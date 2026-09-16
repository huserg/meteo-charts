# Package A — Foundations

Date: 2026-09-16
Repository: `meteo-charts`
Roadmap: `2026-09-16-datasense-roadmap.md`

## Goal

Put a safety net under the application before package B rewrites the ingestion path:
a modern skeleton to build on, a test environment that does not touch the real database,
characterization tests that pin today's behaviour, and CI that runs them.

## Scope

A changes no behaviour, with a single deliberate exception: the null dereference on an
unknown MAC address (A4). Everything else is structure, tests and tooling.

Out of scope, by package: schema and indexes, device authentication (B); aggregation and
retention (C); UI (F); README and full documentation (G).

## A1 — Laravel 12 skeleton

The repository runs Laravel 12 dependencies on the Laravel 10 skeleton. Every file involved
is stock, so the migration is mechanical.

**Delete** (all identical to framework defaults, verified file by file):

- `app/Http/Kernel.php`, `app/Console/Kernel.php`, `app/Exceptions/Handler.php`
- `app/Http/Middleware/`: `Authenticate`, `EncryptCookies`, `PreventRequestsDuringMaintenance`,
  `RedirectIfAuthenticated`, `TrimStrings`, `TrustHosts`, `TrustProxies`, `VerifyCsrfToken`
- `app/Providers/`: `AuthServiceProvider`, `EventServiceProvider`, `BroadcastServiceProvider`
  (already commented out of `config/app.php`), `RouteServiceProvider`
- `tests/CreatesApplication.php`

**Create**: `bootstrap/app.php` in `Application::configure()` style, wiring `routes/web.php`,
`routes/api.php` under the `api` prefix, and `routes/console.php`.
`bootstrap/providers.php` lists `AppServiceProvider`. Remove the `providers` array from
`config/app.php`.

Broadcasting is **not** wired. `BroadcastServiceProvider` is commented out of
`config/app.php` today, so `routes/channels.php` is never loaded and `Broadcast::routes()`
never runs. Calling `withBroadcasting()` would add behaviour, which A must not do.
`routes/channels.php` stays on disk, unused, exactly as it is now.

**Preserve explicitly.** These disappear silently otherwise:

1. `throttle:api`. Laravel 11+ does not rate limit the `api` group by default; it needs
   `$middleware->throttleApi()`. Without it the ingestion endpoints lose their limiter.
   The named limiter itself (`RateLimiter::for('api', …)`, 60/min keyed by user id or IP)
   moves from `RouteServiceProvider` to `AppServiceProvider::boot()`.
2. `RouteServiceProvider::HOME` (`/dashboard`), consumed by `RedirectIfAuthenticated` and the
   Breeze controllers. Usages move to `route('dashboard')`.
3. `Paginator::defaultView('vendor.pagination.tailwind')` stays in `AppServiceProvider::boot()`.

**Verify with a test, do not assume**: `EventServiceProvider` currently binds
`Registered` to `SendEmailVerificationNotification`. Whether Laravel 12 registers that
listener on its own must be proven by the existing Breeze `EmailVerificationTest` and
`RegistrationTest`, not reasoned about. If it does not, the binding is re-declared in
`AppServiceProvider`.

**Acceptance**: `php artisan route:list --json` produces byte-identical output before and
after, and the Breeze test suite passes unchanged.

`ConvertEmptyStringsToNull` remains a Laravel 12 default, so the accidental behaviour
described in the roadmap survives this migration. That is intended — B removes the
dependency on it.

## A2 — Test and development environment

`phpunit.xml` has two defects: the SQLite lines are commented out, so tests run against the
database configured in `.env`, and `processUncoveredFiles` was removed in PHPUnit 10 while
the project is on PHPUnit 11.

- Rewrite `phpunit.xml` to the PHPUnit 11 schema, with `DB_CONNECTION=sqlite` and
  `DB_DATABASE=:memory:`.
- Add `docker-compose.yml` providing MySQL 8 for local development. No system database.
- Update `.env.example`: container database values, and mailpit on port 1025 instead of the
  stale `mailhog` host.

## A3 — Characterization tests

These pin the behaviour B will deliberately change, so the change can be measured rather
than hoped for. Each one asserts what the code does **today**, including where that is wrong.

`POST /api/devices/sensors`:

- empty payload → code 9
- no `mac` field → code 10
- unknown MAC → currently a 500 (see A4)
- known device with no stored token → code 50 with `register_token`, **and no reading stored**
- empty token string → token rotation, via `ConvertEmptyStringsToNull`
- matching token → code 0, and one row created per provided sensor value
- mismatched token → code 12

`POST /api/devices/logs`: the same authentication cases, plus malformed JSON → code 13, and
the dead second `mac_missing` check at `LogsController.php:39-44`.

`BatteryLevel::convertToPercent`: the 2.5 V and 4.2 V bounds, the 0-100 clamp, and rounding.
A test that survives replacing the clamp with a passthrough, or shifting the floor from 2.5 V
to 3.0 V, is not testing anything.

`Device` global scope: one user cannot see another user's devices, and the API removes the
scope on purpose.

Charts: the period mapping in `GraphController::PERIODS` and the custom date range branch.

**Missing factories** to write: `Temperature`, `Humidity`, `Pressure`, `BatteryLevel`, `Log`,
`LogEntry`. Only `Device` and `User` exist.

## A4 — Unknown MAC crash

`SensorsController::raw_status` assigns `$device->last_sync` at line 37, immediately after
`->first()`, while its `!isset($device)` guard sits at line 60 — unreachable. Any POST with
an unknown MAC returns a 500 on an unauthenticated endpoint. `LogsController` guards before
use, which shows this is an oversight rather than a choice.

Fix: move the guard before the first dereference. The A3 test for an unknown MAC changes from
asserting a 500 to asserting code 11, in the same commit.

## A5 — CI and code quality

- Add `laravel/pint` and `larastan/larastan` to `require-dev`, with `pint.json` on the Laravel
  preset and `phpstan.neon` at level 5, no baseline.
- `.github/workflows/ci.yml`:
  - job `tests`: PHP 8.2, `composer install`, `php artisan test` on SQLite
  - job `tests-mysql`: the same suite against a MySQL 8 service container
  - job `quality`: `pint --test`, `phpstan analyse`
  - job `assets`: `bun install`, `bun run build`, to catch Vite breakage
- Fix whatever level 5 reports in application code; no baseline file is created.

## A6 — Housekeeping

- `CLAUDE.md` states Laravel 10, npm and `./vendor/bin/phpunit`. After A those are wrong and
  actively misleading. Correct the stale facts only; the full rewrite belongs to G.
- Create `CHANGELOG.md`. Tags already exist (`23w50a`, `v1.0`, `v1.0.1`); the changelog starts
  from the current state and records A onwards.

## Definition of done

- `route:list` diff is empty, and the Breeze suite passes
- `php artisan test` runs on in-memory SQLite and touches no real database
- Every case in A3 is covered by a passing test
- An unknown MAC returns code 11, proven by a test that failed before the fix
- CI is green on all four jobs
- PHPStan level 5 passes with no baseline

## Risks

- **SQLite and MySQL divergence.** The schema uses `float` columns and `foreignId` without
  `constrained()`. The MySQL CI job exists precisely to catch what SQLite tolerates.
- **Characterization tests encode bugs.** That is their purpose here, and it is a liability if
  it is forgotten: each such test carries a comment naming the package that will change it.

## Next

Package B, which consumes this net: device authentication, schema and indexes, one request
per measurement, and the firmware's protocol half.

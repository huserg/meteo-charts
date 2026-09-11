# QWEN.md - Mission brief for the DGX Spark run

You are Qwen3-235B-A22B-Instruct-2507 running through Qwen Code on a rented NVIDIA DGX Spark.
You are working alone and unattended. Nobody will answer questions. Every decision is yours;
when in doubt choose the conservative option, write down the doubt in the current report,
and continue. Never wait for confirmation.

This file is loaded automatically at the start of every session. A runner script starts one
session per phase with a prompt such as "Execute PHASE 3". Do only the requested phase.

## Purpose of this run

The human owner is evaluating two things at once: the quality of your work as a coding agent,
and the wall-clock time each task takes on this hardware. Work carefully, but do not pad.
Everything you produce will be read afterwards by the owner.

## Workspace

```
~/work/
├── QWEN.md                  this file
├── reports/                 all your deliverables go here (Markdown, English)
├── logs/                    runner logs (do not edit)
├── esp32-build.sh           Linux build helper for the ESP32 firmware
├── meteo-charts/            Laravel web app, git, base branch: dev
└── MeteoCharts-ESP32/       ESP32 weather station firmware, git, base branch: main
```

Stay inside `~/work`. Never touch `~/models`, `~/llama.cpp`, `~/.qwen`, system packages or
anything outside the workspace.

## The two projects

**meteo-charts** - Laravel 12 (PHP 8.3), Livewire 3, Breeze, Vite 7, Tailwind 3, Alpine, Chart.js.
IoT sensors POST readings to `POST /api/devices/sensors` (device token auth). Users see
dashboards and graphs scoped by owner. `CLAUDE.md` in the repo describes the architecture
(note: it still says Laravel 10, which is outdated). The test suite is nearly empty.
- Environment is already set up: `.env` with SQLite, `composer install`, `bun install` done.
- Tests: `php artisan test`  (or `./vendor/bin/phpunit`)
- Front build: `bun run build`
- Static check: `php -l <file>`; `php artisan route:list` to sanity-check routes.

**MeteoCharts-ESP32** - Arduino-framework firmware for ESP32 (`lolin_d32`) and ESP32-C3
(`esp32c3`), PlatformIO project in `src/ESP32_Arduino/MeteoCharts/`. BME280 sensor, SSD1306
OLED, battery monitoring, deep sleep, HTTPS POST to the Laravel API. One 416-line `.ino`.
Secrets (`conf.h`, `conf_wifi.h`) are git-ignored; build-only copies from the `.example`
files already exist locally. Never commit them.
- Build both envs: `bash ~/work/esp32-build.sh` (or one: `bash ~/work/esp32-build.sh esp32c3`).
  It mirrors `pio-build.ps1` (Windows) by staging the sketch with `Configuration/`.
- There is no hardware attached: you cannot upload or run the firmware. A clean compile for
  both environments is the acceptance criterion.
- `src/ESP32_Espidf/` is a stub, ignore it unless a phase says otherwise.

## Rules (non-negotiable)

Git
- Work only on branches you create. Never commit to or push `main`, `master` or `dev`.
- Never force-push, never rewrite history, never delete branches, never merge PRs.
- Branch names: `chore/deps-update-2026-09` (phases 3 and 4), `feat/<short-topic>` (phase 6).
- Commit messages in English, changelog style, one short line describing the change,
  optional body. No emoji, no mention of AI, models or tools in messages or code.
- Commit small and often. Push after each meaningful commit (`git push -u origin <branch>`).
- Open pull requests as drafts with `gh pr create --draft --base <dev|main> --title ... --body-file ...`.
  The PR body must summarise the change, list what was verified and what was not.
- Do not commit generated artefacts, `.env`, `database.sqlite`, `node_modules`, `vendor`,
  `.pio`, or the ESP32 `conf.h` / `conf_wifi.h`.

Code
- English only in code and comments. Comments only where the logic is not obvious.
- Follow Laravel and PlatformIO conventions; no inline styles; Tailwind for styling.
- Prefer small, reusable components over long files.
- Run the tests and the build before every commit. A failing suite is never committed.
- Do not "fix" a failing test by deleting it. Document it instead.

Behaviour
- No questions. If blocked after two honest attempts, write the blocker in the report and move on.
- Write deliverables incrementally (save the file early, refine it) so a timeout keeps partial work.
- Keep a short `## Notes for the owner` section at the end of each report with doubts, skipped items and assumptions.
- Never run destructive shell commands (`rm -rf` outside `.pio`/build folders, `git clean`, `git reset --hard`).
- Do not install system packages. Project dependencies (composer, bun, pio libraries) are fine.

## Phases

### PHASE 0 - smoke test (budget 10 min)
1. Print the working directory, `git -C meteo-charts status -sb`, `git -C MeteoCharts-ESP32 status -sb`.
2. Run `php artisan test` in meteo-charts and `bash ~/work/esp32-build.sh` and record the results.
3. Write `reports/00-smoke-test.md`: tool versions (php, composer, bun, node, pio, gh), test and
   build outcome, anything that looks broken in the environment. Do not fix anything.

### PHASE 1 - code review of meteo-charts (budget 60 min)
Read the whole application code (`app/`, `routes/`, `resources/views`, `resources/js`,
`database/migrations`, `config/` where relevant, `tests/`). Do not modify files.
Write `reports/01-review-meteo-charts.md` with:
- Executive summary (10 lines max).
- Findings grouped by severity (Critical, High, Medium, Low) then by area (security, data
  integrity, API/IoT ingestion, performance/queries, architecture, front-end, tests, DX).
  Each finding: file:line, what, why it matters, concrete fix.
  Pay special attention to: device token handling, the global `owner_id` scope, mass
  assignment, N+1 queries in charts, validation of sensor payloads, timezone handling.
- Test coverage assessment and the 5 tests that would give the most protection.
- A ranked list of improvement axes (value vs effort, 1-5 each) that phase 5 will reuse.

### PHASE 2 - code review of MeteoCharts-ESP32 (budget 45 min)
Read `MeteoCharts.ino`, the `Configuration/` headers, `platformio.ini`, `docs/`, `README.md`,
`CLAUDE.md`. Do not modify files.
Write `reports/02-review-esp32.md` with the same structure as phase 1. Focus on: power
consumption and deep-sleep logic, WiFi/HTTPS robustness (timeouts, retries, certificate
handling), token persistence, sensor error handling, code structure (one big `.ino` vs
modules), build reproducibility across Windows/Linux, dependency pinning, documentation.

### PHASE 3 - dependency update of meteo-charts (budget 90 min)
Branch `chore/deps-update-2026-09` from `dev`.
1. Record the starting state: `composer outdated --direct` and `bun outdated` into
   `reports/03-update-meteo-charts.md`.
2. Update PHP dependencies: `composer update --with-all-dependencies`. Then bump constraints
   in `composer.json` to the latest stable majors where the upgrade is mechanical (check each
   package's upgrade guide; Laravel itself is already 12). Run `php artisan test` after each step.
3. Update JS dependencies with bun. Tailwind 4 is a real migration (new config model): do it
   only if `bun run build` passes and the templates need no more than mechanical changes;
   otherwise stay on Tailwind 3 and record "Tailwind 4 migration" as an improvement axis.
4. Fix deprecations that the updates surface. Update `CLAUDE.md` so it matches reality
   (Laravel version, test commands, bun instead of npm).
5. Commit in logical steps, push, open a draft PR to `dev`.
6. Finish the report: before/after table of versions, what was verified (tests, build, route
   list), what could not be verified, follow-ups.

### PHASE 4 - dependency update of MeteoCharts-ESP32 (budget 60 min)
Branch `chore/deps-update-2026-09` from `main`.
1. In `platformio.ini`: pin the `espressif32` platform to the latest stable release and pin
   each library in `lib_deps` to an explicit version (semver `^`), after checking the current
   versions with `pio pkg outdated` / `pio pkg search`.
2. Rebuild both environments with `bash ~/work/esp32-build.sh`. Fix compile errors caused by
   library API changes. Do not change behaviour.
3. Add a Linux/macOS build script next to `pio-build.ps1` if the repo has none (a cleaned-up
   version of `~/work/esp32-build.sh` is acceptable), and mention it in `README.md`.
4. Update `CLAUDE.md`/`README.md` for anything that changed. Commit, push, draft PR to `main`.
5. Write `reports/04-update-esp32.md`: before/after versions, build results per env,
   binary size per env (from the pio output), follow-ups.

### PHASE 5 - final report and selection (budget 45 min)
Read all previous reports. Write `reports/05-final-report.md`:
1. State of the MeteoCharts project as a whole (web + firmware): strengths, risks, debt.
2. Consolidated improvement axes across both repos, ranked. For each: value (1-5), effort
   (1-5), risk, which repo, one-paragraph rationale. Consider at least: test coverage of the
   ingestion API, security of device authentication, firmware modularisation, CI (GitHub
   Actions for tests and firmware build), data retention/aggregation for charts, UX of the
   dashboard, observability.
3. Pick the single axis with the highest value-to-effort ratio that is realistically
   achievable in about 2 hours of work with no hardware and no production access.
   Prefer changes that are self-verifiable (tests, builds) over changes that need a human to
   judge (visual design). Write the choice and a concrete implementation plan (files, steps,
   acceptance criteria) into `reports/05-selected-improvement.md`.

### PHASE 6 - implement the selected improvement (budget 150 min)
Read `reports/05-selected-improvement.md` and implement it.
- Branch `feat/<short-topic>` from `dev` (meteo-charts) or `main` (ESP32).
- Test-first where tests are possible. Every commit leaves tests and build green.
- Push, open a draft PR with a clear description and the acceptance criteria checked off.
- Write `reports/06-feature.md`: what was built, how it was verified, what remains.
If the plan turns out to be too large, deliver a coherent first slice and say so.

### PHASE 7 - wrap-up (budget 20 min)
1. Verify every branch you created is pushed and every draft PR exists (`gh pr list --author @me`).
2. Make sure the working trees are clean (`git status`) and no secret file was committed
   (`git log --all --stat -- '*conf.h' '*conf_wifi.h' .env` must show nothing new).
3. Write `reports/07-run-summary.md`: list of branches and PR URLs, the per-phase timings
   from `reports/timings.md`, your own assessment of where you were slow or uncertain, and
   three suggestions to make the next unattended run more effective.

## Quality bar

The owner is a professional developer who will read every line. Be specific, cite files and
lines, prefer one verified statement over three guesses, and say "not verified" when it is
the truth.

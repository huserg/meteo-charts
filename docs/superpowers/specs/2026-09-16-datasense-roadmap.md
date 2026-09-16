# DataSense roadmap

Date: 2026-09-16

DataSense is two repositories that share one contract:

- `meteo-charts` — Laravel application, dashboard and ingestion API
- `MeteoCharts-ESP32` — firmware for the sensor stations

This document records how the improvement work is decomposed, in what order, and why.
Each work package gets its own design document and its own implementation plan.

## Goal

A solid base, usable day to day, and presentable. Explicitly not a multi-tenant platform:
the application stays single-owner with per-user device scoping.

## Constraint

No production devices and no data to preserve. The ingestion protocol can be redesigned
rather than patched.

## The problem that frames everything

The firmware keeps its device token in a plain global (`MeteoCharts.ino:18`) and then calls
`esp_deep_sleep()` (`:92`). Deep sleep clears RAM and restarts from `setup()`, so every wake
cycle sends an empty token. This only works because `ConvertEmptyStringsToNull` turns `""`
into `null`, which drops the server into its `fresh_token` branch: it issues a new token,
answers code 50, and the device calls `WebRequest()` recursively to finally send its reading.

Consequences: every measurement costs two HTTP requests, the token rotates on every cycle,
and the token authenticates nothing — knowing a MAC address and sending an empty token is
enough to obtain a valid one. The null dereference on an unknown MAC
(`SensorsController.php:37`, guarded only at `:60`) is a symptom of the same unfinished design.

## Work packages

| # | Package | Repos | Depends on |
|---|---|---|---|
| A | Foundations: Laravel 12 skeleton, test environment, characterization tests, CI, static analysis | meteo-charts | — |
| B | Ingestion contract: device authentication, schema and indexes, one request per measurement, validation | both | A |
| C | Data lifecycle: hourly and daily rollups, raw data retention, downsampled chart queries | meteo-charts | B |
| D | Device health and alerts: device metadata, silence detection, notification channel | meteo-charts | B, C |
| E | Firmware rework: module split, compile-time display option, retry and offline buffer, OTA | MeteoCharts-ESP32 | B |
| F | UI rework: dashboard, charts, visual identity | meteo-charts | C, D |
| G | Documentation and deployment: README, CLAUDE.md, device API reference, reproducible deploy | both | all |

B is the load-bearing package: it changes the protocol the firmware speaks, so it touches
both repositories at once.

## Sequencing

A to G in order, with one deliberate split: the **protocol half of the firmware work
(token persistence in NVS, new authentication scheme) belongs to B**, not E. The device is
therefore never left speaking a protocol the server no longer accepts, and E becomes
embedded comfort work with no urgency.

A produces no visible feature. That is accepted: B is surgery on the critical path, and this
is the only order where it can be done with a safety net.

Rejected alternatives:

- **Usage value first** (bugs, then health and alerts, then the rest). Faster payoff, but
  health and alerts would be built on a `last_sync` fed by an ingestion path that rotates
  tokens and drops readings, and would be rewritten once B landed.
- **One repository at a time.** Fewer context switches, but it would freeze the server-side
  protocol before knowing what the device can honour (NVS, energy budget, buffer size).

## Decisions taken

- Tests run on in-memory SQLite locally; CI runs the suite a second time against MySQL 8 to
  catch divergences that matter once C writes aggregation SQL.
- PHPStan starts at level 5 with no baseline, and rises as packages land.
- Work is committed directly on the `dev` branch.

## Status

- A: designed, see `2026-09-16-fondations-design.md`
- B to G: not designed yet

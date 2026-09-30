# CSRF execution record

Assigned member: Muditha IT24610813

Captured: 2026-09-29T20:55:52.224Z (UTC; 30 September 2026 in Sri Lanka).

A tokenless form served from 127.0.0.1:8090 inserted a unique GROUP-CSRF entry on the baseline (HTTP 200). The final handler returned HTTP 403 and the unique row was absent on a subsequent read. A legitimate form still persisted. The browser condition was same-site, different-origin with SameSite=Lax; this is not a universal cross-site-cookie claim. Invalid and cross-session token unit tests passed.

These are actual Codex-assisted local runs. The after screenshots show the cumulative final application, not a claim that the student's GitHub branch has already been tested. Baseline: pinned upstream vulnerable handlers with disclosed configuration/seed adaptations, port 8081. Final: port 8080, separate database. Release tag 2.12.7 displays version 2.12.6. Browser requests to non-loopback hosts were blocked. Students must independently repeat and explain their own stage, then record their actual PR, review and test evidence.

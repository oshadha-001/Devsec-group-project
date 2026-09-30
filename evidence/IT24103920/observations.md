# SQL injection execution record

Assigned member: Oshadha IT24103920

Captured: 2026-09-29T20:55:52.224Z (UTC; 30 September 2026 in Sri Lanka).

Authenticated jeremy lookup used password input `' OR 1=1 -- ` (trailing space). Baseline returned 40 records; final returned zero. A valid synthetic credential pair returned one in each deployment. Passwords and client secrets are masked in screenshots. SQL parameter-binding unit tests passed.

These are actual Codex-assisted local runs. The after screenshots show the cumulative final application, not a claim that the student's GitHub branch has already been tested. Baseline: pinned upstream vulnerable handlers with disclosed configuration/seed adaptations, port 8081. Final: port 8080, separate database. Release tag 2.12.7 displays version 2.12.6. Browser requests to non-loopback hosts were blocked. Students must independently repeat and explain their own stage, then record their actual PR, review and test evidence.

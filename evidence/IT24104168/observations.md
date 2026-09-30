# Command injection execution record

Assigned member: Minura IT24104168

Captured: 2026-09-29T20:55:52.224Z (UTC; 30 September 2026 in Sri Lanka).

DNS input `127.0.0.1; printf GROUP-CMD-PROOF` produced the marker in the baseline command-output element. The final handler rejected it and produced no executed marker. Reflection in a heading was not counted as execution. Localhost resolution and the IP/input-validation unit tests passed.

These are actual Codex-assisted local runs. The after screenshots show the cumulative final application, not a claim that the student's GitHub branch has already been tested. Baseline: pinned upstream vulnerable handlers with disclosed configuration/seed adaptations, port 8081. Final: port 8080, separate database. Release tag 2.12.7 displays version 2.12.6. Browser requests to non-loopback hosts were blocked. Students must independently repeat and explain their own stage, then record their actual PR, review and test evidence.

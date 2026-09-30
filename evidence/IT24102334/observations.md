# Stored XSS execution record

Assigned member: Pathum IT24102334

Captured: 2026-09-29T20:55:52.224Z (UTC; 30 September 2026 in Sri Lanka).

The stored script `<script>document.body.insertAdjacentHTML("afterbegin","<h1>GROUP-XSS-PROOF</h1>")</script>` created a visible heading before the fix. In the final application it was displayed literally and created no heading. The payload was stored through the normal authenticated form.

These are actual Codex-assisted local runs. The after screenshots show the cumulative final application, not a claim that the student's GitHub branch has already been tested. Baseline: pinned upstream vulnerable handlers with disclosed configuration/seed adaptations, port 8081. Final: port 8080, separate database. Release tag 2.12.7 displays version 2.12.6. Browser requests to non-loopback hosts were blocked. Students must independently repeat and explain their own stage, then record their actual PR, review and test evidence.

# Verified local result and remaining submission work

Date: 30 September 2026 (Sri Lanka). Browser run: 2026-09-29T20:55:52.224Z UTC.

- Two Docker deployments started successfully: baseline 127.0.0.1:8081 and final 127.0.0.1:8080, separate MySQL volumes. MySQL has no published host port.
- All 15 browser assertions passed. Four malicious inputs reproduced their selected baseline weaknesses and were blocked in the final cumulative source. Legitimate account lookup, blog submission and localhost resolution passed.
- PHP syntax and three focused unit suites passed. A pre-existing DirectoryIterationHandler return-type deprecation notice remains; it is not a syntax failure.
- Semgrep 1.112.0, same four targeted rules: baseline 4 findings and exit 1; final 0 findings and exit 0; no scanner errors. This is bounded SAST coverage, not whole-application assurance.
- Gitleaks 8.24.2 source-directory scan: zero findings. The actual future submission history is not yet scanned.
- Trivy 0.60.0 vendored dependency scan: 2 high findings for jQuery 1.8.3; exit 1. Inventory identifies four components, but registry mapping is verified for only two jQuery copies. Unknown/missing versions remain coverage gaps.
- Trivy final web image: 310 high and 20 critical package findings; exit 1.
- Trivy MySQL image: 37 high and 1 critical package findings; exit 1. Package findings may repeat one advisory across packages; these are not unique exploit counts.
- Four primary screenshot pairs (eight images: four before and four after), plus additional runtime/CSRF images and machine-readable results are supplied. Password/client-secret fields were masked before SQL screenshots were saved.
- Browser requests to non-loopback hosts were blocked. A full host-offline and clean-clone test remains for the group; first image/build/scanner downloads need connectivity or prepared caches.

The normal security pipeline is NOT verified green: inherited dependency/image findings remain. Gates intentionally reject HIGH/CRITICAL findings. Do not conceal them. The local SAST baseline proved a blocked command; no hosted GitHub result has been invented.

Manual group actions still required: submit four real reviewed PRs in order, provision LAB_DB_PASSWORD in Actions secrets, run and capture actual hosted workflows, test the merged revision, record actual human contributions, sign declarations and attach the already-submitted signed ethical-clearance copy. The signed file was not available to include. No commits, pushes, PRs, student signatures or messages were made on behalf of group members.

Full report: docs/Mutillidae_II_Group_Report.docx and .pdf. Scanner JSON files and image identities are under evidence/local-verification. Local demonstrations used only synthetic data and the user's authorized Mutillidae environment.

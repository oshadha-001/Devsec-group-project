# Application threats and risk assessment

Likelihood and impact are scored 1 low, 2 moderate, 3 high. Ratings are qualitative, justified below; they are not measured incident probabilities.

| Threat | STRIDE | L | I | Risk | Reason and specific control |
|---|---|---|---|---|---|
| Account lookup SQL injection | Tampering / information disclosure | 3 | 3 | 9 | Authenticated lookup fields reach a concatenated query; bound parameters in SQLQueryHandler::getUserAccount separate syntax and values. |
| Stored blog script execution | Tampering / elevation | 3 | 3 | 9 | Blog content persists and is rendered to later readers; HTML encoding in view-someones-blog.php treats markup as text. |
| DNS lookup command injection | Elevation / tampering | 3 | 3 | 9 | Shell command receives a submitted hostname; member 3 replaces shell execution with validated PHP address resolution. |
| Forged blog submission | Spoofing / tampering | 2 | 2 | 4 | Victim session can authorize a forged request; member 4 adds a session-bound unpredictable token and denies missing/invalid tokens. Browser cookie policy affects reproduction and must be recorded. |
| Credential exposure | Information disclosure | 2 | 3 | 6 | Tracked defaults, logs and web files can expose credentials; runtime files replace live defaults, exports are disabled and Gitleaks scans history. |
| Vulnerable dependencies | Tampering / elevation | 2 | 3 | 6 | PHP/browser libraries and base images carry inherited risk; dependency inventory and Trivy gates expose findings requiring remediation. |

Controls assigned to later member stages are planned until those patches are merged. Residual risks include other intentionally vulnerable lessons, plaintext application passwords, broader authentication/authorization defects, missing comprehensive auditing and incomplete CSRF coverage outside blog submission. Four fixes do not make the whole teaching app production-safe.

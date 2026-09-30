## 1 Executive summary

This project demonstrates four source-level security improvements to OWASP Mutillidae II for the IE3142 group assessment. The selected application is an intentionally vulnerable teaching system. The implementation addresses SQL injection in account lookup, stored cross-site scripting in blog display, operating-system command injection in DNS lookup, and cross-site request forgery in blog submission. These changes run in a two-component PHP and MySQL deployment. The remaining teaching exercises are outside the remediation scope and retain known weaknesses.

Local validation reproduced all four selected attacks against the vulnerable handlers and replayed identical inputs against the corrected application. SQL injection returned 40 accounts before correction and zero afterward. Stored script content stopped executing, injected command output disappeared, and a tokenless blog request changed from a successful insertion to HTTP 403 with no inserted entry. Legitimate account lookup, blog submission and hostname lookup continued working. All 15 recorded browser checks and the three focused PHP test suites passed.

The delivery contains a common foundation and four sequential member packages. The assigned owners are Oshadha, Pathum, Minura and Muditha. Code preparation, local testing and report drafting were assisted by Codex; these activities do not establish completed student contributions. Each member must independently review and understand their patch, record their actual work and submit their own pull request. Hosted GitHub evidence and signed documents remain group responsibilities. Wider dependency and image findings are reported openly rather than treated as resolved by the four fixes.

## 2 System architecture and reproducibility

The source is pinned to upstream release tag 2.12.7, commit 3df16679355f393f0488ad5ca1b7020141f52580 [1]. Its application banner and version file identify 2.12.6; both identifiers are retained to make the screenshots traceable. The GPL licence and upstream component notices accompany the source. The comparison deployment preserves the four vulnerable handlers, but shares documented configuration and seed adaptations. It is therefore an adapted baseline, not a byte-for-byte untouched upstream deployment.

Apache and PHP 8.2 serve the application, while MySQL 8.4 stores synthetic users and blog entries. A short-lived seed service initializes the original schema and synthetic records. Health checks ensure the database becomes available before initialization and the web service starts afterward. Persistent database storage survives ordinary restarts. The final browser endpoint is restricted to 127.0.0.1:8080; the separate baseline uses port 8081 and its own volume. MySQL exposes no host port and communicates over an internal Docker network.

Browser requests cross a trust boundary into PHP, and database operations cross another boundary into MySQL. Runtime secret files enter only the services that need them. Container isolation reduces accidental exposure but does not remove application vulnerabilities. The browser test runner denied requests to non-loopback hosts, demonstrating the selected local exercises without third-party browser services. A complete network-disconnected host test was not performed. Images, scanner databases and build dependencies require initial downloads or prepared caches before an offline demonstration.

## 3 Threat model and priorities

The assessment uses STRIDE categories and a qualitative likelihood-times-impact score. Both factors range from one to three; the score prioritizes this teaching deployment rather than estimating real incident probability. Account lookup receives a high likelihood because a signed-in user directly supplies the query input. Persisted blog content reaches later readers, making stored script execution similarly accessible. DNS input originally crossed directly into a shell. CSRF likelihood is lower because exploitation depends on an authenticated browser and its cookie policy.

The threat matrix maps six concrete threats to implemented or proposed controls. Each selected route is tested at security level zero so the protections cannot be bypassed merely by switching the demonstration setting. Residual risks remain material: other SQL queries, output paths and state-changing operations are intentionally vulnerable; synthetic passwords remain plaintext in the application database; and bundled libraries have incomplete version identification. Stronger authorization, password hashing, restricted database privileges and comprehensive auditing are subsequent work, not claims of this submission.

## 4 Vulnerability analysis and remediation

### 4 1 Oshadha IT24103920 SQL injection

The account lookup built a SQL string containing user-controlled credentials. An authenticated synthetic user submitted username jeremy and the password payload shown in Appendix A. The quote and Boolean expression changed the WHERE condition, causing 40 account records to be returned. Credentials visible in that response were masked before the screenshot was saved. This demonstrates information disclosure through a query boundary failure, classified as CWE-89.

The corrected SQLQueryHandler::getUserAccount method uses two placeholders and passes the values separately to a mysqli prepared statement through MySQLHandler::executePrepared. It also rejects non-string or oversized inputs. This follows the separation of query structure and data described by OWASP [2]. The identical malicious password then returned zero records, while the real synthetic user's credentials still returned one record. A query-recorder unit test verifies binding and malformed-input handling; the browser test supplies the complementary live-database evidence. The fix is confined to this method and does not certify every query in Mutillidae.

### 4 2 Pathum IT24102334 Stored cross site scripting

The blog viewer rendered stored author and comment fields into HTML. A harmless script inserted a visible GROUP-XSS-PROOF heading into the page, proving browser execution after storage and retrieval. It neither collected cookies nor contacted an external server. The failure is CWE-79: application data was interpreted as active markup in another user's browser context.

The patch applies htmlspecialchars with ENT_QUOTES, ENT_SUBSTITUTE and UTF-8 to the blog author, date, comment and author-selection output. The protection applies independently of the demonstration security level. A small set of trusted formatting tokens remains explicitly controlled by the page. Retesting the same stored script produced visible literal script text and no injected heading. Ordinary blog content remained readable. This result supports HTML-context encoding at the selected output locations; JavaScript, URL or CSS contexts elsewhere would require their own context-appropriate controls and separate tests.

### 4 3 Minura IT24104168 Command injection

The original DNS lookup passed a submitted hostname into an operating-system command. The input 127.0.0.1; printf GROUP-CMD-PROOF caused the marker to appear inside command output. The proof checks that output region, because reflection of the input in the page heading alone would not demonstrate command execution. This is CWE-78 and could allow operations with the web process's privileges.

The replacement GroupDns helper validates a bounded hostname or literal IP address and performs address resolution through PHP. It never constructs or invokes a shell command. Invalid input receives a generic error and HTTP 400 rather than a diagnostic stack trace. The same command payload produced no execution marker after correction, and a localhost lookup succeeded. Focused tests cover IPv4, IPv6, localhost, shell metacharacters, oversized input and non-string values. The DNS exercise now provides address resolution rather than every feature of the original command-line utility; this is an intentional functional tradeoff that removes the dangerous boundary.

### 4 4 Muditha IT24610813 Cross site request forgery

At security level zero the original blog token handler accepted submissions without validating a token. The test logged in as jeremy and submitted a form from 127.0.0.1:8090 to the application. The baseline inserted a uniquely marked blog entry and returned HTTP 200. Both endpoints are the same site but different origins, with SameSite=Lax cookies. This proves the recorded browser condition; it does not assert that every unrelated external site can send the session cookie.

GroupCsrf generates a random 32-byte session token and validates the submitted POST value using hash_equals. Authentication and token validation occur before insertion, independently of the lab setting [3]. Missing, malformed and cross-session tokens fail. Output buffering permits the included handler to send an actual HTTP 403 response after template processing begins. The identical tokenless form then returned 403 and the unique entry was absent from the stored blog list. A valid form submission still persisted. Token lifecycle tests also verify stability within a session and rejection after switching sessions. Other state-changing routes remain outside this patch.

## 5 Security pipeline and measured results

The prepared GitHub workflow separates PHP validation, SAST, software composition analysis, secret scanning and image scanning. A final job succeeds only when all required jobs succeed. Reports are uploaded even when a security job fails. The targeted Semgrep rules inspect the four selected anti-patterns; they are deliberately bounded and cannot establish whole-application security. Using Semgrep 1.112.0 and the same rules, the baseline produced four findings and the final source produced zero, with no scanner errors. Enforcing the error option returned exit code one before correction and zero afterward [4].

Gitleaks 8.24.2 found no leaks in the final source-directory scan after static signing keys and token examples were removed or replaced. The hosted workflow requests full Git history, which must be checked after real commits exist. A directory result cannot substitute for history analysis. Source examples, generated credentials and screenshot content must also be reviewed before publication.

The application vendors old libraries without a Composer lockfile. A generated CycloneDX inventory records observed version banners and file hashes: two jQuery copies, Colorbox and NuSOAP. Only the two jQuery entries have verified package identities for the dependency scan. JWT, Gritter and menu code remain unresolved inventory coverage. The SCA gate scans the identified packages and rejects high or critical findings; an incomplete inventory is not an empty vulnerability list. Trivy 0.60.0 also scans both application and database images [5]. Appendix B reports the actual measured counts and outcomes, including failed gates.

The local Semgrep comparison demonstrates a working blocking command. It is not a hosted pipeline screenshot. A separate manual GitHub demonstration temporarily adds a detectable shell sink to the runner workspace so the SAST job fails; it does not commit or publish that source. The group must run it, retain the run URL and capture genuine Actions evidence. Stage three can remain red while the later CSRF patch is pending. Existing dependency and image findings also prevent a truthful claim that every gate is green.

## 6 Secrets management

The initializer generates cryptographically random local credentials in ignored .secrets files. Compose mounts the application database password and signing key into the web service; root and seed-user credentials have narrower service assignments. Web database reset and credential export files are disabled. These changes remove live defaults from tracked source, but do not introduce password hashing into the original application schema.

The manual runtime workflow requires an encrypted Actions secret named LAB_DB_PASSWORD, containing 64 lowercase hexadecimal characters. The initializer consumes it without printing its value, and generates other credentials on the runner. Fork pull requests receive no such secret. GitHub distinguishes stored secret configuration from values passed to a job [6]. Replacing a local file does not rotate a password already stored in MySQL; rotation needs a deliberate account update. Screenshots must reveal secret names only, never values or session cookies.

## 7 Industry practice and case study

NIST's Secure Software Development Framework 1.1 describes integrating security practices into a development lifecycle [7]. Here that principle is expressed through small reviewable changes, automated checks, retained evidence and explicit residual-risk tracking. The four packages make it possible to connect one finding to a control, test and reviewer, provided students record genuine contributions.

The December 2021 Log4j response illustrates why source fixes alone are insufficient. CISA and international partners issued coordinated mitigation guidance for vulnerabilities in a widely reused logging component [8]. This project does not claim to use Log4j. The relevant lesson is dependency visibility: copied libraries can be hard to identify and missed by a package-manager-only scan. Recording version banners, hashes and inventory gaps makes that limitation visible. Ongoing component updates and repeated scans are still necessary because new advisories can affect previously accepted versions.

## 8 Reflection and submission readiness

The strongest outcome is reproducible evidence for the four selected route fixes. The investigation also exposed practical issues: a rejected mutation initially returned the wrong HTTP status, repeated demonstration data cluttered screenshots, and generic dependency discovery did not adequately identify vendored code. Checking persisted state, exact response status and source version banners improved the result beyond a screenshot-only demonstration.

The next priorities are validating unknown libraries, upgrading inherited components, extending controls to related routes and verifying startup on a clean offline demonstration machine. Students must complete their real GitHub reviews and Actions runs, reconcile contribution claims, and sign the statements. One group submission must list all members and roles and include the actual signed ethical-clearance form. The user confirmed clearance was submitted for local testing; the signed file was not available for this package. It must be attached before Courseweb submission. No signature, PR URL or hosted run has been invented.

# Original and fixed comparison

Download the exact upstream commit in UPSTREAM.md into a separate directory outside the submission Git history. The authoring workspace contains the original archive under tmp/mutillidae-source/2.12.7.zip. Do not upload that archive or its demo credential dumps to the submission repo.

The foundation package preserves the four vulnerable code paths while changing deployment and credential provisioning. Its modifications are listed in UPSTREAM.md. Capture original-source hashes for SQLQueryHandler.php, view-someones-blog.php, dns-lookup.php and CSRFTokenHandler.php before applying any member package. The SQLQueryHandler and three page/class files match their upstream content apart from normalized line endings at this stage. The database connection adapter differs and must be disclosed.

For strict unmodified-app evidence, use a separate upstream deployment with deployment-only DB configuration overrides and synthetic data. Keep a separate Compose project name, loopback port and database volume. Never use the public Mutillidae demonstration website. Record the runtime wrappers and their differences. Reproduce every selected exploit before its member fix is applied.

If using the shared foundation as the comparison, describe it precisely as upstream vulnerable handlers in an isolated deployment with seed/configuration changes. Do not call every byte of that deployment unmodified. Save the original archive as the provenance source.

# Vendored dependency coverage

There is no upstream Composer lockfile. scripts/vendor-inventory.py reads version banners in the actual vendored files and produces a CycloneDX SBOM with SHA256 hashes. It records both jQuery versions, Colorbox and NuSOAP; only jQuery has a verified npm package identity in this inventory. Unversioned JWT, Gritter and DHTML menu libraries are listed as unresolved coverage, not invented package versions. Trivy scans the identified SBOM packages and fails on HIGH or CRITICAL vulnerabilities. Review reports/vendor-coverage.json alongside the findings; a successful scan is not proof of complete dependency coverage. Other libraries may be present.

Upgrade or replace the legacy libraries in a separately tested follow-up. This project's four route fixes do not remediate the complete upstream dependency tree. Image scanning covers operating-system packages separately.

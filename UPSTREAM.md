# Source and changes

Source: https://github.com/webpwnized/mutillidae
Release tag: 2.12.7 (the source and application UI display 2.12.6)
Commit: 3df16679355f393f0488ad5ca1b7020141f52580
Archive SHA256: 497bc899024e063bf13b26a06b19e403a142d811d62e3a04355e406fd0a93360
Licence: GNU GPL version 3; see LICENSE. Upstream component notices remain in source.

The inspected main branch had a malformed CSRFTokenHandler method; the released commit above preserves a valid original comparison. It was selected explicitly, not described as the newest release.

Foundation changes: Docker wrappers, runtime database credentials and JWT signing key, removal of password fallback guesses and credential-bearing connection errors, generated synthetic seed passwords, disabled web database reset and plaintext credential exports. Static example JWTs and a browser demo token were removed or generated at runtime. Credential dump files are not copied. LDAP is outside this two-component project. Full secret scanning remains required.

The four targeted source patches are applied separately. Existing unmodified lessons retain intentional weaknesses. No claim of comprehensive application hardening is made.

# Mutillidae II group DevSecOps project

IE3142 | Oshadha IT24103920, Pathum IT24102334, Minura IT24104168, Muditha IT24610813

Repository: https://github.com/oshadha-001/Devsec-group-project

This is a local educational remediation of the attributed Mutillidae II 2.12.7 application. It is intentionally vulnerable outside the four selected fixes. Do not expose it publicly. Preparation and actual verification are recorded separately in evidence/STATUS.md.

## Start the lab
Install Git and Docker Desktop using Linux containers. In PowerShell at this repository root:

```powershell
powershell -File scripts/Initialize-Secrets.ps1
docker compose up --build -d --wait web
```

Open http://127.0.0.1:8080/index.php. Lab users are `admin` and `jeremy`; read their generated passwords privately from `.secrets/admin_password.txt` and `.secrets/user_password.txt`. Do not put credentials in screenshots. Docker supplies MySQL; no host database installation is needed. The database port is not published. First startup requires internet to obtain images and system packages. Normal startup reuses the synthetic database. Stop with `docker compose down`; retain the volume unless intentionally resetting this lab.

The original upstream comparison is kept separately outside this repository. The shared foundation changes connection configuration, generates seed credentials and disables credential dump exports; it does not fix the four demonstration paths. Use unchanged upstream handlers at security level 0 for the before tests, and exactly the same input on the corrected code. See docs/BASELINE.md.

## Four sequential contributions
Only import the foundation first. Apply member packages 1, 2, 3 and 4 in order after each preceding PR is merged. `git pull` downloads merged changes. A pull request asks reviewers to merge your branch. See docs/GITHUB-WORKFLOW.md. Never upload the final combined snapshot before the four PRs: that would hide the individual code changes from review.

Each member reviews and tests the AI-assisted draft, makes their own corrections, and commits under their own GitHub identity. Supplied role assignments are planned ownership, not a claim of completed student work.

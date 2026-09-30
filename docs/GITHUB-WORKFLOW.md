# Sequential GitHub pull requests

The owner first uploads ONLY the 00-foundation contents to main. This creates the base branch required for the first PR. Preserve the root .gitignore and licence. Do not upload a ZIP as application source. Add the other three members as collaborators using their actual GitHub usernames, or use forks if collaborator access is unavailable.

For each member, after the previous PR is reviewed and merged:

```powershell
git clone https://github.com/oshadha-001/Devsec-group-project.git
cd Devsec-group-project
# If already cloned, use the existing folder instead:
git switch main
git pull --ff-only origin main
git switch -c YOUR_BRANCH_FROM_MEMBER_GUIDE
# Run Apply-Package.ps1 from your unzipped member package; give this repo path.
# Review changes, run tests, add genuine screenshots and complete your observations.
git diff --check
git diff
git add .
git commit -m "YOUR_COMMIT_MESSAGE_FROM_MEMBER_GUIDE"
git push -u origin YOUR_BRANCH_FROM_MEMBER_GUIDE
```

Sign into YOUR account in Git/GitHub and use your own configured Git name/email. These packages do not configure or impersonate student identities. On GitHub choose Compare & pull request, base main, your member branch; use PR-DESCRIPTION.md as a draft and replace pending evidence with observed results. Have another member review it. Make corrections on the same branch and push again. Merge only after review. The next member then pulls main and begins. PR numbers are allocated by GitHub; package numbers are the intended sequence, not promised PR numbers.

Suggested branches: member/IT24103920-sqli, member/IT24102334-xss, member/IT24104168-command, member/IT24610813-csrf.

Reviewers must check scope, code, before/after proof, legitimate behavior, tests, scans and AI disclosure. A copied draft alone does not establish individual understanding. Preserve actual PR links and review outcomes in the contribution record.

Do not overwrite another member's edits. Apply-Package refuses a different starting version of any changed file. Resolve such a conflict by reviewing changes.patch and manually adapting the patch, then retesting; do not force replacement. A separate complete-project folder is only a final reference, not a replacement for this sequence.

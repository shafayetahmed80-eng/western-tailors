# Western Bespoke — AI Engineering & Deployment Rules

Welcome to **Western Bespoke (ওয়েস্টার্ন বেস্পোক)**. These rules are **MANDATORY** for every AI agent, assistant, subagent, and engineering session operating in this repository, across all chat tabs, tools, and environments.

---

## 1. Project Stack & Architecture

- **Platform:** Botble CMS 7.6.4+ (Laravel 12.51.0, PHP 8.3)
- **Active Theme:** `ninico` (`platform/themes/ninico/`)
- **Branding & Aesthetics:**
  - Primary Color: Midnight Navy (`#0A192F`)
  - Accent Color: Sartorial Gold (`#C5A880`)
  - Typography: `Jost` (body/UI) & `Playfair Display` (headings/serif luxury titles)
- **Live Production URL:** `https://westernbespoke.com`
- **Hosting Environment:** Hostinger Business Plan, LiteSpeed Web Server, PHP 8.3.37
- **Live Server Path:** `/home/u555947128/westernbespoke_app`
- **SSH Key:** `C:\Users\Shafayet Ahmed\.ssh\id_ed25519`
- **SSH Host & Port:** `u555947128@178.16.136.179` on port `65002`

---

## 2. Mandatory Git Flow & Pull Request Standards

**NEVER commit directly to `main`.** All bug fixes, UI improvements, and feature developments MUST strictly follow this exact lifecycle:

1. **Feature Branch:**
   - Always branch off latest clean `main`:
     ```bash
     git checkout main && git pull origin main
     git checkout -b feat/your-feature-name  # or fix/your-bug-name
     ```
2. **Quality Implementation:**
   - Implement changes cleanly respecting Botble CMS structure and luxury bespoke design guidelines.
   - Use standard Laravel and Botble conventions (Blade templates, theme options, database migrations).
3. **Commit & Push:**
   - Use conventional commit messages: `feat: ...` or `fix: ...`.
   - Push to GitHub:
     ```bash
     git push -u origin <branch-name>
     ```
4. **Pull Request (PR) & CI Validation:**
   - Create a Pull Request via GitHub CLI:
     ```bash
     gh pr create --title "..." --body "..." --base main --head <branch-name>
     ```
   - Monitor GitHub Actions CI checks (`gh pr checks <id>`).
   - Every change MUST pass the automated `PHP 8.3 & Laravel Checks` (Green).
5. **PR Merge:**
   - Once CI is green, merge the PR into `main`:
     ```bash
     gh pr merge <id> --merge --delete-branch
     ```
   - Pull the merged code into local `main`:
     ```bash
     git checkout main && git pull origin main
     ```

---

## 3. Mandatory Live Deployment Protocol

**NEVER manually edit files on the live Hostinger server.**
**NEVER deploy via manual FTP/file overwrites.**

Whenever changes are merged into `main`, the live deployment MUST be executed exclusively through the automated deployment script via SSH:

```bash
ssh -i 'C:\Users\Shafayet Ahmed\.ssh\id_ed25519' -p 65002 u555947128@178.16.136.179 'bash ~/westernbespoke_app/update.sh'
```

### What `update.sh` executes automatically on the server:
1. Verifies no uncommitted/manual edits exist on the server (prevents data loss).
2. Checks GitHub `origin/main` for new commits.
3. If database migrations exist, automatically takes a compressed snapshot into `/home/u555947128/db-backups/` before any changes.
4. Performs fast-forward merge of new code (`git merge --ff-only`).
5. Discovers Botble CMS plugins & packages (`php artisan package:discover --ansi`).
6. Applies database migrations safely (`php artisan migrate --force`).
7. Clears and rebuilds production performance caches (`config:cache`, `route:cache`, `view:cache`).
8. Signals LiteSpeed web server to reload PHP workers (`touch .lsphp_restart.txt`).
9. Runs automated live health check against `https://westernbespoke.com` until `HTTP 200 OK` is verified.

---

## 4. Emergency Rollback Protocol

If an unexpected issue occurs in production after an update, execute immediate one-command rollback:

```bash
ssh -i 'C:\Users\Shafayet Ahmed\.ssh\id_ed25519' -p 65002 u555947128@178.16.136.179 'bash ~/westernbespoke_app/update.sh --rollback'
```
This instantly reverts to the previous git commit, flushes caches, and reloads the web server.

---

## 5. Communication & Language

- Always interact and communicate with the user in clear, polite, and natural **Bengali (বাংলা)**.
- For all file references, provide clickable markdown links using the `file:///` URI format.

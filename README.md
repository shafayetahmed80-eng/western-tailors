# Western Bespoke

Official e-commerce website for **Western Bespoke** — premium bespoke tailoring, suits, tuxedos, and traditional attire.

- **Production URL:** [https://westernbespoke.com](https://westernbespoke.com)
- **Framework:** Laravel 12.x / Botble CMS 7.6.4+
- **PHP Version:** PHP 8.3
- **Database:** MySQL / MariaDB (utf8mb4)

---

## Deployment & Updates

Western Bespoke uses an automated Git-based deployment workflow.

### 1. Developer Workflow (Local)
1. Make changes on a feature branch:
   ```bash
   git checkout -b feature/your-feature
   ```
2. Commit and push:
   ```bash
   git add .
   git commit -m "feat: description of change"
   git push origin feature/your-feature
   ```
3. Open a Pull Request on GitHub. Automated CI tests (`PHP 8.3 Syntax`, `Database Migrations`, `Artisan Cache`) will run automatically.
4. Merge into `main` after CI checks pass.

### 2. Live Server Update (Hostinger Terminal)
Run the following single command in the Hostinger terminal:
```bash
bash ~/westernbespoke_app/update.sh
```

This automated script will:
1. Verify no manual edits exist on the server to prevent data loss.
2. Check GitHub `origin/main` for new commits.
3. Automatically take a compressed backup of the database (`~/db-backups/`) if migrations are detected.
4. Fast-forward merge the new code.
5. Discover packages and plugins (`php artisan package:discover`).
6. Apply database migrations (`php artisan migrate --force`).
7. Clear and optimize Laravel caches (`config`, `routes`, `views`).
8. Reload LiteSpeed PHP workers and verify live HTTP 200 health.

### 3. Emergency Rollback
If you ever need to immediately revert to the previous version:
```bash
bash ~/westernbespoke_app/update.sh --rollback
```
To restore a database snapshot taken prior to an update:
```bash
bash ~/westernbespoke_app/scripts/restore-database.sh
```

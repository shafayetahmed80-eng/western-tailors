#!/usr/bin/env bash
# One-command update for Western Bespoke on Hostinger.
#
#   bash update.sh              (normal: pull latest code, backup db if needed, migrate, optimize, restart)
#   bash update.sh --rollback   (undo: revert to previous commit and refresh cache)
#
# This script:
# 1. Checks that no local files were manually modified on the server.
# 2. Checks GitHub for new commits on the current branch.
# 3. If new database migrations are detected, it automatically takes a compressed
#    snapshot of the database (scripts/backup-database.sh) before proceeding.
# 4. Pulls the new code using fast-forward merge.
# 5. Optimizes Composer dependencies (composer install --no-dev --optimize-autoloader).
# 6. Runs database migrations safely (php artisan migrate --force).
# 7. Clears and rebuilds production caches (config, routes, views).
# 8. Reloads LiteSpeed PHP workers and runs an automated health check against https://westernbespoke.com.
set -euo pipefail

MODE="update"
case "${1:-}" in
  "") ;;
  --rollback) MODE="rollback" ;;
  *) echo "Unknown option: $1 (only --rollback is allowed)" >&2; exit 1 ;;
esac

APP_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$APP_DIR"

say() { printf '\n==> %s\n' "$*"; }
die() { printf '\n[STOPPED] %s\n' "$*" >&2; exit 1; }

SITE_URL="${PUBLIC_SITE_URL:-https://westernbespoke.com}"

# Check health of the live website
check_health() {
  say "Checking that the site answers with HTTP 200"
  sleep 2
  for TRY in 1 2 3 4 5; do
    STATUS="$(curl -s -o /dev/null -w "%{http_code}" -m 15 "$SITE_URL" || true)"
    if [ "$STATUS" = "200" ]; then
      printf '\n%s returned HTTP 200 OK!\n' "$SITE_URL"
      return 0
    fi
    printf 'Attempt %d/5: %s returned HTTP %s. Retrying in 3s...\n' "$TRY" "$SITE_URL" "$STATUS"
    sleep 3
  done
  printf '\nWarning: %s is not returning HTTP 200 (Status: %s).\n' "$SITE_URL" "$STATUS"
  return 1
}

# ----------------- ROLLBACK MODE -----------------
if [ "$MODE" = "rollback" ]; then
  [ -f .commit_prev ] || die "No previous commit record found (.commit_prev is missing). Cannot rollback."
  PREV_SHA="$(tr -d '[:space:]' < .commit_prev)"
  [ -n "$PREV_SHA" ] || die "Previous commit hash is empty."

  say "Rolling back to previous commit: $PREV_SHA"
  git reset --hard "$PREV_SHA"

  say "Clearing and rebuilding cache"
  php artisan optimize:clear
  php artisan config:cache || true
  php artisan route:cache || true
  php artisan view:cache || true

  # Touch markers for LiteSpeed / PHP worker pool reload
  mkdir -p tmp
  touch tmp/restart.txt 2>/dev/null || true
  touch .lsphp_restart.txt 2>/dev/null || true

  if check_health; then
    printf '\nRollback to %s completed successfully.\n' "$PREV_SHA"
    printf 'If this update modified the database, restore the snapshot with: bash scripts/restore-database.sh\n'
    exit 0
  else
    die "Rollback finished, but site did not return 200 OK. Please inspect storage/logs/laravel.log"
  fi
fi

# ----------------- UPDATE MODE -----------------
[ -f .env ] || die ".env file is missing. Please ensure your environment configuration is present."

command -v git >/dev/null 2>&1 || die "git is not available on this server."
command -v php >/dev/null 2>&1 || die "php is not available on this server."

# Check for uncommitted server edits
if [ -n "$(git status --porcelain --untracked-files=no)" ]; then
  die "Files on the server were modified manually. Run 'git status' to inspect. Update halted to prevent data loss."
fi

say "Checking for updates from GitHub"
BRANCH="$(git rev-parse --abbrev-ref HEAD)"
git fetch --quiet origin "$BRANCH"

LOCAL="$(git rev-parse HEAD)"
REMOTE="$(git rev-parse "origin/$BRANCH")"

if [ "$LOCAL" = "$REMOTE" ]; then
  echo "Nothing new. Western Bespoke is already up to date with origin/$BRANCH ($LOCAL)."
  exit 0
fi

echo "New commits found:"
git --no-pager log --oneline "$LOCAL..$REMOTE"

# Scan for database migrations in Laravel standard path and Botble platform plugins
MIGRATION_CHANGES="$(git diff --name-only "$LOCAL" "$REMOTE" -- 'database/migrations/*' 'platform/*/database/migrations/*' | wc -l | tr -d ' ')"

if [ "$MIGRATION_CHANGES" -gt 0 ]; then
  printf '\nThis update includes database migrations (%s file(s) changed).\n' "$MIGRATION_CHANGES"
  say "Creating automatic database backup before applying migrations"
  if [ -f scripts/backup-database.sh ]; then
    bash scripts/backup-database.sh "before-${REMOTE:0:7}"
  else
    die "Backup tool (scripts/backup-database.sh) is missing. Cannot safely update."
  fi
fi

# Save current commit for rollback
printf '%s\n' "$LOCAL" > .commit_prev

say "Downloading and merging new code"
git merge --ff-only --quiet "origin/$BRANCH"

say "Discovering application packages and plugins"
php artisan package:discover --ansi

say "Applying database migrations"
php artisan migrate --force

say "Rebuilding caches and optimizing framework"
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

say "Reloading web server process"
mkdir -p tmp
touch tmp/restart.txt 2>/dev/null || true
touch .lsphp_restart.txt 2>/dev/null || true

if check_health; then
  printf '\n============================================\n'
  printf '  Western Bespoke updated successfully!     \n'
  printf '  Current commit: %s                        \n' "$(git rev-parse --short HEAD)"
  printf '============================================\n'
  exit 0
fi

printf '\nUpdate was applied, but site health check did not pass.\n'
printf 'To revert back to the previous version, run:\n'
printf '  bash update.sh --rollback\n'
exit 1

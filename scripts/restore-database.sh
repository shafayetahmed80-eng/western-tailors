#!/usr/bin/env bash
# Restores the Western Bespoke database from a saved compressed backup.
#
#   bash scripts/restore-database.sh [path-to-backup.sql.gz]
#
# If no file is specified, it lists the available backups in ~/db-backups/
# and lets you pick the one to restore.
set -euo pipefail

APP_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$APP_DIR"

DIR="${BACKUP_DIR:-$HOME/db-backups}"

fail() { printf '[RESTORE ERROR] %s\n' "$*" >&2; exit 1; }

command -v mysql >/dev/null 2>&1 || fail "mysql is not available on this server."
command -v gzip >/dev/null 2>&1 || fail "gzip is not available on this server."
[ -f .env ] || fail ".env file is missing in $APP_DIR."

FILE="${1:-}"

if [ -z "$FILE" ]; then
  echo "Available database backups in $DIR:"
  BACKUPS=($(ls -1 "$DIR"/western-bespoke-*.sql.gz 2>/dev/null | sort -r || true))
  if [ ${#BACKUPS[@]} -eq 0 ]; then
    fail "No database backups found in $DIR."
  fi
  for i in "${!BACKUPS[@]}"; do
    printf '  [%d] %s (%s)\n' "$((i+1))" "$(basename "${BACKUPS[$i]}")" "$(du -h "${BACKUPS[$i]}" 2>/dev/null | cut -f1 || echo "")"
  done
  printf '\nEnter number (1-%d) to restore, or Ctrl+C to cancel: ' "${#BACKUPS[@]}"
  read -r CHOICE
  case "$CHOICE" in
    ''|*[!0-9]*) fail "Invalid selection." ;;
  esac
  if [ "$CHOICE" -lt 1 ] || [ "$CHOICE" -gt "${#BACKUPS[@]}" ]; then
    fail "Number out of range."
  fi
  FILE="${BACKUPS[$((CHOICE-1))]}"
fi

[ -f "$FILE" ] || fail "Backup file not found: $FILE"
gzip -t "$FILE" 2>/dev/null || fail "The backup archive is damaged or corrupt."

echo "You are about to restore the database from:"
echo "  $FILE"
printf 'Type "restore" and press Enter to confirm: '
read -r CONFIRM
[ "$CONFIRM" = "restore" ] || fail "Aborted by user. No changes made."

# Read DB credentials from .env safely
get_env_val() {
  grep -E "^${1}=" .env | tail -n 1 | cut -d '=' -f2- | sed -e 's/^[[:space:]]*["'\''"]*//' -e 's/["'\''"][[:space:]]*$//' | tr -d '\r'
}

DB_HOST="$(get_env_val DB_HOST)"
DB_PORT="$(get_env_val DB_PORT)"
DB_NAME="$(get_env_val DB_DATABASE)"
DB_USER="$(get_env_val DB_USERNAME)"
DB_PASS="$(get_env_val DB_PASSWORD)"

[ -n "$DB_NAME" ] || fail "DB_DATABASE is not set in .env."
[ -n "$DB_USER" ] || fail "DB_USERNAME is not set in .env."

HOST_ARG=()
if [ "$DB_HOST" != "localhost" ] && [ -n "$DB_HOST" ]; then
  HOST_ARG=(-h "$DB_HOST" -P "${DB_PORT:-3306}")
fi

echo "Restoring database..."
gzip -dc "$FILE" | MYSQL_PWD="$DB_PASS" mysql -u "$DB_USER" "${HOST_ARG[@]}" "$DB_NAME"

echo "Clearing application cache..."
if command -v php >/dev/null 2>&1; then
  php artisan optimize:clear || true
fi

echo "Database restore completed successfully!"

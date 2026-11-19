#!/usr/bin/env bash
# Saves a compressed copy of the Western Bespoke database and keeps only the newest few.
#
#   bash scripts/backup-database.sh [label]
#
# The copy goes to ~/db-backups/western-bespoke-<UTC date and time>-<label>.sql.gz,
# outside the website folders, readable only by this hosting account.
# update.sh runs this automatically before any update that changes the database.
set -euo pipefail

APP_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$APP_DIR"

KEEP="${BACKUP_KEEP:-10}"
DIR="${BACKUP_DIR:-$HOME/db-backups}"
LABEL="${1:-manual}"
LABEL="${LABEL//[^A-Za-z0-9._-]/}"
[ -n "$LABEL" ] || LABEL="manual"

fail() { printf 'Backup failed: %s\n' "$*" >&2; exit 1; }

case "$KEEP" in ''|*[!0-9]*) fail "BACKUP_KEEP must be a number." ;; esac
[ "$KEEP" -ge 1 ] || fail "BACKUP_KEEP must be at least 1."
command -v mysqldump >/dev/null 2>&1 || fail "mysqldump is not available on this server."
command -v gzip >/dev/null 2>&1 || fail "gzip is not available on this server."
[ -f .env ] || fail ".env file is missing in $APP_DIR."

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

mkdir -p "$DIR" || fail "cannot create $DIR."
chmod 700 "$DIR" 2>/dev/null || true

ERRORS="$(mktemp)"
PARTIAL="$(mktemp "$DIR/.partial-XXXXXX")"
trap 'rm -f "$ERRORS" "$PARTIAL"' EXIT

HOST_ARG=()
if [ "$DB_HOST" != "localhost" ] && [ -n "$DB_HOST" ]; then
  HOST_ARG=(-h "$DB_HOST" -P "${DB_PORT:-3306}")
fi

if ! MYSQL_PWD="$DB_PASS" mysqldump -u "$DB_USER" "${HOST_ARG[@]}" \
     --single-transaction --quick --skip-lock-tables \
     --default-character-set=utf8mb4 "$DB_NAME" 2>"$ERRORS" | gzip -c > "$PARTIAL"; then
  fail "mysqldump stopped: $(tail -n 3 "$ERRORS" | tr '\n' ' ')"
fi

# Verify gzip integrity and check completion line
gzip -t "$PARTIAL" 2>/dev/null || fail "the backup archive is damaged."
LAST_LINE="$(gzip -dc "$PARTIAL" | tail -n 1)"
case "$LAST_LINE" in
  *"Dump completed"*) ;;
  *) fail "the database dump is incomplete." ;;
esac

STAMP="$(date -u +%Y%m%d-%H%M%S)"
FILE="$DIR/western-bespoke-$STAMP-$LABEL.sql.gz"
chmod 600 "$PARTIAL"
mv "$PARTIAL" "$FILE"

# Rotate: remove backups older than KEEP limit
ls -1 "$DIR"/western-bespoke-*.sql.gz 2>/dev/null | sort -r | tail -n +"$((KEEP + 1))" | while IFS= read -r OLD; do
  rm -f -- "$OLD"
done

printf 'Database backup saved: %s (%s)\n' "$FILE" "$(du -h "$FILE" 2>/dev/null | cut -f1 || echo "OK")"

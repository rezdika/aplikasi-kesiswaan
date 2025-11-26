#!/bin/bash
# Auto Backup Script for Database Kesiswaan

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="storage/app/backups"
DB_NAME="${DB_DATABASE}"
DB_USER="${DB_USERNAME}"
DB_PASS="${DB_PASSWORD}"
DB_HOST="${DB_HOST}"

# Create backup directory if not exists
mkdir -p $BACKUP_DIR

# MySQL Backup
if [ -z "$DB_PASS" ]; then
    mysqldump -h $DB_HOST -u $DB_USER $DB_NAME > $BACKUP_DIR/backup_$DATE.sql
else
    mysqldump -h $DB_HOST -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_DIR/backup_$DATE.sql
fi

# Compress
gzip $BACKUP_DIR/backup_$DATE.sql

# Clean old backups (keep 30 days)
find $BACKUP_DIR -name "*.gz" -mtime +30 -delete

echo "Backup completed: backup_$DATE.sql.gz"

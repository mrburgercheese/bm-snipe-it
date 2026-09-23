#!/bin/bash
# ============================================================
# Script: restore_telegram_patch.sh
# Tujuan: Re-apply modifikasi (Telegram, Views, HTAccess) ke Snipe-IT
#         setelah update/upgrade Snipe-IT
# Dibuat : 2026-06-11
# ============================================================

set -e

BASEDIR="/home/bmsnipeit/public_html"
STAMP=$(date +"%Y%m%d_%H%M%S")

echo "======================================"
echo " Restore Snipe-IT Customizations"
echo " Waktu: $(date)"
echo "======================================"

# Backup dulu file yang ada sekarang (hasil update)
echo "[1/4] Backup file hasil update..."
cp "$BASEDIR/app/Listeners/CheckoutableListener.php" "$BASEDIR/app/Listeners/CheckoutableListener.php.pre_patch_${STAMP}"
cp "$BASEDIR/app/Observers/MaintenanceObserver.php" "$BASEDIR/app/Observers/MaintenanceObserver.php.pre_patch_${STAMP}"
cp "$BASEDIR/app/Observers/ComponentObserver.php" "$BASEDIR/app/Observers/ComponentObserver.php.pre_patch_${STAMP}"
cp "$BASEDIR/app/Observers/AssetObserver.php" "$BASEDIR/app/Observers/AssetObserver.php.pre_patch_${STAMP}"
cp "$BASEDIR/resources/views/dashboard.blade.php" "$BASEDIR/resources/views/dashboard.blade.php.pre_patch_${STAMP}"
cp "$BASEDIR/resources/views/maintenances/index.blade.php" "$BASEDIR/resources/views/maintenances/index.blade.php.pre_patch_${STAMP}"
cp "$BASEDIR/resources/views/users/print.blade.php" "$BASEDIR/resources/views/users/print.blade.php.pre_patch_${STAMP}"
cp "$BASEDIR/.htaccess" "$BASEDIR/.htaccess.pre_patch_${STAMP}"
cp "$BASEDIR/routes/web.php" "$BASEDIR/routes/web.php.pre_patch_${STAMP}"
cp "$BASEDIR/resources/views/layouts/default.blade.php" "$BASEDIR/resources/views/layouts/default.blade.php.pre_patch_${STAMP}"
mkdir -p "$BASEDIR/resources/views/custom"
cp "$BASEDIR/resources/views/custom/bulk_checkout_license.blade.php" "$BASEDIR/resources/views/custom/bulk_checkout_license.blade.php.pre_patch_${STAMP}" 2>/dev/null || true
cp "$BASEDIR/resources/views/custom/bulk_checkin_license.blade.php" "$BASEDIR/resources/views/custom/bulk_checkin_license.blade.php.pre_patch_${STAMP}" 2>/dev/null || true

# Find the latest working backup file for each
echo "[2/4] Mencari file backup working..."
LISTENER_BACKUP=$(ls -t "$BASEDIR/app/Listeners/CheckoutableListener.php.working_"* 2>/dev/null | head -1)
OBSERVER_BACKUP=$(ls -t "$BASEDIR/app/Observers/MaintenanceObserver.php.working_"* 2>/dev/null | head -1)
COMP_OBSERVER_BACKUP=$(ls -t "$BASEDIR/app/Observers/ComponentObserver.php.working_"* 2>/dev/null | head -1)
ASSET_OBSERVER_BACKUP=$(ls -t "$BASEDIR/app/Observers/AssetObserver.php.working_"* 2>/dev/null | head -1)
DASHBOARD_BACKUP=$(ls -t "$BASEDIR/resources/views/dashboard.blade.php.working_"* 2>/dev/null | head -1)
MAINT_INDEX_BACKUP=$(ls -t "$BASEDIR/resources/views/maintenances/index.blade.php.working_"* 2>/dev/null | head -1)
PRINT_BACKUP=$(ls -t "$BASEDIR/resources/views/users/print.blade.php.working_"* 2>/dev/null | head -1)
HTACCESS_BACKUP=$(ls -t "$BASEDIR/.htaccess.working_"* 2>/dev/null | head -1)
ROUTES_BACKUP=$(ls -t "$BASEDIR/routes/web.php.working_"* 2>/dev/null | head -1)
LAYOUT_BACKUP=$(ls -t "$BASEDIR/resources/views/layouts/default.blade.php.working_"* 2>/dev/null | head -1)
VIEW_CHECKOUT_BACKUP=$(ls -t "$BASEDIR/resources/views/custom/bulk_checkout_license.blade.php.working_"* 2>/dev/null | head -1)
VIEW_CHECKIN_BACKUP=$(ls -t "$BASEDIR/resources/views/custom/bulk_checkin_license.blade.php.working_"* 2>/dev/null | head -1)

# Verify backups exist
for backup_file in "$LISTENER_BACKUP" "$OBSERVER_BACKUP" "$COMP_OBSERVER_BACKUP" "$ASSET_OBSERVER_BACKUP" "$DASHBOARD_BACKUP" "$MAINT_INDEX_BACKUP" "$PRINT_BACKUP" "$HTACCESS_BACKUP" "$ROUTES_BACKUP" "$LAYOUT_BACKUP" "$VIEW_CHECKOUT_BACKUP" "$VIEW_CHECKIN_BACKUP"; do
    if [ -z "$backup_file" ]; then
        echo "ERROR: Ada file backup working yang tidak ditemukan!"
        exit 1
    fi
done

echo "  -> Listener     : $LISTENER_BACKUP"
echo "  -> Observer     : $OBSERVER_BACKUP"
echo "  -> Comp Obs     : $COMP_OBSERVER_BACKUP"
echo "  -> Asset Obs    : $ASSET_OBSERVER_BACKUP"
echo "  -> Dashboard    : $DASHBOARD_BACKUP"
echo "  -> Maint Index  : $MAINT_INDEX_BACKUP"
echo "  -> Print User   : $PRINT_BACKUP"
echo "  -> HTAccess     : $HTACCESS_BACKUP"
echo "  -> Routes       : $ROUTES_BACKUP"
echo "  -> Layout       : $LAYOUT_BACKUP"
echo "  -> View Checkout: $VIEW_CHECKOUT_BACKUP"
echo "  -> View Checkin : $VIEW_CHECKIN_BACKUP"

# Copy backup to active files
cp "$LISTENER_BACKUP" "$BASEDIR/app/Listeners/CheckoutableListener.php"
cp "$OBSERVER_BACKUP" "$BASEDIR/app/Observers/MaintenanceObserver.php"
cp "$COMP_OBSERVER_BACKUP" "$BASEDIR/app/Observers/ComponentObserver.php"
cp "$ASSET_OBSERVER_BACKUP" "$BASEDIR/app/Observers/AssetObserver.php"
cp "$DASHBOARD_BACKUP" "$BASEDIR/resources/views/dashboard.blade.php"
cp "$MAINT_INDEX_BACKUP" "$BASEDIR/resources/views/maintenances/index.blade.php"
cp "$PRINT_BACKUP" "$BASEDIR/resources/views/users/print.blade.php"
cp "$HTACCESS_BACKUP" "$BASEDIR/.htaccess"
cp "$ROUTES_BACKUP" "$BASEDIR/routes/web.php"
cp "$LAYOUT_BACKUP" "$BASEDIR/resources/views/layouts/default.blade.php"
mkdir -p "$BASEDIR/resources/views/custom"
cp "$VIEW_CHECKOUT_BACKUP" "$BASEDIR/resources/views/custom/bulk_checkout_license.blade.php"
cp "$VIEW_CHECKIN_BACKUP" "$BASEDIR/resources/views/custom/bulk_checkin_license.blade.php"

# Validasi syntax PHP
echo "[3/4] Validasi syntax PHP..."
php -l "$BASEDIR/app/Listeners/CheckoutableListener.php" || { echo "ERROR syntax CheckoutableListener!"; exit 1; }
php -l "$BASEDIR/app/Observers/MaintenanceObserver.php"  || { echo "ERROR syntax MaintenanceObserver!"; exit 1; }
php -l "$BASEDIR/app/Observers/ComponentObserver.php"    || { echo "ERROR syntax ComponentObserver!"; exit 1; }
php -l "$BASEDIR/app/Observers/AssetObserver.php"        || { echo "ERROR syntax AssetObserver!"; exit 1; }
php -l "$BASEDIR/resources/views/dashboard.blade.php"    || { echo "ERROR syntax dashboard.blade.php!"; exit 1; }
php -l "$BASEDIR/resources/views/maintenances/index.blade.php" || { echo "ERROR syntax index.blade.php!"; exit 1; }
php -l "$BASEDIR/resources/views/users/print.blade.php"  || { echo "ERROR syntax print.blade.php!"; exit 1; }
php -l "$BASEDIR/routes/web.php"                         || { echo "ERROR syntax routes/web.php!"; exit 1; }
php -l "$BASEDIR/resources/views/layouts/default.blade.php" || { echo "ERROR syntax default.blade.php!"; exit 1; }
php -l "$BASEDIR/resources/views/custom/bulk_checkout_license.blade.php" || { echo "ERROR syntax bulk_checkout_license.blade.php!"; exit 1; }
php -l "$BASEDIR/resources/views/custom/bulk_checkin_license.blade.php" || { echo "ERROR syntax bulk_checkin_license.blade.php!"; exit 1; }

# Clear cache Laravel
echo "[4/4] Clear cache Laravel..."
cd "$BASEDIR" && php artisan optimize:clear

echo ""
echo "======================================"
echo " SELESAI! Semua kustomisasi"
echo " berhasil di-restore."
echo "======================================"

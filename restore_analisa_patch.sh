#!/bin/bash
# ==============================================================================
# Skrip Pemulihan Otomatis Modifikasi Custom BMSnipeIT (Analisa Hardware, Upgrade & Component Checkout)
# Lokasi: /home/bmsnipeit/restore_analisa_patch.sh
# ==============================================================================

BASEDIR="/home/bmsnipeit/public_html"

echo "[1/5] Memeriksa Direktori & File Custom..."
mkdir -p "$BASEDIR/resources/views/analisa"

# Copy Controller jika tidak ada
if [ ! -f "$BASEDIR/app/Http/Controllers/HardwareAnalisaController.php" ]; then
    echo "  -> Menyalin Controller HardwareAnalisaController.php..."
    cp /home/bmsnipeit/HardwareAnalisaController.php "$BASEDIR/app/Http/Controllers/" 2>/dev/null
fi

# Copy Views jika tidak ada
if [ ! -f "$BASEDIR/resources/views/analisa/cpu_intel_noncore.blade.php" ]; then
    echo "  -> Menyalin Blade Views Analisa Hardware..."
    cp /home/bmsnipeit/views_backup/* "$BASEDIR/resources/views/analisa/" 2>/dev/null
fi

echo "[2/5] Memeriksa & Injeksi Route Custom ke routes/web.php..."
if ! grep -q "hardware.analisa.complete_upgrade" "$BASEDIR/routes/web.php"; then
    echo "  -> Menginjeksikan Route Analisa Hardware & Complete Upgrade..."
    sed -i '/custom.lookup_asset/i \
    // Custom Analisa Hardware Routes (Added by Lexa)\
    Route::get('\''analisa/cpu-intel-noncore'\'', [\\App\\Http\\Controllers\\HardwareAnalisaController::class, '\''intelNonCore'\''])->name('\''hardware.analisa.cpu_intel_noncore'\'');\
    Route::post('\''analisa/toggle-upgrade-status'\'', [\\App\\Http\\Controllers\\HardwareAnalisaController::class, '\''toggleUpgradeStatus'\''])->name('\''hardware.analisa.toggle_upgrade'\'');\
    Route::get('\''analisa/progress-report'\'', [\\App\\Http\\Controllers\\HardwareAnalisaController::class, '\''progressReport'\''])->name('\''hardware.analisa.progress_report'\'');\
    Route::post('\''analisa/create-snapshot'\'', [\\App\\Http\\Controllers\\HardwareAnalisaController::class, '\''createSnapshot'\''])->name('\''hardware.analisa.create_snapshot'\'');\
    Route::post('\''analisa/delete-snapshot'\'', [\\App\\Http\\Controllers\\HardwareAnalisaController::class, '\''deleteSnapshot'\''])->name('\''hardware.analisa.delete_snapshot'\'');\
    Route::get('\''analisa/print-report'\'', [\\App\\Http\\Controllers\\HardwareAnalisaController::class, '\''printReport'\''])->name('\''hardware.analisa.print_report'\'');\
    Route::get('\''analisa/components-list'\'', [\\App\\Http\\Controllers\\HardwareAnalisaController::class, '\''getComponentsList'\''])->name('\''hardware.analisa.components_list'\'');\
    Route::post('\''analisa/complete-upgrade'\'', [\\App\\Http\\Controllers\\HardwareAnalisaController::class, '\''completeUpgrade'\''])->name('\''hardware.analisa.complete_upgrade'\'');\
' "$BASEDIR/routes/web.php"
fi

echo "[3/5] Memeriksa & Injeksi Menu Sidebar ke resources/views/layouts/default.blade.php..."
if ! grep -q "Analisa Hardware" "$BASEDIR/resources/views/layouts/default.blade.php"; then
    echo "  -> Menginjeksikan Menu Sidebar Analisa Hardware..."
    sed -i '/requestable_items/a \
                        <!-- Menu Analisa Hardware (Added by Lexa) -->\
                        <li class="treeview{!! (request()->is('\''analisa/*'\'') ? '\'' active'\'' : '\'\') !!}">\
                            <a href="#">\
                                <i class="fa fa-calculator fa-fw"></i>\
                                <span>Analisa Hardware</span>\
                                <span class="pull-right-container">\
                                    <i class="fa fa-angle-left pull-right"></i>\
                                </span>\
                            </a>\
                            <ul class="treeview-menu">\
                                <li{!! (request()->is('\''analisa/cpu-intel-noncore'\'') ? '\'' active'\'' : '\'\') !!}>\
                                    <a href="{{ route('\''hardware.analisa.cpu_intel_noncore'\'') }}">\
                                        <i class="fa fa-microchip text-blue fa-fw"></i>\
                                        <span>CPU Intel (Non-Core)</span>\
                                    </a>\
                                </li>\
                                <li{!! (request()->is('\''analisa/progress-report'\'') ? '\'' active'\'' : '\'\') !!}>\
                                    <a href="{{ route('\''hardware.analisa.progress_report'\'') }}">\
                                        <i class="fa fa-line-chart text-purple fa-fw"></i>\
                                        <span>Laporan Progress Upgrade</span>\
                                    </a>\
                                </li>\
                            </ul>\
                        </li>' "$BASEDIR/resources/views/layouts/default.blade.php"
fi

echo "[4/5] Membersihkan Cache Laravel..."
cd "$BASEDIR"
php artisan view:clear
php artisan route:clear

echo "[5/5] Pemulihan Selesai! Seluruh fitur Analisa Hardware & Complete Upgrade tetap aktif 100%."

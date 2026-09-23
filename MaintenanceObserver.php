<?php

namespace App\Observers;

use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\Maintenance;
use Illuminate\Support\Facades\Log;

class MaintenanceObserver
{
    public function updated(Maintenance $maintenance)
    {
        $logAction = new Actionlog;
        $logAction->item_type = Maintenance::class;
        $logAction->item_id = $maintenance->id;
        $logAction->target_type = Asset::class;
        $logAction->target_id = $maintenance->asset_id;
        $logAction->created_at = date("Y-m-d H:i:s");
        $logAction->action_date = date("Y-m-d H:i:s");
        $logAction->created_by = auth()->id();
        if ($maintenance->imported) {
            $logAction->setActionSource("importer");
        }
        $logAction->logaction("update");
    }

    public function created(Maintenance $maintenance)
    {
        $logAction = new Actionlog;
        $logAction->item_type = Maintenance::class;
        $logAction->item_id = $maintenance->id;
        $logAction->target_type = Asset::class;
        $logAction->target_id = $maintenance->asset_id;
        $logAction->created_at = date("Y-m-d H:i:s");
        $logAction->action_date = date("Y-m-d H:i:s");
        $logAction->created_by = auth()->id();
        if ($maintenance->imported) {
            $logAction->setActionSource("importer");
        }
        $logAction->logaction("create");

        // Kirim notifikasi Telegram - fire and forget (non-blocking)
        try {
            $asset     = $maintenance->asset;
            $assetName = $asset ? ($asset->display_name ?? $asset->name ?? "-") : "-";
            $assetTag  = $asset ? ($asset->asset_tag ?? "") : "";
            $maintType = $maintenance->asset_maintenance_type ?? "-";
            $maintName = $maintenance->name ?? "-";
            $startDate = $maintenance->start_date ?? "-";
            $complDate = $maintenance->completion_date ?? null;
            $notes     = $maintenance->notes ?? "-";
            $cost      = $maintenance->cost ? "Rp " . number_format($maintenance->cost, 0, ",", ".") : "-";
            $supplier  = $maintenance->supplier ? $maintenance->supplier->name : "-";
            $dateStr   = date("Y-m-d H:i:s") . " WIB";

            $lines   = [];
            $lines[] = "<b>🛠️ MAINTENANCE BARU DITAMBAHKAN</b>";
            $lines[] = "----------------------------------";
            $lines[] = "🖥️ <b>Aset</b>    : " . htmlspecialchars($assetName, ENT_NOQUOTES, 'UTF-8');
            if ($assetTag) $lines[] = "🏷️ <b>No Aset</b> : " . htmlspecialchars($assetTag, ENT_NOQUOTES, 'UTF-8');
            $lines[] = "🔧 <b>Judul</b>   : " . htmlspecialchars($maintName, ENT_NOQUOTES, 'UTF-8');
            $lines[] = "📋 <b>Jenis</b>   : " . htmlspecialchars($maintType, ENT_NOQUOTES, 'UTF-8');
            $lines[] = "🏭 <b>Supplier</b>: " . htmlspecialchars($supplier, ENT_NOQUOTES, 'UTF-8');
            $lines[] = "📅 <b>Mulai</b>   : " . htmlspecialchars($startDate, ENT_NOQUOTES, 'UTF-8');
            if ($complDate) $lines[] = "✅ <b>Selesai</b> : " . htmlspecialchars($complDate, ENT_NOQUOTES, 'UTF-8');
            $lines[] = "💰 <b>Biaya</b>   : " . htmlspecialchars($cost, ENT_NOQUOTES, 'UTF-8');
            $lines[] = "📝 <b>Catatan</b> : " . htmlspecialchars($notes, ENT_NOQUOTES, 'UTF-8');
            $lines[] = "🕒 <b>Waktu</b>   : " . htmlspecialchars($dateStr, ENT_NOQUOTES, 'UTF-8');
            $lines[] = "----------------------------------";

            $this->sendTelegramAsync(implode("\n", $lines));
        } catch (\Exception $e) {
            Log::warning("Telegram maintenance create notify failed: " . $e->getMessage());
        }
    }

    public function deleting(Maintenance $maintenance)
    {
        // Kirim notifikasi Telegram SEBELUM record dihapus
        try {
            $asset     = $maintenance->asset;
            $assetName = $asset ? ($asset->display_name ?? $asset->name ?? "-") : "-";
            $assetTag  = $asset ? ($asset->asset_tag ?? "") : "";
            $maintType = $maintenance->asset_maintenance_type ?? "-";
            $maintName = $maintenance->name ?? "-";
            $startDate = $maintenance->start_date ?? "-";
            $notes     = $maintenance->notes ?? "-";
            $dateStr   = date("Y-m-d H:i:s") . " WIB";

            $lines   = [];
            $lines[] = "<b>🗑️ MAINTENANCE DIHAPUS</b>";
            $lines[] = "----------------------------------";
            $lines[] = "🖥️ <b>Aset</b>    : " . htmlspecialchars($assetName, ENT_NOQUOTES, 'UTF-8');
            if ($assetTag) $lines[] = "🏷️ <b>No Aset</b> : " . htmlspecialchars($assetTag, ENT_NOQUOTES, 'UTF-8');
            $lines[] = "🔧 <b>Judul</b>   : " . htmlspecialchars($maintName, ENT_NOQUOTES, 'UTF-8');
            $lines[] = "📋 <b>Jenis</b>   : " . htmlspecialchars($maintType, ENT_NOQUOTES, 'UTF-8');
            $lines[] = "📅 <b>Mulai</b>   : " . htmlspecialchars($startDate, ENT_NOQUOTES, 'UTF-8');
            $lines[] = "📝 <b>Catatan</b> : " . htmlspecialchars($notes, ENT_NOQUOTES, 'UTF-8');
            $lines[] = "🕒 <b>Dihapus</b> : " . htmlspecialchars($dateStr, ENT_NOQUOTES, 'UTF-8');
            $lines[] = "----------------------------------";

            $this->sendTelegramAsync(implode("\n", $lines));
        } catch (\Exception $e) {
            Log::warning("Telegram maintenance delete notify failed: " . $e->getMessage());
        }

        $logAction = new Actionlog;
        $logAction->item_type = Maintenance::class;
        $logAction->item_id = $maintenance->id;
        $logAction->target_type = Asset::class;
        $logAction->target_id = $maintenance->asset_id;
        $logAction->created_at = date("Y-m-d H:i:s");
        $logAction->action_date = date("Y-m-d H:i:s");
        $logAction->created_by = auth()->id();
        $logAction->logaction("delete");
    }

    /**
     * Kirim pesan Telegram via curl --data-urlencode di background (non-blocking)
     */
    private function sendTelegramAsync(string $message): void
    {
        if (!env("TELEGRAM_NOTIFICATION_ENABLED", false)) {
            return;
        }

        $token  = env("TELEGRAM_BOT_TOKEN", "");
        $chatId = env("TELEGRAM_CHAT_ID", "");

        if (!$token || !$chatId) {
            return;
        }

        $cmd = sprintf(
            "curl -s --max-time 8 -X POST %s --data-urlencode %s --data-urlencode %s --data-urlencode %s > /dev/null 2>&1 &",
            escapeshellarg("https://api.telegram.org/bot" . $token . "/sendMessage"),
            escapeshellarg("chat_id=" . $chatId),
            escapeshellarg("parse_mode=HTML"),
            escapeshellarg("text=" . $message)
        );

        exec($cmd);
    }
}

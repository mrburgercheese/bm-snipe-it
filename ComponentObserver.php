<?php

namespace App\Observers;

use App\Models\Actionlog;
use App\Models\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ComponentObserver
{
    /**
     * Listen to the User created event.
     *
     * @return void
     */
    public function updated(Component $component)
    {
        $logAction = new Actionlog;
        $logAction->item_type = Component::class;
        $logAction->item_id = $component->id;
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->action_date = date('Y-m-d H:i:s');
        $logAction->created_by = auth()->id();
        if ($component->imported) {
            $logAction->setActionSource('importer');
        }
        $logAction->logaction('update');
    }

    /**
     * Listen to the Component created event when
     * a new component is created.
     *
     * @return void
     */
    public function created(Component $component)
    {
        $logAction = new Actionlog;
        $logAction->item_type = Component::class;
        $logAction->item_id = $component->id;
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->action_date = date('Y-m-d H:i:s');
        $logAction->created_by = auth()->id();
        if ($component->imported) {
            $logAction->setActionSource('importer');
        }
        $logAction->logaction('create');
    }

    /**
     * Listen to the Component deleting event.
     *
     * @return void
     */
    public function deleting(Component $component)
    {
        $logAction = new Actionlog;
        $logAction->item_type = Component::class;
        $logAction->item_id = $component->id;
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->action_date = date('Y-m-d H:i:s');
        $logAction->created_by = auth()->id();
        $logAction->logaction('delete');

        // Kirim notifikasi Telegram
        try {
            if (env('TELEGRAM_NOTIFICATION_ENABLED', false)) {
                $token = env('TELEGRAM_BOT_TOKEN');
                $chatId = env('TELEGRAM_CHAT_ID');
                
                if ($token && $chatId) {
                    $itemName = $component->name ?? '';
                    $categoryName = $component->category?->name ?? '-';
                    $adminName = auth()->user()?->display_name ?? auth()->user()?->name ?? 'System';
                    $dateStr = date('Y-m-d H:i:s') . ' WIB';

                    $tgMessage = "🗑️ *KOMPONEN DIHAPUS*\n";
                    $tgMessage .= "----------------------------------\n";
                    $tgMessage .= "🧩 *Nama*: " . $itemName . "\n";
                    $tgMessage .= "📁 *Kategori*: " . $categoryName . "\n";
                    $tgMessage .= "👤 *Admin*: " . $adminName . "\n";
                    $tgMessage .= "📅 *Tanggal*: " . $dateStr . "\n";
                    $tgMessage .= "----------------------------------";

                    Http::timeout(10)->post("https://api.telegram.org/bot{$token}/sendMessage", [
                        'chat_id' => $chatId,
                        'text' => $tgMessage,
                        'parse_mode' => 'Markdown',
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::warning("Telegram component deleting notify failed: " . $e->getMessage());
        }
    }
}

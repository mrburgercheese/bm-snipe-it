<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Asset;

class HardwareAnalisaController extends Controller
{
    private function getSnapshotFilePath()
    {
        return storage_path('app/upgrade_snapshots.json');
    }

    private function getSnapshots()
    {
        $file = $this->getSnapshotFilePath();
        if (file_exists($file)) {
            $content = file_get_contents($file);
            return json_decode($content, true) ?: [];
        }
        return [];
    }

    private function saveSnapshots($snapshots)
    {
        $file = $this->getSnapshotFilePath();
        file_put_contents($file, json_encode($snapshots, JSON_PRETTY_PRINT));
    }

    /**
     * Tampilkan Halaman Analisa Hardware - CPU Intel Non-Core (Tanpa Laptop & Tanpa Xeon)
     */
    public function intelNonCore(Request $request)
    {
        $prefix = DB::getTablePrefix();

        $companyId = $request->input('company_id');
        $statusId = $request->input('status_id');
        $search = $request->input('search');

        $query = DB::table('assets')
            ->leftJoin('models', 'assets.model_id', '=', 'models.id')
            ->leftJoin('categories', 'models.category_id', '=', 'categories.id')
            ->leftJoin('companies', 'assets.company_id', '=', 'companies.id')
            ->leftJoin('locations', 'assets.location_id', '=', 'locations.id')
            ->leftJoin('status_labels', 'assets.status_id', '=', 'status_labels.id')
            ->leftJoin('users', function($join) {
                $join->on('assets.assigned_to', '=', 'users.id')
                     ->where('assets.assigned_type', '=', 'App\\Models\\User');
            })
            ->whereNull('assets.deleted_at')
            // Filter CPU Intel Non-Core
            ->where(function($q) {
                $q->where('_snipeit_jenis_processor_12', 'LIKE', '%Intel%')
                  ->orWhere('_snipeit_jenis_processor_12', 'LIKE', '%intel%')
                  ->orWhere('_snipeit_jenis_processor_12', 'LIKE', '%Pentium%')
                  ->orWhere('_snipeit_jenis_processor_12', 'LIKE', '%Celeron%')
                  ->orWhere('_snipeit_jenis_processor_12', 'LIKE', '%Atom%');
            })
            // Eksklusi Core & Xeon
            ->where(function($q) {
                $q->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%Core%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%core%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%i3%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%i5%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%i7%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%i9%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%Xeon%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%xeon%');
            })
            // Filter Eksklusi Laptop
            ->where(function($q) {
                $q->where('categories.name', 'NOT LIKE', '%LAPTOP%')
                  ->where('categories.name', 'NOT LIKE', '%laptop%')
                  ->orWhereNull('categories.name');
            });

        if ($companyId) {
            $query->where('assets.company_id', $companyId);
        }

        if ($statusId) {
            $query->where('assets.status_id', $statusId);
        }

        if ($search) {
            $query->where(function($q) use ($search, $prefix) {
                $q->where('assets.asset_tag', 'LIKE', "%{$search}%")
                  ->orWhere('assets.name', 'LIKE', "%{$search}%")
                  ->orWhere('assets._snipeit_jenis_processor_12', 'LIKE', "%{$search}%")
                  ->orWhere('assets._snipeit_jenis_ram_5', 'LIKE', "%{$search}%")
                  ->orWhere('companies.name', 'LIKE', "%{$search}%")
                  ->orWhere(DB::raw("CONCAT(" . $prefix . "users.first_name, ' ', COALESCE(" . $prefix . "users.last_name, ''))"), 'LIKE', "%{$search}%");
            });
        }

        $assets = $query->select(
            'assets.id',
            'assets.asset_tag',
            'assets.name as asset_name',
            'assets._snipeit_jenis_processor_12 as processor',
            'assets._snipeit_jenis_ram_5 as ram',
            'models.name as model_name',
            'categories.name as category_name',
            'companies.name as company_name',
            'status_labels.name as status_name',
            'status_labels.id as status_id',
            DB::raw("CONCAT(" . $prefix . "users.first_name, ' ', COALESCE(" . $prefix . "users.last_name, '')) as assigned_user")
        )->orderBy('companies.name', 'ASC')->orderBy('assets.asset_tag', 'ASC')->get();

        $baseQuery = DB::table('assets')
            ->leftJoin('models', 'assets.model_id', '=', 'models.id')
            ->leftJoin('categories', 'models.category_id', '=', 'categories.id')
            ->whereNull('assets.deleted_at')
            ->where(function($q) {
                $q->where('_snipeit_jenis_processor_12', 'LIKE', '%Intel%')
                  ->orWhere('_snipeit_jenis_processor_12', 'LIKE', '%intel%')
                  ->orWhere('_snipeit_jenis_processor_12', 'LIKE', '%Pentium%')
                  ->orWhere('_snipeit_jenis_processor_12', 'LIKE', '%Celeron%')
                  ->orWhere('_snipeit_jenis_processor_12', 'LIKE', '%Atom%');
            })
            ->where(function($q) {
                $q->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%Core%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%core%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%i3%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%i5%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%i7%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%i9%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%Xeon%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%xeon%');
            })
            ->where(function($q) {
                $q->where('categories.name', 'NOT LIKE', '%LAPTOP%')
                  ->where('categories.name', 'NOT LIKE', '%laptop%')
                  ->orWhereNull('categories.name');
            });

        $totalCount = (clone $baseQuery)->count();
        $totalDeployed = (clone $baseQuery)->where('assets.status_id', 4)->count();
        $totalScheduled = (clone $baseQuery)->where('assets.status_id', 17)->count(); // ID 17 = Terjadwal Upgrade
        $totalStock = (clone $baseQuery)->where('assets.status_id', 2)->count();
        $totalPerbaikan = (clone $baseQuery)->whereIn('assets.status_id', [3, 7, 8])->count();

        $companies = DB::table('companies')->orderBy('name', 'ASC')->get();
        $statuses = DB::table('status_labels')->orderBy('name', 'ASC')->get();

        return view('analisa.cpu_intel_noncore', compact(
            'assets',
            'totalCount',
            'totalDeployed',
            'totalScheduled',
            'totalStock',
            'totalPerbaikan',
            'companies',
            'statuses',
            'companyId',
            'statusId',
            'search'
        ));
    }

    /**
     * AJAX Toggle Status Terjadwal Upgrade
     */
    public function toggleUpgradeStatus(Request $request)
    {
        $assetId = $request->input('asset_id');

        if (!$assetId) {
            return response()->json(['success' => false, 'message' => 'Asset ID wajib diisi!'], 400);
        }

        $asset = Asset::find($assetId);
        if (!$asset) {
            return response()->json(['success' => false, 'message' => 'Asset tidak ditemukan!'], 404);
        }

        if ($asset->status_id == 17) {
            $asset->status_id = 4; // Asset Terpasang
            $asset->save();
            $newStatusName = 'Asset Terpasang';
            $isScheduled = false;
        } else {
            $asset->status_id = 17; // Terjadwal Upgrade
            $asset->save();
            $newStatusName = 'Terjadwal Upgrade';
            $isScheduled = true;
        }

        return response()->json([
            'success' => true,
            'asset_id' => $asset->id,
            'new_status_id' => $asset->status_id,
            'new_status_name' => $newStatusName,
            'is_scheduled' => $isScheduled,
            'message' => 'Status aset ' . $asset->asset_tag . ' berhasil diubah menjadi ' . $newStatusName
        ]);
    }

    /**
     * Ambil Daftar Komponen Aktif dengan Stok > 0 (Include Kode/Serial & Nama Kategori)
     */
    public function getComponentsList()
    {
        $components = DB::table('components')
            ->leftJoin('categories', 'components.category_id', '=', 'categories.id')
            ->whereNull('components.deleted_at')
            ->select(
                'components.id',
                'components.name',
                'components.serial',
                'components.model_number',
                'components.qty',
                'categories.name as category_name'
            )
            ->orderBy('categories.name', 'ASC')
            ->orderBy('components.name', 'ASC')
            ->get();

        $availableComponents = [];

        foreach ($components as $comp) {
            $checkedOut = DB::table('components_assets')
                ->where('component_id', $comp->id)
                ->sum('assigned_qty');
            $comp->remaining_qty = max(0, $comp->qty - $checkedOut);

            // Filter HANYA komponen yang stoknya > 0
            if ($comp->remaining_qty > 0) {
                $availableComponents[] = $comp;
            }
        }

        return response()->json($availableComponents);
    }

    /**
     * AJAX Action: Selesaikan Upgrade (Update Spec, Checkout Component, & Create Maintenance Log)
     */
    public function completeUpgrade(Request $request)
    {
        $assetId = $request->input('asset_id');
        $newProcessor = $request->input('new_processor');
        $newRam = $request->input('new_ram');
        $cost = $request->input('cost') ?: 0;
        $notes = $request->input('notes') ?: 'Selesai upgrade hardware CPU & spesifikasi baru';
        $selectedComponents = $request->input('components', []);

        if (!$assetId) {
            return response()->json(['success' => false, 'message' => 'Asset ID wajib diisi!'], 400);
        }

        $asset = Asset::find($assetId);
        if (!$asset) {
            return response()->json(['success' => false, 'message' => 'Asset tidak ditemukan!'], 404);
        }

        $oldProcessor = $asset->_snipeit_jenis_processor_12 ?: '-';
        $oldRam = $asset->_snipeit_jenis_ram_5 ?: '-';

        // 1. Update Spesifikasi Aset (Trigger AssetObserver -> Log di action_logs otomatis)
        if ($newProcessor) {
            $asset->_snipeit_jenis_processor_12 = $newProcessor;
        }
        if ($newRam) {
            $asset->_snipeit_jenis_ram_5 = $newRam;
        }

        $asset->status_id = 4; // Reset kembali ke Asset Terpasang (Deployable)
        $asset->save();

        // 2. Checkout Komponen dari Stok Snipe-IT + Transaksi Action Logs
        $componentSummary = [];
        $userId = auth()->user() ? auth()->user()->id : 2;
        $now = date('Y-m-d H:i:s');

        if (!empty($selectedComponents) && is_array($selectedComponents)) {
            foreach ($selectedComponents as $c) {
                $compId = (int)($c['id'] ?? 0);
                $qty = (int)($c['qty'] ?? 1);
                if ($compId > 0 && $qty > 0) {
                    $comp = DB::table('components')->where('id', $compId)->first();
                    if ($comp) {
                        // Insert pivot checkout
                        DB::table('components_assets')->insert([
                            'component_id' => $compId,
                            'asset_id' => $assetId,
                            'assigned_qty' => $qty,
                            'created_by' => $userId,
                            'note' => 'Pemasangan komponen upgrade hardware untuk asset ' . $asset->asset_tag,
                            'created_at' => $now,
                            'updated_at' => $now
                        ]);

                        // Insert standard Snipe-IT action_logs for Component Checkout
                        DB::table('action_logs')->insert([
                            'created_by' => $userId,
                            'action_type' => 'checkout to asset',
                            'item_type' => 'App\\Models\\Component',
                            'item_id' => $compId,
                            'target_type' => 'App\\Models\\Asset',
                            'target_id' => $assetId,
                            'quantity' => $qty,
                            'note' => 'Checkout komponen upgrade hardware untuk asset ' . $asset->asset_tag,
                            'company_id' => $asset->company_id,
                            'action_date' => $now,
                            'action_source' => 'gui',
                            'created_at' => $now,
                            'updated_at' => $now
                        ]);

                        $codeStr = $comp->serial ? ' (' . $comp->serial . ')' : '';
                        $componentSummary[] = $comp->name . $codeStr . ' - ' . $qty . ' Pcs';
                    }
                }
            }
        }

        // 3. Catat Maintenance Log Otomatis (Double-Update Rule 18)
        $assignedUser = $asset->assignedTo ? $asset->assignedTo->first_name . ' ' . $asset->assignedTo->last_name : 'No User';
        $compText = !empty($componentSummary) ? "\nKomponen Dipasang: " . implode(', ', $componentSummary) : '';
        $maintNote = "Selesai Upgrade Hardware.\nPerubahan CPU: {$oldProcessor} ➔ {$newProcessor}\nPerubahan RAM: {$oldRam} ➔ {$newRam}{$compText}\nCatatan: {$notes}";

        DB::table('maintenances')->insert([
            'asset_id' => $assetId,
            'supplier_id' => 2, // INTERN - PT BESTARI MULIA
            'asset_maintenance_type' => 'Hardware Upgrade',
            'name' => 'Selesai Upgrade Hardware - ' . $asset->asset_tag . ' (' . trim($assignedUser) . ')',
            'is_warranty' => 0,
            'start_date' => date('Y-m-d'),
            'completion_date' => date('Y-m-d'),
            'cost' => $cost,
            'notes' => $maintNote,
            'created_by' => $userId,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        return response()->json([
            'success' => true,
            'asset_id' => $assetId,
            'asset_tag' => $asset->asset_tag,
            'new_processor' => $asset->_snipeit_jenis_processor_12,
            'message' => 'Aset ' . $asset->asset_tag . ' berhasil dinyatakan Selesai Upgrade! Spesifikasi ter-update, komponen ter-checkout ke Action Logs, dan Laporan Maintenance telah dicatat.'
        ]);
    }

    /**
     * Sub-Menu: Halaman Laporan & Progress Upgrade (Tracking & Snapshots)
     */
    public function progressReport(Request $request)
    {
        $prefix = DB::getTablePrefix();

        $baseQuery = DB::table('assets')
            ->leftJoin('models', 'assets.model_id', '=', 'models.id')
            ->leftJoin('categories', 'models.category_id', '=', 'categories.id')
            ->whereNull('assets.deleted_at')
            ->where(function($q) {
                $q->where('_snipeit_jenis_processor_12', 'LIKE', '%Intel%')
                  ->orWhere('_snipeit_jenis_processor_12', 'LIKE', '%intel%')
                  ->orWhere('_snipeit_jenis_processor_12', 'LIKE', '%Pentium%')
                  ->orWhere('_snipeit_jenis_processor_12', 'LIKE', '%Celeron%')
                  ->orWhere('_snipeit_jenis_processor_12', 'LIKE', '%Atom%');
            })
            ->where(function($q) {
                $q->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%Core%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%core%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%i3%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%i5%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%i7%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%i9%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%Xeon%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%xeon%');
            })
            ->where(function($q) {
                $q->where('categories.name', 'NOT LIKE', '%LAPTOP%')
                  ->where('categories.name', 'NOT LIKE', '%laptop%')
                  ->orWhereNull('categories.name');
            });

        $totalNonCore = (clone $baseQuery)->count();
        $totalScheduled = (clone $baseQuery)->where('assets.status_id', 17)->count();

        $snapshots = $this->getSnapshots();
        $initialTarget = !empty($snapshots) ? $snapshots[0]['total_target'] : 57;
        
        $completedCount = max(0, $initialTarget - $totalNonCore);
        $remainingCount = $totalNonCore;
        $progressPercent = $initialTarget > 0 ? round(($completedCount / $initialTarget) * 100, 1) : 0;

        $scheduledAssets = DB::table('assets')
            ->leftJoin('models', 'assets.model_id', '=', 'models.id')
            ->leftJoin('categories', 'models.category_id', '=', 'categories.id')
            ->leftJoin('companies', 'assets.company_id', '=', 'companies.id')
            ->leftJoin('locations', 'assets.location_id', '=', 'locations.id')
            ->leftJoin('status_labels', 'assets.status_id', '=', 'status_labels.id')
            ->leftJoin('users', function($join) {
                $join->on('assets.assigned_to', '=', 'users.id')
                     ->where('assets.assigned_type', '=', 'App\\Models\\User');
            })
            ->whereNull('assets.deleted_at')
            ->where('assets.status_id', 17)
            ->select(
                'assets.id',
                'assets.asset_tag',
                'assets.name as asset_name',
                'assets._snipeit_jenis_processor_12 as processor',
                'assets._snipeit_jenis_ram_5 as ram',
                'models.name as model_name',
                'categories.name as category_name',
                'companies.name as company_name',
                'locations.name as location_name',
                DB::raw("CONCAT(" . $prefix . "users.first_name, ' ', COALESCE(" . $prefix . "users.last_name, '')) as assigned_user")
            )
            ->orderBy('companies.name', 'ASC')
            ->orderBy('assets.asset_tag', 'ASC')
            ->get();

        return view('analisa.progress_report', compact(
            'totalNonCore',
            'totalScheduled',
            'initialTarget',
            'completedCount',
            'remainingCount',
            'progressPercent',
            'scheduledAssets',
            'snapshots'
        ));
    }

    /**
     * AJAX: Ambil & Simpan Snapshot Progress Baru
     */
    public function createSnapshot(Request $request)
    {
        $title = $request->input('title') ?: 'Snapshot Progress Upgrade ' . date('d M Y');
        $notes = $request->input('notes') ?: 'Snapshot otomatis kemajuan upgrade hardware';

        $prefix = DB::getTablePrefix();

        $baseQuery = DB::table('assets')
            ->leftJoin('models', 'assets.model_id', '=', 'models.id')
            ->leftJoin('categories', 'models.category_id', '=', 'categories.id')
            ->whereNull('assets.deleted_at')
            ->where(function($q) {
                $q->where('_snipeit_jenis_processor_12', 'LIKE', '%Intel%')
                  ->orWhere('_snipeit_jenis_processor_12', 'LIKE', '%intel%')
                  ->orWhere('_snipeit_jenis_processor_12', 'LIKE', '%Pentium%')
                  ->orWhere('_snipeit_jenis_processor_12', 'LIKE', '%Celeron%')
                  ->orWhere('_snipeit_jenis_processor_12', 'LIKE', '%Atom%');
            })
            ->where(function($q) {
                $q->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%Core%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%core%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%i3%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%i5%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%i7%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%i9%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%Xeon%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%xeon%');
            })
            ->where(function($q) {
                $q->where('categories.name', 'NOT LIKE', '%LAPTOP%')
                  ->where('categories.name', 'NOT LIKE', '%laptop%')
                  ->orWhereNull('categories.name');
            });

        $totalNonCore = (clone $baseQuery)->count();
        $totalScheduled = (clone $baseQuery)->where('assets.status_id', 17)->count();

        $snapshots = $this->getSnapshots();
        $initialTarget = !empty($snapshots) ? $snapshots[0]['total_target'] : $totalNonCore;
        $completedCount = max(0, $initialTarget - $totalNonCore);
        $progressPercent = $initialTarget > 0 ? round(($completedCount / $initialTarget) * 100, 1) : 0;

        $newSnapshot = [
            'id' => uniqid('snap_'),
            'date' => date('Y-m-d H:i:s'),
            'title' => $title,
            'notes' => $notes,
            'total_target' => $initialTarget,
            'total_remaining' => $totalNonCore,
            'total_scheduled' => $totalScheduled,
            'total_completed' => $completedCount,
            'progress_percent' => $progressPercent,
            'created_by' => auth()->user() ? auth()->user()->first_name . ' ' . auth()->user()->last_name : 'Bakhtiyar Sierad'
        ];

        array_unshift($snapshots, $newSnapshot);
        $this->saveSnapshots($snapshots);

        return response()->json([
            'success' => true,
            'snapshot' => $newSnapshot,
            'message' => 'Snapshot progress berhasil disimpan!'
        ]);
    }

    /**
     * AJAX: Hapus Snapshot
     */
    public function deleteSnapshot(Request $request)
    {
        $snapshotId = $request->input('id');
        $snapshots = $this->getSnapshots();

        $filtered = array_values(array_filter($snapshots, function($s) use ($snapshotId) {
            return $s['id'] !== $snapshotId;
        }));

        $this->saveSnapshots($filtered);

        return response()->json([
            'success' => true,
            'message' => 'Snapshot berhasil dihapus!'
        ]);
    }

    /**
     * Generate & Cetak Laporan Formal (A4 Landscape)
     */
    public function printReport(Request $request)
    {
        $prefix = DB::getTablePrefix();

        $scheduledAssets = DB::table('assets')
            ->leftJoin('models', 'assets.model_id', '=', 'models.id')
            ->leftJoin('categories', 'models.category_id', '=', 'categories.id')
            ->leftJoin('companies', 'assets.company_id', '=', 'companies.id')
            ->leftJoin('locations', 'assets.location_id', '=', 'locations.id')
            ->leftJoin('status_labels', 'assets.status_id', '=', 'status_labels.id')
            ->leftJoin('users', function($join) {
                $join->on('assets.assigned_to', '=', 'users.id')
                     ->where('assets.assigned_type', '=', 'App\\Models\\User');
            })
            ->whereNull('assets.deleted_at')
            ->where('assets.status_id', 17)
            ->select(
                'assets.id',
                'assets.asset_tag',
                'assets.name as asset_name',
                'assets._snipeit_jenis_processor_12 as processor',
                'assets._snipeit_jenis_ram_5 as ram',
                'models.name as model_name',
                'categories.name as category_name',
                'companies.name as company_name',
                'locations.name as location_name',
                DB::raw("CONCAT(" . $prefix . "users.first_name, ' ', COALESCE(" . $prefix . "users.last_name, '')) as assigned_user")
            )
            ->orderBy('companies.name', 'ASC')
            ->orderBy('assets.asset_tag', 'ASC')
            ->get();

        $baseQuery = DB::table('assets')
            ->leftJoin('models', 'assets.model_id', '=', 'models.id')
            ->leftJoin('categories', 'models.category_id', '=', 'categories.id')
            ->whereNull('assets.deleted_at')
            ->where(function($q) {
                $q->where('_snipeit_jenis_processor_12', 'LIKE', '%Intel%')
                  ->orWhere('_snipeit_jenis_processor_12', 'LIKE', '%intel%')
                  ->orWhere('_snipeit_jenis_processor_12', 'LIKE', '%Pentium%')
                  ->orWhere('_snipeit_jenis_processor_12', 'LIKE', '%Celeron%')
                  ->orWhere('_snipeit_jenis_processor_12', 'LIKE', '%Atom%');
            })
            ->where(function($q) {
                $q->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%Core%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%core%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%i3%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%i5%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%i7%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%i9%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%Xeon%')
                  ->where('_snipeit_jenis_processor_12', 'NOT LIKE', '%xeon%');
            })
            ->where(function($q) {
                $q->where('categories.name', 'NOT LIKE', '%LAPTOP%')
                  ->where('categories.name', 'NOT LIKE', '%laptop%')
                  ->orWhereNull('categories.name');
            });

        $totalNonCore = (clone $baseQuery)->count();
        $totalScheduled = (clone $baseQuery)->where('assets.status_id', 17)->count();

        $snapshots = $this->getSnapshots();
        $initialTarget = !empty($snapshots) ? $snapshots[0]['total_target'] : 57;
        $completedCount = max(0, $initialTarget - $totalNonCore);
        $progressPercent = $initialTarget > 0 ? round(($completedCount / $initialTarget) * 100, 1) : 0;

        return view('analisa.print_report', compact(
            'scheduledAssets',
            'totalNonCore',
            'totalScheduled',
            'initialTarget',
            'completedCount',
            'progressPercent'
        ));
    }
}

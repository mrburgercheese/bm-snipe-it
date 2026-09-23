<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Rencana & Progress Upgrade Hardware IT - A4 Landscape</title>
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/font-awesome.min.css') }}">
    <style>
        @page {
            size: A4 landscape;
            margin: 12mm 15mm 15mm 15mm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10pt;
            color: #222;
            line-height: 1.4;
            background-color: #e9ecef;
            margin: 0;
            padding: 0;
        }
        .page-container {
            max-width: 1050px;
            margin: 25px auto;
            padding: 35px 40px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.12);
            border: 1px solid #dcdcdc;
        }
        .header-table {
            width: 100%;
            border-bottom: 3px double #333;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .company-title {
            font-size: 16pt;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #111;
        }
        .doc-title {
            font-size: 13pt;
            font-weight: bold;
            color: #0071c5;
            margin-top: 4px;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 20px;
            font-size: 9.5pt;
            background-color: #f8f9fa;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 8px 12px;
        }
        .meta-table td {
            padding: 4px 6px;
        }
        .summary-box-container {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 25px;
        }
        .summary-box {
            flex: 1;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 10px 14px;
            text-align: center;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.03);
        }
        .summary-box .num {
            font-size: 20pt;
            font-weight: 800;
            color: #0071c5;
            line-height: 1.1;
        }
        .summary-box .lbl {
            font-size: 8.5pt;
            color: #64748b;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 4px;
        }
        table.report-data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            font-size: 9.5pt;
        }
        table.report-data th {
            background-color: #0071c5 !important;
            color: #ffffff !important;
            border: 1px solid #005696;
            padding: 8px 10px;
            text-align: left;
            font-weight: bold;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        table.report-data td {
            border: 1px solid #cbd5e1;
            padding: 7px 10px;
        }
        table.report-data tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .footer-note {
            margin-top: 30px;
            border-top: 1px solid #cbd5e1;
            padding-top: 10px;
            font-size: 9pt;
            color: #64748b;
            text-align: right;
            font-style: italic;
        }
        .no-print-bar {
            background-color: #1e293b;
            color: #fff;
            padding: 12px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        .no-print-bar button {
            background-color: #2563eb;
            color: #fff;
            border: none;
            padding: 9px 20px;
            font-size: 11pt;
            cursor: pointer;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.2s;
        }
        .no-print-bar button:hover {
            background-color: #1d4ed8;
        }
        @media print {
            body {
                background-color: #ffffff !important;
            }
            .no-print-bar {
                display: none !important;
            }
            .page-container {
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                border: none !important;
            }
        }
    </style>
</head>
<body>

<div class="no-print-bar">
    <div style="font-weight: bold; font-size: 11pt;">
        <i class="fa fa-file-text-o"></i> Preview Laporan Formal (A4 Landscape Standar IT)
    </div>
    <div>
        <button onclick="window.print()">
            <i class="fa fa-print"></i> Cetak Laporan (Print / PDF)
        </button>
    </div>
</div>

<div class="page-container">

    <table class="header-table">
        <tr>
            <td style="width: 65%;">
                <div class="company-title">PT BESTARI MULIA</div>
                <div class="doc-title">LAPORAN FORMAL PENJADWALAN & PROGRESS UPGRADE HARDWARE IT</div>
                <div style="font-size: 9pt; color: #64748b; margin-top: 3px;">
                    Dokumen Manajemen Inventaris Aset IT - Format A4 Landscape
                </div>
            </td>
            <td style="width: 35%; text-align: right; font-size: 8.5pt; color: #475569; line-height: 1.5;">
                <strong>No. Dokumen:</strong> RPT-IT-UPG-{{ date('Ym') }}<br>
                <strong>Tanggal Cetak:</strong> {{ date('d F Y H:i') }} WIB<br>
                <strong>Pencetak:</strong> {{ auth()->user() ? auth()->user()->first_name . ' ' . auth()->user()->last_name : 'Bakhtiyar Sierad (IT Dept)' }}
            </td>
        </tr>
    </table>

    <table class="meta-table">
        <tr>
            <td style="width: 15%;"><strong>Kategori Hardware:</strong></td>
            <td style="width: 35%;">PC Desktop Intel Non-Core (Excl. Laptop & Xeon)</td>
            <td style="width: 15%;"><strong>Progress Kemajuan:</strong></td>
            <td style="width: 35%; font-weight: bold; color: #16a34a;">{{ $progressPercent }}% Selesai ({{ $completedCount }} dari {{ $initialTarget }} Unit)</td>
        </tr>
    </table>

    <div class="summary-box-container">
        <div class="summary-box">
            <div class="num">{{ number_format($initialTarget) }}</div>
            <div class="lbl">Target Awal PC Non-Core</div>
        </div>
        <div class="summary-box" style="border-color: #9333ea;">
            <div class="num" style="color: #9333ea;">{{ number_format($totalScheduled) }}</div>
            <div class="lbl">Terjadwal Upgrade</div>
        </div>
        <div class="summary-box" style="border-color: #16a34a;">
            <div class="num" style="color: #16a34a;">{{ number_format($completedCount) }}</div>
            <div class="lbl">Selesai Di-Upgrade</div>
        </div>
        <div class="summary-box" style="border-color: #dc2626;">
            <div class="num" style="color: #dc2626;">{{ number_format($totalNonCore) }}</div>
            <div class="lbl">Sisa Belum Upgrade</div>
        </div>
    </div>

    <h4 style="margin-bottom: 10px; font-size: 11pt; color: #0071c5; text-transform: uppercase;">
        Daftar Perangkat Berstatus "Terjadwal Upgrade" ({{ count($scheduledAssets) }} Unit)
    </h4>

    <table class="report-data">
        <thead>
            <tr>
                <th style="width: 35px; text-align: center;">NO</th>
                <th style="width: 120px;">ASSET TAG</th>
                <th>NAMA PERANGKAT</th>
                <th>PEMAKAI (ASSIGNED USER)</th>
                <th>PERUSAHAAN</th>
                <th>LOKASI</th>
                <th>SPESIFIKASI CPU ASAL</th>
                <th style="width: 60px;">RAM</th>
                <th style="width: 120px; text-align: center;">STATUS TARGET</th>
            </tr>
        </thead>
        <tbody>
            @forelse($scheduledAssets as $idx => $asset)
            <tr>
                <td style="text-align: center;">{{ $idx + 1 }}</td>
                <td style="font-weight: bold; font-family: monospace; font-size: 10pt;">{{ $asset->asset_tag }}</td>
                <td>{{ $asset->asset_name ?: '-' }}</td>
                <td>{{ trim($asset->assigned_user) ?: 'Belum Ditugaskan' }}</td>
                <td>{{ $asset->company_name ?: 'No Company' }}</td>
                <td>{{ $asset->location_name ?: '-' }}</td>
                <td>{{ $asset->processor ?: '-' }}</td>
                <td>{{ $asset->ram ? trim($asset->ram) : '-' }}</td>
                <td style="text-align: center; font-weight: bold; color: #9333ea;">
                    Terjadwal Upgrade
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align: center; padding: 20px; color: #64748b;">
                    Belum ada aset berstatus "Terjadwal Upgrade" yang didaftarkan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer-note">
        Generated Report by bmsnipeit — {{ date('d F Y H:i:s') }} WIB
    </div>

</div>

</body>
</html>

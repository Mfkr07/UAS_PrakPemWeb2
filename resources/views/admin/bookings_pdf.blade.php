<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Rekapitulasi Pendapatan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .total-row th {
            text-align: right;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Rekapitulasi Pendapatan</h1>
        <p>Warnet / Game Center</p>
        <p>Tanggal Cetak: {{ now()->format('d M Y, H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID Order</th>
                <th>Penyewa</th>
                <th>Rig / PC</th>
                <th>Durasi</th>
                <th>Mulai</th>
                <th>Selesai</th>
                <th>Status</th>
                <th class="text-right">Total Tarif</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach($bookings as $booking)
                @php $grandTotal += $booking->total_price; @endphp
                <tr>
                    <td>#WA-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $booking->user->name ?? 'Guest' }}</td>
                    <td>{{ $booking->computer->name ?? '-' }}</td>
                    <td>{{ $booking->duration_hours }} Jam</td>
                    <td>{{ $booking->start_time ? $booking->start_time->format('d/m/Y H:i') : '-' }}</td>
                    <td>{{ $booking->end_time ? $booking->end_time->format('d/m/Y H:i') : '-' }}</td>
                    <td>{{ ucfirst($booking->status) }}</td>
                    <td class="text-right">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <th colspan="7">Total Keseluruhan Pendapatan</th>
                <th class="text-right">Rp {{ number_format($grandTotal, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

</body>
</html>

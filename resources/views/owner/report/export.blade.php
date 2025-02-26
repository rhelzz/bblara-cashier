<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Transaksi Tunai</th>
            <th>Transaksi QRIS</th>
            <th>Total Transaksi</th>
            <th>Modal (Rp)</th>
            <th>Pendapatan (Rp)</th>
            <th>Keuntungan (Rp)</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dailyReports as $report)
        <tr>
            <td>{{ $report['tanggal'] }}</td>
            <td>{{ $report['transaksi_tunai_count'] }}</td>
            <td>{{ $report['transaksi_qris_count'] }}</td>
            <td>{{ $report['total_transaksi'] }}</td>
            <td>{{ number_format($report['modal'], 0, ',', '.') }}</td>
            <td>{{ number_format($report['pendapatan'], 0, ',', '.') }}</td>
            <td>{{ number_format($report['keuntungan'], 0, ',', '.') }}</td>
        </tr>
        @endforeach
        <tr>
            <td><strong>TOTAL</strong></td>
            <td><strong>{{ $totalData['total_transaksi_tunai'] }}</strong></td>
            <td><strong>{{ $totalData['total_transaksi_qris'] }}</strong></td>
            <td><strong>{{ $totalData['total_transaksi'] }}</strong></td>
            <td><strong>{{ number_format($totalData['total_modal'], 0, ',', '.') }}</strong></td>
            <td><strong>{{ number_format($totalData['total_pendapatan'], 0, ',', '.') }}</strong></td>
            <td><strong>{{ number_format($totalData['total_keuntungan'], 0, ',', '.') }}</strong></td>
        </tr>
    </tbody>
</table>
<table>
    <tr>
        <td colspan="7">Laporan Pendapatan: {{ $startDate }} hingga {{ $endDate }}</td>
    </tr>
</table>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendapatan Harian - Bblara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Raleway', sans-serif;
        }
        .nav-text {
            position: relative;
            display: inline-block;
        }
        .nav-text::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: #e17f12;
            transition: width 0.2s ease-in-out;
        }
        .hover-link:hover .nav-text::after {
            width: 100%;
        }
        .stats-card {
            transition: transform 0.2s ease-in-out;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <button class="fixed text-white text-3xl top-5 left-4 p-2 rounded-md bg-gray-700 lg:hidden focus:outline-none z-50" onclick="toggleSidebar()">
            <i class="bi bi-list"></i>
        </button>
        <x-navbar-owner></x-navbar-owner>
        <div class="flex-1 lg:w-5/6">
            <x-navbar-top-owner></x-navbar-top-owner>
            
            <div class="p-6 lg:p-8">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-3xl font-bold text-gray-800">Laporan Pendapatan Harian</h1>
                    <div class="flex space-x-2">
                        <a href="{{ route('owner.report.index') }}" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>

                <!-- Date Range Filter -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Pilih Rentang Tanggal</h2>
                    <form action="{{ route('owner.report.daily-income') }}" method="GET" class="flex flex-col md:flex-row items-end space-y-4 md:space-y-0 md:space-x-4">
                        <div class="w-full md:w-1/3">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Dari Tanggal</label>
                            <input type="date" name="startDate" value="{{ $startDate }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="w-full md:w-1/3">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Sampai Tanggal</label>
                            <input type="date" name="endDate" value="{{ $endDate }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="w-full md:w-1/3 flex space-x-2">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline flex items-center">
                                <i class="bi bi-search me-2"></i> Tampilkan
                            </button>
                            <a href="{{ route('owner.report.export-excel') }}?startDate={{ $startDate }}&endDate={{ $endDate }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline flex items-center">
                                <i class="bi bi-file-earmark-excel me-2"></i> Export Excel
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <!-- Total Modal Card -->
                    <div class="stats-card bg-gradient-to-r from-red-500 to-red-600 rounded-xl shadow-lg p-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-white text-lg">Total Modal</p>
                                <h3 class="text-white text-3xl font-bold">Rp {{ number_format($totalData['total_modal'], 0, ',', '.') }}</h3>
                                <p class="text-red-100 mt-2">{{ $startDate }} - {{ $endDate }}</p>
                            </div>
                            <div class="bg-white/20 p-4 rounded-lg">
                                <i class="bi bi-cash-stack text-4xl text-white"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Total Pendapatan Card -->
                    <div class="stats-card bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-white text-lg">Total Pendapatan</p>
                                <h3 class="text-white text-3xl font-bold">Rp {{ number_format($totalData['total_pendapatan'], 0, ',', '.') }}</h3>
                                <p class="text-blue-100 mt-2">{{ $startDate }} - {{ $endDate }}</p>
                            </div>
                            <div class="bg-white/20 p-4 rounded-lg">
                                <i class="bi bi-wallet2 text-4xl text-white"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Total Keuntungan Card -->
                    <div class="stats-card bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-lg p-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-white text-lg">Total Keuntungan</p>
                                <h3 class="text-white text-3xl font-bold">Rp {{ number_format($totalData['total_keuntungan'], 0, ',', '.') }}</h3>
                                <p class="text-green-100 mt-2">{{ $startDate }} - {{ $endDate }}</p>
                            </div>
                            <div class="bg-white/20 p-4 rounded-lg">
                                <i class="bi bi-graph-up-arrow text-4xl text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transactions Card -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <!-- Tunai Transactions -->
                    <div class="stats-card bg-white rounded-xl shadow-lg p-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-gray-600 text-lg">Transaksi Tunai</p>
                                <h3 class="text-gray-800 text-3xl font-bold">{{ $totalData['total_transaksi_tunai'] }}</h3>
                                <p class="text-gray-500 mt-2">transaksi</p>
                            </div>
                            <div class="bg-blue-100 p-4 rounded-lg text-blue-600">
                                <i class="bi bi-cash text-4xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- QRIS Transactions -->
                    <div class="stats-card bg-white rounded-xl shadow-lg p-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-gray-600 text-lg">Transaksi QRIS</p>
                                <h3 class="text-gray-800 text-3xl font-bold">{{ $totalData['total_transaksi_qris'] }}</h3>
                                <p class="text-gray-500 mt-2">transaksi</p>
                            </div>
                            <div class="bg-purple-100 p-4 rounded-lg text-purple-600">
                                <i class="bi bi-qr-code text-4xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Total Transactions -->
                    <div class="stats-card bg-white rounded-xl shadow-lg p-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-gray-600 text-lg">Total Transaksi</p>
                                <h3 class="text-gray-800 text-3xl font-bold">{{ $totalData['total_transaksi'] }}</h3>
                                <p class="text-gray-500 mt-2">transaksi</p>
                            </div>
                            <div class="bg-orange-100 p-4 rounded-lg text-orange-600">
                                <i class="bi bi-cart-check text-4xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Table -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-semibold mb-4">Rincian Pendapatan Harian</h2>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-3 px-4 border-b text-left">Tanggal</th>
                                    <th class="py-3 px-4 border-b text-right">Trans. Tunai</th>
                                    <th class="py-3 px-4 border-b text-right">Trans. QRIS</th>
                                    <th class="py-3 px-4 border-b text-right">Total Trans.</th>
                                    <th class="py-3 px-4 border-b text-right">Modal (Rp)</th>
                                    <th class="py-3 px-4 border-b text-right">Pendapatan (Rp)</th>
                                    <th class="py-3 px-4 border-b text-right">Keuntungan (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dailyReports as $report)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 border-b">{{ $report['tanggal'] }}</td>
                                    <td class="py-3 px-4 border-b text-right">{{ $report['transaksi_tunai_count'] }}</td>
                                    <td class="py-3 px-4 border-b text-right">{{ $report['transaksi_qris_count'] }}</td>
                                    <td class="py-3 px-4 border-b text-right">{{ $report['total_transaksi'] }}</td>
                                    <td class="py-3 px-4 border-b text-right">{{ number_format($report['modal'], 0, ',', '.') }}</td>
                                    <td class="py-3 px-4 border-b text-right">{{ number_format($report['pendapatan'], 0, ',', '.') }}</td>
                                    <td class="py-3 px-4 border-b text-right">{{ number_format($report['keuntungan'], 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-100 font-semibold">
                                <tr>
                                    <td class="py-3 px-4 border-b">TOTAL</td>
                                    <td class="py-3 px-4 border-b text-right">{{ $totalData['total_transaksi_tunai'] }}</td>
                                    <td class="py-3 px-4 border-b text-right">{{ $totalData['total_transaksi_qris'] }}</td>
                                    <td class="py-3 px-4 border-b text-right">{{ $totalData['total_transaksi'] }}</td>
                                    <td class="py-3 px-4 border-b text-right">{{ number_format($totalData['total_modal'], 0, ',', '.') }}</td>
                                    <td class="py-3 px-4 border-b text-right">{{ number_format($totalData['total_pendapatan'], 0, ',', '.') }}</td>
                                    <td class="py-3 px-4 border-b text-right">{{ number_format($totalData['total_keuntungan'], 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('x-navbar-owner');
            sidebar.classList.toggle('hidden');
        }
    </script>
</body>
</html>
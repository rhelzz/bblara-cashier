<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perbandingan Transaksi - Bblara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        .chart-container {
            position: relative;
            height: 300px;
            margin: auto;
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
                    <h1 class="text-3xl font-bold text-gray-800">Perbandingan Transaksi</h1>
                    <div class="flex space-x-2">
                        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="bi bi-download me-2"></i>Export
                        </button>
                    </div>
                </div>

                <!-- Payment Method Comparison Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Chart Card -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-xl font-semibold mb-4">Grafik Perbandingan Pembayaran</h2>
                        <div class="chart-container">
                            <canvas id="transactionChart"></canvas>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 gap-6">
                        <!-- QRIS Stats -->
                        <div class="stats-card bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl shadow-lg p-6">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-white text-lg">Total QRIS</p>
                                    <h3 class="text-white text-3xl font-bold">{{ $qrisCount }}</h3>
                                    <p class="text-purple-100 mt-2">Transaksi</p>
                                </div>
                                <div class="bg-white/20 p-4 rounded-lg">
                                    <i class="bi bi-qr-code text-4xl text-white"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Cash Stats -->
                        <div class="stats-card bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-6">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-white text-lg">Total Tunai</p>
                                    <h3 class="text-white text-3xl font-bold">{{ $tunaiCount }}</h3>
                                    <p class="text-blue-100 mt-2">Transaksi</p>
                                </div>
                                <div class="bg-white/20 p-4 rounded-lg">
                                    <i class="bi bi-cash text-4xl text-white"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Summary Card -->
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-xl font-semibold mb-4">Kesimpulan</h3>
                            <div class="flex items-center">
                                <i class="bi bi-trophy-fill text-yellow-500 text-3xl mr-4"></i>
                                <p class="text-lg">
                                    @if($qrisCount > $tunaiCount)
                                        <span class="font-semibold text-purple-600">QRIS</span> adalah metode pembayaran terpopuler dengan {{ $qrisCount }} transaksi
                                    @elseif($tunaiCount > $qrisCount)
                                        <span class="font-semibold text-blue-600">Tunai</span> adalah metode pembayaran terpopuler dengan {{ $tunaiCount }} transaksi
                                    @else
                                        QRIS dan Tunai memiliki jumlah yang sama yaitu {{ $qrisCount }} transaksi
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Best Seller Section -->
                <div class="mt-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Menu Best Seller</h2>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Best Seller Chart -->
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-xl font-semibold mb-4">Top 5 Menu Terlaris</h3>
                            <div class="chart-container">
                                <canvas id="bestSellerChart"></canvas>
                            </div>
                        </div>

                        <!-- Best Seller Cards -->
                        <div class="grid grid-cols-1 gap-4">
                            @foreach($bestSellersWithPercentage as $menu => $data)
                            <div class="stats-card bg-white rounded-xl shadow-lg p-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="bg-gradient-to-r from-orange-400 to-orange-500 p-3 rounded-lg">
                                            <i class="bi bi-cup-hot text-2xl text-white"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-semibold">{{ $menu }}</h4>
                                            <p class="text-gray-600">Terjual {{ $data['count'] }} kali</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-2xl font-bold text-orange-500">{{ $data['percentage'] }}%</span>
                                        <div class="w-24 bg-gray-200 rounded-full h-2 mt-2">
                                            <div class="bg-orange-500 rounded-full h-2" style="width: {{ $data['percentage'] }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
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

        // Payment Methods Chart
        const ctx = document.getElementById('transactionChart').getContext('2d');
        const transactionChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['QRIS', 'Tunai'],
                datasets: [{
                    label: 'Jumlah Transaksi',
                    data: [{{ $qrisCount }}, {{ $tunaiCount }}],
                    backgroundColor: [
                        'rgba(147, 51, 234, 0.8)',  // Purple for QRIS
                        'rgba(59, 130, 246, 0.8)'   // Blue for Cash
                    ],
                    borderColor: [
                        'rgba(147, 51, 234, 1)',
                        'rgba(59, 130, 246, 1)'
                    ],
                    borderWidth: 2,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            font: {
                                family: 'Raleway'
                            }
                        },
                        grid: {
                            display: true,
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                family: 'Raleway',
                                weight: 'bold'
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            family: 'Raleway',
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            family: 'Raleway',
                            size: 13
                        },
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.dataset.label + ': ' + tooltipItem.raw + ' Transaksi';
                            }
                        }
                    }
                }
            }
        });

        // Best Seller Chart
        const bestSellerCtx = document.getElementById('bestSellerChart').getContext('2d');
        const bestSellerChart = new Chart(bestSellerCtx, {
            type: 'doughnut',
            data: {
                labels: [@foreach($bestSellersWithPercentage as $menu => $data) '{{ $menu }}', @endforeach],
                datasets: [{
                    data: [@foreach($bestSellersWithPercentage as $data) {{ $data['count'] }}, @endforeach],
                    backgroundColor: [
                        'rgba(225, 127, 18, 0.8)',
                        'rgba(234, 88, 12, 0.8)',
                        'rgba(249, 115, 22, 0.8)',
                        'rgba(251, 146, 60, 0.8)',
                        'rgba(253, 186, 116, 0.8)'
                    ],
                    borderColor: [
                        'rgba(225, 127, 18, 1)',
                        'rgba(234, 88, 12, 1)',
                        'rgba(249, 115, 22, 1)',
                        'rgba(251, 146, 60, 1)',
                        'rgba(253, 186, 116, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            font: {
                                family: 'Raleway',
                                size: 12
                            },
                            padding: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            family: 'Raleway',
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            family: 'Raleway',
                            size: 13
                        },
                        callbacks: {
                            label: function(tooltipItem) {
                                const dataset = tooltipItem.dataset;
                                const total = dataset.data.reduce((acc, data) => acc + data, 0);
                                const value = dataset.data[tooltipItem.dataIndex];
                                const percentage = Math.round((value / total) * 100);
                                return `${tooltipItem.label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        function toggleDropdown(button) {
            const dropdownMenus = document.querySelectorAll(".dropdown-menu");
            const dropdownArrows = document.querySelectorAll("i.bi-chevron-down");

            dropdownMenus.forEach((menu) => {
                if (menu !== button.nextElementSibling) {
                    menu.classList.add("max-h-0");
                    menu.classList.remove("max-h-40");
                }
            });

            dropdownArrows.forEach((arrow) => {
                if (arrow !== button.querySelector("i.bi-chevron-down")) {
                    arrow.classList.remove("rotate-180");
                }
            });

            const dropdownMenu = button.nextElementSibling;
            const dropdownArrow = button.querySelector("i.bi-chevron-down");

            if (dropdownMenu.classList.contains("max-h-0")) {
                dropdownMenu.classList.remove("max-h-0");
                dropdownMenu.classList.add("max-h-40");
                dropdownArrow.classList.add("rotate-180");
            } else {
                dropdownMenu.classList.add("max-h-0");
                dropdownMenu.classList.remove("max-h-40");
                dropdownArrow.classList.remove("rotate-180");
            }
        }
    </script>
</body>
</html>
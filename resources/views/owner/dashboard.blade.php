<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Responsive Tailwind Sidebar</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap Icons CDN -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css"
    />
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
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
    </style>
  </head>
  <body class="bg-gray-100">
    <div class="flex">
      <!-- Toggle Button for Sidebar -->
      <button
        class="fixed text-white text-3xl top-5 left-4 p-2 rounded-md bg-gray-700 lg:hidden focus:outline-none z-50"
        onclick="toggleSidebar()"
      >
        <i class="bi bi-list"></i>
      </button>

      <!-- Sidebar -->
      <x-navbar-owner></x-navbar-owner>

      <!-- Main Content -->
      <div class="flex-1 lg:w-5/6">
        {{-- Navbar Top --}}
        <x-navbar-top-owner></x-navbar-top-owner>

        <!-- Content Wrapper -->
        <div class="p-4 lg:p-8">
          <!-- Full-width Container for Welcome Message -->
          <div class="bg-white p-4 mb-6 rounded-lg flex items-center shadow space-x-4">
            <i class="bi bi-person-circle text-4xl text-[#005281]"></i>
            <div>
              <h2 class="text-2xl font-semibold text-gray-700">Halo {{ ucfirst(Auth::user()->name) }}, selamat datang!</h2>
              <p class="text-gray-600">Ini adalah dashboard untuk melihat data real-time dan performa bisnis Anda. Silakan pilih rentang tanggal untuk melihat analisis lebih lanjut.</p>
            </div>
          </div>
          <div>
            <div class="bg-white p-4 rounded shadow mb-4">
              <div class="flex justify-between items-center">
                <div class="w-1/2 pl-2">
                  <label class="block text-gray-700">Tanggal Awal</label>
                  <input type="date" class="w-full p-2 border rounded" placeholder="16 Jan 2025 - 16 Jan 2025">
                </div>
                <div class="w-1/2 pl-2">
                  <label class="block text-gray-700">Tanggal Akhir</label>
                  <input type="date" class="w-full p-2 border rounded" placeholder="16 Jan 2025 - 16 Jan 2025">
                </div>
              </div>
            </div>

            <!-- Add Chart.js Combo Chart -->
            <div class="bg-white p-4 rounded shadow mb-4">
              <canvas id="comboChart" class="w-full h-64"></canvas>
            </div>

            <!-- Stats Cards -->
            <div class="flex justify-between space-x-4">
              <!-- Card 1: Total Modal -->
              <div class="w-1/3 bg-white p-4 rounded shadow flex flex-col items-start space-y-2">
                <div class="flex items-center">
                  <i class="bi bi-cart text-gray-500 mr-2"></i>
                  <h3 class="text-gray-700 font-semibold">Total Modal</h3>
                </div>
                <p class="text-green-500 text-sm">5% (+Rp2,500,000) dibanding kemarin</p>
                <p class="text-gray-500 text-sm">Rata-rata</p>
                <p class="text-gray-700 text-2xl">Rp50,000,000</p>
              </div>

              <!-- Card 2: Total Pendapatan -->
              <div class="w-1/3 bg-white p-4 rounded shadow flex flex-col items-start space-y-2">
                <div class="flex items-center">
                  <i class="bi bi-bar-chart text-gray-500 mr-2"></i>
                  <h3 class="text-gray-700 font-semibold">Total Pendapatan</h3>
                </div>
                <p class="text-green-500 text-sm">10% (+Rp5,000,000) dibanding kemarin</p>
                <p class="text-gray-500 text-sm">Rata-rata</p>
                <p class="text-gray-700 text-2xl">Rp55,000,000</p>
              </div>

              <!-- Card 3: Total Keuntungan -->
              <div class="w-1/3 bg-white p-4 rounded shadow flex flex-col items-start space-y-2">
                <div class="flex items-center">
                  <i class="bi bi-cash-stack text-gray-500 mr-2"></i>
                  <h3 class="text-gray-700 font-semibold">Total Keuntungan</h3>
                </div>
                <p class="text-green-500 text-sm">8% (+Rp2,000,000) dibanding kemarin</p>
                <p class="text-gray-500 text-sm">Rata-rata</p>
                <p class="text-gray-700 text-2xl">Rp27,000,000</p>
              </div>
            </div>
          </div>

        </div>
      </div>

      <!-- Scripts -->
      <script>
        function toggleDropdown(button) {
        const dropdownMenus = document.querySelectorAll(".dropdown-menu");
        const dropdownArrows = document.querySelectorAll("i.bi-chevron-down");
  
        // Tutup semua dropdown kecuali yang dipilih
        dropdownMenus.forEach((menu) => {
          if (menu !== button.nextElementSibling) {
            menu.classList.add("max-h-0");
            menu.classList.remove("max-h-40");
          }
        });
  
        // Atur semua panah kecuali yang dipilih
        dropdownArrows.forEach((arrow) => {
          if (arrow !== button.querySelector("i.bi-chevron-down")) {
            arrow.classList.remove("rotate-180");
          }
        });
  
        // Toggle dropdown yang dipilih
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
      <script>
        // Chart.js combo chart with pastel colors (Pink and Blue for bars, Bright Pastel Green for line)
        const ctx = document.getElementById('comboChart').getContext('2d');
        new Chart(ctx, {
          type: 'bar',
          data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [
              {
                label: 'Total Modal',
                data: [50000000, 52000000, 53000000, 55000000, 56000000, 57000000, 58000000, 59000000, 60000000, 61000000, 62000000, 63000000],
                backgroundColor: 'rgba(255, 182, 193, 0.6)', // Pastel Pink
                borderColor: 'rgba(255, 182, 193, 1)',
                borderWidth: 1
              },
              {
                label: 'Total Pendapatan',
                data: [55000000, 56000000, 57000000, 59000000, 60000000, 61000000, 62000000, 63000000, 64000000, 65000000, 66000000, 67000000],
                backgroundColor: 'rgba(173, 216, 230, 0.6)', // Pastel Blue
                borderColor: 'rgba(173, 216, 230, 1)',
                borderWidth: 1
              },
              {
                label: 'Total Keuntungan',
                type: 'line',
                data: [27000000, 28000000, 29000000, 30000000, 31000000, 32000000, 33000000, 34000000, 35000000, 36000000, 37000000, 38000000],
                borderColor: 'rgba(144, 238, 144, 1)', // Bright Pastel Green
                backgroundColor: 'rgba(144, 238, 144, 0.2)',
                borderWidth: 2,
                fill: true
              }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              x: {
                grid: {
                  display: false
                }
              },
              y: {
                beginAtZero: true,
                ticks: {
                  stepSize: 5000000 // Penjualan naik setiap 5 juta
                }
              }
            },
            plugins: {
              legend: {
                display: true,
                position: 'top'
              }
            }
          }
        });
      </script>
    </body>
</html>

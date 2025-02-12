<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Beranda - Bblara</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" />
    {{-- Font Cdn --}}
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600&display=swap" rel="stylesheet">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
      body{
        font-family: 'Raleway', sans-serif;
      }
      #progressBar {
        background-color: #005281;
        transition: width 0.4s ease-in-out;
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
          <!-- Welcome Message -->
          <div class="bg-white p-4 mb-6 rounded-lg flex items-center shadow space-x-4">
            <i class="bi bi-person-circle text-4xl text-[#005281]"></i>
            <div>
              <h2 class="text-2xl lg:text-xl font-semibold text-gray-700">
                Halo {{ ucfirst(Auth::user()->name) }}, Selamat Datang!
              </h2>
              <p class="text-gray-600 text-sm">
                Ini adalah dashboard untuk melihat data real-time dan performa bisnis Anda.
              </p>
            </div>
          </div>

          <!-- Date Range Selector -->
          <div class="bg-white p-4 rounded shadow mb-4">
            <div class="flex flex-col space-y-4">
              <!-- Preset Buttons -->
              <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-2">
                <button 
                  onclick="applyPreset('today')" 
                  data-preset="today"
                  class="px-4 py-2 text-sm font-medium text-white bg-[#005281] rounded-md hover:bg-[#003d61] focus:outline-none focus:ring-2 focus:ring-[#005281] focus:ring-opacity-50 transition-colors duration-200 ease-in-out group"
                >
                  Hari Ini
                </button>
                <button 
                  onclick="applyPreset('yesterday')" 
                  data-preset="yesterday"
                  class="px-4 py-2 text-sm font-medium text-white bg-[#005281] rounded-md hover:bg-[#003d61] focus:outline-none focus:ring-2 focus:ring-[#005281] focus:ring-opacity-50 transition-colors duration-200 ease-in-out"
                >
                  Kemarin
                </button>
                <button 
                  onclick="applyPreset('last7days')" 
                  data-preset="last7days"
                  class="px-4 py-2 text-sm font-medium text-white bg-[#005281] rounded-md hover:bg-[#003d61] focus:outline-none focus:ring-2 focus:ring-[#005281] focus:ring-opacity-50 transition-colors duration-200 ease-in-out"
                >
                  7 Hari Terakhir
                </button>
                <button 
                  onclick="applyPreset('last30days')" 
                  data-preset="last30days"
                  class="px-4 py-2 text-sm font-medium text-white bg-[#005281] rounded-md hover:bg-[#003d61] focus:outline-none focus:ring-2 focus:ring-[#005281] focus:ring-opacity-50 transition-colors duration-200 ease-in-out"
                >
                  30 Hari Terakhir
                </button>
                <button 
                  onclick="applyPreset('thisMonth')" 
                  data-preset="thisMonth"
                  class="px-4 py-2 text-sm font-medium text-white bg-[#005281] rounded-md hover:bg-[#003d61] focus:outline-none focus:ring-2 focus:ring-[#005281] focus:ring-opacity-50 transition-colors duration-200 ease-in-out"
                >
                  Bulan Ini
                </button>
                <button 
                  onclick="applyPreset('lastMonth')" 
                  data-preset="lastMonth"
                  class="px-4 py-2 text-sm font-medium text-white bg-[#005281] rounded-md hover:bg-[#003d61] focus:outline-none focus:ring-2 focus:ring-[#005281] focus:ring-opacity-50 transition-colors duration-200 ease-in-out"
                >
                  Bulan Lalu
                </button>
              </div>

              <!-- Custom Date Range -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-gray-700 text-sm font-medium mb-2">Tanggal Awal</label>
                  <input 
                    type="date" 
                    id="startDate" 
                    class="w-full p-2 border rounded focus:ring-2 focus:ring-[#005281] focus:border-transparent"
                    onchange="handleDateChange()"
                  >
                </div>
                <div>
                  <label class="block text-gray-700 text-sm font-medium mb-2">Tanggal Akhir</label>
                  <input 
                    type="date" 
                    id="endDate" 
                    class="w-full p-2 border rounded focus:ring-2 focus:ring-[#005281] focus:border-transparent"
                    onchange="handleDateChange()"
                  >
                </div>
              </div>
            </div>
          </div>

          <!-- Stats Cards -->
          <div class="stats-cards flex flex-wrap gap-4 mb-4">
            <!-- Card 1: Total Modal -->
            <div class="stats-card flex-1 min-w-[250px] bg-white p-4 rounded shadow">
              <div class="flex items-center mb-2">
                <i class="bi bi-cart text-gray-500 mr-2"></i>
                <h3 class="text-gray-700 font-semibold">Total Modal</h3>
              </div>
              <p id="modalPercentage" class="text-{{ $modalPercentage >= 0 ? 'green' : 'red' }}-500 text-sm mb-2">
                {{ number_format($modalPercentage, 1) }}% 
                ({{ $modalDiff >= 0 ? '+' : '' }}Rp{{ number_format($modalDiff, 0, ',', '.') }}) 
                dibanding periode sebelumnya
              </p>
              <p class="text-gray-500 text-sm">Total Modal</p>
              <p class="text-gray-700 text-2xl font-bold" id="totalModal">
                Rp{{ number_format($todayModal, 0, ',', '.') }}
              </p>
            </div>

            <!-- Card 2: Total Pendapatan -->
            <div class="stats-card flex-1 min-w-[250px] bg-white p-4 rounded shadow">
              <div class="flex items-center mb-2">
                <i class="bi bi-bar-chart text-gray-500 mr-2"></i>
                <h3 class="text-gray-700 font-semibold">Total Pendapatan</h3>
              </div>
              <p id="pendapatanPercentage" class="text-{{ $pendapatanPercentage >= 0 ? 'green' : 'red' }}-500 text-sm mb-2">
                {{ number_format($pendapatanPercentage, 1) }}% 
                ({{ $pendapatanDiff >= 0 ? '+' : '' }}Rp{{ number_format($pendapatanDiff, 0, ',', '.') }}) 
                dibanding periode sebelumnya
              </p>
              <p class="text-gray-500 text-sm">Total Pendapatan</p>
              <p class="text-gray-700 text-2xl font-bold" id="totalPendapatan">
                Rp{{ number_format($todayPendapatan, 0, ',', '.') }}
              </p>
            </div>

            <!-- Card 3: Total Keuntungan -->
            <div class="stats-card flex-1 min-w-[250px] bg-white p-4 rounded shadow">
              <div class="flex items-center mb-2">
                <i class="bi bi-cash-stack text-gray-500 mr-2"></i>
                <h3 class="text-gray-700 font-semibold">Total Keuntungan</h3>
              </div>
              <p id="keuntunganPercentage" class="text-{{ $keuntunganPercentage >= 0 ? 'green' : 'red' }}-500 text-sm mb-2">
                {{ number_format($keuntunganPercentage, 1) }}% 
                ({{ $keuntunganDiff >= 0 ? '+' : '' }}Rp{{ number_format($keuntunganDiff, 0, ',', '.') }}) 
                dibanding periode sebelumnya
              </p>
              <p class="text-gray-500 text-sm">Total Keuntungan</p>
              <p class="text-gray-700 text-2xl font-bold" id="totalKeuntungan">
                Rp{{ number_format($todayKeuntungan, 0, ',', '.') }}
              </p>
            </div>
          </div>

          <!-- Chart Container -->
          <div class="chart-container bg-white p-4 rounded shadow mb-4">
            <canvas id="comboChart" class="w-full" style="height: 400px;"></canvas>
          </div>

          <!-- To-Do List and Progress Section -->
          <div class="flex flex-col md:flex-row gap-4 mb-4">
            <!-- Card 1: To-Do List -->
            <div class="w-full md:w-1/2 bg-white p-6 rounded-lg shadow">
              <div class="flex flex-row mb-4">
                <i class="bi bi-card-list mr-2"></i>
                <h2 class="font-semibold text-gray-700 mb-2">To-Do List</h2>
              </div>
              <hr class="w-full mb-2 border-t-2 border-gray-300" />
              <ul class="space-y-2">
                <li class="flex items-center space-x-3">
                  <input 
                    type="checkbox" 
                    id="task1" 
                    class="form-checkbox h-5 w-5 text-[#005281] border-gray-300 rounded" 
                    onchange="updateProgress()" 
                  />
                  <label for="task1" class="text-gray-700">Buka Toko Pukul 10:00 WIB</label>
                </li>
                <li class="flex items-center space-x-3">
                  <input 
                    type="checkbox" 
                    id="task2" 
                    class="form-checkbox h-5 w-5 text-[#005281] border-gray-300 rounded" 
                    onchange="updateProgress()" 
                  />
                  <label for="task2" class="text-gray-700">Bersih - Bersih / Prepare</label>
                </li>
                <li class="flex items-center space-x-3">
                  <input 
                    type="checkbox" 
                    id="task3" 
                    class="form-checkbox h-5 w-5 text-[#005281] border-gray-300 rounded" 
                    onchange="updateProgress()" 
                  />
                  <label for="task3" class="text-gray-700">Istirahat Jam Makan Siang</label>
                </li>
                <li class="flex items-center space-x-3">
                  <input 
                    type="checkbox" 
                    id="task4" 
                    class="form-checkbox h-5 w-5 text-[#005281] border-gray-300 rounded" 
                    onchange="updateProgress()" 
                  />
                  <label for="task4" class="text-gray-700">Tutup Pukul 10:00 WIB</label>
                </li>
              </ul>
            </div>

            <!-- Card 2: Progress Bar -->
            <div class="w-full md:w-1/2 bg-white px-6 py-4 rounded-lg shadow">
              <div class="mb-4">
                <div class="flex flex-row items-center mb-4">
                  <i class="bi bi-clipboard-fill mr-2"></i>
                  <label class="block text-gray-700 font-semibold">Progress</label>
                </div>
                <div class="relative pt-1">
                  <div class="flex mb-2 items-center justify-between">
                    <span class="text-sm font-semibold inline-block text-[#005281]">0%</span>
                    <span class="text-sm font-semibold inline-block text-[#005281]">100%</span>
                  </div>
                  <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div id="progressBar" class="bg-[#005281] h-2.5 rounded-full transition-all duration-500 ease-in-out" style="width: 0%"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Footer -->
          <footer class="text-gray-400 text-center py-4 mt-8">
            <p>Copyright &#169; 2024 Bblaratech3. All Rights Reserved.</p>
          </footer>
        </div>
      </div>
    </div>

    <!-- Scripts -->
    <script>
      const monthlyData = @json($monthlyData);
      let myChart;
      let currentPreset = 'today';

      // Chart configuration
      const chartConfig = {
        type: 'bar',
        data: {
          labels: Object.keys(monthlyData),
          datasets: [
            {
              label: 'Total Modal',
              data: Object.values(monthlyData).map(data => data.modal),
              backgroundColor: 'rgba(255, 182, 193, 0.6)',
              borderColor: 'rgba(255, 182, 193, 1)',
              borderWidth: 1
            },
            {
              label: 'Total Pendapatan',
              data: Object.values(monthlyData).map(data => data.pendapatan),
              backgroundColor: 'rgba(173, 216, 230, 0.6)',
              borderColor: 'rgba(173, 216, 230, 1)',
              borderWidth: 1
            },
            {
              label: 'Total Keuntungan',
              type: 'line',
              data: Object.values(monthlyData).map(data => data.keuntungan),
              borderColor: 'rgba(144, 238, 144, 1)',
              backgroundColor: 'rgba(144, 238, 144, 0.2)',
              borderWidth: 2,
              fill: true
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          animation: {
            duration: 750,
            easing: 'easeInOutQuart'
          },
          scales: {
            x: {
              grid: {
                display: false
              }
            },
            y: {
              beginAtZero: true,
              ticks: {
                callback: function(value) {
                  return 'Rp' + new Intl.NumberFormat('id-ID').format(value);
                }
              }
            }
          },
          plugins: {
            legend: {
              display: true,
              position: 'top'
            },
            tooltip: {
              callbacks: {
                label: function(context) {
                  return context.dataset.label + ': Rp' + new Intl.NumberFormat('id-ID').format(context.raw);
                }
              }
            }
          }
        }
      };

      // Initialize chart
      document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('comboChart').getContext('2d');
        myChart = new Chart(ctx, chartConfig);
        setDefaultDates();
      });

      // Set default dates
      function setDefaultDates() {
        const today = new Date();
        document.getElementById('endDate').value = today.toISOString().split('T')[0];
        document.getElementById('startDate').value = today.toISOString().split('T')[0];
        applyPreset('today');
      }

      // Handle date change
      function handleDateChange() {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        
        if (startDate && endDate) {
          updateData();
          resetPresetButtons();
        }
      }

      // Apply preset
      function applyPreset(preset) {
        currentPreset = preset;
        updatePresetButtons(preset);
        updateData(preset);
      }

      // Update preset buttons
      function updatePresetButtons(activePreset) {
        document.querySelectorAll('.date-btn').forEach(btn => {
          btn.classList.remove('active');
          if (btn.dataset.preset === activePreset) {
            btn.classList.add('active');
          }
        });
      }

      // Reset preset buttons
      function resetPresetButtons() {
        document.querySelectorAll('.date-btn').forEach(btn => {
          btn.classList.remove('active');
        });
      }

      // Update data
      function updateData(preset = null) {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;

        let url = '/api/dashboard-data';
        let params = new URLSearchParams();

        if (preset) {
          params.append('preset', preset);
        } else {
          if (!startDate || !endDate) {
            alert('Harap pilih rentang tanggal terlebih dahulu.');
            return;
          }
          params.append('start', startDate);
          params.append('end', endDate);
        }

        // Show loading state
        document.body.style.cursor = 'wait';

        fetch(`${url}?${params.toString()}`)
          .then(response => {
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            return response.json();
          })
          .then(data => {
            if (!data) throw new Error('Data kosong');
            updateCards(data);
            if (data.monthlyData) {
              updateChart(data.monthlyData);
            }
          })
          .catch(error => {
            console.error('Error updating dashboard:', error);
            alert('Terjadi kesalahan saat memperbarui data. Silakan coba lagi.');
          })
          .finally(() => {
            document.body.style.cursor = 'default';
          });
      }

      // Update cards
      function updateCards(data) {
          if (!data) return;

          const formatCurrency = (value) => 'Rp' + new Intl.NumberFormat('id-ID').format(value || 0);
          const formatPercentage = (value) => value ? value.toFixed(2) : '0.00';

          ['Modal', 'Pendapatan', 'Keuntungan'].forEach(type => {
              const total = document.querySelector(`#total${type}`);
              const percentage = document.querySelector(`#${type.toLowerCase()}Percentage`);
              const lowerType = type.toLowerCase();
              
              if (total) {
                  total.textContent = formatCurrency(data[`today${type}`]);
              }
              
              if (percentage) {
                  const percentValue = data[`${lowerType}Percentage`] || 0;
                  const diffValue = data[`${lowerType}Diff`] || 0;
                  const isPositive = percentValue >= 0;
                  
                  percentage.className = `text-${isPositive ? 'green' : 'red'}-500 text-sm mb-2`;
                  percentage.textContent = `${formatPercentage(percentValue)}% (${isPositive ? '+' : ''}${formatCurrency(diffValue)}) dibanding periode sebelumnya`;
              }
          });
      }

      // Update chart
      function updateChart(newData) {
        if (!myChart) return;

        myChart.data.labels = Object.keys(newData);
        myChart.data.datasets.forEach((dataset, index) => {
          const type = ['modal', 'pendapatan', 'keuntungan'][index];
          dataset.data = Object.values(newData).map(data => data[type]);
        });
        
        myChart.update('active');
      }

      function updatePresetButtons(activePreset) {
        document.querySelectorAll('[data-preset]').forEach(btn => {
          if (btn.dataset.preset === activePreset) {
            btn.classList.add('bg-[#003d61]');
            btn.classList.remove('bg-[#005281]');
          } else {
            btn.classList.remove('bg-[#003d61]');
            btn.classList.add('bg-[#005281]');
          }
        });
      }

      function resetPresetButtons() {
        document.querySelectorAll('[data-preset]').forEach(btn => {
          btn.classList.remove('bg-[#003d61]');
          btn.classList.add('bg-[#005281]');
        });
      }

      // Toggle sidebar for mobile
      function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.classList.toggle('hidden');
      }
    </script>
    <script>
      // Save todo state in localStorage
      function saveTodoState() {
        const tasks = document.querySelectorAll('.form-checkbox');
        const todoState = Array.from(tasks).map(task => task.checked);
        localStorage.setItem('todoState', JSON.stringify(todoState));
      }

      // Load todo state from localStorage
      function loadTodoState() {
        const savedState = localStorage.getItem('todoState');
        if (savedState) {
          const todoState = JSON.parse(savedState);
          const tasks = document.querySelectorAll('.form-checkbox');
          tasks.forEach((task, index) => {
            task.checked = todoState[index];
          });
          updateProgress();
        }
      }

      // Update progress bar
      function updateProgress() {
        const tasks = document.querySelectorAll('.form-checkbox');
        const completedTasks = Array.from(tasks).filter(task => task.checked).length;
        const totalTasks = tasks.length;
        const progress = (completedTasks / totalTasks) * 100;
        
        const progressBar = document.getElementById('progressBar');
        progressBar.style.width = `${progress}%`;
        
        // Save state after update
        saveTodoState();
      }

      // Add to DOMContentLoaded
      document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('comboChart').getContext('2d');
        myChart = new Chart(ctx, chartConfig);
        setDefaultDates();
        loadTodoState(); // Load saved todo state
      });
    </script>
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
  </body>
</html>
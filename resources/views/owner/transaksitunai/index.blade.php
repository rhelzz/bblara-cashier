<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Transaksi Tunai - Bblara</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap Icons CDN -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css"
    />
    {{-- Font Cdn --}}
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600&display=swap" rel="stylesheet">
    <style>
      body{
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

      .bi-arrow-down-up {
        transition: all 0.2s ease-in-out;
      }

      .bi-arrow-up, .bi-arrow-down {
        color: #e17f12;
      }

      th[onclick] {
        transition: background-color 0.2s ease-in-out;
      }

      th[onclick]:hover {
        background-color: #f3f4f6;
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
          <div class="p-6 bg-gray-100 min-h-screen">
              <div class="max-w-7xl mx-auto">
                  <div class="flex justify-between items-center mb-6">
                      <h1 class="text-2xl font-semibold text-gray-900">Daftar Transaksi Tunai</h1>
                      <div class="text-sm text-gray-600">
                          <p>Current User: {{ Auth::user()->name ?? 'rhelzz' }}</p>
                          <p>Date: <span id="currentDateTime">2025-01-30 04:55:24</span></p>
                      </div>
                  </div>
          
                  @if(session('success'))
                      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                          <span class="block sm:inline">{{ session('success') }}</span>
                      </div>
                  @endif
          
                  <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="overflow-x-auto">
                      <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pengguna</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Modal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode Pembayaran</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer group" onclick="sortTable()">
                                    <div class="flex items-center">
                                        Waktu Transaksi
                                        <span id="sort-icon" class="ml-2">
                                            <i class="bi bi-arrow-down-up"></i>
                                        </span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->name_user }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($transaction->total_cost_price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($transaction->payment_method) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->timestamp }}</td>
                                </tr>
                            @endforeach
                            <!-- Total Row -->
                            <tr class="bg-gray-50 font-semibold">
                                <td class="px-6 py-4 whitespace-nowrap"></td>
                                <td class="px-6 py-4 whitespace-nowrap">Total</td>
                                <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($transactions->sum('subtotal'), 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($transactions->sum('total_cost_price'), 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap"></td>
                                <td class="px-6 py-4 whitespace-nowrap"></td>
                            </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
              </div>
          </div>
        </div>
      </div>

      <!-- Scripts -->
      <script>
        // Update current date time
        function updateDateTime() {
            const now = new Date();
            const formattedDateTime = now.getFullYear() + '-' + 
                                  String(now.getMonth() + 1).padStart(2, '0') + '-' + 
                                  String(now.getDate()).padStart(2, '0') + ' ' + 
                                  String(now.getHours()).padStart(2, '0') + ':' + 
                                  String(now.getMinutes()).padStart(2, '0') + ':' + 
                                  String(now.getSeconds()).padStart(2, '0');
            document.getElementById('currentDateTime').textContent = formattedDateTime;
        }

        // Update time every second
        setInterval(updateDateTime, 1000);

        // Sidebar Toggle Function
        function toggleSidebar() {
          const sidebar = document.querySelector('.sidebar');
          sidebar.classList.toggle('-translate-x-full');
        }

        // Dropdown Toggle Function
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

        // Table Sorting Function
        let isAscending = true;

        function sortTable() {
            const table = document.querySelector('table');
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr')).filter(row => !row.classList.contains('bg-gray-50'));
            const sortIcon = document.getElementById('sort-icon');

            // Update sort icon
            sortIcon.innerHTML = isAscending ? 
                '<i class="bi bi-arrow-up text-orange-500"></i>' : 
                '<i class="bi bi-arrow-down text-orange-500"></i>';

            // Sort the rows
            rows.sort((a, b) => {
                // Get timestamp and ID for comparison
                const timeA = new Date(a.cells[5].textContent.trim());
                const timeB = new Date(b.cells[5].textContent.trim());
                const idA = parseInt(a.cells[0].textContent.trim());
                const idB = parseInt(b.cells[0].textContent.trim());
                
                // First compare by timestamp
                if (timeA.getTime() !== timeB.getTime()) {
                    return isAscending ? timeA - timeB : timeB - timeA;
                }
                
                // If timestamps are equal, sort by ID
                return isAscending ? idA - idB : idB - idA;
            });

            // Remove existing rows (except total row)
            rows.forEach(row => row.remove());

            // Add sorted rows back
            const totalRow = tbody.querySelector('.bg-gray-50');
            rows.forEach(row => tbody.insertBefore(row, totalRow));
        }

        // Initialize sorting when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Set initial state to true for oldest to newest sorting
            isAscending = true;
            
            // Update sort icon to show initial state
            const sortIcon = document.getElementById('sort-icon');
            sortIcon.innerHTML = '<i class="bi bi-arrow-up text-orange-500"></i>';
            
            // Perform initial sort
            sortTable();
            
            // Initialize datetime
            updateDateTime();
            
            // Add click handler for the sort header
            const sortHeader = document.querySelector('th[onclick="sortTable()"]');
            sortHeader.addEventListener('click', function() {
                isAscending = !isAscending;
                sortTable();
            });
        });
      </script>
    </body>
</html>
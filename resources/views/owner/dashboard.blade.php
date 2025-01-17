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
        background-color:  #e17f12;
        transition: width 0.2s ease-in-out;
      }
    
      .hover-link:hover .nav-text::after {
        width: 100%;
      }
    </style>
  </head>
  <body>
    <!-- Toggle Button for Sidebar -->
    <button
      class="absolute text-white text-3xl top-5 left-4 p-2 rounded-md bg-gray-700 lg:hidden focus:outline-none"
      onclick="toggleSidebar()"
    >
      <i class="bi bi-list"></i>
    </button>

    <!-- Sidebar -->
    <div
      id="sidebar"
      class="fixed top-0 left-0 lg:left-0 p-4 w-64 bg-[#FCFCFC] h-full flex flex-col overflow-y-auto transition-transform transform -translate-x-full lg:translate-x-0 text-[#000000] border-r-2"
    >
      <!-- Sidebar Header -->
      <div class="flex items-center justify-between mb-4">
        <img src="{{ asset('assets/logo-transparent.png') }}" alt="" class="w-auto h-40 mx-auto">
        <button
          class="lg:hidden text-gray-400 hover:text-white"
          onclick="toggleSidebar()"
        >
          <i class="bi bi-x text-2xl"></i>
        </button>
      </div>

      <div class="w-full border-b-2 border-gray-300"></div>

      <!-- Menu Items -->
      <div class="space-y-2 flex-1">
        <!-- Beranda -->
        <a href="#" class="flex items-center p-3 rounded-md bg-none transition hover-link">
          <i class="bi bi-house-door-fill"></i>
          <span class="ml-3 nav-text font-semibold">Beranda</span>
        </a>

        <!-- Kasir -->
        <a href="#" class="flex items-center p-3 rounded-md bg-none transition hover-link">
          <i class="bi bi-basket"></i>
          <span class="ml-3 nav-text font-semibold">Kasir</span>
        </a>

        <!-- Transaksi Dropdown -->
        <div>
          <button
            onclick="toggleDropdown(this)"
            class="flex items-center justify-between w-full p-3 rounded-md bg-none transition focus:outline-none hover-link">
            <span class="flex items-center">
              <i class="bi bi-arrow-left-right"></i>
              <span class="ml-3 nav-text font-semibold">Transaksi</span>
            </span>
            <i class="bi bi-chevron-down transition-transform"></i>
          </button>
          <div class="dropdown-menu space-y-2 overflow-hidden max-h-0 transition-all duration-300">
            <a href="#" class="block p-3 rounded-md bg-none transition mt-2 hover-link">
              <span class="nav-text font-semibold">Transaksi Tunai</span>
            </a>
            <a href="#" class="block p-3 rounded-md bg-none transition hover-link">
              <span class="nav-text font-semibold">Transaksi Qris</span>
            </a>
          </div>
        </div>

        <!-- Produk Dropdown -->
        <div>
          <button
            onclick="toggleDropdown(this)"
            class="flex items-center justify-between w-full p-3 rounded-md bg-none transition focus:outline-none hover-link">
            <span class="flex items-center">
              <i class="bi bi-box-seam"></i>
              <span class="ml-3 nav-text font-semibold">Produk</span>
            </span>
            <i class="bi bi-chevron-down transition-transform"></i>
          </button>
          <div class="dropdown-menu space-y-2 overflow-hidden max-h-0 transition-all duration-300">
            <a href="#" class="block p-3 rounded-md bg-none transition mt-2 hover-link">
              <span class="nav-text font-semibold">Tabel Produk</span>
            </a>
            <a href="#" class="block p-3 rounded-md bg-none transition hover-link">
              <span class="nav-text font-semibold">Tambah Produk</span>
            </a>
            <a href="#" class="block p-3 rounded-md bg-none transition hover-link">
              <span class="nav-text font-semibold">Edit Produk</span>
            </a>
          </div>
        </div>

        <!-- Stok Dropdown -->
        <div>
          <button
            onclick="toggleDropdown(this)"
            class="flex items-center justify-between w-full p-3 rounded-md bg-none transition focus:outline-none hover-link">
            <span class="flex items-center">
              <i class="bi bi-clipboard-data"></i>
              <span class="ml-3 nav-text font-semibold">Stok</span>
            </span>
            <i class="bi bi-chevron-down transition-transform"></i>
          </button>
          <div class="dropdown-menu space-y-2 overflow-hidden max-h-0 transition-all duration-300">
            <a href="#" class="block p-3 rounded-md bg-none transition mt-2 hover-link">
              <span class="nav-text font-semibold">Tabel Stok</span>
            </a>
            <a href="#" class="block p-3 rounded-md bg-none transition hover-link">
              <span class="nav-text font-semibold">Tambah Stok</span>
            </a>
            <a href="#" class="block p-3 rounded-md bg-none transition hover-link">
              <span class="nav-text font-semibold">Edit Produk</span>
            </a>
          </div>
        </div>
      </div>

      <!-- Logout -->
      <a href="#" class="flex items-center p-3 rounded-md bg-none transition hover-link mt-auto">
        <i class="bi bi-box-arrow-right"></i>
        <span class="ml-3 nav-text font-semibold">Logout</span>
      </a>
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
  </body>
</html>
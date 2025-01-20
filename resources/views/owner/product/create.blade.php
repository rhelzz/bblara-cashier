<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Beranda - Bblara</title>
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
                <div class="max-w-2xl mx-auto">
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h1 class="text-2xl font-semibold text-gray-900 mb-6">Tambah Produk Baru</h1>
            
                        <form action="{{ route('owner.product.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
            
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                                <input type="text" name="name" id="name" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       value="{{ old('name') }}" required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
            
                            <div class="mb-4">
                                <label for="cost_price" class="block text-sm font-medium text-gray-700">Harga Modal</label>
                                <input type="number" name="cost_price" id="cost_price" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       value="{{ old('cost_price') }}" required>
                                @error('cost_price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
            
                            <div class="mb-4">
                                <label for="price" class="block text-sm font-medium text-gray-700">Harga Jual</label>
                                <input type="number" name="price" id="price" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       value="{{ old('price') }}" required>
                                @error('price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
            
                            <div class="mb-4">
                                <label for="image" class="block text-sm font-medium text-gray-700">Gambar Produk</label>
                                <input type="file" name="image" id="image" 
                                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                       accept="image/*" required>
                                @error('image')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
            
                            <div class="flex justify-end mt-6">
                                <a href="{{ route('owner.product.index') }}" 
                                   class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2 hover:bg-gray-600">
                                    Batal
                                </a>
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                                    Simpan
                                </button>
                            </div>
                        </form>
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
    </body>
</html>

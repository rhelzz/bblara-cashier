<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product - Bblara</title>
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
                        <div class="mb-6">
                            <h1 class="text-2xl font-semibold text-gray-900">Detail Produk</h1>
                        </div>
            
                        <div class="mb-6">
                            <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" 
                                 class="w-full h-64 object-cover rounded-lg">
                        </div>
            
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Nama Produk</h3>
                                <p class="mt-1 text-lg text-gray-900">{{ $product->name }}</p>
                            </div>
            
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Harga Modal</h3>
                                <p class="mt-1 text-lg text-gray-900">Rp {{ number_format($product->cost_price, 0, ',', '.') }}</p>
                            </div>
            
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Harga Jual</h3>
                                <p class="mt-1 text-lg text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
            
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Margin</h3>
                                <p class="mt-1 text-lg text-gray-900">
                                    Rp {{ number_format($product->price - $product->cost_price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
            
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('owner.product.index') }}" 
                               class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                                Kembali
                            </a>
                            <a href="{{ route('owner.product.edit', $product) }}" 
                               class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">
                                Edit
                            </a>
                            <form action="{{ route('owner.product.destroy', $product) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                    Hapus
                                </button>
                            </form>
                        </div>
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

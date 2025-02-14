<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tabel Produk - Bblara</title>
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
              <div class="max-w-7xl mx-auto">
                  <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold text-gray-800">Daftar Produk</h1>
                      <a href="{{ route('owner.product.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                          Tambah Produk
                      </a>
                  </div>
          
                  @if(session('success'))
                      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                          <span class="block sm:inline">{{ session('success') }}</span>
                      </div>
                  @endif
          
                  <div class="bg-white rounded-lg shadow overflow-hidden">
                      <table class="min-w-full divide-y divide-gray-200">
                          <thead class="bg-gray-50">
                              <tr>
                                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Modal</th>
                                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Jual</th>
                                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                              </tr>
                          </thead>
                          <tbody class="bg-white divide-y divide-gray-200">
                              @foreach($products as $product)
                                  <tr>
                                      <td class="px-6 py-4 whitespace-nowrap">
                                          <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" 
                                              class="h-16 w-16 object-cover rounded">
                                      </td>
                                      <td class="px-6 py-4 whitespace-nowrap">{{ $product->name }}</td>
                                      <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($product->cost_price, 0, ',', '.') }}</td>
                                      <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                      <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex space-x-2">
                                            {{-- Button Lihat --}}
                                            <a href="{{ route('owner.product.show', $product) }}" 
                                               class="inline-flex items-center px-3 py-1.5 bg-blue-500 text-white text-sm font-medium rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <i class="bi bi-eye mr-1"></i>
                                                Lihat
                                            </a>
                                    
                                            {{-- Button Edit --}}
                                            <a href="{{ route('owner.product.edit', $product) }}" 
                                               class="inline-flex items-center px-3 py-1.5 bg-yellow-500 text-white text-sm font-medium rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                                <i class="bi bi-pencil mr-1"></i>
                                                Edit
                                            </a>
                                    
                                            {{-- Button Hapus --}}
                                            <form action="{{ route('owner.product.destroy', $product) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')"
                                                        class="inline-flex items-center px-3 py-1.5 bg-red-500 text-white text-sm font-medium rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                    <i class="bi bi-trash mr-1"></i>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                  </tr>
                              @endforeach
                          </tbody>
                      </table>
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

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detail Produk - Bblara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" />
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Chart.js CDN -->
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
      .progress-bar {
        transition: width 1s ease-in-out;
      }
      .product-image-container {
        aspect-ratio: 1/1;
        overflow: hidden;
      }
    </style>
  </head>
  <body class="bg-gray-100">
    <div class="flex">
      <!-- Toggle Button for Sidebar -->
      <button class="fixed text-white text-3xl top-5 left-4 p-2 rounded-md bg-gray-700 lg:hidden focus:outline-none z-50"
        onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
      </button>

      <!-- Sidebar -->
      <x-navbar-owner></x-navbar-owner>

      <!-- Main Content -->
      <div class="flex-1 lg:w-5/6">
        {{-- Navbar Top --}}
        <x-navbar-top-owner></x-navbar-top-owner>

        <!-- Content Wrapper -->
        <div class="p-3 lg:p-6">
          <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header Section -->
            <div class="p-4 bg-gray-50 border-b">
              <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Detail Produk</h1>
                <div class="space-x-2">
                  <a href="{{ route('owner.product.index') }}" 
                     class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <i class="bi bi-arrow-left mr-2"></i> Kembali
                  </a>
                  <a href="{{ route('owner.product.edit', $product) }}" 
                     class="inline-flex items-center px-3 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600">
                    <i class="bi bi-pencil mr-2"></i> Edit
                  </a>
                  <form action="{{ route('owner.product.destroy', $product) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="inline-flex items-center px-3 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-red-500 hover:bg-red-600"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                      <i class="bi bi-trash mr-2"></i> Hapus
                    </button>
                  </form>
                </div>
              </div>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 p-6">
              <!-- Left Column - Image -->
              <div class="product-image-container rounded-lg overflow-hidden shadow-sm">
                <img src="{{ Storage::url($product->image_path) }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-full object-cover">
              </div>

              <!-- Right Column - Product Details -->
              <div class="space-y-6">
                <!-- Product Name -->
                <div class="bg-gray-50 p-4 rounded-lg">
                  <h3 class="text-sm font-medium text-gray-500 mb-1">Nama Produk</h3>
                  <p class="text-xl font-semibold text-gray-900">{{ $product->name }}</p>
                </div>

                <!-- Financial Details -->
                <div class="grid grid-cols-2 gap-4">
                  <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Harga Modal</h3>
                    <p class="text-lg font-semibold text-gray-900">Rp {{ number_format($product->cost_price, 0, ',', '.') }}</p>
                  </div>

                  <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Harga Jual</h3>
                    <p class="text-lg font-semibold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                  </div>
                </div>

                <!-- Margin Analysis -->
                @php
                $margin = $product->price - $product->cost_price;
                $marginPercentage = ($margin / $product->cost_price) * 100;

                // Normalisasi yang baru
                $normalizedPercentage = $marginPercentage;
                if ($marginPercentage >= 50) {
                    $normalizedPercentage = 100; // Langsung set 100% jika mencapai atau melebihi 50%
                } elseif ($marginPercentage >= 25) {
                    // Normalisasi antara 25% dan 50% ke 66.67% sampai 100%
                    $normalizedPercentage = 66.67 + (($marginPercentage - 25) / 25) * 33.33;
                } elseif ($marginPercentage >= 10) {
                    // Normalisasi antara 10% dan 25% ke 33.33% sampai 66.67%
                    $normalizedPercentage = 33.33 + (($marginPercentage - 10) / 15) * 33.34;
                } else {
                    // Normalisasi antara 0% dan 10% ke 0% sampai 33.33%
                    $normalizedPercentage = ($marginPercentage / 10) * 33.33;
                }

                // Status logic remains the same
                if ($marginPercentage >= 50) {
                    $status = 'Sangat Baik';
                    $statusColor = 'text-green-600 bg-green-100';
                    $progressColor = 'bg-green-500';
                } elseif ($marginPercentage >= 25) {
                    $status = 'Baik';
                    $statusColor = 'text-blue-600 bg-blue-100';
                    $progressColor = 'bg-blue-500';
                } elseif ($marginPercentage >= 10) {
                    $status = 'Cukup';
                    $statusColor = 'text-yellow-600 bg-yellow-100';
                    $progressColor = 'bg-yellow-500';
                } else {
                    $status = 'Buruk';
                    $statusColor = 'text-red-600 bg-red-100';
                    $progressColor = 'bg-red-500';
                }
                @endphp

                <div class="bg-white p-6 rounded-lg border space-y-4">
                  <!-- Margin Header -->
                  <div class="flex justify-between items-start">
                    <div>
                      <h3 class="text-sm font-medium text-gray-500 mb-1">Margin</h3>
                      <p class="text-lg font-semibold text-gray-900">
                        Rp {{ number_format($margin, 0, ',', '.') }}
                      </p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusColor }}">
                      {{ $status }}
                    </span>
                  </div>

                  <!-- Margin Percentage -->
                  <div class="flex items-baseline space-x-2">
                    <span class="text-2xl font-bold {{ $marginPercentage >= 50 ? 'text-green-600' : ($marginPercentage >= 25 ? 'text-blue-600' : ($marginPercentage >= 10 ? 'text-yellow-600' : 'text-red-600')) }}">
                      {{ number_format($marginPercentage, 1) }}%
                    </span>
                    <span class="text-sm text-gray-500">margin profit</span>
                  </div>

                  <!-- Progress Bar Container -->
                  <div class="space-y-2">
                    <div class="relative pt-1">
                      <div class="flex mb-2 items-center justify-between">
                        <div>
                          <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full {{ $statusColor }}">
                            Status Margin
                          </span>
                        </div>
                      </div>
                      <!-- Menjadi kode baru: -->
                      <div class="overflow-hidden h-3 text-xs flex rounded bg-gray-200">
                        <div class="progress-bar shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center {{ $progressColor }}"
                            style="width: {{ $normalizedPercentage }}%">
                        </div>
                      </div>
                      <!-- Updated Progress Markers -->
                      <div class="mt-2 grid grid-cols-4 text-xs">
                        <div class="text-left text-gray-600">
                          <span class="bg-red-100 px-2 py-1 rounded">0-10%</span>
                          <span class="block mt-1">Buruk</span>
                        </div>
                        <div class="text-center text-gray-600">
                          <span class="bg-yellow-100 px-2 py-1 rounded">10-24%</span>
                          <span class="block mt-1">Cukup</span>
                        </div>
                        <div class="text-center text-gray-600">
                          <span class="bg-blue-100 px-2 py-1 rounded">25-49%</span>
                          <span class="block mt-1">Baik</span>
                        </div>
                        <div class="text-right text-gray-600">
                          <span class="bg-green-100 px-2 py-1 rounded">≥50%</span>
                          <span class="block mt-1">Sangat Baik</span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Updated Status Description -->
                  <div class="mt-4 p-3 rounded-lg {{ $statusColor }} bg-opacity-50">
                    <p class="text-sm">
                      @if($marginPercentage >= 50)
                        Margin profit sangat baik! Produk ini memberikan keuntungan yang optimal.
                      @elseif($marginPercentage >= 25)
                        Margin profit dalam kondisi baik. Terus pertahankan dan cari peluang untuk ditingkatkan.
                      @elseif($marginPercentage >= 10)
                        Margin profit cukup. Ada ruang untuk peningkatan melalui optimasi harga atau pengurangan biaya.
                      @else
                        Margin profit dalam kondisi buruk. Segera lakukan penyesuaian harga atau evaluasi biaya produksi untuk meningkatkan profitabilitas.
                      @endif
                    </p>
                  </div>
                </div>

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
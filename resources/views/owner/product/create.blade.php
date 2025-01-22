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
    <!-- Font Cdn -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600&display=swap" rel="stylesheet">
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
      input[type="text"],
      input[type="number"],
      input[type="file"] {
        border: 2px solid #e2e8f0; /* Tailwind gray-300 */
        padding: 0.75rem 1rem; /* Tailwind p-3 px-4 */
        border-radius: 0.375rem; /* Tailwind rounded-md */
        transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
      }
      input[type="text"]:focus,
      input[type="number"]:focus,
      input[type="file"]:focus {
        border-color: #3182ce; /* Tailwind blue-500 */
        box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.3); /* Tailwind ring-blue-500 */
        outline: none;
      }
      input[type="text"]:hover,
      input[type="number"]:hover,
      input[type="file"]:hover {
        border-color: #cbd5e0; /* Tailwind gray-400 */
      }
      .dropzone {
        border: 2px dashed #e2e8f0; /* Tailwind gray-300 */
        border-radius: 0.375rem; /* Tailwind rounded-md */
        padding: 1.5rem; /* Tailwind p-6 */
        text-align: center;
        transition: border-color 0.2s ease-in-out;
        cursor: pointer;
      }
      .dropzone:hover {
        border-color: #cbd5e0; /* Tailwind gray-400 */
      }
      .dropzone.dragover {
        border-color: #3182ce; /* Tailwind blue-500 */
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
        <!-- Navbar Top -->
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
                           class="mt-1 block w-full"
                           value="{{ old('name') }}" required>
                    @error('name')
                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                  </div>

                  <div class="mb-4">
                    <label for="cost_price" class="block text-sm font-medium text-gray-700">Harga Modal</label>
                    <input type="number" name="cost_price" id="cost_price"
                           class="mt-1 block w-full"
                           value="{{ old('cost_price') }}" required>
                    @error('cost_price')
                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                  </div>

                  <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-700">Harga Jual</label>
                    <input type="number" name="price" id="price"
                           class="mt-1 block w-full"
                           value="{{ old('price') }}" required>
                    @error('price')
                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                  </div>

                  <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">Gambar Produk</label>
                    <div class="dropzone" id="dropzone">
                      <i class="bi bi-cloud-arrow-up text-gray-400 text-4xl"></i>
                      <p class="text-gray-400">Drag & drop gambar di sini, atau klik untuk memilih gambar</p>
                      <input type="file" name="image" id="image" class="hidden" accept="image/*" required>
                    </div>
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

        // Drag and Drop functionality
        const dropzone = document.getElementById('dropzone');
        const imageInput = document.getElementById('image');

        dropzone.addEventListener('dragover', (event) => {
          event.preventDefault();
          dropzone.classList.add('dragover');
        });

        dropzone.addEventListener('dragleave', () => {
          dropzone.classList.remove('dragover');
        });

        dropzone.addEventListener('drop', (event) => {
          event.preventDefault();
          dropzone.classList.remove('dragover');
          const files = event.dataTransfer.files;
          imageInput.files = files;
        });

        dropzone.addEventListener('click', () => {
          imageInput.click();
        });

        imageInput.addEventListener('change', () => {
          const files = imageInput.files;
          if (files.length > 0) {
            dropzone.querySelector('p').innerText = files[0].name;
          }
        });
      </script>
    </body>
</html>
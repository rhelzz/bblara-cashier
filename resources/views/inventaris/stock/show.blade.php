<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stok - Bblara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
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
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <button class="fixed text-white text-3xl top-5 left-4 p-2 rounded-md bg-gray-700 lg:hidden focus:outline-none z-50" onclick="toggleSidebar()">
            <i class="bi bi-list"></i>
        </button>
        <x-navbar-inventaris></x-navbar-inventaris>
        <div class="flex-1 lg:w-5/6">
            <x-navbar-top-inventaris></x-navbar-top-inventaris>
            <div class="p-4 lg:p-8">
                <div class="p-6 bg-gray-100 min-h-screen">
                    <div class="max-w-2xl mx-auto">
                        <div class="bg-white rounded-lg shadow-lg p-6">
                            <div class="mb-6">
                                <h1 class="text-2xl font-semibold text-gray-900">Detail Stok</h1>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">ID</h3>
                                    <p class="mt-1 text-lg text-gray-900">{{ $stock->id }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Bahan Baku</h3>
                                    <p class="mt-1 text-lg text-gray-900">{{ $stock->raw_material }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Kuantitas</h3>
                                    <p class="mt-1 text-lg text-gray-900">{{ $stock->qty }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Berat</h3>
                                    <p class="mt-1 text-lg text-gray-900">{{ $stock->weight . ' ' . $stock->unit }}</p>
                                </div>
                            </div>
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('inventaris.stock.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Kembali</a>
                                <a href="{{ route('inventaris.stock.edit', $stock) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">Edit</a>
                                <form action="{{ route('inventaris.stock.destroy', $stock) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600" onclick="return confirm('Apakah Anda yakin ingin menghapus stok ini?')">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
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
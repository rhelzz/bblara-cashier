<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Stock - Bblara</title>
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
        input[type="text"],
        input[type="number"],
        select {
            border: 2px solid #e2e8f0;
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus {
            border-color: #3182ce;
            box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.3);
            outline: none;
        }
        input[type="text"]:hover,
        input[type="number"]:hover,
        select:hover {
            border-color: #cbd5e0;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <button class="fixed text-white text-3xl top-5 left-4 p-2 rounded-md bg-gray-700 lg:hidden focus:outline-none z-50" onclick="toggleSidebar()">
            <i class="bi bi-list"></i>
        </button>
        <x-navbar-owner></x-navbar-owner>
        <div class="flex-1 lg:w-5/6">
            <x-navbar-top-owner></x-navbar-top-owner>
            <div class="p-4 lg:p-8">
                <div class="p-6 bg-gray-100 min-h-screen">
                    <div class="max-w-2xl mx-auto">
                        <div class="bg-white rounded-lg shadow-lg p-6">
                            <h1 class="text-2xl font-semibold text-gray-900 mb-6">Tambah Stok Baru</h1>
                            <form action="{{ route('owner.stock.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <label for="raw_material" class="block text-sm font-medium text-gray-700">Bahan Baku</label>
                                    <input type="text" name="raw_material" id="raw_material" class="mt-1 block w-full" value="{{ old('raw_material') }}" required>
                                    @error('raw_material')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="qty" class="block text-sm font-medium text-gray-700">Kuantitas</label>
                                    <input type="number" name="qty" id="qty" class="mt-1 block w-full" value="{{ old('qty') }}" required>
                                    @error('qty')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="weight" class="block text-sm font-medium text-gray-700">Berat</label>
                                    <div class="flex">
                                        <input type="text" name="weight" id="weight" class="mt-1 block w-full" value="{{ old('weight') }}" required>
                                        <select name="unit" id="unit" class="mt-1 ml-2 block">
                                            <option value="gr">gr</option>
                                            <option value="ml">ml</option>
                                            <option value="l">l</option>
                                            <option value="ons">ons</option>
                                            <option value="kg">kg</option>
                                        </select>
                                    </div>
                                    @error('unit')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex justify-end mt-6">
                                    <a href="{{ route('owner.stock.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2 hover:bg-gray-600">Batal</a>
                                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Simpan</button>
                                </div>
                            </form>
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
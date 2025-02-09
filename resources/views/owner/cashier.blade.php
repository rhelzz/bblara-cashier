<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kasir - Bblara</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" />

    <!-- Font Cdn -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- jQuery (diperlukan untuk Toastr) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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

        /* Add this to your existing style tag */
        .receipt-section {
            position: fixed;
            right: 0;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            width: 16.666667%; /* This is equivalent to w-1/6 */
        }

        /* Style the scrollbar for better appearance */
        .receipt-section::-webkit-scrollbar {
            width: 6px;
        }

        .receipt-section::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .receipt-section::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        .receipt-section::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Adjust main content to account for fixed receipt section */
        .main-content {
            margin-right: 16.666667%; /* Same as receipt section width */
        }
    
        /* Tambahkan CSS untuk print */
        /* Update the print media query in your style section */
        @media print {
            /* Hide all elements initially */
            body * {
                visibility: hidden;
            }
            
            /* Show only receipt section and its contents */
            .receipt-section, 
            .receipt-section * {
                visibility: visible;
            }
            
            /* Position receipt for full screen */
            .receipt-section {
                position: absolute;
                left: 0;
                top: 0;
                width: 100vw !important; /* Force full viewport width */
                height: 100vh !important; /* Force full viewport height */
                padding: 20px;
                margin: 0;
                max-width: none !important; /* Remove max-width restriction */
            }

            /* Adjust content scaling for full screen */
            .receipt-section {
                font-size: 16px; /* Increase font size for better readability */
                line-height: 1.5;
            }

            /* Center the content */
            .receipt-section > div {
                max-width: 800px;
                margin: 0 auto;
            }

            /* Hide buttons when printing */
            .receipt-section .button-group {
                display: none !important;
            }

            /* Adjust spacing for items */
            .receipt-section #item-list {
                margin: 30px 0;
                max-height: none !important; /* Remove scroll restrictions */
            }

            /* Enhance headers and totals visibility */
            .receipt-section h1 {
                font-size: 24px;
                margin-bottom: 20px;
            }

            /* Improve spacing between items */
            .receipt-section .flex.flex-col {
                margin-bottom: 20px;
            }

            /* Remove any background colors and shadows */
            .receipt-section {
                background: none !important;
                box-shadow: none !important;
            }

            /* Hide scrollbars */
            .receipt-section::-webkit-scrollbar {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="flex relative">

        <!-- Navbar Owner -->
        <x-navbar-owner></x-navbar-owner>

        <!-- Main Content -->
        <section class="w-4/6 bg-white shadow rounded main-content xl:w-4/6 lg:w-[62.5%]">
            <x-navbar-top-owner></x-navbar-top-owner>

            <!-- Search Bar -->
            <div class="p-4">
                <div class="relative">
                    <input 
                        type="text" 
                        id="searchInput" 
                        class="w-full px-4 py-2 pl-10 pr-8 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#005281] focus:border-transparent"
                        placeholder="Search product name..."
                    >
                    <div class="absolute top-2.5 left-3 text-gray-400">
                        <i class="bi bi-search"></i>
                    </div>
                    <button 
                        id="clearSearch" 
                        class="absolute top-2.5 right-3 text-gray-400 hover:text-gray-600 hidden"
                        onclick="clearSearchInput()"
                    >
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>

            <!-- Main content section -->
            @foreach ($products as $row)
            <form class="p-6" method="POST" action="#" onsubmit="addToOrder(event)" data-product-name="{{ $row->name }}" data-product-price="{{ $row->price }}" data-cost-price="{{ $row->cost_price }}">
                    <div class="w-full p-6 bg-white rounded shadow-lg">
                        <header class="mb-4">
                            <h2 class="font-bold text-xl text-green-700">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}. {{ $row->name }} (Rp {{ number_format($row->price, 0, ',', '.') }})</h2>
                        </header>
                    
                        <!-- Kontainer untuk gambar dan kontrol -->
                        <div class="flex gap-6">
                            <!-- Gambar -->
                            <figure class="w-1/3">
                                <img src="{{ Storage::url($row->image_path) }}" alt="Macchiato Milk Tea" class="w-56 h-56 object-cover object-center">
                            </figure>
                    
                            <!-- Kontrol -->
                            <div class="w-2/3 grid grid-cols-2 gap-4">
                                <!-- Amount -->
                                <div class="p-4 bg-white rounded shadow">
                                    <label class="block font-medium text-gray-700 mb-2">Amount:</label>
                                    <div class="flex items-center justify-center space-x-2">
                                        <button type="button" class="px-3 py-1 bg-[#e17f12] rounded-full w-12 h-12 shadow text-white font-bold lg:h-10 lg:w-10 lg:text-sm" onclick="decrementAmount()">-</button>
                                        <input type="text" name="amount" value="1" class="w-10 text-center border rounded h-12" readonly>
                                        <button type="button" class="px-3 py-1 bg-[#e17f12] rounded-full w-12 h-12 shadow text-white lg:h-10 lg:w-10 lg:text-sm" onclick="incrementAmount()">+</button>
                                    </div>
                                </div>
                    
                                <!-- Size -->
                                <div class="p-4 bg-white rounded shadow">
                                    <label class="block font-medium text-gray-700 mb-2">Size:</label>
                                    <div class="flex items-center justify-center space-x-4">
                                        <div class="relative">
                                            <input type="radio" name="size" id="size-m" value="M" class="sr-only peer" onchange="updatePrice()" checked>
                                            <label for="size-m" class="flex items-center justify-center px-3 py-1 border rounded-full w-12 h-12 text-center cursor-pointer peer-checked:bg-[#e17f12] peer-checked:text-white hover:bg-gray-50 lg:h-10 lg:w-10 lg:text-sm">M</label>
                                        </div>
                                        <div class="relative">
                                            <input type="radio" name="size" id="size-l" value="L" class="sr-only peer" onchange="updatePrice()">
                                            <label for="size-l" class="flex items-center justify-center px-3 py-1 border rounded-full w-12 h-12 text-center cursor-pointer peer-checked:bg-[#e17f12] peer-checked:text-white hover:bg-gray-50 lg:h-10 lg:w-10 lg:text-sm">L</label>
                                        </div>
                                    </div>
                                </div>
                    
                                <!-- Sugar -->
                                <div class="p-4 bg-white rounded shadow">
                                    <label class="block font-medium text-gray-700 mb-2">Sugar:</label>
                                    <div class="flex items-center justify-center space-x-4">
                                        <div class="relative">
                                            <input type="radio" name="sugar" id="sugar-25" value="25" class="sr-only peer" onchange="updatePrice()">
                                            <label for="sugar-25" class="flex items-center justify-center px-3 py-1 border rounded-full w-12 h-12 text-center cursor-pointer peer-checked:bg-[#e17f12] peer-checked:text-white hover:bg-gray-50 lg:h-10 lg:w-10 lg:text-sm">25%</label>
                                        </div>
                                        <div class="relative">
                                            <input type="radio" name="sugar" id="sugar-50" value="50" class="sr-only peer" onchange="updatePrice()" checked>
                                            <label for="sugar-50" class="flex items-center justify-center px-3 py-1 border rounded-full w-12 h-12 text-center cursor-pointer peer-checked:bg-[#e17f12] peer-checked:text-white hover:bg-gray-50 lg:h-10 lg:w-10 lg:text-sm">50%</label>
                                        </div>
                                        <div class="relative">
                                            <input type="radio" name="sugar" id="sugar-75" value="75" class="sr-only peer" onchange="updatePrice()">
                                            <label for="sugar-75" class="flex items-center justify-center px-3 py-1 border rounded-full w-12 h-12 text-center cursor-pointer peer-checked:bg-[#e17f12] peer-checked:text-white hover:bg-gray-50 lg:h-10 lg:w-10 lg:text-sm">75%</label>
                                        </div>
                                    </div>
                                </div>
                    
                                <!-- Ice -->
                                <div class="p-4 bg-white rounded shadow">
                                    <label class="block font-medium text-gray-700 mb-2">Ice:</label>
                                    <div class="flex items-center justify-center space-x-4">
                                        <div class="relative">
                                            <input type="radio" name="ice" id="ice-25" value="25" class="sr-only peer" onchange="updatePrice()">
                                            <label for="ice-25" class="flex items-center justify-center px-3 py-1 border rounded-full w-12 h-12 text-center cursor-pointer peer-checked:bg-[#e17f12] peer-checked:text-white hover:bg-gray-50 lg:h-10 lg:w-10 lg:text-sm">25%</label>
                                        </div>
                                        <div class="relative">
                                            <input type="radio" name="ice" id="ice-50" value="50" class="sr-only peer" onchange="updatePrice()" checked>
                                            <label for="ice-50" class="flex items-center justify-center px-3 py-1 border rounded-full w-12 h-12 text-center cursor-pointer peer-checked:bg-[#e17f12] peer-checked:text-white hover:bg-gray-50 lg:h-10 lg:w-10 lg:text-sm">50%</label>
                                        </div>
                                        <div class="relative">
                                            <input type="radio" name="ice" id="ice-75" value="75" class="sr-only peer" onchange="updatePrice()">
                                            <label for="ice-75" class="flex items-center justify-center px-3 py-1 border rounded-full w-12 h-12 text-center cursor-pointer peer-checked:bg-[#e17f12] peer-checked:text-white hover:bg-gray-50 lg:h-10 lg:w-10 lg:text-sm">75%</label>
                                        </div>
                                    </div>
                                </div>
                    
                                <!-- Add Total Price and Topping Section -->
                                <div class="col-span-2 grid grid-cols-2 gap-4 mt-4">
                                    <!-- Topping Section -->
                                    <div class="p-4 bg-white rounded shadow">
                                        <label class="block font-medium text-gray-700 mb-2">Customized :</label>
                                        <div class="flex flex-col space-y-2">
                                            <div class="relative">
                                                <input type="radio" name="topping" id="topping-none" value="No Topping" class="sr-only peer" onchange="updatePrice()" checked>
                                                <label for="topping-none" 
                                                    class="block w-full px-4 py-2 border rounded cursor-pointer peer-checked:bg-[#e17f12] peer-checked:text-white hover:bg-gray-50 text-center lg:text-sm">
                                                    No Topping
                                                </label>
                                            </div>
                                            <div class="relative">
                                                <input type="radio" name="topping" id="topping-oat" value="Susu Oat" class="sr-only peer" onchange="updatePrice()">
                                                <label for="topping-oat" 
                                                    class="block w-full px-4 py-2 border rounded cursor-pointer peer-checked:bg-[#e17f12] peer-checked:text-white hover:bg-gray-50 text-center lg:text-sm">
                                                    Susu Oat +(5K)
                                                </label>
                                            </div>
                                            <div class="relative">
                                                <input type="radio" name="topping" id="topping-espresso" value="Espresso" class="sr-only peer" onchange="updatePrice()">
                                                <label for="topping-espresso" 
                                                    class="block w-full px-4 py-2 border rounded cursor-pointer peer-checked:bg-[#e17f12] peer-checked:text-white hover:bg-gray-50 text-center lg:text-sm">
                                                    Espresso +(4K)
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Total Price and Add to Order Section -->
                                    <div class="p-4 bg-white rounded shadow flex flex-col w-auto h-40">
                                        <div class="text-center">
                                            <label class="block font-medium text-gray-700 mb-2">Total Price:</label>
                                            <span id="total-price" class="text-2xl font-bold text-[#e17f12] block mb-3 lg:text-base"></span>
                                        </div>
                                        <button type="submit" class="w-full px-6 py-2 bg-[#005281] text-white rounded hover:bg-[#004371] transition-colors lg:text-sm">
                                            Add to Order
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @endforeach

        </section>

        <!-- Receipt Section -->
        <section class="w-1/6 bg-white p-6 shadow rounded font-mono text-sm receipt-section xl:w-1/6 lg:w-[20.83%]">
            <div class="text-center mb-4">
                <h1 class="text-xl font-bold">Struk Pesanan</h1>
                <p class="text-xs text-gray-500" id="current-date"></p>
                <p class="text-xs text-gray-500" id="cashier-name"></p>
            </div>

            <!-- Item List -->
            <div class="space-y-4 max-h-[500px] overflow-y-auto" id="item-list">
                <!-- Items will be dynamically added here -->
            </div>

            <hr class="border-dashed border-t-2 my-4">

            <!-- SubTotal -->
            <div class="flex justify-between text-lg font-bold text-green-600">
                <span class="lg:text-xs">Subtotal</span>
                <span id="subtotal" class="lg:text-xs">Rp. 0</span>
            </div>

            <hr class="border-dashed border-t-2 my-4">

            <!-- Hidden form for transaction -->
            <form id="transactionForm" method="POST" action="{{ route('owner.transaksitunai.store') }}" style="display: none;">
                @csrf
                <input type="hidden" name="subtotal" id="transaction_subtotal">
                <input type="hidden" name="total_cost_price" id="transaction_total_cost_price">
                <input type="hidden" name="name_user" id="transaction_name_user" value="{{ ucfirst(Auth::user()->name) }}">
                <input type="hidden" name="payment_method" id="transaction_payment_method" value="tunai">
                <input type="hidden" name="timestamp" id="transaction_timestamp">
            </form>

            <!-- Add this after the existing transactionForm -->
            <form id="transactionQRISForm" method="POST" action="{{ route('owner.transaksiqris.store') }}" style="display: none;">
                @csrf
                <input type="hidden" name="subtotal" id="transaction_qris_subtotal">
                <input type="hidden" name="total_cost_price" id="transaction_qris_total_cost_price">
                <input type="hidden" name="name_user" id="transaction_qris_name_user" value="{{ ucfirst(Auth::user()->name) }}">
                <input type="hidden" name="payment_method" id="transaction_qris_payment_method" value="qris">
                <input type="hidden" name="timestamp" id="transaction_qris_timestamp">
            </form>

            <!-- Buttons -->
            <div class="text-center space-y-2">
                <div class="text-center space-y-2 button-group">
                    <button onclick="processPayment()" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition-colors">Pay</button>
                    <button onclick="processQRISPayment()" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition-colors">Pay with QRIS</button>
                    <button onclick="printReceipt()" class="w-full border border-gray-300 py-2 rounded hover:bg-gray-50 transition-colors">Print</button>
                    <button onclick="clearOrder()" class="w-full border border-red-300 text-red-600 py-2 rounded hover:bg-red-50 transition-colors">Clear Order</button>
                </div>
            </div>
        </section>

    </div>

    <script>
        function toggleDropdown(button) {
          const dropdownMenus = document.querySelectorAll(".dropdown-menu");
          const dropdownArrows = document.querySelectorAll("i.bi-chevron-down");
      
          // Close all dropdowns except the selected one
          dropdownMenus.forEach((menu) => {
            if (menu !== button.nextElementSibling) {
              menu.classList.add("max-h-0");
              menu.classList.remove("max-h-40");
            }
          });
      
          // Reset all arrows except the selected one
          dropdownArrows.forEach((arrow) => {
            if (arrow !== button.querySelector("i.bi-chevron-down")) {
              arrow.classList.remove("rotate-180");
            }
          });
      
          // Toggle the selected dropdown
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
    <script>
        // Set current date and cashier name when page loads
        document.addEventListener('DOMContentLoaded', function() {
            const currentDate = new Date();
            document.getElementById('current-date').textContent = currentDate.toLocaleString('en-US', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('cashier-name').textContent = '{{ ucfirst(Auth::user()->name) }}';
            
            // Initialize price for all forms
            document.querySelectorAll('form[data-product-price]').forEach(form => {
                updatePrice.call(form);
            });
        });

        // Function to toggle dropdown
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

        // Function to increment amount
        function incrementAmount() {
            const button = event.target;
            const form = button.closest('form');
            let amountField = form.querySelector('input[name="amount"]');
            amountField.value = parseInt(amountField.value) + 1;
            updatePrice.call(form);
        }

        // Function to decrement amount
        function decrementAmount() {
            const button = event.target;
            const form = button.closest('form');
            let amountField = form.querySelector('input[name="amount"]');
            if (parseInt(amountField.value) > 1) {
                amountField.value = parseInt(amountField.value) - 1;
                updatePrice.call(form);
            }
        }

        // Function to format Rupiah
        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(number).replace('IDR', 'Rp').trim();
        }

        // Function to update price
        function updatePrice() {
            const form = this.tagName === 'FORM' ? this : this.closest('form');
            const basePrice = parseInt(form.getAttribute('data-product-price'));
            const amount = parseInt(form.querySelector('input[name="amount"]').value);
            const size = form.querySelector('input[name="size"]:checked');
            const topping = form.querySelector('input[name="topping"]:checked');

            // Add console.log for debugging
            console.log('Base Price:', basePrice);
            console.log('Form:', form);

            let itemPrice = basePrice;
            let customizations = [];

            if (size && size.value === 'L') {
                itemPrice += 3000;
                customizations.push('Size L (+3K)');
            }

            if (topping) {
                if (topping.value === 'Susu Oat') {
                    itemPrice += 5000;
                    customizations.push('Susu Oat (+5K)');
                } else if (topping.value === 'Espresso') {
                    itemPrice += 4000;
                    customizations.push('Espresso (+4K)');
                }
            }

            const totalPrice = itemPrice * amount;

            const totalPriceElement = form.querySelector('#total-price');
            if (totalPriceElement) {
                totalPriceElement.textContent = formatRupiah(totalPrice);
            }
            
            form.setAttribute('data-base-price', basePrice);
            form.setAttribute('data-item-price', itemPrice);
            form.setAttribute('data-customizations', JSON.stringify(customizations));
        }

        // Function to add order
        function addToOrder(event) {
            event.preventDefault();

            const form = event.target;
            const productName = form.getAttribute('data-product-name');
            const basePrice = parseInt(form.getAttribute('data-base-price'));
            const itemPrice = parseInt(form.getAttribute('data-item-price'));
            const customizations = JSON.parse(form.getAttribute('data-customizations') || '[]');

            const size = form.querySelector('input[name="size"]:checked');
            const sugar = form.querySelector('input[name="sugar"]:checked');
            const ice = form.querySelector('input[name="ice"]:checked');
            const topping = form.querySelector('input[name="topping"]:checked');

            if (!size || !sugar || !ice || !topping) {
                alert('Please select all options before adding to order');
                return;
            }

            const amount = parseInt(form.querySelector('input[name="amount"]').value);
            const totalPrice = itemPrice * amount;

            const item = document.createElement('div');
            item.className = 'flex flex-col border-b pb-2 mb-3';
            item.innerHTML = `
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="flex justify-between">
                            <span class="font-semibold lg:text-xs">${productName} x${amount}</span>
                        </div>
                        <ul class="ml-2 text-gray-600 text-xs mt-1">
                            <li>Size: ${size.value}</li>
                            <li>Sugar: ${sugar.value}%</li>
                            <li>Ice: ${ice.value}%</li>
                            <li>Topping: ${topping.value}</li>
                            <li>Base Price: ${formatRupiah(basePrice)}</li>
                            ${customizations.length > 0 ? 
                                `<li class="text-xs text-gray-500">Add-ons: ${customizations.join(', ')}</li>` : 
                                ''}
                            <li class="font-semibold lg:text-xs">Total: ${formatRupiah(totalPrice)}</li>
                        </ul>
                    </div>
                    <button type="button" onclick="removeItem(this)" class="ml-2 text-red-500 hover:text-red-700 text-xs">×</button>
                </div>
            `;

            const itemList = document.getElementById('item-list');
            itemList.appendChild(item);

            updateSubtotal();

            form.querySelector('input[name="amount"]').value = 1;
            form.querySelector('#size-m').checked = true;
            form.querySelector('#sugar-50').checked = true;
            form.querySelector('#ice-50').checked = true;
            form.querySelector('#topping-none').checked = true;
            updatePrice.call(form);
        }

        // Function to remove item
        function removeItem(button) {
            const item = button.closest('.flex.flex-col');
            item.remove();
            updateSubtotal();
        }

        // Function to update subtotal
        function updateSubtotal() {
            const itemList = document.getElementById('item-list');
            const prices = itemList.querySelectorAll('.text-xs.mt-1 li:last-child');
            let subtotal = 0;

            prices.forEach(price => {
                const priceText = price.textContent;
                const priceNumber = parseInt(priceText.split(': ')[1].replace(/[^\d]/g, ''));
                subtotal += priceNumber;
            });

            document.getElementById('subtotal').textContent = formatRupiah(subtotal);
        }

            // Updated processPayment function without payment method selection
            async function processPayment() {
                const subtotalElement = document.getElementById('subtotal');
                const subtotalText = subtotalElement.textContent;
                
                if (subtotalText === 'Rp 0') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Empty Order',
                        text: 'Please add items to your order before proceeding to payment',
                        confirmButtonColor: '#e17f12'
                    });
                    return;
                }

                // Calculate total cost price
                let totalCostPrice = 0;
                const itemList = document.getElementById('item-list');
                const items = itemList.querySelectorAll('.flex.flex-col');
                
                items.forEach(item => {
                    const productName = item.querySelector('.font-semibold').textContent.split(' x')[0];
                    const quantity = parseInt(item.querySelector('.font-semibold').textContent.split('x')[1]);
                    const form = document.querySelector(`form[data-product-name="${productName}"]`);
                    const baseCostPrice = parseFloat(form.getAttribute('data-cost-price'));
                    
                    let itemCostPrice = baseCostPrice;
                    const size = item.querySelector('li:nth-child(1)').textContent.split(': ')[1];
                    const topping = item.querySelector('li:nth-child(4)').textContent.split(': ')[1];

                    if (size === 'L') {
                        itemCostPrice += 1500;
                    }
                    if (topping === 'Susu Oat') {
                        itemCostPrice += 2500;
                    } else if (topping === 'Espresso') {
                        itemCostPrice += 2000;
                    }

                    totalCostPrice += (itemCostPrice * quantity);
                });

                const now = new Date();
                const timestamp = now.getFullYear() + '-' + 
                                String(now.getMonth() + 1).padStart(2, '0') + '-' + 
                                String(now.getDate()).padStart(2, '0') + ' ' + 
                                String(now.getHours()).padStart(2, '0') + ':' + 
                                String(now.getMinutes()).padStart(2, '0') + ':' + 
                                String(now.getSeconds()).padStart(2, '0');

                // Show confirmation dialog
                const { isConfirmed } = await Swal.fire({
                    title: 'Confirm Payment',
                    text: `Confirm payment for ${subtotalText}?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#e17f12',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, process payment',
                    cancelButtonText: 'Cancel'
                });

                if (isConfirmed) {
                    // Set form values
                    const subtotal = parseFloat(subtotalText.replace(/[^\d]/g, ''));
                    document.getElementById('transaction_subtotal').value = subtotal;
                    document.getElementById('transaction_total_cost_price').value = totalCostPrice.toFixed(2);
                    document.getElementById('transaction_timestamp').value = timestamp;
                    document.getElementById('transaction_payment_method').value = 'tunai'; // Set default payment method to tunai

                    // Show loading state
                    Swal.fire({
                        title: 'Processing Payment',
                        text: 'Please wait...',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Submit the form
                    try {
                        await document.getElementById('transactionForm').submit();
                        
                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Payment Successful',
                            text: 'Your transaction has been processed successfully!',
                            confirmButtonColor: '#e17f12'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Optional: Redirect or refresh page
                                // window.location.reload();
                            }
                        });
                    } catch (error) {
                        // Show error message if something goes wrong
                        Swal.fire({
                            icon: 'error',
                            title: 'Payment Failed',
                            text: 'There was an error processing your payment. Please try again.',
                            confirmButtonColor: '#e17f12'
                        });
                    }
                }
            }

            async function processQRISPayment() {
                const subtotalElement = document.getElementById('subtotal');
                const subtotalText = subtotalElement.textContent;
                
                if (subtotalText === 'Rp 0') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Empty Order',
                        text: 'Please add items to your order before proceeding to payment',
                        confirmButtonColor: '#e17f12'
                    });
                    return;
                }

                // Show QRIS code first
                const { isConfirmed: scanConfirmed } = await Swal.fire({
                    title: 'Scan QRIS Code',
                    html: `
                        <div class="flex flex-col items-center">
                            <img src="{{ asset('assets/qris-bblara.png') }}" 
                                alt="QRIS Code" 
                                class="w-64 h-64 object-contain mb-4">
                            <p class="text-sm text-gray-600">Please scan the QRIS code above to make your payment</p>
                            <p class="font-bold mt-2">Total: ${subtotalText}</p>
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'I have completed the payment',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#e17f12',
                    cancelButtonColor: '#d33',
                    width: 'auto'
                });

                if (!scanConfirmed) {
                    return;
                }

                // Calculate total cost price
                let totalCostPrice = 0;
                const itemList = document.getElementById('item-list');
                const items = itemList.querySelectorAll('.flex.flex-col');
                
                items.forEach(item => {
                    const productName = item.querySelector('.font-semibold').textContent.split(' x')[0];
                    const quantity = parseInt(item.querySelector('.font-semibold').textContent.split('x')[1]);
                    const form = document.querySelector(`form[data-product-name="${productName}"]`);
                    const baseCostPrice = parseFloat(form.getAttribute('data-cost-price'));
                    
                    let itemCostPrice = baseCostPrice;
                    const size = item.querySelector('li:nth-child(1)').textContent.split(': ')[1];
                    const topping = item.querySelector('li:nth-child(4)').textContent.split(': ')[1];

                    if (size === 'L') {
                        itemCostPrice += 1500;
                    }
                    if (topping === 'Susu Oat') {
                        itemCostPrice += 2500;
                    } else if (topping === 'Espresso') {
                        itemCostPrice += 2000;
                    }

                    totalCostPrice += (itemCostPrice * quantity);
                });

                const now = new Date();
                const timestamp = now.getFullYear() + '-' + 
                                String(now.getMonth() + 1).padStart(2, '0') + '-' + 
                                String(now.getDate()).padStart(2, '0') + ' ' + 
                                String(now.getHours()).padStart(2, '0') + ':' + 
                                String(now.getMinutes()).padStart(2, '0') + ':' + 
                                String(now.getSeconds()).padStart(2, '0');

                // Show final confirmation dialog
                const { isConfirmed } = await Swal.fire({
                    title: 'Confirm QRIS Payment',
                    text: `Confirm that you have completed the QRIS payment for ${subtotalText}?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#e17f12',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, payment completed',
                    cancelButtonText: 'Cancel'
                });

                if (isConfirmed) {
                    // Set form values for QRIS transaction
                    const subtotal = parseFloat(subtotalText.replace(/[^\d]/g, ''));
                    document.getElementById('transaction_qris_subtotal').value = subtotal;
                    document.getElementById('transaction_qris_total_cost_price').value = totalCostPrice.toFixed(2);
                    document.getElementById('transaction_qris_timestamp').value = timestamp;

                    // Show loading state
                    Swal.fire({
                        title: 'Processing QRIS Payment',
                        text: 'Please wait...',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Submit the QRIS form
                    try {
                        await document.getElementById('transactionQRISForm').submit();
                        
                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'QRIS Payment Successful',
                            text: 'Your QRIS transaction has been processed successfully!',
                            confirmButtonColor: '#e17f12'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Optional: Redirect or refresh page
                                // window.location.reload();
                            }
                        });
                    } catch (error) {
                        // Show error message if something goes wrong
                        Swal.fire({
                            icon: 'error',
                            title: 'QRIS Payment Failed',
                            text: 'There was an error processing your QRIS payment. Please try again.',
                            confirmButtonColor: '#e17f12'
                        });
                    }
                }
            }

        // Function to print receipt
        function printReceipt() {
            const subtotal = document.getElementById('subtotal').textContent;
            if (subtotal === 'Rp 0') {
                alert('No items in the order to print');
                return;
            }
            window.print();
        }

        // Function to clear order
        function clearOrder() {
            const itemList = document.getElementById('item-list');
            if (itemList.children.length === 0) {
                alert('Order is already empty');
                return;
            }
            if (confirm('Are you sure you want to clear the entire order?')) {
                itemList.innerHTML = '';
                updateSubtotal();
            }
        }

        // Add event listeners
        document.querySelectorAll('input[name="size"], input[name="topping"]').forEach(input => {
            input.addEventListener('change', function() {
                updatePrice.call(this.closest('form'));
            });
        });

        // Search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const clearButton = document.getElementById('clearSearch');
            const productForms = document.querySelectorAll('form[data-product-name]');

            function filterProducts(searchTerm) {
                searchTerm = searchTerm.toLowerCase().trim();
                
                productForms.forEach(form => {
                    const productName = form.getAttribute('data-product-name').toLowerCase();
                    const productCard = form.closest('.p-6');
                    
                    if (productName.includes(searchTerm)) {
                        productCard.style.display = '';
                        // Highlight matching text if there's a search term
                        const titleElement = form.querySelector('h2');
                        if (searchTerm !== '') {
                            const regex = new RegExp(`(${searchTerm})`, 'gi');
                            const originalText = titleElement.textContent;
                            titleElement.innerHTML = originalText.replace(
                                regex, 
                                '<span class="bg-yellow-200">$1</span>'
                            );
                        } else {
                            // Remove highlighting if search is cleared
                            titleElement.innerHTML = titleElement.textContent;
                        }
                    } else {
                        productCard.style.display = 'none';
                    }
                });
            }

            function clearSearchInput() {
                searchInput.value = '';
                clearButton.classList.add('hidden');
                filterProducts('');
                searchInput.focus();
            }

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value;
                filterProducts(searchTerm);
                
                // Toggle clear button visibility
                if (searchTerm) {
                    clearButton.classList.remove('hidden');
                } else {
                    clearButton.classList.add('hidden');
                }
            });

            // Clear search when pressing Escape key
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    clearSearchInput();
                }
            });

            // Make clearSearchInput function globally available
            window.clearSearchInput = clearSearchInput;
        });
    </script>
    <script>
        // Konfigurasi default Toastr
        document.addEventListener('DOMContentLoaded', function() {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
        });

        // Function to clear order with Toastr
        function clearOrder() {
            const itemList = document.getElementById('item-list');
            if (itemList.children.length === 0) {
                toastr.warning('Order is already empty!', 'Warning');
                return;
            }

            // Show confirmation using SweetAlert2
            Swal.fire({
                title: 'Clear Order?',
                text: 'Are you sure you want to clear the entire order?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e17f12',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, clear it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    itemList.innerHTML = '';
                    updateSubtotal();
                    
                    // Show success message with Toastr
                    toastr.success('Order has been cleared successfully!', 'Success');
                }
            });
        }
    </script>

</body>
</html>
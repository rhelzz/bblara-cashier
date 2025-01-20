<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cashier - Bblara</title>

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

    <div class="flex">

        <!-- Navbar Owner -->
        <x-navbar-owner></x-navbar-owner>

        <!-- Main Content -->
        <section class="w-4/6 bg-white shadow rounded">
            <x-navbar-top-owner></x-navbar-top-owner>

            <!-- Main content section -->
            <form class="p-6" method="POST" action="#" onsubmit="addToOrder(event)">
                <div class="w-full p-6 bg-white rounded shadow-lg">
                    <header class="mb-4">
                        <h2 class="font-bold text-xl text-green-700">01. Macchiato Milk Tea (Rp. 45.000)</h2>
                    </header>
                
                    <!-- Kontainer untuk gambar dan kontrol -->
                    <div class="flex gap-6">
                        <!-- Gambar -->
                        <figure class="w-1/3">
                            <img src="https://placehold.co/300x300/png" alt="Macchiato Milk Tea" class="w-auto h-60 object-cover rounded">
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
                                        <input type="radio" name="size" id="size-s" value="S" class="sr-only peer" onchange="updatePrice()" checked>
                                        <label for="size-s" class="flex items-center justify-center px-3 py-1 border rounded-full w-12 h-12 text-center cursor-pointer peer-checked:bg-[#e17f12] peer-checked:text-white hover:bg-gray-50 lg:h-10 lg:w-10 lg:text-sm">S</label>
                                    </div>
                                    <div class="relative">
                                        <input type="radio" name="size" id="size-m" value="M" class="sr-only peer" onchange="updatePrice()">
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
                                    <label class="block font-medium text-gray-700 mb-2">Topping:</label>
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
                                        <span id="total-price" class="text-2xl font-bold text-[#e17f12] block mb-3 lg:text-base">Rp. 45.000</span>
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
        </section>

        <!-- Receipt Section -->
        <section class="w-1/6 bg-white p-6 shadow rounded font-mono text-sm receipt-section">
            <div class="text-center mb-4">
                <h1 class="text-xl font-bold">Receipt</h1>
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

            <!-- Buttons -->
            <div class="text-center space-y-2">
                <div class="text-center space-y-2 button-group">
                    <button onclick="processPayment()" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition-colors">Pay</button>
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
        window.onload = function() {
            const currentDate = new Date();
            document.getElementById('current-date').textContent = currentDate.toLocaleString('en-US', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('cashier-name').textContent = 'Cashier: rhelzz';
            updatePrice();
        };

        // Function to increment the amount
        function incrementAmount() {
            let amountField = document.querySelector('input[name="amount"]');
            amountField.value = parseInt(amountField.value) + 1;
            updatePrice();
        }

        // Function to decrement the amount
        function decrementAmount() {
            let amountField = document.querySelector('input[name="amount"]');
            if (parseInt(amountField.value) > 1) {
                amountField.value = parseInt(amountField.value) - 1;
                updatePrice();
            }
        }

        // Function to format number as Rupiah
        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(number).replace('IDR', 'Rp').trim();
        }

        // Function to update the price based on the selected options
        function updatePrice() {
            const basePrice = 45000;
            const amount = parseInt(document.querySelector('input[name="amount"]').value);
            const size = document.querySelector('input[name="size"]:checked');
            const topping = document.querySelector('input[name="topping"]:checked');

            let totalPrice = basePrice;

            if (size && size.value === 'M') {
                totalPrice += 5000;
            } else if (size && size.value === 'L') {
                totalPrice += 10000;
            }

            if (topping && topping.value === 'Susu Oat') {
                totalPrice += 5000;
            } else if (topping && topping.value === 'Espresso') {
                totalPrice += 4000;
            }

            totalPrice *= amount;

            document.getElementById('total-price').textContent = formatRupiah(totalPrice);
        }

        // Function to add item to the order
        function addToOrder(event) {
            event.preventDefault();

            // Validate selections
            const size = document.querySelector('input[name="size"]:checked');
            const sugar = document.querySelector('input[name="sugar"]:checked');
            const ice = document.querySelector('input[name="ice"]:checked');
            const topping = document.querySelector('input[name="topping"]:checked');

            if (!size || !sugar || !ice || !topping) {
                alert('Please select all options before adding to order');
                return;
            }

            const itemList = document.getElementById('item-list');
            const amount = document.querySelector('input[name="amount"]').value;
            const totalPriceText = document.getElementById('total-price').textContent;
            const totalPrice = parseInt(totalPriceText.replace(/[^\d]/g, ''));

            // Create a new item element
            const item = document.createElement('div');
            item.className = 'flex flex-col border-b pb-2 mb-3';
            item.innerHTML = `
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="flex justify-between">
                            <span class="font-semibold lg:text-xs">Macchiato Milk Tea x${amount}</span>
                        </div>
                        <ul class="ml-2 text-gray-600 text-xs mt-1">
                            <li>Size: ${size.value}</li>
                            <li>Sugar: ${sugar.value}%</li>
                            <li>Ice: ${ice.value}%</li>
                            <li>Topping: ${topping.value}</li>
                            <li class="font-semibold lg:text-xs">Total: ${formatRupiah(totalPrice)}</li>
                        </ul>
                    </div>
                    <button type="button" onclick="removeItem(this)" class="ml-2 text-red-500 hover:text-red-700 text-xs">×</button>
                </div>
            `;

            // Add the new item to the item list
            itemList.appendChild(item);

            // Update the subtotal
            updateSubtotal();

            // Reset form to default values
            document.querySelector('input[name="amount"]').value = 1;
            document.getElementById('size-s').checked = true;
            document.getElementById('sugar-50').checked = true;
            document.getElementById('ice-50').checked = true;
            document.getElementById('topping-none').checked = true;
            updatePrice();
        }

        // Function to remove item from order
        function removeItem(button) {
            const item = button.closest('.flex.flex-col');
            item.remove();
            updateSubtotal();
        }

        // Function to update the subtotal
        function updateSubtotal() {
            const itemList = document.getElementById('item-list');
            // Ubah selector untuk mengambil elemen yang berisi total harga
            const prices = itemList.querySelectorAll('.text-xs.mt-1 li:last-child');
            let subtotal = 0;

            prices.forEach(price => {
                // Mengambil angka dari teks "Total: Rp XX.XXX"
                const priceText = price.textContent;
                const priceNumber = parseInt(priceText.split(': ')[1].replace(/[^\d]/g, ''));
                subtotal += priceNumber;
            });

            document.getElementById('subtotal').textContent = formatRupiah(subtotal);
        }

        // Function to process payment
        function processPayment() {
            const subtotal = document.getElementById('subtotal').textContent;
            if (subtotal === 'Rp 0') {
                alert('Please add items to your order before proceeding to payment');
                return;
            }
            alert('Processing payment for ' + subtotal);
            // Add your payment processing logic here
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
    </script>

</body>
</html>
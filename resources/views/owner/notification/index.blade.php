<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Notifications - Bblara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" />
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
        <!-- Toggle Button for Sidebar -->
        <button class="fixed text-white text-3xl top-5 left-4 p-2 rounded-md bg-gray-700 lg:hidden focus:outline-none z-50" onclick="toggleSidebar()">
            <i class="bi bi-list"></i>
        </button>

        <!-- Sidebar -->
        <x-navbar-owner></x-navbar-owner>

        <!-- Main Content -->
        <div class="flex-1 lg:w-5/6">
            {{-- Navbar Top --}}
            <x-navbar-top-owner></x-navbar-top-owner>

            <!-- Content Wrapper -->
            <div class="p-4 lg:px-8 py-0">
                <div class="p-6 bg-gray-100 min-h-screen">
                    <div class="max-w-7xl mx-auto">
                        <div class="max-w-4xl mx-auto py-8">
                            <div class="bg-white shadow-md rounded-lg p-4">
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-xl font-semibold">Notifications</h2>
                                    <button id="clear-all-btn" class="bg-red-500 text-white px-4 py-2 rounded">Clear All</button>
                                </div>
                                @if($notifications->isEmpty())
                                    <p>No notifications found.</p>
                                @else
                                    @foreach ($notifications as $notification)
                                        <div class="bg-gray-50 p-4 rounded-lg mb-4">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <div>
                                                        <p class="text-gray-800">{{ $notification->message }}</p>
                                                        <p class="text-gray-500 text-sm">{{ $notification->created_at->format('h:i A') }}</p>
                                                    </div>
                                                </div>
                                                <div class="text-gray-500 text-sm">
                                                    <div class="flex items-center">
                                                        <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                                                        {{ $notification->created_at->format('F j, Y') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="text-center mt-4">
                                    <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded">Load more</button>
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
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('hidden');
        }

        function toggleDeleteModal() {
            const modal = document.getElementById('deleteModal');
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            } else {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        }

        document.getElementById('clear-all-btn').addEventListener('click', function () {
            if (confirm('Are you sure you want to clear all notifications?')) {
                fetch('/owner/notifications/clear-all', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Failed to clear notifications.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to clear notifications.');
                });
            }
        });
    </script>
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
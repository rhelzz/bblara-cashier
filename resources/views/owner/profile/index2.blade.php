<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - {{ $user->name }}</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
    <!-- Font CDN -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Raleway', sans-serif;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            background-color: #F9FAFB;
            border-color: #E5E7EB;
        }
    
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            background-color: #F3F4F6;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Toggle Button for Sidebar -->
        <button class="fixed text-white text-3xl top-5 left-4 p-2 rounded-md bg-gray-700 lg:hidden focus:outline-none z-50" onclick="toggleSidebar()">
            <i class="bi bi-list"></i>
        </button>

        <!-- Main Content -->
        <div class="flex-1 lg:w-5/6">
            <div class="p-4 lg:p-8">
                <!-- Back Button -->
                <div class="mb-6">
                    <a href="{{ route('owner.dashboard.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                        <i class="bi bi-arrow-left mr-2"></i>
                        Back to Dashboard
                    </a>
                </div>

                <!-- Welcome Message -->
                <div class="bg-white p-6 mb-6 rounded-lg flex items-center shadow space-x-4">
                    <i class="bi bi-person-circle text-5xl text-[#005281]"></i>
                    <div>
                        <h2 class="text-2xl lg:text-2xl font-semibold text-gray-700">Profile Settings</h2>
                        <p class="text-gray-600 text-base">Manage your account settings and preferences</p>
                    </div>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded relative mb-4 text-base" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="space-y-8">
                    <!-- Profile Information -->
                    <div class="bg-white p-8 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold text-gray-700 mb-6">Profile Information</h3>
                        <form action="{{ route('owner.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <!-- Avatar -->
                            <div class="flex items-center space-x-6 mb-6">
                                <div class="w-32 h-32 rounded-full overflow-hidden bg-gray-200">
                                    @if($user->avatar)
                                        <img src="{{ Storage::url('avatars/' . $user->avatar) }}" alt="Profile" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <i class="bi bi-person-fill text-6xl"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <input type="file" name="avatar" id="avatar" class="hidden" accept="image/*">
                                    <label for="avatar" class="cursor-pointer px-6 py-3 text-base bg-[#005281] text-white rounded-md hover:bg-[#003d61] focus:outline-none focus:ring-2 focus:ring-[#005281] focus:ring-opacity-50 transition-colors duration-200">
                                        Change Avatar
                                    </label>
                                </div>
                            </div>

                            <!-- Name -->
                            <div class="space-y-2">
                                <label for="name" class="block text-base font-medium text-gray-700">Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                                    class="h-12 px-4 mt-1 block w-full text-base rounded-md border-gray-300 shadow-sm focus:border-[#005281] focus:ring focus:ring-[#005281] focus:ring-opacity-50">
                                @error('name')
                                    <p class="text-red-500 text-base mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="space-y-2">
                                <label for="email" class="block text-base font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                    class="h-12 px-4 mt-1 block w-full text-base rounded-md border-gray-300 shadow-sm focus:border-[#005281] focus:ring focus:ring-[#005281] focus:ring-opacity-50">
                                @error('email')
                                    <p class="text-red-500 text-base mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" 
                                class="w-full sm:w-auto px-6 py-3 text-base bg-[#005281] text-white rounded-md hover:bg-[#003d61] focus:outline-none focus:ring-2 focus:ring-[#005281] focus:ring-opacity-50 transition-colors duration-200">
                                Save Changes
                            </button>
                        </form>
                    </div>

                    <!-- Update Password -->
                    <div class="bg-white p-8 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold text-gray-700 mb-6">Update Password</h3>
                        <form action="{{ route('owner.profile.password') }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <div class="space-y-2">
                                <label for="current_password" class="block text-base font-medium text-gray-700">Current Password</label>
                                <input type="password" name="current_password" id="current_password"
                                    class="h-12 px-4 mt-1 block w-full text-base rounded-md border-gray-300 shadow-sm focus:border-[#005281] focus:ring focus:ring-[#005281] focus:ring-opacity-50">
                                @error('current_password')
                                    <p class="text-red-500 text-base mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="password" class="block text-base font-medium text-gray-700">New Password</label>
                                <input type="password" name="password" id="password"
                                    class="h-12 px-4 mt-1 block w-full text-base rounded-md border-gray-300 shadow-sm focus:border-[#005281] focus:ring focus:ring-[#005281] focus:ring-opacity-50">
                                @error('password')
                                    <p class="text-red-500 text-base mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="password_confirmation" class="block text-base font-medium text-gray-700">Confirm New Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="h-12 px-4 mt-1 block w-full text-base rounded-md border-gray-300 shadow-sm focus:border-[#005281] focus:ring focus:ring-[#005281] focus:ring-opacity-50">
                            </div>

                            <button type="submit"
                                class="w-full sm:w-auto px-6 py-3 text-base bg-[#005281] text-white rounded-md hover:bg-[#003d61] focus:outline-none focus:ring-2 focus:ring-[#005281] focus:ring-opacity-50 transition-colors duration-200">
                                Update Password
                            </button>
                        </form>
                    </div>

                    <!-- Delete Account -->
                    <div class="bg-white p-8 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold text-gray-700 mb-4">Delete Account</h3>
                        <p class="text-base text-gray-600 mb-6">
                            Once your account is deleted, all of its resources and data will be permanently deleted.
                        </p>
                        <button onclick="toggleDeleteModal()"
                            class="px-6 py-3 text-base bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition-colors duration-200">
                            Delete Account
                        </button>
                    </div>
                </div>

                <!-- Footer -->
                <footer class="text-gray-400 text-center py-6 mt-8">
                    <p class="text-base">Copyright &#169; 2024 Bblaratech3. All Rights Reserved.</p>
                </footer>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('hidden');
        }

        function toggleDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.toggle('hidden');
            modal.classList.toggle('flex');
        }

        // Preview avatar image before upload
        document.getElementById('avatar').addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.w-20.h-20 img').src = e.target.result;
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    </script>
</body>
</html>
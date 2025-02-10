<div class="flex justify-between items-center p-4 bg-white shadow">
    <!-- Bagian Kiri: Dashboard Label -->
    <div class="flex items-center">
        <i class="fas fa-chart-bar text-gray-500 mr-2"></i>
        <span class="text-gray-700 font-semibold">BBlarA - Pos</span>
    </div>

    <!-- Bagian Kanan: Profile dan Notifikasi -->
    <div class="flex items-center space-x-4">
        <!-- Notifikasi -->
        <i class="bi bi-bell-fill text-gray-500 text-xl cursor-pointer"></i>

        <!-- Profil Pengguna -->
        <div class="flex items-center">
            <span class="text-gray-700 mr-2">Hai, {{ ucfirst(auth()->user()->name) . (' - ') . ucfirst(auth()->user()->usertype) }}</span>
            
            <a href="{{ route('owner.profile.index') }}" class="flex items-center hover:opacity-80 transition-opacity">
                @php
                    $avatarPath = auth()->user()->avatar 
                        ? asset('storage/avatars/' . auth()->user()->avatar) 
                        : 'https://via.placeholder.com/40?text=User';
                @endphp
                <img src="{{ $avatarPath }}" alt="Profile" class="w-10 h-10 rounded-full border-2 border-gray-300 object-cover">
            </a>
        </div>
    </div>
</div>

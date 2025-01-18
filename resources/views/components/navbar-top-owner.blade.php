<div class="flex justify-between items-center p-4 bg-white shadow">
    <!-- Bagian Kiri: Dashboard Label -->
    <div class="flex items-center">
        <i class="fas fa-chart-bar text-gray-500 mr-2"></i>
        <span class="text-gray-700 font-semibold">Dashboard</span>
    </div>

    <!-- Bagian Kanan: Profile dan Notifikasi -->
    <div class="flex items-center space-x-4">

        <!-- Teks "Hi, [Nama Pengguna]" dan Ikon Profil di sebelah kanan -->
        <div class="flex items-center">
            <span class="text-gray-700 mr-2">Hai!!, {{ ucfirst(Auth::user()->name) }}</span>
            <i class="bi bi-person-circle text-gray-500 text-2xl"></i>
        </div>

        <!-- Ikon Notifikasi di sebelah kiri -->
        <i class="bi bi-bell-fill text-gray-500 text-xl mr-4"></i>

    </div>
</div>

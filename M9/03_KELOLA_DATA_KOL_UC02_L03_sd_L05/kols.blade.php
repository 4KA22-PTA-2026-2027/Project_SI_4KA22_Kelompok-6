@extends('layouts.app')
@section('title', 'Data KOL - Admin Siapamau')
@section('content')
<div class="min-h-screen bg-[#FAF5F0] pb-28 md:pb-12">

    <!-- Top Sticky Header -->
    <div class="bg-white/90 backdrop-blur-md px-5 pt-8 pb-3 border-b border-gray-100 sticky top-0 z-30">
        <div class="max-w-md mx-auto space-y-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.dashboard') }}" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:text-[#8B1F33] transition-colors">
                        <i class="fas fa-arrow-left text-xs"></i>
                    </a>
                    <h1 class="font-serif text-lg font-bold text-gray-900">Data KOL</h1>
                </div>
                <span class="text-xs font-semibold text-gray-500">
                    {{ $kols->count() }} Creator
                </span>
            </div>

            <!-- Search Bar -->
            <div class="relative">
                <input type="text" id="searchKolInput" onkeyup="searchKolTable()" placeholder="Cari nama kreator atau email..."
                       class="w-full bg-[#FAF5F0] border border-gray-200 rounded-2xl pl-10 pr-4 py-2.5 text-xs text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#8B1F33]/20 focus:border-[#8B1F33]">
                <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="max-w-md mx-auto px-5 pt-4 space-y-3" id="kolListContainer">

        @forelse($kols as $kol)
            <div class="kol-item bg-white rounded-3xl p-4 border border-gray-100 shadow-sm space-y-3">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-[#8B1F33] to-[#C44C65] text-white flex items-center justify-center font-bold text-sm shadow-xs overflow-hidden flex-shrink-0">
                            @if($kol->user->avatar)
                                <img src="{{ asset('storage/'.$kol->user->avatar) }}" class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr($kol->user->name, 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-xs flex items-center gap-1">
                                <span class="kol-name">{{ $kol->user->name }}</span>
                                <i class="fas fa-check-circle text-amber-500 text-[10px]"></i>
                            </h4>
                            <p class="text-[10px] text-gray-400">{{ $kol->user->email }}</p>
                            <span class="inline-block mt-0.5 text-[9px] font-bold text-[#8B1F33] bg-[#8B1F33]/10 px-2 py-0.5 rounded-full uppercase">
                                {{ $kol->category->name ?? 'Lifestyle' }}
                            </span>
                        </div>
                    </div>

                    <span class="text-[9px] font-bold px-2 py-0.5 rounded-full uppercase bg-emerald-50 text-emerald-700 border border-emerald-200">
                        Aktif
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-2 bg-[#FAF5F0] rounded-2xl p-2.5 text-center border border-gray-100">
                    <div>
                        <p class="text-[9px] text-gray-400 uppercase font-semibold">Followers</p>
                        <p class="font-serif text-xs font-bold text-gray-900 mt-0.5">
                            {{ $kol->followers ? number_format($kol->followers) : '150K+' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[9px] text-gray-400 uppercase font-semibold">Engagement</p>
                        <p class="font-serif text-xs font-bold text-gray-900 mt-0.5">8.4%</p>
                    </div>
                </div>

                <div class="pt-1 flex items-center justify-between text-xs">
                    <span class="text-gray-500 text-[11px]">
                        Rate: <strong class="text-gray-900">Rp {{ number_format($kol->rate ?? 1500000, 0, ',', '.') }}</strong>
                    </span>
                    <a href="{{ route('admin.kols.show', $kol->id) }}"
                       class="bg-[#8B1F33] hover:bg-[#701828] text-white text-xs font-semibold px-4 py-1.5 rounded-xl transition-colors shadow-xs">
                        Lihat Data
                    </a>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-3xl p-10 text-center text-gray-400 border border-gray-100">
                <i class="fas fa-users text-3xl mb-2 text-[#8B1F33]/20"></i>
                <p class="text-xs">Belum ada creator terdaftar.</p>
            </div>
        @endforelse

    </div>
</div>

<!-- Bottom Navigation Bar (Admin) -->
<nav class="fixed bottom-0 left-0 w-full bg-white/95 backdrop-blur-md border-t border-gray-200/80 z-50">
    <div class="max-w-md mx-auto flex justify-around items-center py-2.5 px-3">
        <!-- Beranda -->
        <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center gap-1 text-gray-400 hover:text-[#8B1F33] transition-colors">
            <div class="w-8 h-8 rounded-full flex items-center justify-center">
                <i class="fas fa-chart-pie text-sm"></i>
            </div>
            <span class="text-[10px]">Beranda</span>
        </a>

        <!-- Kelola Job -->
        <a href="{{ route('admin.jobs.index') }}" class="flex flex-col items-center gap-1 text-gray-400 hover:text-[#8B1F33] transition-colors">
            <div class="w-8 h-8 rounded-full flex items-center justify-center">
                <i class="fas fa-briefcase text-sm"></i>
            </div>
            <span class="text-[10px]">Job</span>
        </a>

        <!-- Permintaan -->
        <a href="{{ route('admin.requests.index') }}" class="flex flex-col items-center gap-1 text-gray-400 hover:text-[#8B1F33] transition-colors">
            <div class="w-8 h-8 rounded-full flex items-center justify-center">
                <i class="fas fa-handshake text-sm"></i>
            </div>
            <span class="text-[10px]">Permintaan</span>
        </a>

        <!-- Data KOL (Active) -->
        <a href="{{ route('admin.kols.index') }}" class="flex flex-col items-center gap-1 text-[#8B1F33] font-semibold">
            <div class="w-8 h-8 rounded-full bg-[#8B1F33]/10 flex items-center justify-center">
                <i class="fas fa-users text-sm"></i>
            </div>
            <span class="text-[10px]">KOL</span>
        </a>

        <!-- Profil -->
        <a href="{{ route('profile.edit') }}" class="flex flex-col items-center gap-1 text-gray-400 hover:text-[#8B1F33] transition-colors">
            <div class="w-8 h-8 rounded-full flex items-center justify-center">
                <i class="fas fa-user text-sm"></i>
            </div>
            <span class="text-[10px]">Profil</span>
        </a>
    </div>
</nav>

<script>
function searchKolTable() {
    var input = document.getElementById("searchKolInput");
    var filter = input.value.toLowerCase();
    var items = document.querySelectorAll(".kol-item");

    items.forEach(function(item) {
        var text = item.textContent.toLowerCase();
        if (text.indexOf(filter) > -1) {
            item.style.display = "";
        } else {
            item.style.display = "none";
        }
    });
}
</script>
@endsection

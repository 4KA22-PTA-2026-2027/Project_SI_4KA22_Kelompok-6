@extends('layouts.app')
@section('title', 'Daftar Talent KOL - Siapamau')
@section('content')
<div class="min-h-screen bg-[#FAF5F0] pb-28 md:pb-12">

    <!-- Top Sticky Header -->
    <div class="bg-white/90 backdrop-blur-md px-5 pt-8 pb-3 border-b border-gray-100 sticky top-0 z-30">
        <div class="max-w-md mx-auto space-y-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <a href="{{ route('dashboard') }}" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:text-[#8B1F33] transition-colors">
                        <i class="fas fa-arrow-left text-xs"></i>
                    </a>
                    <h1 class="font-serif text-lg font-bold text-gray-900">Daftar Talent KOL</h1>
                </div>
                <span class="text-xs font-semibold text-gray-500">
                    {{ $kols->count() }} Creator
                </span>
            </div>

            <!-- Search Bar & Filter Toggle -->
            <form action="{{ route('talents.index') }}" method="GET" class="flex gap-2">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <div class="relative flex-1">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari nama atau bio talent..."
                           class="w-full bg-[#FAF5F0] border border-gray-200 rounded-2xl pl-10 pr-4 py-2.5 text-xs text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#8B1F33]/20 focus:border-[#8B1F33] transition-all">
                    <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                </div>
                <button type="button" onclick="toggleFilterDrawer()"
                        class="bg-white border border-gray-200 hover:border-[#8B1F33] text-gray-700 hover:text-[#8B1F33] w-11 h-10 rounded-2xl flex items-center justify-center transition-colors flex-shrink-0 shadow-xs">
                    <i class="fas fa-sliders text-xs"></i>
                </button>
            </form>

            <!-- Category Filter Pills -->
            <div class="flex gap-2 overflow-x-auto hide-scrollbar pb-1 -mx-5 px-5">
                <a href="{{ route('talents.index', array_filter(['search' => request('search'), 'min_followers' => request('min_followers'), 'max_followers' => request('max_followers')])) }}"
                   class="flex-shrink-0 px-4 py-1.5 rounded-full text-xs font-semibold transition-all
                   {{ !$category_id ? 'bg-[#8B1F33] text-white shadow-sm' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
                    Semua
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('talents.index', array_filter(['category' => $cat->id, 'search' => request('search'), 'min_followers' => request('min_followers'), 'max_followers' => request('max_followers')])) }}"
                       class="flex-shrink-0 px-4 py-1.5 rounded-full text-xs font-semibold transition-all
                       {{ $category_id == $cat->id ? 'bg-[#8B1F33] text-white shadow-sm' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Collapsible Filter Drawer -->
    <div id="filterDrawer" class="max-w-md mx-auto px-5 pt-3 {{ request('min_followers') || request('min_rate') ? '' : 'hidden' }}">
        <div class="bg-white rounded-3xl p-5 border border-gray-100 shadow-md space-y-4">
            <div class="flex items-center justify-between pb-2 border-b border-gray-100">
                <h4 class="font-serif text-xs font-bold text-gray-900">Filter Lanjutan</h4>
                <button type="button" onclick="toggleFilterDrawer()" class="text-xs text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('talents.index') }}" method="GET" class="space-y-3">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                <!-- Range Followers -->
                <div>
                    <label class="block text-[11px] font-semibold text-gray-700 mb-1">Rentang Followers (Min - Max)</label>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="number" name="min_followers" value="{{ request('min_followers') }}" placeholder="Min. (misal: 10000)"
                               class="w-full bg-[#FAF5F0] border border-gray-200 rounded-xl px-3 py-2 text-xs">
                        <input type="number" name="max_followers" value="{{ request('max_followers') }}" placeholder="Maks. (misal: 500000)"
                               class="w-full bg-[#FAF5F0] border border-gray-200 rounded-xl px-3 py-2 text-xs">
                    </div>
                </div>

                <!-- Range Rate -->
                <div>
                    <label class="block text-[11px] font-semibold text-gray-700 mb-1">Rate Kompensasi (Rp)</label>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="number" name="min_rate" value="{{ request('min_rate') }}" placeholder="Min. Rp"
                               class="w-full bg-[#FAF5F0] border border-gray-200 rounded-xl px-3 py-2 text-xs">
                        <input type="number" name="max_rate" value="{{ request('max_rate') }}" placeholder="Maks. Rp"
                               class="w-full bg-[#FAF5F0] border border-gray-200 rounded-xl px-3 py-2 text-xs">
                    </div>
                </div>

                <div class="pt-1 flex gap-2">
                    <button type="submit" class="flex-1 bg-[#8B1F33] hover:bg-[#701828] text-white text-xs font-bold py-2.5 rounded-xl transition-colors shadow-sm">
                        Terapkan Filter
                    </button>
                    <a href="{{ route('talents.index') }}" class="px-4 py-2.5 bg-gray-100 text-gray-600 text-xs font-semibold rounded-xl hover:bg-gray-200 text-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Main 2-Column Grid of Talents -->
    <div class="max-w-md mx-auto px-5 pt-4">

        @if(request('search') || request('min_followers') || request('min_rate'))
            <div class="flex items-center justify-between text-xs text-gray-600 pb-3 px-1">
                <span>Filter aktif: <strong>{{ $kols->count() }} hasil ditemukan</strong></span>
                <a href="{{ route('talents.index') }}" class="text-[#8B1F33] font-semibold hover:underline">Hapus Filter</a>
            </div>
        @endif

        <div class="grid grid-cols-2 gap-3">
            @forelse($kols as $kol)
                <div class="bg-white rounded-3xl p-3 border border-gray-100 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                    <div>
                        <!-- Aspect Square Image -->
                        <div class="aspect-square rounded-2xl bg-gradient-to-tr from-[#FAF5F0] to-[#F5E6E8] relative overflow-hidden mb-2.5">
                            @if($kol->user->avatar)
                                <img src="{{ asset('storage/'.$kol->user->avatar) }}" class="w-full h-full object-cover rounded-2xl" alt="{{ $kol->user->name }}">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-[#8B1F33]">
                                    <div class="w-12 h-12 rounded-full bg-white shadow-xs flex items-center justify-center font-bold text-base">
                                        {{ strtoupper(substr($kol->user->name, 0, 1)) }}
                                    </div>
                                </div>
                            @endif

                            @if($kol->category)
                                <span class="absolute top-2 left-2 bg-black/60 backdrop-blur-xs text-white text-[9px] font-bold px-2 py-0.5 rounded-full uppercase">
                                    {{ $kol->category->name }}
                                </span>
                            @endif
                        </div>

                        <h4 class="font-bold text-gray-900 text-xs truncate flex items-center gap-1">
                            {{ $kol->user->name }}
                            <i class="fas fa-check-circle text-amber-500 text-[10px]"></i>
                        </h4>
                        <p class="text-[10px] text-gray-400 mt-0.5 flex items-center gap-1">
                            <i class="fas fa-users text-[9px]"></i>
                            {{ $kol->followers ? number_format($kol->followers) : '150K' }} followers
                        </p>
                    </div>

                    <div class="pt-2 mt-2 border-t border-gray-50 flex items-center justify-between">
                        <div>
                            <p class="text-[9px] text-gray-400 uppercase">Rate Mulai</p>
                            <p class="text-xs font-bold text-[#8B1F33] font-serif">
                                Rp {{ number_format($kol->rate ?? 1500000, 0, ',', '.') }}
                            </p>
                        </div>
                        <a href="{{ route('talents.show', $kol->id) }}"
                           class="bg-[#8B1F33] hover:bg-[#701828] text-white w-7 h-7 rounded-xl flex items-center justify-center text-xs transition-colors shadow-xs">
                            <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-2 bg-white rounded-3xl p-10 text-center border border-gray-100 shadow-sm">
                    <div class="w-16 h-16 bg-[#8B1F33]/10 text-[#8B1F33] rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-search text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-800 text-sm">Tidak ada kreator yang sesuai</h4>
                    <p class="text-xs text-gray-500 mt-1">Coba sesuaikan kata kunci pencarian atau ubah rentang filter.</p>
                    <a href="{{ route('talents.index') }}" class="inline-block mt-4 text-xs font-semibold text-[#8B1F33] underline">
                        Tampilkan Semua Creator
                    </a>
                </div>
            @endforelse
        </div>

    </div>
</div>

<!-- Bottom Navigation Bar (Brand) -->
<nav class="fixed bottom-0 left-0 w-full bg-white/95 backdrop-blur-md border-t border-gray-200/80 z-50">
    <div class="max-w-md mx-auto flex justify-around items-center py-2.5 px-3">
        <!-- Cari Talent (Active) -->
        <a href="{{ route('talents.index') }}" class="flex flex-col items-center gap-1 text-[#8B1F33] font-semibold">
            <div class="w-8 h-8 rounded-full bg-[#8B1F33]/10 flex items-center justify-center">
                <i class="fas fa-search text-sm"></i>
            </div>
            <span class="text-[10px]">Cari Talent</span>
        </a>

        <!-- Pekerjaan -->
        <a href="{{ route('jobs.index') }}" class="flex flex-col items-center gap-1 text-gray-400 hover:text-[#8B1F33] transition-colors">
            <div class="w-8 h-8 rounded-full flex items-center justify-center">
                <i class="fas fa-briefcase text-sm"></i>
            </div>
            <span class="text-[10px]">Pekerjaan</span>
        </a>

        <!-- Beranda Brand -->
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-1 text-gray-400 hover:text-[#8B1F33] transition-colors">
            <div class="w-8 h-8 rounded-full flex items-center justify-center">
                <i class="fas fa-home text-sm"></i>
            </div>
            <span class="text-[10px]">Beranda</span>
        </a>

        <!-- Profil -->
        <a href="{{ route('profile') }}" class="flex flex-col items-center gap-1 text-gray-400 hover:text-[#8B1F33] transition-colors">
            <div class="w-8 h-8 rounded-full flex items-center justify-center">
                <i class="fas fa-user text-sm"></i>
            </div>
            <span class="text-[10px]">Profil</span>
        </a>
    </div>
</nav>

<script>
function toggleFilterDrawer() {
    var drawer = document.getElementById('filterDrawer');
    if (drawer) {
        if (drawer.classList.contains('hidden')) {
            drawer.classList.remove('hidden');
            drawer.scrollIntoView({ behavior: 'smooth' });
        } else {
            drawer.classList.add('hidden');
        }
    }
}
</script>
@endsection

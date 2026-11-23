@extends('layouts.app')

@section('title', 'Daftar Akun - Siapamau')

@section('content')
<div class="min-h-screen bg-bg-cream flex flex-col justify-start items-center py-6 px-4">
    <div class="w-full max-w-xs md:max-w-sm">

        <!-- Top Navigation / Back button -->
        <div class="mb-3">
            <a href="{{ route('home') }}" class="text-gray-700 hover:text-primary transition-colors text-base inline-flex items-center justify-center w-8 h-8 rounded-full hover:bg-maroon-soft">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>

        <!-- Role Toggle Switcher (1 Link untuk Brand & KOL) -->
        <div class="flex p-1 bg-white border border-gray-200/90 rounded-2xl mb-4 shadow-xs">
            <button type="button" id="tab-brand" onclick="switchRole('brand')" class="flex-1 py-2 text-xs font-bold rounded-xl transition-all duration-200 bg-primary text-white shadow-xs">
                Brand
            </button>
            <button type="button" id="tab-kol" onclick="switchRole('kol')" class="flex-1 py-2 text-xs font-bold rounded-xl transition-all duration-200 text-gray-500 hover:text-gray-800">
                KOL
            </button>
        </div>

        <!-- ========================================== -->
        <!--        1. FORMULIR REGISTER BRAND          -->
        <!-- ========================================== -->
        <div id="section-brand">
            <div class="mb-4">
                <h1 class="text-lg md:text-xl font-bold text-gray-900 tracking-tight">
                    Daftar sebagai Brand
                </h1>
                <p class="text-xs text-gray-500 mt-1 leading-snug">
                    Lengkapi detail perusahaan Anda untuk mulai berkolaborasi dengan talenta terbaik.
                </p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="space-y-3.5">
                @csrf
                <input type="hidden" name="role" value="brand">

                <!-- Nama brand/perusahaan -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Nama brand/perusahaan
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        value="{{ old('role') === 'brand' ? old('name') : '' }}" 
                        placeholder="Contoh: PT Siapamau Infinitix Growth" 
                        class="w-full bg-white border @if(old('role') === 'brand') @error('name') border-red-500 @else border-gray-200/90 @enderror @else border-gray-200/90 @endif rounded-xl px-3.5 py-2.5 text-xs text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary shadow-xs transition-all"
                        required
                    >
                    @if(old('role') === 'brand')
                        @error('name')
                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    @endif
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Email
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        value="{{ old('role') === 'brand' ? old('email') : '' }}" 
                        placeholder="nama@gmail.com" 
                        class="w-full bg-white border @if(old('role') === 'brand') @error('email') border-red-500 @else border-gray-200/90 @enderror @else border-gray-200/90 @endif rounded-xl px-3.5 py-2.5 text-xs text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary shadow-xs transition-all"
                        required
                    >
                    @if(old('role') === 'brand')
                        @error('email')
                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    @endif
                </div>

                <!-- Kata sandi -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Kata sandi
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            name="password" 
                            id="brand-pass"
                            placeholder="Min. 8 karakter" 
                            class="w-full bg-white border @if(old('role') === 'brand') @error('password') border-red-500 @else border-gray-200/90 @enderror @else border-gray-200/90 @endif rounded-xl px-3.5 py-2.5 pr-10 text-xs text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary shadow-xs transition-all"
                            required
                        >
                        <button type="button" onclick="togglePass('brand-pass', 'brand-pass-icon')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none">
                            <i class="fas fa-eye text-xs" id="brand-pass-icon"></i>
                        </button>
                    </div>
                    @if(old('role') === 'brand')
                        @error('password')
                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    @endif
                </div>

                <!-- Konfirmasi kata sandi -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Konfirmasi kata sandi
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="brand-confirm-pass"
                            placeholder="Ulangi kata sandi" 
                            class="w-full bg-white border border-gray-200/90 rounded-xl px-3.5 py-2.5 pr-10 text-xs text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary shadow-xs transition-all"
                            required
                        >
                        <button type="button" onclick="togglePass('brand-confirm-pass', 'brand-confirm-icon')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none">
                            <i class="fas fa-eye text-xs" id="brand-confirm-icon"></i>
                        </button>
                    </div>
                </div>

                <!-- Kode undangan -->
                <div>
                    <div class="flex items-center gap-1.5 mb-1">
                        <label class="text-xs font-semibold text-gray-700">
                            Kode undangan
                        </label>
                        <div class="group relative inline-block">
                            <i class="fas fa-info-circle text-[11px] text-gray-400 cursor-help"></i>
                            <div class="hidden group-hover:block absolute bottom-full left-1/2 -translate-x-1/2 mb-1.5 w-48 p-2 bg-gray-800 text-white text-[10px] rounded-lg shadow-lg z-20 text-center">
                                Gunakan kode undangan dari tim Siapamau (contoh: ABCD)
                            </div>
                        </div>
                    </div>
                    <div class="relative">
                        <input 
                            type="text" 
                            name="invitation_code" 
                            value="{{ old('role') === 'brand' ? old('invitation_code') : '' }}" 
                            placeholder="Contoh: ABCD" 
                            class="w-full bg-white border @error('invitation_code') border-red-500 @else border-gray-200/90 @enderror rounded-xl px-3.5 py-2.5 pr-10 text-xs text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary shadow-xs transition-all uppercase tracking-wide"
                            required
                        >
                        @error('invitation_code')
                            <div class="absolute right-3 top-1/2 -translate-y-1/2 text-red-500 pointer-events-none">
                                <i class="fas fa-circle-exclamation text-xs"></i>
                            </div>
                        @enderror
                    </div>
                    @error('invitation_code')
                        <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-3 px-4 rounded-xl text-xs transition-colors shadow-sm">
                        Daftar
                    </button>
                </div>
            </form>

            <p class="text-xs text-gray-500 text-center mt-5">
                Sudah punya akun? <a href="{{ route('login') }}" class="font-bold text-gray-900 hover:text-primary transition-colors">Masuk</a>
            </p>
        </div>


        <!-- ========================================== -->
        <!--         2. FORMULIR REGISTER KOL           -->
        <!-- ========================================== -->
        <div id="section-kol" class="hidden">
            <div class="mb-4">
                <h1 class="text-lg md:text-xl font-bold text-gray-900 tracking-tight">
                    Daftar sebagai KOL
                </h1>
                <p class="text-xs text-gray-500 mt-1 leading-snug">
                    Bergabunglah dengan ekosistem kreator premium kami dan mulai kembangkan pengaruh Anda.
                </p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="space-y-3.5">
                @csrf
                <input type="hidden" name="role" value="kol">

                <!-- Nama lengkap -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Nama lengkap
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        value="{{ old('role') === 'kol' ? old('name') : '' }}" 
                        placeholder="Masukkan nama lengkap Anda" 
                        class="w-full bg-white border @if(old('role') === 'kol') @error('name') border-red-500 @else border-gray-200/90 @enderror @else border-gray-200/90 @endif rounded-xl px-3.5 py-2.5 text-xs text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary shadow-xs transition-all"
                        required
                    >
                    @if(old('role') === 'kol')
                        @error('name')
                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    @endif
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Email
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        value="{{ old('role') === 'kol' ? old('email') : '' }}" 
                        placeholder="nama@gmail.com" 
                        class="w-full bg-white border @if(old('role') === 'kol') @error('email') border-red-500 @else border-gray-200/90 @enderror @else border-gray-200/90 @endif rounded-xl px-3.5 py-2.5 text-xs text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary shadow-xs transition-all"
                        required
                    >
                    @if(old('role') === 'kol')
                        @error('email')
                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    @endif
                </div>

                <!-- Platform media sosial utama -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Platform media sosial utama
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            name="social_platform" 
                            list="platforms-list"
                            value="{{ old('role') === 'kol' ? old('social_platform') : '' }}" 
                            placeholder="Contoh: Instagram" 
                            class="w-full bg-white border border-gray-200/90 rounded-xl px-3.5 py-2.5 text-xs text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary shadow-xs transition-all"
                        >
                        <datalist id="platforms-list">
                            <option value="Instagram">
                            <option value="TikTok">
                            <option value="YouTube">
                            <option value="Twitter/X">
                        </datalist>
                    </div>
                </div>

                <!-- Niche konten -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Niche konten
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            name="niche" 
                            list="niches-list"
                            value="{{ old('role') === 'kol' ? old('niche') : '' }}" 
                            placeholder="Contoh: Lifestyle" 
                            class="w-full bg-white border border-gray-200/90 rounded-xl px-3.5 py-2.5 text-xs text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary shadow-xs transition-all"
                        >
                        <datalist id="niches-list">
                            <option value="Lifestyle">
                            <option value="Beauty">
                            <option value="Foodies">
                            <option value="Sports">
                            <option value="Tech">
                            <option value="Fashion">
                            <option value="Gaming">
                            <option value="Travel">
                        </datalist>
                    </div>
                </div>

                <!-- Kata sandi -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Kata sandi
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            name="password" 
                            id="kol-pass"
                            placeholder="Min. 8 karakter" 
                            class="w-full bg-white border @if(old('role') === 'kol') @error('password') border-red-500 @else border-gray-200/90 @enderror @else border-gray-200/90 @endif rounded-xl px-3.5 py-2.5 pr-10 text-xs text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary shadow-xs transition-all"
                            required
                        >
                        <button type="button" onclick="togglePass('kol-pass', 'kol-pass-icon')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none">
                            <i class="fas fa-eye text-xs" id="kol-pass-icon"></i>
                        </button>
                    </div>
                    @if(old('role') === 'kol')
                        @error('password')
                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    @endif
                </div>

                <!-- Konfirmasi kata sandi -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Konfirmasi kata sandi
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="kol-confirm-pass"
                            placeholder="Ulangi kata sandi" 
                            class="w-full bg-white border border-gray-200/90 rounded-xl px-3.5 py-2.5 pr-10 text-xs text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary shadow-xs transition-all"
                            required
                        >
                        <button type="button" onclick="togglePass('kol-confirm-pass', 'kol-confirm-icon')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none">
                            <i class="fas fa-eye text-xs" id="kol-confirm-icon"></i>
                        </button>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-3 px-4 rounded-xl text-xs transition-colors shadow-sm">
                        Daftar
                    </button>
                </div>
            </form>

            <p class="text-xs text-gray-500 text-center mt-5">
                Sudah punya akun? <a href="{{ route('login') }}" class="font-bold text-gray-900 hover:text-primary transition-colors">Masuk di sini</a>
            </p>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    function switchRole(role) {
        const isBrand = role === 'brand';
        const brandSection = document.getElementById('section-brand');
        const kolSection = document.getElementById('section-kol');
        const tabBrand = document.getElementById('tab-brand');
        const tabKol = document.getElementById('tab-kol');

        if (isBrand) {
            brandSection.classList.remove('hidden');
            kolSection.classList.add('hidden');

            tabBrand.className = 'flex-1 py-2 text-xs font-bold rounded-xl transition-all duration-200 bg-primary text-white shadow-xs';
            tabKol.className = 'flex-1 py-2 text-xs font-bold rounded-xl transition-all duration-200 text-gray-500 hover:text-gray-800';
            
            document.title = 'Daftar sebagai Brand - Siapamau';
        } else {
            brandSection.classList.add('hidden');
            kolSection.classList.remove('hidden');

            tabBrand.className = 'flex-1 py-2 text-xs font-bold rounded-xl transition-all duration-200 text-gray-500 hover:text-gray-800';
            tabKol.className = 'flex-1 py-2 text-xs font-bold rounded-xl transition-all duration-200 bg-primary text-white shadow-xs';
            
            document.title = 'Daftar sebagai KOL - Siapamau';
        }

        // Perbarui URL tanpa reload agar tetap dalam 1 link
        if (window.history.replaceState) {
            const url = new URL(window.location);
            url.searchParams.set('role', role);
            window.history.replaceState(null, '', url);
        }
    }

    function togglePass(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (!input || !icon) return;

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Tentukan role awal saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const roleFromUrl = urlParams.get('role');
        const oldRole = "{{ old('role') }}";
        const defaultRole = oldRole || roleFromUrl || "{{ $role ?? 'brand' }}";
        
        switchRole(defaultRole === 'kol' ? 'kol' : 'brand');
    });
</script>
@endsection

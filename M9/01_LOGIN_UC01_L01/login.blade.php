@extends('layouts.app')
@section('title', 'Masuk - Siapamau Management')
@section('content')
<div class="min-h-screen bg-[#FAF5F0] flex flex-col justify-between">

    <!-- Top Navigation Bar -->
    <div class="px-5 pt-7 pb-2 flex items-center justify-between max-w-sm mx-auto w-full">
        <a href="{{ route('home') }}" title="Kembali ke Beranda Publik"
           class="text-[#8B1F33] w-9 h-9 flex items-center justify-center rounded-full hover:bg-[#8B1F33]/10 transition-colors">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <a href="{{ route('home') }}"
           class="text-xs font-semibold text-[#8B1F33] hover:underline flex items-center gap-1.5 bg-[#8B1F33]/5 hover:bg-[#8B1F33]/10 px-3.5 py-1.5 rounded-full transition-colors">
            <i class="fas fa-home text-xs"></i>
            <span>Beranda Publik</span>
        </a>
    </div>

    <!-- Center Content -->
    <div class="flex-1 flex flex-col items-center px-6 pt-2 pb-8 max-w-sm mx-auto w-full">

        <!-- Logo Siapamau (Klik untuk langsung ke Beranda) -->
        <a href="{{ route('home') }}" title="Klik untuk ke Beranda Publik"
           class="group flex flex-col items-center mb-5 cursor-pointer transition-transform hover:scale-105">
            <div class="w-16 h-16 bg-[#8B1F33]/10 rounded-full flex items-center justify-center mx-auto mb-2 group-hover:bg-[#8B1F33]/15 transition-colors shadow-xs">
                <i class="fas fa-crown text-[#8B1F33] text-2xl"></i>
            </div>
            <h2 class="font-serif text-base font-bold text-[#8B1F33] text-center mb-0.5 tracking-widest uppercase group-hover:text-[#6e1828] transition-colors">
                Siapamau Management
            </h2>
            <p class="text-[11px] text-gray-500 text-center">Influencer Management Platform</p>
        </a>

        <!-- ========================================================================= -->
        <!-- STEP 1: PILIH PERAN (ROLE SELECTION)                                      -->
        <!-- ========================================================================= -->
        <div id="step-role" class="w-full">
            <div class="text-center mb-5 pb-3 border-b border-[#8B1F33]/15">
                <h3 class="text-sm font-bold text-gray-800">Masuk sebagai</h3>
                <p class="text-[11px] text-gray-500 mt-0.5">Pilih jenis akun yang Anda gunakan</p>
            </div>

            <!-- Opsi 1: KOL -->
            <div onclick="selectRoleAndProceed('kol')"
                 class="role-card flex items-center justify-between w-full bg-white border-2 border-gray-200 rounded-2xl px-4 py-3.5 cursor-pointer mb-3 transition-all hover:border-[#8B1F33]/60 hover:shadow-xs"
                 id="card-kol" style="border-color:#E5E7EB; background:#fff;">
                <div class="flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-[#8B1F33]/10 text-[#8B1F33] flex items-center justify-center flex-shrink-0 text-base">
                        <i class="fas fa-star"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-800">KOL / Influencer</p>
                        <p class="text-[11px] text-gray-500">Content creator & talenta kreatif</p>
                    </div>
                </div>
                <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center flex-shrink-0" id="circle-kol" style="border-color:#D1D5DB;">
                    <div class="w-2.5 h-2.5 rounded-full" id="dot-kol" style="background:#8B1F33; display:none;"></div>
                </div>
            </div>

            <!-- Opsi 2: Brand/Client -->
            <div onclick="selectRoleAndProceed('brand')"
                 class="role-card flex items-center justify-between w-full bg-white border-2 border-gray-200 rounded-2xl px-4 py-3.5 cursor-pointer mb-3 transition-all hover:border-[#8B1F33]/60 hover:shadow-xs"
                 id="card-brand" style="border-color:#E5E7EB; background:#fff;">
                <div class="flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 text-base">
                        <i class="fas fa-building"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-800">Brand / Klien</p>
                        <p class="text-[11px] text-gray-500">Perusahaan & pemilik kampanye</p>
                    </div>
                </div>
                <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center flex-shrink-0" id="circle-brand" style="border-color:#D1D5DB;">
                    <div class="w-2.5 h-2.5 rounded-full" id="dot-brand" style="background:#8B1F33; display:none;"></div>
                </div>
            </div>

            <!-- Opsi 3: Founder / Admin -->
            <div class="text-center mt-3 mb-5">
                <button type="button" onclick="selectRoleAndProceed('admin')"
                        class="text-xs text-gray-500 hover:text-[#8B1F33] font-medium underline underline-offset-4 transition-colors">
                    <i class="fas fa-shield-alt text-[10px] mr-1"></i> Masuk sebagai Founder / Admin
                </button>
            </div>

            <!-- Tombol Lanjut -->
            <button type="button" onclick="showLoginFormDirect()" id="btn-lanjut"
                class="w-full text-white font-bold py-3.5 px-4 rounded-2xl text-xs transition-all shadow-sm flex items-center justify-center gap-2"
                style="background:#8B1F33; opacity:0.5; cursor:not-allowed;"
                disabled>
                <span>Lanjut</span>
                <i class="fas fa-arrow-right text-xs"></i>
            </button>
        </div>

        <!-- ========================================================================= -->
        <!-- STEP 2: FORM LOGIN (EMAIL & KATA SANDI)                                   -->
        <!-- ========================================================================= -->
        <div id="step-login" class="w-full" style="display:none;">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 rounded-2xl px-4 py-3 text-xs mb-4 flex items-center gap-2">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <!-- Role Selector Tabs in Login Form -->
            <div class="flex items-center justify-between mb-4 pb-2 border-b border-[#8B1F33]/15">
                <button type="button" onclick="backToRoleStep()" class="text-xs text-gray-500 hover:text-[#8B1F33] flex items-center gap-1 font-semibold">
                    <i class="fas fa-arrow-left text-[10px]"></i> Ganti Peran
                </button>
                <span id="role-badge" class="text-[10px] font-bold text-[#8B1F33] bg-[#8B1F33]/10 px-2.5 py-1 rounded-full uppercase tracking-wider">
                    KOL Creator
                </span>
            </div>

            <form action="{{ route('login') }}" method="POST" class="w-full space-y-3.5">
                @csrf
                <input type="hidden" name="role" id="form-role" value="kol">

                <!-- Email / Username -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="input-email" value="{{ old('email') }}"
                        class="w-full bg-white border @error('email') border-red-400 @else border-gray-200 @enderror rounded-xl px-3.5 py-2.5 text-xs text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#8B1F33]/20 focus:border-[#8B1F33] shadow-xs transition-all"
                        placeholder="nama@gmail.com" required>
                    @error('email')
                        <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Kata Sandi</label>
                    <div class="relative">
                        <input type="password" name="password" id="password-field"
                            class="w-full bg-white border @error('password') border-red-400 @else border-gray-200 @enderror rounded-xl px-3.5 py-2.5 pr-10 text-xs text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#8B1F33]/20 focus:border-[#8B1F33] shadow-xs transition-all"
                            placeholder="Min. 8 karakter" required>
                        <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none">
                            <i class="fas fa-eye text-xs" id="eye-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lupa Kata Sandi -->
                <div class="text-right -mt-1">
                    <a href="{{ route('password.request') }}" class="text-xs text-[#8B1F33] font-medium hover:underline">
                        Lupa kata sandi?
                    </a>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="w-full bg-[#8B1F33] hover:bg-[#701828] text-white font-bold py-3.5 px-4 rounded-2xl text-xs transition-colors shadow-md mt-1">
                    Masuk
                </button>
            </form>

            <!-- Divider -->
            <div class="flex items-center gap-3 my-4 w-full">
                <div class="flex-1 border-t border-[#8B1F33]/15"></div>
                <span class="text-xs text-gray-400">atau</span>
                <div class="flex-1 border-t border-[#8B1F33]/15"></div>
            </div>

            <!-- Link Registrasi -->
            <p class="text-xs text-gray-500 text-center">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-bold text-gray-900 hover:text-[#8B1F33] transition-colors">
                    Daftar di sini
                </a>
            </p>
        </div>

    </div>

    <!-- Simple Footer Credit -->
    <div class="py-4 text-center text-[11px] text-gray-400 border-t border-gray-100/50">
        &copy; 2026 PT Siapamau Infinite Growth. All Rights Reserved.
    </div>
</div>

<script>
    let selectedRole = 'kol';

    // Jika terdapat error validasi, otomatis buka form login langsung
    @if($errors->any() || session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            showLoginFormDirect();
        });
    @endif

    // Memilih peran dan langsung membuka form login secara mulus
    function selectRoleAndProceed(role) {
        selectedRole = role;

        // Reset visual card
        ['kol','brand'].forEach(function(r) {
            var card = document.getElementById('card-' + r);
            var circle = document.getElementById('circle-' + r);
            var dot = document.getElementById('dot-' + r);
            if (card) { card.style.borderColor = '#E5E7EB'; card.style.backgroundColor = '#ffffff'; }
            if (circle) circle.style.borderColor = '#D1D5DB';
            if (dot) dot.style.display = 'none';
        });

        // Tandai card yang dipilih
        if (role === 'kol' || role === 'brand') {
            var card = document.getElementById('card-' + role);
            var circle = document.getElementById('circle-' + role);
            var dot = document.getElementById('dot-' + role);
            if (card) { card.style.borderColor = '#8B1F33'; card.style.backgroundColor = 'rgba(139,31,51,0.04)'; }
            if (circle) circle.style.borderColor = '#8B1F33';
            if (dot) dot.style.display = 'block';
        }

        // Aktifkan tombol lanjut
        var btn = document.getElementById('btn-lanjut');
        btn.disabled = false;
        btn.style.opacity = '1';
        btn.style.cursor = 'pointer';

        // Langsung tampilkan form setelah jeda singkat (250ms) untuk kenyamanan pengguna
        setTimeout(function() {
            showLoginFormDirect();
        }, 250);
    }

    function showLoginFormDirect() {
        document.getElementById('step-role').style.display = 'none';
        document.getElementById('step-login').style.display = 'block';

        var fr = document.getElementById('form-role');
        if (fr) fr.value = selectedRole;

        var badge = document.getElementById('role-badge');
        var emailInput = document.getElementById('input-email');

        if (selectedRole === 'brand') {
            if (badge) badge.innerText = 'Brand Partner';
            if (emailInput && !emailInput.value) emailInput.placeholder = 'brand@glowskin.com';
        } else if (selectedRole === 'admin') {
            if (badge) badge.innerText = 'Super Admin';
            if (emailInput && !emailInput.value) emailInput.placeholder = 'admin@siapamau.com';
        } else {
            if (badge) badge.innerText = 'KOL Creator';
            if (emailInput && !emailInput.value) emailInput.placeholder = 'melvin@kol.com';
        }
    }

    function backToRoleStep() {
        var loginStep = document.getElementById('step-login');
        if (loginStep) loginStep.style.display = 'none';
        var roleStep = document.getElementById('step-role');
        if (roleStep) roleStep.style.display = 'block';
    }

    function togglePassword() {
        var field = document.getElementById('password-field');
        var icon = document.getElementById('eye-icon');
        if (field.type === 'password') {
            field.type = 'text';
            icon.className = 'fas fa-eye-slash text-xs';
        } else {
            field.type = 'password';
            icon.className = 'fas fa-eye text-xs';
        }
    }
</script>
@endsection

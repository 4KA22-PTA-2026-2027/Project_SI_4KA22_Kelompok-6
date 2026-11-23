@extends('layouts.app')

@section('title', 'Lupa Kata Sandi - Siapamau')

@section('content')
<div class="min-h-screen bg-bg-cream flex flex-col justify-start items-center py-6 px-4">
    <div class="w-full max-w-xs md:max-w-sm">

        <!-- Stage Indicator Pills (Mudah untuk testing/preview semua tahapan) -->
        <div class="flex p-1 bg-white border border-gray-200/90 rounded-2xl mb-4 shadow-xs">
            <button type="button" id="tab-step-1" onclick="goToStep(1)" class="flex-1 py-1.5 text-[11px] font-bold rounded-xl transition-all duration-200 bg-primary text-white shadow-xs">
                1. Email
            </button>
            <button type="button" id="tab-step-2" onclick="goToStep(2)" class="flex-1 py-1.5 text-[11px] font-bold rounded-xl transition-all duration-200 text-gray-500 hover:text-gray-800">
                2. OTP
            </button>
            <button type="button" id="tab-step-3" onclick="goToStep(3)" class="flex-1 py-1.5 text-[11px] font-bold rounded-xl transition-all duration-200 text-gray-500 hover:text-gray-800">
                3. Sandi Baru
            </button>
        </div>


        <!-- ======================================================== -->
        <!--        TAHAP 1: LUPA KATA SANDI (INPUT EMAIL)             -->
        <!-- ======================================================== -->
        <div id="stage-1" class="w-full">
            <!-- Header bar -->
            <div class="flex items-center gap-2 mb-3">
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary transition-colors text-sm inline-flex items-center justify-center w-8 h-8 rounded-full hover:bg-maroon-soft">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <span class="font-bold text-xs text-gray-900">Lupa Kata Sandi</span>
            </div>

            <!-- Illustration / Banner Circle -->
            <div class="flex justify-center my-3">
                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-pink-100 via-rose-50 to-orange-100 border-2 border-white shadow-sm flex items-center justify-center relative overflow-hidden">
                    <div class="w-16 h-16 rounded-2xl bg-white/90 shadow-xs flex flex-col items-center justify-center text-primary">
                        <i class="fas fa-laptop-code text-xl mb-0.5"></i>
                        <span class="text-[8px] font-bold tracking-wider uppercase text-gray-400">Siapamau</span>
                    </div>
                </div>
            </div>

            <!-- Card Headings -->
            <div class="text-center mb-4">
                <h1 class="text-base md:text-lg font-bold text-gray-900 tracking-tight">
                    Atur Ulang Sandi
                </h1>
                <p class="text-xs text-gray-500 mt-1 leading-snug px-2">
                    Masukkan alamat email Anda untuk menerima instruksi pemulihan.
                </p>
            </div>

            <form onsubmit="handleSendInstructions(event)" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs">
                            <i class="far fa-envelope"></i>
                        </span>
                        <input 
                            type="email" 
                            id="email-input" 
                            value="{{ old('email') }}"
                            placeholder="nama@gmail.com" 
                            class="w-full bg-white border border-gray-200/90 rounded-xl pl-9 pr-3.5 py-2.5 text-xs text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary shadow-xs transition-all"
                            required
                        >
                    </div>
                </div>

                <div class="pt-1">
                    <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-3 px-4 rounded-xl text-xs transition-colors shadow-sm flex items-center justify-center gap-1.5">
                        <span>Kirim Instruksi</span>
                        <i class="fas fa-play text-[9px] ml-0.5"></i>
                    </button>
                </div>
            </form>

            <p class="text-xs text-gray-500 text-center mt-6">
                Butuh bantuan lebih cepat? <a href="#" class="font-bold text-gray-900 hover:text-primary transition-colors">Hubungi Admin</a>
            </p>
        </div>


        <!-- ======================================================== -->
        <!--        TAHAP 2: VERIFIKASI OTP (6 KOTAK KODE)            -->
        <!-- ======================================================== -->
        <div id="stage-2" class="w-full hidden">
            <!-- Header bar -->
            <div class="flex items-center gap-2 mb-4">
                <button type="button" onclick="goToStep(1)" class="text-gray-700 hover:text-primary transition-colors text-sm inline-flex items-center justify-center w-8 h-8 rounded-full hover:bg-maroon-soft">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <span class="font-bold text-xs text-gray-900">Verifikasi OTP</span>
            </div>

            <!-- Envelope Icon Box -->
            <div class="flex justify-center my-3">
                <div class="w-14 h-14 rounded-2xl bg-primary text-white flex items-center justify-center text-xl shadow-md shadow-primary/20">
                    <i class="fas fa-envelope-open-text"></i>
                </div>
            </div>

            <!-- Card Headings -->
            <div class="text-center mb-5">
                <h1 class="text-base md:text-lg font-bold text-gray-900 tracking-tight">
                    Verifikasi Email
                </h1>
                <p class="text-xs text-gray-500 mt-1 leading-snug px-3">
                    Kami telah mengirimkan kode verifikasi ke email <span id="confirmed-email" class="font-semibold text-gray-700">email Anda</span>
                </p>
            </div>

            <form onsubmit="handleVerifyOtp(event)" class="space-y-4">
                <!-- 6 Kotak Input OTP -->
                <div class="flex justify-between gap-1.5 px-1">
                    <input type="text" maxlength="1" class="otp-box w-10 h-12 text-center text-sm font-bold text-gray-900 bg-white border border-gray-200/90 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary shadow-xs transition-all" data-index="0" autofocus>
                    <input type="text" maxlength="1" class="otp-box w-10 h-12 text-center text-sm font-bold text-gray-900 bg-white border border-gray-200/90 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary shadow-xs transition-all" data-index="1">
                    <input type="text" maxlength="1" class="otp-box w-10 h-12 text-center text-sm font-bold text-gray-900 bg-white border border-gray-200/90 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary shadow-xs transition-all" data-index="2">
                    <input type="text" maxlength="1" class="otp-box w-10 h-12 text-center text-sm font-bold text-gray-900 bg-white border border-gray-200/90 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary shadow-xs transition-all" data-index="3">
                    <input type="text" maxlength="1" class="otp-box w-10 h-12 text-center text-sm font-bold text-gray-900 bg-white border border-gray-200/90 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary shadow-xs transition-all" data-index="4">
                    <input type="text" maxlength="1" class="otp-box w-10 h-12 text-center text-sm font-bold text-gray-900 bg-white border border-gray-200/90 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary shadow-xs transition-all" data-index="5">
                </div>

                <!-- Resend countdown -->
                <div class="text-center pt-1">
                    <p class="text-[11px] text-gray-400">Tidak menerima kode?</p>
                    <p id="timer-wrapper" class="text-xs font-semibold text-primary mt-0.5">
                        Kirim ulang dalam <span id="timer-count">00:55</span>
                    </p>
                    <button type="button" id="btn-resend" onclick="restartCountdown()" class="hidden text-xs font-bold text-primary hover:underline mt-0.5">
                        Kirim ulang kode sekarang
                    </button>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-3 px-4 rounded-xl text-xs transition-colors shadow-sm">
                        Verifikasi
                    </button>
                </div>
            </form>

            <div class="text-center mt-5">
                <a href="{{ route('login') }}" class="text-xs text-gray-500 hover:text-gray-900 font-medium inline-flex items-center gap-1.5 transition-colors">
                    <i class="fas fa-arrow-left text-[10px]"></i>
                    <span>Kembali ke Login</span>
                </a>
            </div>
        </div>


        <!-- ======================================================== -->
        <!--      TAHAP 3: ATUR ULANG KATA SANDI (PASSWORD BARU)       -->
        <!-- ======================================================== -->
        <div id="stage-3" class="w-full hidden">
            <!-- Top brand bar -->
            <div class="flex items-center justify-between mb-3">
                <a href="{{ route('home') }}" class="font-serif text-base font-bold text-primary">Siapamau</a>
                <button type="button" class="text-gray-600 hover:text-primary transition-colors text-sm">
                    <i class="far fa-bell"></i>
                </button>
            </div>

            <!-- Padlock Banner Card -->
            <div class="w-full rounded-2xl bg-gradient-to-r from-amber-50/80 via-rose-50 to-pink-100/70 border border-gray-200/60 p-4 mb-3.5 flex flex-col items-center justify-center text-center shadow-xs">
                <div class="w-11 h-11 rounded-2xl bg-white shadow-xs flex items-center justify-center text-primary text-lg mb-1.5">
                    <i class="fas fa-lock"></i>
                </div>
                <span class="text-[9px] font-bold tracking-widest text-gray-500 uppercase">
                    ATUR ULANG KATA SANDI
                </span>
            </div>

            <!-- Card Headings -->
            <div class="mb-3">
                <h1 class="text-base md:text-lg font-bold text-gray-900 tracking-tight">
                    Atur Ulang Kata Sandi
                </h1>
                <p class="text-xs text-gray-500 mt-1 leading-snug">
                    Buat kata sandi baru untuk akun Anda untuk menjaga keamanan data profesional Anda.
                </p>
            </div>

            <form action="{{ route('password.update') }}" method="POST" class="space-y-3" id="reset-form">
                @csrf
                <input type="hidden" name="email" id="final-email" value="{{ old('email') }}">

                <!-- Kata sandi baru -->
                <div>
                    <label class="block text-[11px] font-bold text-gray-500 tracking-wider uppercase mb-1">
                        KATA SANDI BARU
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            name="password" 
                            id="new-pass" 
                            placeholder="Masukkan kata sandi baru" 
                            oninput="validatePasswordRequirements()"
                            class="w-full bg-white border border-gray-200/90 rounded-xl px-3.5 py-2.5 pr-10 text-xs text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary shadow-xs transition-all"
                            required
                        >
                        <button type="button" onclick="togglePass('new-pass', 'new-pass-icon')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none">
                            <i class="fas fa-eye text-xs" id="new-pass-icon"></i>
                        </button>
                    </div>
                </div>

                <!-- Konfirmasi kata sandi -->
                <div>
                    <label class="block text-[11px] font-bold text-gray-500 tracking-wider uppercase mb-1">
                        KONFIRMASI KATA SANDI
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="confirm-pass" 
                            placeholder="Ulangi kata sandi baru" 
                            oninput="validatePasswordRequirements()"
                            class="w-full bg-white border border-gray-200/90 rounded-xl px-3.5 py-2.5 pr-10 text-xs text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary shadow-xs transition-all"
                            required
                        >
                        <button type="button" onclick="togglePass('confirm-pass', 'confirm-pass-icon')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none">
                            <i class="fas fa-eye text-xs" id="confirm-pass-icon"></i>
                        </button>
                    </div>
                </div>

                <!-- Syarat Kata Sandi (Live Interactive Checklist) -->
                <div class="bg-rose-50/50 border border-rose-100/90 rounded-xl p-3 space-y-1.5">
                    <p class="text-xs font-semibold text-gray-800 mb-1">Syarat Kata Sandi:</p>
                    
                    <div id="req-length" class="flex items-center gap-2 text-[11px] text-gray-500 transition-colors">
                        <i class="fas fa-circle-check text-gray-300 text-xs" id="icon-length"></i>
                        <span>Minimal 8 karakter</span>
                    </div>

                    <div id="req-capital" class="flex items-center gap-2 text-[11px] text-gray-500 transition-colors">
                        <i class="fas fa-circle-check text-gray-300 text-xs" id="icon-capital"></i>
                        <span>Setidaknya satu huruf kapital</span>
                    </div>

                    <div id="req-number" class="flex items-center gap-2 text-[11px] text-gray-500 transition-colors">
                        <i class="fas fa-circle-check text-gray-300 text-xs" id="icon-number"></i>
                        <span>Setidaknya satu angka</span>
                    </div>

                    <div id="req-match" class="flex items-center gap-2 text-[11px] text-gray-500 transition-colors">
                        <i class="fas fa-circle-check text-gray-300 text-xs" id="icon-match"></i>
                        <span>Kedua kata sandi harus sama</span>
                    </div>
                </div>

                <div class="pt-1">
                    <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-3 px-4 rounded-xl text-xs transition-colors shadow-sm">
                        Simpan Kata Sandi
                    </button>
                </div>
            </form>

            <p class="text-xs text-gray-500 text-center mt-5">
                Butuh bantuan? <a href="#" class="font-bold text-gray-900 hover:text-primary transition-colors">Hubungi Admin</a>
            </p>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    let currentStep = 1;
    let countdownInterval = null;

    function goToStep(step) {
        currentStep = step;
        
        // Hide all stages
        document.getElementById('stage-1').classList.add('hidden');
        document.getElementById('stage-2').classList.add('hidden');
        document.getElementById('stage-3').classList.add('hidden');

        // Show selected stage
        document.getElementById(`stage-${step}`).classList.remove('hidden');

        // Update tabs styling
        for (let i = 1; i <= 3; i++) {
            const tab = document.getElementById(`tab-step-${i}`);
            if (i === step) {
                tab.className = 'flex-1 py-1.5 text-[11px] font-bold rounded-xl transition-all duration-200 bg-primary text-white shadow-xs';
            } else {
                tab.className = 'flex-1 py-1.5 text-[11px] font-bold rounded-xl transition-all duration-200 text-gray-500 hover:text-gray-800';
            }
        }

        // Timer handling for step 2
        if (step === 2) {
            startCountdown(55);
            // Autofocus first OTP box
            setTimeout(() => {
                document.querySelector('.otp-box')?.focus();
            }, 100);
        }

        // Update URL query param without reload
        if (window.history.replaceState) {
            const url = new URL(window.location);
            url.searchParams.set('step', step);
            window.history.replaceState(null, '', url);
        }
    }

    function handleSendInstructions(e) {
        e.preventDefault();
        const email = document.getElementById('email-input').value.trim();
        if (!email) return;

        document.getElementById('confirmed-email').textContent = email;
        document.getElementById('final-email').value = email;

        goToStep(2);
    }

    function handleVerifyOtp(e) {
        e.preventDefault();
        // Ambil nilai OTP
        let otpValue = '';
        document.querySelectorAll('.otp-box').forEach(box => {
            otpValue += box.value;
        });

        if (otpValue.length < 6) {
            alert('Silakan masukkan 6 digit kode OTP lengkap.');
            return;
        }

        goToStep(3);
    }

    // OTP Boxes Auto Focus & Backspace Logic
    document.querySelectorAll('.otp-box').forEach((box, idx, boxes) => {
        box.addEventListener('input', (e) => {
            if (e.target.value.length === 1 && idx < boxes.length - 1) {
                boxes[idx + 1].focus();
            }
        });

        box.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !e.target.value && idx > 0) {
                boxes[idx - 1].focus();
            }
        });

        // Paste support
        box.addEventListener('paste', (e) => {
            e.preventDefault();
            const pasteData = (e.clipboardData || window.clipboardData).getData('text').trim();
            if (pasteData) {
                const digits = pasteData.slice(0, 6).split('');
                digits.forEach((d, i) => {
                    if (boxes[i]) boxes[i].value = d;
                });
                if (boxes[digits.length - 1]) boxes[digits.length - 1].focus();
            }
        });
    });

    // Countdown Timer for OTP
    function startCountdown(seconds) {
        clearInterval(countdownInterval);
        let remaining = seconds;
        const timerCount = document.getElementById('timer-count');
        const timerWrapper = document.getElementById('timer-wrapper');
        const btnResend = document.getElementById('btn-resend');

        timerWrapper.classList.remove('hidden');
        btnResend.classList.add('hidden');

        countdownInterval = setInterval(() => {
            const mins = Math.floor(remaining / 60).toString().padStart(2, '0');
            const secs = (remaining % 60).toString().padStart(2, '0');
            timerCount.textContent = `${mins}:${secs}`;

            if (remaining <= 0) {
                clearInterval(countdownInterval);
                timerWrapper.classList.add('hidden');
                btnResend.classList.remove('hidden');
            }
            remaining--;
        }, 1000);
    }

    function restartCountdown() {
        startCountdown(55);
        alert('Kode OTP baru telah dikirimkan ke email Anda.');
    }

    // Live Password Requirement Checker
    function validatePasswordRequirements() {
        const pass = document.getElementById('new-pass').value;
        const confirm = document.getElementById('confirm-pass').value;

        // 1. Min 8 Karakter
        const hasLength = pass.length >= 8;
        setReqStatus('length', hasLength);

        // 2. Setidaknya satu huruf kapital
        const hasCapital = /[A-Z]/.test(pass);
        setReqStatus('capital', hasCapital);

        // 3. Setidaknya satu angka
        const hasNumber = /[0-9]/.test(pass);
        setReqStatus('number', hasNumber);

        // 4. Kedua kata sandi harus sama
        const hasMatch = pass.length > 0 && pass === confirm;
        setReqStatus('match', hasMatch);
    }

    function setReqStatus(key, isValid) {
        const row = document.getElementById(`req-${key}`);
        const icon = document.getElementById(`icon-${key}`);
        if (!row || !icon) return;

        if (isValid) {
            row.classList.remove('text-gray-500');
            row.classList.add('text-green-600', 'font-medium');
            icon.className = 'fas fa-circle-check text-green-500 text-xs';
        } else {
            row.classList.remove('text-green-600', 'font-medium');
            row.classList.add('text-gray-500');
            icon.className = 'fas fa-circle-check text-gray-300 text-xs';
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

    // Init page on step from URL or default step 1
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const step = parseInt(urlParams.get('step')) || {{ $step ?? 1 }};
        goToStep(step >= 1 && step <= 3 ? step : 1);
    });
</script>
@endsection


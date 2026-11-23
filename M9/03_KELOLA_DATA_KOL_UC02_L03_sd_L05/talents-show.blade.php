@extends('layouts.app')
@section('title', $kol->user->name . ' - Siapamau')
@section('content')
<div class="min-h-screen bg-[#FAF5F0] pb-28 md:pb-12">

    <!-- Top Sticky Bar -->
    <div class="bg-white/90 backdrop-blur-md px-5 py-3.5 border-b border-gray-100 flex items-center justify-between sticky top-0 z-40">
        <a href="{{ route('talents.index') }}" class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-gray-700 hover:text-[#8B1F33] transition-colors">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <h1 class="font-serif text-sm font-bold text-gray-900 truncate max-w-[200px]">Detail KOL</h1>
        <button onclick="shareTalent()" class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-gray-700 hover:text-[#8B1F33] transition-colors">
            <i class="fas fa-share-alt text-sm"></i>
        </button>
    </div>

    <!-- Main Container -->
    <div class="max-w-md mx-auto px-5 pt-5 space-y-4">

        <!-- Profile Card Header -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 text-center relative overflow-hidden">
            <!-- Background Accent -->
            <div class="absolute top-0 left-0 w-full h-20 bg-gradient-to-r from-[#8B1F33] to-[#B5374F]"></div>

            <div class="relative z-10 pt-6">
                <!-- Avatar -->
                <div class="w-20 h-20 mx-auto rounded-full bg-gradient-to-tr from-[#8B1F33] to-[#C44C65] text-white flex items-center justify-center text-2xl font-bold border-4 border-white shadow-lg overflow-hidden">
                    @if($kol->user->avatar)
                        <img src="{{ asset('storage/'.$kol->user->avatar) }}" class="w-full h-full object-cover">
                    @else
                        {{ strtoupper(substr($kol->user->name, 0, 1)) }}
                    @endif
                </div>

                <div class="mt-3">
                    <h2 class="font-serif text-lg font-bold text-gray-900 flex items-center justify-center gap-1.5">
                        {{ $kol->user->name }}
                        <i class="fas fa-check-circle text-amber-500 text-xs" title="Verified Creator"></i>
                    </h2>
                    <p class="text-xs text-gray-500">{{ $kol->user->email }}</p>
                    <div class="mt-2 flex items-center justify-center gap-2">
                        <span class="bg-[#8B1F33]/10 text-[#8B1F33] text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                            {{ $kol->category->name ?? 'Lifestyle & Beauty' }}
                        </span>
                        <span class="bg-emerald-50 text-emerald-700 text-[10px] font-bold px-2.5 py-1 rounded-full flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Siap Kolaborasi
                        </span>
                    </div>
                </div>

                <!-- 3 Stats Box -->
                <div class="grid grid-cols-3 gap-2 mt-5 pt-5 border-t border-gray-100">
                    <div class="p-2 bg-[#FAF5F0] rounded-2xl">
                        <p class="text-[10px] text-gray-400 font-semibold uppercase">Followers</p>
                        <p class="font-serif text-base font-bold text-gray-900 mt-0.5">
                            {{ $kol->followers ? number_format($kol->followers) : '150K+' }}
                        </p>
                    </div>
                    <div class="p-2 bg-[#FAF5F0] rounded-2xl">
                        <p class="text-[10px] text-gray-400 font-semibold uppercase">Engagement</p>
                        <p class="font-serif text-base font-bold text-gray-900 mt-0.5">8.4%</p>
                    </div>
                    <div class="p-2 bg-[#FAF5F0] rounded-2xl">
                        <p class="text-[10px] text-gray-400 font-semibold uppercase">Rate Mulai</p>
                        <p class="font-serif text-sm font-bold text-[#8B1F33] mt-0.5">
                            Rp {{ number_format($kol->rate ?? 1500000, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bio & Social Links -->
        <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 space-y-3">
            <h3 class="font-serif text-sm font-bold text-gray-900">Tentang Kreator</h3>
            <p class="text-xs text-gray-600 leading-relaxed">
                {{ $kol->bio ?? 'Content creator berdedikasi tinggi dengan fokus pada ulasan produk berkualitas, estetika visual, dan engagement komunitas yang kuat.' }}
            </p>

            <div class="pt-2 border-t border-gray-100 flex flex-wrap gap-2">
                @if($kol->instagram)
                    <a href="https://instagram.com/{{ ltrim($kol->instagram, '@') }}" target="_blank"
                       class="flex items-center gap-1.5 text-xs text-pink-600 bg-pink-50 px-3 py-1.5 rounded-full font-medium hover:bg-pink-100">
                        <i class="fab fa-instagram"></i> {{ $kol->instagram }}
                    </a>
                @endif
                @if($kol->tiktok)
                    <a href="https://tiktok.com/@ {{ ltrim($kol->tiktok, '@') }}" target="_blank"
                       class="flex items-center gap-1.5 text-xs text-gray-800 bg-gray-100 px-3 py-1.5 rounded-full font-medium hover:bg-gray-200">
                        <i class="fab fa-tiktok"></i> {{ $kol->tiktok }}
                    </a>
                @endif
                @if(!$kol->instagram && !$kol->tiktok)
                    <span class="flex items-center gap-1.5 text-xs text-pink-600 bg-pink-50 px-3 py-1.5 rounded-full font-medium">
                        <i class="fab fa-instagram"></i> @ {{ strtolower(str_replace(' ', '', $kol->user->name)) }}
                    </span>
                @endif
            </div>
        </div>

        <!-- Portofolio Konten (6 Grid Photos) -->
        <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 space-y-3">
            <div class="flex items-center justify-between">
                <h3 class="font-serif text-sm font-bold text-gray-900">Portofolio Konten</h3>
                <span class="text-[11px] text-gray-400">Showcase Terkini</span>
            </div>

            <div class="grid grid-cols-3 gap-2">
                <div class="aspect-square rounded-2xl bg-gradient-to-tr from-amber-100 to-rose-100 overflow-hidden flex items-center justify-center text-[#8B1F33]/40 border border-gray-100">
                    <i class="fas fa-camera text-base"></i>
                </div>
                <div class="aspect-square rounded-2xl bg-gradient-to-tr from-pink-100 to-amber-100 overflow-hidden flex items-center justify-center text-[#8B1F33]/40 border border-gray-100">
                    <i class="fas fa-play text-base"></i>
                </div>
                <div class="aspect-square rounded-2xl bg-gradient-to-tr from-rose-100 to-stone-200 overflow-hidden flex items-center justify-center text-[#8B1F33]/40 border border-gray-100">
                    <i class="fas fa-images text-base"></i>
                </div>
                <div class="aspect-square rounded-2xl bg-gradient-to-tr from-stone-200 to-pink-100 overflow-hidden flex items-center justify-center text-[#8B1F33]/40 border border-gray-100">
                    <i class="fas fa-film text-base"></i>
                </div>
                <div class="aspect-square rounded-2xl bg-gradient-to-tr from-amber-100 to-stone-100 overflow-hidden flex items-center justify-center text-[#8B1F33]/40 border border-gray-100">
                    <i class="fas fa-star text-base"></i>
                </div>
                <div class="aspect-square rounded-2xl bg-gradient-to-tr from-rose-100 to-amber-100 overflow-hidden flex items-center justify-center text-[#8B1F33]/40 border border-gray-100">
                    <i class="fas fa-heart text-base"></i>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Fixed Bottom Action Bar -->
<div class="fixed bottom-0 left-0 w-full bg-white/95 backdrop-blur-md border-t border-gray-200/80 px-5 py-3.5 z-40">
    <div class="max-w-md mx-auto">
        @auth
            @if(auth()->user()->role === 'brand')
                <button onclick="openHireModal()"
                        class="w-full bg-[#8B1F33] hover:bg-[#701828] text-white py-3.5 rounded-2xl text-xs font-bold transition-all shadow-md flex items-center justify-center gap-2">
                    <i class="fas fa-handshake text-xs"></i>
                    <span>Ajukan Kerja Sama</span>
                </button>
            @else
                <a href="{{ route('talents.index') }}" class="block w-full text-center bg-[#8B1F33] text-white py-3.5 rounded-2xl text-xs font-bold">
                    Kembali ke Daftar Talent
                </a>
            @endif
        @else
            <a href="{{ route('login') }}" class="block w-full text-center bg-[#8B1F33] text-white py-3.5 rounded-2xl text-xs font-bold">
                Masuk sebagai Brand untuk Mengajukan Kerja Sama
            </a>
        @endauth
    </div>
</div>

<!-- ================= MODAL AJUKAN KERJA SAMA ================= -->
<div id="hireModal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs hidden flex items-end sm:items-center justify-center p-0 sm:p-4">
    <div class="bg-white w-full max-w-md rounded-t-3xl sm:rounded-3xl p-6 shadow-2xl max-h-[90vh] overflow-y-auto">

        <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4">
            <div>
                <h3 class="font-serif text-base font-bold text-gray-900">Ajukan Kerja Sama</h3>
                <p class="text-[11px] text-gray-500">Proposal kampanye untuk <strong>{{ $kol->user->name }}</strong></p>
            </div>
            <button onclick="closeHireModal()" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>

        <form action="{{ route('talents.hire', $kol->id) }}" method="POST" class="space-y-3.5">
            @csrf

            <!-- Brand Name (Auto) -->
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Brand Anda</label>
                <input type="text" value="{{ auth()->user()->brandProfile->company_name ?? auth()->user()->name ?? 'Brand Partner' }}" readonly
                       class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-gray-600 cursor-not-allowed">
            </div>

            <!-- Judul Kampanye -->
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Judul Kampanye</label>
                <input type="text" name="campaign_title" required
                       placeholder="Contoh: Launching Serum Glow Botanical"
                       class="w-full bg-[#FAF5F0] border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#8B1F33]/20 focus:border-[#8B1F33]">
            </div>

            <!-- Platform & Kompensasi -->
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Platform Utama</label>
                    <select name="platform" class="w-full bg-[#FAF5F0] border border-gray-200 rounded-xl px-3 py-2.5 text-xs text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#8B1F33]/20">
                        <option value="Instagram">Instagram (Reels/Feed)</option>
                        <option value="TikTok">TikTok Video</option>
                        <option value="YouTube">YouTube Shorts/Video</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Tawaran Kompensasi (Rp)</label>
                    <input type="number" name="compensation" value="{{ $kol->rate ?? 1500000 }}" required
                           class="w-full bg-[#FAF5F0] border border-gray-200 rounded-xl px-3 py-2.5 text-xs text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#8B1F33]/20">
                </div>
            </div>

            <!-- Brief / Catatan Pengajuan -->
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Brief Ringkas Kampanye</label>
                <textarea name="brief" rows="3" required
                          placeholder="Jelaskan pesan utama kampanye, target audiens, dan ekspektasi konten dari kreator..."
                          class="w-full bg-[#FAF5F0] border border-gray-200 rounded-xl p-3 text-xs text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#8B1F33]/20"></textarea>
            </div>

            <!-- Deadline -->
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Target Penayangan Konten</label>
                <input type="date" name="deadline" value="{{ now()->addDays(14)->format('Y-m-d') }}"
                       class="w-full bg-[#FAF5F0] border border-gray-200 rounded-xl px-3.5 py-2 text-xs text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#8B1F33]/20">
            </div>

            <!-- Submit -->
            <button type="submit"
                    class="w-full bg-[#8B1F33] hover:bg-[#701828] text-white font-bold py-3.5 rounded-2xl text-xs transition-colors shadow-md mt-2 flex items-center justify-center gap-2">
                <i class="fas fa-paper-plane text-xs"></i>
                <span>Kirim Pengajuan Kerja Sama</span>
            </button>
        </form>

    </div>
</div>

<!-- ================= MODAL PENGAJUAN BERHASIL ================= -->
@if(session('hire_success'))
<div id="hireSuccessModal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-center justify-center p-5">
    <div class="bg-white rounded-3xl p-6 text-center max-w-sm w-full shadow-2xl animate-fade-in space-y-4">
        <!-- Big Check Circle -->
        <div class="w-20 h-20 bg-[#8B1F33]/10 text-[#8B1F33] rounded-full flex items-center justify-center mx-auto ring-8 ring-[#8B1F33]/5">
            <i class="fas fa-check text-3xl"></i>
        </div>

        <div>
            <h3 class="font-serif text-lg font-bold text-gray-900">Pengajuan Berhasil!</h3>
            <p class="text-xs text-gray-500 mt-1.5 leading-relaxed">
                Proposal kampanye <strong>{{ session('hire_success')['campaign_title'] }}</strong> telah berhasil dikirimkan ke <strong>{{ session('hire_success')['kol_name'] }}</strong>.
            </p>
        </div>

        <div class="pt-2 space-y-2">
            <a href="{{ route('dashboard') }}"
               class="block w-full bg-[#8B1F33] hover:bg-[#701828] text-white py-3 rounded-2xl text-xs font-bold transition-colors shadow-sm">
                Lihat di Dashboard
            </a>
            <button onclick="document.getElementById('hireSuccessModal').style.display='none'"
                    class="block w-full text-xs text-gray-500 hover:text-gray-800 py-2 font-medium">
                Tutup
            </button>
        </div>
    </div>
</div>
@endif

<script>
function openHireModal() {
    var modal = document.getElementById('hireModal');
    if (modal) modal.classList.remove('hidden');
}

function closeHireModal() {
    var modal = document.getElementById('hireModal');
    if (modal) modal.classList.add('hidden');
}

function shareTalent() {
    if (navigator.share) {
        navigator.share({
            title: "{{ $kol->user->name }} - Siapamau",
            text: "Lihat profil kreator di Siapamau Influencer Platform!",
            url: window.location.href,
        }).catch(function(err) {});
    } else {
        navigator.clipboard.writeText(window.location.href);
        alert('Tautan profil kreator berhasil disalin!');
    }
}
</script>
@endsection

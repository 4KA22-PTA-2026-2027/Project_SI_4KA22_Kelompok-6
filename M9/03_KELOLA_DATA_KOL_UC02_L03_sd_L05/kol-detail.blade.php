@extends('layouts.app')
@section('title', 'Detail KOL - Admin Siapamau')
@section('content')
<div class="min-h-screen bg-[#FAF5F0] pb-28 md:pb-12">

    <!-- Top Sticky Bar -->
    <div class="bg-white/90 backdrop-blur-md px-5 py-3.5 border-b border-gray-100 flex items-center justify-between sticky top-0 z-40">
        <a href="{{ route('admin.kols.index') }}" class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-gray-700 hover:text-[#8B1F33] transition-colors">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <h1 class="font-serif text-sm font-bold text-gray-900 truncate max-w-[200px]">Detail KOL</h1>
        <span class="text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-1 rounded-full">
            Terverifikasi
        </span>
    </div>

    <div class="max-w-md mx-auto px-5 pt-5 space-y-4">

        <!-- Profile Card Header -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 text-center relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-20 bg-gradient-to-r from-[#8B1F33] to-[#B5374F]"></div>

            <div class="relative z-10 pt-6">
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
                        <i class="fas fa-check-circle text-amber-500 text-xs"></i>
                    </h2>
                    <p class="text-xs text-gray-500">{{ $kol->user->email }}</p>
                    <div class="mt-2 flex items-center justify-center gap-2">
                        <span class="bg-[#8B1F33]/10 text-[#8B1F33] text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                            {{ $kol->category->name ?? 'Lifestyle' }}
                        </span>
                        <span class="bg-emerald-50 text-emerald-700 text-[10px] font-bold px-2.5 py-1 rounded-full">
                            Akun Aktif
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
                        <p class="text-[10px] text-gray-400 font-semibold uppercase">Job Selesai</p>
                        <p class="font-serif text-base font-bold text-[#8B1F33] mt-0.5">
                            {{ $kol->completed_jobs ?? 24 }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Profil Lengkap -->
        <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 space-y-3.5">
            <h3 class="font-serif text-sm font-bold text-gray-900 pb-2 border-b border-gray-50">Data Profil Lengkap</h3>

            <div class="space-y-2.5 text-xs">
                <div class="flex items-center justify-between py-1 border-b border-gray-50">
                    <span class="text-gray-400 font-medium">Nama Lengkap</span>
                    <span class="font-bold text-gray-800">{{ $kol->user->name }}</span>
                </div>
                <div class="flex items-center justify-between py-1 border-b border-gray-50">
                    <span class="text-gray-400 font-medium">Email Terdaftar</span>
                    <span class="font-bold text-gray-800">{{ $kol->user->email }}</span>
                </div>
                <div class="flex items-center justify-between py-1 border-b border-gray-50">
                    <span class="text-gray-400 font-medium">Nomor WhatsApp</span>
                    <span class="font-bold text-gray-800">{{ $kol->user->phone ?? '0812-3456-7890' }}</span>
                </div>
                <div class="flex items-center justify-between py-1 border-b border-gray-50">
                    <span class="text-gray-400 font-medium">Instagram</span>
                    <span class="font-bold text-pink-600">{{ $kol->instagram ?? '@' . strtolower(str_replace(' ', '', $kol->user->name)) }}</span>
                </div>
                <div class="flex items-center justify-between py-1 border-b border-gray-50">
                    <span class="text-gray-400 font-medium">TikTok</span>
                    <span class="font-bold text-gray-800">{{ $kol->tiktok ?? '@' . strtolower(str_replace(' ', '', $kol->user->name)) }}</span>
                </div>
                <div class="flex items-center justify-between py-1 border-b border-gray-50">
                    <span class="text-gray-400 font-medium">Rate Card</span>
                    <span class="font-bold text-[#8B1F33] font-serif">Rp {{ number_format($kol->rate ?? 1500000, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Bio -->
            <div class="pt-2">
                <p class="text-[10px] text-gray-400 font-semibold uppercase mb-1">Bio / Perkenalan</p>
                <p class="text-xs text-gray-600 leading-relaxed bg-[#FAF5F0] p-3 rounded-2xl border border-gray-100">
                    {{ $kol->bio ?? 'Content creator fokus di bidang lifestyle, beauty, dan rekomendasi produk harian berkualitas.' }}
                </p>
            </div>
        </div>

        <!-- Riwayat Job KOL -->
        <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 space-y-3">
            <h3 class="font-serif text-sm font-bold text-gray-900 pb-2 border-b border-gray-50">Riwayat Lamaran Job</h3>

            <div class="space-y-2">
                @forelse($applications as $app)
                    <div class="p-2.5 bg-[#FAF5F0] rounded-2xl flex items-center justify-between text-xs border border-gray-100">
                        <div>
                            <p class="font-bold text-gray-900 truncate max-w-[180px]">{{ $app->job->title ?? 'Job Kampanye' }}</p>
                            <p class="text-[10px] text-gray-400">{{ $app->created_at->format('d M Y') }}</p>
                        </div>
                        <span class="text-[9px] font-bold px-2 py-0.5 rounded-full uppercase
                            {{ $app->status === 'accepted' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                            {{ $app->status }}
                        </span>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 text-center py-2">Belum ada riwayat lamaran.</p>
                @endforelse
            </div>
        </div>

        <!-- Tombol Aksi Hubungi KOL -->
        <div class="pt-2">
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $kol->user->phone ?? '6281234567890') }}" target="_blank"
               class="w-full bg-[#8B1F33] hover:bg-[#701828] text-white font-bold py-3.5 rounded-2xl text-xs transition-colors shadow-md flex items-center justify-center gap-2">
                <i class="fab fa-whatsapp text-sm"></i>
                <span>Hubungi KOL via WhatsApp</span>
            </a>
        </div>

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
@endsection


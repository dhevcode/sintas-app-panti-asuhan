@extends('layouts.admin')

@section('title', 'Dashboard - CareHub')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center bg-white p-8 rounded-[2rem] border shadow-sm">
        <div>
            <h3 class="text-xl font-black text-slate-800 uppercase tracking-tighter">Ringkasan Operasional</h3>
            <p class="text-xs text-gray-500 mt-1 uppercase font-bold tracking-widest">CareHub v0.1.2 • {{ date('d F Y') }}</p>
        </div>
        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center">
            <i data-lucide="layout-grid"></i>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-8 rounded-[2.5rem] border shadow-sm hover:shadow-md transition">
            <div class="flex justify-between items-start">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center">
                    <i data-lucide="users"></i>
                </div>
                <span class="text-[10px] font-black text-blue-500 bg-blue-50 px-3 py-1 rounded-full uppercase">Aktif</span>
            </div>
            <div class="mt-6">
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Total Anak Asuh</p>
                <h3 class="text-4xl font-black text-slate-800">{{ $totalAnak }}</h3>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] border shadow-sm hover:shadow-md transition">
            <div class="flex justify-between items-start">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                    <i data-lucide="wallet"></i>
                </div>
                <span class="text-[10px] font-black text-emerald-500 bg-emerald-50 px-3 py-1 rounded-full uppercase">Surplus</span>
            </div>
            <div class="mt-6">
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Saldo Kas CareHub</p>
                <h3 class="text-3xl font-black text-slate-800">Rp {{ number_format($saldoKas, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] border shadow-sm hover:shadow-md transition">
            <div class="flex justify-between items-start">
                <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center">
                    <i data-lucide="package"></i>
                </div>
                <span class="text-[10px] font-black text-rose-500 bg-rose-50 px-3 py-1 rounded-full uppercase">Perlu Restock</span>
            </div>
            <div class="mt-6">
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Barang Stok Rendah</p>
                <h3 class="text-4xl font-black text-slate-800">{{ $barangKritis }} <span class="text-sm text-gray-400 font-bold uppercase">Item</span></h3>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border shadow-sm overflow-hidden">
        <div class="p-8 border-b bg-gray-50/50 flex justify-between items-center">
            <h4 class="font-black text-xs uppercase tracking-[0.2em] text-slate-800">Aktivitas Keuangan Terbaru</h4>
            <a href="{{ route('keuangan.index') }}" class="text-[10px] font-black text-blue-600 uppercase hover:underline">Lihat Semua</a>
        </div>
        <div class="divide-y">
            @forelse($transaksiTerakhir as $trx)
            <div class="p-6 flex items-center justify-between hover:bg-gray-50 transition">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 {{ $trx->tipe == 'masuk' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }} rounded-xl flex items-center justify-center">
                        <i data-lucide="{{ $trx->tipe == 'masuk' ? 'arrow-down-left' : 'arrow-up-right' }}" size="18"></i>
                    </div>
                    <div>
                        <p class="font-black text-slate-800 text-sm">{{ $trx->kategori }}</p>
                        <p class="text-[10px] text-gray-400 font-bold uppercase">{{ $trx->tanggal }} • {{ $trx->deskripsi }}</p>
                    </div>
                </div>
                <p class="font-black {{ $trx->tipe == 'masuk' ? 'text-emerald-600' : 'text-rose-600' }}">
                    {{ $trx->tipe == 'masuk' ? '+' : '-' }} Rp {{ number_format($trx->nominal, 0, ',', '.') }}
                </p>
            </div>
            @empty
            <div class="p-12 text-center text-gray-400">
                <p class="text-xs font-bold uppercase">Belum ada transaksi tercatat.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
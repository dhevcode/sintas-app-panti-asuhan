@extends('layouts.admin')
@section('title', 'Keuangan - SINTAS')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-[2rem] border border-emerald-100 shadow-sm">
            <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Total Pemasukan</p>
            <h3 class="text-2xl font-black mt-1 text-emerald-700">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</h3>
        </div>
        <div class="bg-white p-6 rounded-[2rem] border border-rose-100 shadow-sm">
            <p class="text-[10px] font-black text-rose-600 uppercase tracking-widest">Total Pengeluaran</p>
            <h3 class="text-2xl font-black mt-1 text-rose-700">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</h3>
        </div>
        <div class="bg-blue-600 p-6 rounded-[2rem] shadow-xl text-white">
            <p class="text-[10px] font-black text-blue-100 uppercase tracking-widest">Saldo Bersih</p>
            <h3 class="text-2xl font-black mt-1">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
        </div>
    </div>

    <div class="flex gap-4">
        <button onclick="openModal('masuk')" class="bg-emerald-600 text-white px-6 py-3 rounded-2xl text-xs font-black uppercase shadow-lg">+ Pemasukan</button>
        <button onclick="openModal('keluar')" class="bg-rose-600 text-white px-6 py-3 rounded-2xl text-xs font-black uppercase shadow-lg">+ Pengeluaran</button>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase border-b">
                <tr>
                    <th class="px-8 py-5">Tanggal</th>
                    <th class="px-8 py-5">Keterangan</th>
                    <th class="px-8 py-5 text-right">Nominal</th>
                </tr>
            </thead>
            <tbody class="divide-y text-sm">
                @foreach(App\Models\Transaksi::latest()->take(10)->get() as $t)
                <tr class="hover:bg-gray-50">
                    <td class="px-8 py-5 font-bold text-gray-400">{{ $t->tanggal }}</td>
                    <td class="px-8 py-5">
                        <p class="font-black text-gray-800">{{ $t->kategori }}</p>
                        <p class="text-[10px] text-gray-400 uppercase">{{ $t->deskripsi }}</p>
                    </td>
                    <td class="px-8 py-5 text-right font-black {{ $t->tipe == 'masuk' ? 'text-emerald-600' : 'text-rose-600' }}">
                        {{ $t->tipe == 'masuk' ? '+' : '-' }} Rp {{ number_format($t->nominal, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div id="modalFinance" class="fixed inset-0 z-[200] hidden items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm">
    <div class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl p-8 space-y-6 animate-zoomIn">
        <h3 id="modalTitle" class="font-black text-gray-800 uppercase text-xs tracking-widest text-center">Tambah Transaksi</h3>
        <form action="{{ route('keuangan.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="tipe" id="tipeInput">
            <input type="text" name="kategori" placeholder="Kategori (Donasi, Listrik, dll)" class="w-full p-4 bg-gray-50 border rounded-2xl font-bold outline-none" required>
            <input type="number" name="nominal" placeholder="Nominal Rp" class="w-full p-4 bg-gray-50 border rounded-2xl font-black text-xl outline-none" required>
            <textarea name="deskripsi" placeholder="Keterangan singkat..." class="w-full p-4 bg-gray-50 border rounded-2xl outline-none text-sm" rows="3"></textarea>
            <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-xl">Simpan Transaksi</button>
            <button type="button" onclick="closeModal()" class="w-full text-gray-400 text-[10px] font-black uppercase">Batal</button>
        </form>
    </div>
</div>

<script>
    function openModal(tipe) {
        document.getElementById('tipeInput').value = tipe;
        document.getElementById('modalTitle').innerText = tipe == 'masuk' ? 'Tambah Pemasukan' : 'Tambah Pengeluaran';
        document.getElementById('modalFinance').classList.replace('hidden', 'flex');
    }
    function closeModal() {
        document.getElementById('modalFinance').classList.replace('flex', 'hidden');
    }
</script>
@endsection
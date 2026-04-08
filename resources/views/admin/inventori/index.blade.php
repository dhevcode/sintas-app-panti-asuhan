@extends('layouts.admin')
@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-black uppercase tracking-tighter">Logistik & Inventori</h2>
        <button onclick="openModalTambah()" class="bg-blue-600 text-white px-6 py-3 rounded-2xl text-[10px] font-black uppercase">+ Tambah Barang</button>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach($items as $item)
        <div class="bg-white rounded-[2.5rem] border overflow-hidden shadow-sm hover:shadow-md transition flex flex-col h-full">
            <div class="h-44 bg-gray-100 flex items-center justify-center overflow-hidden shrink-0">
                @if($item->gambar)
                    <img src="{{ asset('storage/' . $item->gambar) }}" class="w-full h-full object-cover">
                @else
                    <div class="text-center">
                        <i data-lucide="package" class="mx-auto text-gray-300 mb-1"></i>
                        <span class="text-[9px] text-gray-300 font-black uppercase tracking-widest">No Image</span>
                    </div>
                @endif
            </div>

            <div class="p-6 flex flex-col flex-1">
                <p class="text-[9px] font-black text-blue-600 uppercase tracking-widest mb-1">{{ $item->kategori }}</p>
                <h3 class="font-black text-gray-800 leading-tight text-lg">{{ $item->nama_barang }}</h3>
                
                <div class="mt-4">
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Stok Tersisa</p>
                    <p class="font-black text-2xl text-slate-800">{{ $item->stok }} <span class="text-xs text-slate-400 font-bold uppercase ml-1">{{ $item->satuan }}</span></p>
                </div>

                <div class="mt-auto pt-6 flex items-center justify-between border-t border-gray-50">
                    <button type="button" onclick="editBarang({{ $item->id }})" class="flex items-center gap-1.5 text-blue-500 font-black text-[10px] uppercase tracking-widest hover:text-blue-700 transition-colors">
                        <i data-lucide="edit-3" size="14"></i> Edit
                    </button>
                    
                    <form action="{{ route('inventori.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus barang ini dari SINTAS?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="flex items-center gap-1.5 text-rose-400 font-black text-[10px] uppercase tracking-widest hover:text-rose-600 transition-colors">
                            <i data-lucide="trash-2" size="14"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div id="modalInventori" class="fixed inset-0 z-[200] hidden items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm">
    <div class="bg-white w-full max-w-md rounded-[2.5rem] p-10 space-y-6 animate-zoomIn shadow-2xl">
        
        <div class="text-center">
            <h3 class="font-black text-gray-800 uppercase text-xs tracking-[0.2em]">Tambah Logistik Baru</h3>
            <p class="text-[10px] text-gray-400 font-bold mt-1">SINTAS INVENTORY SYSTEM</p>
        </div>

        <form id="formInventori" action="{{ route('inventori.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div id="methodField"></div> 

            <div class="text-center">
                <h3 id="modalTitle" class="font-black text-gray-800 uppercase text-xs tracking-[0.2em]">Tambah Logistik Baru</h3>
                <p class="text-[10px] text-gray-400 font-bold mt-1">SINTAS INVENTORY SYSTEM</p>
            </div>
            
            <div class="space-y-1">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Nama Barang</label>
                <input type="text" name="nama_barang" placeholder="Contoh: Beras Premium" 
                    class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none font-bold focus:ring-4 focus:ring-blue-50 transition-all" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Jumlah Stok</label>
                    <input type="number" name="stok" placeholder="0" 
                        class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none font-bold focus:ring-4 focus:ring-blue-50" required>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Satuan</label>
                    <input type="text" name="satuan" placeholder="Kg/Dus/Pcs" 
                        class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none font-bold focus:ring-4 focus:ring-blue-50" required>
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Kategori Logistik</label>
                <select name="kategori" class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none font-bold appearance-none">
                    <option value="Sembako">Sembako / Dapur</option>
                    <option value="Kebutuhan Mandi">Kebutuhan Mandi & Kebersihan</option>
                    <option value="Pakaian">Pakaian & Tekstil</option>
                    <option value="Pendidikan">Alat Tulis & Buku</option>
                    <option value="Kesehatan">Obat-obatan & Kesehatan</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <div class="space-y-1">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Foto Barang</label>
                <div class="border-2 border-dashed border-gray-100 rounded-2xl p-4 bg-gray-50/50">
                    <input type="file" name="gambar" class="text-[10px] font-black uppercase text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-5 rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all active:scale-[0.98] mt-4">
                Simpan Logistik
            </button>
            <button type="button" onclick="closeModal()" class="w-full text-gray-300 text-[9px] font-black uppercase tracking-widest hover:text-rose-500 transition-colors">
                Batal & Tutup
            </button>
        </form>
    </div>
</div>

<script>
    function openModal() { document.getElementById('modalInventori').classList.replace('hidden', 'flex'); }
    function closeModal() { document.getElementById('modalInventori').classList.replace('flex', 'hidden'); }

    function openModalTambah() {
        const form = document.getElementById('formInventori');
        
        // Reset Form agar kosong
        form.reset();
        
        // Kembalikan Action ke Store (Simpan Baru)
        form.action = "{{ route('inventori.store') }}";
        
        // Hapus Method PUT (karena simpan baru pakai POST murni)
        document.getElementById('methodField').innerHTML = '';
        
        // Ganti Judul
        document.getElementById('modalTitle').innerText = 'Tambah Logistik Baru';
        
        // Tampilkan Modal
        openModal(); 
    }

    function editBarang(id) {
        // Ambil data dari server (Route edit yang kita buat di Controller)
        fetch(`/inventori/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                const form = document.getElementById('formInventori');
                
                // 1. Ubah Action Form ke URL Update
                form.action = `/inventori/${id}`;
                
                // 2. Tambahkan Method PUT (Syarat Laravel untuk Update)
                document.getElementById('methodField').innerHTML = '@method("PUT")';
                
                // 3. Isi field form dengan data dari Database
                form.nama_barang.value = data.nama_barang;
                form.stok.value = data.stok;
                form.satuan.value = data.satuan;
                form.kategori.value = data.kategori;

                // 4. Ganti Judul Modal
                document.getElementById('modalTitle').innerText = 'Edit Barang: ' + data.nama_barang;
                
                openModal();
            });
    }
</script>
@endsection
@extends('layouts.admin')

@section('title', 'CMS Artikel - CareHub')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center bg-white p-8 rounded-[2rem] border shadow-sm">
        <div>
            <h3 class="text-xl font-black text-slate-800 uppercase tracking-tighter">Content Management</h3>
            <p class="text-xs text-gray-500 mt-1 uppercase font-bold tracking-widest">Kelola Berita & Kegiatan Panti</p>
        </div>
        <button onclick="openModalTambah()" class="bg-blue-600 text-white px-6 py-3.5 rounded-2xl text-xs font-black uppercase tracking-widest shadow-xl hover:bg-blue-700 transition-all">+ Tulis Artikel</button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @forelse($artikels as $a)
        <div class="bg-white rounded-[2.5rem] border overflow-hidden shadow-sm hover:shadow-md transition flex flex-col">
            <div class="h-48 bg-gray-100 shrink-0">
                @if($a->gambar)
                    <img src="{{ asset('storage/' . $a->gambar) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-300 font-black text-[10px] uppercase tracking-widest">No Cover</div>
                @endif
            </div>
            
            <div class="p-8 flex flex-col flex-1">
                <div class="flex items-center gap-2 mb-3">
                    <span class="bg-blue-50 text-blue-600 text-[9px] font-black px-2 py-0.5 rounded-md uppercase">{{ $a->created_at->format('d M Y') }}</span>
                    <span class="text-[9px] text-gray-400 font-bold uppercase">Oleh: {{ $a->penulis }}</span>
                </div>
                <h3 class="font-black text-gray-800 leading-tight text-lg mb-3 line-clamp-2">{{ $a->judul }}</h3>
                <p class="text-gray-500 text-xs leading-relaxed line-clamp-3 mb-6">{{ Str::limit(strip_tags($a->konten), 120) }}</p>
                
                <div class="mt-auto pt-6 border-t border-gray-50 flex justify-between items-center">
                    <button type="button" onclick="editArtikel({{ $a->id }})" class="text-[10px] font-black uppercase text-blue-500 hover:text-blue-700">Edit</button>
                    
                    <form action="{{ route('artikel.destroy', $a->id) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-[10px] font-black uppercase text-rose-400 hover:text-rose-600">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white p-20 rounded-[2.5rem] border border-dashed text-center">
            <i data-lucide="pen-tool" class="mx-auto text-gray-200 mb-4" size="48"></i>
            <p class="text-gray-400 font-bold uppercase text-xs tracking-widest">Belum ada artikel yang dipublish</p>
        </div>
        @endforelse
    </div>
</div>

<div id="modalArtikel" class="fixed inset-0 z-[200] hidden items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm">
    <div class="bg-white w-full max-w-2xl rounded-[2.5rem] p-10 shadow-2xl animate-zoomIn overflow-y-auto max-h-[90vh]">
        <div class="text-center mb-8">
            <h3 id="modalTitle" class="font-black text-gray-800 uppercase text-xs tracking-[0.2em]">Buat Artikel Baru</h3>
            <p class="text-[10px] text-gray-400 font-bold mt-1 uppercase">CareHub CMS ENGINE</p>
        </div>

        <form id="formArtikel" action="{{ route('artikel.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            
            <div id="methodField"></div>

            <div class="space-y-1">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Judul Artikel</label>
                <input type="text" name="judul" placeholder="Masukkan judul yang menarik..." 
                    class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl font-bold outline-none focus:ring-4 focus:ring-blue-50 transition-all" required>
            </div>

            <div class="space-y-1">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Isi Konten</label>
                <textarea name="konten" rows="8" placeholder="Tuliskan isi berita atau kegiatan di sini..." 
                    class="w-full p-5 bg-gray-50 border border-gray-100 rounded-2xl outline-none text-sm leading-relaxed" required></textarea>
            </div>

            <div class="space-y-1">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Gambar Cover</label>
                <div class="border-2 border-dashed border-gray-100 rounded-2xl p-6 bg-gray-50/50 text-center">
                    <input type="file" name="gambar" class="text-[10px] font-black uppercase text-gray-400">
                </div>
                <p class="text-[9px] text-gray-400 ml-1 italic">*Biarkan kosong jika tidak ingin mengubah gambar (saat edit)</p>
            </div>

            <div class="pt-4 flex flex-col gap-3">
                <button type="submit" class="w-full bg-blue-600 text-white py-5 rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all">Simpan Artikel</button>
                <button type="button" onclick="closeModal()" class="w-full text-gray-300 text-[9px] font-black uppercase tracking-widest hover:text-rose-500 transition-colors">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        const modal = document.getElementById('modalArtikel');
        modal.classList.replace('hidden', 'flex');
    }

    function closeModal() {
        const modal = document.getElementById('modalArtikel');
        modal.classList.replace('flex', 'hidden');
    }

    // FUNGSI BARU: Reset form untuk tambah artikel
    function openModalTambah() {
        const form = document.getElementById('formArtikel');
        form.reset();
        form.action = "{{ route('artikel.store') }}";
        document.getElementById('methodField').innerHTML = '';
        document.getElementById('modalTitle').innerText = 'Buat Artikel Baru';
        openModal();
    }

    function editArtikel(id) {
        fetch(`/artikel/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                const form = document.getElementById('formArtikel');
                
                form.action = `/artikel/${id}`;
                
                document.getElementById('methodField').innerHTML = '@method("PUT")';
                
                form.judul.value = data.judul;
                form.konten.value = data.konten;

                document.getElementById('modalTitle').innerText = 'Edit Artikel: ' + data.judul;
                
                openModal();
            })
            .catch(error => {
                alert('Gagal mengambil data artikel');
                console.error(error);
            });
    }
</script>
@endsection
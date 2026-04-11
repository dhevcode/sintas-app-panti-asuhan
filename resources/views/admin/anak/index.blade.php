@extends('layouts.admin')

@section('title', 'Manajemen Anak - CareHub')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center bg-white p-8 rounded-[2rem] border shadow-sm">
        <div>
            <h3 class="text-xl font-black text-slate-800 uppercase tracking-tighter">Database Anak Asuh</h3>
            <p class="text-xs text-gray-500 mt-1 uppercase tracking-widest font-bold">Total: {{ $children->count() }} Anak di CareHub</p>
        </div>
        <button onclick="openModalTambah()" class="bg-blue-600 text-white px-6 py-3.5 rounded-2xl text-xs font-black uppercase tracking-widest shadow-xl hover:bg-blue-700 transition-all">+ Anak Baru</button>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-gray-400 text-[10px] uppercase font-black border-b">
                <tr>
                    <th class="px-8 py-5">Identitas & Bakat</th>
                    <th class="px-8 py-5">Medis</th>
                    <th class="px-8 py-5">Pendidikan</th>
                    <th class="px-8 py-5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($children as $c)
                <tr class="hover:bg-blue-50/20 group transition-colors">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center font-black text-blue-600 text-xl uppercase">{{ substr($c->nama, 0, 1) }}</div>
                            <div>
                                <p class="font-black text-gray-800">{{ $c->nama }}</p>
                                <p class="text-[10px] text-gray-400 font-bold uppercase">{{ $c->jenis_kelamin }} • {{ $c->umur }} TH</p>
                                <div class="mt-1">
                                    <span class="bg-amber-50 text-amber-600 text-[9px] font-black px-2 py-0.5 rounded-md border border-amber-100 uppercase tracking-tighter">
                                        <i data-lucide="sparkles" class="inline w-2 h-2 mr-1"></i> {{ $c->bakat ?? 'Umum' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <span class="bg-rose-50 text-rose-600 text-[10px] font-bold px-3 py-1 rounded-lg border border-rose-100 italic">{{ $c->medis ?? 'Tidak ada data' }}</span>
                    </td>
                    <td class="px-8 py-6 text-xs font-bold text-gray-600 uppercase tracking-tight">{{ $c->pendidikan }}</td>
                    <td class="px-8 py-6">
                        <div class="flex justify-end gap-2">
                            <button onclick="editAnak({{ $c->id }})" class="p-2 text-blue-400 hover:text-blue-600 transition-colors">
                                <i data-lucide="edit-3" size="18"></i>
                            </button>
                            <form action="{{ route('anak.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Hapus profil ini dari CareHub?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-rose-300 hover:text-rose-600 transition-colors">
                                    <i data-lucide="trash-2" size="18"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-8 py-20 text-center text-gray-400">
                        <i data-lucide="folder-open" size="48" class="mx-auto opacity-20 mb-4"></i>
                        <p class="font-bold">Belum ada data anak asuh.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="modalAnak" class="fixed inset-0 z-[200] hidden items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm" onclick="closeModalOutside(event)">
    <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl p-10 flex flex-col animate-zoomIn relative">
        <button onclick="toggleModal(false)" class="absolute top-8 right-8 text-gray-400 hover:text-rose-500">
            <i data-lucide="x"></i>
        </button>

        <form id="formAnak" action="{{ route('anak.store') }}" method="POST" class="space-y-5">
            @csrf
            <div id="methodField"></div>

            <div class="text-center mb-2">
                <h3 id="modalTitle" class="font-black text-gray-800 uppercase text-xs tracking-widest">Tambah Anak Baru</h3>
                <p class="text-[10px] text-gray-400 font-bold mt-1">CareHub DATABASE SYSTEM</p>
            </div>
            
            <div class="space-y-1">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Nama Lengkap</label>
                <input type="text" name="nama" class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl font-bold outline-none focus:ring-4 focus:ring-blue-50 transition-all" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl font-bold outline-none focus:ring-4 focus:ring-blue-50" required>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl font-bold outline-none appearance-none">
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Pendidikan / Sekolah</label>
                <input type="text" name="pendidikan" class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl font-bold outline-none focus:ring-4 focus:ring-blue-50" required>
            </div>

            <div class="space-y-1">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Bakat / Skill</label>
                <input type="text" name="bakat" placeholder="Contoh: Sepak Bola, Melukis" class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl font-bold outline-none focus:ring-4 focus:ring-blue-50">
            </div>

            <div class="space-y-1">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Info Medis</label>
                <textarea name="medis" class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none text-sm resize-none" rows="2" placeholder="Riwayat alergi/penyakit..."></textarea>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-5 rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all active:scale-[0.98]">
                Simpan Data di CareHub
            </button>
        </form>
    </div>
</div>

<script>
    function toggleModal(show) {
        const modal = document.getElementById('modalAnak');
        if (show) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        } else {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }

    function closeModalOutside(event) {
        if (event.target.id === 'modalAnak') toggleModal(false);
    }

    function openModalTambah() {
        const form = document.getElementById('formAnak');
        form.reset();
        form.action = "{{ route('anak.store') }}";
        document.getElementById('methodField').innerHTML = '';
        document.getElementById('modalTitle').innerText = 'Tambah Anak Baru';
        toggleModal(true);
    }

    function editAnak(id) {
        fetch(`/anak/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                const form = document.getElementById('formAnak');
                form.action = `/anak/${id}`;
                document.getElementById('methodField').innerHTML = '@method("PUT")';
                
                form.nama.value = data.nama;
                form.tanggal_lahir.value = data.tanggal_lahir;
                form.jenis_kelamin.value = data.jenis_kelamin;
                form.pendidikan.value = data.pendidikan;
                form.bakat.value = data.bakat || '';
                form.medis.value = data.medis || '';

                document.getElementById('modalTitle').innerText = 'Edit Profil: ' + data.nama;
                toggleModal(true);
            });
    }
</script>
@endsection
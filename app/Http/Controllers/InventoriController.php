<?php

namespace App\Http\Controllers;

use App\Models\Inventori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InventoriController extends Controller
{
    public function index() {
        $items = Inventori::latest()->get();
        return view('admin.inventori.index', compact('items'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama_barang' => 'required', 
            'stok' => 'required|numeric',
            'satuan' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $path = $request->hasFile('gambar') ? $request->file('gambar')->store('inventori', 'public') : null;

        Inventori::create([
            'nama_barang' => $request->nama_barang, 
            'kategori' => $request->kategori,
            'stok' => $request->stok,
            'satuan' => $request->satuan,
            'gambar' => $path
        ]);

        return redirect()->back()->with('success', 'Barang berhasil disimpan ke database SINTAS!');
    }

    // Fungsi Delete (CRUD)
    public function destroy($id) {
        $item = Inventori::findOrFail($id);
        if($item->gambar) {
            Storage::disk('public')->delete($item->gambar); 
        }
        $item->delete();
        return redirect()->back()->with('success', 'Barang dihapus!');
    }

    // Menampilkan form edit (atau mengirim data ke modal)
    public function edit($id) {
        $item = Inventori::findOrFail($id);
        return response()->json($item); // Kita pakai JSON agar bisa tampil di modal tanpa refresh
    }

    // Menyimpan perubahan data
    public function update(Request $request, $id) {
        $item = Inventori::findOrFail($id);
        
        $request->validate([
            'nama_barang' => 'required',
            'stok' => 'required|numeric',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada gambar baru
            if($item->gambar) { Storage::disk('public')->delete($item->gambar); }
            $data['gambar'] = $request->file('gambar')->store('inventori', 'public');
        }

        $item->update($data);

        return redirect()->back()->with('success', 'Data barang berhasil diperbarui!');
    }
}

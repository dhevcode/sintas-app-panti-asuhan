<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikels = Artikel::latest()->get();
        return view('admin.artikel.index', compact('artikels'));
    }

    public function store(Request $request) 
    {
        $request->validate([
            'judul' => 'required', 
            'konten' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        $path = $request->hasFile('gambar') ? $request->file('gambar')->store('artikel', 'public') : null;

        Artikel::create([
            'judul' => $request->judul,
            'konten' => $request->konten,
            'gambar' => $path,
            'penulis' => auth()->user()->name ?? 'Admin SINTAS'
        ]);

        return redirect()->back()->with('success', 'Artikel berhasil dipublish!');
    }

    public function edit($id) 
    {
        $artikel = Artikel::findOrFail($id);
        return response()->json($artikel);
    }

    public function update(Request $request, $id)
    {
        $artikel = Artikel::findOrFail($id);

        $request->validate([
            'judul' => 'required',
            'konten' => 'required',
        ]);

        $data = [
            'judul' => $request->judul,
            'konten' => $request->konten,
        ];

        if ($request->hasFile('gambar')) {
            if ($artikel->gambar) {
                Storage::disk('public')->delete($artikel->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('artikel', 'public');
        }

        $artikel->update($data);

        return redirect()->back()->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);
        
        if ($artikel->gambar) {
            Storage::disk('public')->delete($artikel->gambar);
        }

        $artikel->delete();
        return redirect()->back()->with('success', 'Artikel berhasil dihapus!');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function store(Request $request) {
        $request->validate(['judul' => 'required', 'konten' => 'required']);
        
        $path = $request->hasFile('gambar') ? $request->file('gambar')->store('artikel', 'public') : null;

        \App\Models\Artikel::create([
            'judul' => $request->judul,
            'konten' => $request->konten,
            'gambar' => $path
        ]);

        return redirect()->back()->with('success', 'Artikel berhasil dipublish!');
    }

    public function index()
    {
        // Mengambil semua artikel, urutkan dari yang terbaru
        $artikels = \App\Models\Artikel::latest()->get();

        // Kirim data ke folder admin/artikel/index.blade.php
        return view('admin.artikel.index', compact('artikels'));
    }
}

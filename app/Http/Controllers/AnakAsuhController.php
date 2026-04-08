<?php

namespace App\Http\Controllers;

use App\Models\AnakAsuh;
use Illuminate\Http\Request;

class AnakAsuhController extends Controller
{
    public function index() {
        $children = AnakAsuh::latest()->get();
        return view('admin.anak.index', compact('children'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama' => 'required',
            'tanggal_lahir' => 'required|date', // Pastikan validasi ke tanggal_lahir
            'pendidikan' => 'required',
            // 'umur' => 'required' <--- HAPUS baris ini jika masih ada
        ]);

        AnakAsuh::create($request->all());
        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    public function destroy($id) {
        AnakAsuh::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function edit($id) {
        return response()->json(AnakAsuh::findOrFail($id));
    }
}
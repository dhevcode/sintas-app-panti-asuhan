<?php

namespace App\Http\Controllers;

// WAJIB: Import model Transaksi agar bisa digunakan
use App\Models\Transaksi; 
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function index() 
    {
        // Mengambil data dari tabel transaksis
        $pemasukan = Transaksi::where('tipe', 'masuk')->latest()->get();
        $pengeluaran = Transaksi::where('tipe', 'keluar')->latest()->get();
        
        $totalMasuk = $pemasukan->sum('nominal');
        $totalKeluar = $pengeluaran->sum('nominal');
        $saldo = $totalMasuk - $totalKeluar;

        return view('admin.keuangan.index', compact(
            'pemasukan', 
            'pengeluaran', 
            'totalMasuk', 
            'totalKeluar', 
            'saldo'
        ));
    }

    public function store(Request $request) 
    {
        // Validasi sederhana agar data yang masuk tidak kosong
        $request->validate([
            'kategori' => 'required',
            'nominal' => 'required|numeric',
            'tipe' => 'required|in:masuk,keluar',
        ]);

        Transaksi::create([
            'tanggal' => now(),
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'tipe' => $request->tipe,
            'nominal' => $request->nominal,
            'status' => 'Selesai',
        ]);

        return redirect()->back()->with('success', 'Transaksi berhasil dicatat!');
    }
}
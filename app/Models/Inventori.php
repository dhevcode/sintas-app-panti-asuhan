<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventori extends Model
{
    protected $fillable = ['nama_barang', 'kategori', 'stok', 'satuan', 'gambar'];
}

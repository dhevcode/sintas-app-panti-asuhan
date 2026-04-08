<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    protected $fillable = ['judul', 'slug', 'konten', 'gambar', 'penulis'];

    public static function boot() {
        parent::boot();
        static::creating(function ($artikel) {
            $artikel->slug = \Illuminate\Support\Str::slug($artikel->judul);
        });
    }
}

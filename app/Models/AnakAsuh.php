<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnakAsuh extends Model
{
    protected $fillable = ['nama', 'tanggal_lahir', 'jenis_kelamin', 'medis', 'pendidikan', 'bakat'];
}

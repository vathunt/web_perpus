<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori_Berita extends Model
{
    protected $table = 'kategori_berita';

    protected $fillable = ['nama_kategori'];
}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table = 'berita';

    protected $dates = ['tgl_berita'];

    protected $fillable = [
        'judul_berita',
        'judul_seo',
        'kategori_berita_id',
        'tgl_berita',
        'isi_berita',
        'thumbnail_berita',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function kategori_berita()
    {
        return $this->belongsTo('App\Kategori_Berita');
    }
}
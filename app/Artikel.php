<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    protected $table = 'artikel';

    protected $dates = ['tgl_artikel'];

    protected $fillable = [
        'judul_artikel',
        'judul_seo',
        'tgl_artikel',
        'tag',
        'isi_artikel',
        'thumbnail_artikel',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }
}

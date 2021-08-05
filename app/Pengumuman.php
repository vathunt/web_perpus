<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumuman';

    protected $dates = ['tgl_pengumuman'];

    protected $fillable = [
        'judul_pengumuman',
        'judul_seo',
        'tgl_pengumuman',
        'detail_pengumuman',
        'thumbnail_pengumuman',
        'nama_file_lampiran',
        'lampiran_pengumuman',
        'user_id'
    ];

    protected $casts = [
        'nama_file_lampiran'  => 'array',
        'lampiran_pengumuman' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    protected $table = 'slides';

    protected $fillable = ['gambar_slide', 'keterangan_slide', 'status_tampil'];
}
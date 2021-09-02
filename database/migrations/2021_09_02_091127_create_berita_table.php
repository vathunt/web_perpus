<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateBeritaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id();
            $table->string('judul_berita');
            $table->string('judul_seo');
            $table->unsignedBigInteger('kategori_berita_id');
            $table->date('tgl_berita');
            $table->text('isi_berita');
            $table->string('thumbnail_berita');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('kategori_berita_id')->references('id')->on('kategori_berita')->onUpdate('cascade');
            $table->timestamps();
        });

        // Add Fulltext Index
        DB::statement('ALTER TABLE berita ADD FULLTEXT fulltext_index(judul_berita, isi_berita)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Delete Fulltext Index
        Schema::table('berita', function ($table) {
            $table->dropIndex('fulltext_index');
        });

        Schema::dropIfExists('berita');
    }
}
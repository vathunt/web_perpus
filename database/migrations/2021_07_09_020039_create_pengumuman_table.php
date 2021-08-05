<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePengumumanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id();
            $table->string('judul_pengumuman');
            $table->string('judul_seo');
            $table->date('tgl_pengumuman');
            $table->text('detail_pengumuman');
            $table->string('thumbnail_pengumuman');
            $table->text('nama_file_lampiran')->nullable();
            $table->text('lampiran_pengumuman')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
            $table->timestamps();
        });

        // Add Fulltext Index on Table
        DB::statement('ALTER TABLE `pengumuman` ADD FULLTEXT fulltext_index(judul_pengumuman, detail_pengumuman)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Delete Fulltext Index
        Schema::table('pengumuman', function ($table) {
            $table->dropIndex('fulltext_index');
        });

        Schema::dropIfExists('pengumuman');
    }
}

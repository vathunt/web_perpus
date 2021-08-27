<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateArtikelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artikel', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id();
            $table->string('judul_artikel');
            $table->string('judul_seo');
            $table->text('tags');
            $table->date('tgl_artikel');
            $table->text('isi_artikel');
            $table->string('thumbnail_artikel');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
            $table->timestamps();
        });

        // Add Fultext Index
        DB::statement('ALTER TABLE `artikel` ADD FULLTEXT fulltext_index(judul_artikel, tag, isi_artikel)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Delete Fulltext Index
        Schema::table('artikel', function() {
            $table->dropIndex('fulltext_index');
        });

        Schema::dropIfExists('artikel');
    }
}

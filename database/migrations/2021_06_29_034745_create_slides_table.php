<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slides', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id();
            $table->string('gambar_slide');
            $table->string('keterangan_slide')->nullable();
            $table->enum('status_tampil', ['1', '0'])->default('1');
            $table->timestamps();
        });

        // Add Fulltext Index
        DB::statement('ALTER TABLE `slides` ADD FULLTEXT keterangan_slide_index(keterangan_slide)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Delete Fulltext Index
        Schema::table('slides', function ($table) {
            $table->dropIndex('keterangan_slide_index');
        });

        Schema::dropIfExists('slides');
    }
}

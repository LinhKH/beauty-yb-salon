<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social-setting', function (Blueprint $table) {
            $table->id();
            $table->string('facebook');
            $table->string('twitter');
            $table->string('instagram');
            $table->string('you_tube');
            $table->timestamps();
        });

        DB::table('social-setting')->insert([
            'facebook' => 'https://www.facebook.com/yahooobaba',
            'twitter' => 'https://www.twitter.com/yahooobaba',
            'instagram' => 'https://www.instagram.com/yahoo_baba/',
            'you_tube' => 'https://www.youtube.com/@YahooBaba',
        ]);
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('social-setting');
    }
};

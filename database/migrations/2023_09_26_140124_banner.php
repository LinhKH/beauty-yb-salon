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
        Schema::create('banner', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('sub_title');
            $table->string('banner_image');
            $table->tinyInteger('status')->default('1');
            $table->timestamps();
        });

        DB::table('banner')->insert([[
            'title' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit',
            'sub_title' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit',
            'banner_image' => 'banner1.jpg',
        ],[
            'title' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit',
            'sub_title' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit',
            'banner_image' => 'banner2.jpg',
        ],
        [
            'title' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit',
            'sub_title' => '',
            'banner_image' => 'banner3.jpg',
        ],
        [
            'title' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit',
            'sub_title' => '',
            'banner_image' => 'banner4.jpg',
        ]]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banner');
    }
};

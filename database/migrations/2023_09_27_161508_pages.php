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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('page_title');
            $table->string('page_slug');
            $table->longText('description')->nullable(); //LONGTEXT equivalent to the table
            $table->tinyInteger('status')->default('1'); //Declare a default value for a column
            $table->integer('show_in_header')->default('0'); //Declare a default value for a column
            $table->integer('show_in_footer')->default('0'); //Declare a default value for a column
            $table->timestamps();
        });

        DB::table('pages')->insert([[
            'page_title' => 'About',
            'page_slug' => 'about',
            'show_in_footer' => '1',
        ],[
            'page_title' => 'Privacy',
            'page_slug' => 'privacy',
            'show_in_footer' => '1',
        ]]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
};

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
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('com_name');
            $table->string('com_logo'); 
            $table->string('com_email'); 
            $table->string('com_phone');
            $table->string('address');
            $table->string('address_footer');
            $table->string('cur_format',20); 
            $table->string('map');
            $table->text('description');
            $table->string('booking_amount');
            $table->timestamps();
        });

        DB::table('general_settings')->insert([
            'com_name' => 'Yb Beauty',
            'com_logo' => 'logo.png',
            'com_email' => 'email@company.com',
            'com_phone' => '1597532015',
            'address' => 'New York, United States',
            'address_footer' => 'Copyright @ 2023',
            'cur_format' => '$',
            'map' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.9914410252723!2d2.291906375662195!3d48.85837360070865!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66e2964e34e2d%3A0x8ddca9ee380ef7e0!2sEiffel%20Tower!5e0!3m2!1sen!2sin!4v1698323795994!5',
            'description' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable. If you are going to use a passage of Lorem Ipsum you need to be sure there isnt anything embarrassing hidden in the middle of text.',
            'booking_amount' => '10',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('general_settings');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->id();
            $table->string('admin_name',20);
            $table->string('username',20); 
            $table->string('admin_email',250);
            $table->string('password');
            $table->timestamps();
        });

        DB::table('admin')->insert([
            'admin_name' => 'Site Admin',
            'admin_email' => 'admin@example.com',
            'username' => 'admin',
            'password' => Hash::make('123456'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin');
    }
};

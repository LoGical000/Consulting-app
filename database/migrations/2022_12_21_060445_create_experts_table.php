<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->double('price');
            $table->text('image_url');
            $table->string('phone');
            $table->string('address');
            $table->text('details');
            $table->double('rating')->default(2.5);
            $table->unsignedbigInteger('category_id'); 
            $table->foreign('user_id')->references('id')->on('users')->OnDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->OnDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('experts');
    }
};

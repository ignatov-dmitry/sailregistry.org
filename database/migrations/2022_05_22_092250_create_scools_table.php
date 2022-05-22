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
        Schema::create('scools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_rus');
            $table->integer('old_id')->nullable();
            $table->integer('country_id')->nullable();
            $table->string('country')->nullable();
            $table->string('applicants')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('website')->nullable();
            $table->text('address')->nullable();
            $table->string('logo')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scools');
    }
};

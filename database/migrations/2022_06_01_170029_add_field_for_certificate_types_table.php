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
        Schema::table('certificate_types', function (Blueprint $table) {
            $table->unsignedBigInteger('certificate_type_parent_id')->nullable();
            $table->index('certificate_type_parent_id');
            $table->text('description')->nullable();
            $table->string('region')->nullable();
            $table->string('tides')->nullable();
            $table->string('weather')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('certificate_types', function (Blueprint $table) {

        });
    }
};

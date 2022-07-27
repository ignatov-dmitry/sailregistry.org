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
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('first_name', 'first_name_en');
            $table->renameColumn('middle_name', 'middle_name_en');
            $table->renameColumn('last_name', 'last_name_en');
            $table->string('first_name_ru')->after('last_name');
            $table->string('middle_name_ru')->after('first_name_ru');
            $table->string('last_name_ru')->after('middle_name_ru');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};

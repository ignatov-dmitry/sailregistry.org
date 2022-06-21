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
            $table->string('name_rus')->after('name')->nullable();
            $table->string('type')->after('code')->nullable();
            $table->string('source')->after('type')->nullable();
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
        Schema::table('certificate_types', function (Blueprint $table) {
            //
        });
    }
};

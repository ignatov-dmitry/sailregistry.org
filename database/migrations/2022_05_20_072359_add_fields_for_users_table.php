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
            $table->renameColumn('name', 'user_login');
            $table->string('email')->nullable()->change();
            $table->string('first_name')->nullable()->after('name');
            $table->string('middle_name')->nullable()->after('first_name');
            $table->string('last_name')->nullable()->after('middle_name');
            $table->integer('old_id')->nullable()->after('id');
            $table->string('role')->after('old_id');
            $table->string('public_id')->nullable()->after('old_id');
            $table->date('birthday')->nullable()->after('last_name');
            $table->unsignedBigInteger('country_id')->nullable()->default(0)->after('last_name');
            $table->string('country')->nullable()->after('last_name');
            $table->string('user_status')->nullable()->after('last_name');
            $table->text('img_src')->nullable()->after('last_name');
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

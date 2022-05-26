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
            $table->string('full_name')->nullable()->after('last_name');
            $table->integer('old_id')->nullable()->after('id');
            $table->integer('wp_user_id')->nullable()->after('old_id');
            $table->string('role')->after('wp_user_id');
            $table->string('public_id')->nullable()->after('wp_user_id');
            $table->date('birthday')->nullable()->after('full_name');
            $table->unsignedBigInteger('country_id')->nullable()->default(0)->after('full_name');
            $table->string('country')->nullable()->after('full_name');
            $table->string('user_status')->nullable()->after('full_name');
            $table->text('img_src')->nullable()->after('full_name');
            $table->index('old_id');
            $table->index('wp_user_id');
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

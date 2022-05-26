<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(array(
            [
                'name'  => 'Администратор системы',
                'slug'  => 'super_admin',
                'level' => '1'
            ],
            [
                'name'  => 'Администратор ЦО',
                'slug'  => 'co_admin',
                'level' => '2'
            ],
            [
                'name'  => 'Администратор школы',
                'slug'  => 'school_admin',
                'level' => '3'
            ],
            [
                'name'  => 'Инструктор школы',
                'slug'  => 'instructor',
                'level' => '4'
            ],
            [
                'name'  => 'Обычный пользователь',
                'slug'  => 'basic_contributor',
                'level' => '5'
            ]
        ));
    }
}

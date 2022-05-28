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
                'slug'  => 'super-admin',
                'level' => '1'
            ],
            [
                'name'  => 'Администратор ЦО',
                'slug'  => 'co-admin',
                'level' => '2'
            ],
            [
                'name'  => 'Администратор школы',
                'slug'  => 'school-admin',
                'level' => '3'
            ],
            [
                'name'  => 'Инструктор школы',
                'slug'  => 'instructor',
                'level' => '4'
            ],
            [
                'name'  => 'Обычный пользователь',
                'slug'  => 'basic-contributor',
                'level' => '5'
            ]
        ));
    }
}

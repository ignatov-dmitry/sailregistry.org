<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $query = DB::select('select distinct school_name as name from legacy_certificates;');

        $schools = array();

        foreach ($query as $item) {
            $schools[] = array('name' => $item->name, 'is_active' => 1);
        }

        DB::table('schools')->insert($schools);
    }
}

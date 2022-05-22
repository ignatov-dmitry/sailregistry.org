<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $query = DB::select(
                'SELECT lwt.name FROM legacy_wpua_term_taxonomy AS lwtt
                            LEFT JOIN legacy_wpua_terms AS lwt ON lwt.term_id = lwtt.term_id
                         WHERE lwtt.taxonomy = \'countries\' AND lwt.name != \'test\'
                         ORDER BY name;'
            );

        $countries = array();
        foreach ($query as $item) {
            $countries[] = array('name' => $item->name, 'is_active' => 1);
        }

        DB::table('countries')->insert($countries);
    }
}

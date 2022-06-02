<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RussianCertificateTypeSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $certificates = [
            [
                'name'        => 'Yacht Sailor',
                'code'        => 'S',
                'description' => 'complying requirements of res.40ECE and having all abilities and qualification needed for crew position at  pleasure yacht up to 24 meters lenght',
                'region'      => '',
                'tides'       => '',
                'weather'     => ''
            ],
            [
                'name'        => 'Co-skipper (Secondary skipper)',
                'code'        => 'CS',
                'description' => 'complying requirements of res.40ECE and having all abilities and qualification needed to command trail yacht in flotilla with following limitations:',
                'region'      => 'navigation area GMDSS A1',
                'tides'       => 'nontidal',
                'weather'     => 'fair weather conditions'
            ],
            [
                'name'        => 'Yacht skipper',
                'code'        => 'YS',
                'description' => 'complying requirements of res.40ECE and having all abilities and qualification needed to command pleasure yacht up to 24 meters lenght with following limitations:',
                'region'      => 'navigation area GMDSS A1',
                'tides'       => 'nontidal',
                'weather'     => 'fair weather conditions'
            ],
            [
                'name'        => 'Tidal skipper',
                'code'        => 'TS',
                'description' => 'complying requirements of res.40ECE and having all abilities and qualification needed to command pleasure yacht up to 24 meters lenght with following limitations:',
                'region'      => 'navigation area GMDSS A1',
                'tides'       => 'tidal-nontidal',
                'weather'     => 'fair weather conditions'
            ],
            [
                'name'        => 'Yacht Captain Sea',
                'code'        => 'YCS',
                'description' => 'complying requirements of res.40ECE and having all abilities and qualification needed to command pleasure yacht up to 24 meters lenght with following limitations:',
                'region'      => 'navigation area GMDSS A1-2',
                'tides'       => 'tidal-nontidal',
                'weather'     => 'any weather conditions'
            ],
            [
                'name'        => 'Yacht Captain Ocean',
                'code'        => 'YCO',
                'description' => 'complying requirements of res.40ECE and having all abilities and qualification needed to command pleasure yacht up to 24 meters lenght with following limitations:',
                'region'      => 'navigation area GMDSS A1-2',
                'tides'       => 'tidal-nontidal',
                'weather'     => 'any weather conditions'
            ],
            [
                'name'        => 'GMDSS short range radiooperator',
                'code'        => 'SRC',
                'description' => '',
                'region'      => '',
                'tides'       => '',
                'weather'     => ''
        ],
        ];
        DB::table('certificate_types')->insert($certificates);
    }
}

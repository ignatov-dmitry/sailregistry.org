<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $query = DB::select(
            'select distinct course_name AS name, course_code AS code from legacy_certificates order by course_name;'
        );

        $certificates = array();
        $iteration = 0;
        foreach ($query as $item) {
            if ($item->name == '')
                continue;
            if ($iteration < 200) {
                $certificates[] = [
                    'name' => htmlspecialchars_decode($item->name),
                    'code' => $item->code
                ];
                $iteration++;
            }
            else {
                $certificates[] = [
                    'name' => htmlspecialchars_decode($item->name),
                    'code' => $item->code
                ];
                DB::table('certificate_types')->insert($certificates);
                $certificates = array();
                $iteration = 0;
            }
        }

        if (count($certificates) > 0)
            DB::table('certificate_types')->insert($certificates);
    }
}

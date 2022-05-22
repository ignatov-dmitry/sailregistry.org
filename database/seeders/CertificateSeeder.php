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
        $query = DB::table('legacy_certificates')->get()->toArray();

        $certificates = array();
        $group = 0;
        $iteration = 0;
        foreach ($query as $item) {
            if ($iteration < 200){
                $item = json_decode(json_encode($item),true);
                $item['issue_date'] = $item['issue_date'] !== '' ? date('Y-m-d', strtotime($item['issue_date'])) : null;
                $item['expiry_date'] = $item['expiry_date'] !== '' ? date('Y-m-d', strtotime($item['expiry_date'])) : null;
                $item['revalidation_date'] = $item['revalidation_date'] !== '' ? date('Y-m-d', strtotime($item['revalidation_date'])) : null;
                $certificates[$group][] = $item;
                $iteration++;
            }
            else {
                $group++;
                $iteration = 0;
            }
        }

        foreach ($certificates as $group_certificates) {
            DB::table('certificates')->insert($group_certificates);
        }
    }
}

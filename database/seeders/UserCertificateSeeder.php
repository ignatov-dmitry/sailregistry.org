<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserCertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_certificates = DB::table('legacy_certificates')->get()->toArray();

        $certificates = array();
        $iteration = 0;
        foreach ($user_certificates as $item) {
            if ($iteration < 200) {
                $item = json_decode(json_encode($item),true);
                $item['issue_date'] = $item['issue_date'] !== '' ? date('Y-m-d', strtotime($item['issue_date'])) : null;
                $item['expiry_date'] = $item['expiry_date'] !== '' ? date('Y-m-d', strtotime($item['expiry_date'])) : null;
                $item['revalidation_date'] = $item['revalidation_date'] !== '' ? date('Y-m-d', strtotime($item['revalidation_date'])) : null;
                $certificates[] = $item;
                $iteration++;
            }
            else {
                $item = json_decode(json_encode($item),true);
                $item['issue_date'] = $item['issue_date'] !== '' ? date('Y-m-d', strtotime($item['issue_date'])) : null;
                $item['expiry_date'] = $item['expiry_date'] !== '' ? date('Y-m-d', strtotime($item['expiry_date'])) : null;

                $item['revalidation_date'] = $item['revalidation_date'] !== '' ? date('Y-m-d', strtotime($item['revalidation_date'])) : null;

                $certificates[] = $item;

                DB::table('certificates')->insert($certificates);

                $certificates = array();
                $iteration = 0;
            }
        }

        if (count($certificates) > 0)
            DB::table('certificates')->insert($certificates);
    }
}

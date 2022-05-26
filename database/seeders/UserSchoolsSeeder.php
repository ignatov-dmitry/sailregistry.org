<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSchoolsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_schools = DB::table('user_certificates')
            ->distinct()
            ->select(['user_id', 'school_id'])
            ->get()
            ->toArray();

        $schools = array();
        $iteration = 0;

        foreach ($user_schools as $item) {
            $schools[] = array(
                'user_id' => $item->user_id,
                'school_id' => $item->school_id
            );

            if ($iteration < 500)
                $iteration++;
            else {
                DB::table('user_schools')->insert($schools);
                $schools = array();
                $iteration = 0;
            }
        }

        if (count($schools) > 0)
            DB::table('user_schools')->insert($schools);
    }
}

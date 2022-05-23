<?php

namespace Database\Seeders;

use App\Models\CertificateType;
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
        $user_certificates = DB::table('legacy_certificates as lc')
            ->select(['lc.*', 'u.id as u_id', 's.id as s_id'] )
            ->leftJoin('users as u', 'u.old_id', '=', 'lc.user_id')
            ->leftJoin('schools as s', 's.name', '=', 'lc.school_name')
            ->where('lc.course_name', '!=', '')
            ->get()->toArray();

        $certificates = array();
        $iteration = 0;
        foreach ($user_certificates as $item) {
            $item = json_decode(json_encode($item),true);

            $certificate = CertificateType::where('name', '=', $item['course_name'])->first();

            if ($iteration < 200) {
                $certificates[] = array(
                    'user_id' => $item['u_id'],
                    'old_id' => $item['user_id'],
                    'certificate_id' => $certificate ? $certificate->id : null,
                    'school_id' => $item['s_id'],
                    'instructor_id' => null,
                    'certificate_number' => $item['certificate_number'],
                    'issue_date' => $item['issue_date'] !== '' ? date('Y-m-d', strtotime($item['issue_date'])) : null,
                    'expiry_date' => $item['expiry_date'] !== '' ? date('Y-m-d', strtotime($item['expiry_date'])) : null,
                    'revalidation_date' => $item['revalidation_date'] !== '' ? date('Y-m-d', strtotime($item['revalidation_date'])) : null
                );

                $iteration++;
            }
            else {
                $certificates[] = array(
                    'user_id' => $item['u_id'],
                    'old_id' => $item['user_id'],
                    'certificate_id' => $certificate ? $certificate->id : null,
                    'school_id' => $item['s_id'],
                    'instructor_id' => null,
                    'certificate_number' => $item['certificate_number'],
                    'issue_date' => $item['issue_date'] !== '' ? date('Y-m-d', strtotime($item['issue_date'])) : null,
                    'expiry_date' => $item['expiry_date'] !== '' ? date('Y-m-d', strtotime($item['expiry_date'])) : null,
                    'revalidation_date' => $item['revalidation_date'] !== '' ? date('Y-m-d', strtotime($item['revalidation_date'])) : null
                );

                DB::table('user_certificates')->insert($certificates);

                $certificates = array();
                $iteration = 0;
            }
        }

        if (count($certificates) > 0)
            DB::table('user_certificates')->insert($certificates);
    }
}

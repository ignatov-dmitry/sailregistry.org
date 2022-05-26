<?php

namespace Database\Seeders;

use App\Models\CertificateType;
use App\Models\User;
use App\Models\UserCertificate;
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
            ->select(['lc.*', 'u.id as u_id', 's.id as s_id', 'ui.id as instructor_id', 'lc.school_name as school_name'])
            ->leftJoin('users as u', 'u.old_id', '=', 'lc.user_id')
            ->leftJoin('schools as s', 's.name', '=', 'lc.school_name')
            ->leftJoin('legacy_wpua_usermeta as lwpm', function ($join){
                $join->on('lc.instructor_name', '=', 'lwpm.meta_value')
                     ->on('lwpm.meta_key', '=', DB::raw('\'_name\''));
            })
            ->leftJoin('legacy_wpua_usermeta as lwpm2', function ($join){
                $join->on('lwpm.user_id', '=', 'lwpm2.user_id')
                     ->on('lwpm2.meta_key', '=', DB::raw('\'wpua_capabilities\''));
            })
            ->leftJoin('users as ui', 'lwpm.user_id', '=', 'ui.wp_user_id')
            ->where('lc.course_name', '!=', '')
            ->where('lwpm2.meta_value', '=', 'a:1:{s:10:"instructor";b:1;}')
            ->distinct()
            ->get()
            ->toArray();


        $certificates = array();
        $iteration = 0;
        foreach ($user_certificates as $item) {

            $certificate = CertificateType::where('name', '=', $item->course_name)->first();

            $certificates[] = array(
                'user_id'            => $item->u_id,
                'old_id'             => $item->user_id,
                'certificate_id'     => $certificate ? $certificate->id : null,
                'school_id'          => $item->s_id,
                'school_name'        => $item->school_name,
                'instructor_id'      => $item->instructor_id,
                'instructor_name'    => $item->instructor_name,
                'certificate_number' => $item->certificate_number,
                'issue_date'         => $item->issue_date !== '' ? date('Y-m-d', strtotime($item->issue_date)) : null,
                'expiry_date'        => $item->expiry_date !== '' ? date('Y-m-d', strtotime($item->expiry_date)) : null,
                'revalidation_date'  => $item->revalidation_date !== '' ? date('Y-m-d', strtotime($item->revalidation_date)) : null
            );

            if ($iteration < 500)
                $iteration++;
            else {
                DB::table('user_certificates')->insert($certificates);
                $certificates = array();
                $iteration = 0;
            }
        }

        if (count($certificates) > 0)
            DB::table('user_certificates')->insert($certificates);

    }
}

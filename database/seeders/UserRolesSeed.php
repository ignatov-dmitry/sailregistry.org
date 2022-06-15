<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRolesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_roles = DB::table('users as u')
            ->distinct()
            ->select(['u.id as user_id', 'r.id as role_id', 'uc.school_id'])
            ->leftJoin('roles as r', DB::raw('REPLACE(u.role, \'_\', \'-\')'), '=', DB::raw('REPLACE(r.slug, \'_\', \'-\')'))
            ->leftJoin('user_certificates as uc', 'uc.user_id', '=', 'u.id')
            ->get()
            ->toArray();

        $roles = array();
        $iteration = 0;

        foreach ($user_roles as $item) {
            $roles[] = array(
                'user_id'   => $item->user_id,
                'role_id'   => $item->role_id,
                'school_id' => $item->school_id
            );

            if ($iteration < 500)
                $iteration++;
            else {
                DB::table('user_roles')->insert($roles);
                $roles = array();
                $iteration = 0;
            }
        }

        if (count($roles) > 0)
            DB::table('user_roles')->insert($roles);
    }
}

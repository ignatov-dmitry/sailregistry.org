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
            ->select(['u.id as user_id', 'r.id as role_id'])
            ->leftJoin('roles as r', 'u.role', '=', 'r.slug')
            ->get()
            ->toArray();

        $roles = array();
        $iteration = 0;

        foreach ($user_roles as $item) {
            $roles[] = array(
                'user_id' => $item->user_id,
                'role_id' => $item->role_id
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

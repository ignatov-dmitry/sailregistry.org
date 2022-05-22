<?php

namespace Database\Seeders;

use App\Models\LegacyModels\LegacyWpuaUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $query = DB::select('
            SELECT lwu.ID,
                   lwu.user_login,
                   lwum_capabilities.meta_value AS role,
                   lwum_old_id.meta_value AS old_id,
                   lwum_birthday.meta_value AS birthday,
                   lwum_first_name_en.meta_value AS first_name,
                   lwum_last_name_en.meta_value AS last_name,
                   lwum_middle_name_en.meta_value AS middle_name,
                   lwum_public_id.meta_value AS public_id,
                   lu.country,
                   lu.user_status,
                   lu.img_src
            FROM legacy_wpua_users AS lwu
                LEFT JOIN legacy_wpua_usermeta AS lwum_capabilities ON lwu.ID = lwum_capabilities.user_id AND lwum_capabilities.meta_key = \'wpua_capabilities\'
                LEFT JOIN legacy_wpua_usermeta AS lwum_old_id ON lwu.ID = lwum_old_id.user_id AND lwum_old_id.meta_key = \'_old_id\'
                LEFT JOIN legacy_wpua_usermeta AS lwum_birthday ON lwu.ID = lwum_birthday.user_id AND lwum_birthday.meta_key = \'_birthday\'
                LEFT JOIN legacy_wpua_usermeta AS lwum_first_name_en ON lwu.ID = lwum_first_name_en.user_id AND lwum_first_name_en.meta_key = \'_first_name_en\'
                LEFT JOIN legacy_wpua_usermeta AS lwum_last_name_en ON lwu.ID = lwum_last_name_en.user_id AND lwum_last_name_en.meta_key = \'_last_name_en\'
                LEFT JOIN legacy_wpua_usermeta AS lwum_middle_name_en ON lwu.ID = lwum_middle_name_en.user_id AND lwum_middle_name_en.meta_key = \'_middle_name_en\'
                LEFT JOIN legacy_wpua_usermeta AS lwum_public_id ON lwu.ID = lwum_public_id.user_id AND lwum_public_id.meta_key = \'_public_id\'
                LEFT JOIN legacy_users AS lu ON lu.old_id = lwum_old_id.meta_value and lu.old_id != \'\'
            ORDER BY lwu.ID
        ');


        $users = array();
        $pass = Hash::make('qwerty123');
        $iteration = 0;

        foreach ($query as $item) {
            if ($iteration < 200) {
                $users[] = [
                    'user_login'  => $item->user_login,
                    'role'        => array_keys(unserialize($item->role))[0],
                    'old_id'      => (int)$item->old_id,
                    'birthday'    => $item->birthday !== '' ? date('Y-m-d', strtotime($item->birthday)) : null,
                    'first_name'  => $item->first_name,
                    'last_name'   => $item->last_name,
                    'middle_name' => $item->middle_name,
                    'public_id'   => $item->public_id,
                    'country'     => $item->country,
                    'user_status' => $item->user_status,
                    'img_src'     => $item->img_src,
                    'password'    => $pass
                ];
                $iteration++;
            }
            else {
                $users[] = [
                    'user_login'  => $item->user_login,
                    'role'        => array_keys(unserialize($item->role))[0],
                    'old_id'      => (int)$item->old_id,
                    'birthday'    => $item->birthday !== '' ? date('Y-m-d', strtotime($item->birthday)) : null,
                    'first_name'  => $item->first_name,
                    'last_name'   => $item->last_name,
                    'middle_name' => $item->middle_name,
                    'public_id'   => $item->public_id,
                    'country'     => $item->country,
                    'user_status' => $item->user_status,
                    'img_src'     => $item->img_src,
                    'password'    => $pass
                ];
                DB::table('users')->insert($users);
                $users = array();
                $iteration = 0;
            }
        }
        if (count($users) > 0)
            DB::table('users')->insert($users);
    }
}

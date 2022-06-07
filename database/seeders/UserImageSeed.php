<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Intervention\Image\Facades\Image;

class UserImageSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $russian_schools = ['RAYS', 'Oleg Goncharenko Sailing School', 'Russian Yacht Center', 'Moscow Sailing Academy', 'Daleco', 'Navigatore'];
        $users = User::where('img', '=', null)
            ->whereIn('s.name', $russian_schools)
            ->leftJoin('user_schools as us', 'us.user_id', 'users.id')
            ->leftJoin('schools as s', 's.id', '=', 'us.school_id')
            ->select(['users.id', 'users.hash', 'users.img_src'])
            ->get();
        $inc = 0;
        foreach ($users as $user) {
            if ($user->img_src == '') {
                $this->command->info('user ID: ' . $user->id . ' - No image ' . round(($inc / $users->count()) * 100, 2) . '%');
                $inc++;
                continue;
            }

            try {
                $userPhoto = Image::make($user->img_src);
            }
            catch (\Exception $e) {
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $user->img_src);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $content = curl_exec($curl);
                curl_close($curl);

                try {
                    $userPhoto = Image::make($content);
                }
                catch (\Exception $exception) {
                    continue;
                }
            }

            $path = '/images/photos/' . $user->hash . '.jpg';
            $userPhoto->save(public_path() . $path, 100, 'jpg');
            $user->img = $path;
            $user->save();
            $inc++;
            $this->command->info('user ID: ' . $user->id . ' - Success ' . round(($inc / $users->count()) * 100, 2) . '%');
        }
    }
}

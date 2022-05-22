<?php


namespace App\Models\LegacyModels;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LegacyModels\LegacyUser
 *
 * @property int $id
 * @property string $old_id
 * @property string $name
 * @property string $country
 * @property string $birthday
 * @property string $img_src
 * @property string $qr_code
 * @property string $user_status
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyUser whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyUser whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyUser whereImgSrc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyUser whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyUser whereOldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyUser whereQrCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyUser whereUserStatus($value)
 * @mixin \Eloquent
 */
class LegacyUser extends Model
{
    use HasFactory;
}

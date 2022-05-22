<?php


namespace App\Models\LegacyModels;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LegacyModels\LegacyWpuaUser
 *
 * @property int $ID
 * @property string $user_login
 * @property string $user_pass
 * @property string $user_nicename
 * @property string $user_email
 * @property string $user_url
 * @property string $user_registered
 * @property string $user_activation_key
 * @property int $user_status
 * @property string $display_name
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaUser whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaUser whereID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaUser whereUserActivationKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaUser whereUserEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaUser whereUserLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaUser whereUserNicename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaUser whereUserPass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaUser whereUserRegistered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaUser whereUserStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaUser whereUserUrl($value)
 * @mixin \Eloquent
 */
class LegacyWpuaUser extends Model
{
    use HasFactory;
}

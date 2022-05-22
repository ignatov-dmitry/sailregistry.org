<?php


namespace App\Models\LegacyModels;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LegacyModels\LegacyWpuaUsermeta
 *
 * @property int $umeta_id
 * @property int $user_id
 * @property string|null $meta_key
 * @property string|null $meta_value
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaUsermeta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaUsermeta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaUsermeta query()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaUsermeta whereMetaKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaUsermeta whereMetaValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaUsermeta whereUmetaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaUsermeta whereUserId($value)
 * @mixin \Eloquent
 */
class LegacyWpuaUsermeta extends Model
{
    use HasFactory;
    protected $table = 'legacy_wpua_usermeta';
}

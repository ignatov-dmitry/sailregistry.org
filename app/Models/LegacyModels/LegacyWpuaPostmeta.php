<?php


namespace App\Models\LegacyModels;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LegacyModels\LegacyWpuaPostmeta
 *
 * @property int $meta_id
 * @property int $post_id
 * @property string|null $meta_key
 * @property string|null $meta_value
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPostmeta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPostmeta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPostmeta query()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPostmeta whereMetaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPostmeta whereMetaKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPostmeta whereMetaValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaPostmeta wherePostId($value)
 * @mixin \Eloquent
 */
class LegacyWpuaPostmeta extends Model
{
    use HasFactory;
    protected $table = 'legacy_wpua_postmeta';
}

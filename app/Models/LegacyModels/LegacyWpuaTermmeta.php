<?php

namespace App\Models\LegacyModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LegacyModels\LegacyWpuaTermmeta
 *
 * @property int $meta_id
 * @property int $term_id
 * @property string|null $meta_key
 * @property string|null $meta_value
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaTermmeta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaTermmeta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaTermmeta query()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaTermmeta whereMetaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaTermmeta whereMetaKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaTermmeta whereMetaValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaTermmeta whereTermId($value)
 * @mixin \Eloquent
 */
class LegacyWpuaTermmeta extends Model
{
    use HasFactory;
    protected $table = 'legacy_wpua_termmeta';
}

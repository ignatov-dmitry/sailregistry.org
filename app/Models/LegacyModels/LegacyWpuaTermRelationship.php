<?php

namespace App\Models\LegacyModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LegacyModels\LegacyWpuaTermRelationship
 *
 * @property int $object_id
 * @property int $term_taxonomy_id
 * @property int $term_order
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaTermRelationship newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaTermRelationship newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaTermRelationship query()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaTermRelationship whereObjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaTermRelationship whereTermOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaTermRelationship whereTermTaxonomyId($value)
 * @mixin \Eloquent
 */
class LegacyWpuaTermRelationship extends Model
{
    use HasFactory;
}

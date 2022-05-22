<?php

namespace App\Models\LegacyModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LegacyModels\LegacyWpuaTermTaxonomy
 *
 * @property int $term_taxonomy_id
 * @property int $term_id
 * @property string $taxonomy
 * @property string $description
 * @property int $parent
 * @property int $count
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaTermTaxonomy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaTermTaxonomy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaTermTaxonomy query()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaTermTaxonomy whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaTermTaxonomy whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaTermTaxonomy whereParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaTermTaxonomy whereTaxonomy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaTermTaxonomy whereTermId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaTermTaxonomy whereTermTaxonomyId($value)
 * @mixin \Eloquent
 */
class LegacyWpuaTermTaxonomy extends Model
{
    use HasFactory;
    protected $table = 'legacy_wpua_term_taxonomy';
}

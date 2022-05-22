<?php

namespace App\Models\LegacyModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LegacyModels\LegacyWpuaTerm
 *
 * @property int $term_id
 * @property string $name
 * @property string $slug
 * @property int $term_group
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaTerm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaTerm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaTerm query()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaTerm whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaTerm whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaTerm whereTermGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyWpuaTerm whereTermId($value)
 * @mixin \Eloquent
 */
class LegacyWpuaTerm extends Model
{
    use HasFactory;
}

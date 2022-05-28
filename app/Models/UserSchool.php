<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserSchool
 *
 * @property int $user_id
 * @property int $school_id
 * @method static \Illuminate\Database\Eloquent\Builder|UserSchool newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSchool newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSchool query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSchool whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSchool whereUserId($value)
 * @mixin \Eloquent
 */
class UserSchool extends Model
{
    use HasFactory;
}

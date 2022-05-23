<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserScool
 *
 * @property int $user_id
 * @property int $school_id
 * @method static \Illuminate\Database\Eloquent\Builder|UserScool newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserScool newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserScool query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserScool whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserScool whereUserId($value)
 * @mixin \Eloquent
 */
class UserScool extends Model
{
    use HasFactory;
}

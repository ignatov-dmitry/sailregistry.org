<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserRoles
 *
 * @property int $user_id
 * @property string $role_slug
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoles newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoles newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoles query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoles whereRoleSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRoles whereUserId($value)
 * @mixin \Eloquent
 */
class UserRoles extends Model
{
    use HasFactory;
}

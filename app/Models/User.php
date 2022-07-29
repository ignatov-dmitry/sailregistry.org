<?php

namespace App\Models;

use App\Classes\Corrector;
use App\Traits\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


/**
 * App\Models\User
 *
 * @property int $id
 * @property int|null $old_id
 * @property int|null $wp_user_id
 * @property string|null $public_id
 * @property string $role
 * @property string $user_login
 * @property string|null $first_name
 * @property string|null $middle_name
 * @property string|null $last_name
 * @property string|null $full_name
 * @property string|null $img_src
 * @property string|null $user_status
 * @property string|null $country
 * @property int|null $country_id
 * @property string|null $birthday
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserCertificate[] $certificates
 * @property-read int|null $certificates_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereImgSrc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereOldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePublicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereWpUserId($value)
 * @mixin \Eloquent
 * @property string|null $hash
 * @property string|null $img
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\School[] $schools
 * @property-read int|null $schools_count
 * @method static \Illuminate\Database\Eloquent\Builder|User whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereImg($value)
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Image;

    protected $guarded = [
        '_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public const LOGO_PATH = 'images/photos';

    public function setBirthdayAttribute($value){
        $this->attributes['birthday'] =  date("Y-m-d", strtotime($value));
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function hasRole(... $roles): bool
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('slug', $role)) {
                return true;
            }
        }
        return false;
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(UserCertificate::class);
    }

    public function schools(): BelongsToMany
    {
        return $this->belongsToMany(School::class, 'user_roles');
    }

    public function country(): HasOne
    {
        return $this->hasOne(Country::class);
    }

    public static function checkSimilarEntries(array $userData) {
        $users = User::all()->toArray();
        $corrector = new Corrector();
        $corrector->setWords(array_column($users, 'first_name_en'));
        $firstNameEnArray = $corrector->correctWord([$userData['first_name_en']]);

        $corrector->setWords(array_column($users, 'last_name_en'));
        $lastNameEnArray = $corrector->correctWord([$userData['last_name_en']]);

        $corrector->setWords(array_column($users, 'first_name_ru'));
        $firstNameRuArray = $corrector->correctWord([$userData['first_name_ru']]);

        $corrector->setWords(array_column($users, 'last_name_ru'));
        $lastNameRuArray = $corrector->correctWord([$userData['last_name_ru']]);


        dd($firstNameEnArray, $lastNameEnArray, $firstNameRuArray, $lastNameRuArray);


        return [];
    }
}

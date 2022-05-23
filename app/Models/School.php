<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\School
 *
 * @property int $id
 * @property string $name
 * @property string $name_rus
 * @property int|null $old_id
 * @property int|null $country_id
 * @property string|null $country
 * @property string|null $applicants
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $website
 * @property string|null $address
 * @property string|null $logo
 * @property string|null $description
 * @property int $is_active
 * @method static \Illuminate\Database\Eloquent\Builder|School newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|School newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|School query()
 * @method static \Illuminate\Database\Eloquent\Builder|School whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereApplicants($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereNameRus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereOldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereWebsite($value)
 * @mixin \Eloquent
 */
class School extends Model
{
    use HasFactory;
}

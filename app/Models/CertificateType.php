<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CertificateType
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $code
 * @property int|null $certificate_type_parent_id
 * @property string|null $description
 * @property string|null $region
 * @property string|null $tides
 * @property string|null $weather
 * @property-read CertificateType|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder|CertificateType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CertificateType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CertificateType query()
 * @method static \Illuminate\Database\Eloquent\Builder|CertificateType whereCertificateTypeParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertificateType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertificateType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertificateType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertificateType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertificateType whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertificateType whereTides($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertificateType whereWeather($value)
 * @mixin \Eloquent
 * @property int|null $order
 * @method static \Illuminate\Database\Eloquent\Builder|CertificateType whereOrder($value)
 * @property int|null $priority
 * @property int|null $group
 * @method static \Illuminate\Database\Eloquent\Builder|CertificateType whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertificateType wherePriority($value)
 */
class CertificateType extends Model
{
    use HasFactory;
    protected $hidden = [
        'id',
    ];

    protected $guarded = [
        '_token'
    ];

    public $timestamps = false;

    public array $types = array(
        'international' => 'Международный',
        'local'         => 'Локальный'
    );

    public array $sources = array(
        'IYT' => 'Американский',
        'RSC' => 'Российский'
    );

    public function parent() {
        return $this->hasOne(self::class, 'id', 'certificate_type_parent_id');
    }
}

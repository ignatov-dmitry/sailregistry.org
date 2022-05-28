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
 * @method static \Illuminate\Database\Eloquent\Builder|CertificateType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CertificateType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CertificateType query()
 * @method static \Illuminate\Database\Eloquent\Builder|CertificateType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertificateType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CertificateType whereName($value)
 * @mixin \Eloquent
 */
class CertificateType extends Model
{
    use HasFactory;
    protected $hidden = [
        'id',
    ];

}

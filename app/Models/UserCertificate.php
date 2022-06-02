<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserCertificate
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $old_id
 * @property int|null $certificate_id
 * @property int|null $school_id
 * @property string|null $school_name
 * @property int|null $instructor_id
 * @property string|null $instructor_name
 * @property string|null $certificate_number
 * @property string|null $issue_date
 * @property string|null $expiry_date
 * @property string|null $revalidation_date
 * @property-read \App\Models\CertificateType|null $certificateType
 * @property-read mixed $link
 * @property-read \App\Models\User|null $instructor
 * @property-read \App\Models\School|null $school
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserCertificate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCertificate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCertificate query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCertificate whereCertificateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCertificate whereCertificateNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCertificate whereExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCertificate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCertificate whereInstructorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCertificate whereInstructorName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCertificate whereIssueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCertificate whereOldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCertificate whereRevalidationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCertificate whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCertificate whereSchoolName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCertificate whereUserId($value)
 * @mixin \Eloquent
 */
class UserCertificate extends Model
{
    use HasFactory;

    protected $appends = array('link');

    public function getLinkAttribute() {
        return 'https://iytnet.com/certprofile/' . $this->attributes['old_id'];
    }

    public function certificateType() {
        return $this->hasOne(CertificateType::class, 'id', 'certificate_id');
    }

    public function school() {
        return $this->hasOne(School::class, 'id', 'school_id');
    }

    public function instructor() {
        return $this->hasOne(User::class, 'id', 'instructor_id');
    }

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}

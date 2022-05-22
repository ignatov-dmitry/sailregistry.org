<?php


namespace App\Models\LegacyModels;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LegacyModels\LegacyCertificate
 *
 * @property int $id
 * @property string $user_id
 * @property string $user_status
 * @property string $certificate_number
 * @property string $course_code
 * @property string $course_name
 * @property string $school_name
 * @property string $instructor_name
 * @property string $issue_date
 * @property string $expiry_date
 * @property string $revalidation_date
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyCertificate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyCertificate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyCertificate query()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyCertificate whereCertificateNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyCertificate whereCourseCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyCertificate whereCourseName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyCertificate whereExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyCertificate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyCertificate whereInstructorName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyCertificate whereIssueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyCertificate whereRevalidationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyCertificate whereSchoolName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyCertificate whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyCertificate whereUserStatus($value)
 * @mixin \Eloquent
 */
class LegacyCertificate extends Model
{
    use HasFactory;
}

<?php

namespace App\Http\Controllers;


use App\Classes\PDF_EPS;
use App\Models\Role;
use App\Models\User;
use App\Models\UserCertificate;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Imagick;
use Intervention\Image\Facades\Image;
use setasign\Fpdi\Tfpdf\Fpdi;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StudentsController extends Controller
{
    public function index(Request $request)
    {
        $russian_schools = ['RAYS', 'Oleg Goncharenko Sailing School', 'Russian Yacht Center', 'Moscow Sailing Academy', 'Daleco', 'Navigatore'];
        if ($request->get('schools'))
            $selected_schools = $request->get('schools');
        else
            $selected_schools = $russian_schools;

        $students = User::select(
            [
                'users.id',
                'users.hash',
                'users.old_id',
                'users.full_name',
                'users.birthday',
                'r.name',
                'r.slug',
                DB::raw('GROUP_CONCAT(s.name SEPARATOR \', \') as school_names')
            ])
            ->leftJoin('user_roles as ur', 'users.id', '=', 'ur.user_id')
            ->leftJoin('roles as r', 'r.id', '=', 'ur.role_id')
            ->leftJoin('user_schools as us', 'us.user_id', 'users.id')
            ->leftJoin('schools as s', 's.id', '=', 'us.school_id')
            ->leftJoin('user_certificates as uc', 'uc.user_id', '=', 'users.id')
            ->where('r.slug', '=', Role::BASIC_CONTRIBUTOR)
            ->whereIn('s.name', $selected_schools)
            ->whereBetween('uc.expiry_date', [$request->get('date_from') ? : '1990-01-01', $request->get('date_to') ? : '2100-12-31'])
            ->groupBy(['users.id', 's.name'])
            ->orderBy('s.name')
            ->orderBy('users.full_name')
            ->paginate(30);
        $total = $students->total();
        return view('students.students_list', compact('students', 'total', 'russian_schools'));
    }

    public function showStudent($hash) {
        $user = User::whereHash($hash)->first();
        $userCertificatesGroups = UserCertificate::whereUserId($user->id)
            ->leftJoin('certificate_types as ct', 'ct.id', '=', 'user_certificates.certificate_id')
            ->leftJoin('certificate_types as ct_ru', 'ct_ru.id', '=', 'ct.certificate_type_parent_id')
            ->select([
                'user_certificates.*',
                'ct.*',
                'ct_ru.id as id_ru',
                'ct_ru.name as name_ru',
                'ct_ru.description as description_ru',
                'ct_ru.region as region_ru',
                'ct_ru.tides as tides_ru',
                'ct_ru.weather as weather_ru',
                'ct_ru.group as group_ru',
            ])
            ->get()->groupBy('group_ru', true);
        return view('students.student', compact('user', 'userCertificatesGroups'));
    }

    public function showDataForCertificate(User $user, int $group) {
        $certificate = UserCertificate::whereUserId($user->id)
            ->where('ct_ru.group', '=', $group)
            ->leftJoin('certificate_types as ct', 'ct.id', '=', 'user_certificates.certificate_id')
            ->leftJoin('certificate_types as ct_ru', 'ct_ru.id', '=', 'ct.certificate_type_parent_id')
            ->select([
                'user_certificates.*',
                'ct.*',
                'ct_ru.id as id_ru',
                'ct_ru.name as name_ru',
                'ct_ru.description as description_ru',
                'ct_ru.region as region_ru',
                'ct_ru.tides as tides_ru',
                'ct_ru.weather as weather_ru',
                'ct_ru.group as group_ru',
            ])
            ->orderByDesc('ct_ru.priority')
            ->first();

        $description = '';
        $txt = '';
        if ($certificate->certificateType->parent || $certificate->certificateType) {
            if ($txt = $certificate->certificateType->parent->description ? : $certificate->certificateType->description)
                $description .= $txt;

            if ($txt = $certificate->certificateType->parent->region ? : $certificate->certificateType->region)
                $description .= $txt . '; ';

            if ($txt = $certificate->certificateType->parent->tides ? : $certificate->certificateType->tides)
                $description .= $txt . '; ';

            if ($txt = $certificate->certificateType->parent->weather ? : $certificate->certificateType->weather)
                $description .= $txt . '; ';
        }

        return view('students.certificate_form', compact('certificate', 'description'));
    }

    public function toPdf(User $user, Request $request) {
        $qr = 'qr.png';
        $image = QrCode::size(1000)
            ->format('png')
            ->generate(route('student.student', $user->hash));

        $pdf = new Fpdi();
        $pdf->SetAutoPageBreak(true,0);
        $pdf->AddFont('Helvetica', '', 'Helvetica.ttf', 'utf-8');
        $pdf->AddFont('Helvetica-Bold', '', 'Helvetica-Bold.ttf', 'utf-8');

        //page 1
        $pdf->setSourceFile(resource_path() . '/pdf/certificate/front.pdf');

        $tplIdx = $pdf->importPage(1);
        $specs = $pdf->getTemplateSize($tplIdx);
        $pdf->AddPage("L", array($specs['width'], $specs['height']));
        $pdf->useTemplate($tplIdx);

//        $pdf->SetXY(4.5, 20);
//        $pdf->SetFont('Helvetica', '', 4.5);
//        $pdf->SetTextColor(255, 255, 255);
//        $pdf->Write(0, 'REGISTRY OF SAILING COMPETENCY');

        $profilePhoto = 'profile.jpg';
        if ($user->img_src) {
            $userPhoto = Image::make($user->img_src);
            file_put_contents($profilePhoto,$userPhoto->encode('jpg')); {
                $pdf->Image($profilePhoto, 5.5, 22.97, 25.5);
                unlink($profilePhoto);
            }
        }



        $pdf->SetFont('Helvetica-Bold', '', 12);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Text(31.8, 28.7, strtoupper($request->get('full_name')));

        $pdf->SetFont('Helvetica', '', 9);
        $pdf->SetXY(31.3, 32.8);
        $pdf->MultiCell(65, 4, strtoupper($request->get('certificate_name') . ' ' . $request->get('certificate_code')), null, 'L');
        $pdf->Text(32.55, 42.8, 'DOB: ' . date_format(date_create($request->get('birthday')), 'd.m.Y'));

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(35, 6.2);
        $pdf->Cell(50, 0, 'CERT № ' . $request->get('certificate_code') . ' - ' . $request->get('certificate_number'), 0, 0, 'R');

        $pdf->SetXY(35, 9.77);
        $pdf->Cell(50, 0, 'ISSUED DATE ' . $request->get('issue_date'), 0, 0, 'R');

        $pdf->SetXY(35, 13.25);
        $pdf->Cell(50, 0, 'VALID TILL ' . $request->get('expiry_date'), 0, 0, 'R');

        $pdf->SetXY(35, 16.8);
        $pdf->Cell(50, 0, 'SINCE ' . $request->get('revalidation_date'), 0, 0, 'R');



        //page 2
        $pdf->setSourceFile(resource_path() . '/pdf/certificate/back.pdf');

        $tplIdx = $pdf->importPage(1);
        $specs = $pdf->getTemplateSize($tplIdx);
        $pdf->AddPage("L", array($specs['width'], $specs['height']));
        $pdf->useTemplate($tplIdx);

//        $pdf->SetXY(1.8, 18);
//        $pdf->SetFont('Helvetica', '', 4.5);
//        $pdf->SetTextColor(34, 75, 155);
//        $pdf->Write(0, 'REGISTRY OF SAILING COMPETENCY');

        $pdf->SetXY(4.03, 24.9);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Helvetica', '', 7);
        $pdf->Write(0, 'This is to certify that');

        $pdf->SetXY(4.03, 29.8);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Helvetica-Bold', '', 13);
        $pdf->Write(0, strtoupper($request->get('full_name') . ' ' . $request->get('certificate_code')));

        $pdf->SetXY(4.03, 35.35);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Helvetica', '', 7);
        $pdf->MultiCell(70, 2.7, $request->get('description'), 0, 'L');

        if( file_put_contents($qr,$image)!==false ) {
            $pdf->Image($qr, 65.3, 5, 19.1, 19.1, 'png');
            unlink($qr);
        }
        $pdf->SetDisplayMode('fullwidth');
        $pdf->SetCompression(false);

        $pdf->Close();


        if (in_array($request->get('send'), ['I']))
            $pdf->Output($request->get('send'), 'certificate.pdf', true);

        else {
            $imagick = new Imagick();
            $epsFile = public_path('temp/certificate.eps');
            $pdfFile = public_path('cert.pdf');

            file_put_contents($epsFile, $pdf->Output('S', 'certificate.pdf', true));

            $imagick->readImage($epsFile);

            $saveImagePath = $epsFile;
            $imagick->setImageCompressionQuality(100);
            $imagick->setimageformat('eps');
            $imagick->writeImages($saveImagePath, false);

            $pdf = public_path('cert.pdf');
            exec('convert -density 600x600 ' . $epsFile . ' ' . $pdfFile);
            return response()->download($pdf);
        }
    }
}

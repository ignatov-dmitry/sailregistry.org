<?php

namespace App\Http\Controllers;


use App\Models\Role;
use App\Models\User;
use App\Models\UserCertificate;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use setasign\Fpdi\Tfpdf\Fpdi;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use ZipArchive;

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

    public function showStudent(User $user) {
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
            ->generate(route('students.student', $user));

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

        $pdf->SetXY(2, 18);
        $pdf->SetFont('Helvetica', '', 4.5);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Write(0, 'REGISTRY OF SAILING COMPETENCY');

        $profilePhoto = 'profile.jpg';
        if ($user->img_src) {
            $userPhoto = Image::make($user->img_src);
            file_put_contents($profilePhoto,$userPhoto->encode('jpg')); {
                $pdf->Image($profilePhoto, 3, 21, 25.6);
                unlink($profilePhoto);
            }
        }



        $pdf->SetFont('Helvetica-Bold', '', 12);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Text(30, 27, strtoupper($request->get('full_name')));

        $pdf->SetFont('Helvetica', '', 9);
        $pdf->SetXY(28.9, 32);
        $pdf->MultiCell(65, 4, strtoupper($request->get('certificate_name') . ' ' . $request->get('certificate_code')), null, 'L');
        $pdf->Text(30, 45, 'DOB: ' . date_format(date_create($request->get('birthday')), 'd.m.Y'));

        $pdf->SetFont('Helvetica', '', 7);
        $pdf->SetXY(35, 4);
        $pdf->Cell(50, 0, 'CERT № ' . $request->get('certificate_code') . ' - ' . $request->get('certificate_number'), 0, 0, 'R');

        $pdf->SetXY(35, 8);
        $pdf->Cell(50, 0, 'ISSUED DATE ' . $request->get('issue_date'), 0, 0, 'R');

        $pdf->SetXY(35, 12);
        $pdf->Cell(50, 0, 'VALID TILL ' . $request->get('expiry_date'), 0, 0, 'R');

        $pdf->SetXY(35, 16);
        $pdf->Cell(50, 0, 'SINCE ' . $request->get('revalidation_date'), 0, 0, 'R');



        //page 2
        $pdf->setSourceFile(resource_path() . '/pdf/certificate/back.pdf');

        $tplIdx = $pdf->importPage(1);
        $specs = $pdf->getTemplateSize($tplIdx);
        $pdf->AddPage("L", array($specs['width'], $specs['height']));
        $pdf->useTemplate($tplIdx);

        $pdf->SetXY(1.8, 18);
        $pdf->SetFont('Helvetica', '', 4.5);
        $pdf->SetTextColor(34, 75, 155);
        $pdf->Write(0, 'REGISTRY OF SAILING COMPETENCY');

        $pdf->SetXY(1.8, 22);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Helvetica', '', 6.5);
        $pdf->Write(0, 'This is to certify that');

        $pdf->SetXY(1.8, 27);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Helvetica-Bold', '', 12.5);
        $pdf->Write(0, strtoupper($request->get('full_name') . ' ' . $request->get('certificate_code')));

        $pdf->SetXY(1.8, 32);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Helvetica', '', 6.5);
        $pdf->MultiCell(70, 2.5, $request->get('description'), 0, 'L');

        if( file_put_contents($qr,$image)!==false ) {
            $pdf->SetXY(2, 18);
            $pdf->Image($qr, 63, 2, 20, 20, 'png');
            unlink($qr);
        }

        $pdf->Output($request->get('send'), 'certificate.pdf', true);
    }



//    public function getCertificate(UserCertificate $certificate) {
//        $imgFront = Image::make(resource_path() . '/img/certificate/front.png');
//        $imgBack = Image::make(resource_path() . '/img/certificate/back.png');
//
//        $userPhoto = Image::make($certificate->user->img_src);
//        $userPhoto->resize(178, 178, function ($constraint) {
//            $constraint->aspectRatio();
//        });
//        $imgFront->insert($userPhoto, '', 19, 124);
//
//
//        $userPhoto->resize(75, 69, function ($constraint) {
//            $constraint->aspectRatio();
//        });
//        $imgFront->insert($userPhoto, '', 427, 240);
//
//        // Near head photo
//        $imgFront->text(strtoupper($certificate->user->full_name), 180, 160, function($font) {
//            $font->file(resource_path() . '/fonts/certificates/helvetica_bold.otf');
//            $font->size(25);
//            $font->color([255, 255, 255, 1]);
//        });
//
//        $imgFront->text(strtoupper($certificate->user->full_name), 180, 210, function($font) {
//            $font->file(resource_path() . '/fonts/certificates/helvetica_regular.otf');
//            $font->size(20);
//            $font->color([255, 255, 255, 1]);
//        });
//
//        $imgFront->text('DOB: ' . strtoupper($certificate->user->birthday), 180, 260, function($font) {
//            $font->file(resource_path() . '/fonts/certificates/helvetica_regular.otf');
//            $font->size(20);
//            $font->color([255, 255, 255, 1]);
//        });
//
//        // top right
//        $imgFront->text('CERT № SRC ' . $certificate->certificate_number, 490, 52, function ($font) {
//            $font->file(resource_path() . '/fonts/certificates/helvetica_regular.otf');
//            $font->size(15);
//            $font->color([255, 255, 255, 1]);
//            $font->align('right');
//        });
//
//        $imgFront->text('ISSUED DATE ' . $certificate->issue_date, 490, 77, function ($font) {
//            $font->file(resource_path() . '/fonts/certificates/helvetica_regular.otf');
//            $font->size(15);
//            $font->color([255, 255, 255, 1]);
//            $font->align('right');
//        });
//
//        $imgFront->text('VALID TILL ' . $certificate->expiry_date, 490, 102, function ($font) {
//            $font->file(resource_path() . '/fonts/certificates/helvetica_regular.otf');
//            $font->size(15);
//            $font->color([255, 255, 255, 1]);
//            $font->align('right');
//        });
//
//        if ($certificate->revalidation_date) {
//            $imgFront->text('SINCE ' . $certificate->revalidation_date, 490, 127, function ($font) {
//                $font->file(resource_path() . '/fonts/certificates/helvetica_regular.otf');
//                $font->size(15);
//                $font->color([255, 255, 255, 1]);
//                $font->align('right');
//            });
//        }
//
//
//        $imgBack->text('This is to certify that', 15, 140, function ($font) {
//            $font->file(resource_path() . '/fonts/certificates/helvetica_regular.otf');
//            $font->size(14);
//        });
//
//        $imgBack->text(strtoupper($certificate->user->full_name), 13, 170, function ($font) {
//            $font->file(resource_path() . '/fonts/certificates/helvetica_bold.otf');
//            $font->size(20);
//        });
//
//        $imgBack->text("adsasd asd jklkjkljklj asdljklkjlk lkjlkjlk askldjlkj askljdkljasl \n lkasjd", 13, 210, function ($font) {
//            $font->file(resource_path() . '/fonts/certificates/helvetica_regular.otf');
//            $font->size(13);
//        });
//
//        $image = QrCode::size(120)
//            ->format('png')
//            ->generate('dasdasd asd sad asd adsasdasd asd asd as dasdas ');
//
//        $qr = Image::make(base64_encode($image));
//
//        $imgBack->insert($qr, 'top-left', 370, 15);
//
//
//        return $imgBack->response('png', 100);
//
//
//        $path = time() . '/';
//        File::makeDirectory(storage_path('images/') . $path, 0755, true, true);
//
//        $img->save(storage_path('images/') . $path . 'front.png', 100, 'png');
//
//        $frontImage = $img->basename;
//
//        $zip = new ZipArchive();
//        $zip_file = 'certificates.zip';
//        $zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);
//        $zip->addFile(storage_path('images/' . $path . $frontImage), $frontImage);
//        $zip->close();
//        File::deleteDirectory(storage_path('images/' . $path));
//
//        return response()->download($zip_file);
//    }
}

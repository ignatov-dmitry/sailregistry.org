<?php

namespace App\Exports;

use App\Models\CertificateType;
use App\Models\LegacyModels\LegacyCertificate;
use App\Models\UserCertificate;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
//        $scools = CertificateType::distinct()
//            ->leftJoin('users AS u', 'u.old_id', '=', 'certificates.user_id')
//            ->select(DB::raw('certificates.school_name,
//                u.first_name,
//                u.middle_name,
//                u.last_name,
//                u.birthday,
//                certificates.*
//              '
//            ))
//            ->whereIn('school_name', array('RAYS'))
//            ->whereBetween('expiry_date', array('2022-01-01', '2022-08-31'))
//            ->orderBy('certificates.school_name')
//            ->get();

        $users = UserCertificate::from('user_certificates as uc')
            ->select(array(
                's.name',
                'u.first_name',
                'u.middle_name',
                'u.last_name',
                'u.birthday',
                'u.old_id',
                'uc.certificate_number',
                'ct.code',
                'ct.name as certificate_name',
                'lc.instructor_name',
                'uc.issue_date',
                'uc.expiry_date',
                'uc.revalidation_date'
            ))
            ->leftJoin('schools as s', 's.id', '=', 'uc.school_id')
            ->leftJoin('certificate_types as ct', 'ct.id', '=', 'uc.certificate_id')
            ->leftJoin('users as u', 'u.id', '=', 'uc.user_id')
            ->leftJoin('legacy_certificates as lc', 'lc.user_id', '=', 'uc.old_id')
            ->whereIn('s.name', array('Daleco'))
            ->whereBetween('uc.expiry_date', array('2022-01-01', '2022-08-31'))
            ->get();

        return $users;
    }

    public function headings(): array
    {
        return array_keys($this->collection()->first()->toArray());
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->freezePane('A2');
                $event->sheet->getStyle('P') ->applyFromArray(array( 'font' => array( 'color' => ['rgb' => '0000FF'], 'underline' => 'single' ) ));
            },
        ];
    }
}

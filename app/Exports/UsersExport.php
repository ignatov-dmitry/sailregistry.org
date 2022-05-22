<?php

namespace App\Exports;

use App\Models\CertificateType;
use App\Models\LegacyModels\LegacyCertificate;
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
        $scools = CertificateType::distinct()->leftJoin('users AS u', 'u.old_id', '=', 'certificates.user_id')
            ->select(DB::raw('certificates.school_name,
                u.first_name,
                u.middle_name,
                u.last_name,
                u.birthday,
                certificates.*
              '
            ))
            ->whereIn('school_name', array(
                'Atlas Marine Ltd.',
                'Atlas Marine Vladivostok',
                'Atlas Sailing',
                'Atlas Sailing Greece',
                'Atlas Sailing Spain',
                'Atlas Sailing UK',
                'European Sailing School',
                'European Yacht Training',
                'Friends and Family Sailing School',
                'Friends Travel Yachting School',
                'RAYS',
                'North-West Yacht School',
                'North West Sailing Education',
                'Russian Association of Yacht Skippers',
                'Sailing Time',
                'Sailing Time — Italy',
                'Yacht Captains Club',
                'Yacht Captains Club Montenegro'
            ))
            ->whereBetween('expiry_date', array('2022-01-01', '2022-08-31'))
            ->orderBy('certificates.school_name')
            ->get();

        return $scools;
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

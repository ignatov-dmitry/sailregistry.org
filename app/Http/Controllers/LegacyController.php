<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Models\CertificateType;
use App\Models\LegacyModels\LegacyCertificate;
use App\Models\LegacyModels\LegacyUser;
use App\Models\LegacyModels\LegacyWpuaPost;
use App\Models\LegacyModels\LegacyWpuaPostmeta;
use App\Models\LegacyModels\LegacyWpuaTerm;
use App\Models\LegacyModels\LegacyWpuaTermmeta;
use App\Models\LegacyModels\LegacyWpuaTermRelationship;
use App\Models\LegacyModels\LegacyWpuaTermTaxonomy;
use App\Models\LegacyModels\LegacyWpuaUser;
use App\Models\LegacyModels\LegacyWpuaUsermeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LegacyController extends Controller
{
    public function search(Request $request) {

        $school_certificates = DB::table('schools as s')
            ->select(['s.id as s_id', 'ct.id', 'ls.course_name'])
            ->leftJoin('legacy_certificates as ls', 's.name', '=', 'ls.school_name')
            ->leftJoin('certificate_types as ct', 'ls.course_name', '=', 'ct.name')
            ->distinct()
            ->where('course_name', '!=', '')
            ->get()
            ->groupBy('s_id')
            ->toArray()
        ;
        dd($school_certificates);

        //return Excel::download(new UsersExport(), 'users.xlsx');

        //return view('legacy.search', compact('scools'));
    }
}

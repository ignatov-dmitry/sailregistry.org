<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Models\Certificate;
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
        //return Excel::download(new UsersExport(), 'users.xlsx');

        return Excel::download(new UsersExport, 'users.xlsx');
        //$users = LegacyUser::distinct()->leftJoin('');
        return view('legacy.search', compact('scools'));
    }
}

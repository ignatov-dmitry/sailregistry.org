<?php

namespace App\Http\Controllers;

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

class LegacyController extends Controller
{
    public function search(Request $request) {
        dd(LegacyWpuaTermTaxonomy::all());
        //return view();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CertificateType;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = CertificateType::paginate(20);
        return view('admin.certificate.index', compact('certificates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    public function edit(CertificateType $certificateType)
    {
        return view('admin.certificate.show', compact('certificateType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CertificateType  $certificateType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CertificateType $certificateType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CertificateType  $certificateType
     * @return \Illuminate\Http\Response
     */
    public function destroy(CertificateType $certificateType)
    {
        //
    }
}

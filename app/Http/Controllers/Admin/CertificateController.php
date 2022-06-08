<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCertificateTypeRequest;
use App\Http\Requests\UpdateCertificateTypeRequest;
use App\Models\CertificateType;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index(Request $request)
    {
        $likeStr = '%' . $request->get('search') . '%';
        if ($request->get('search')) {
            $certificates = CertificateType::where('name', 'like', $likeStr)
                ->orWhere('code', 'like', $likeStr)
                ->paginate(20);
        }

        else
            $certificates = CertificateType::paginate(20);

        return view('admin.certificate.index', compact('certificates'));
    }


    public function create(CertificateType $certificateType)
    {
        $certificates = CertificateType::all();
        return view('admin.certificate.show', compact('certificateType', 'certificates'));
    }


    public function store(StoreCertificateTypeRequest $request)
    {
        $certificateType = CertificateType::create($request->toArray());
        return response()->redirectToRoute('admin.certificates.edit', $certificateType);
    }


    public function edit(CertificateType $certificateType)
    {
        $certificates = CertificateType::all();
        return view('admin.certificate.show', compact('certificateType', 'certificates'));
    }


    public function update(UpdateCertificateTypeRequest $request, CertificateType $certificateType)
    {
        $certificateType->update($request->toArray());
        return response()->redirectToRoute('admin.certificates.edit', $certificateType);
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

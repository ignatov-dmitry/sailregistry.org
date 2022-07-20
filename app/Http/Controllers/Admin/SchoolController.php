<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolRequest;
use App\Models\Country;
use App\Models\Role;
use App\Models\School;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index(Request $request)
    {
        $likeStr = '%' . $request->get('search') . '%';
        $schools = School::distinct();

        if ($request->get('search')) {
            $schools = $schools->where('name', 'like', $likeStr)
                ->orWhere('name_rus', 'like', $likeStr);

        }
            $schools = $schools->paginate(20);

        return view('admin.school.index', compact('schools'));
    }

    public function create(School $school)
    {
        //TODO Сделать проверку чтобы не выводились пользователи которые являются админами школ
        $countries = Country::all();
        $admins = $school->schoolAdmin()->where('role_id', '=', 3)->get();
        return view('admin.school.show', compact('school', 'countries', 'admins'));
    }


    public function store(SchoolRequest $request)
    {
        //TODO Сделать проверку чтобы не выводились пользователи которые являются админами школ
        $insert = $request->toArray();

        if (isset($insert['logo'])) {
            $filename = time() . '.' . $insert['logo']->getClientOriginalExtension();
            $insert['logo']->move(public_path(School::LOGO_PATH), $filename);
            $insert['logo'] = School::LOGO_PATH . '/' . $filename;
        }

        $school = School::create($insert);

        $requestAdmin = User::whereId($insert['admin_id'])->first();

        $requestAdmin->roles()->sync([Role::whereSlug(Role::SCHOOL_ADMIN)->first(['id'])->id => ['school_id' => $school->id]]);

        return response()->redirectToRoute('admin.schools.edit', $school);
    }


    public function show(School $school)
    {
        //
    }


    public function edit(School $school)
    {
        //TODO Сделать проверку чтобы не выводились пользователи которые являются админами школ
        $countries = Country::all();
        $admins = $school->schoolAdmin()->where('role_id', '=', 3)->get();
        return view('admin.school.show', compact('school', 'countries', 'admins'));
    }

    public function update(SchoolRequest $request, School $school)
    {
        //TODO Сделать проверку чтобы не выводились пользователи которые являются админами школ
        $insert = $request->toArray();

        $requestAdmins = User::whereIn('id', $insert['admin_id'])->get();

        UserRole::where([
            'role_id'   => Role::whereSlug(Role::SCHOOL_ADMIN)->first(['id'])->id,
            'school_id' => $school->id
        ])->delete();


        foreach ($requestAdmins as $requestAdmin) {
            $requestAdmin->roles()->sync([Role::whereSlug(Role::SCHOOL_ADMIN)->first(['id'])->id => ['school_id' => $school->id]]);
        }


        if (isset($insert['logo'])) {
            $filename = time() . '.' . $insert['logo']->getClientOriginalExtension();
            $insert['logo']->move(public_path(School::LOGO_PATH), $filename);
            $insert['logo'] = School::LOGO_PATH . '/' . $filename;
        }



        $school->update($insert);
        return response()->redirectToRoute('admin.schools.edit', $school);
    }

    public function destroy(School $school)
    {
        //
    }
}

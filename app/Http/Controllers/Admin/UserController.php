<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Role;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mail;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $searchKeys = array('country_id', 'school_id', 'search');
        $countries = Country::all();
        $schools = School::all();
        $likeStr = '%' . $request->get('search') . '%';

        $users = User::distinct()
            ->select(['users.*'])
            ->leftJoin('user_roles as ur', 'ur.user_id', '=', 'users.id')
            ->whereNot('ur.role_id', '=', Role::where('slug', '=', Role::SUPER_ADMIN)->first('id')->id);


        if (Auth::user()->hasRole('school-admin')) {
            $users = $users->whereIn('ur.school_id', array_column(Auth::user()->schools->toArray(), 'id'));
        }

        foreach ($request->toArray() as $key => $item) {
            if ($key == 'search') {
                $users = $users->where(function ($query) use ($likeStr){
                    $query->orWhere('first_name_en', 'like', $likeStr);
                    $query->orWhere('middle_name_en', 'like', $likeStr);
                    $query->orWhere('last_name_en', 'like', $likeStr);
                    $query->orWhere('first_name_ru', 'like', $likeStr);
                    $query->orWhere('middle_name_ru', 'like', $likeStr);
                    $query->orWhere('last_name_ru', 'like', $likeStr);
                    $query->orWhere('email', 'like', $likeStr);
                });
            }
            elseif (in_array($key, $searchKeys)) {
                if (is_array($request->get($key))){
                    $users = $users
                        ->whereIn($key, $request->get($key));
                }
                else {
                    $users = $users
                        ->where($key, $request->get($key));
                }
            }
        }

        $users = $users->paginate(20, ['id']);

        return view('admin.user.index', compact('users', 'countries', 'schools'));
    }

    public function create(Request $request)
    {
        //TODO В представлении есть canEdit нужно с ним разобраться
        $similarUsers = null;
        if ($similarIds = $request->get('similarIds')){
            $similarUsers = User::whereIn('id', $similarIds)->get();
        }

        $schoolSelectAttributes = array('id' => 'school_id');

        if (Auth::user()->hasRole(Role::SUPER_ADMIN)) {
            $schoolSelectAttributes[] = 'multiple';
            $schoolSelectAttributes['name'] = 'school_id[]';
            $schoolSelectAttributes['id'] = 'school_ids';
        }

        $countries = Country::all(['id', 'name'])->toArray();
        $countries = array_combine(array_column($countries, 'id'), array_column($countries, 'name'));
        array_unshift($countries, '');

        $schools = School::all(['id', 'name'])->toArray();
        $schools = array_combine(array_column($schools, 'id'), array_column($schools, 'name'));
        array_unshift($schools, '');

        return view('admin.user.show', compact('countries', 'schools', 'schoolSelectAttributes', 'similarUsers'));
    }

    public function store(Request $request)
    {
        $insert = $request->toArray();
        $similarUsers = User::checkSimilarEntries($insert)->toArray();
        $similarIds = array_column($similarUsers, 'id');
        $similarIdsRequest = $request->get('similarIds') ? $request->get('similarIds') : [];

        if (count($similarUsers) && array_diff($similarIds, $similarIdsRequest)) {

            $request->flash();
            return redirect()->action([UserController::class, 'create'], ['similarIds' => $similarIds]);
        }

        if (isset($insert['img'])) {
            $insert['img'] = User::uploadPhoto($insert['img'], User::LOGO_PATH);
        }



        $user = User::create($insert);
        $user->hash = \hash('sha1', env('APP_KEY') . $user->id);
        $user->save();

        $schoolRoleId = Role::whereSlug(Role::BASIC_CONTRIBUTOR)->first()->id;

        if (isset($insert['school_id']) && is_array($insert['school_id']) && Auth::user()->hasRole(Role::SUPER_ADMIN)) {
            $user->schools()->syncWithPivotValues($insert['school_id'], ['role_id' => $schoolRoleId]);
        }
        else {
            $user->roles()->sync([$schoolRoleId => ['school_id' => Auth::user()->schools->first()->id]]);
        }


        return response()->redirectToRoute('admin.users.edit', $user);
    }

    public function show(User $user)
    {
        return redirect()->route('student.student', $user->hash);
    }

    public function edit(User $user)
    {
        $schoolSelectAttributes = array('id' => 'school_id');

        $countries = Country::all(['id', 'name'])->toArray();
        $countries = array_combine(array_column($countries, 'id'), array_column($countries, 'name'));
        array_unshift($countries, '');

        $schools = School::all(['id', 'name'])->toArray();
        $schools = array_combine(array_column($schools, 'id'), array_column($schools, 'name'));
        array_unshift($schools, '');

        $userSchoolsIds = array_column($user->schools->toArray(), 'id');
        $currentUserSchools = array_column(Auth::user()->schools->toArray(), 'id');

        if ((bool)array_intersect($userSchoolsIds, $currentUserSchools) || Auth::user()->hasRole(Role::SUPER_ADMIN))
        {
            unset($schoolSelectAttributes['disabled']);
            $canEdit = '';
        }
        else {
            $schoolSelectAttributes[] = 'disabled';
            $canEdit = 'disabled';
        }

        if (Auth::user()->hasRole(Role::SUPER_ADMIN)) {
            $schoolSelectAttributes[] = 'multiple';
            $schoolSelectAttributes['name'] = 'school_id[]';
            $schoolSelectAttributes['id'] = 'school_ids';
        }

        return view('admin.user.show', compact('schools', 'countries', 'user', 'canEdit', 'schoolSelectAttributes', 'userSchoolsIds'));
    }

    public function update(Request $request, User $user)
    {
        $validateFields = array(
            'last_name_ru'  => 'required',
            'first_name_ru' => 'required',
            'user_login'    => 'required',
            'email'         => 'required',
            'country_id'    => 'gt:0',
            'img'           => 'image|mimes:jpg,jpeg,png,gif|max:2048'
        );

        if ($user->user_login !== $request->get('user_login'))
            $validateFields['user_login'] = 'required|unique:users';

        if ($user->email !== $request->get('email'))
            $validateFields['email'] = 'required|unique:users';

        $request->validate($validateFields);


        //TODO Проверить чтобы небыло проблем со school_id При сохранении под админом школы (добавлялась школа, а не перезаписывалась)
        $updateData = array('id' => $user->id);
        $updateData = array_merge($updateData, $request->toArray());

        if (isset($updateData['img'])) {
            $updateData['img'] = User::uploadPhoto($updateData['img'], User::LOGO_PATH);
        }

        $user->update($updateData);

        $schoolRoleId = Role::whereSlug(Role::BASIC_CONTRIBUTOR)->first()->id;

        if (isset($request['school_id']) && is_array($request['school_id']) && Auth::user()->hasRole(Role::SUPER_ADMIN)) {
            $user->schools()->syncWithPivotValues($request['school_id'], ['role_id' => $schoolRoleId]);
        }
        else {
            $user->roles()->sync([$schoolRoleId => ['school_id' => Auth::user()->schools->first()->id]]);
        }

        return response()->redirectToRoute('admin.users.edit', $user);
    }

    public function destroy(User $user)
    {
        //
    }

    public function getUsersByUserLogin(Request $request) {
        $users = User::select(['id', 'user_login'])
            ->where('user_login', 'like', $request->get('user_login') . '%')
            ->get();

        return response()->json($users);
    }

    public function sendCredentials(Request $request, User $user) {
        $password = Str::random(8);

        $user->password = Hash::make($password);
        $user->save();

        Mail::send('admin.email.credentials', ['login' => $user->user_login, 'password' => $password], function ($m) use ($request) {
            $m->from('credentials@sailregistry.org', 'sailregistry.org');
            $m->to($request->email)->subject('Ваши доступы к системе sailregistry.org');
        });

        return view('admin.email.credentials', ['login' => $user->user_login, 'password' => $password]);
    }

    public function addToSchool(User $user) {
        $schoolId = (Auth::user()->schools->toArray())[0]['id'];
        $schoolRoleId = Role::whereSlug(Role::BASIC_CONTRIBUTOR)->first()->id;
        $user->schools()->sync([$schoolId => ['role_id' => $schoolRoleId]], false);

        return response()->redirectToRoute('admin.users.edit', $user);
    }
}

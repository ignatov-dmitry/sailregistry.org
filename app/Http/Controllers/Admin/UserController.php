<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
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
    private $currentUser;

    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->currentUser= Auth::user();
            return $next($request);
        });
    }

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


        if ($this->currentUser->hasRole('school-admin')) {
            $users = $users->whereIn('ur.school_id', array_column($this->currentUser->schools->toArray(), 'id'));
        }

        foreach ($request->toArray() as $key => $item) {
            if ($key == 'search') {
                $users = $users->where(function ($query) use ($likeStr){
                    $query->orWhere('first_name', 'like', $likeStr);
                    $query->orWhere('middle_name', 'like', $likeStr);
                    $query->orWhere('last_name', 'like', $likeStr);
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

    public function create()
    {
        //
    }

    public function store(UserRequest $request)
    {
        //
    }

    public function show(User $user)
    {
        return redirect()->route('student.student', $user->hash);
    }

    public function edit(User $user)
    {
        $countries = Country::all(['id', 'name'])->toArray();
        $countries = array_combine(array_column($countries, 'id'), array_column($countries, 'name'));

        $schools = School::all();
        $userSchoolsIds = array_column($user->schools->toArray(), 'id');
        $currentUserSchools = array_column($this->currentUser->schools->toArray(), 'id');

        if ((bool)array_intersect($userSchoolsIds, $currentUserSchools) || $this->currentUser->hasRole(Role::SUPER_ADMIN))
        {
            $canEdit = '';
        }
        else {
            $canEdit = 'disabled';
        }

        return view('admin.user.show', compact('schools', 'countries', 'user', 'canEdit'));
    }

    public function update(UserRequest $request, User $user)
    {
        //
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

        Mail::send('admin.email.credentials', ['login' => $user->user_login,'password' => $password], function ($m) use ($request) {
            $m->from('credentials@sailregistry.org', 'sailregistry.org');

            $m->to($request->email)->subject('Ваши доступы к системе sailregistry.org');
        });

        return view('admin.email.credentials', ['login' => $user->user_login,'password' => $password]);
    }
}

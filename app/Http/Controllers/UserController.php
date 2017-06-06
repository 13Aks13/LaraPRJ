<?php

namespace App\Http\Controllers;

use App\Models\UserStatus;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Image;
use App\User;
use App\Models\Role;

class UserController extends Controller
{
    private $defaultPassword = 'secret';

    protected function uploadAvatar($request, $user) {
        $file       = $request->file('avatar');
        $width      = (int)$request->get('w', 259);
        $height     = (int)$request->get('h', 259);
        $x          = (int)$request->get('x1', 0);
        $y          = (int)$request->get('y1', 0);

        if($width == 0) {
            $width = 259;
        }

        if($height == 0) {
            $height = 259;
        }

        $imageName  = $file->getClientOriginalName();

        $user->deleteAvatar();
        Image::make($file)->crop($width, $height, $x, $y)->resize(259, 259)->save($user->getAvatarStorageFullPath() . '/' . $imageName);
        return $imageName;
    }

    public function index(){
        $users = User::all();

        return view('users.index')->with(['users' => $users]);
    }

    public function show($id)
    {
        $user = User::find($id);

        return view('users.show')->with(['user' => $user]);
    }

    public function create()
    {
        $statuses = UserStatus::all();
        return view('users.create', compact('statuses'));
    }

    public function store(UserRequest $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make($this->defaultPassword);
        $role = Role::where('title', '=', 'role_user')->first();

        $user = new User();
        $user->fill($data);
        $user->status_id = $data['status_id'];
        $user->save();
        if($request->hasFile('avatar')) {
            $user->avatar = $this->uploadAvatar($request, $user);
        }

        $user->role()->associate($role);
        $user->save();

        $this->sendFlashMessage('User successfully created.');
        return redirect()->route('admin.users.index');
    }

    public function edit($id)
    {
        $user = User::find($id);
        $statuses = UserStatus::all();
        return view('users.edit')->with(['user' => $user, 'statuses' => $statuses]);
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::find($id);
        $data = $request->all();

        $user->fill($data);
        if($request->hasFile('avatar')) {
            $user->avatar = $this->uploadAvatar($request, $user);
        }
        $user->save();

        $this->sendFlashMessage('User successfully updated.');
        return redirect()->route('admin.users.index');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        $this->sendFlashMessage('User successfully deleted.');
        return redirect()->route('admin.users.index');
    }

    public function block($id)
    {
        $user = User::find($id);
        $user->isBlocked = !$user->isBlocked;
        $user->save();

        return redirect()->route('admin.users.index');

    }

    public function toggleStatus($id)
    {
        $user = User::find($id);
        //$user->atWork = !$user->atWork;
        $user->save();
        return redirect()->back();
    }

    public function deleteImg($id)
    {
        $user = User::find($id);
        $user->deleteAvatar();
        $user->save();

        $this->sendFlashMessage('User avatar successfully deleted.');
        return redirect()->back();
    }

    public function profile($id)
    {
        $user = User::find($id);
        return view('users.profile')->with([
            'user' => $user,
            'total' => $user->tasks()->where('status_id', '=', 3)->where('updated_at', 'like', date('Y-m-d') . '%')->sum('points'),
        ]);
    }

    public function updateStatus(Request $request)
    {
        $id = $request->input('user_id');
        $status = $request->input('status_id');
        $user = User::find($id);
        $user->status_id = $status;

        $statusName = UserStatus::find($status)->name;

        if(!$user->save()) {
           return response('Status not was changed!', 500);
        }

        return response( [ 'msg' => 'Status changed', 'status_name' => $statusName ], 200 );

    }

}

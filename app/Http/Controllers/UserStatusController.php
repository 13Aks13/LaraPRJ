<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStatusRequest;
use App\Models\UserStatus;

class UserStatusController extends Controller
{

    public function index()
    {
        $userStatus = UserStatus::all();
        return view('userstatus.index')->with(['usersstatus' => $userStatus]);
    }

    public function show($id)
    {
        $userStatus = UserStatus::find($id);
        return view('userstatus.show')->with(['userstatus' => $userStatus]);
    }

    public function create()
    {
        return view('userstatus.create');
    }

    public function store(UserStatusRequest $request)
    {
        $data = $request->all();

        $userStatus = new UserStatus();
        $userStatus->fill($data);
        $userStatus->save();

        $this->sendFlashMessage('User status successfully created.');
        return redirect()->route('admin.user-statuses.index');
    }

    public function edit($id)
    {
        $userStatus = UserStatus::find($id);
        return view('userstatus.edit')->with(['status' => $userStatus]);
    }

    public function update(UserStatusRequest $request, $id)
    {
        $userStatus = UserStatus::find($id);
        $data = $request->all();

        $userStatus->fill($data);
        $userStatus->save();

        $this->sendFlashMessage('User status successfully updated.');
        return redirect()->route('admin.user-statuses.index');
    }

    public function destroy($id)
    {
        $userStatus = UserStatus::find($id);
        $userStatus->delete();

        $this->sendFlashMessage('User status successfully deleted.');
        return redirect()->route('admin.user-statuses.index');
    }

}
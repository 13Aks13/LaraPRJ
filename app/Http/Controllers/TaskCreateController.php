<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\User;
use Auth;
use App\Models\Status;
use App\Http\Requests;

class TaskCreateController extends Controller
{
    public function create()
    {
        $users = User::where('role_id', '=', '2')->where('isBlocked', '=', false)->get();

        return view('tasks.store')->with(['users' => $users]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $task = new Task();
        $task->fill($data);
        $task->CreatedBy()->associate(Auth::user());
        $status = Status::where('title', '=', 'new')->first();
        $task->status()->associate($status);
        $task->AssigneTo()->associate(Auth::user());
        $task->save();
        $this->sendFlashMessage('Task successfully created.');
        return redirect()->route('home');
    }

}

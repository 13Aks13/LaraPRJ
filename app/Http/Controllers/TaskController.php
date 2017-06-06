<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\User;
use App\Models\Status;
use App\Models\Note;
use Auth;
use App\Http\Requests;
use App\Http\Requests\TaskRequest;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();

        return view('tasks.index')->with(['tasks' => $tasks]);
    }

    public function create()
    {
        $users = User::where('role_id', '=', '2')->where('isBlocked', '=', false)->get();

        return view('tasks.create')->with(['users' => $users]);
    }

    public function edit($id)
    {
        $task = Task::find($id);
        $users = User::where('role_id', '=', '2')->where('isBlocked', '=', false)->get();

        return view('tasks.edit')->with(['task' => $task, 'users' => $users]);
    }

    public function update(TaskRequest $request, $id)
    {
        $task = Task::find($id);
        $data = $request->all();
        $task->fill($data);
        if('' !== $assigneTo = $request->get('assigneTo', '')) {
            $task->assigneTo_id = $assigneTo;
        } else {
            $task->AssigneTo()->associate(Auth::user());
        }
        $task->save();
        $this->sendFlashMessage('Task successfully updated.');
        return redirect()->Route('admin.tasks.index');
    }

    public function store(TaskRequest $request)
    {
        $data = $request->all();
        $task = new Task();
        $task->fill($data);
        $task->CreatedBy()->associate(Auth::user());
        $status = Status::where('title', '=', 'new')->first();
        $task->status()->associate($status);
        if('' !== $assigneTo = $request->get('assigneTo', '')) {
            $task->assigneTo_id = $assigneTo;
        } else {
            $task->AssigneTo()->associate(Auth::user());
        }
        $task->save();
        $this->sendFlashMessage('Task successfully created.');
        return redirect()->Route('admin.tasks.index');
    }

    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();
        $this->sendFlashMessage('Task successfully deleted.');
        return redirect()->Route('admin.tasks.index');
    }

    public function changeStatus(Request $request)
    {
        $id = $request->get('id');
        $note = $request->get('note', '');

        $task = Task::find($id);
        $status = Status::where('title', '=', 'done')->first();
        $task->status()->associate($status);

        if($note != '') {
            $comment = new Note;
            $comment->text = $note;
            $comment->task()->associate($task);
            $comment->save();
        }

        $task->save();
        return redirect()->back();
    }
}

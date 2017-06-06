<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\StatusRequest;
use App\Models\Status;

class StatusController extends Controller
{
    public function index()
    {
        $statuses = Status::all();

        return view('statuses.index')->with(['statuses' => $statuses]);
    }

    public function create()
    {
        return view('statuses.create');
    }

    public function edit($id)
    {
        $status = Status::find($id);

        return view('statuses.edit')->with(['status' => $status]);
    }
    public function store(StatusRequest $request)
    {
        $data = $request->all();

        $status = new Status();
        $status->fill($data);
        $status->save();

        return redirect()->Route('admin.statuses.index');
    }

    public function update(StatusRequest $request, $id)
    {
        $status = Status::find($id);
        $data = $request->all();

        $status->fill($data);
        $status->save();

        $this->sendFlashMessage('Task successfully updated.');
        return redirect()->Route('admin.statuses.index');
    }

    public function destroy($id)
    {
        $status = Status::find($id);
        $status->delete();

        $this->sendFlashMessage('Task successfully deleted.');
        return redirect()->Route('admin.statuses.index');
    }
}

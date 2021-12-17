<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("pages.tasks", ['tasks' => Task::withTrashed()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return route("tasks.index");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required'
        ]);

        Task::create($request->all());

        return redirect()->route("tasks.index")->with("success", "Task has been created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Task::withTrashed()->find($id);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $newData = $request->validate([
            'description' => 'required'
        ]);

        Task::where('id', $id)->update($newData);

        return redirect()->route('tasks.index')->with("success", "Task has beens updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::where('id', $id)->firstOrFail();
        $task->delete();

        return redirect()->route("tasks.index")->with("success", "Task has been deleted successfully");
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        Task::withTrashed()->find($id)->restore();

        return redirect()->route("tasks.index")->with("success", "Task has been restored successfully");
    }

    /**
     * Force delete done resources from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteDoneTasks()
    {
        Task::onlyTrashed()->forceDelete();

        return redirect()->route("tasks.index")->with("success", "Done tasks have been deleted successfully");
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\toDo;
use Illuminate\Http\Request;

class ToDoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $todo = toDo::all();
        // return response()->json($todo);
        if (request()->ajax()) {
            $todo = toDo::latest()->get();
            return response()->json(['todo' => $todo]);
        }

        return view('todo.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        $request->validate([
            'name' => 'required|unique:to_dos,name',
        ]);


        if(toDo::create($request->only('name'))){

            return response()->json(['message' => 'To do data added successfully']);
        }else{
            dd("errr");
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(toDo $toDo)
    {
        $todo = toDo::all();
        return response()->json($todo);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(toDo $toDo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, toDo $toDo)
    {
        $task = todo::findOrFail($request->todos_id);
        if($task->completed==0){

            $task->completed = 1;
        }else{
            $task->completed = 0;

        }
        $task->save();
    
        return response()->json(['message' => 'Task updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, toDo $toDo)
    {
        $task = todo::findOrFail($request->todos_id);
        if($task){

            $task->delete();
          
        }

        return response()->json(['message' => 'To Do deleted successfully']);
    }
}

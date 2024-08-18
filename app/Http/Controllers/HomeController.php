<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function task() {

        $task = Task::where('user_id', Auth::id())->orderBy('created_at', 'DESC')->get();
        return view('user.task', compact('task'));

    }
    public function dashboard() {
        return view('user.dashboard');
    }
    public function addTask(Request $request) {

        Validator::make($request->all(), [
            'task' => ['required', 'string', 'max:255' ],
            'description' => ['nullable' ,'string'],
            'deadline' => ['required', 'date']
        ])->validate();

        Task::create([
            'user_id' => auth()->id(),
            'task_title' => $request->input('task'),
            'description' => $request->input('description'),
            'deadline' => $request->input('deadline'),
            'date' => Carbon::now(),
            'created_at' =>  Carbon::now(),
            'updated_at' =>  null,
            'deleted_at' =>  null
        ]);

        return redirect()->back()->with('success', 'Task created successfully.');
    }
    public function editTask(Request $request, $id)
    {
        $request->validate([
            'task' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date',
        ]);

        try {
            $task = Task::findOrFail($id);
            $task->update([
                'task_title' => $request->input('task'),
                'deadline' => $request->input('deadline'),
                'description' => $request->input('description'),
                'updated_at' => now(),
            ]);

            return redirect()->back()->with('success', 'Task updated successfully!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Task not found!');
        }
    }

    public function deleteTask($id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();

            return redirect()->back()->with('success', 'Task deleted successfully!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Task not found!');
        }
    }

}

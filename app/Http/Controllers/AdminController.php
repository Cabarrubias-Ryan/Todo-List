<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Task;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard() {
        return view('admin.dashboard');
    }
    public function displayTask() {
        $task = DB::table('Task')
                        ->orderBy('created_at', 'ASC')
                        ->get();
        return view('admin.task', compact('task'));
    }
    public function displayUser(){
        $users = DB::table('User')
                        ->join('Task', 'User.id', '=', 'Task.user_id')
                        ->select('User.*', DB::raw('COUNT(Task.id) as task_count'))
                        ->groupBy('User.id')
                        ->orderBy('created_at','ASC')
                        ->get();


        return view('admin.user', compact('users'));
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

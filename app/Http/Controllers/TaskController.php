<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class TaskController extends Controller
{

    public function index(){

        //Busca el usuario
        $user = User::find(Auth::id());

        return view('user.tasks.tasks_index', [
            'tasks' => $user->tasks,
            'action' => route('user.tasks.store'),
            'method' => 'POST',
        ]);
    }

    public function store(CreateTaskRequest $request){

        $task = Task::create([
            'name' => $request->task
        ]);

        //Busca el usuario
        $user = User::find(Auth::id());

        //Guarda en la tabla pivote de tareas ligada al usuario
        $user->tasks()->attach($task->id);

        //Redirecciona al index de tareas
        return redirect()->route('user.tasks.index')
        ->with('success', 'Tarea registrada correctamente.');

    }

    public function destroy($id){

        //Busca la tarea
        $task = Task::find($id);

        //Comprueba que la tarea existe
        if (!$task) {
            //Redirecciona al index de tareas con un mensaje de error
            return redirect()->route('user.tasks.index')
            ->with('error', 'La tarea no existe.');
        }

        //Busca el usuario
        $user = User::find(Auth::id());

        //Elimina de la tabla pivote la tarea ligada al usuario
        $user->tasks()->detach($task->id);

        //Elimina la tarea
        $task->delete();

        //Redirecciona al index de tareas
        return redirect()->route('user.tasks.index')
        ->with('success', 'Tarea eliminada correctamente.');

    }



}

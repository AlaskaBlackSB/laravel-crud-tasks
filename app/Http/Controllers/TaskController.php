<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    public function index()
    {

        //Busca el usuario
        $user = User::find(Auth::id());

        return view('user.tasks.tasks_index', [
            'tasks' => $user->tasks,
            'action' => route('user.tasks.store'),
            'method' => 'POST',
        ]);
    }

    public function store(CreateTaskRequest $request)
    {

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

    public function edit($id)
    {

        /* Comprobamos que la tarea exista y que sea del usuario autenticado */
        $models = verifyTask($id);

        if ($models === false) {
            return redirect()->route('user.tasks.index')
            ->with('error', 'La tarea no existe o no pertenece al usuario autenticado.');
        }

        return View('user.tasks.show_task', [
            'task' => $models['task'],
            'tasks' => $models['user']->tasks,
            'action' => route('user.tasks.update', ['task' => $models['task']->id]),
            'method' => 'PUT',
        ]);
    }

    public function update(CreateTaskRequest $request, $id)
    {

        /* Comprobamos que la tarea exista y que sea del usuario autenticado */
        $models = verifyTask($id);

        if ($models === false) {
            return redirect()->route('user.tasks.index')
            ->with('error', 'La tarea no existe o no pertenece al usuario autenticado.');
        }

        // Actualiza la tarea
        $models['task']->update([ 'name' => $request->task]);

        //Redirecciona al index de tareas
        return redirect()->route('user.tasks.index')
        ->with('success', 'Tarea actualizada correctamente.');

    }

    public function destroy($id)
    {

        /* Comprobamos que la tarea exista y que sea del usuario autenticado */
        $models = verifyTask($id);

        if ($models === false) {
            return redirect()->route('user.tasks.index')
            ->with('error', 'La tarea no existe o no pertenece al usuario autenticado.');
        }

        //Elimina de la tabla pivote la tarea ligada al usuario
        $models['user']->tasks()->detach($models['task']->id);

        //Elimina la tarea
        $models['task']->delete();

        //Redirecciona al index de tareas
        return redirect()->route('user.tasks.index')
        ->with('success', 'Tarea eliminada correctamente.');

    }



}

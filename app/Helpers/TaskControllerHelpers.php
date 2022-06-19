<?php

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

if (! function_exists('verifyTask')) {
    function verifyTask($id)
    {
        /* Comprobamos que la tarea exista y que sea del usuario autenticado */

        //Busca la tarea
        $task = Task::find($id);

        // Comprueba que la tarea exista
        if (!$task) {
            //Redirecciona al index de tareas con un mensaje de error
            return false;
        }

        // Buscamos al usuario
        $user = User::find(Auth::id());

        //Comprobamos que la tarea le pertenece al usuario
        if ( empty($user->tasks()->where('id', $id)->get()->first())  ) {
            // Redirecciona al index de tareas con un mensaje de error
            return false;
        }

        return [
            'task' => $task,
            'user' => $user,
        ];
    }
}

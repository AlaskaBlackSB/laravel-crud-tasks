@extends('layouts.app')

@section('content')

<div class="container w-auto">
    <div class="bg-white border border-dark px-3">
        <h3 class="text-center border-bottom pt-2 pb-2">Editar una tarea</h3>

        {{-- Muestra mensaje de exito al crear la liga --}}
        @include('components.show-messages-success-errors')

        <div class="p-3 ">
            <form method="POST" action="{{ isset($action)? $action : '' }}">
                @csrf
                @method(isset($method) ? $method : 'POST')
                <div class="mb-3">
                  <label
                    for="task"
                    class="form-label
                        @error('task')
                            is-invalid
                        @enderror
                    "
                    @error('task')
                        autofocus
                    @enderror
                    >Nombre:</label>
                  <input type="text" name="task" class="form-control" id="task" aria-describedby="taskHelp" value="{{$task->name}}">
                  <div id="taskHelp" class="form-text">Nombre de la tarea.</div>
                  @error('task')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
                <button type="submit" class="btn btn-primary">Editar</button>
              </form>
        </div>
    </div>

    @include('user.tasks.components.show_tasks')
</div>

@endsection


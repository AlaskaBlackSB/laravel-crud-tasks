<div class="mt-4 p-3">
    <h2>Tareas</h2>
    @if (!$tasks->isEmpty())
    <div class="table-responsive w-auto">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <th>{{$task->name}}</th>
                        <th>
                            <a
                            href="{{route('user.tasks.edit', ['task' => $task->id])}}"
                            >Editar</a>
                        </th>
                        <th>
                            <form method="POST" action="{{route('user.tasks.destroy', ['task' => $task->id])}}">
                                @csrf
                                @method("delete")
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <div class="alert alert-danger d-flex align-items-center justify-content-center text-center py-2" role="alert">
            {{-- <i class="material-icons icon text-danger">warning</i> --}}
                    No hay tareas registradas
        </div>
    @endif
</div>

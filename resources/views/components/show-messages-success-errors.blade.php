{{-- Muestra mensaje de exito al crear la liga --}}
@if (session('success'))
<div>
    <p class="alert alert-success mb-0">{{session('success')}}</p>
</div>
@endif

{{-- Muestra mensaje de error --}}
@if (session('error'))
<div>
    <p class="alert alert-danger mb-0">{{session('error')}}</p>
</div>
@endif

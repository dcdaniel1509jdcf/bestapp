@extends('adminlte::page')

@section('title', 'Permisos')

@section('content_header')
    <h1 class="m-0 text-dark">@lang('permissions')</h1>
@stop
@section('content')

    <section class="section">

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @can('permission-create')
                                <a class="btn btn-sm btn-info" href="{{ route('permissions.create') }}">Crear nuevo Permiso</a>
                            @endcan

                            <table class="table table-striped mt-2">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Permiso</th>

                                        <th scope="col">Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <th scope="row">{{ $permission->id }}</th>
                                            <td>{{ $permission->name }}</td>
                                            <td>
                                                @can('permission-edit')
                                                    <a class="btn btn-sm btn-outline-info"
                                                        href="{{ route('permissions.edit', ['permission' => $permission->id]) }}">Editar</a>
                                                @endcan

                                                @can('permission-delete')
                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'route' => ['permissions.destroy', $permission->id],
                                                        'style' => 'display:inline',
                                                        'class' => 'form-eliminar',
                                                    ]) !!}


                                                    {!! Form::submit('Borrar', ['class' => 'btn btn-sm btn-outline-danger']) !!}

                                                    {!! Form::close() !!}
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                            <div class="pagination justify-content-end">


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')

    <script>
        $(document).ready(function() {
            $(".form-eliminar").submit(function(e) {
                e.preventDefault(); // Previniendo el comportamiento predeterminado del botón
                Swal.fire({
                    title: "¿Está seguro?",
                    text: "Se va a eliminar un registro!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    cancelButtonText: "Cancelar",
                    confirmButtonText: "Sí, eliminar!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Si el usuario confirma, envía el formulario
                        this.submit();
                    }
                });
            });
        });
    </script>

@endsection

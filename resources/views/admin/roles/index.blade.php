@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
    <h1 class="m-0 text-dark">@lang('Roles')</h1>
@stop
@section('content')

    <section class="section">

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @can('role-create')
                                <a class="btn btn-sm btn-info" href="{{ route('roles.create') }}">Crear nuevo Rol</a>
                            @endcan
<br>
<br>
                            <table class="table table-striped mt-2" id="tableIni">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Rol</th>

                                        <th scope="col">Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                        <tr>
                                            <th scope="row">{{ $role->id }}</th>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                                @can('role-edit')
                                                    <a class="btn btn-sm btn-outline-info"
                                                        href="{{ route('roles.edit', ['role' => $role->id]) }}">Editar</a>
                                                @endcan

                                                @can('role-delete')
                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'route' => ['roles.destroy', $role->id],
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
            $("#tableIni").DataTable();
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

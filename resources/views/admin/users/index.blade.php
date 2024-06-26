@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Usuarios</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row py-2">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-right">
                                @can('user-delete')
                                    <a class="btn btn-sm btn-info" href="{{ route('users.create') }}"> Crear nuevo usuario</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped mt-2" id="tableIni">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $user)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if (!empty($user->getRoleNames()))
                                            @foreach ($user->getRoleNames() as $v)
                                                <label class="badge badge-success">{{ $v }}</label>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        <!-- <a class="btn btn-info" href="{{ route('users.show', $user->id) }}">Show</a> -->
                                        @can('user-edit')
                                            <a class="btn btn-primary" href="{{ route('users.edit', $user->id) }}">Editar</a>
                                        @endcan
                                        @can('user-delete')
                                            {!! Form::open([
                                                'method' => 'DELETE',
                                                'route' => ['users.destroy', $user->id],
                                                'style' => 'display:inline',
                                                'class' => 'form-eliminar',
                                            ]) !!}
                                            {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                                            {!! Form::close() !!}
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>


@stop

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

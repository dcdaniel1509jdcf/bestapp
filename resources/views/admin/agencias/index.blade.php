@extends('adminlte::page')

@section('title', 'Agencias')

@section('content_header')
    <h1 class="m-0 text-dark">Agencias</h1>
@stop
@section('content')

    <section class="section">

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @can('agencia-create')
                                <a class="btn btn-sm btn-info" href="{{ route('agencias.create') }}">Crear nueva Agencia</a>
                            @endcan

                            <table class="table table-striped mt-2">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nombre</th>

                                        <th scope="col">Direccion</th>
                                        <th scope="col">Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($agencias as $agencia)
                                        <tr>
                                            <th scope="row">{{ $agencia->id }}</th>
                                            <td>{{ $agencia->nombre }}</td>
                                            <td>{{ $agencia->direccion }}</td>
                                            <td>
                                                @can('agencia-edit')
                                                    <a class="btn btn-sm btn-outline-info"
                                                        href="{{ route('agencias.edit', ['agencia' => $agencia->id]) }}">Editar</a>
                                                @endcan

                                                @can('agencia-delete')
                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'route' => ['agencias.destroy', $agencia->id],
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

@extends('adminlte::page')

@section('title', 'Depósitos')

@section('content_header')
    <h1 class="m-0 text-dark">Depósito</h1>
@stop
@section('content')

    <section class="section">

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @can('deposito-create')
                                <a class="btn btn-sm btn-info" href="{{ route('depositos.create') }}">Crear nuevo Depósito</a>
                            @endcan

                            <table class="table table-striped mt-2" id="tableIni">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Cliente</th>
                                        <th scope="col">Agencia</th>

                                        <th scope="col">Fecha</th>
                                        <th scope="col">Usuario</th>
                                        <th scope="col">Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($depositos as $deposito)
                                        <tr>
                                            <th scope="row">{{ $deposito->id }}</th>
                                            <td>{{ $deposito->apellidos  }}</td>
                                            <td>{{ $deposito->agencia->nombre }}</td>
                                            <td>{{ $deposito->fecha }}</td>
                                            <td>{{ $deposito->user->name }}</td>
                                            <td>
                                                @canany(['deposito-authorize'])
                                                    <a class="btn btn-sm btn-outline-primary"
                                                        href="{{ route('depositos.show', ['deposito' => $deposito->id]) }}">Ver</a>
                                                @endcanany
                                                @can('deposito-edit')
                                                    <a class="btn btn-sm btn-outline-info"
                                                        href="{{ route('depositos.edit', ['deposito' => $deposito->id]) }}">Editar</a>
                                                @endcan

                                                @can('deposito-delete')
                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'route' => ['depositos.destroy', $deposito->id],
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
                                {{ $depositos->links() }}

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
            $('input, textarea').on('input', function() {
                this.value = this.value.toUpperCase();
            });
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

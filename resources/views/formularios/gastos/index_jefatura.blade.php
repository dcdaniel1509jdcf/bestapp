@extends('adminlte::page')

@section('title', 'Depósitos')

@section('content_header')
    <h1 class="m-0 text-dark">Gastos de Jefatura</h1>
@stop
@section('content')

    <section class="section">

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped mt-2" id="tableIni">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Concepto</th>
                                            <th scope="col">Agencia/Departamento</th>

                                            <th scope="col">Fecha</th>
                                            <th scope="col">Usuario</th>
                                            <th scope="col">Estado</th>
                                            <th scope="col">Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @isset($gastos)


                                        @foreach ($gastos as $gasto)
                                            <tr>
                                                <th scope="row">{{ $gasto->id }}</th>
                                                <td>{{ $gasto->concepto }}</td>
                                                <td>{{ $gasto->agencia ? $gasto->agencia : 'No disponible' }}</td>
                                                <td>{{ $gasto->created_at->format('Y-m-d') }}</td>
                                                <td>{{ $gasto->user->name }}</td>
                                                <td>
                                                    @if ($gasto->estado == '1')
                                                        <span class="badge badge-info">En Espera</span>
                                                    @elseif ($gasto->estado == '2')
                                                        <span class="badge badge-success">Aprobado Cargar Documentos</span>
                                                    @elseif ($gasto->estado == '3')
                                                        <span class="badge badge-danger">Solicitud Negada</span>
                                                    @elseif ($gasto->estado == '4')
                                                        <span class="badge badge-warning">Documentos Cargados</span>
                                                    @elseif ($gasto->estado == '5')
                                                        <span class="badge badge-info">Finalizar Transacción</span>
                                                    @elseif ($gasto->estado == '6')
                                                        <span class="badge badge-warning">Rectificar Información</span>
                                                    @elseif ($gasto->estado == '7')
                                                        <span class="badge badge-info">Gastos Departamentos</span>
                                                    @else
                                                        <span class="badge badge-danger">Estado Desconocido</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @canany(['gasto-authorize'])
                                                        <a class="btn btn-sm btn-outline-primary"
                                                            href="{{ route('gastos.show', ['gasto' => $gasto->id]) }}">Ver</a>
                                                    @endcanany
                                                    @canany(['gasto-edit'])
                                                        <a class="btn btn-sm btn-outline-info"
                                                            href="{{ route('gastos.edit', ['gasto' => $gasto->id]) }}">Editar</a>
                                                    @endcanany
                                                    @canany(['gasto-delete'])
                                                        {!! Form::open([
                                                            'method' => 'DELETE',
                                                            'route' => ['gastos.destroy', $gasto->id],
                                                            'style' => 'display:inline',
                                                            'class' => 'form-eliminar',
                                                        ]) !!}
                                                        {!! Form::submit('Borrar', ['class' => 'btn btn-sm btn-outline-danger']) !!}

                                                        {!! Form::close() !!}
                                                    @endcanany

                                                </td>
                                            </tr>
                                        @endforeach
                                        @endisset

                                    </tbody>
                                </table>
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

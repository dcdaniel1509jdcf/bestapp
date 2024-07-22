@extends('adminlte::page')

@section('title', 'Depósitos')

@section('content_header')
    <h1 class="m-0 text-dark">Gastos</h1>
@stop
@section('content')

    <section class="section">

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <table class="table table-striped mt-2" id="tableIni">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Concepto</th>
                                        <th scope="col">Agencia</th>

                                        <th scope="col">Fecha</th>
                                        <th scope="col">Usuario</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($gastos as $gasto)
                                        <tr>
                                            <th scope="row">{{ $gasto->id }}</th>
                                            <td>{{ $gasto->concepto }}</td>
                                            <td>{{ $gasto->agencia ? $gasto->agencia->nombre : 'No disponible' }}</td>
                                            <td>{{ $gasto->fecha }}</td>
                                            <td>{{ $gasto->user->name }}</td>
                                            <td>
                                                @if ($gasto->estado == 'En Espera')
                                                    <span class="badge badge-info">En Espera</span>
                                                @elseif ($gasto->estado == 'Rechazado')
                                                    <span class="badge badge-danger">Rechazado</span>
                                                @else
                                                    <span class="badge badge-success">{{ $gasto->estado }}</span>
                                                @endif

                                            </td>
                                            <td>
                                                @canany(['gasto-show'])
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


                                </tbody>
                            </table>

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

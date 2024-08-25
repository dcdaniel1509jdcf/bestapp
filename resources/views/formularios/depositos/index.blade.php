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
                            <form action="{{ route('filtrar') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-xs-4 col-md-4 col-sm-4">
                                        <div class="form-group">
                                            <label for="select_filtro">Selecciona un filtro :</label>
                                            <select name="select_filtro" class="form-control" id="select_filtro">
                                                <option value="">Seleccione</option>
                                                <option value="apellidos"
                                                    {{ session('filtros.select_filtro') == 'apellidos' ? 'selected' : '' }}
                                                    }}>
                                                    Cliente</option>
                                                <option value="agencia_id"
                                                    {{ session('filtros.select_filtro') == 'agencia_id' ? 'selected' : '' }}>
                                                    Agencia</option>
												<option value="banco"
                                                    {{ session('filtros.select_filtro') == 'banco' ? 'selected' : '' }}>
                                                    banco</option>
                                                <option value="fecha"
                                                    {{ session('filtros.select_filtro') == 'fecha' ? 'selected' : '' }}>
                                                    Fecha</option>
                                                <option value="origen"
                                                    {{ session('filtros.select_filtro') == 'origen' ? 'selected' : '' }}>
                                                    Origen</option>
                                                <option value="num_documento"
                                                    {{ session('filtros.select_filtro') == 'num_documento' ? 'selected' : '' }}>
                                                    Numero desposito</option>
                                                <option value="tesoreria"
                                                    {{ session('filtros.select_filtro') == 'tesoreria' ? 'selected' : '' }}>
                                                    Estado</option>


                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-md-4 col-sm-4">
                                        <div class="form-group">
                                            <label for="input_filtro">Buscar:</label>
                                            <input type="text" name="input_filtro" class="form-control" id="input_filtro"
                                                value="{{ session('filtros.input_filtro') }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-md btn-success">Filtrar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @can('deposito-create')
                                <a class="btn btn-sm btn-info" href="{{ route('depositos.create') }}">Crear nuevo Depósito</a>
                            @endcan
<br><br>
                            <table class="table table-striped mt-2" id="tableIni">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Cliente</th>
										@role('GESTOR DIFUSIONES')
										<th scope="col">VALOR</th>
                                        <th scope="col">BANCO</th>
										@endrole
										@role('TESORERIA')
										<th scope="col">BANCO</th>
										@endrole
                                        <th scope="col">Agencia</th>

                                        <th scope="col">Fecha</th>
                                        <th scope="col">Usuario</th>
                                        <th scope="col">Origen</th>
                                        <th scope="col">Numero de Deposito</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($depositos as $deposito)
                                        <tr>
                                            <th scope="row">{{ $deposito->id }}</th>
                                            <td>{{ $deposito->apellidos  }}</td>
											@role('GESTOR DIFUSIONES')
											<td>{{ $deposito->val_deposito  }}</td>
                                            <td>{{ $deposito->banco }}</td>
											@endrole
											@role('TESORERIA')
											<td>{{ $deposito->banco }}</td>
											@endrole
                                            <td>{{ $deposito->agencia->nombre }} </td>
                                            <td>{{ $deposito->fecha }}</td>

                                            <td>{{ $deposito->user->name }}</td>
                                            <td>{{ $deposito->origen }}</td>
                                            <td>{{ $deposito->num_documento }}</td>
                                            <td>
                                                @if ($deposito->tesoreria== null)
                                                <span class="badge badge-success">En Proceso</span>
                                                @elseif ($deposito->tesoreria== 'NEGADO')
                                                <span class="badge badge-danger">Negado</span>
                                                @else
                                                <span class="badge badge-info">{{$deposito->tesoreria}}</span>
                                                @endif
<p style="font-size: 10px">{{$deposito->baja}}</p>
                                                </td>
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

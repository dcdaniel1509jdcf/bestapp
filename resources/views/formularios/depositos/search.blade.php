@extends('adminlte::page')

@section('title', 'Depósito')

@section('css')
    <style>
        .custom-file-input~.custom-file-label::after {
            content: "Buscar";
        }
    </style>
@stop
@section('content_header')
    <h1 class="m-0 text-dark text-center">Buscar Depósitos</h1>
@stop

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-dark alert-dismissible fade show" role="alert">
                                    <strong>!Revise los campos!</strong><br>
                                    @foreach ($errors->all() as $error)
                                        <span class="badge badge-danger">{{ $error }}</span>
                                    @endforeach
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            {!! Form::open(['route' => 'depositos.search', 'method' => 'get']) !!}
                            @csrf

                            <div class="row">
                                <div class="col-xs-12 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Apellidos y Nombres del cliente:</label>
                                        {!! Form::text('apellidos', null, ['class' => 'form-control', 'id' => 'apellidos']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Numero de Deposito:</label>
                                        {!! Form::text('num_documento', null, ['class' => 'form-control', 'id' => 'num_documento']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-md-12 col-sm-12">
                                    {!! Form::submit('Buscar', ['class' => 'btn btn-success']) !!}
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-body">
                            @if ($resultados)
                                <div class="row mt-4">
                                    <div class="col-xs-12 col-md-12 col-sm-12">
                                        <h3 class="h5">Resultados de la búsqueda:</h3>

                                        <table class="table table-striped table-sm table-responsive table-hover"
                                            id="tableIni">
                                            <thead class="thead-dark">
                                                <tr class="text-center">
                                                    <th scope="col" class="p-1">Cliente</th>
                                                    @role('GESTOR DIFUSIONES')
                                                        <th scope="col" class="p-1">Valor</th>
                                                        <th scope="col" class="p-1">Banco</th>
                                                    @endrole
                                                    @role('TESORERIA')
                                                        <th scope="col" class="p-1">Banco</th>
                                                    @endrole
                                                    <th scope="col" class="p-1">Agencia</th>
                                                    <th scope="col" class="p-1">Fecha</th>
                                                    <th scope="col" class="p-1">Usuario</th>
                                                    <th scope="col" class="p-1">Origen</th>
                                                    <th scope="col" class="p-1">Nro. de Depósito</th>
                                                    <th scope="col" class="p-1">Estado</th>
                                                    <th scope="col" class="p-1">Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($resultados as $deposito)
                                                    <tr class="text-center">
                                                        <td class="p-1">{{ $deposito->apellidos }}</td>
                                                        @role('GESTOR DIFUSIONES')
                                                            <td class="p-1">{{ $deposito->val_deposito }}</td>
                                                            <td class="p-1">{{ $deposito->banco }}</td>
                                                        @endrole
                                                        @role('TESORERIA')
                                                            <td class="p-1">{{ $deposito->banco }}</td>
                                                        @endrole
                                                        <td class="p-1">{{ $deposito->agencia->nombre }}</td>
                                                        <td class="p-1">{{ $deposito->fecha }}</td>
                                                        <td class="p-1">{{ $deposito->user->name }}</td>
                                                        <td class="p-1">{{ $deposito->origen }}</td>
                                                        <td class="p-1">{{ $deposito->num_documento }}</td>
                                                        <td class="p-1">
                                                            @if ($deposito->tesoreria == null)
                                                                <span class="badge badge-success">En Proceso</span>
                                                            @elseif ($deposito->tesoreria == 'NEGADO')
                                                                <span class="badge badge-danger">Negado</span>
                                                            @else
                                                                <span
                                                                    class="badge badge-info">{{ $deposito->tesoreria }}</span>
                                                            @endif
                                                            <p style="font-size: 8px">{{ $deposito->baja }}</p>
                                                        </td>
                                                        <td class="p-1">
                                                            <a class="btn btn-sm btn-outline-info"
                                                                href="{{ route('depositos.edit.adm', ['deposito' => $deposito->id]) }}">Editar</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @else
                                <div class="row ">
                                    <div class="col-xs-12 col-md-12 col-sm-12">
                                        <h3 class="h5">Sin Resultados de la búsqueda </h3>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('js')

@stop

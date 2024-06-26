@extends('adminlte::page')

@section('title', 'Depósitos')

@section('content_header')
    <h1 class="m-0 text-dark text-center">Depósito</h1>
@stop
@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-dark alert-dismissible fade show" role="alert">
                                    <strong>!Revise los campos!</strong>
                                    @foreach ($errors->all() as $error)
                                        <span class="badge badge-danger">{{ $error }}</span>
                                    @endforeach
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            {!! Form::model($deposito, [
                                'route' => ['depositos.autorizacion', $deposito->id],
                                'method' => 'PATCH',
                            ]) !!}
                            <div class="row">
                                <div class="col-xs-4 col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label for="name">Agencia:</label>
                                        {!! Form::label('agencia', $deposito->agencia->nombre, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-4 col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label for="name">Origen:</label>
                                        {!! Form::label('origen', $deposito->origen, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-4 col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label for="name">Fecha del comprobante:</label>
                                        {!! Form::label('fecha', $deposito->fecha, ['class' => 'form-control']) !!}

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Apellidos y Nombres:</label>

                                        {!! Form::label('apellidos', $deposito->apellidos, ['class' => 'form-control']) !!}

                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="name">Numero de Deposito:</label>
                                        {!! Form::label('num_documento', $deposito->num_documento, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="name">Valor del deposito o transferencia:</label>
                                        {!! Form::label('val_deposito', $deposito->val_deposito, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="name">Banco:</label>
                                        {!! Form::label('banco', $deposito->banco, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="name">Numero del factura:</label>
                                        {!! Form::label('num_credito', $deposito->num_credito, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="comprobante">Comprobante</label>
                                        @if ($deposito->comprobante)
                                            <p>Archivo actual: <button type="button" class="btn btn-sm btn-link" data-toggle="modal" data-target="#staticBackdrop">
                                                Ver Documento
                                              </button>
                                              <a href="{{ Storage::url($deposito->comprobante) }}" class="btn btn-sm btn-link"
                                                    target="_blank">abrir</a></p>
                                                    @include('formularios.depositos.partial.modal')
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4 col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label for="tesoreria">Tesoreria:</label>
                                        {!! Form::label('tesoreria', $deposito->tesoreria, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-8 col-md-8 col-sm-8">
                                    <div class="form-group">
                                        <label for="name">Novedades:</label>
                                        {!! Form::label('novedad', $deposito->novedad, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="name">Cajas:</label>
                                        {!! Form::label('cajas', $deposito->cajas, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                @can('deposito-authorize')
                                @role('GESTOR DIFUSIONES')
                                    <div class="col-xs-4 col-md-4 col-sm-4">
                                        <div class="form-group">
                                            <label for="baja">Dado de baja:</label>
                                            {!! Form::select('baja', ['DADO DE BAJA' => 'DADO DE BAJA'], null, [
                                                'class' => 'form-control',
                                                'placeholder' => 'SELECCIONE',
                                            ]) !!}
                                        </div>
                                    </div>
                                @endrole
                                @endcan

                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-md-12 col-sm-12">
                                    @role('GESTOR DIFUSIONES') {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!} @endrole
                                    <a href="{{ route('depositos.index') }}" class="btn btn-secondary">Atras</a>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('js')
    <script>
        // Mostrar el nombre del archivo seleccionado
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = document.getElementById("file").files[0].name;
            var nextSibling = e.target.nextElementSibling
            nextSibling.innerText = fileName
        });
    </script>
@stop

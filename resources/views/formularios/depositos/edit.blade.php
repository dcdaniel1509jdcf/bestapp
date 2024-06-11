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
                                'route' => ['depositos.update', $deposito->id],
                                'method' => 'PATCH',
                                'enctype' => 'multipart/form-data',
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

                                        {!! Form::select('origen', ['COBRO' => 'COBRO', 'VENTA' => 'VENTA'], null, [
                                            'class' => 'form-control',
                                            'placeholder' => 'SELECCIONE',
                                        ]) !!}

                                    </div>
                                </div>
                                <div class="col-xs-4 col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label for="name">Fecha del comprobante:</label>
                                        {!! Form::date('fecha', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Apellidos y Nombres:</label>
                                        {!! Form::text('apellidos', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="name">Numero de Deposito:</label>
                                        {!! Form::text('num_documento', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="name">Valor del deposito o transferencia:</label>
                                        {!! Form::text('val_deposito', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="name">Banco:</label>
                                        {!! Form::text('banco', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="name">Numero del factura:</label>
                                        {!! Form::text('num_credito', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="comprobante">Cargar Comprobante</label>
                                        <div class="custom-file">
                                            {!! Form::file('comprobante', ['class' => 'custom-file-input', 'id' => 'file']) !!}
                                            {!! Form::label('file', 'Elegir archivo', ['class' => 'custom-file-label']) !!}
                                        </div>
                                        @if ($deposito->comprobante)
                                            <p>Archivo actual: <a href="{{ Storage::url($deposito->comprobante) }}"
                                                    target="_blank">Ver Comprobante</a></p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @can('deposito-show')
                            <hr>
                            <div class="row">
                                <div class="col-xs-4 col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label for="tesoreria">Tesoreria:</label>

                                        {!! Form::select('tesoreria', ['CONFIRMADO' => 'CONFIRMADO', 'NEGADO' => 'NEGADO'], null, [
                                            'class' => 'form-control',
                                            'placeholder' => 'SELECCIONE',
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-8 col-md-8 col-sm-8">
                                    <div class="form-group">
                                        <label for="name">Novedades:</label>
                                        {!! Form::text('novedad', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="name">Cajas:</label>
                                        {!! Form::text('cajas', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                            </div>
                            @endcan
                            <div class="row">
                                <div class="col-xs-12 col-md-12 col-sm-12">
                                    {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
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

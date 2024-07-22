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



                            <div class="row">
                                <div class="col-xs-4 col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label for="agencia_id">Agencia:</label>
                                        {!! Form::text('agencia_id', $gasto->agencia ? $gasto->agencia->nombre : 'No disponible', [
                                            'class' => 'form-control',
                                            'readonly',
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-xs-4 col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label for="fecha">Fecha:</label>
                                        {!! Form::text('fecha', $gasto->fecha, ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-4 col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label for="concepto">Concepto:</label>
                                        {!! Form::text('concepto', ucfirst($gasto->concepto), ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                            </div>

                            @if ($gasto->concepto === 'movilizacion')
                                <div id="movilizacion">
                                    <div class="row">
                                        <div class="col-xs-6 col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="tipo_movilizacion">Tipo de Movilización:</label>
                                                {!! Form::text('tipo_movilizacion', $gasto->tipo_movilizacion, ['class' => 'form-control', 'readonly']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="destino">Destino:</label>
                                                {!! Form::text('destino', $gasto->destino, ['class' => 'form-control', 'readonly']) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="asignado_a">Asignado a:</label>
                                                {!! Form::text('asignado_a', $gasto->asignado_a, ['class' => 'form-control', 'readonly']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="valor">Valor:</label>
                                        {!! Form::text('valor', $gasto->valor, ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="detalle">Detalle:</label>
                                        {!! Form::textarea('detalle', $gasto->detalle, ['class' => 'form-control', 'rows' => '2', 'readonly']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="numero_factura">Número de Factura:</label>
                                        {!! Form::text('numero_factura', $gasto->numero_factura, ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="file">Comprobante:</label>
                                        @if ($gasto->comprobante)
                                            <a href="{{ asset('storage/' . $gasto->comprobante) }}" target="_blank">Ver
                                                Comprobante</a>
                                        @else
                                            No disponible
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="estado">Estado:</label>
                                        {!! Form::text('estado', $gasto->estado, ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="estado">Novedad:</label>
                                        {!! Form::text('novedad', $gasto->novedad, ['class' => 'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-xs-6 col-md-6 col-sm-6">
                                    <a href="{{ route('gastos.index') }}" class="btn btn-block btn-secondary">Volver a la
                                        lista</a>
                                </div>
                            </div>




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

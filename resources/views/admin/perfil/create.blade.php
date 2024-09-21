@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <h1 class="m-0 text-dark text-center">{{ isset($profile) ? 'Editar Perfil' : 'Crear Perfil' }}</h1>
@stop

@section('content')

    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="container">

                            {!! Form::model($profile, ['route' => ['user.profiles.upsert', $userId], 'method' => 'POST']) !!}

                            {!! Form::hidden('user_id', $userId) !!}
                            <div class="form-group">
                                {!! Form::label('cedula', 'Número de Cédula') !!}
                                {!! Form::text('cedula', null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('banco', 'Banco') !!}
                                {!! Form::select('banco', [
                                    '10' => 'Banco Pichincha',
                                    '17' => 'Banco Guayaquil',
                                    '30' => 'Banco Pacifico',
                                    '32' => 'Banco Internacional',
                                    '36' => 'Banco Produbanco',
                                    '42' => 'Banco General Rumiñahui',
                                    '60' => 'Banco Procredit'
                                ], null, ['class' => 'form-control', 'placeholder' => 'Seleccione un banco', 'required']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('numero_cuenta', 'Número de Cuenta') !!}
                                {!! Form::text('numero_cuenta', null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('departamento', 'Departamento') !!}
                                {!! Form::select('departamento', [
                                    'LEGAL' => 'LEGAL',
                                    'CONTABILIDAD' => 'CONTABILIDAD',
                                    'ASISTENTE CONTABLE' => 'ASISTENTE CONTABLE',
                                    'CREDITO' => 'CREDITO',
                                    'COBRANZAS' => 'COBRANZAS',
                                    'INVENTARIO' => 'INVENTARIO',
                                    'LOGISTICA' => 'LOGISTICA'
                                ], null, ['class' => 'form-control', 'placeholder' => 'Seleccione un departamento', 'required']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::submit('Guardar', ['class' => 'btn btn-block btn-primary']) !!}
                            </div>

                            {!! Form::close() !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

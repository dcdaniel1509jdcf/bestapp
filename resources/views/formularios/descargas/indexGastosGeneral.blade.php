
@extends('adminlte::page')

@section('title', 'Depositos')

@section('content_header')
    <h1 class="m-0 text-dark text-center">Descarga General de Gastos</h1>
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                {!! Form::open(['route' => 'gastos.general.download', 'method' => 'POST']) !!}
                @csrf

                <div class="row justify-content-center">
                    <div class="col-xs-4 col-md-4 col-sm-4">
                        <div class="form-group">
                            <label for="dateIni">Fecha Inicio:</label>
                            {{ Form::text('dateIni', null, ['class' => 'form-control flatpickrIn ','required']) }}

                        </div>
                    </div>
                    <div class="col-xs-4 col-md-4 col-sm-4">
                        <div class="form-group">
                            <label for="dateFin">Fecha Fin:</label>
                            {{ Form::text('dateFin', null, ['class' => 'form-control flatpickrFn','required']) }}
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-xs-12 col-md-6 col-sm-6">
                        <div class="mb-3">
                            <label for="concepto" class="form-label">Seleccione el Concepto a descargar</label>
                            <select class="form-control" id="concepto" name="concepto[]" multiple required style="height: 120px;">
                                <option value="gastos_varios">Gastos Varios</option>
                                <option value="suministros">Suministros</option>
                                <option value="movilizacion">Movilización</option>
                                <option value="mantenimiento">Mantenimiento</option>
                                <option value="tramites_entidades">Trámites Entidades</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-12 col-sm-12 text-center">
                        {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                        <a href="{{ route('depositos.index') }}" class="btn btn-secondary">Atras</a>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@stop

@section('js')
    <script>
            flatpickr(".flatpickrIn", {
                altInput: true,
                enableTime: true,
                altFormat: "F j, Y H:i",
                dateFormat: "Y-m-d H:i",
                maxTime: "00:01",
                maxDate: "today",
            });
            flatpickr(".flatpickrFn", {
                altInput: true,
                enableTime: true,
                altFormat: "F j, Y H:i",
                minTime: "23:59",
                dateFormat: "Y-m-d H:i",
                maxDate: "today",
            });
    </script>
@endsection

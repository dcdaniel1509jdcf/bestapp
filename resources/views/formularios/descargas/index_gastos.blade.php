
@extends('adminlte::page')

@section('title', 'Depositos')

@section('content_header')
    <h1 class="m-0 text-dark">Descargar</h1>
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                {!! Form::open(['route' => 'gastos.download', 'method' => 'POST']) !!}
                @csrf

                <div class="row">
                    <div class="col-xs-4 col-md-4 col-sm-4">
                        <div class="form-group">
                            <label for="dateIni">Fecha Inicio:</label>
                            {{ Form::text('dateIni', null, ['class' => 'form-control flatpickrIn ']) }}

                        </div>
                    </div>
                    <div class="col-xs-4 col-md-4 col-sm-4">
                        <div class="form-group">
                            <label for="dateFin">Fecha Fin:</label>
                            {{ Form::text('dateFin', null, ['class' => 'form-control flatpickrFn']) }}
                        </div>
                    </div>
                </div>


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

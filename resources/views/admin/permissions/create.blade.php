@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
    <h1 class="m-0 text-dark">Crear Permiso</h1>
@stop

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
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



                            {!! Form::open(['route' => 'permissions.store', 'method' => 'POST']) !!}

                            <div class="row">
                                <div class="col-xs-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Nombre:</label>
                                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-xs-12 col-md-12 col-sm-12">

                                    {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                                    <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Atras</a>

                                </div>
                            </div>
                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

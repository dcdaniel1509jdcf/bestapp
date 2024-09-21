@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <h1 class="m-0 text-dark text-center">Editar usuario</h1>
@stop

@section('content')
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


                        {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'PATCH']) !!}



                        <div class="row">
                            <div class="col-xs-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Nombre:</label>
                                    {!! Form::text('name', null, ['class' => 'form-control mayuscula']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Email:</label>
                                    {!! Form::email('email', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="password">Password:</label>
                                    {!! Form::password('password', ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="confirm-password">Password:</label>
                                    {!! Form::password('confirm-password', ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="agencia_id">Agencia:</label>
                                    {!! Form::select('agencia_id', $agencias, null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Role:</label>

                                    {!! Form::select('roles[]', $roles, $userRole, ['class' => 'form-control']) !!}

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="active">Usuario Activo?:</label>
                                    {!! Form::select('active', [1 => 'Activo', 0 => 'Inactivo'], $user->active, ['class' => 'form-control']) !!}

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-12 col-sm-12">

                                {!! Form::submit('Guardar', ['class' => 'btn btn-block btn-success']) !!}

                            </div>
                        </div>
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

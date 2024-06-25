@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content')
    <div class="section-body">
        <div class="row py-3 justify-content-center">
            <div class="col-lg-8">
                <div class="card card-outline card-primary">


                    <div class="card-header ">
                        <h3 class="card-title float-none text-center">
                            Reset Password </h3>
                    </div>


                    <div class="card-body login-card-body ">
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


                        {!! Form::model($user, ['route' => ['change.password.user.post'], 'method' => 'POST']) !!}



                        <div class="row">
                            <div class="col-xs-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Nombre:</label>
                                    {!! Form::label('name', $user->name, ['class' => 'form-control mayuscula']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Email:</label>
                                    {!! Form::label('email', $user->email, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="password">Contraseña Actual:</label>
                                    {!! Form::password('current_password', ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="password">Contraseña:</label>
                                    {!! Form::password('password', ['class' => 'form-control']) !!}
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="confirm-password">Confirmar contraseña:</label>
                                    {!! Form::password('confirm-password', ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-xs-6 col-md-6 col-sm-6">

                                {!! Form::submit('Actualizar', ['class' => 'btn btn-block btn-success']) !!}

                            </div>
                        </div>
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

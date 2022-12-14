@extends('layouts.app')

@section('content')
<div class="row" style="margin-top:10px;">
    <div class="col s12 m12 ">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('panel')}}">Panel</a></li>
            <li class="breadcrumb-item"><a href="{{route('config')}}">Configuración</a></li>
            <li class="breadcrumb-item"><a href="#">Detalles</a></li>
        </ul>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="margin-top:20px;">
                <div class="card-header">
                    <span class="card-title">Registrar Usuario</span>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row" style="margin-top:20px;">
                            <div class="input-field col m8 offset-m1">
                                <i class="icon-account_circle prefix"></i>
                                <label for="name" class="col-form-label text-md-right">Nombre</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">

                            <div class=" input-field col m8 offset-m1">
                                <i class="icon-markunread prefix"></i>
                                <label for="email" class="col-form-label text-md-right">Correo</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col m8 offset-m1">
                                <i class="icon-lock_outline prefix"></i>
                                <label for="password" class="col-form-label text-md-right">Contraseña</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col m8 offset-m1">
                                <i class="icon-lock_outline prefix"></i>
                                <label for="password-confirm" class="col-form-label text-md-right">Confirmar Contraseña</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12 m1 offset-m9" style="padding:20px;">
                                <button type="submit" class="btn" style="background-color:#1860ab">
                                    Registrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
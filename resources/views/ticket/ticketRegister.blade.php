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
        <div class="col-md-6">
            <div class="card" style="margin-top:20px;">
                <div class="card-header">
                    <span class="card-title">Registrar Oficinas</span>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{route('save.ticket')}} ">
                        @csrf

                        <div class="row" style="margin-top:20px;">                         
                                <div class="input-field col m8">
                                    <i class="icon-looks_one prefix"></i> 
                                    <label for="number_ticket" class="col-form-label text-md-right">Número de Oficina</label>
                                    <input id="number_ticket" type="number" class="form-control @error('number_ticket') is-invalid @enderror" name="number_ticket" value="{{ old('number_ticket') }}" required autocomplete="number_ticket" autofocus>
    
                                    @error('number_ticket')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        <div class="row" style="margin-top:20px;">                         
                            <div class="input-field col m8">
                                <i class="icon-looks_one prefix"></i> 
                                <label for="name_ticket" class="col-form-label text-md-right">Nombre Oficina</label>
                                <input id="name_ticket" type="text" class="form-control @error('name_ticket') is-invalid @enderror" name="name_ticket" value="{{ old('name') }}" required autocomplete="name_ticket" autofocus>

                                @error('name_ticket')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">                        
                            <div class=" input-field col m8">
                                <i class="icon-picture_in_picture prefix"></i>  
                                <label for="description_ticket" class="col-form-label text-md-right">Descripción</label>
                                <input id="description_ticket" type="text" class="form-control @error('description_ticket') is-invalid @enderror" name="description_ticket" value="{{ old('description_ticket') }}" autocomplete="description_ticket">

                                @error('description_ticket')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col s1" style="padding:10px;">
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

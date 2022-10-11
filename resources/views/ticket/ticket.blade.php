@extends('layouts.app')
           
@section('content')

<script>
    // const url = "http://localhost/sysq/public/";
    const url = "http://192.168.3.128:8000/";
        
    function redireccionar(){
        setTimeout("location.href='http://192.168.3.128:8000/sysq/public/'", 10000);
    }

</script>

<main >
    <body onload="">
        <div class="container-fluid" style="padding: 20px">
            <div class="row" style="margin-top:20px;">
                <div class="col s12 m12 l12"  id="no_imprimir">
                   <div class="alert alert-info" role="alert">
                       Recuerde el número, la pagina sera actualizada en breve
                    </div>
                    <a class="btn btn-primary" href="{{ Route ('index')  }}" role="button">NUEVO TICKET</a>
                </div>
            </div> 
            
            <div class="row">
                <div class="col s12 m8 offset-m2 l6 offset-l3">
                    <div class="card z-depth-2">
                        <div class="card-header center-align" style="background-color:#1860ab">
                            <h4 class="font-audiowide white-text">UGEL HUANUCO</h4>
                            <h6 class="white-text">{{ $turn_pivot->created_at}}</h6>
                        </div>
                        @foreach($turn_pivot->tickets as $oficina)
                        <div class="card-content center-align">
                            <h4>{{ $turn_pivot->clients->ci_client }}</h4>
                            <span class="ticket-number">{{$turn_pivot->random_code}}</span>
                            
                            <h4>{{$oficina->name_ticket}}</h4>
                            <h6>({{$oficina->description_ticket}})</h6>
                            
                            <span>({{$turn_pivot->turn_type}})</span>
                        </div>
                        @endforeach
                        <div class="card-footer center-align" style="background-color:#1860ab" id="no_imprimir">
                            <span class="white-text">Sistema para Colas</span>
                            <a href="javascript:window.print()"> Imprimir</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        @include('includes.buttonFloating')
    
        <style>
            .ticket-number {
                font-size: 96px;
                font-weight: 900;
            }
            @media print{
                #nav-mobile,
                #no_imprimir {
                    display: none;
                }
            }
        </style>
        
    </body>

</main>
    
@endsection
    
@extends('layouts.app')

<body class="grey lighten-3 font-nunito">

    @section('content')
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="row">
                    @include('includes.messageInfo')
                    <div class="col s12 center-align">
                        <h4>Seleccione la oficina para la atención. {{$response}}</h4>
                    </div>
                </div>

                <div class="row">

                    @foreach($tickets as $ticket)
                        @if($ticket->status_ticket == 'Activa' )
                        <div class="col s12 m6 animated bounceIn">
                            <a href="{{route('ticket.turn',['ci'=>$ci, 'id'=>$ticket->id])}}" class="waves-effect btn-app white black-text">
                                <i class="icon-subtitles black-text" style="font-size:50px;"></i>
                                <span style="font-size:20px;">{{$ticket->name_ticket}}</span><br>
                            </a>

                            <div class="row" style="margin-top:20px;">
                                <div class="col s12 m12">
                                    <span>
                                        {{"( ".$ticket->description_ticket. " )"}}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endif

                    @endforeach
                </div>
            </div>
            @include('includes.buttonFloating')
        </div>
    </main>
    @endsection

</body>

</html>
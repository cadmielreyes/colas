@extends('layouts.app')

@section('content')


<main>
    <script src="{{ asset('js/data/turn.js') }}"></script>

    <div class="container-fluid" style="margin-top:20px;">
        <div class="row left-align alert alert-info">
            <div class="col s4 m3 center-align">
                <i class="fas fa-exclamation-circle  " style="margin-left:10px;font-size: 70px; margin-top: .5rem;"></i>
            </div>
            <div class="col s8 m9 ">
                <span style="font-size: 40px; font-weight: bolder;">Atención</span><br>
                <span id="info">Realizar la llamada por ticket de cliente para cada servicio.</span>
            </div>
        </div>
        <div class="divider"></div>
        @if ($ticket)
        <div class="row">
            <div class="col s12 m3">
                <div class="row">
                    <div class="col s12 m12 center-align" style="background-color:#1860ab;border: solid 1px #cccccc">
                        <h5 class="white-text">Oficina</h5>
                        <span class="white-text" style="font-size: 40px;">{{ $ticket->name_ticket }}</span><br>
                        <a href="#taquilla" class="btn btn-flat white-text modal-trigger">Cambiar</a>
                    </div>
                </div>

                <div class="row" style="margin-top:50px;">
                    <div class="col s12 m12 animated bounceIn" id="blockResetTurnos">
                        <input type="hidden" value="{{ $ticket->id }}" id="idTicketReset">
                        <input type="hidden" value="{{ $ticket->number_ticket }}" id="numberTicket">
                        <input type="hidden" value="{{ $user->ticket_id }}" id="id_ticket" class="id_ticket">
                        <button type="button" id="resetTaquilla" class="waves-effect btn-app white black-text" style="border: none; " disabled="true">
                            <i class="fas fa-book-reader red-text"></i>
                            <span style="font-size: 16px;">Cancelar Turnos Oficina</span>
                        </button>
                    </div>
                </div>

            </div>

            <div class="col s12 m9">

                <div class="row">
                    <div class="col s12" style="margin-bottom:40px;margin-top:25px;">
                        <table>
                            <tbody>
                                <tr>
                                    <td>Numero Oficina</td>
                                    <td>{{ $ticket->number_ticket }}</td>
                                </tr>
                                <tr>
                                    <td id="nameClient">Servicio</td>
                                    <td id="ciClient">{{ $ticket->name_ticket }}</td>
                                </tr>
                                <tr>
                                    <td id="nameTurn">Descripción</td>
                                    <td id="numberTurn">{{ $ticket->description_ticket }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @if($ticket->id == $user->ticket_id)
                    <div class="col s12 m6 animated bounceIn" id="block_llamar">
                        @if ($first)
                        <input type="hidden" value="{{ $first->id }}" id="idTurn" class="idTurn">
                        <input type="hidden" value="{{ $first->random_code }}" id="code" class="code">
                        <input type="hidden" value="{{ $first->clients->ci_client }}" id="ci" class="ci">
                        @else
                        <input type="hidden" value="0" id="idTurn1" class="idTurn1">
                        <input type="hidden" value="0" id="code1" class="code">
                        @endif
                        <button type="button" id="llamar" style="border:none;" class="waves-effect btn-app white black-text">
                            <i class="fas fa-bullhorn" style="color:#ffb300"></i>
                            <span style="font-size: 16px;" id="text_llamar">Llamar</span>
                        </button>
                    </div>
                    <div class="col s12 m6 animated bounceIn" id="block_derivar">
                        <button type="button" id="derivar" style="border:none;" class="waves-effect btn-app white black-text ">
                            <i class="fas fa-arrow-alt-circle-right" style="color:#1860ab"></i>
                            <span style="font-size: 16px;">Derivar</span>
                        </button>
                    </div>
                    <div class="col s12 m4 animated bounceIn" id="block_iniciar">
                        <button type="button" id="iniciar" style="border:none;" class="waves-effect btn-app white black-text ">
                            <i class="fas fa-play" style="color:#1860ab"></i>
                            <span style="font-size: 16px;">Iniciar Atención</span>
                        </button>
                    </div>
                    <div class="col s12 m4 animated bounceIn" id="block_cancelar">
                        <button type="button" id="cancelar" style="border:none;" class="waves-effect btn-app white black-text">
                            <i class="fas fa-user-times red-text"></i>
                            <span style="font-size: 16px;">No se presentó</span>
                        </button>
                    </div>
                    <div class="col s12 m4 animated bounceIn" id="block_finalizar">
                        <button type="button" id="finalizar" style="border:none;" class="waves-effect btn-app white black-text">
                            <i class="fas fa-times-circle green-text"></i>
                            <span style="font-size: 16px;">Finalizar</span>
                        </button>
                    </div>
                    @endif
                </div>
            </div>


            <div class="row">
                <div class="col s12">
                    <div class="collection with-header">
                        <table class="table table-bordered">
                            <tr>
                                <td width="50%">
                                    <div class="collection-header">
                                        <h5>Mi Fila</h5>
                                    </div>
                                </td>
                                <td width="50%">
                                    <div class="collection-header">
                                        <h5>Fecha y hora de registro</h5>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <table class="table table-bordered" style="text-align: center;">
                            <tbody id="actualizar_turns"> 
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col s12 m3 center-align" style="background-color:#1860ab" style="border: solid 1px #cccccc">
                <h6 class="white-text">Oficina</h6>
                <span class="white-text" style="font-size: 70px;">0</span><br>
                <a href="#taquilla" class="btn btn-flat white-text modal-trigger">Cambiar</a>
            </div>
            <div class="col s12 m9" style="margin-bottom:200px;margin-top:25px;">
                <table>
                    <tbody>
                        <tr>
                            <td>Seleccione una oficina o registre en el menu de configuración</td>
                            <td>0000</td>
                        </tr>
                        <tr>
                            <td>0000</td>
                            <td>0000</td>
                        </tr>
                        <tr>
                            <td>0000</td>
                            <td>0000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>

    <!-- Modal Structure -->
    <div id="taquilla" class="modal bottom-sheet">
        <div class="modal-content">
            <div class="row">
                <div class="centered col s12 m12">
                    <h5 style="margin-left:15px;"> Oficinas </h5>
                </div>
            </div>
        </div>

        @if ($ticketAll)
        <div class="row">
            <div class="col s12 m12">
                <ul class="collection">
                    @foreach ($ticketAll as $tickets)
                    <li class="collection-item avatar">
                        <i class="icon-local_convenience_store circle orange"></i>
                        <span class="title">{{ $tickets->number_ticket }}</span>
                        <p>{{ $tickets->name_ticket }} <br>
                            {{ $tickets->description_ticket }}
                        </p>
                        <a href="{{ route('panel.select', ['id' => $tickets->id]) }}" class="btn secondary-content red">Seleccionar</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col s12 m12">
                <span class="black-text">No hay Oficinas</span>
            </div>
        </div>
        @endif

        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">cerrar</a>
        </div>
    </div>
    <!-- Modal va en una seccion aparte, solo que aqui esta la prueba -->
    <!-- Modal notificacion -->
    <div id="notification" class="modal fade show" tabindex="-1" role="dialog" style="display: block;" data-keyboard="false" data-backdrop="static">
        <div class="modal-content center-align" style="color:#1860ab">
            <div class="row">
                <div class="col s12 center-align">
                    <span style="font-size: 80px; font-weight: 900" id="infoCode">ATENCION!!!</span>
                </div>
                <div class="col s12 center-align">
                    <span style="font-size:50px;">Tiene usuarios por atender</span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a data-controls-modal="your_div_id" data-backdrop="static" data-keyboard="false" type="button" href="{{route('marcarLeido')}}" class="btn btn-primary">ENTENDIDO</a>
        </div>
    </div>

    <!-- Modal derivacion -->
    <div id="derivacion" class="modal fade show" tabindex="-1" role="dialog" style="display: block;" data-keyboard="false" data-backdrop="static">
        <div class="modal-content center-align" style="color:#1860ab">
            <form method="POST" action="{{route('derivar')}} ">
                @csrf
                <input type="hidden" name="id_turn" id="id_turn" value="">
                <div class="row">
                    <div class="col s12 center-align">
                        <span style="font-size: 50px; font-weight: 900">Seleccione oficina</span>
                    </div>
                    <div class="input-field col m10 offset-m1 ">
                        <select class="browser-default custom-select" id="opciones" name="oficina">

                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-backdrop="static" data-keyboard="false" class="btn btn-primary">DERIVAR</button>
                </div>
            </form>
        </div>

    </div>


    <audio class="audio">
        <source src="{{ asset('img/turn.mp3') }}" type="audio/ogg">
    </audio>
    <audio class="audio_notification">
        <source src="{{ asset('img/notification.mp3') }}" type="audio/ogg">
    </audio>
    <audio class="iphone-notificacion">
        <source src="{{ asset('img/iphone-notificacion.mp3') }}" type="audio/ogg">
    </audio>


</main>

@endsection
<script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('js/materialize.min.js') }}"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/aos.js') }}"></script>
<script src="{{ asset('js/initialize.js') }}"></script>
<script src="{{ asset('js/owner.js') }}"></script>
<script src="{{ asset('js/data/turn.js') }}"></script>
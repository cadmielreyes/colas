@extends('layouts.app')

<body class="grey lighten-3 font-nunito">

    @section('content')
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="row">
                    @include('includes.messageInfo')
                    <div class="col s12 center-align">
                        <h4>Resumen de Atencion por oficina</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m3 center-align" style="background-color:#1860ab;border: solid 1px #cccccc">
                        <h5 class="white-text">Oficina</h5>
                        <span class="white-text" style="font-size: 40px;">{{$ticket->name_ticket}}</span><br>
                        <a href="#" class="btn btn-flat white-text modal-trigger">Cambiar</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m9">
                        <h5>Resumen de fecha actual</h5>
                        <table>
                            <tbody>
                                <tr>
                                    <td>Total atendidos en el día: </td>
                                    <td>{{$atendidos}}</td>
                                </tr>
                                <tr>
                                    <td>Total en Espera: </td>
                                    <td>{{$espera}}</td>
                                </tr>
                                <tr>
                                    <td>En Atención: </td>
                                    <td>{{$atencion}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m9">
                        <h5>Resumen por dia seleccionado</h5>
                        <table>
                            <tbody>
                                <tr>
                                    <td class="center-align">Seleccione fecha <br>
                                    --/--/----
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total atendidos</td>
                                    <td>--</td>
                                </tr>
                                <tr>
                                    <td>Total en Espera: </td>
                                    <td>--</td>
                                </tr>
                                <tr>
                                    <td>En Atención: </td>
                                    <td>--</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @include('includes.buttonFloating')
        </div>
    </main>
    @endsection

</body>

</html>
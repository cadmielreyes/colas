<header>
        <nav class="white container-fluid">
                <div class="nav-wrapper">
                        <a href="{{ route('index')  }}" style="margin-top:0"><img class="logo" src="{{asset('img/sysQ-logo.png')}}" alt=""></a>
                        @auth
                        <ul id="nav-mobile" class="right show-on-med-and-down">

                                <li>
                                        <a href="{{ route('index') }}" class="black-text tooltipped" data-position="left" data-tooltip="Inicio">
                                                <i class="icon-home nav-icons"></i>
                                        </a>
                                </li>
                                <li>
                                        <a href="{{ route('resumen') }}" class="black-text tooltipped" data-position="left" data-tooltip="Resumen">
                                                <i class="icon-border_color nav-icons"></i>
                                        </a>
                                </li>
                                <li>
                                        <a href="{{ route('home') }}" class="black-text tooltipped" data-position="left" data-tooltip="Panel">
                                                <i class="icon-account_circle nav-icons"></i>
                                        </a>
                                </li>
                                <li>
                                        <a href="{{ route('turn')}}" class="black-text tooltipped" data-position="bottom" data-tooltip="Turnos" style="{{ (auth()->user()->tickets->name_ticket) == 'SUPER USUARIO' ? '' : 'pointer-events: none; cursor: default;' }}">
                                                <i class="icon-slow_motion_video nav-icons"></i>
                                        </a>
                                </li>
                                <li>
                                        <a href="{{ route('config')}}" class="black-text tooltipped" data-position="left" data-tooltip="Configuraci??n" style="{{ (auth()->user()->tickets->name_ticket) == 'SUPER USUARIO' ? '' : 'pointer-events: none; cursor: default;' }}">
                                                <i class="icon-settings nav-icons"></i>
                                        </a>
                                </li>

                                <li>
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="black-text tooltipped" data-position="bottom" data-tooltip="Cerrar Sesi??n">
                                                <i class="icon-exit_to_app nav-icons"></i>
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                        </form>
                                </li>
                        </ul>
                        @endauth
                </div>
        </nav>
</header>
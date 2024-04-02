<nav>
    <ul>
        <div class="nav-bar nav-left">
            <li class="nav-title">
                <a href="{{ route('home') }}"><div class="material-symbol">home</div></a>
            </li>
            @auth
                <li>
                    <a href="{{ route('profile.show', Auth::user()->id) }}">
                        <div class="material-symbol">account_circle</div>
                    </a>
                </li>
            @endauth
            <li><a href="{{ route('game.index') }}"><div class="material-symbol">stadia_controller</div></a></li>
            <li>
                <a href="{{ route('profile.index') }}"><div class="material-symbol">data_loss_prevention</div></a>
            </li>
        </div>

        

        <div class="nav-bar nav-right right-align">
            @if (Route::has('login'))
                @auth
                    <li>
                        <form class="logout-big" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <label class="text-vertical-middle" for="link"> {{ Auth::user()->name }} </label>
                            <div class="text-vertical-middle material-symbol">chevron_right</div>
                            <a class="text-vertical-middle link" href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Logout') }}
                            </a>
                        </form>

                        <form class="logout-small" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a class="text-vertical-middle link" href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                <div class="material-symbol">logout</div>
                            </a>
                        </form>
                    </li>
                @else
                    <li><a class="link" href="{{ route('login') }}" >{{ __('Login') }}</a></li>

                    @if (Route::has('register'))
                        <li><a class="link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                    @endif
                @endauth
            @endif
        </div>
    </ul>
</nav>
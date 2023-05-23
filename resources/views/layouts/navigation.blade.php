<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarNav">
            @auth()
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="{{route('profile')}}">Профиль</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{route('users.index')}}">Пользователи</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{route('statements')}}">Statements</a>
                </li>
{{--                <li class="nav-item active">--}}
{{--                    <a class="nav-link" href="{{route('export.index')}}">Экспорт</a>--}}
{{--                </li>--}}
            </ul>
            @endauth
            <div class="col-md-3 text-end">
                @auth
                    <a href="{{route('logout')}}" class="btn btn-dark me-2">Выход</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

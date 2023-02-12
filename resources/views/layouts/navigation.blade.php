<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarNav">
            @auth()
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="{{route('profile')}}">Profile</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{route('users.index')}}">Users</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{route('statements')}}">Statements</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{route('export.index')}}">My exports</a>
                </li>
            </ul>
            @endauth
            <div class="col-md-3 text-end">
                @auth
                    <a href="{{route('logout')}}" class="btn btn-dark me-2">Logout</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

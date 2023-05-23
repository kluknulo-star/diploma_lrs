@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="header text-center" style="margin-top: 30px">Вход</h1>
        <div class="row" style="max-width: 50%; margin: 0 auto; margin-top: 50px">
            <div class="col-12">

                @include('layouts.messages')
                @include('layouts.errors')

                <form method="POST" action="{{route('login')}}">
                    @csrf
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="form2Example1">Почта</label>
                        <input type="email" id="form2Example1" class="form-control" name="email"
                               value="{{old('email')}}">
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="form2Example2">Пароль</label>
                        <input type="password" id="form2Example2" class="form-control" name="password" value=""/>
                    </div>
{{--                    <div class="form-group row">--}}
{{--                        <div class="col-md-6 offset-md-4">--}}
{{--                            <div class="checkbox">--}}
{{--                                <label>--}}
{{--                                    <a href="{{ route('forget.password.get') }}">Reset Password</a>--}}
{{--                                </label>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <!-- Submit button -->
                    <div class="div" style="display: flex; align-items: center;">
                        <button name='user_login' type="submit" class="btn btn-primary btn-block"
                                style="width: 40%; margin: 0 auto">Войти
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

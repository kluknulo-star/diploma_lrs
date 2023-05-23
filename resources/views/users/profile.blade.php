@extends('layouts.app')

@section('content')
    <div class="container">
        @include('layouts.messages')
        @include('layouts.errors')
        <h2 class="mb-3">Профиль: {{Auth::user()->name}}</h2>
        <h4>Токены:</h4>
        @foreach($tokens as $key => $token)
{{--            <label for="myInput{{$key}}">Your token:</label>--}}

        <div class="row mb-2">
            <div class="col-8">
                <input class="form-control" type="text"
                       value="{{$token->token}}" id="myInput{{$key}}">
            </div>
            <div class="col-auto">
                @if($token->expiration_date < now())
                    <form method="post" action="{{route('delete.token', $token->token_id)}}">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-danger">X</button>
                    </form>
                @else
                    <button onclick="myFunction({{$key}})" class="btn btn-ligth">Скопировать</button>

                    @if(now() < $token->expiration_date)
                        Осталось: {{(now())->diffInHours($token->expiration_date)}}ч
                    @endif
                @endif
            </div>
{{--            <div class="col-auto"></div>--}}
        </div>

        @endforeach

        @if($tokens->where('expiration_date', '>', now())->count() < 5)
            <form method="post" action="#generateToken">
                @csrf
                <h3 class="mt-3">
                    Длительность действия (в днях):
                </h3>
                <div class="row mb-1">
                    <div class="col-auto">
                        <input name="token_live_time" type="number" class="form-control" value="1"/>
                    </div>
                </div>


                <button type="submit" class="btn btn-success">Создать новый токен</button>
            </form>
        @endif
    </div>
@endsection

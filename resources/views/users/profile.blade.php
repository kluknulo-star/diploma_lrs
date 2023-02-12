@extends('layouts.app')

@section('content')
    <div class="container">
        @include('layouts.messages')
        @include('layouts.errors')
        <h2>Profile: {{Auth::user()->name}}</h2>
        <h4>Tokens:</h4>
        @foreach($tokens as $key => $token)
            <label for="myInput{{$key}}">Your token:
                @if($token->expiration_date < now())
                    <form method="post" action="{{route('delete.token', $token->token_id)}}">
                        @method('DELETE')
                        @csrf
                        <button>X</button>
                    </form>
                @endif
            </label><br><input style="min-width: 560px;" type="text"
                               value="{{$token->token}}" id="myInput{{$key}}">
            <button onclick="myFunction({{$key}})">Copy text</button>
            The token is valid only before {{$token->expiration_date}}
            @if(now() < $token->expiration_date)
                <br>
                Time before diny ending: {{(now())->diffInHours($token->expiration_date)}} hours
            @endif
            <br>

        @endforeach

        @if($tokens->where('expiration_date', '>', now())->count() < 5)
            <form method="post" action="#generateToken">
                @csrf
                <label>
                    days:<br/>
                    <input name="token_live_time" value="1"/>
                </label>

                <button type="submit">Generate new token</button>
            </form>
        @endif
    </div>
@endsection

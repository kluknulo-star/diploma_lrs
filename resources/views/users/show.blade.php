@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>User #{{$user->user_id}}</h2>
        <ul class="list-group">
            <li class="list-group-item">username: {{$user->name}}</li>
            <li class="list-group-item">email: {{$user->email}}</li>
        </ul>
    </div>
@endsection

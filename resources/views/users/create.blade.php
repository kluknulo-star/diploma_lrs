@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create new user</h1>

        @include('layouts.errors')

        <form method="post" action="{{route('users.store')}}">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Username</label>
                <input type="text" name="name" placeholder="name" value="{{old('name')}}"/>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input type="email" name="email" placeholder="email" value="{{old('email')}}"/>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" name="password" placeholder="password"/>
            </div>

            <button type="submit">Add user</button>
        </form>
    </div>
@endsection

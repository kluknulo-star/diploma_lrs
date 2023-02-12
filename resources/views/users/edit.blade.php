@extends('layouts.app')

@section('content')
    <div class="container">
        @include('layouts.errors')
        <form method="post" action="{{route('users.update',$user->user_id)}}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="exampleInputUsername">Username</label>
                <input type="text" name="name" placeholder="name" value="{{old('name', $user->name)}}"
                       id="exampleInputUsername"/>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail">Email</label>
                <input type="email" name="email" placeholder="email" value="{{old('email', $user->email)}}" id="exampleInputEmail"/>
            </div>
            <button type="submit">Update</button>
        </form>
    </div>
@endsection

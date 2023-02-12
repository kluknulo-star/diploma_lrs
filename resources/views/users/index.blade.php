@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Users</h1>
        <a href="{{route('users.create')}}">Create new user</a>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            @foreach($users as $user)
                <tbody>
                <tr>
                    <td>{{$user->user_id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td><a href="{{route('users.show', ['id' => $user->user_id])}}">View</a>
                    </td>
                    <td><a href="{{route('users.edit', ['id' => $user->user_id])}}">Edit</a>
                    </td>
                    <td>
                        @if(\Illuminate\Support\Facades\Auth::id() !== (int) $user->user_id)
                            <form action="{{route('users.destroy', ['id' => $user->user_id])}}" method="Post">
                                @csrf
                                @method('Delete')
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
                </tbody>
            @endforeach
        </table>
        <div>
            {{$users->withQueryString()->links()}}
        </div>
    </div>
@endsection

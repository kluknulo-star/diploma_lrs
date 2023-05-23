@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Пользователи</h1>
        <a href="{{route('users.create')}}" class="btn btn-primary mb-1">Создать</a>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Имя</th>
                <th scope="col">Почта</th>
                <th colspan="3" class="text-center">Дейсвтия</th>
            </tr>
            </thead>
            @foreach($users as $user)
                <tbody>
                <tr>
                    <td>{{$user->user_id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td><a href="{{route('users.show', ['id' => $user->user_id])}}" class="btn btn-light">Посмтреть</a>
                    </td>
                    <td><a href="{{route('users.edit', ['id' => $user->user_id])}}" class="btn btn-dark">Изменить</a>
                    </td>
                    <td>
                        @if(\Illuminate\Support\Facades\Auth::id() !== (int) $user->user_id)
                            <form action="{{route('users.destroy', ['id' => $user->user_id])}}" method="Post">
                                @csrf
                                @method('Delete')
                                <button type="submit" class="btn btn-danger">Удалить</button>
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

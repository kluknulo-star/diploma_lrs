@extends('layouts.app')

@section('content')
    <div class="container">
        <br>
        <h2>Statement #{{$statement->statement_id}}</h2>

        <br>
        <ul class="list-group">
            <li class="list-group-item">
                <pre>{{json_encode($statement->content,
                        JSON_UNESCAPED_UNICODE |
                        JSON_PRETTY_PRINT |
                        JSON_UNESCAPED_SLASHES)}}</pre>
            </li>
        </ul>
    </div>
@endsection

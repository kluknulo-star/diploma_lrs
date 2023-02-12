@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Exports</h1>

        @include('layouts.errors')
        @include('layouts.messages')

        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Export</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($exports as $export)
                <tr>
                    <td>{{$export->export_id}}</td>
                    <td>{{$export->file_path}}</td>
                    <td>
                        @if($export->percent_of_work === 100)
                            <form action="{{route('export.download', ['id' => $export->export_id])}}" method="Post">
                                @csrf
                                <button type="submit">Download</button>
                            </form>
                        @else
                            {{$export->percent_of_work}} %
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="max-width: 100px; max-height: 250px;">
            {{$exports->withQueryString()->links()}}
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Statements</h1>
        <form action="{{route('statements')}}" method="post">
            @csrf
            <div class="form-group">
                <label>Actor filter: </label>
                <input type="text" name="actor-filter" value="{{$filterParam['actor-filter'] ?? ''}}"/>
            </div>
            <div class="form-group">
                <label>object filter: </label>
                <input type="text" name="object-filter" value="{{$filterParam['object-filter'] ?? ''}}"/>
            </div>
            <div class="form-group">
                <label>Verb filter: </label>
                <input type="text" name="verb-filter" value="{{$filterParam['verb-filter'] ?? ''}}"/>
            </div>
            <div class="form-group">
                <label>Context filter: </label>
                <input type="text" name="context-filter" value="{{$filterParam['context-filter'] ?? ''}}"/>
            </div>
            <div class="form-group">
                <label>Sorted by: </label>
                <select name="dep-sort">
                    <option
                        value="DESC"
                        @selected($sorting !== 'ASC')>
                        Убыванию
                    </option>
                    <option
                        value="ASC"
                        @selected($sorting === 'ASC')>
                        Возрастанию
                    </option>
                </select>
            </div>
            <button type="submit">Apply</button>
        </form>
        <form action="{{route('export.save', $formExportParams)}}" method="post">
            @csrf
            <button type="submit">Export</button>
        </form>
        @include('layouts.messages')
        @include('layouts.errors')
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Actor</th>
                <th scope="col">Verb</th>
                <th scope="col">Object</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($statements as $statement)
                <tr>
                    <td>{{$statement['statement_id']}}</td>
                    <td>
                        <a href="{{route('statements', ['actor-filter' => $statement['actor_mbox']['link']])}}">
                            {{$statement['actor_mbox']['text']}}
                        </a>
                    </td>
                    <td>
                        <a href="{{route('statements', ['verb-filter' => $statement['verb_id']['link']])}}">
                            {{$statement['verb_id']['text']}}
                        </a>
                    </td>
                    <td>
                        <a href="{{route('statements', ['object-filter' => $statement['object_id']['link']])}}">
                            {{$statement['object_id']['text']}}
                        </a>
                    </td>
                    <td>
                        <a href="{{route('statements.show', ['statement'=> $statement['statement_id']])}}">
                            View
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div>
            {{$paginator->withQueryString()->links()}}
        </div>
    </div>
@endsection

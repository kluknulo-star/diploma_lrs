@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Предложения</h1>
        <form action="{{route('statements')}}" method="post">
            @csrf
            <div class="form-group">
                <label>Actor фильтр: </label>
                <input type="text" name="actor-filter" value="{{$filterParam['actor-filter'] ?? ''}}"/>
            </div>
            <div class="form-group">
                <label>Object фильтр: </label>
                <input type="text" name="object-filter" value="{{$filterParam['object-filter'] ?? ''}}"/>
            </div>
            <div class="form-group">
                <label>Verb фильтр: </label>
                <input type="text" name="verb-filter" value="{{$filterParam['verb-filter'] ?? ''}}"/>
            </div>
            <div class="form-group">
                <label>Context фильтр: </label>
                <input type="text" name="context-filter" value="{{$filterParam['context-filter'] ?? ''}}"/>
            </div>
            <div class="form-group">
                <label>Сортировать по: </label>
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
            <button type="submit" class="btn btn-success rounded rounded-2 mb-2">Поиск</button>
        </form>

{{--        <form action="{{route('export.save', $formExportParams)}}" method="post">--}}
{{--            @csrf--}}
{{--            <button type="submit" class="btn btn-primary rounded rounded-2 mt-1 mb-1">Экспортировать</button>--}}
{{--        </form>--}}
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

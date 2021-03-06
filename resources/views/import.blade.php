@extends('layouts.app')


@section('content')
    <div class="container text-center">
        <h1 class="title m-b-md">
            Import properties.
        </h1>
        <div>
            @if ($result)
                <h3 class="text-{{$result->markupName()}}">{{$result->message()}}</h3>
                <p>failed:{{$result->data()['failed']}} </p>
                <p>saved: {{$result->data()['saved']}}</p>
                <p>total: {{$result->data()['total']}}</p>
                <p>skipped: {{$result->data()['total']-$result->data()['saved']-$result->data()['failed']}}</p>
                <p>time: {{$result->data()['time']}}</p>
            @endif
            <p>
                <a href="{{route('import.run')}}" class="btn btn-primary btn-lg" tabindex="-1" role="button">Run import
                </a>
            </p>
        </div>
    </div>
@endsection




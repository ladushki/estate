@extends('layouts.app')


@section('content')
    <div class="container text-center">
        <h1 class="title m-b-md">
            {{$item->name}}.
        </h1>
        <a href="{{ route('admin.show',['id'=>$item->uuid]) }}" class="btn btn-outline-secondary"><i class="fa fa-arrow-alt-circle-left"></i> show</a>
        <div class="py-3 col-6">
            {!! $form !!}

        </div>
    </div>
@endsection


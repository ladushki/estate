@extends('layouts.app')


@section('content')
    <div class="container">
        <h1 class="title m-b-md">
            Update the data.
        </h1>
        <div class="col-10">
            <input name="id" value="{{$id}}" id="uuid" type="hidden">
            {!! $form->render() !!}
        </div>
    </div>
@endsection




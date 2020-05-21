@extends('layouts.app')


@section('content')
    <div class="container text-center">
        <h1 class="title m-b-md">
            Properties.
        </h1>
        <div class="py-3">
            @include('_search_form')
        </div>
        <div class="card-columns">
            @forelse ($properties as $item)
                <div class="card">
                    <img class="card-img-top" src="{{$item->thumbnail}}" alt="Card image">
                    <div class="card-body">
                        <h5 class="card-title">{{$item->town}}</h5>
                        <p class="card-text"><i class="fas fa-map-marker-alt"></i>
                            <a href="{{$item->mapLink}}" class="card-link" target="_blank">
                                {{$item->county}}, {{$item->country}}
                            </a>
                        </p>
                        <small>{{$item->num_bedrooms}} bedroom,
                            {{$item->num_bathrooms}} bathroom, {{$item->propertyType->title}} </small>
                    </div>
                    <div class="card-footer">
                        @money($item->price)
                        <span class="badge badge-primary">{{$item->type}}</span>
                        <div>
                            <a href="{{route('admin.show', ['id'=>$item->uuid])}}"
                               class="stretched-link">More >>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p>No results</p>
            @endforelse

        </div>
        <div class="text-center"> {{ $properties->onEachSide(5)->links("pagination::bootstrap-4") }}</div>
    </div>
@endsection




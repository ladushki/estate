@extends('layouts.app')


@section('content')
    <div class="container text-center">
        <div class="col-md-12">
            <div class="property-details">
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-xs-12">
                        <div class="info">
                            <h3>{{$item->name}} <span class="badge badge-primary">{{$item->type}}</span></h3>
                            <p class="address">{{$item->address}}<br>
                                {{$item->town}}<br>
                                {{$item->postcode}}</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-xs-12">
                        <div class="details">
                            <div class="details-listing">
                                <h5>
                                    <p class="room-type">{{$item->propertyType->title}}</p>
                                </h5>
                            </div>
                            <div class="details-listing">
                                <p>Bedrooms</p>
                                <h5>{{$item->num_bedrooms}}</h5>
                            </div>
                            <div class="details-listing">
                                <p>Bathrooms</p>
                                <h5>{{$item->num_bathrooms}}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-xs-12">
                        <div class="others">
                            <ul>
                                <li><span>@money($item->price)</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 col-md-12 col-xs-12">
                        <div class="image">
                            <img src="{{$item->large_image}}"/>
                        </div>

                    </div>
                    <div class="col-lg-4  text-left">
                        <a href="{{route('edit', ['id'=>$item->uuid])}}" class="btn btn-outline-info">Edit</a>
                        <a href="{{route('vue-edit', ['id'=>$item->uuid])}}" class="btn btn-outline-info">Edit vue</a>
                        <a href="{{route('listing', ['product'=>$item->type])}}" class="btn btn-outline-primary">
                            All for {{$item->type}} </a>
                        <div class="py-3">
                            <h3>Description</h3>
                            <p>{{$item->description}}</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection




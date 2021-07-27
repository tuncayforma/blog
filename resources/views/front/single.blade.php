@extends('front.layouts.master')
@section('bg',$articles->image)
@section('title',$articles->title)
@section('content')
                <div class="col-md-9">
                    {!! $articles->content !!}
                </div>
@include('front.widgets.categoryWidget')
@endsection

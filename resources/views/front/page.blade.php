@extends('front.layouts.master')
@section('bg',$page->image)
@section('title',$page->title)
@section('content')
                <div class="col-md-9">
                    {!! $page->content !!}
                </div>
@endsection

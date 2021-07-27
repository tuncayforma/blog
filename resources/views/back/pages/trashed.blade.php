@extends('back.layouts.master')
@section('title','Silinen Makaleler')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary float-left">@yield('title')</h6>
            <a href="{{route('admin.makaleler.index')}}" class="btn btn-primary btn-sm float-right"><i class="fa fa-trash"></i> Aktif Makaleler</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Fotoğraf</th>
                        <th>Makale Başlığı</th>
                        <th>Kategori</th>
                        <th>Hit</th>
                        <th>Oluşturma T.</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($articles as $article)
                    <tr>
                        <td>
                        <img src="{{asset('/')}}{{$article->image}}" width="200">
                        </td>
                        <td>{{$article->title}}</td>
                        <td>{{$article->getCategory->name}}</td>
                        <td>{{$article->hit}}</td>
                        <td>{{$article->created_at->diffForHumans()}}</td>
                        <td><input class="switch" article-id="{{$article->id}}" type="checkbox" data-on="Aktif" data-off="Pasif" data-offstyle="danger" data-onstyle="success" @if($article->status==1)  checked @endif data-toggle="toggle"></td>
                        <td>
                        <div>
                               <a href="{{route('admin.recover',$article->id)}}" title="Silmeyi Geri Al" class="btn btn-sm btn-success"><i class="fa fa-undo"></i> Silmeyi Geri Al</a> <br>
                               <a href="{{route('admin.hardDelete',$article->id)}}" title="Tamamen Sil" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Tamamen Sil</a>
                           </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
@endsection
@section('js')
    <script>
        $(function() {
            $('.switch').change(function() {
                id = $(this)[0].getAttribute('article-id');
                statu = $(this).prop('checked');
                $.get("{{url('admin/switch')}}/"+id, {statu:statu}, function (data,status){});
            })
        })
    </script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
@endsection

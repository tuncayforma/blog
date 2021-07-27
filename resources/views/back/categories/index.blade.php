@extends('back.layouts.master')
@section('title','Tüm Kategoriler')
@section('content')

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"> Yeni Kategori Oluştur</h6>
                </div>
                <div class="card-body mb-4">
                    <form method="post" action="{{route('admin.category.create')}}">
                        @csrf
                        <div class="form-group">
                            <label for="">Kategori Adı</label>
                            <input type="text" class="form-control" name="category" required/>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block float-right">Ekle</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"> @yield('title')</h6>
                </div>
                <div class="card-body mb-4">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Kategori Adı</th>
                                <th>Makale Sayısı</th>
                                <th>Durum</th>
                                <th>İşlemler</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{$category->name}}</td>
                                    <td>{{$category->articleCount()}}</td>
                                    <td><input class="switch" category-id="{{$category->id}}" type="checkbox" data-on="Aktif" data-off="Pasif" data-offstyle="danger" data-onstyle="success" @if($category->status==1)  checked @endif data-toggle="toggle"></td>
                                    <td>
                                        <a category-id="{{$category->id}}" class="btn btn-sm btn-primary edit-click" title="Kategoriyi düzenle"><i class="fa fa-edit text-white"></i></a>
                                        <a category-id="{{$category->id}}" category-count="{{$category->articleCount()}}" category-name="{{$category->name}}" class="btn btn-sm btn-danger remove-click" title="Kategoriyi sil"><i class="fa fa-times text-white"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Modal -->
    <!-- Modal Güncelle -->
    <div class="modal fade" id="editModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Kategoriyi düzenle</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('admin.category.update')}}">
                        @csrf
                        <div class="form-group">
                            <label for="">Kategori Adı</label>
                            <input type="text" class="form-control" id="category" name="category"/>
                            <input type="hidden" id="category_id" name="id"/>
                        </div>
                        <div class="form-group">
                            <label for="">Kategori Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug"/>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block float-right">Kaydet</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Kapat</button>

                </div>

            </div>
        </div>
    </div>
    <!-- Modal Sil -->
    <div class="modal fade" id="deleteModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Kategoriyi sil </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div id="body" class="modal-body">
                    <div class="alert alert-danger" id="articleAlert">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" >Kapat</button>
                    <form method="post" action="{{route('admin.category.delete')}}">
                        @csrf
                        <input type="hidden" name="id" id="deleteId">
                        <button type="submit" id="delete-button" class="btn btn-primary" >Sil</button>
                    </form>
                </div>

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
            $('.remove-click').click(function (){
                id = $(this)[0].getAttribute('category-id');
                count = $(this)[0].getAttribute('category-count');
                name = $(this)[0].getAttribute('category-name');
                if(id==1){
                    $('#articleAlert').html(name +' kategorisi sabittir. Silinen diğer kategorilere ait makaleler bu kategoriye eklenecektir');
                    $('#body').show();
                    $('#delete-button').hide();
                    $('#deleteModal').modal();
                    return;
                }
                $('#delete-button').show();
                $('#deleteId').val(id);
                $('#body').hide();
                if(count>0){
                    $('#articleAlert').html('Bu kategoriye ait ' + count + ' makale bulunmaktadır. Silmek istediğinize emin misiniz?');
                    $('#body').show();
                }
                $('#deleteModal').modal();
            });
            $('.edit-click').click(function (){
                id = $(this)[0].getAttribute('category-id');
                $.ajax({
                    type:'GET',
                    url:'{{url("admin/category/getdata")}}/+id',
                    data:{id:id},
                    success:function(data){
                        console.log(data);
                        $('#category').val(data.name);
                        $('#slug').val(data.slug);
                        $('#category_id').val(data.id);
                        $('#editModal').modal();
                    }
                });
            });
            $('.switch').change(function() {
                id = $(this)[0].getAttribute('category-id');
                statu = $(this).prop('checked');
                $.get("{{url('admin/category/switch')}}/"+id, {statu:statu}, function (data,status){});
            })
        })
    </script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
@endsection

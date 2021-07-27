@extends('back.layouts.master')
@section('title',$article->title.' makalesini güncelle')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                  @foreach($errors->all() as $error)
                      {{$error}} <br>
                    @endforeach
                </div>
            @endif
            <div class="container px-5 my-5">
                <form method="post" action="{{route('admin.makaleler.update',$article->id)}}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-floating mb-3">
                        <label for="makaleBasligi">Makale Başlığı</label>
                        <input class="form-control" name="title" id="makaleBasligi" value="{{$article->title}}" type="text" placeholder="Makale Başlığı" data-sb-validations="required" />
                        <div class="invalid-feedback" data-sb-feedback="makaleBasligi:required">Makale Başlığı is required.</div>
                    </div>
                    <div class="form-floating mb-3">
                        <label for="makaleKategori">Makale Kategori</label>
                        <select class="form-control" name="category" id="makaleKategori" aria-label="Makale Kategori">
                            <option value="0"> Seçim Yapınız</option>
                            @foreach($categories as $category)
                            <option @if($article->category_id==$category->id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-floating mb-3">
                        <label for="makaleFotografi">Makale Fotoğrafı</label> <br>
                        <img src="{{asset($article->image)}}" width="300">
                        <input class="form-control"  name="image" id="makaleFotografi" type="file" placeholder="Makale Fotoğrafı" data-sb-validations="required" />
                        <div class="invalid-feedback" data-sb-feedback="makaleFotografi:required">Makale Fotoğrafı is required.</div>
                    </div>
                    <div class="form-floating mb-3">
                        <label for="makaleIcerigi">Makale İçeriği</label>
                        <textarea class="form-control" name="contents" id="makaleIcerigi" type="text" placeholder="Makale İçeriği" style="height: 10rem;" data-sb-validations="required">{!! $article->content !!}</textarea>
                        <div class="invalid-feedback" data-sb-feedback="makaleIcerigi:required">Makale İçeriği is required.</div>
                    </div>
                    <div class="d-none" id="submitSuccessMessage">
                        <div class="text-center mb-3">
                            <div class="fw-bolder">Form submission successful!</div>
                            <p>To activate this form, sign up at</p>
                            <a href="https://startbootstrap.com/solution/contact-forms">https://startbootstrap.com/solution/contact-forms</a>
                        </div>
                    </div>
                    <div class="d-none" id="submitErrorMessage">
                        <div class="text-center text-danger mb-3">Error sending message!</div>
                    </div>
                    <div>
                        <button class="btn btn-primary btn-lg" id="submitButton" type="submit">Makaleyi Güncelle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#makaleIcerigi').summernote(
                {
                    'height':300
                }
            );
        });
    </script>
@endsection

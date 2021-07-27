@extends('back.layouts.master')
@section('title','Sayfa Oluştur')
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
                <form method="post" action="{{route('admin.page.create.post')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-floating mb-3">
                        <label for="SayfaBasligi">Sayfa Başlığı</label>
                        <input class="form-control" name="title" id="SayfaBasligi" type="text" placeholder="Sayfa Başlığı" data-sb-validations="required" />
                        <div class="invalid-feedback" data-sb-feedback="SayfaBasligi:required">Sayfa Başlığı is required.</div>
                    </div>
                    <div class="form-floating mb-3">
                        <label for="SayfaFotografi">Sayfa Fotoğrafı</label>
                        <input class="form-control"  name="image" id="SayfaFotografi" type="file" placeholder="Sayfa Fotoğrafı" data-sb-validations="required" />
                        <div class="invalid-feedback" data-sb-feedback="SayfaFotografi:required">Sayfa Fotoğrafı is required.</div>
                    </div>
                    <div class="form-floating mb-3">
                        <label for="SayfaIcerigi">Sayfa İçeriği</label>
                        <textarea class="form-control" name="contents" id="SayfaIcerigi" type="text" placeholder="Sayfa İçeriği" style="height: 10rem;" data-sb-validations="required"></textarea>
                        <div class="invalid-feedback" data-sb-feedback="SayfaIcerigi:required">Sayfa İçeriği is required.</div>
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
                        <button class="btn btn-primary btn-lg" id="submitButton" type="submit">Sayfayi Oluştur</button>
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
            $('#SayfaIcerigi').summernote(
                {
                    'height':300
                }
            );
        });
    </script>
@endsection

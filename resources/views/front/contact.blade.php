@extends('front.layouts.master')
@section('bg','https://media.istockphoto.com/photos/got-a-problem-contact-us-picture-id1129113667?k=6&m=1129113667&s=612x612&w=0&h=uw_vb53_uxej3Bn7mh-qZCL_xzKXdAtFL2Piw7IRrYQ=')
@section('title','İletişim')
@section('content')
    <div class="col-md-8">
        <div class="container px-5 my-5">
            @if(session('success'))
                <div class="alert alert-success">
                    {{session('success')}}
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            <form method="post" action="{{route('contact.post')}}">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="adSoyad">Ad Soyad</label>
                    <input class="form-control" name="name" value="{{old('name')}}" type="text" placeholder="Ad Soyadınız" data-sb-validations="required" />
                    <div class="invalid-feedback" data-sb-feedback="adSoyad:required">Ad Soyad is required.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="emailAdresi">Email Adresi</label>
                    <input class="form-control" name="email" type="email"  value="{{old('email')}}" placeholder="Email Adresiniz" data-sb-validations="required,email" />
                    <div class="invalid-feedback" data-sb-feedback="emailAdresi:required">Email Adresi is required.</div>
                    <div class="invalid-feedback" data-sb-feedback="emailAdresi:email">Email Adresi Email is not valid.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label" name="topic">Konu</label>
                    <select class="form-select" name="topic" aria-label="Konu">
                        <option value="Bilgi" @if(old('topic')=="Bilgi") selected @endif>Bilgi</option>
                        <option value="Destek" @if(old('topic')=="Destek") selected @endif>Destek</option>
                        <option value="Genel" @if(old('topic')=="Genel") selected @endif>Genel</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="mesajiniz">Mesajınız</label>
                    <textarea class="form-control" name="message" type="text" placeholder="Mesajınız" style="height: 10rem;" data-sb-validations="required">{{old('message')}}</textarea>
                    <div class="invalid-feedback" data-sb-feedback="mesajiniz:required">Mesajınız is required.</div>
                </div>
                <div class="d-grid">
                    <button class="btn btn-primary" id="submitButton" type="submit">Gönder</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-4">
        Telefon Numarası: 541545461
        Adres :sdfşçfşifsdş
    </div>
@endsection


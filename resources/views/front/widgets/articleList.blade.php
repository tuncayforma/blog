<!-- Post preview-->
@foreach($articles as $article)
    <div class="post-preview">
        <a href="{{route('single',[$article->getCategory->slug,$article->slug])}}">
            <h2 class="post-title">{{$article->title}}</h2>
            <img src="{{asset($article->image)}}" style="width:100%;"/>
            <h3 class="post-subtitle">{!!Str::limit($article->content,70)!!}</h3>
        </a>
        <p class="post-meta">
            Kategori: <a href="#!">{{$article->getCategory->name}}</a>
            <span class="float-end">{{$article->created_at->diffForHumans()}} </span>
        </p>
    </div>
    <!-- Divider-->
    <hr class="my-4" />
@endforeach
<div class="d-flex justify-content-center">{{ $articles->render()}} </div>

<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles=Article::orderBy('created_at','ASC')->get();
        return view('back.articles.index',compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('back.articles.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:100',
            'contents' => 'required',

        ]);

        $article = new Article();
        $article->title = $request->title;
        $article->category_id = $request->category;
        $article->content = $request->contents;
        $article->slug = Str::slug($request->title);
        if ($request->hasFile('image')){
            $imageName = Str::slug($request->title).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$imageName);
            $article->image = 'uploads/'.$imageName;
        }
        $article->save();
        toastr()->success('Başarılı!', 'Makale başarıyla oluşturuldu');
        return redirect()->route('admin.makaleler.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::findOrfail($id);
        $categories = Category::all();
        return view('back.articles.update',compact('categories','article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'min:3',
            'image' => 'image|mimes:jpeg,png,jpg|max:100',
        ]);

        $article = Article::findOrFail($id);
        $article->title = $request->title;
        $article->category_id = $request->category;
        $article->content = $request->contents;
        $article->slug = Str::slug($request->title);
        if ($request->hasFile('image')){
            $imageName = Str::slug($request->title).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$imageName);
            $article->image = 'uploads/'.$imageName;
        }
        $article->save();
        toastr()->success('Başarılı!', 'Makale başarıyla güncellendi');
        return redirect()->route('admin.makaleler.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function delete($id){
        Article::findOrFail($id)->delete();
        toastr()->success('Başarılı!', 'Makale silinen makalelere taşındı');
        return redirect()->route('admin.makaleler.index');
    }
    public function switch(Request $request){
        $article=Article::findOrFail($request->id);
        $article->status=$request->statu=='true' ? 1 : 0;
        $article->save();
    }
    public function trashed(){
        $articles = Article::onlyTrashed()->orderBy('deleted_at','ASC')->get();
        return view('back.articles.trashed',compact('articles'));
    }
    public function recover($id){
        Article::onlyTrashed()->findOrFail($id)->restore();
        toastr()->success('Başarılı!', 'Silme işlemi başarıyla geri alındı');
        return redirect()->route('admin.trashed');
    }
    public function hardDelete($id){
        $article = Article::onlyTrashed()->findOrFail($id);
        if(File::exists($article->image)){
            File::delete(public_path($article->image));
        }
        $article->forceDelete();
        toastr()->success('Başarılı!', 'Makale başarıyla silindi');
        return redirect()->route('admin.trashed');
    }
}

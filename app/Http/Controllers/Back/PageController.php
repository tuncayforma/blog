<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class pageController extends Controller
{
    public function index(){
        $pages = page::orderBy('order','asc')->get();
        return view('back.pages.index',compact('pages'));
    }
    public function create(){
        return view('back.pages.create');
    }
    public function update($id){
        $page = Page::findOrFail($id);
        return view('back.pages.update',compact('page'));
    }
    public function switch(Request $request){
        $page=page::findOrFail($request->id);
        $page->status=$request->statu=='true' ? 1 : 0;
        $page->save();
    }
    public function post(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:10000',
            'contents' => 'required',

        ]);
        $last = Page::orderBy('order','desc')->first();

        $page = new Page();
        $page->title = $request->title;
        $page->content = $request->contents;
        $page->order = $last->order+1;
        $page->slug = Str::slug($request->title);
        if ($request->hasFile('image')){
            $imageName = Str::slug($request->title).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$imageName);
            $page->image = 'uploads/'.$imageName;
        }
        $page->save();
        toastr()->success( 'Sayfa başarıyla oluşturuldu');
        return redirect()->route('admin.pages.index');
    }
    public function updatepost(Request $request, $id){
        $request->validate([
            'title' => 'min:3',
            'image' => 'image|mimes:jpeg,png,jpg|max:10000',
        ]);
        $page = Page::findOrFail($id);
        $page->title = $request->title;
        $page->content = $request->contents;
        $page->slug = Str::slug($request->title);
        if ($request->hasFile('image')){
            $imageName = Str::slug($request->title).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$imageName);
            $page->image = 'uploads/'.$imageName;
        }
        $page->save();
        toastr()->success( 'Sayfa başarıyla güncellendi');
        return redirect()->route('admin.pages.index');
    }
    public function delete($id){
        $page = Page::findOrFail($id);
        if(File::exists($page->image)){
            File::delete(public_path($page->image));
        }
        $page->delete();
        toastr()->success('Başarılı!', 'Sayfa başarıyla silindi');
        return redirect()->route('admin.pages.index');
    }
    public function orders(Request $request){
        foreach ($request->get('page') as $key => $order){
            Page::where('id',$order)->update(['order'=>$key]);
        };

    }
}

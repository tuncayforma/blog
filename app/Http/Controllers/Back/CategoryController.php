<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::all();
        return view('back.categories.index',compact('categories'));
    }
    public function switch(Request $request){
        $categories=Category::findOrFail($request->id);
        $categories->status=$request->statu=='true' ? 1 : 0;
        $categories->save();
    }
    public function create(Request $request){
        $isExist = Category::whereSlug(Str::slug($request->category))->first();
        if ($isExist){
            toastr()->error($request->category. ' adında bir kategori mevcut!');
            return redirect()->back();die;
        }
        $category = new Category();
        $category->name = $request->category;
        $category->slug = Str::slug($request->category);
        $category->save();
        toastr()->success('Kategori başarıyla oluşturuldu');
        return redirect()->back();
    }
    public function update(Request $request){
        $isSlug = Category::whereSlug(Str::slug($request->slug))->whereNotIn('id',[$request->id])->first();
        $isExist = Category::whereName($request->category)->whereNotIn('id',[$request->id])->first();
        if ($isExist or $isSlug){
            toastr()->error($request->category. ' adında bir kategori mevcut!');
            return redirect()->back();die;
        }
        $category = Category::find($request->id);
        $category->name = $request->category;
        $category->slug = Str::slug($request->slug);
        $category->save();
        toastr()->success('Kategori başarıyla güncellendi');
        return redirect()->back();
    }
    public function getdata(Request $request){
        $category=Category::findOrFail($request->id);
        return response()->json($category);
    }
    public function delete(Request $request){
        $category = Category::findOrFail($request->id);
        if ($category->id==1){
            toastr()->error('Bu kategori silinemez');
            return redirect()->back();
        }
        $message ='';
        $count = $category->articleCount();
        if ($count>0){
            Article::where('category_id',$category->id)->update([
                'category_id'=>1
            ]);
            $defaultCategory = Category::find(1);
            $message =  'Bu kategoriye ait '. $count .' makale '. $defaultCategory->name. ' kategorisine taşındı';
        }
        toastr()->success($message,'Kategori başarıyla silindi');
        $category->delete();
        return redirect()->back();
    }
}

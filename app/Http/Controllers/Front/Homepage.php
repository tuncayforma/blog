<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Article;
use App\Models\Page;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use Validator;
use function GuzzleHttp\Promise\all;

class Homepage extends Controller
{
    public function __construct()
    {
        if (Config::find(1)->active==0){
            return redirect()->to('site-bakimda')->send();
        }
        view()->share('pages',$data['pages']=Page::where('status',1)->orderBy('order','ASC')->get());
        view()->share('categories',Category::where('status',1)->inRandomOrder()->get());
    }

    public function index(){
        $data['articles']=Article::with('getCategory')->where('status',1)->whereHas('getCategory',function ($query){
            $query->where('status',1);
        })->orderBy('created_at','DESC')->paginate(5);
        return view('front.homepage',$data);
    }
    public function single($category,$slug){
        $category = Category::whereSlug($category)->first() ?? abort(403,"Böyle bir kategori bulunamadı");
        $data['articles']=Article::whereSlug($slug)->whereCategoryId($category->id)->first() ?? abort(403,'Böyle bir yazı bulunamadı');
        return view('front.single',$data);
    }
    public function category($slug){
        $category = Category::whereSlug($slug)->first() ?? abort(403,"Böyle bir kategori bulunamadı");
        $data['category']=$category;
        $data['articles']= Article::where('category_id',$category->id)->where('status',1)->orderBy('created_at','DESC')->paginate(3);
        return view('front.category',$data);
    }
    public function page($slug){
        $page=Page::whereSlug($slug)->first() ?? abort(403,'Böyle bir sayfa bulunamadı.');
        $data['page'] = $page;
        return view('front.page',$data);
    }
    public function contact(){
        return view('front.contact');
    }
    public function contactpost(Request $request){
        $rules=[
            'name'=>'required|min:5',
            'email'=>'required|email',
            'topic'=> 'required',
            'message'=> 'required|min:10'
        ];
        $validate = Validator::make($request->post(),$rules);
        if ($validate->fails()){
            return redirect()->route('contact')->withErrors($validate)->withInput();
        }
        else{

            Mail::send([],[],function ($message) use($request){
                $message->from('iletisim@blogsitesi.com','Blog Sitesi');
                $message->to('tuncayforma4@gmail.com');
                $message->setBody('Measjı Gönderen : '.$request->name. '<br/>
                        Mesajı Gönderen Mail : '.$request->email. '<br/>
                        Mesajın Konusu : '.$request->topic. '<br/>
                        Mesaj : '.$request->message.'<br/><br>
                        Mesaj Gönderilme Tarihi : '.now().'','text/html');
                $message->subject($request->name. ' iletişimden mesaj gönderildi!');
            });
           /* $contact = new Contact;
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->topic = $request->topic;
            $contact->message = $request->message;
            $contact->save();*/

            return redirect()->route('contact')->with('success','İletişim mesajınız bize iletildi. Teşekkür ederiz.');
        }
    }
}

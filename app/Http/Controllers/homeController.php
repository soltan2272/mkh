<?php

namespace App\Http\Controllers;

use FarhanWazir\GoogleMaps\GMaps;
use Illuminate\Http\Request;
use \Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;


use App\User;

use App\Role;

use App\Map;

use App\Quest;


use Validator;

use Auth;

use Redirect;

use App\kidPost;

use DB;

use App\Home;

use Hash;

class homeController extends Controller
{
     public function index()
     {
         $home=Home::all();

       return view('index',compact('home'));
     }

     public function aboutus()
     {
         $home=Home::all();
         return view('about-us',compact('home'));
     }


    public function map()
    {
        $home=Home::all();
        $posts=array();
        $cat=array();
        $posts=DB::table('kid_posts')->pluck('governate');
        $cat=DB::table('kid_posts')->pluck('category');
        $locations=array();
        for($i=0;$i<count($posts);$i++)
        {
            $locations[$i]= DB::table('maps')->where('address','LIKE','%'.$posts[$i].'%')->get() ;
                //Map::where('address', 'LIKE', '%' . $posts[$i] . '%');
        }
        //dd($cat);
         return view ('map',compact('locations','cat','home'));
     }

     public function edituserpassword(Request $request)
     {
         $yes=2;
         $user =User::where('id',$request->id)->first();
         if (Hash::check($request->oldpass, $user->password)) {
             $user->password=bcrypt($request->newpass);
             $user->save();
             $yes=3;
         }

       /*  $user=User::find(Auth::user()->id);
         $home=Home::all();*/

        return redirect('/editprofile')->with('yes',$yes);

         //return view('editprofile',compact('user','home','yes'));
     }

     public function profile()
     {
         $home=Home::all();
         $posts=kidPost::where('user_id',Auth::user()->id)->latest()->paginate(5);
         return view('profile',compact('posts','home'));
     }


    public function editprofile()
    {
        $home=Home::all();
        $yes=0;
        $user=User::find(Auth::user()->id);
        return view('editprofile',compact('user','home','yes'));
    }
    public function saveeditprofile(Request $request)
    {
        $home=Home::all();
        $usr= DB::table('users')->where('id',Auth::user()->id)->get();
        foreach($usr as $us) {
            $eml=($us->email);
        };

        if($eml==$request->email)
        {

        }
        else
        {
            $this->validate($request,[
                'email'=>'required|email|unique:users',
            ]);
        }

        $user=User::find(Auth::user()->id);
        $user->firstName=$request->firstname;
        $user->lastName=$request->lastname;
        $user->email=$request->email;
        $user->phone=$request->phone;
        $user->gender=$request->gender;
        $user->save();
        $yes=1;
        return view('editprofile',compact('user','home','yes'));
    }




    public function newpost()
    {
        $home=Home::all();
        return view('newPost',compact('home'));
    }

    public function storepost(Request $request)
    {

        $post=new kidPost;
        $post->name=$request->input('name');
        $post->relative_relation=$request->input('r_r');
        $post->age=$request->input('age');
        $post->age_before=$request->input('age_before');
        $post->blood_type=$request->input('b_t');
        $post->gender=$request->input('gender');
        $post->governate=$request->input('governate');
        $post->city=$request->input('city');
        $post->street=$request->input('street');
        $post->detailed_address=$request->input('d_a');
        $post->other_info=$request->input('o_i');
        $post->user_id=$request->input('usr_id');
        $post->category=$request->input('category');

         //dd('11');
     //   dd($request->all());
        if($request->hasFile('image'))
        {

            $fileobject=$request->file('image');
            $filename=$fileobject->getClientOriginalName();
            $post->url=time().'.'. $filename;
            $fileobject->move('images',time().'.'.$filename);
          //  $fileobject->storeAs('images',time().'.'. $filename);

        }

        $post->save();


        return redirect('/profile');
    }

    public function editpost(Request $request)
    {
         $post=kidPost::find($request->id);
         $post->name=$request->input('name');
         $post->relative_relation=$request->input('r_r');
         $post->age=$request->input('age');
         $post->age_before=$request->input('age_before');
         $post->blood_type=$request->input('b_t');
         $post->gender=$request->input('gender');
         $post->governate=$request->input('governate');
         $post->city=$request->input('city');
         $post->street=$request->input('street');
         $post->detailed_address=$request->input('d_a');
         $post->other_info=$request->input('o_i');
 
          //dd('11');
      //   dd($request->all());
         if($request->hasFile('image'))
         {
 
             $fileobject=$request->file('image');
             $filename=$fileobject->getClientOriginalName();
             $post->url=time().'.'. $filename;
             $fileobject->move('images',time().'.'.$filename);
           //  $fileobject->storeAs('images',time().'.'. $filename);
 
         }
 
         $post->save();
 
 
         return redirect('/profile');
    }
    public function delpost(Request $request)
    {
       
        $quest=new Quest;
        $quest->post_id=$request->id;
        $quest->find_kidnap=$request->qq1;
        $quest->from_us=$request->qq1;
        $quest->comment=$request->q3;
        $quest->save();
        $post=kidPost::find($request->id);
        $post->delete();
        return back();
    }

    public function search()
    {
        $posts=kidPost::where('status',2)->latest()->paginate(5);
        $home=Home::all();
        return view('searching',compact('posts','home'));
    }
    public function getpostdata($id)
    {
        $posts=kidPost::find($id);
       
        echo json_encode($posts);
        
    }

    public function getsearch(Request $request)
    {

        $id=$request->input('id');
         $cat=$request->input('cat');
        $gender=$request->input('gender');
        $gov=$request->input('governate');
        $city=$request->input('city');




        $home=Home::all();
        if(isset($cat) && isset($gender))
        {
             $posts=kidPost::where('category',$request->input('cat'))
                ->where('gender',$request->input('gender'))->latest()->get();
        }

        if(isset($cat) && isset($gov))
        {
            $posts=kidPost::where('category',$request->input('cat'))
                ->where('governate',$request->input('governate'))->latest()->get();
        }
        if(isset($cat) && isset($city))
        {
            $posts=kidPost::where('category',$request->input('cat'))
                ->where('city',$request->input('city'))->latest()->get();
        }

        if(isset($gender) && isset($gov))
        {
            $posts=kidPost::where('gender',$gender)
                ->where('governate',$gov)->latest()->get();
        }
        if(isset($gender) && isset($city))
        {
            $posts=kidPost::where('gender',$gender)
                ->where('city',$city)->latest()->get();
        }


        if(isset($gov) && isset($city))
        {
            $posts=kidPost::where('governate',$gov)
                ->where('city',$city)->latest()->get();
        }

        if(isset($cat) && isset($gender) && isset($gov))
        {
            $posts=kidPost::where('category',$cat)
                ->where('gender',$gender)
                ->where('governate',$gov)->latest()->get();
        }
        if(isset($cat) && isset($gov) && isset($city))
        {
            $posts=kidPost::where('category',$cat)
                ->where('governate',$gov)
                ->where('city',$city)->latest()->get();
        }
        if( isset($gender) && isset($gov) && isset($city))
        {
            $posts=kidPost::where('gender',$gender)
                ->where('governate',$gov)
                ->where('city',$city)->latest()->get();
        }

        if( isset($cat) && isset($gender) && isset($gov) && isset($city))
        {
            $posts=kidPost::where('category',$cat)
                ->where('gender',$gender)
                ->where('governate',$gov)
                ->where('city',$city)->latest()->get();
        }

        if(isset($id) && isset($cat) && isset($gender) && isset($gov) && isset($city))
        {
            $posts=kidPost::where('id',$request->input('id'))
                ->where('category',$request->input('cat'))
                ->where('gender',$request->input('gender'))
                ->where('governate',$request->input('governate'))
                ->where('city',$request->input('city'))->latest()->get();
        }


        //dd(count($posts));
       if(count($posts)==0) {
          // dd(22);
            $posts = kidPost::where('id', $request->input('id'))
                ->orwhere('category', $request->input('cat'))
                ->orwhere('gender', $request->input('gender'))
                ->orwhere('governate', $request->input('governate'))
                ->orwhere('city', $request->input('city'))->latest()->get();
        }

        return view('getsearch',compact('posts','home'));
    }
}

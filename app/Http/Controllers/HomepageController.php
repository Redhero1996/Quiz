<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Image;
use Storage;
use Mail;
use App\Category;
use App\Topic;
use App\User;

class HomepageController extends Controller
{

    public function index(){
    	$categories = Category::all();
    	$topics = Topic::orderBy('id', 'desc')->paginate(12);

    	return view('pages.welcome', ['categories' => $categories, 'topics' => $topics]);
    }

    public function about(){
    	return view('pages.about');
    }

    public function getcontact(){
    	return view('pages.contact');
    }
    public function postcontact(Request $request){
        $request->validate([
            'email' => 'required|email',
            'subject' => 'min:3',
            'message' => 'min:10',
        ],[
            'email.required' => 'Vui lòng nhập email',
            'subject.min' => 'Tiêu đề tối tiểu 3 ký tự',
            'message.min' => 'Nội dung tối thiểu 10 ký tự' 
        ]);
        $data = [
            'email' => $request->email,
            'subject' => $request->subject,
            'bodyMessage' => $request->message,
        ];

        Mail::send('emails.contact', $data, function ($message) use ($data){
            $message->from($data['email']);
        
            $message->to('herogustin1986@gmail.com');
        
            $message->subject($data['subject']);
        
        });
        Session::flash('success', 'Email của bạn đã được gửi!');
        return redirect('/');
    }

    // ============= User Profile ===============//
    public function getProfile($id){
        $topics = Topic::all();
        $user = User::find($id);
        
        return view('pages.profile', ['user' => $user]);
    } 
    public function postProfile(Request $request, $id){
        $user = User::find($id);

        $request->validate([
            'name' => 'required',
        ],[
            'name.required' => 'Vui lòng nhập tên',
        ]);

        if($request->changePassword == 'on'){
            $request->validate([
                'password' => 'required|min:6',
                'confirm_pass' => 'required|same:password',
            ], [
                'password.required' => 'Vui lòng nhập mật khẩu',
                'password.min' => 'Mật khẩu tối thiểu 6 ký tự',
                'confirm_pass.required' => 'Mật khẩu không khớp',
                'confirm_pass.same' => 'Mật khẩu không khớp',
            ]);
            $user->password = bcrypt($request->password);
        }

        $user->name = $request->name;        
        if($user->level == 1){
            $user->level = 1;
        }else{
            $user->level = 0;
        }

        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time().'.'.$avatar->getClientOriginalExtension();
            $location = public_path('images/'.$filename);
            Image::make($avatar)->resize(200, 200)->save($location);

            if(isset($user->avatar)){
                $old_avatar = $user->avatar;
                $user->avatar = $filename;
                Storage::delete($old_avatar);
            }else{
                $user->avatar = $filename;
            }
            
        }

        $user->save();

        Session::flash('success', 'Tài khoản đã được cập nhật');
        return redirect()->route('user.profile', $user->id);
    }

    public function logout(){
        Auth::logout();
        Session::flush();
        return redirect('/');
    }
}

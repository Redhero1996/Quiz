<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Image;
use Storage;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index')->withUsers($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
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
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'confirm_pass' => 'required|same:password',
            'avatar' => 'sometimes|image',
        ]);
        
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->level = $request->level;

        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time().'.'.$avatar->getClientOriginalExtension();
            $location = public_path('images/'.$filename);
            Image::make($avatar)->resize(200, 200)->save($location);
            
            $user->avatar = $filename;

        }
        
        $user->save();

        Session::flash('success', 'The user was successfully save!');
        return redirect()->route('users.show', $user->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('admin.users.show')->withUser($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.users.edit')->withUser($user);
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
        $user = User::find($id);

        $request->validate([
            'name' => 'required|min:3',
        ]);

        if($request->changePassword == 'on'){
            $request->validate([
                'password' => 'required|min:6',
                'confirm_pass' => 'required|same:password',
            ]);
        }

        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->level = $request->level;
        // dd($request->file('avatar'));
        if($request->file('avatar')){

           $avatar = $request->file('avatar');
           $filename = time().'.'.$avatar->getClientOriginalExtension();
           $location = public_path('images/'.$filename);
           Image::make($avatar)->resize(200,200)->save($location);
           // get the old photo
           $oldImage = $user->avatar;
           // update the database
           $user->avatar = $filename;

           // dd($filename);
           // delete the old photo
           Storage::delete($oldImage);
       }

        $user->save();

        Session::flash('success', 'The user was successfully updated!');
        return redirect()->route('users.show', $user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->topics()->detach();
        $user->delete();

        Session::flash('success', 'The user was successfully deleted!');
        return redirect()->route('users.index');
    }
}

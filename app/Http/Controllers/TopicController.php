<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Topic;
use App\Category;
use App\Question;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = Topic::all();
        return view('admin.topics.index')->withTopics($topics);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.topics.create', [ 'categories' => $categories ]);
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
            'category_id' => 'required|integer',
        ]);

        $topic = new Topic();
        $topic->name = $request->name;
        $topic->slug = str_slug($request->name, '-');
        $topic->category_id = $request->category_id;
        $topic->save();
        Session::flash('success', 'The topic was successfully saved!');
        return redirect()->route('topics.show', $topic->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $topic = Topic::where('slug', $slug)->first();
        return view('admin.topics.show')->withTopic($topic);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $topic = Topic::find($id);
        $categories = Category::all();

        $cats = [];
        foreach ($categories as $category) {
            $cats[$category->id] = $category->name;
            
        }
         // dd($cats); 
        return view('admin.topics.edit', [ 'topic' => $topic, 'categories' => $cats ]);
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
        $topic = Topic::find($id);
        $request->validate([
            'name' => 'required|min:3|max:255',
            'category_id' => 'required|integer',
        ]);

        $topic->name = $request->name;
        $topic->slug = str_slug($request->name, '-');
        $topic->category_id = $request->category_id;
        $topic->save();
        
        Session::flash('success', 'The topic was successfully updated!');
        return redirect()->route('topics.show', $topic->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $topic = Topic::find($id);
        $topic->questions()->detach();
        $topic->users()->detach();
        $topic->delete();

        Session::flash('success', 'The topic was successfully deleted!');
        return redirect()->route('topics.index');
    }
}

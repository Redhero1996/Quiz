<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Purifier;

use App\Question;
use App\Category;
use App\Topic;
use App\Answer;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::all();
        return view('admin.questions.index', [ 'questions' => $questions ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $topics = Topic::all();
        $categories = Category::all();
        return view('admin.questions.create', ['topics' => $topics, 'categories' => $categories]);
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
            'content' => 'required|min:3',
            'topic_id' => 'required|integer',
            'answer.*' => 'required',
            'correct_ans' => 'required|min:1'
        ]);        

        $question = new Question();
        $question->content = Purifier::clean($request->content);
        $question->save();

        $question->topics()->sync($request->topic_id, false); 

        $question = Question::find($question->id);
        $correct = $question->correct_ans;

        $all_correct = $request->correct_ans;

        foreach ($request->answer as $key => $content) {
			$answer = new Answer();
			$answer->question_id = $question->id;
			$answer->content = $content;
			$answer->question()->associate($question->id);
	        $answer->save();
			for ($i=0; $i < count($all_correct); $i++) { 

				if($key == (int)$all_correct[$i]){
					$correct[$key] = $answer->id;
					$question->correct_ans = $correct;
				}
				$question->save();
			}       	
        }

        Session::flash('success', 'The question was successfully saved!');
        return redirect()->route('questions.show', $question->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $alphabet = array( 'A', 'B', 'C', 'D', 'E',
                       'F', 'g', 'h', 'i', 'j',
                       'k', 'l', 'm', 'n', 'o',
                       'p', 'q', 'r', 's', 't',
                       'u', 'v', 'w', 'x', 'y',
                       'z'
                       );
        $question = Question::find($id);
        $answers = Answer::where('question_id', $id)->get();

        return view('admin.questions.show', [   'question'  => $question,
                                                'answers'   => $answers,
                                                'alphabet'  => $alphabet
                                            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $alphabet = array( 'A', 'B', 'C', 'D', 'E',
                       'F', 'g', 'h', 'i', 'j',
                       'k', 'l', 'm', 'n', 'o',
                       'p', 'q', 'r', 's', 't',
                       'u', 'v', 'w', 'x', 'y',
                       'z'
                       );
        $question = Question::find($id);
        $topics = Topic::all();
        $answers = Answer::where('question_id', $id)->get();
              
        $tops = [];
        foreach ($topics as $topic) {
            $tops[$topic->id] = $topic->name;
        }

        return view('admin.questions.edit', [   'question' => $question, 
                                                'topics' => $tops, 
                                                'answers' => $answers,
                                                'alphabet' => $alphabet ]);
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
        $question = Question::find($id); 
        $answers = Answer::where('question_id', $id)->get();
        // Reset all correct answers
        $question->correct_ans = null;
        $correct = $question->correct_ans;

        $request->validate([
            'content' => 'required|min:3',
            'topic_id' => 'required|integer',
            'name.*' => 'required',
            'correct_ans' => 'required|min:1',
        ]);

        $question->content = Purifier::clean($request->content);
        // update all correct answers
        for ($i=0; $i < count($request->correct_ans); $i++) {   
        	$correct[$i] = (int)$request->correct_ans[$i];      	
			$question->correct_ans = $correct;
        }
        $question->save();
        
        $question->topics()->sync($request->topic_id);
        // Update all answers was be change
        $all_ans = $request->answer;
        for($i=0; $i < count($all_ans); $i++){
            $answer = Answer::find($answers[$i]->id);
            if($all_ans[$i] != $answers[$i]->content){
                $answer->content = $all_ans[$i];
                $answer->save();
            }   
        }
        
        Session::flash('success', 'The question was successfully updated!');
        return redirect()->route('questions.show', $question->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::find($id);
        $question->topics()->detach();
        $answers = Answer::where('question_id', $id)->delete();
        $question->delete();

        Session::flash('success', 'The question was successfully deleted!');
        return redirect()->route('questions.index');

    }
}

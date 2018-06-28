<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Topic;
use App\Answer;
use App\User;
use App\Category;
use App\Question;

class QuizController extends Controller
{
	
    public function category($id){
		$topics = Topic::where('category_id', $id)->orderBy('id', 'desc')->select('id', 'name', 'created_at')->get();
        foreach ($topics as $key => $topic) {
            foreach ($topic->users as $user) {
                if(Auth::check() && (Auth::user()->id == $user->pivot->user_id)){
                    $topics[$key]['user'] = $user->pivot->user_id;
                }
            }
        }
		return response()->json($topics);
    }

    public function topic($id){
        $topic = Topic::find($id);
    	$questions = Topic::find($id)->questions()->where('topic_id', $id)->get();
        $alphabet = array( 'A', 'B', 'C', 'D', 'E',
                       'F', 'g', 'h', 'i', 'j',
                       'k', 'l', 'm', 'n', 'o',
                       'p', 'q', 'r', 's', 't',
                       'u', 'v', 'w', 'x', 'y',
                       'z'
                       );
    	$data = [];
    	foreach ($questions as $question) {
    		// $answer = Answer::where('question_id', $question->id)->get();
    		$answers = Question::find($question->id)->answers()->get();

			$data[] = [
				'question' => $question,
				'answer' => $answers,
    		];    		
    	}
    	return view('pages.topic', ['data' => $data, 'alphabet' => $alphabet, 'topic' => $topic]);
    }

    function correct(Request $request){
    	$correctAns = [];
    	$dataRequest = $request->dataRequest;
        $score = 0;
        $total = 0;
        $topic_id = $dataRequest[0]['topic'];
        foreach ($dataRequest as $key => $value) {
            $question = Question::find($value['question_id']);            

            if(isset($value['answer'])){
                $value['answer'] = array_map(function($elem){ return intval($elem); }, $value['answer']);
                if((count($value['answer']) == count($question->correct_ans)) && !array_diff($value['answer'], $question->correct_ans)){
                    $score++;
                    $total += 5;
                    $correctAns[] = [
                        'question_id' => $value['question_id'],
                        'answer_id' => $value['answer'],
                        'answer' => true,
                    ];       
                }else{
                    $correctAns[] = [
                        'question_id' => $value['question_id'],
                        'answer_id' => isset($value['answer']) ? $value['answer'] : -1,
                        'answer' => false,
                        'correct_ans' => $question->correct_ans,
                    ];  
                }
            }else{
                $correctAns[] = [
                    'question_id' => $value['question_id'],
                    'answer_id' => -1,
                    'answer' => false,
                    'correct_ans' => $question->correct_ans,
                ];
            }
    	}

        // Save total
        Auth::user()->topics()->attach($topic_id, ['total' => $total]);

    	$data = [
    		'score' => $score,
            'total' => $total,
    		'correctAns' => $correctAns
    	];

    	return $data;

    }
}

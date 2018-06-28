<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
	protected $table = 'questions';
	protected $casts = [
		'correct_ans' => 'array',
	];

    public function topics(){
    	return $this->belongsToMany(Topic::class);
    }

    public function answers(){
    	// return $this->hasMany('App\Question', 'answers', 'question_id');
    	return $this->hasMany(Answer::class);
    }
}

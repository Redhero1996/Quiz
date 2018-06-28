<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $table = 'topics';

   	public function category(){
   		return $this->belongsTo(Category::class);
   }
   public function questions(){
   		return $this->belongsToMany(Question::class);
   }
   public function users(){
   		return $this->belongsToMany(User::class)->withPivot('total');
   }
}

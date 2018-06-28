<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topic;
use App\Category;

class AjaxSelectController extends Controller
{

    public function selectAjax($category_id){
		$topics = Topic::where('category_id', $category_id)->select('id', 'name')->get();
		return response()->json($topics);
    }
}

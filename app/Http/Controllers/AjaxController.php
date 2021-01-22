<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Webinar;
class AjaxController extends Controller
{

    

    public function submitAddform(Request $request){
    	$str = 0;
        $users = new Webinar();
		$users->name = $request->name;
		/*$users->password = $request->fname." ".$request->lname;
		$users->fname = $request->fname;
		$users->lname = $request->lname;
		$users->phone = $request->phone;
		$users->email = $request->email;*/

		
		if($users->save()){
			$str = 1;
		}
		return $str;
    }
    public function submitDeleteform(Request $request){
    	$str = 0;
        $users = User::find($request->id);
		if($users->delete()){
			$str = 1;
		}
		return $str;
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\CommentModel;
use App\Models\CommentReplyModel;
use Illuminate\Http\Request;

use Session;
use Sentinel;
use Validator;
Use Redirect;



class CommentController extends Controller
{
    public function __construct()
    {
       $this->CommentModel = new CommentModel();
       $this->CommentReplyModel = new CommentReplyModel();
    }
    
    
    public function store(Request $request)
    {

        $arr_rules      = $arr_data = array();

        $arr_rules['_token']                = "required";
        $arr_rules['name']                 = "required";

        $validator = validator::make($request->all(),$arr_rules);

        if($validator->fails()) 
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $arr_data['name']              =   $request->input('name', null); 
        $arr_data['blog_id']              =   $request->input('blog_id', null);
        $arr_data['email']        =   $request->input('email', null); 
        
        $data['status'] = $this->CommentModel->create($arr_data);
        $id = $data['status']->id;

        if($id){
            $arr_data['message']     =   $request->input('message', null);     
            $arr_data['comment_id']  =   $id;     
            $arr_data['blog_id']              =   $request->input('blog_id', null);

            $data['status1'] = $this->CommentReplyModel->create($arr_data);

            if($data['status1']){
                Session::flash('comment_success', 'Your message send successfully');
                return Redirect::back();                
            }
        }

        Session::flash('comment_success', 'Your message send successfully');
        return Redirect::back();
    
    }
    
    public function update_comment(Request $request,$enc_id)
    {
        $arr_rules      = $arr_data = array();

        $arr_rules['_token']                = "required";
        $arr_rules['reply']                 = "required";

        $validator = validator::make($request->all(),$arr_rules);

        if($validator->fails()) 
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $arr_data['reply']              =   $request->input('reply', null); 
        $arr_data['blog_id']              =   $request->input('blog_id', null);
        
        
        $status = $this->CommentModel->where('id',$enc_id)->update($arr_data);

        Session::flash('success', 'Your message send successfully');
        return Redirect::back();
        
        
    }
    
    
    public function new_comment(Request $request)
    {
         $arr_rules      = $arr_data = array();

            $arr_rules['_token']                = "required";
            $arr_rules['message']                 = "required";

            // $validator = validator::make($request->all(),$arr_rules);

            // if($validator->fails()) 
            // {}
            //     return redirect()->back()->withErrors($validator)->withInput();
            // }

            $arr_data['message']     =   $request->input('message_data');     
            $arr_data['comment_id']  =   $request->input('comment_id');          
            $arr_data['blog_id']     =   $request->input('blog_id');
            
            $data['status1'] = $this->CommentReplyModel->create($arr_data);

            
            
            if($data['status1']){
                Session::flash('comment_success', 'Your message send successfully');
                //json_encode($data);
                return Redirect::back();                
            }
      
    }

}

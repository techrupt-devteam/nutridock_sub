<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\BlogModel;
use App\Models\CommentModel;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use \Illuminate\Support\Str;
use \Illuminate\Support\Arr;

use Sentinel;
use Session;
//use Cookie;
use DB;
use Validator;

class BlogController extends Controller
{
    function __construct()
    {   
        $this->arr_view_data                = [];
        $this->module_view_folder           = "admin";
        $this->product_image_base_path      = base_path().'/uploads/images/';
        $this->product_image_public_path    = url('/').config('app.project.img_path.images');
        $this->BlogModel                    = new BlogModel();
        $this->CommentModel                 = new CommentModel();
    }


    public function index()
    {
        $data['seo_title'] = "Blog";
        $arr_data = [];
        $obj_data = $this->BlogModel->orderby('id','DESC')->get();
        if($obj_data)
        {
            $arr_data = $obj_data->toArray();
        }
        $data['arr_data']      = $arr_data;
        /*Category*/
        $cate_data = [];
        $value     = \DB::table('categories')
                        ->orderby('id','ASC')
                        ->get();
        if($value)
        {
            $cate_data = $value->toArray();
        }
        $data['cate_data']      = $cate_data;
        /*Recent Data*/
        $recent_data = [];
        $recent_value     = \DB::table('blog')
                        ->orderby('id','DESC')
                        ->limit(3)
                        ->get();
        if($recent_value)
        {
            $recent_data = $recent_value->toArray();
        }
        $data['recent_data']  = $recent_data;
        
        return view('blog',$data);
    }

    public function blog_detail($enc_id='')
    {
        $data['seo_title'] = "Blog Detail";
        //$id = base64_decode($enc_id);
        
        $str = request()->segment(2);
        
        $string = preg_replace('/[^\p{L}\s0-9]/u',' ',$str);
        
        $arr_data = [];
        $value     = \DB::table('blog')
                        ->where('link',$string)
                        ->get();
        if(!empty($value))
        {
            $arr_data = $value->toArray();
        }
        $data['arr_data']      = $arr_data;
        
        $id='';
        $data['meta_title'] = '';
        $data['meta_keywords'] = '';
        $data['meta_description'] = '';
        foreach($data['arr_data'] as $row){
            $id = $row->id; 
            $data['meta_title'] = $row->meta_title; 
            $data['meta_keywords'] = $row->meta_keywords; 
            $data['meta_description'] = $row->meta_description; 
        }

        /*Benefits*/
        $benefits_data = [];
        $benefits_value     = \DB::table('benefits')
                        ->where('blog_id',$id)
                        ->get();
        if(!empty($benefits_value))
        {
            $benefits_data = $benefits_value->toArray();
        }
        $data['benefits_data']      = $benefits_data;
        /*Random Record*/
        $random_data = [];
        
        if(!empty($random_value))
        {
            $random_data = $random_value->toArray();
        }
        $data['random_data']      = $random_data;

        /*Category*/
        $cate_data = [];
        $value     = \DB::table('categories')
                        ->orderby('id','ASC')
                        ->get();
        if($value)
        {
            $cate_data = $value->toArray();
        }
        $data['cate_data']      = $cate_data;

        /*Comments*/

        /*Category*/
        $row_data = [];
        $row_value     = \DB::table('comments')
                        ->select('id','name','blog_id','email')
                        ->where('blog_id',$id)
                        ->where('status','Active')
                         ->where('is_deleted','No')
                        ->orderby('id','ASC')
                        ->get()->toArray();
        if($row_value)
        {
            $row_data = $row_value;
        }

        $data['row_data']      = $row_data;

        Arr::set($data,'comment',$row_data);
    
       foreach($row_data as $key => $row_data_dtl)
       {
           // $row_dtl_value     = \DB::table('comments_reply')->where('blog_id',$row_data_dtl->blog_id)->where('comment_id',$row_data_dtl->id)->orderby('id','ASC')->get()->toArray();
        
            $row_dtl_value     = \DB::table('comments_reply')->select('*','id AS comment_reply_id')->where('blog_id',$row_data_dtl->blog_id)->where('approve_status','Approve')->where('comment_id',$row_data_dtl->id)->orderby('id','ASC')->get()->toArray();
            Arr::set($data['comment'],$key,$row_dtl_value);
       }
          
       
        $arr_data = [];
        $value     = "SELECT comments_reply.id as comment_reply_id, comments.id as id, comments_reply.created_at as comments_reply_created_at,comments_reply.*,comments.* FROM comments_reply JOIN comments ON comments_reply.comment_id=comments.id group by comments_reply.comment_id";

       
        $data['comment_data'] = \DB::select(DB::raw($value));

        $comment_id='';
        $commentdata = $data['comment_data'];

        if($commentdata)
        {
             foreach ($commentdata as $row) {
            $comment_id = $row->id;
            }
            $max_value  = "SELECT * FROM comments_reply WHERE id=(SELECT MAX(id) FROM comments_reply where comment_id = $comment_id)";
            $data['max_record'] = \DB::select(DB::raw($max_value));
        }

        /*Recent Data*/
        $recent_data = [];
        $recent_value     = \DB::table('blog')
                        ->orderby('id','DESC')
                        ->limit(3)
                        ->get();
        if($recent_value)
        {
            $recent_data = $recent_value->toArray();
        }
        $data['recent_data']  = $recent_data;

        
        return view('blog_detail', compact('id', $id), $data);
    }
}

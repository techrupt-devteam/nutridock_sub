<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Session;
use Sentinel;
use Validator;

class BookingController extends Controller
{
    public function __construct(User $User)
    {
        $data               = [];
        $this->base_model   = '';//$User; 
        $this->title        = "Booking";
        $this->url_slug     = "booking";
        $this->folder_path  = "admin/booking/";
    }

    public function index()
    {
        $arr_data = [];
        $data     = \DB::table('booking')
                        ->where(['status'=>'Paid'])
                        //->where('kyc_document_type','!=',null)
                        ->orderBy('id','DESC')
                        ->get();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'index',$data);
    }
     public function value_add_services()
    {
        $arr_data = [];
        $data     = \DB::table('value_add_services')
                        ->orderBy('id','DESC')
                        ->get();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Value Add Services';
        return view($this->folder_path.'value_add_services',$data);
    }
    public function add_value_add_services(Request $request)
    {
        $car = \DB::table('value_add_services')
                                ->get();
        

        $data['data'] = $car;
        $data['page_name'] = "Add";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Service';
        return view($this->folder_path.'add_value_add_services',$data);
    }
    public function store_value_add_services(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'service_name'=> 'required',
                'service_type' => 'required',
                'price'=> 'required',
                'description'=> 'required',
                'video_link'=> 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        

        $arr_data             = [];
        $arr_data['service_name']     = $request->input('service_name');
        $arr_data['service_type']     = $request->input('service_type');
        $arr_data['price']     = $request->input('price');
        $arr_data['description']     = $request->input('description');
        $arr_data['video_link']     = $request->input('video_link');
        $image = $_FILES["image"]["name"];
        if(empty($image))
        {
            $response            = [];
            $response['status']  = false;
            $response['message'] = "Invalid Parameters.";
            $response['data']    = [];
            print_r(json_encode($response));
            die();  
        }

        if(isset($_FILES["image"]["name"]) && !empty($_FILES["image"]["name"]))
            {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < 18; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
          
                $file_name                         = $_FILES["image"]["name"];
                $file_tmp                          = $_FILES["image"]["tmp_name"];
                $ext                               = pathinfo($file_name,PATHINFO_EXTENSION);
                $random_file_name                  = $randomString.'.'.$ext;
                $latest_image                      = '/admin/upload/value_add_service/'.$random_file_name;

                if(move_uploaded_file($file_tmp,env('BASE_PATH').$latest_image))
                {
                    $arr_data['video_banner']      = $latest_image;
                }
            } 

        $offer             = \DB::table('value_add_services')->insert($arr_data);
        if (!empty($offer))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('admin/value_add_services');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }
    public function edit_value_add_services($id)
    {
        $arr_data = [];
        $arr_data     = \DB::table('value_add_services')->where(['id'=>$id])->first();
      
        

        
        $data['data']      = $arr_data;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Service';

        return view($this->folder_path.'edit_value_add_services',$data);
    }
    public function update_value_add_services(Request $request,$id)
   {
        $validator = Validator::make($request->all(), [
                'service_name'=> 'required',
                'service_type' => 'required',
                'price'=> 'required',
                'description'=> 'required',
                'video_link'=> 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        

        $arr_data             = [];
        $arr_data['service_name']     = $request->input('service_name');
        $arr_data['service_type']     = $request->input('service_type');
        $arr_data['price']     = $request->input('price');
        $arr_data['description']     = $request->input('description');
        $arr_data['video_link']     = $request->input('video_link');
        if(isset($_FILES["image"]["name"]) && !empty($_FILES["image"]["name"]))
            {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < 18; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
          
                $file_name                         = $_FILES["image"]["name"];
                $file_tmp                          = $_FILES["image"]["tmp_name"];
                $ext                               = pathinfo($file_name,PATHINFO_EXTENSION);
                $random_file_name                  = $randomString.'.'.$ext;
                $latest_image                      = '/admin/upload/value_add_service/'.$random_file_name;

                if(move_uploaded_file($file_tmp,env('BASE_PATH').$latest_image))
                {
                    $arr_data['video_banner']      = $latest_image;
                }
            } 
     

        $offers = \DB::table('value_add_services')->where(['id'=>$id])->update($arr_data);

        if (!empty($offers))
        {
            Session::flash('success', 'Success! Record updated successfully.');
            return \Redirect::to('admin/value_add_services');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }
    public function view_value_add_services($id)
    {
        $arr_data = [];

        $data1     = \DB::table('value_add_services')->where(['id'=>$id])->first();


        $data['data']      = $data1;
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Service';
        return view($this->folder_path.'view_value_add_services',$data);
    }
    public function delete_value_add_services($id)
    {
        \DB::table('value_add_services')->where(['id'=>$id])->delete();
        Session::flash('success', 'Success! Record deleted successfully.');
        return \Redirect::back();
    }






    public function nexa_value_add_services()
    {
        $arr_data = [];
        $data     = \DB::table('nexa_value_add_services')
                        ->orderBy('id','DESC')
                        ->get();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Value Add Services';
        return view($this->folder_path.'nexa_value_add_services',$data);
    }
    public function nexa_add_value_add_services(Request $request)
    {
        $car = \DB::table('nexa_value_add_services')
                                ->get();
        

        $data['data'] = $car;
        $data['page_name'] = "Add";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Service';
        return view($this->folder_path.'nexa_add_value_add_services',$data);
    }
    public function nexa_store_value_add_services(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'service_name'=> 'required',
                'service_type' => 'required',
                'price'=> 'required',
                'description'=> 'required',
                'video_link'=> 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        

        $arr_data             = [];
        $arr_data['service_name']     = $request->input('service_name');
        $arr_data['service_type']     = $request->input('service_type');
        $arr_data['price']     = $request->input('price');
        $arr_data['description']     = $request->input('description');
        $arr_data['video_link']     = $request->input('video_link');
        $image = $_FILES["image"]["name"];
        if(empty($image))
        {
            $response            = [];
            $response['status']  = false;
            $response['message'] = "Invalid Parameters.";
            $response['data']    = [];
            print_r(json_encode($response));
            die();  
        }

        if(isset($_FILES["image"]["name"]) && !empty($_FILES["image"]["name"]))
            {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < 18; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
          
                $file_name                         = $_FILES["image"]["name"];
                $file_tmp                          = $_FILES["image"]["tmp_name"];
                $ext                               = pathinfo($file_name,PATHINFO_EXTENSION);
                $random_file_name                  = $randomString.'.'.$ext;
                $latest_image                      = '/admin/upload/value_add_service/'.$random_file_name;

                if(move_uploaded_file($file_tmp,env('BASE_PATH').$latest_image))
                {
                    $arr_data['video_banner']      = $latest_image;
                }
            } 

        $offer             = \DB::table('nexa_value_add_services')->insert($arr_data);
        if (!empty($offer))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('admin/nexa_value_add_services');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }
    public function nexa_edit_value_add_services($id)
    {
        $arr_data = [];
        $arr_data     = \DB::table('nexa_value_add_services')->where(['id'=>$id])->first();
      
        

        
        $data['data']      = $arr_data;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Service';

        return view($this->folder_path.'nexa_edit_value_add_services',$data);
    }
    public function nexa_update_value_add_services(Request $request,$id)
   {
        $validator = Validator::make($request->all(), [
                'service_name'=> 'required',
                'service_type' => 'required',
                'price'=> 'required',
                'description'=> 'required',
                'video_link'=> 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        

        $arr_data             = [];
        $arr_data['service_name']     = $request->input('service_name');
        $arr_data['service_type']     = $request->input('service_type');
        $arr_data['price']     = $request->input('price');
        $arr_data['description']     = $request->input('description');
        $arr_data['video_link']     = $request->input('video_link');
        if(isset($_FILES["image"]["name"]) && !empty($_FILES["image"]["name"]))
            {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < 18; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
          
                $file_name                         = $_FILES["image"]["name"];
                $file_tmp                          = $_FILES["image"]["tmp_name"];
                $ext                               = pathinfo($file_name,PATHINFO_EXTENSION);
                $random_file_name                  = $randomString.'.'.$ext;
                $latest_image                      = '/admin/upload/value_add_service/'.$random_file_name;

                if(move_uploaded_file($file_tmp,env('BASE_PATH').$latest_image))
                {
                    $arr_data['video_banner']      = $latest_image;
                }
            } 
     

        $offers = \DB::table('nexa_value_add_services')->where(['id'=>$id])->update($arr_data);

        if (!empty($offers))
        {
            Session::flash('success', 'Success! Record updated successfully.');
            return \Redirect::to('admin/nexa_value_add_services');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }
    public function nexa_view_value_add_services($id)
    {
        $arr_data = [];

        $data1     = \DB::table('nexa_value_add_services')->where(['id'=>$id])->first();


        $data['data']      = $data1;
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Service';
        return view($this->folder_path.'nexa_view_value_add_services',$data);
    }
    public function nexa_delete_value_add_services($id)
    {
        \DB::table('nexa_value_add_services')->where(['id'=>$id])->delete();
        Session::flash('success', 'Success! Record deleted successfully.');
        return \Redirect::back();
    }

    public function offers()
    {
        $arr_data = [];
        $data     = \DB::table('offers')
                        ->get();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Offer';
        return view($this->folder_path.'offers',$data);
    }
    public function nexa_offers()
    {
        $arr_data = [];
        $data     = \DB::table('nexa_offers')
                        ->get();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Offer';
        return view($this->folder_path.'nexa_offers',$data);
    }
    public function nexa_home_banner()
    {
        $arr_data = [];
        $data     = \DB::table('nexa_home_banner')
                        ->get();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Home Banner';
        return view($this->folder_path.'nexa_home_banner',$data);
    }
    public function comm_home_banner()
    {
        $arr_data = [];
        $data     = \DB::table('comm_home_banner')
                        ->get();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Home Banner';
        return view($this->folder_path.'comm_home_banner',$data);
    }
    public function commercial_offers()
    {
        $arr_data = [];
        $data     = \DB::table('commercial_offers')
                        ->get();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Offer';
        return view($this->folder_path.'commercial_offers',$data);
    }
    public function offer_enquiry()
    {
        $arr_data = [];
        $data     = \DB::table('offer_enquiries')
                        ->get();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Offer';
        return view($this->folder_path.'offer_enquiries',$data);
    }
    public function nexa_offer_enquiry()
    {
        $arr_data = [];
        $data     = \DB::table('nexa_offer_enquiries')
                        ->get();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Offer';
        return view($this->folder_path.'nexa_offer_enquiry',$data);
    }
    public function commercial_offer_enquiry()
    {
        $arr_data = [];
        $data     = \DB::table('commercial_offer_enquiries')
                        ->get();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Offer';
        return view($this->folder_path.'commercial_offer_enquiry',$data);
    }
    public function book_you_service()
    {
        $arr_data = [];
        $data= $this->get_list('book_your_service','yes');
        //dd($data);
        /*$data     = \DB::table('book_your_service')
                        //->where('kyc_document_type','!=',null)
                        ->orderBy('id','DESC')
                        ->get();*/

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Services';
        return view($this->folder_path.'book_your_service',$data);
    }
    public function booked_value_added_services()
    {
        $arr_data = [];
        /*$data     = \DB::table('scheduled_value_added_service')
                        //->where('kyc_document_type','!=',null)
                        ->orderBy('id','DESC')
                        ->get();*/
        $data =$this->get_list('scheduled_value_added_service','yes');

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Value Added Services';
        return view($this->folder_path.'scheduled_value_added_service',$data);
    }

    public function nexa_booked_value_added_services()
    {
        $arr_data = [];
/*        $data     = \DB::table('nexa_scheduled_value_added_service')
                        //->where('kyc_document_type','!=',null)
                        ->orderBy('id','DESC')
                        ->get();
*/
         $data =$this->get_list('scheduled_value_added_service','yes');

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Value Added Services';
        return view($this->folder_path.'nexa_scheduled_value_added_service',$data);
    }

    public function test_drive()
    {
        $arr_data = [];
        /*$data     = \DB::table('test_drive')
                        //->where('kyc_document_type','!=',null)
                        ->orderBy('id','DESC')
                        ->get();
        */
        $data = $this->get_list('test_drive');
        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Test Drives';
        return view($this->folder_path.'test_drive',$data);
    }
    
    public function quotations()
    {
        $arr_data = [];
        $data     = \DB::table('quotations')
                        //->where('kyc_document_type','!=',null)
                        ->orderBy('id','DESC')
                        ->get();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Quotations';
        return view($this->folder_path.'quotations',$data);
    }
    
    public function finance()
    {
        $arr_data = [];
       /*$data     = \DB::table('finance')
                        //->where('kyc_document_type','!=',null)
                        ->orderBy('id','DESC')
                        ->get();*/
        $data = $this->get_list('finance');               

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Finance';
        return view($this->folder_path.'finance',$data);
    }

    public function insurance()
    {
        $arr_data = [];
        /*$data     = \DB::table('insurance')
                        //->where('kyc_document_type','!=',null)
                        ->orderBy('id','DESC')
                        ->get();*/
        $data = $this->get_list('insurance');
        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Insurance';
        return view($this->folder_path.'insurance',$data);
    }
    public function enquiry()
    {
        $arr_data = [];
        $data     = \DB::table('enquiries')
                        //->where('kyc_document_type','!=',null)
                        ->orderBy('id','DESC')
                        ->get();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Enquiry';
        return view($this->folder_path.'enquiry',$data);
    }
    
    public function manage_nexa_booking()
    {
        $arr_data = [];
        $data     = \DB::table('nexa_booking')
                        ->where(['status'=>'Paid'])
                        //->where('kyc_document_type','!=',null)
                        ->orderBy('id','DESC')
                        ->get();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = 'nexa_booking';
        $data['title']     = 'Booking';
        return view($this->folder_path.'nexa_booking',$data);
    } 

    public function nexa_showroom_visits()
    {
        $arr_data = [];
        $data     = \DB::table('nexa_showroom_visits')
                        //->where('kyc_document_type','!=',null)
                        ->orderBy('id','DESC')
                        ->get();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = 'nexa_booking';
        $data['title']     = 'Showroom visits';
        return view($this->folder_path.'nexa_showroom_visitsss',$data);
    } 

    public function nexa_book_you_service()
    {
        $arr_data = [];
       /* $data     = \DB::table('nexa_book_your_service')
                        //->where('kyc_document_type','!=',null)
                        ->orderBy('id','DESC')
                        ->get();*/
        $data= $this->get_list('nexa_book_your_service','yes');

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Services';
        return view($this->folder_path.'nexa_book_your_service',$data);
    }

    public function nexa_test_drive()
    {
        $arr_data = [];
        /*$data     = \DB::table('nexa_test_drive')
                        ->orderBy('id','DESC')
                        ->get();*/
        $data = $this->get_list('nexa_test_drive');

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Test Drives';
        return view($this->folder_path.'nexa_test_drive',$data);
    }
    public function nexa_quotations()
    {
        $arr_data = [];
        $data     = \DB::table('nexa_quotations')
                        //->where('kyc_document_type','!=',null)
                        ->orderBy('id','DESC')
                        ->get();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Quotations';
        return view($this->folder_path.'nexa_quotations',$data);
    }
    public function nexa_insurance()
    {
        $arr_data = [];
        /*$data     = \DB::table('nexa_insurance')
                        //->where('kyc_document_type','!=',null)
                        ->orderBy('id','DESC')
                        ->get();*/
        $data = $this->get_list('nexa_insurance');


        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Insurance';
        return view($this->folder_path.'nexa_insurance',$data);
    }

    public function nexa_finance()
    {
        $arr_data = [];
       /* $data     = \DB::table('nexa_finance')
                        //->where('kyc_document_type','!=',null)
                        ->orderBy('id','DESC')
                        ->get();*/
         $data = $this->get_list('nexa_finance');

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Finance';
        return view($this->folder_path.'nexa_finance',$data);
    }
    public function nexa_feedback()
    {
        $arr_data = [];
        $data     = \DB::table('nexa_feedback')
                        //->where('kyc_document_type','!=',null)
                        ->orderBy('id','DESC')
                        ->get();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Feedback';
        return view($this->folder_path.'nexa_feedback',$data);
    }

    public function nexa_enquiry()
    {
        $arr_data = [];
        $data     = \DB::table('nexa_enquiries')
                        //->where('kyc_document_type','!=',null)
                        ->orderBy('id','DESC')
                        ->get();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Enquiry';
        return view($this->folder_path.'nexa_enquiries',$data);
    }

    public function manage_commercial_booking()
    {
        $arr_data = [];
        $data     = \DB::table('commercial_booking')
                        ->where(['status'=>'Paid'])
                        //->where('kyc_document_type','!=',null)
                        ->orderBy('id','DESC')
                        ->get();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Booking';
        return view($this->folder_path.'commercial_booking',$data);
    } 

    public function commercial_book_you_service()
    {
        $arr_data = [];
       /* $data     = \DB::table('commercial_book_your_service')
                        //->where('kyc_document_type','!=',null)
                        ->orderBy('id','DESC')
                        ->get();*/
        $data= $this->get_list('commercial_book_your_service','yes');

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Services';
        return view($this->folder_path.'commercial_book_you_service',$data);
    }

    public function commercial_showroom_visits()
    {
        $arr_data = [];
        /*$data     = \DB::table('commercial_showroom_visits')
                        //->where('kyc_document_type','!=',null)
                        ->orderBy('id','DESC')
                        ->get();
                        // dd($data);*/

        $session_user = Session::get('user');
        if($session_user->role!='admin'){ 
            $city = $session_user->city;
            $area1 = $session_user->area;
            $data = \DB::table('commercial_showroom_visits')
                 ->where(['client_city'=>$city,'area'=>$area1])
                 ->orderBy('id','DESC')
                 ->get();
        }
        elseif($session_user->role=='admin')
        {
            $data = \DB::table('commercial_showroom_visits')->orderBy('id','DESC')->get();
        }
        


        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Appointments';
        return view($this->folder_path.'commercial_showroom_visits',$data);
    }

public function commercial_feedback()
    {
        $arr_data = [];
        $data     = \DB::table('commercial_feedback')
                        //->where('kyc_document_type','!=',null)
                        ->orderBy('id','DESC')
                        ->get();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Feedback';
        return view($this->folder_path.'commercial_feedback',$data);
    }
    public function commercial_enquiry()
    {
        $arr_data = [];
        $data     = \DB::table('commercial_enquiries')
                        //->where('kyc_document_type','!=',null)
                        ->orderBy('id','DESC')
                        ->get();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Enquiry';
        return view($this->folder_path.'commercial_enquiries',$data);
    }
     public function download_bookings(Request $request)
    {
        $data     = \DB::table('booking')
                        ->where(['status'=>'Paid'])
                        //->where('kyc_document_type','!=',null)
                        ->orderBy('id','DESC')
                        ->get();

        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=Booking.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
          
          echo "Sr. No.";
          echo ',';
          echo "Full Name";
          echo ',';
          echo "Email";
          echo ',';
          echo "Mobile No.";
          echo ',';
          echo "City";
          echo ',';
          echo "Address";
          echo ',';
          echo "Car";
          echo ',';
          echo "Variant";
          echo ',';
          echo "Color";
          echo ',';
          echo "On Road Cost";
          echo ',';
          echo "Any Spacial Request";
          echo ',';
          echo "Do you Require Finance";
          echo ',';
          echo "Booking Date";
          echo ',';
          echo "Transation";
          echo ',';
          echo "Amount";
          echo ',';
          echo "\n"; 
        foreach ($data as $key => $value) 
        {
              echo $key+1;
              echo ',';
              echo $value->name;
              echo ',';
              echo $value->email;
              echo ',';
              echo $value->mobile;
              echo ',';
              echo $value->city;
              echo ',';
              echo str_replace(",","",$value->address);
              echo ',';
              echo $value->car;
              echo ',';
              echo $value->varient;
              echo ',';
              echo $value->color;
              echo ',';
              echo $value->road_cost;
              echo ',';
              echo $value->special_request;
              echo ',';
              echo $value->finance;
              echo ',';
              echo $value->date;
              echo ',';
              echo $value->transaction_id;
              echo ',';
              echo $value->amount;
              echo ',';
              echo "\n";
        }
        //print_r($data);
        die;
    }
    //seva book your services   
    public function download_services(Request $request)
    {
       
        $data     = \DB::table('book_your_service')
                        ->orderBy('id','DESC')
                        ->get();

        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=Seva-Book-Your-Services".Date('d-m-Y').".csv");
        header("Pragma: no-cache");
        header("Expires: 0");
          
          echo "Sr. No.";
          echo ',';
          echo "Full Name";
          echo ',';
          echo "Email";
          echo ',';
          echo "Mobile No.";
          echo ',';
          echo "Service Date";
          echo ',';
          echo "Service Type";
          echo ',';
          echo "City";
          echo ',';
          echo "Area";
          echo ',';
          echo "Time";
          echo ',';
          echo "Car No";
          echo ',';
          echo "Pickyup";
          echo ',';
          echo "Pincode";
          echo ',';
          echo "Message";
          echo ',';
          echo "Create Date";
          echo ',';
          echo "\n";
          foreach ($data as $key => $value) 
          {
            
              echo $key+1;
              echo ',';
              echo $value->name;
              echo ',';
              echo $value->email;
              echo ',';
              echo $value->mobile_no;
              echo ',';
              echo $value->service_date;
              echo ',';
              echo $value->service;
              echo ',';
              echo $value->city;
              echo ',';     
              echo $value->area;
              echo ',';
              echo $value->time;
              echo ',';
              echo $value->car_no;
              echo ',';
              echo $value->pickup;
              echo ',';
              echo $value->pincode;
              echo ',';
              echo $value->message;
              echo ',';
              echo $value->created_at;
              echo ',';
              echo "\n";
         }
        //print_r($data);
        die;
    }

    //nexa book your services csv 
    public function nexa_download_services(Request $request)
    {
        $data     = \DB::table('nexa_book_your_service')
                    ->orderBy('id','DESC')
                    ->get();

        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=Nexa-Book-Your-Services".Date('d-m-Y').".csv");
        header("Pragma: no-cache");
        header("Expires: 0");
          
          echo "Sr. No.";
          echo ',';
          echo "Full Name";
          echo ',';
          echo "Email";
          echo ',';
          echo "Mobile No.";
          echo ',';
          echo "Service Date";
          echo ',';
          echo "Service Type";
          echo ',';
          echo "City";
          echo ',';
          echo "Area";
          echo ',';
          echo "Time";
          echo ',';
          echo "Car No";
          echo ',';
          echo "Pickyup";
          echo ',';
          echo "Pincode";
          echo ',';
          echo "Message";
          echo ',';
          echo "Create Date";
          echo ',';
          echo "\n";
          foreach ($data as $key => $value) 
          {
            
              echo $key+1;
              echo ',';
              echo $value->name;
              echo ',';
             echo $value->email;
              echo ',';
              echo $value->mobile_no;
              echo ',';
              echo $value->service_date;
              echo ',';
              echo $value->service;
              echo ',';
              echo $value->city;
              echo ',';     
              echo $value->area;
              echo ',';
              echo $value->time;
              echo ',';
              echo $value->car_no;
              echo ',';
              echo $value->pickup;
              echo ',';
              echo $value->address;
              echo ',';
              echo $value->message;
              echo ',';
              echo $value->created_at;
              echo ',';
              echo "\n";
         }
        //print_r($data);
        die;
    }
    
    //commercial book your services csv 
        public function commercial_download_services(Request $request)
        {
            $data     = \DB::table('commercial_book_your_service')
                        ->orderBy('id','DESC')
                        ->get();

            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=commercial-Book-Your-Services".Date('d-m-Y').".csv");
            header("Pragma: no-cache");
            header("Expires: 0");
              
              echo "Sr. No.";
              echo ',';
              echo "Full Name";
              echo ',';
              echo "Email";
              echo ',';
              echo "Mobile No.";
              echo ',';
              echo "Service Date";
              echo ',';
              echo "Service Type";
              echo ',';
              echo "City";
              echo ',';
              echo "Area";
              echo ',';
              echo "Time";
              echo ',';
              echo "Car No";
              echo ',';
            /*  echo "Pickyup";
              echo ',';*/
            /*  echo "Pincode";
              echo ',';*/
              echo "Message";
              echo ',';
              echo "Create Date";
              echo ',';
              echo "\n";
              foreach ($data as $key => $value) 
              {
                
                  echo $key+1;
                  echo ',';
                  echo $value->name;
                  echo ',';
                  echo $value->email;
                  echo ',';
                  echo $value->mobile_no;
                  echo ',';
                  echo $value->service_date;
                  echo ',';
                 echo $value->service;
                  echo ',';
                  echo $value->city;
                  echo ',';     
                  echo $value->area;
                  echo ',';
                  echo $value->time;
                  echo ',';
                  echo $value->car_no;
                  echo ',';
                  /*echo $value->pickup;
                  echo ',';*/
          
                  echo $value->message;
                  echo ',';
                  echo $value->created_at;
                  echo ',';
                  echo "\n";
             }
            //print_r($data);
            die;
        }



    // 
    public function nexa_download_bookings(Request $request)
    {
        $data     = \DB::table('nexa_booking')
                        ->where(['status'=>'Paid'])
                        //->where('kyc_document_type','!=',null)
                        ->orderBy('id','DESC')
                        ->get();
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=Nexa_booking.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
          
          echo "Sr. No.";
          echo ',';
          echo "Full Name";
          echo ',';
          echo "Email";
          echo ',';
          echo "Mobile No.";
          echo ',';
          echo "City";
          echo ',';
          echo "Address";
          echo ',';
          echo "Car";
          echo ',';
          echo "Variant";
          echo ',';
          echo "Color";
          echo ',';
          echo "On Road Cost";
          echo ',';
          echo "Any Spacial Request";
          echo ',';
          echo "Do you Require Finance";
          echo ',';
          echo "Booking Date";
          echo ',';
          echo "Transation";
          echo ',';
          echo "Amount";
          echo ',';
          echo "\n"; 
        foreach ($data as $key => $value) 
        {
              echo $key+1;
              echo ',';
              echo $value->name;
              echo ',';
              echo $value->email;
              echo ',';
              echo $value->mobile;
              echo ',';
              echo $value->city;
              echo ',';
              echo str_replace(",","",$value->address);
              echo ',';
              echo $value->car;
              echo ',';
              echo $value->varient;
              echo ',';
              echo $value->color;
              echo ',';
              echo str_replace(",","",$value->road_cost);
              echo ',';
              echo $value->special_request;
              echo ',';
              echo $value->finance;
              echo ',';
              echo $value->date;
              echo ',';
              echo $value->transaction_id;
              echo ',';
              echo $value->amount;
              echo ',';
              echo "\n";
        }
        //print_r($data);
        die;
    }

    public function commercial_download_bookings(Request $request)
    {
        $data     = \DB::table('commercial_booking')
                        ->where(['status'=>'Paid'])
                        //->where('kyc_document_type','!=',null)
                        ->orderBy('id','DESC')
                        ->get();
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=Commercial_Booking.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
          
          echo "Sr. No.";
          echo ',';
          echo "Full Name";
          echo ',';
          echo "Email";
          echo ',';
          echo "Mobile No.";
          echo ',';
          echo "City";
          echo ',';
          echo "Address";
          echo ',';
          echo "Car";
          echo ',';
          echo "Variant";
          echo ',';
          echo "Color";
          echo ',';
          echo "On Road Cost";
          echo ',';
          echo "Any Spacial Request";
          echo ',';
          echo "Do you Require Finance";
          echo ',';
          echo "Booking Date";
          echo ',';
          echo "Transation";
          echo ',';
          echo "Amount";
          echo ',';
          echo "\n"; 
        foreach ($data as $key => $value) 
        {
              echo $key+1;
              echo ',';
              echo $value->name;
              echo ',';
              echo $value->email;
              echo ',';
              echo $value->mobile;
              echo ',';
              echo $value->city;
              echo ',';
              echo str_replace(",","",$value->address);
              echo ',';
              echo $value->car;
              echo ',';
              echo $value->varient;
              echo ',';
              echo $value->color;
              echo ',';
              echo $value->road_cost;
              echo ',';
              echo $value->special_request;
              echo ',';
              echo $value->finance;
              echo ',';
              echo $value->date;
              echo ',';
              echo $value->transaction_id;
              echo ',';
              echo $value->amount;
              echo ',';
              echo "\n";
        }
        //print_r($data);
        die;
    }

    public function download_nexa_showroom_visits(Request $request)
    {
       $data     = \DB::table('nexa_showroom_visits')
                        //->where('kyc_document_type','!=',null)
                        ->orderBy('id','DESC')
                        ->get();
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=Nexa_Showroom_Visits.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
          
          echo "Sr. No.";
          echo ',';
          echo "Full Name";
          echo ',';
          echo "Mobile No.";
          echo ',';
          echo "City";
          echo ',';
          echo "Date";
          echo ',';
          echo "Time";
          echo ',';
          echo "\n"; 
        foreach ($data as $key => $value) 
        {
              echo $key+1;
              echo ',';
              echo $value->full_name;
              echo ',';
              echo $value->phone_no;
              echo ',';
              echo $value->client_city;
              echo ',';
              echo $value->date;
              echo ',';
              echo $value->time;
              echo ',';
              echo "\n";
        }
        //print_r($data);
        die;
    } 

    public function download_commercial_showroom_visits(Request $request)
    {
       $data     = \DB::table('commercial_showroom_visits')
                        //->where('kyc_document_type','!=',null)
                        ->orderBy('id','DESC')
                        ->get();
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=Commercial_showroom_visits.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
          
          echo "Sr. No.";
          echo ',';
          echo "Full Name";
          echo ',';
          echo "Mobile No.";
          echo ',';
          echo "City";
          echo ',';
          echo "Date";
          echo ',';
          echo "Time";
          echo ',';
          echo "\n"; 
        foreach ($data as $key => $value) 
        {
              echo $key+1;
              echo ',';
              echo $value->full_name;
              echo ',';
              echo $value->phone_no;
              echo ',';
              echo $value->client_city;
              echo ',';
              echo $value->date;
              echo ',';
              echo $value->time;
              echo ',';
              echo "\n";
        }
        //print_r($data);
        die;
    } 
    


    public function active_store($id)
    {
        $product = $this->base_model->where('id','=',$id)->first();
        if($product->active=='1')
        {
            $this->base_model->where('id','=',$id)->update(['active'=>'0']);
            Session::flash('success', 'Success! Store deactivated successfully.');
        }
        else
        {
            $this->base_model->where('id','=',$id)->update(['active'=>'1']);
            Session::flash('success', 'Success! Store activated successfully.');
        }
            return \Redirect::to('admin/manage_store');
    }

    public function delivery_index()
    {
        $arr_data = [];
        $login_user_details  = Session::get('user');
        $data     = $this->base_model->where(['role'=>'Delivery Boy']);
                        //->where('kyc_document_type','!=',null)
        
        if($login_user_details->role=='Store')
            {
                $data     = $data->where(['store_id'=>$login_user_details->id]);
            }
        $data     = $data->orderBy('id','DESC');
        $data     = $data->get();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

         

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Delivery Boy';
        return view($this->folder_path.'delivery_index',$data);
    }

    public function store_index()
    {
        $arr_data = [];
        $data     = $this->base_model->where(['role'=>'Store'])
                        ->orderBy('id','DESC')
                        ->get();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = 'store';
        $data['title']     = 'Stores';
        return view($this->folder_path.'store_index',$data);
    }
 
    public function add()
    {
        $data['page_name']       = "Add";
        $data['title']           = $this->title;
        $data['url_slug']        = $this->url_slug;
        $data['state']           = \DB::table('pincode_with_area')->groupBy('state')->get();
        $data['vendor_category'] = \DB::table('vendor_category')->groupBy('vendor_category')->where('deleted_at','=',null)->get();
        return view($this->folder_path.'add',$data);
    }

    public function deliverty_boy_add()
    {
        $data['page_name']       = "Add";
        $data['title']           = 'Delivery Boy';
        $data['url_slug']        = $this->url_slug;
        $data['state']           = [];//\DB::table('pincode_with_area')->groupBy('state')->get();
        $data['vendor_category'] = \DB::table('vendor_category')->groupBy('vendor_category')->where('deleted_at','=',null)->get();
        return view($this->folder_path.'deliverty_boy_add',$data);
    }

    public function store_add()
    {
        $data['page_name']       = "Add";
        $data['title']           = 'Store';
        $data['url_slug']        = $this->url_slug;
        $data['state']           = [];//\DB::table('pincode_with_area')->groupBy('state')->get();
        $data['vendor_category'] = \DB::table('vendor_category')->groupBy('vendor_category')->where('deleted_at','=',null)->get();
        return view($this->folder_path.'store_add',$data);
    }

    public function store(Request $request)
    {
        $validator          = Validator::make($request->all(), [
            'first_name'        => 'required',
            'last_name'         => 'required',
            'mobile_no'         => 'required',
            'email'             => 'required',
            'password'          => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        $is_exist = $this->base_model->where(['email'=>$request->input('email')])->count();

        if($is_exist)
        {
            Session::flash('first_name', $request->input('first_name'));
            Session::flash('last_name', $request->input('last_name'));
            Session::flash('mobile_no', $request->input('mobile_no'));
            Session::flash('email', $request->input('email'));
            Session::flash('password', $request->input('password'));
            Session::flash('error', "User already exist!");
            return \Redirect::back();
        }

        $is_exist = $this->base_model->where(['mobile_no'=>$request->input('mobile_no')])->count();

        if($is_exist)
        {
            Session::flash('first_name', $request->input('first_name'));
            Session::flash('last_name', $request->input('last_name'));
            Session::flash('mobile_no', $request->input('mobile_no'));
            Session::flash('email', $request->input('email'));
            Session::flash('password', $request->input('password'));

            Session::flash('error', "User already exist!");
            return \Redirect::back();
        }

        $image = $_FILES["upload_pan"]["name"];
        if(empty($image))
        {
            Session::flash('error', "Please upload image.");
            return \Redirect::back();
        }


        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 18; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
  
        $file_name                         = $_FILES["upload_pan"]["name"];
        $file_tmp                          = $_FILES["upload_pan"]["tmp_name"];
        $ext                               = pathinfo($file_name,PATHINFO_EXTENSION);
        $random_file_name                  = $randomString.'.'.$ext;
        $latest_image                      = 'upload/profile/'.$random_file_name;

        $image1 = $_FILES["kyc_document"]["name"];
        if(empty($image1))
        {
            Session::flash('error', "Please upload image.");
            return \Redirect::back();
        }
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i <   18; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
  
        $file_name1                         = $_FILES["kyc_document"]["name"];
        $file_tmp1                          = $_FILES["kyc_document"]["tmp_name"];
        $ext1                               = pathinfo($file_name1,PATHINFO_EXTENSION);
        $random_file_name1                  = '2'.$randomString.'.'.$ext1;
        $latest_image1                      = 'upload/profile/'.$random_file_name1;

        if(move_uploaded_file($file_tmp,env('BASE_PATH').$latest_image)  && move_uploaded_file($file_tmp1,env('BASE_PATH').$latest_image1))
        {
            $arr_data                       = [];
            $arr_data['first_name']         = $request->input('first_name');
            $arr_data['last_name']          = $request->input('last_name');
            $arr_data['mobile_no']          = $request->input('mobile_no');
            $arr_data['email']              = $request->input('email');
            $arr_data['password']           = $request->input('password');
            $arr_data['company_name']       = $request->input('company_name');
            $arr_data['company_address']    = $request->input('company_address');
            $arr_data['state']              = $request->input('state');
            $arr_data['city']               = $request->input('city');
            $arr_data['pincode']            = $request->input('pincode');
            $arr_data['gst_no']             = $request->input('gst_no');
            $arr_data['pan_number']         = $request->input('pan_number');
            $arr_data['upload_pan']         = $latest_image;
            $arr_data['kyc_document_type']  = $request->input('kyc_document_type');
            $arr_data['kyc_document']       = $latest_image1;
            $arr_data['vendor_category_id'] = $request->input('vendor_category_id');
           
            $arr_data['status']             = 'Approved';
            $arr_data['role']               = 'user';
            
            $status = $this->base_model->create($arr_data);
            if (!empty($status))
            {
                $mail = new PHPMailer(true); 
                try 
                {
                    $html = 'Dear '.$arr_data['first_name'].' '.$arr_data['last_name'].', <br>
                                Thank you for Signing Up with Kores India Mobile Application.<br>
                                This online platform gives you quick purchase options with benefits and saving on your purchase.<br>
                                Looking forward to on-board you to Kores Family.<br>
                                Regards,<br>
                                Team Kores';

                    $mail->isSMTP(); 
                    $mail->CharSet    = "utf-8";
                    $mail->SMTPAuth   = true;
                    $mail->SMTPSecure = env('SMTPSECURE');
                    $mail->Host       = env('HOST');
                    $mail->Port       = env('PORT');
                    $mail->Username   = env('USERNAME');
                    $mail->Password   = env('PASSWORD');
                    $mail->Subject    = "Welcome to Kores";
                    $mail->setFrom(env('SETFROMEMAIL'), env('SETFROMNAME'));
                    $mail->MsgHTML($html);
                    $mail->addAddress($arr_data['email'], $arr_data['first_name']);
                    $mail->send();
                } 
                catch (phpmailerException $e) 
                {
                    Session::flash('error', 'Internal Server Issue.'.$e);
                return \Redirect::back();
                } 
                catch (Exception $e) 
                {
                    Session::flash('error', 'Internal Server Issue.'.$e);
                return \Redirect::back();  
                }
                Session::flash('success', 'Success! Record added successfully.');
                return \Redirect::to('admin/manage_user');
            }
            else
            {
                Session::flash('error', "Error! Oop's something went wrong.");
                return \Redirect::back();
            }
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }

    public function deliverty_boy_store(Request $request)
    {
        $validator          = Validator::make($request->all(), [
            'first_name'        => 'required',
            'last_name'         => 'required',
            'mobile_no'         => 'required',
            'email'             => 'required',
            'password'          => 'required',
        
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        $is_exist = $this->base_model->where(['email'=>$request->input('email')])->count();

        if($is_exist)
        {
            Session::flash('first_name', $request->input('first_name'));
            Session::flash('last_name', $request->input('last_name'));
            Session::flash('mobile_no', $request->input('mobile_no'));
            Session::flash('email', $request->input('email'));
            Session::flash('password', $request->input('password'));
        
            Session::flash('error', "User already exist!");
            return \Redirect::back();
        }

        $is_exist = $this->base_model->where(['mobile_no'=>$request->input('mobile_no')])->count();

        if($is_exist)
        {
            Session::flash('first_name', $request->input('first_name'));
            Session::flash('last_name', $request->input('last_name'));
            Session::flash('mobile_no', $request->input('mobile_no'));
            Session::flash('email', $request->input('email'));
            Session::flash('password', $request->input('password'));
          

            Session::flash('error', "User already exist!");
            return \Redirect::back();
        }
        $login_user_details  = Session::get('user');
            $arr_data                       = [];
            $arr_data['first_name']         = $request->input('first_name');
            $arr_data['last_name']          = $request->input('last_name');
            $arr_data['mobile_no']          = $request->input('mobile_no');
            $arr_data['email']              = $request->input('email');
            $arr_data['password']           = base64_encode($request->input('password'));
            $arr_data['store_id']           = $login_user_details->id;
           
            $arr_data['role']               = 'Delivery Boy';
            //dd($arr_data);
            $status = $this->base_model->create($arr_data);
            if (!empty($status))
            {
                
                Session::flash('success', 'Success! Record added successfully.');
                return \Redirect::to('admin/manage_delivery_boy');
            }
            else
            {
                Session::flash('error', "Error! Oop's something went wrong.");
                return \Redirect::back();
            }
    }

    public function store_store(Request $request)
    {
        $validator          = Validator::make($request->all(), [
            'store_name'        => 'required',
            'min_order_value'   => 'required',
            'delivery_fees'     => 'required',
            'mobile_no'         => 'required',
            'email'             => 'required',
            'password'          => 'required',
        
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        $is_exist = $this->base_model->where(['email'=>$request->input('email')])->count();

        if($is_exist)
        {
            Session::flash('store_name', $request->input('store_name'));
            Session::flash('min_order_value', $request->input('min_order_value'));
            Session::flash('delivery_fees', $request->input('delivery_fees'));
            Session::flash('mobile_no', $request->input('mobile_no'));
            Session::flash('email', $request->input('email'));
            Session::flash('password', $request->input('password'));
        
            Session::flash('error', "User already exist!");
            return \Redirect::back();
        }

        $is_exist = $this->base_model->where(['mobile_no'=>$request->input('mobile_no')])->count();

        if($is_exist)
        {
            Session::flash('store_name', $request->input('store_name'));
            Session::flash('min_order_value', $request->input('min_order_value'));
            Session::flash('delivery_fees', $request->input('delivery_fees'));
            Session::flash('mobile_no', $request->input('mobile_no'));
            Session::flash('email', $request->input('email'));
            Session::flash('password', $request->input('password'));

            Session::flash('error', "User already exist!");
            return \Redirect::back();
        }

        $credentials = [
                'email'    => $request->input('email'),
                'password' => $request->input('password'),
            ];

            $user = Sentinel::registerAndActivate($credentials);
            $arr_data                    = [];
            $arr_data['store_name']      = $request->input('store_name');
            $arr_data['min_order_value'] = $request->input('min_order_value');
            $arr_data['delivery_fees']   = $request->input('delivery_fees');
            $arr_data['mobile_no']       = $request->input('mobile_no');
            $arr_data['delivery_schedule']       = $request->input('delivery_schedule');

            $arr_data['role']            = 'Store';

            
            $status = $this->base_model->where(['id'=>$user->id])->update($arr_data);
            $status = \DB::table('activations')->where(['user_id'=>$user->id])->update(['completed_at'=>'1','completed'=>'1']);
            if (!empty($status))
            {
                
                Session::flash('success', 'Success! Record added successfully.');
                return \Redirect::to('admin/manage_store');
            }
            else
            {
                Session::flash('error', "Error! Oop's something went wrong.");
                return \Redirect::back();
            }
    }

    public function approve_user(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
                'status'        => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        $arr_data                  = [];
        if($request->input('status')=='Approved')
        {
            $data = $this->base_model->where(['id'=>$id])->first();

            $arr_data['sales_member']           = $request->input('sales_member');
            $arr_data['admin_approval']         = $request->input('status');
            $arr_data['vendor_category_id']     = $request->input('vendor_category_id');
            $arr_data['company_code']           = $request->input('company_code');
            $arr_data['sales_organization']     = $request->input('sales_organization');
            $arr_data['distribution_channel']   = $request->input('distribution_channel');
            $arr_data['division']               = $request->input('division');
            $arr_data['customer_account_group'] = $request->input('customer_account_group');
            $arr_data['language_key']                               = $request->input('language_key');
            $arr_data['reg_str_grp']                                = $request->input('reg_str_grp');
            $arr_data['excise_ind_customer']                        = $request->input('excise_ind_customer');
            $arr_data['cst_no']                                     = $request->input('cst_no');
            $arr_data['reconcilliation_account']                    = $request->input('reconcilliation_account');
            $arr_data['sort_key']                                   = $request->input('sort_key');
            $arr_data['cash_management_group']                      = $request->input('cash_management_group');
            $arr_data['indicator_record_payment_history']           = $request->input('indicator_record_payment_history');
            $arr_data['payment_methods']                            = $request->input('payment_methods');
            $arr_data['sale_district']                              = $request->input('sale_district');
            $arr_data['sales_office_branch_code']                   = $request->input('sales_office_branch_code');
            $arr_data['customer_group']                             = $request->input('customer_group');
            $arr_data['abc_class']                                  = $request->input('abc_class');
            $arr_data['currency']                                   = $request->input('currency');
            $arr_data['pricing_group']                              = $request->input('pricing_group');
            $arr_data['customer_pricing_procedure']                 = $request->input('customer_pricing_procedure');
            $arr_data['price_list_type']                            = $request->input('price_list_type');
            $arr_data['cust_statistics_grp']                        = $request->input('cust_statistics_grp');
            $arr_data['delivery_priority']                          = $request->input('delivery_priority');
            $arr_data['order_combination_indicator']                = $request->input('order_combination_indicator');
            $arr_data['shipping_conditions']                        = $request->input('shipping_conditions');
            $arr_data['delivering_plant']                           = $request->input('delivering_plant');
            $arr_data['max_partial_delivery']                       = $request->input('max_partial_delivery');
            $arr_data['id_customer_is_to_receive_rebates']          = $request->input('id_customer_is_to_receive_rebates');
            $arr_data['relevant_for_price_determination_id']        = $request->input('relevant_for_price_determination_id');
            $arr_data['incoterms_part_1']                           = $request->input('incoterms_part_1');
            $arr_data['inco_2']                                     = $request->input('inco_2');
            $arr_data['terms_of_payment_key']                       = $request->input('terms_of_payment_key');
            $arr_data['account_assignment_group_for_this_customer'] = $request->input('account_assignment_group_for_this_customer');
            $arr_data['employee_response']                          = $request->input('employee_response');
            $arr_data['employee_response_code']                     = $request->input('employee_response_code');
            $arr_data['tax_classification_for_customer1']           = $request->input('tax_classification_for_customer1');
            $arr_data['tax_classification_for_customer2']           = $request->input('tax_classification_for_customer2');
            $arr_data['tax_classification_for_customer3']           = $request->input('tax_classification_for_customer3');
            $arr_data['tax_classification_for_customer4']           = $request->input('tax_classification_for_customer4');

            //Add order in SAP
           
            $myfile = fopen("../SAP/ECOMMERCE_TO_SAP/CUSTOMERS/".$data->id.".txt", "w") or die("Unable to open file!");
            $counter = 1;
            $txt = "Customer\tName1\tName2\tName3\tStreet1\tStreet2\tStreet3\tCity\tReg\tCon\tPost Box.\tTelphone\tPan No.\tGst No.\tMobile NO.\tEmail\tCompany Code\tSales Organization\tDistribution Channel\tDivision\tCustomer Account Group\tLanguage key\tReg. Str. Grp.\tExcise Ind customer\tCST NO.\tReconcilliation account\tSort Key\tCash Management group\tIndicator: Record Payment History ?\tPayment Methods\tSales district\tSales office/ /BRANCH CODE\tCUSTOMER GROUP\tABC Class\tCurrency\tPricing group\tCustomer Pricing procedure\tPrice list type\tCust Statistics Grp\tDelivery priority\tOrder combination indicator\tShipping conditions\tDelivering plant\tmax partial delivery\tID: Customer is to receive rebates\tRelevant for price determination ID\tIncoterms (part 1)\tInco 2\tTerms of payment key\tAccount assignment group for this customer\tEmployee response\tEmployee response code\tTax classification for customer\tTax classification for customer\tTax classification for customer\tTax classification for customer\n";
            
                $Customer               = $data->id;
                $Name1                  = $data->first_name.' '.$data->last_name ;
                $Name2                  = $data->company_name ;
                $Name3                  = $data->company_address ;
                $Street1                = " ";
                $Street2                = " ";
                $Street3                = " ";
                $City                   = $data->city;
                $Reg                    = " ";
                $Con                    = " ";
                $Post                   = $data->pincode;
                $Telphone               = " ";
                $Pan                    = $data->pan_number;
                $Gst                    = $data->gst_no;
                $mobile_no              = $data->mobile_no;
                $Email                  = $data->email;
                $company_code           = $request->input('company_code');
                $sales_organization     = $request->input('sales_organization');
                $distribution_channel   = $request->input('distribution_channel');
                $division               = $request->input('division');
                $customer_account_group = $request->input('customer_account_group');

                $language_key                               = $request->input('language_key');
                $reg_str_grp                                = $request->input('reg_str_grp');
                $excise_ind_customer                        = $request->input('excise_ind_customer');
                $cst_no                                     = $request->input('cst_no');
                $reconcilliation_account                    = $request->input('reconcilliation_account');
                $sort_key                                   = $request->input('sort_key');
                $cash_management_group                      = $request->input('cash_management_group');
                $indicator_record_payment_history           = $request->input('indicator_record_payment_history');
                $payment_methods                            = $request->input('payment_methods');
                $sale_district                              = $request->input('sale_district');
                $sales_office_branch_code                   = $request->input('sales_office_branch_code');
                $customer_group                             = $request->input('customer_group');
                $abc_class                                  = $request->input('abc_class');
                $currency                                   = $request->input('currency');
                $pricing_group                              = $request->input('pricing_group');
                $customer_pricing_procedure                 = $request->input('customer_pricing_procedure');
                $price_list_type                            = $request->input('price_list_type');
                $cust_statistics_grp                        = $request->input('cust_statistics_grp');
                $delivery_priority                          = $request->input('delivery_priority');
                $order_combination_indicator                = $request->input('order_combination_indicator');
                $shipping_conditions                        = $request->input('shipping_conditions');
                $delivering_plant                           = $request->input('delivering_plant');
                $max_partial_delivery                       = $request->input('max_partial_delivery');
                $id_customer_is_to_receive_rebates          = $request->input('id_customer_is_to_receive_rebates');
                $relevant_for_price_determination_id        = $request->input('relevant_for_price_determination_id');
                $incoterms_part_1                           = $request->input('incoterms_part_1');
                $inco_2                                     = $request->input('inco_2');
                $terms_of_payment_key                       = $request->input('terms_of_payment_key');
                $account_assignment_group_for_this_customer = $request->input('account_assignment_group_for_this_customer');
                $employee_response                          = $request->input('employee_response');
                $employee_response_code                     = $request->input('employee_response_code');
                $tax_classification_for_customer1           = $request->input('tax_classification_for_customer1');
                $tax_classification_for_customer2           = $request->input('tax_classification_for_customer2');
                $tax_classification_for_customer3           = $request->input('tax_classification_for_customer3');
                $tax_classification_for_customer4           = $request->input('tax_classification_for_customer4');

                $txt .= $Customer."\t".$Name1."\t".$Name2."\t".$Name3."\t".$Street1."\t".$Street2."\t".$Street3."\t".$City."\t".$Reg."\t".$Con."\t".$Post."\t".$Telphone."\t".$Pan."\t".$Gst."\t".$mobile_no."\t".$Email."\t".$company_code."\t".$sales_organization."\t".$distribution_channel."\t".$division."\t".$customer_account_group."\t".$language_key."\t".$reg_str_grp."\t".$excise_ind_customer."\t".$cst_no."\t".$reconcilliation_account."\t".$sort_key."\t".$cash_management_group."\t".$indicator_record_payment_history."\t".$payment_methods."\t".$sale_district."\t".$sales_office_branch_code."\t".$customer_group."\t".$abc_class."\t".$currency."\t".$pricing_group."\t".$customer_pricing_procedure."\t".$price_list_type."\t".$cust_statistics_grp."\t".$delivery_priority."\t".$order_combination_indicator."\t".$shipping_conditions."\t".$delivering_plant."\t".$max_partial_delivery."\t".$id_customer_is_to_receive_rebates."\t".$relevant_for_price_determination_id."\t".$incoterms_part_1."\t".$inco_2."\t".$terms_of_payment_key."\t".$account_assignment_group_for_this_customer."\t".$employee_response."\t".$employee_response_code."\t".$tax_classification_for_customer1."\t".$tax_classification_for_customer2."\t".$tax_classification_for_customer3."\t".$tax_classification_for_customer4."\n";
            
            fwrite($myfile, $txt);
            fclose($myfile);

            $mail = new PHPMailer(true); 
            try 
            {
                $html = '
                        <!DOCTYPE html>
                            <html>
                            <head>
                              <title>Kores India</title>
                            </head>
                            <body style="background-color:#e8f8ff; font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:22px; color:#000">
                            <div style="width:600px; margin:20px auto"><div style="border:1px solid #CCC; padding:20px; background:#FFF; margin-bottom:15px ">
                            <img src="http://traineronhire.com/kores/css_and_js/logo.png"><br>
                    Dear '.$data->first_name.', 
                                <h3 style="font-size:16px; color:#e5322c">Welcome to your Kores account!</h3>

                        We are happy to inform you that your <b>Dealer Signup</b> request has been <b>accepted.</b><br><br>
                        We welcome you to Kores Family and really value your association. We are committed to give you power to save moreand earn more in this competitive market. You can now make purchases on your Kores account and start savings.<br><br>
                        Looking forward for wonderful journey.<br><br>
                        Regards,<br>
                            Kores India Team<br>
                            1800 22 2447 || 1800 26 79777<br>
                            
                            <br><br>
                            Disclaimer: This is a system generated email and please do not respond to this email.';

                $mail->isSMTP(); 
                $mail->CharSet    = "utf-8";
                $mail->SMTPAuth   = true;
                $mail->SMTPSecure = env('SMTPSECURE');
                $mail->Host       = env('HOST');
                $mail->Port       = env('PORT');
                $mail->Username   = env('USERNAME');
                $mail->Password   = env('PASSWORD');
                $mail->Subject    = "Congratulations! You request has been accepted.";
                $mail->setFrom(env('SETFROMEMAIL'), env('SETFROMNAME'));
                $mail->MsgHTML($html);
                $mail->addAddress($data->email, $data->first_name);
                //$mail->send();
            } 
            catch (phpmailerException $e) 
            {
                Session::flash('error', 'Internal Server Issue.'.$e);
                return \Redirect::back();  
            } 
            catch (Exception $e) 
            {
                Session::flash('error', 'Internal Server Issue.'.$e);
                return \Redirect::back();
            }

        }
        elseif($request->input('status')=='Rejected')
        {
            $data = $this->base_model->where(['id'=>$id])->first();
            $mail = new PHPMailer(true); 
            try 
            {
                $html = '<!DOCTYPE html>
                            <html>
                            <head>
                              <title>Kores India</title>
                            </head>
                            <body style="background-color:#e8f8ff; font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:22px; color:#000">
                            <div style="width:600px; margin:20px auto"><div style="border:1px solid #CCC; padding:20px; background:#FFF; margin-bottom:15px ">
                            <img src="http://traineronhire.com/kores/css_and_js/logo.png"><br>
                    Dear '.$data->first_name.', 
                                <h3 style="font-size:16px; color:#e5322c">Welcome to your Kores account!</h3>

                        Thank you for Interest in becoming Kores India authorised Vendor.<br><br>
                        We regret to inform you that we are unable to accept your signup request at this time and same has been rejected by our Administrators.<br><br>
                        We really value your time and thank you for your interest.<br><br>
                        Regards,<br>
                            Kores India Team<br>
                            1800 22 2447 || 1800 26 79777<br>
                    
                            <br><br>
                            Disclaimer: This is a system generated email and please do not respond to this email. ';

                $mail->isSMTP(); 
                $mail->CharSet    = "utf-8";
                $mail->SMTPAuth   = true;
                $mail->SMTPSecure = env('SMTPSECURE');
                $mail->Host       = env('HOST');
                $mail->Port       = env('PORT');
                $mail->Username   = env('USERNAME');
                $mail->Password   = env('PASSWORD');
                $mail->Subject    = "Welcome to Kores";
                $mail->setFrom(env('SETFROMEMAIL'), env('SETFROMNAME'));
                $mail->MsgHTML($html);
                $mail->addAddress($data->email, $data->first_name);
                $mail->send();
            } 
            catch (phpmailerException $e) 
            {
                Session::flash('error', 'Internal Server Issue.'.$e);
                return \Redirect::back();
            } 
            catch (Exception $e) 
            {
                Session::flash('error', 'Internal Server Issue.'.$e);
                return \Redirect::back();
            }
            $arr_data['sales_member']      = $request->input('sales_member');
            $arr_data['admin_approval']    = $request->input('status');
            $arr_data['rejection_reason']  = $request->input('rejection');
        }
        $status = $this->base_model->where(['id'=>$id])->update($arr_data);
        if (!empty($status))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('admin/manage_user');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }

    public function assign_credit_user(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
                'credit'        => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        
            //$data = $this->base_model->where(['id'=>$id])->first();
            /*$mail = new PHPMailer(true); 
            try 
            {
                $html = 'Dear '.$data->first_name.', <br><br>
                           We are happy to inform you that your <b>Dealer Signup</b> request has been <b>accepted.</b><br><br>

                            We welcome you to Kores Family and really value your association. We are committed to give you power to save moreand earn more in this competitive market. You can now make purchases on your Kores account and start savings.<br><br>

                            Looking forward for wonderful journey.<br><br>

                            Regards,<br>
                            Kores India Team<br>
                            1800 22 2447 || 1800 26 79777<br>
                            <img src="http://traineronhire.com/kores/css_and_js/logo.png">
                            <br><br>
                            Disclaimer: This is a system generated email and please do not respond to this email. ';

                $mail->isSMTP(); 
                $mail->CharSet    = "utf-8";
                $mail->SMTPAuth   = true;
                $mail->SMTPSecure = env('SMTPSECURE');
                $mail->Host       = env('HOST');
                $mail->Port       = env('PORT');
                $mail->Username   = env('USERNAME');
                $mail->Password   = env('PASSWORD');
                $mail->Subject    = "Congratulations! You request has been accepted.";
                $mail->setFrom(env('SETFROMEMAIL'), env('SETFROMNAME'));
                $mail->MsgHTML($html);
                $mail->addAddress($data->email, $data->first_name);
                $mail->send();
            } 
            catch (phpmailerException $e) 
            {
                Session::flash('error', 'Internal Server Issue.'.$e);
                return \Redirect::back();  
            } 
            catch (Exception $e) 
            {
                Session::flash('error', 'Internal Server Issue.'.$e);
                return \Redirect::back();
            }*/
        $arr_data            = [];
        $arr_data['user_id'] = $id;
        $arr_data['credit']  = $request->input('credit');
        $arr_data['date']    = date('d M Y');
        $status = \DB::table('assign_credit')->insert($arr_data);    
        \DB::table('users')->where(['id'=>$id])->update(['payment_terms'=>$request->input('terms')]);    
        
        if (!empty($status))
        {
            Session::flash('success', 'Success! Credit Updated successfully.');
            return \Redirect::back();
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
           return \Redirect::back();
        }
    }

    public function deliverty_boy_view($id)
    {
        $arr_data = [];
        $data     = $this->base_model->where(['id'=>$id])->first();


        $data['data']      = $data;
        $data['address']   = \DB::table('address')->where(['user_id'=>$id])->get();
        $data['subuser']   = \DB::table('subusers')->where(['user_id'=>$id])->get();
        $data['vendor_category'] = \DB::table('vendor_category')->groupBy('vendor_category')->where('deleted_at','=',null)->get();
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'deliverty_boy_view',$data);
    }

    public function store_view($id)
    {
        $arr_data = [];
        $data     = $this->base_model->where(['id'=>$id])->first();


        $data['data']      = $data;
        $data['address']   = \DB::table('address')->where(['user_id'=>$id])->get();
        $data['subuser']   = \DB::table('subusers')->where(['user_id'=>$id])->get();
        $data['vendor_category'] = \DB::table('vendor_category')->groupBy('vendor_category')->where('deleted_at','=',null)->get();
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Store';
        return view($this->folder_path.'store_view',$data);
    }

    public function view($id)
    {
        $arr_data = [];

        $data1     = \DB::table('booking')->where(['id'=>$id])->first();


        $data['data']      = $data1;
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'view',$data);
    }

    public function view_nexa_booking($id)
    {
       
        $arr_data = [];

        $data1     = \DB::table('nexa_booking')->where(['id'=>$id])->first();


        $data['data']      = $data1;
        $data['page_name'] = "View";
        $data['url_slug']  = 'nexa_booking';
        $data['title']     = 'nexa_booking';
        return view($this->folder_path.'view_nexa_booking',$data);
    }

    public function view_commercial_booking($id)
    {
        $arr_data = [];

        $data1     = \DB::table('commercial_booking')->where(['id'=>$id])->first();


        $data['data']      = $data1;
        $data['page_name'] = "View";
        $data['url_slug']  = 'commercial_booking';
        $data['title']     = 'commercial_booking';
        return view($this->folder_path.'view_commercial_booking',$data);
    }

    public function edit($id)
    {
        $arr_data = [];
        $data     = $this->base_model->where(['id'=>$id])->first();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        $data['state']     = [];//\DB::table('pincode_with_area')
                                //->groupBy('state')
                                //->get();
    
        $data['vendor_category'] = \DB::table('vendor_category')
                                        ->where('deleted_at','=',null)
                                        ->groupBy('vendor_category')
                                        ->get();
        return view($this->folder_path.'edit',$data);
    }

    public function deliverty_boy_edit($id)
    {
        $arr_data = [];
        $data     = $this->base_model->where(['id'=>$id])->first();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
      
        return view($this->folder_path.'deliverty_boy_edit',$data);
    }

    public function store_edit($id)
    {
        $arr_data = [];
        $data     = $this->base_model->where(['id'=>$id])->first();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Store';
      
        return view($this->folder_path.'store_edit',$data);
    }

    public function edit_address($id)
    {
        $arr_data     = \DB::table('address')->where(['id'=>$id])->first();

        $data['data']      = $arr_data;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        $data['state']     = \DB::table('pincode_with_area')
                                ->where(['state'=>'MAHARASHTRA'])
                                ->groupBy('state')
                                ->get();
        $data['city']      = \DB::table('pincode_with_area')
                                ->where(['state'=>$arr_data->state,'district'=>'MUMBAI'])
                                ->orWhere('district', '=', 'PUNE')
                                ->where(['state'=>$arr_data->state])
                                ->orWhere('district', '=', 'NASHIK')
                                ->where(['state'=>$arr_data->state])
                                //->where(['state'=>$arr_data->state])
                                ->orderBy('district','ASC')
                                ->groupBy('district')
                                ->get();
        $data['pincode']   = \DB::table('pincode_with_area')
                                ->where(['district'=>$arr_data->city])
                                ->orderBy('pincode','ASC')
                                ->groupBy('pincode')
                                ->get();

        return view($this->folder_path.'edit_address',$data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
                'first_name'        => 'required',
                'last_name'         => 'required',
                'email'             => 'required',
                'mobile_no'         => 'required',
                'password'          => 'required',
               
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        $is_exist = $this->base_model->where('id','<>',$id)->where(['mobile_no'=>$request->input('mobile_no'),'email'=>$request->input('email')])->count();

        if($is_exist)
        {
            Session::flash('error', "User already exist!");
            return \Redirect::back();
        }


        $arr_data                       = [];
        $arr_data['first_name']         = $request->input('first_name');
        $arr_data['last_name']          = $request->input('last_name');
        $arr_data['mobile_no']          = $request->input('mobile_no');
        $arr_data['email']              = $request->input('email');
        $arr_data['password']           = $request->input('password');
     
        
        $status = $this->base_model->where(['id'=>$id])->update($arr_data);
        if (!empty($status))
        {
            Session::flash('success', 'Success! Record update successfully.');
            return \Redirect::to('admin/manage_user');
            //return \Redirect::back();
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }

    public function deliverty_boy_update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
                'first_name'        => 'required',
                'last_name'         => 'required',
                'email'             => 'required',
                'mobile_no'         => 'required',
                'password'          => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        $is_exist = $this->base_model->where('id','<>',$id)->where(['mobile_no'=>$request->input('mobile_no'),'email'=>$request->input('email')])->count();

        if($is_exist)
        {
            Session::flash('error', "User already exist!");
            return \Redirect::back();
        }


        $arr_data                       = [];
        $arr_data['first_name']         = $request->input('first_name');
        $arr_data['last_name']          = $request->input('last_name');
        $arr_data['mobile_no']          = $request->input('mobile_no');
        $arr_data['email']              = $request->input('email');
        $arr_data['password']           = $request->input('password');
   
        if(isset($_FILES["upload_pan"]["name"]) && !empty($_FILES["upload_pan"]["name"]))
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 18; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
      
            $file_name                         = $_FILES["upload_pan"]["name"];
            $file_tmp                          = $_FILES["upload_pan"]["tmp_name"];
            $ext                               = pathinfo($file_name,PATHINFO_EXTENSION);
            $random_file_name                  = $randomString.'.'.$ext;
            $latest_image                      = 'upload/profile/'.$random_file_name;

            if(move_uploaded_file($file_tmp,env('BASE_PATH').$latest_image))
            {
                $arr_data['upload_pan']      = $latest_image;
            }
        }   

        if(isset($_FILES["kyc_document"]["name"]) && !empty($_FILES["kyc_document"]["name"]))
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 18; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
      
            $file_name1                         = $_FILES["kyc_document"]["name"];
            $file_tmp1                          = $_FILES["kyc_document"]["tmp_name"];
            $ext1                               = pathinfo($file_name1,PATHINFO_EXTENSION);
            $random_file_name1                  = '2'.$randomString.'.'.$ext1;
            $latest_image1                      = 'upload/profile/'.$random_file_name1;

            if(move_uploaded_file($file_tmp1,env('BASE_PATH').$latest_image1))
            {
                $arr_data['kyc_document']      = $latest_image1;
            }
        }   
        
        $status = $this->base_model->where(['id'=>$id])->update($arr_data);
        if (!empty($status))
        {
            Session::flash('success', 'Success! Record update successfully.');
            return \Redirect::to('admin/manage_delivery_boy');
            //return \Redirect::back();
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }

    public function store_update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
                'store_name'        => 'required',
                'min_order_value'   => 'required',
                'delivery_fees'     => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        $is_exist = $this->base_model->where('id','<>',$id)->where(['mobile_no'=>$request->input('mobile_no'),'email'=>$request->input('email')])->count();

        if($is_exist)
        {
            Session::flash('error', "User already exist!");
            return \Redirect::back();
        }


        $arr_data                    = [];
        $arr_data['store_name']      = $request->input('store_name');
        $arr_data['min_order_value'] = $request->input('min_order_value');
        $arr_data['delivery_fees']   = $request->input('delivery_fees');
        $arr_data['delivery_schedule']   = $request->input('delivery_schedule');
        
       
        $status = $this->base_model->where(['id'=>$id])->update($arr_data);
        if (!empty($status))
        {
            Session::flash('success', 'Success! Record update successfully.');
            return \Redirect::to('admin/manage_store');
            //return \Redirect::back();
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }

    public function update_address(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
                'address'           => 'required',
                'state'             => 'required',
                'city'              => 'required',
                'pincode'           => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        $arr_data            = [];
        $arr_data['address'] = $request->input('address');
        $arr_data['state']   = $request->input('state');
        $arr_data['city']    = $request->input('city');
        $arr_data['pincode'] = $request->input('pincode');
        //dd($arr_data);
        $status = \DB::table('address')->where(['id'=>$id])->update($arr_data);
        if (!empty($status))
        {
            Session::flash('success', 'Success! Record updated successfully.');
            return \Redirect::back();
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }

    public function getvarient()
    {
        $id = $_POST['id'];
        if ($id != null) {
                $city = \DB::table('product')
                                ->where(['car'=>$id])
                                ->orderBy('varient','ASC')
                                ->groupBy('varient')
                                ->get();
                        echo "<option  value=''>Select Variant</option>";
                if (count($city) > 0) {
                    foreach ($city as $city_details) {
                        echo "<option value='" . $city_details->varient . "'>" . $city_details->varient . "</option>";
                    }
                } else {
                    echo "<option  value=''>-</option>";
                }
        }
        else
        {
             echo "<option  value=''>Select Variant</option>";
        }
    }
    public function getvarientnexa()
    {
        $id = $_POST['id'];
        if ($id != null) {
                $city = \DB::table('nexa_product')
                                ->where(['car'=>$id])
                                ->orderBy('varient','ASC')
                                ->groupBy('varient')
                                ->get();
                        echo "<option  value=''>Select Variant</option>";
                if (count($city) > 0) {
                    foreach ($city as $city_details) {
                        echo "<option value='" . $city_details->varient . "'>" . $city_details->varient . "</option>";
                    }
                } else {
                    echo "<option  value=''>-</option>";
                }
        }
        else
        {
             echo "<option  value=''>Select Variant</option>";
        }
    }
    public function getvarientcomm()
    {
        $id = $_POST['id'];
        if ($id != null) {
                $city = \DB::table('commercial_product')
                                ->where(['car'=>$id])
                                ->orderBy('varient','ASC')
                                ->groupBy('varient')
                                ->get();
                        echo "<option  value=''>Select Variant</option>";
                if (count($city) > 0) {
                    foreach ($city as $city_details) {
                        echo "<option value='" . $city_details->varient . "'>" . $city_details->varient . "</option>";
                    }
                } else {
                    echo "<option  value=''>-</option>";
                }
        }
        else
        {
             echo "<option  value=''>Select Variant</option>";
        }
    }


    public function getcolor()
    {
        $varient = $_POST['varient'];
        $city = \DB::table('product')
                ->where(['varient'=>$_POST['varient']])
                ->where(['car'=>$_POST['car']])
                ->get();

         echo "<option>Select Color</option>";
                if (count($city) > 0) {
                    foreach ($city as $city_details) {
                        echo "<option value='" . $city_details->color . "'>" . $city_details->color . "</option>";
                    }
                } else {
                    echo "<option>-</option>";
                }
                       
                        
    }
    public function getcolornexa()
    {
        $varient = $_POST['varient'];
        $city = \DB::table('nexa_product')
                ->where(['varient'=>$_POST['varient']])
                ->where(['car'=>$_POST['car']])
                ->get();

         echo "<option>Select Color</option>";
                if (count($city) > 0) {
                    foreach ($city as $city_details) {
                        echo "<option value='" . $city_details->color . "'>" . $city_details->color . "</option>";
                    }
                } else {
                    echo "<option>-</option>";
                }
                       
                        
    }
    public function getcolorcomm()
    {
        $varient = $_POST['varient'];
        $city = \DB::table('commercial_product')
                ->where(['varient'=>$_POST['varient']])
                ->where(['car'=>$_POST['car']])
                ->get();

         echo "<option>Select Color</option>";
                if (count($city) > 0) {
                    foreach ($city as $city_details) {
                        echo "<option value='" . $city_details->color . "'>" . $city_details->color . "</option>";
                    }
                } else {
                    echo "<option>-</option>";
                }
                       
                        
    }

    public function getprice()
    {
        $id = $_POST['id'];
       
                $city = \DB::table('product')
                                ->where(['varient'=>$_POST['varient']])
                                ->where(['car'=>$_POST['car']])
                                ->first();
                    echo "Rs".' '. $city->on_road_price; 
    }

    public function getcity()
    {
        $state = $_POST['id'];
        if ($state != null) {
                $city = \DB::table('pincode_with_area')
                                ->where(['state'=>$state])
                                ->orderBy('district','ASC')
                                ->groupBy('district')
                                ->get();
                        echo "<option>Select City</option>";
                if (count($city) > 0) {
                    foreach ($city as $city_details) {
                        echo "<option value='" . $city_details->district . "'>" . $city_details->district . "</option>";
                    }
                } else {
                    echo "<option>-</option>";
                }
        }
        else
        {
             echo "<option>Select City</option>";
        }
    }

    public function getarea()
    {
        $state = $_POST['id'];
        if ($state != null) {
                $city = \DB::table('area')
                                ->where(['city_name'=>$state])
                                ->orderBy('area','ASC')
                                ->get();
                        echo "<option>Select Area</option>";
                if (count($city) > 0) {
                    foreach ($city as $city_details) {
                        echo "<option value='" . $city_details->area . "'>" . $city_details->area . "</option>";
                    }
                } else {
                    echo "<option>-</option>";
                }
        }
        else
        {
             echo "<option>Select Area</option>";
        }
    }

    public function get_user_suggestion()
    {
        //dd($_GET['term']);
        $data = $this->base_model->limit(10)->get();
        $temp = [];
        foreach ($data as $key => $value) 
        {
            array_push($temp, ['id'=>$value->id,'value'=>$value->first_name]);
        }
        echo json_encode($temp); 
    }

    public function getpincode()
    {
        $district = $_POST['id'];
        if ($district != null) {

                $pincode = \DB::table('pincode_with_area1')
                                ->where(['area'=>$district])
                                //->orderBy('pincode','ASC')
                                //->groupBy('pincode')
                                ->first();
                if (count($pincode) > 0) 
                {
                    echo $pincode->pincode;
                } 
                else 
                {
                    echo "NA";
                }
        }
    }

    public function delete($id)
    {
        $this->base_model->where(['id'=>$id])->delete();
        Session::flash('success', 'Success! Record deleted successfully.');
        return \Redirect::back();
    }

    public function deliverty_boy_delete($id)
    {
        //$this->base_model->where(['id'=>$id])->delete();
        Session::flash('success', 'Success! Record deleted successfully.');
        return \Redirect::back();
    }

    public function store_delete($id)
    {
        //$this->base_model->where(['id'=>$id])->delete();
        Session::flash('success', 'Success! Record deleted successfully.');
        return \Redirect::back();
    }
    public function locations(Request $request)
    {
        $arr_data = [];
        $arr_data = \DB::table('locations')
                        ->get();

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'locations',$data);
    }
    public function add_location(Request $request)
    {
        $data['page_name'] = "Add";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Location';
        return view($this->folder_path.'add_location',$data);
    }
    public function add_offer(Request $request)
    {
        $car = \DB::table('product')
                                ->groupBy('car')
                                ->get();
        

        $data['data'] = $car;
        $data['page_name'] = "Add";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Offer';
        return view($this->folder_path.'add_offer',$data);
    }

    public function add_nexa_offer(Request $request)
    {
        $car = \DB::table('nexa_product')
                                ->groupBy('car')
                                ->get();
        

        $data['data'] = $car;
        $data['page_name'] = "Add";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Offer';
        return view($this->folder_path.'add_nexa_offer',$data);
    }

    public function add_nexa_home_banner(Request $request)
    {
        $car = \DB::table('nexa_product')
                                ->groupBy('car')
                                ->get();
        

        $data['data'] = $car;
        $data['page_name'] = "Add";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Home Banner';
        return view($this->folder_path.'add_nexa_home_banner',$data);
    }
    public function add_comm_home_banner(Request $request)
    {
        $car = \DB::table('product')
                                ->groupBy('car')
                                ->get();
        

        $data['data'] = $car;
        $data['page_name'] = "Add";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Home Banner';
        return view($this->folder_path.'add_comm_home_banner',$data);
    }
    public function add_commercial_offer(Request $request)
    {
        $car = \DB::table('commercial_product')
                                ->groupBy('car')
                                ->get();
        

        $data['data'] = $car;
        $data['page_name'] = "Add";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Offer';
        return view($this->folder_path.'add_commercial_offer',$data);
    }

    
    
    public function store_offer(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'car_maker'=> 'required',
                'varient' => 'required',
                'color'=> 'required',
                'image'=> 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        

        $arr_data             = [];
        $arr_data['car_maker']     = $request->input('car_maker');
        $arr_data['varient']     = $request->input('varient');
        $arr_data['color']     = $request->input('color');
        if(isset($_FILES["image"]["name"]) && !empty($_FILES["image"]["name"]))
            {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < 18; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
          
                $file_name                         = $_FILES["image"]["name"];
                $file_tmp                          = $_FILES["image"]["tmp_name"];
                $ext                               = pathinfo($file_name,PATHINFO_EXTENSION);
                $random_file_name                  = $randomString.'.'.$ext;
                $latest_image                      = '/admin/upload/offers/'.$random_file_name;

                if(move_uploaded_file($file_tmp,env('BASE_PATH').$latest_image))
                {
                    $arr_data['image']      = $latest_image;
                }
            } 
        // dd($arr_data);

        $offer             = \DB::table('offers')->insert($arr_data);
        if (!empty($offer))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('admin/offers');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }
    
    public function store_nexa_home_banner(Request $request)
    {
        $validator = Validator::make($request->all(), [
               
                'image'=> 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        

        $arr_data             = [];
       
        if(isset($_FILES["image"]["name"]) && !empty($_FILES["image"]["name"]))
            {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < 18; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
          
                $file_name                         = $_FILES["image"]["name"];
                $file_tmp                          = $_FILES["image"]["tmp_name"];
                $ext                               = pathinfo($file_name,PATHINFO_EXTENSION);
                $random_file_name                  = $randomString.'.'.$ext;
                $latest_image                      = '/admin/upload/home_banner/'.$random_file_name;

                if(move_uploaded_file($file_tmp,env('BASE_PATH').$latest_image))
                {
                    $arr_data['banner']      = $latest_image;
                }
            } 
        // dd($arr_data);

        $offer             = \DB::table('nexa_home_banner')->insert($arr_data);
        if (!empty($offer))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('admin/nexa_home_banner');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }
    
    public function store_comm_home_banner(Request $request)
    {
        $validator = Validator::make($request->all(), [
               
                'image'=> 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        

        $arr_data             = [];
       
        if(isset($_FILES["image"]["name"]) && !empty($_FILES["image"]["name"]))
            {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < 18; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
          
                $file_name                         = $_FILES["image"]["name"];
                $file_tmp                          = $_FILES["image"]["tmp_name"];
                $ext                               = pathinfo($file_name,PATHINFO_EXTENSION);
                $random_file_name                  = $randomString.'.'.$ext;
                $latest_image                      = '/admin/upload/home_banner/'.$random_file_name;

                if(move_uploaded_file($file_tmp,env('BASE_PATH').$latest_image))
                {
                    $arr_data['banner']      = $latest_image;
                }
            } 
        // dd($arr_data);

        $offer             = \DB::table('comm_home_banner')->insert($arr_data);
        if (!empty($offer))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('admin/comm_home_banner');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }
    
    public function store_nexa_offer(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'car_maker'=> 'required',
                'varient' => 'required',
                'color'=> 'required',
                'image'=> 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        

        $arr_data             = [];
        $arr_data['car_maker']     = $request->input('car_maker');
        $arr_data['varient']     = $request->input('varient');
        $arr_data['color']     = $request->input('color');
        if(isset($_FILES["image"]["name"]) && !empty($_FILES["image"]["name"]))
            {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < 18; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
          
                $file_name                         = $_FILES["image"]["name"];
                $file_tmp                          = $_FILES["image"]["tmp_name"];
                $ext                               = pathinfo($file_name,PATHINFO_EXTENSION);
                $random_file_name                  = $randomString.'.'.$ext;
                $latest_image                      = '/admin/upload/offers/'.$random_file_name;

                if(move_uploaded_file($file_tmp,env('BASE_PATH').$latest_image))
                {
                    $arr_data['image']      = $latest_image;
                }
            } 
        // dd($arr_data);

        $offer             = \DB::table('nexa_offers')->insert($arr_data);
        if (!empty($offer))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('admin/nexa_offers');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }
    
    public function store_commercial_offer(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'car_maker'=> 'required',
                'varient' => 'required',
                'color'=> 'required',
                'image'=> 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        

        $arr_data             = [];
        $arr_data['car_maker']     = $request->input('car_maker');
        $arr_data['varient']     = $request->input('varient');
        $arr_data['color']     = $request->input('color');
        if(isset($_FILES["image"]["name"]) && !empty($_FILES["image"]["name"]))
            {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < 18; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
          
                $file_name                         = $_FILES["image"]["name"];
                $file_tmp                          = $_FILES["image"]["tmp_name"];
                $ext                               = pathinfo($file_name,PATHINFO_EXTENSION);
                $random_file_name                  = $randomString.'.'.$ext;
                $latest_image                      = '/admin/upload/offers/'.$random_file_name;

                if(move_uploaded_file($file_tmp,env('BASE_PATH').$latest_image))
                {
                    $arr_data['image']      = $latest_image;
                }
            } 
        // dd($arr_data);

        $offer             = \DB::table('commercial_offers')->insert($arr_data);
        if (!empty($offer))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('admin/commercial_offers');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }
    
    public function store_location(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'city'     => 'required',
                'area'     => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        $is_exist = \DB::table('locations')
                    ->where(['city'=>$request->input('city')])
                    ->where(['area'=>$request->input('area')])
                    ->count();

        if($is_exist)
        {
            Session::flash('error', "area already exist for this city!");
            return \Redirect::back();
        }

        $arr_data             = [];
        $arr_data['city']     = $request->input('city');
        $arr_data['area']     = $request->input('area');
        $arr_data['is_active']= '1';
        $location             = \DB::table('locations')->insert($arr_data);
        if (!empty($location))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('admin/locations');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }
    
    public function change_location_status($id)
    {
        $data =  \DB::table('locations')->where(['id'=>base64_decode($id)])->first();
        //dd($data->is_active);
        if($data->is_active=='0')
        {
            $location = \DB::table('locations')->where(['id'=>base64_decode($id)])->update(['is_active'=>'1']);
         ;
            Session::flash('success', 'Success! Record activated successfully.');
        }
        else
        {
            $location = \DB::table('locations')->where(['id'=>base64_decode($id)])->update(['is_active'=>'0']);
         
            Session::flash('success', 'Success! Record deactivated successfully.');
        }
        return \Redirect::to('admin/locations');
    }
    
    public function edit_location($id)
    {
        $arr_data = [];
        $arr_data     = \DB::table('locations')->where(['id'=>$id])->first();
        $data['data']      = $arr_data;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Location';
        return view($this->folder_path.'edit_location',$data);
    }
    
    public function edit_offer($id)
    {
        $arr_data = [];
        $arr_data     = \DB::table('offers')->where(['id'=>$id])->first();
      
        

        $data['car'] = \DB::table('product')
                                ->groupBy('car')
                                ->get();

        $data['varient']      = \DB::table('product')
                                ->select('varient')
                                ->where(['varient'=>$arr_data->varient])
                                ->orderBy('varient','ASC')
                                ->groupBy('varient')
                                ->get();
        $data['color']      = \DB::table('product')
                                ->select('color')
                                ->where(['color'=>$arr_data->color])
                                ->orderBy('color','ASC')
                                ->groupBy('color')
                                ->get();

        $data['data']      = $arr_data;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Offer';

        return view($this->folder_path.'edit_offer',$data);
    }

    public function edit_nexa_offer($id)
    {
        $arr_data = [];
        $arr_data     = \DB::table('nexa_offers')->where(['id'=>$id])->first();
      
        

        $data['car'] = \DB::table('nexa_product')
                                ->groupBy('car')
                                ->get();

        $data['varient']      = \DB::table('nexa_product')
                                ->select('varient')
                                ->where(['varient'=>$arr_data->varient])
                                ->orderBy('varient','ASC')
                                ->groupBy('varient')
                                ->get();
        $data['color']      = \DB::table('nexa_product')
                                ->select('color')
                                ->where(['color'=>$arr_data->color])
                                ->orderBy('color','ASC')
                                ->groupBy('color')
                                ->get();

        $data['data']      = $arr_data;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Offer';

        return view($this->folder_path.'edit_nexa_offer',$data);
    }
    
    public function edit_home_banner($id)
    {
        $arr_data = [];
        $arr_data     = \DB::table('nexa_home_banner')->where(['id'=>$id])->first();
        $data['data']      = $arr_data;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Home Banner';

        return view($this->folder_path.'edit_home_banner',$data);
    }
    
    public function edit_comm_home_banner($id)
    {
        $arr_data = [];
        $arr_data     = \DB::table('comm_home_banner')->where(['id'=>$id])->first();
        $data['data']      = $arr_data;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Home Banner';

        return view($this->folder_path.'edit_comm_home_banner',$data);
    }

    public function edit_commercial_offer($id)
    {
        $arr_data = [];
        $arr_data     = \DB::table('commercial_offers')->where(['id'=>$id])->first();
      
        

        $data['car'] = \DB::table('commercial_product')
                                ->groupBy('car')
                                ->get();

        $data['varient']      = \DB::table('commercial_product')
                                ->select('varient')
                                ->where(['varient'=>$arr_data->varient])
                                ->orderBy('varient','ASC')
                                ->groupBy('varient')
                                ->get();
        $data['color']      = \DB::table('commercial_product')
                                ->select('color')
                                ->where(['color'=>$arr_data->color])
                                ->orderBy('color','ASC')
                                ->groupBy('color')
                                ->get();

        $data['data']      = $arr_data;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Offer';

        return view($this->folder_path.'edit_commercial_offer',$data);
    }
    
    public function update_location(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
                'city'     => 'required',
                'area'     => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        $is_exist = \DB::table('locations')
                    ->where(['city'=>$request->input('city')])
                    ->where(['area'=>$request->input('area')])
                    ->count();

        if($is_exist)
        {
            Session::flash('error', "area already exist for this city!");
            return \Redirect::back();
        }

        $arr_data             = [];
        $arr_data['city']     = $request->input('city');
        $arr_data['area']     = $request->input('area');

        $location = \DB::table('locations')->where(['id'=>$id])->update($arr_data);

        if (!empty($location))
        {
            Session::flash('success', 'Success! Record updated successfully.');
            return \Redirect::to('admin/locations');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }
    
    public function update_offer(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
                'car_maker'=> 'required',
                'varient' => 'required',
                'color'=> 'required',
                'image'=> 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        

        $arr_data             = [];
        $arr_data['car_maker']     = $request->input('car_maker');
        $arr_data['varient']     = $request->input('varient');
        $arr_data['color']     = $request->input('color');
        if(isset($_FILES["image"]["name"]) && !empty($_FILES["image"]["name"]))
            {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < 18; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
          
                $file_name                         = $_FILES["image"]["name"];
                $file_tmp                          = $_FILES["image"]["tmp_name"];
                $ext                               = pathinfo($file_name,PATHINFO_EXTENSION);
                $random_file_name                  = $randomString.'.'.$ext;
                $latest_image                      = '/admin/upload/offers/'.$random_file_name;

                if(move_uploaded_file($file_tmp,env('BASE_PATH').$latest_image))
                {
                    $arr_data['image']      = $latest_image;
                }
            } 

        $offers = \DB::table('offers')->where(['id'=>$id])->update($arr_data);

        if (!empty($offers))
        {
            Session::flash('success', 'Success! Record updated successfully.');
            return \Redirect::to('admin/offers');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }
    public function update_nexa_offer(Request $request,$id)
   {
        $validator = Validator::make($request->all(), [
                'car_maker'=> 'required',
                'varient' => 'required',
                'color'=> 'required',
                'image'=> 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        

        $arr_data             = [];
        $arr_data['car_maker']     = $request->input('car_maker');
        $arr_data['varient']     = $request->input('varient');
        $arr_data['color']     = $request->input('color');
        if(isset($_FILES["image"]["name"]) && !empty($_FILES["image"]["name"]))
            {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < 18; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
          
                $file_name                         = $_FILES["image"]["name"];
                $file_tmp                          = $_FILES["image"]["tmp_name"];
                $ext                               = pathinfo($file_name,PATHINFO_EXTENSION);
                $random_file_name                  = $randomString.'.'.$ext;
                $latest_image                      = '/admin/upload/offers/'.$random_file_name;

                if(move_uploaded_file($file_tmp,env('BASE_PATH').$latest_image))
                {
                    $arr_data['image']      = $latest_image;
                }
            } 

        $offers = \DB::table('nexa_offers')->where(['id'=>$id])->update($arr_data);

        if (!empty($offers))
        {
            Session::flash('success', 'Success! Record updated successfully.');
            return \Redirect::to('admin/nexa_offers');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }
    
    public function update_nexa_home_banner(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
                'image'=> 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        

        $arr_data             = [];
       
        if(isset($_FILES["image"]["name"]) && !empty($_FILES["image"]["name"]))
            {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < 18; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
          
                $file_name                         = $_FILES["image"]["name"];
                $file_tmp                          = $_FILES["image"]["tmp_name"];
                $ext                               = pathinfo($file_name,PATHINFO_EXTENSION);
                $random_file_name                  = $randomString.'.'.$ext;
                $latest_image                      = '/admin/upload/home_banner/'.$random_file_name;

                if(move_uploaded_file($file_tmp,env('BASE_PATH').$latest_image))
                {
                    $arr_data['banner']      = $latest_image;
                }
            } 

        $offers = \DB::table('nexa_home_banner')->where(['id'=>$id])->update($arr_data);

        if (!empty($offers))
        {
            Session::flash('success', 'Success! Record updated successfully.');
            return \Redirect::to('admin/nexa_home_banner');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }
    
    public function update_comm_home_banner(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
                'image'=> 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        

        $arr_data             = [];
       
        if(isset($_FILES["image"]["name"]) && !empty($_FILES["image"]["name"]))
            {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < 18; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
          
                $file_name                         = $_FILES["image"]["name"];
                $file_tmp                          = $_FILES["image"]["tmp_name"];
                $ext                               = pathinfo($file_name,PATHINFO_EXTENSION);
                $random_file_name                  = $randomString.'.'.$ext;
                $latest_image                      = '/admin/upload/home_banner/'.$random_file_name;

                if(move_uploaded_file($file_tmp,env('BASE_PATH').$latest_image))
                {
                    $arr_data['banner']      = $latest_image;
                }
            } 

        $offers = \DB::table('comm_home_banner')->where(['id'=>$id])->update($arr_data);

        if (!empty($offers))
        {
            Session::flash('success', 'Success! Record updated successfully.');
            return \Redirect::to('admin/comm_home_banner');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }

    public function update_commercial_offer(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
                'car_maker'=> 'required',
                'varient' => 'required',
                'color'=> 'required',
                'image'=> 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        $arr_data             = [];
        $arr_data['car_maker']     = $request->input('car_maker');
        $arr_data['varient']     = $request->input('varient');
        $arr_data['color']     = $request->input('color');
        if(isset($_FILES["image"]["name"]) && !empty($_FILES["image"]["name"]))
            {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < 18; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
          
                $file_name                         = $_FILES["image"]["name"];
                $file_tmp                          = $_FILES["image"]["tmp_name"];
                $ext                               = pathinfo($file_name,PATHINFO_EXTENSION);
                $random_file_name                  = $randomString.'.'.$ext;
                $latest_image                      = '/admin/upload/offers/'.$random_file_name;

                if(move_uploaded_file($file_tmp,env('BASE_PATH').$latest_image))
                {
                    $arr_data['image']      = $latest_image;
                }
            } 

        $offers = \DB::table('commercial_offers')->where(['id'=>$id])->update($arr_data);

        if (!empty($offers))
        {
            Session::flash('success', 'Success! Record updated successfully.');
            return \Redirect::to('admin/commercial_offers');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }
    
    public function view_location($id)
    {
        $arr_data = [];

        $data1     = \DB::table('locations')->where(['id'=>$id])->first();


        $data['data']      = $data1;
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Location';
        return view($this->folder_path.'view_location',$data);
    }

    public function view_offer($id)
    {
        $arr_data = [];

        $data1     = \DB::table('offers')->where(['id'=>$id])->first();


        $data['data']      = $data1;
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Offer';
        return view($this->folder_path.'view_offer',$data);
    }

    public function view_nexa_home_banner($id)
    {
        $arr_data = [];

        $data1     = \DB::table('nexa_home_banner')->where(['id'=>$id])->first();


        $data['data']      = $data1;
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Home Banner';
        return view($this->folder_path.'view_nexa_home_banner',$data);
    }

    public function view_comm_home_banner($id)
    {
        $arr_data = [];

        $data1     = \DB::table('comm_home_banner')->where(['id'=>$id])->first();


        $data['data']      = $data1;
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Home Banner';
        return view($this->folder_path.'view_comm_home_banner',$data);
    }
    
    public function view_nexa_offer($id)
    {
        $arr_data = [];

        $data1     = \DB::table('nexa_offers')->where(['id'=>$id])->first();


        $data['data']      = $data1;
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Offer';
        return view($this->folder_path.'view_nexa_offer',$data);
    }

    public function view_commercial_offer($id)
    {
        $arr_data = [];

        $data1     = \DB::table('commercial_offers')->where(['id'=>$id])->first();


        $data['data']      = $data1;
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Offer';
        return view($this->folder_path.'view_commercial_offer',$data);
    }
    
    public function delete_location($id)
    {
        \DB::table('locations')->where(['id'=>$id])->delete();
        Session::flash('success', 'Success! Record deleted successfully.');
        return \Redirect::back();
    }

    public function delete_offer($id)
    {
        \DB::table('offers')->where(['id'=>$id])->delete();
        Session::flash('success', 'Success! Record deleted successfully.');
        return \Redirect::back();
    }

    public function delete_nexa_offer($id)
    {
        \DB::table('nexa_offers')->where(['id'=>$id])->delete();
        Session::flash('success', 'Success! Record deleted successfully.');
        return \Redirect::back();
    }

    public function delete_nexa_home_banner($id)
    {
        \DB::table('nexa_home_banner')->where(['id'=>$id])->delete();
        Session::flash('success', 'Success! Record deleted successfully.');
        return \Redirect::back();
    }

    public function delete_comm_home_banner($id)
    {
        \DB::table('comm_home_banner')->where(['id'=>$id])->delete();
        Session::flash('success', 'Success! Record deleted successfully.');
        return \Redirect::back();
    }
    
    public function delete_commercial_offer($id)
    {
        \DB::table('commercial_offers')->where(['id'=>$id])->delete();
        Session::flash('success', 'Success! Record deleted successfully.');
        return \Redirect::back();
    }
    
    public function nexa_locations(Request $request)
    {
        $arr_data = [];
        $arr_data = \DB::table('nexa_locations')
                        ->get();

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'nexa_locations',$data);
    }

    public function add_nexa_location(Request $request)
    {
        $data['page_name'] = "Add";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Location';
        return view($this->folder_path.'add_nexa_location',$data);
    }

    public function store_nexa_location(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'city'     => 'required',
                'area'     => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        $is_exist = \DB::table('nexa_locations')
                    ->where(['city'=>$request->input('city')])
                    ->where(['area'=>$request->input('area')])
                    ->count();

        if($is_exist)
        {
            Session::flash('error', "area already exist for this city!");
            return \Redirect::back();
        }

        $arr_data             = [];
        $arr_data['city']     = $request->input('city');
        $arr_data['area']     = $request->input('area');
        $arr_data['is_active']= '1';
        $location             = \DB::table('nexa_locations')->insert($arr_data);
        $location             = \DB::table('locations')->insert($arr_data);
        if (!empty($location))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('admin/nexa_locations');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }

    public function change_nexa_location_status($id)
    {
        $data =  \DB::table('nexa_locations')->where(['id'=>base64_decode($id)])->first();
        //dd($data->is_active);
        if($data->is_active=='0')
        {
            $location = \DB::table('nexa_locations')->where(['id'=>base64_decode($id)])->update(['is_active'=>'1']);
         ;
            Session::flash('success', 'Success! Record activated successfully.');
        }
        else
        {
            $location = \DB::table('nexa_locations')->where(['id'=>base64_decode($id)])->update(['is_active'=>'0']);
         
            Session::flash('success', 'Success! Record deactivated successfully.');
        }
        return \Redirect::to('admin/nexa_locations');
    }

    public function edit_nexa_location($id)
    {
        $arr_data = [];
        $arr_data     = \DB::table('nexa_locations')->where(['id'=>$id])->first();
        $data['data']      = $arr_data;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Location';
        return view($this->folder_path.'edit_nexa_location',$data);
    }

    public function update_nexa_location(Request $request,$id)
    {
         $validator = Validator::make($request->all(), [
                'city'     => 'required',
                'area'     => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        $is_exist = \DB::table('nexa_locations')
                    ->where(['city'=>$request->input('city')])
                    ->where(['area'=>$request->input('area')])
                    ->count();

        if($is_exist)
        {
            Session::flash('error', "area already exist for this city!");
            return \Redirect::back();
        }

        $arr_data             = [];
        $arr_data['city']     = $request->input('city');
        $arr_data['area']     = $request->input('area');

        $location = \DB::table('nexa_locations')->where(['id'=>$id])->update($arr_data);

        if (!empty($location))
        {
            Session::flash('success', 'Success! Record updated successfully.');
            return \Redirect::to('admin/nexa_locations');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }

    public function view_nexa_location($id)
    {
        $arr_data = [];

        $data1     = \DB::table('nexa_locations')->where(['id'=>$id])->first();


        $data['data']      = $data1;
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Location';
        return view($this->folder_path.'view_nexa_location',$data);
    }

    public function delete_nexa_location($id)
    {
        \DB::table('nexa_locations')->where(['id'=>$id])->delete();
        Session::flash('success', 'Success! Record deleted successfully.');
        return \Redirect::back();
    }

    public function commercial_locations(Request $request)
    {
        $arr_data = [];
        $arr_data = \DB::table('commercial_locations')
                        ->get();

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'commercial_locations',$data);
    }

    public function add_commercial_location(Request $request)
    {
        $data['page_name'] = "Add";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Location';
        return view($this->folder_path.'add_commercial_location',$data);
    }

    public function store_commercial_location(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'city'     => 'required',
                'area'     => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        $is_exist = \DB::table('commercial_locations')
                    ->where(['city'=>$request->input('city')])
                    ->where(['area'=>$request->input('area')])
                    ->count();

        if($is_exist)
        {
            Session::flash('error', "area already exist for this city!");
            return \Redirect::back();
        }

        $arr_data             = [];
        $arr_data['city']     = $request->input('city');
        $arr_data['area']     = $request->input('area');
        $arr_data['is_active']= '1';
        $location             = \DB::table('commercial_locations')->insert($arr_data);
        $location             = \DB::table('locations')->insert($arr_data);
        if (!empty($location))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('admin/commercial_locations');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }

    public function change_commercial_location_status($id)
    {
        $data =  \DB::table('commercial_locations')->where(['id'=>base64_decode($id)])->first();
        //dd($data->is_active);
        if($data->is_active=='0')
        {
            $location = \DB::table('commercial_locations')->where(['id'=>base64_decode($id)])->update(['is_active'=>'1']);
         ;
            Session::flash('success', 'Success! Record activated successfully.');
        }
        else
        {
            $location = \DB::table('commercial_locations')->where(['id'=>base64_decode($id)])->update(['is_active'=>'0']);
         
            Session::flash('success', 'Success! Record deactivated successfully.');
        }
        return \Redirect::to('admin/commercial_locations');
    }

    public function edit_commercial_location($id)
    {
        $arr_data = [];
        $arr_data     = \DB::table('commercial_locations')->where(['id'=>$id])->first();
        $data['data']      = $arr_data;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Location';
        return view($this->folder_path.'edit_commercial_location',$data);
    }

    public function update_commercial_location(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
                'city'     => 'required',
                'area'     => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        $is_exist = \DB::table('commercial_locations')
                    ->where(['city'=>$request->input('city')])
                    ->where(['area'=>$request->input('area')])
                    ->count();

        if($is_exist)
        {
            Session::flash('error', "area already exist for this city!");
            return \Redirect::back();
        }

        $arr_data             = [];
        $arr_data['city']     = $request->input('city');
        $arr_data['area']     = $request->input('area');

        $location = \DB::table('commercial_locations')->where(['id'=>$id])->update($arr_data);

        if (!empty($location))
        {
            Session::flash('success', 'Success! Record updated successfully.');
            return \Redirect::to('admin/commercial_locations');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }

    public function view_commercial_location($id)
    {
        $arr_data = [];

        $data1     = \DB::table('commercial_locations')->where(['id'=>$id])->first();


        $data['data']      = $data1;
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Location';
        return view($this->folder_path.'view_commercial_location',$data);
    }

    public function delete_commercial_location($id)
    {
        \DB::table('commercial_locations')->where(['id'=>$id])->delete();
        Session::flash('success', 'Success! Record deleted successfully.');
        return \Redirect::back();
    }
    
    public  function get_list($table_name,$area=Null)
    {
        $session_user = Session::get('user');
        if($session_user->role!='admin' && $area!=NULL){ 
            $city = $session_user->city;
            $area1 = $session_user->area;
            $data = \DB::table($table_name)
                 ->where(['city'=>$city,'area'=>$area1])
                 ->orderBy('id','DESC')
                 ->get();
        }
        elseif($session_user->role!='admin' && $area==NULL)
        {
            $city = $session_user->city;
            $data = \DB::table($table_name)
                 ->where(['city'=>$city])
                 ->orderBy('id','DESC')
                 ->get();
        }
        elseif($session_user->role=='admin')
        {
            $data = \DB::table($table_name)->orderBy('id','DESC')->get();
        }

        return $data;
    }
    
    
    
    
    
    
    

   
}

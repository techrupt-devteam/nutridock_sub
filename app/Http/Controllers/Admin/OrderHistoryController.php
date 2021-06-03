<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\MenuModel;
use App\Models\SubscriberMealPlan;
use App\Models\SubscriberDetails;
use App\Models\User;
use App\Models\City;
use App\Models\State;
use App\Models\Kitchen;
use App\Models\Order;
use App\Models\MealType;
use Config;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Input;
use Image;
use Session; 
use Sentinel;
use Validator;
use DB;

class OrderHistoryController extends Controller
{
    public function __construct(MealType $MealType,MenuModel $MenuModel,City $City,State $State,User $User,SubscriberMealPlan $SubscriberMealPlan,SubscriberDetails $SubscriberDetails,Kitchen $Kitchen,Order $Order)
    {
        $data                            = [];
        $this->base_model                = $Order; 
        $this->title                     = "Order";
        $this->url_slug                  = "order";
        $this->folder_path               = "admin/order/";
    }

    //Menu  Function
    public function index()
    {
        $arr_data = [];

        $user = Session::get('user');
        if($user->roles=="admin"){
        $data  =  DB::table('nutri_trn_order_history as mp')
                           ->Join('nutri_dtl_subscriber as sub','mp.subscriber_dtl_id','=','sub.id')
                           ->Join('city as city','sub.city','=','city.id')
                           ->Join('nutri_mst_menu as menu','mp.menu_id','=','menu.id')
                           ->Join('nutri_mst_subscriber as suber','sub.subscriber_id','=','suber.id')
                           ->select('mp.*','city.city_name','sub.subscriber_name','suber.mobile','sub.subscriber_name','sub.address1','sub.address2','sub.id as subscriber_dtl_id','suber.id as subscriber_id','menu.item_id','menu.id as mid','menu.menu_title','sub.city','sub.state')
                           ->orderBy('order_id','DESC')
                           ->get(); 
        }
        else
        {
          $data  =  DB::table('nutri_trn_order_history as mp')
                           ->Join('nutri_dtl_subscriber as sub','mp.subscriber_dtl_id','=','sub.id')
                           ->Join('city as city','sub.city','=','city.id')
                           ->Join('nutri_mst_menu as menu','mp.menu_id','=','menu.id')
                           ->Join('nutri_mst_kitchen as kitchen','mp.customer_key','=','kitchen.customer_key')
                           ->Join('nutri_mst_subscriber as suber','sub.subscriber_id','=','suber.id')
                           ->where('kitchen.state_id','=',$user->state)
                           ->where('kitchen.city_id','=',$user->city)
                           ->where('kitchen.area_id','=',$user->area)
                           ->select('mp.*','city.city_name','sub.subscriber_name','suber.mobile','sub.subscriber_name','sub.address1','sub.address2','sub.id as subscriber_dtl_id','suber.id as subscriber_id','menu.item_id','menu.id as mid','menu.menu_title','sub.city','sub.state')
                           ->orderBy('order_id','DESC')
                           ->get(); 
        }
        //dd($order_history);               
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

    // order details 
    public function details(Request $request)
    {

        $id       = $request->order_id;
        $data     = [];
        $arr_data =  DB::table('nutri_trn_order_history as mp')
                     ->Join('nutri_dtl_subscriber as sub','mp.subscriber_dtl_id','=','sub.id')
                     ->Join('nutri_mst_kitchen as kitchen','mp.customer_key','=','kitchen.customer_key')
                     ->Join('city as city','sub.city','=','city.id')
                     ->Join('nutri_mst_menu as menu','mp.menu_id','=','menu.id')
                     ->Join('nutri_mst_subscriber as suber','sub.subscriber_id','=','suber.id')
                     ->where('order_id','=',$id)
                     ->select('mp.*','city.city_name','sub.subscriber_name','suber.mobile','sub.subscriber_name','sub.address1','sub.address2','sub.id as subscriber_dtl_id','suber.id as subscriber_id','menu.item_id','menu.id as mid','menu.menu_title','sub.city','sub.state','kitchen.kitchen_name')
                     ->get()->toArray(); 
       // dd($data);
        $data['data']   = $arr_data[0];
        return view($this->folder_path.'order-details',$data);
    }


    //order push resend 
    public function order_resend(Request $request)
    {
        $id         = $request->order_id;
        $data        = [];
        $arr_data    = DB::table('nutri_trn_order_history as mp')
                       ->Join('nutri_dtl_subscriber as sub','mp.subscriber_dtl_id','=','sub.id')
                       ->Join('nutri_mst_kitchen as kitchen','mp.customer_key','=','kitchen.customer_key')
                       ->Join('city as city','sub.city','=','city.id')
                       ->Join('nutri_mst_menu as menu','mp.menu_id','=','menu.id')
                       ->Join('nutri_mst_subscriber as suber','sub.subscriber_id','=','suber.id')
                       ->where('order_id','=',$id)
                       ->select('mp.*','city.city_name','sub.subscriber_name','suber.mobile','sub.subscriber_name','sub.address1','sub.address2','sub.id as subscriber_dtl_id','suber.id as subscriber_id','menu.item_id','menu.id as mid','menu.menu_title','sub.city','sub.state','kitchen.kitchen_name','mp.mealtype as meal_type_name')
                       ->get()->toArray();

       $current_date = strtotime(date('Y-m-d'));
       $bill_date    = strtotime($arr_data[0]->bill_date);


       if($current_date > $bill_date){
            return "date_error";
        }
        else{

            $order_push = $this->order_push($arr_data[0]);
            $value = $arr_data[0];
            if(isset($order_push['source']['order_id']) && !empty($order_push['source']['order_id']))
            {
                $arr_data                      = [];
                $arr_data['order_no']          = $order_push['source']['order_id'];
                $arr_data['bill_no']           = $order_push['billNumber'];
                $arr_data['order_status']      = 'y';
                //$arr_data['bill_date']         = date('y-m-d');
                $arr_data['order_resend']      = 'y';
                $arr_data['bill_id']           = $order_push['_id'];
                $user = Session::get('user');
                if($user->roles!="admin"){ 
                  $arr_data['login_user_id']   = $user->id;
                }

                
                $order_push                    = $this->base_model
                                                 ->where(['order_id'=>$id])
                                                 ->update($arr_data);
                return "success";
            }
          
        }
       /* else if(isset($order_push['status']) && $order_push['status']=="error")
        {
            $arr_data                      = [];
            $arr_data['order_no']          = NULL;
            $arr_data['bill_no']           = NULL;
            $arr_data['bill_id']           = NULL;
            $arr_data['menu_id']           = $value->mid;
            $arr_data['mealtype']          = $value->meal_type_name;
            $arr_data['subscriber_id']     = $value->subscriber_id;
            $arr_data['subscriber_dtl_id'] = $value->subscriber_dtl_id;
            $arr_data['nutritionist_id']   = $value->nutritionist_id;
            $arr_data['mobile']            = $value->mobile;
            $arr_data['order_status']      = 'n';
            $arr_data['state']             = $value->state;
            $arr_data['city']              = $value->city;
            $arr_data['customer_key']      = $value->customer_key;
            $arr_data['bill_date']         = date('y-m-d');
            $order_push                    = $this->base_order->where(['order_id'=>$id])->update($arr_data);
        }*/
    }

    private function order_push($data)
    {
            $customer_key   = $data->customer_key;
            // $order_id      = $data->program_id."-".date('Y-m-d');
            $order_id       = "test".$data->mid.rand();
            $customer_name  = $data->subscriber_name;
            $mobile         = $data->mobile;
            $address1       = $data->address1;
            $address2       = $data->address2;
            $city           = $data->city_name;
            $item_id        = $data->item_id;
            $meal_type_name = $data->meal_type_name;

            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_PORT => "9010",
            CURLOPT_URL => "http://18.140.214.202:9010/api/v1/online_order/push?customer_key=".$customer_key,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            /*CURLOPT_POSTFIELDS => "{\n\t\"source\": {\n\t\t\"name\": \"Nutridockfit ".$meal_type_name."\",\n\t\t\"id\": \"Syx3IXCI\",\n\t\t\"order_id\": \"".$order_id."\"\n\t},\n\t\"payments\": {\n\t\t\"type\": \"Subscription\"\n\t},\n\t\"discount\": {\n\t\t\"type\": \"fixed\",\n\t\t\"value\": 10\n\t},\n\t\"charges\": [\n\t\t{\n\t\t\t\"name\": \"Delivery Charge\",\n\t\t\t\"value\": 30\n\t\t}\n\t],\n\t\"customer\": {\n\t\t\"firstname\": \"".$customer_name."\",\n\t\t\"mobile\": \"".$mobile."\",\n\t\t\"addType\": \"home\",\n\t\t\"address1\": \"".$address1."\",\n\t\t\"address2\": \"".$address2."\",\n\t\t\"city\": \"".$city."\"\n\t},\n\t\"tabType\": \"delivery\",\n\t\"items\": [\n\t\t{\n\t\t\t\"id\": \"".$item_id."\",\n\t\t\t\"quantity\": 1,\n\t\t\t\"discounts\": [\n\t\t\t\t{\n\t\t\t\t\t\"value\": 10,\n\t\t\t\t\t\"type\": \"percentage\"\n\t\t\t\t}\n\t\t\t]\n\t\t}\n\t]\n}",*/
             CURLOPT_POSTFIELDS => "{\n\t\"source\": {\n\t\t\"name\": \"Nutridockfit ".$meal_type_name."\",\n\t\t\"id\": \"Syx3IXCI\",\n\t\t\"order_id\": \"".$order_id."\"\n\t},\n\t\"payments\": {\n\t\t\"type\": \"Online\"\n\t},\n\t\"charges\": [\n\t\t{\n\t\t\t\"name\": \"Delivery Charge\",\n\t\t\t\"value\": 30\n\t\t}\n\t],\n\t\"customer\": {\n\t\t\"firstname\": \"".$customer_name."\",\n\t\t\"mobile\": \"".$mobile."\",\n\t\t\"addType\": \"home\",\n\t\t\"address1\": \"".$address1."\",\n\t\t\"address2\": \"".$address2."\",\n\t\t\"city\": \"".$city."\"\n\t},\n\t\"tabType\": \"delivery\",\n\t\"items\": [\n\t\t{\n\t\t\t\"id\": \"".$item_id."\",\n\t\t\t\"quantity\": 1\n\t\t}\n\t]\n}",
            CURLOPT_HTTPHEADER => array(
            "authorization: Basic U3lVQWtXMTFPOmU0Skd5UzVCVHczLzVQSUdicmZ0aDJVT2tkSzl2bEtMaTdTa0taRE5zQk09",
            "content-type: application/json"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
          //echo "cURL Error #:" . $err;
          return $err;
          //$msg ="fail"
        } else {            
          $result = json_decode($response,true);
          return $result;          
        }

    }

   
}

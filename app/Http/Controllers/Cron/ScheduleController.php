<?php
namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\SubscriberMealPlan;
use App\Models\SubscriberDetails;
use App\Models\User;
use App\Models\City;
use App\Models\State;
use App\Models\Kitchen;
use App\Models\Order;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use DateTime;
use Config;
use Image;
use Session;
use Sentinel;
use DB;

class ScheduleController extends Controller
{
    public function __construct(City $City,State $State,User $User,SubscriberMealPlan $SubscriberMealPlan,SubscriberDetails $SubscriberDetails,Kitchen $Kitchen,Order $Order)
    {
        $data                           = [];
        $this->base_users               = $User; 
        $this->base_city                = $City; 
        $this->base_state               = $State; 
        $this->base_kitchen             = $Kitchen; 
        $this->base_order               = $Order; 
        $this->base_subscribermealplan  = $SubscriberMealPlan; 
        $this->base_subscriber_details  = $SubscriberDetails; 
    }
 
    public function meal(Request $request)
    {
        $date     = '2021-06-04';
        $get_meal =  DB::table('nutri_subscriber_meal_program as mp')
                       ->Join('nutri_dtl_subscriber as sub','mp.subcriber_id','=','sub.id')
                       ->Join('city as city','sub.city','=','city.id')
                       ->Join('nutri_mst_subscriber as suber','sub.subscriber_id','=','suber.id')
                       ->Join('nutri_mst_menu as menu','mp.menu_id','=','menu.id')
                       ->Join('meal_type as mealtp','mp.mealtype','=','mealtp.meal_type_id')
                       ->where('mp.meal_on_date','=',$date)
                       ->where('mp.skip_meal_flag','=','n')
                       ->select('mp.*','city.city_name','sub.subscriber_name','suber.mobile','sub.subscriber_name','sub.address1','sub.address2','sub.id as subscriber_dtl_id','suber.id as subscriber_id','menu.item_id','menu.id as mid','mealtp.meal_type_name','sub.city','sub.state')
                       ->get(); 
  
        foreach ($get_meal as $key => $value) 
        {
            $order_push = $this->order_push($value);
           
            /*echo "<br/>===================================================";
            echo "<br/> Order_number = ".$order_push['source']['order_id'];
            echo "<br/>===================================================";
            echo "<br/> BillNumber   = ".$order_push['billNumber'];
            echo "<br/>===================================================";
            echo "<br/> Billid       = ".$order_push['_id'];
            echo "<br/>===================================================";*/

            
            if(isset($order_push['source']['order_id']) && !empty($order_push['source']['order_id']))
            {
                $arr_data                      = [];
                $arr_data['order_no']          = $order_push['source']['order_id'];
                $arr_data['bill_no']           = $order_push['billNumber'];
                $arr_data['bill_id']           = $order_push['_id'];
                $arr_data['menu_id']           = $value->mid;
                $arr_data['mealtype']          = $value->meal_type_name;
                $arr_data['subscriber_id']     = $value->subscriber_id;
                $arr_data['program_id']        = $value->program_id;
                $arr_data['subscriber_dtl_id'] = $value->subscriber_dtl_id;
                $arr_data['nutritionist_id']   = $value->nutritionist_id;
                $arr_data['mobile']            = $value->mobile;
                $arr_data['state']             = $value->state;
                $arr_data['order_status']      = 'y';
                $arr_data['city']              = $value->city;
                $arr_data['customer_key']      = "7c446cd81e807a77a9c3bf436f48d1aa722bf768f22a145c85aeb2ec416216d6a12a6bfecd0906b712bafb17ee16b9fc";
                $arr_data['bill_date']         = date('y-m-d',strtotime($date));
                $order_push                    = $this->base_order->create($arr_data);
            }
            else if(isset($order_push['status']) && $order_push['status']=="error")
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
                $arr_data['customer_key']      = "7c446cd81e807a77a9c3bf436f48d1aa722bf768f22a145c85aeb2ec416216d6a12a6bfecd0906b712bafb17ee16b9fc";
                $arr_data['bill_date']         = date('y-m-d',strtotime($date));
                $order_push                    = $this->base_order->create($arr_data);
            }

        }      
    }

    private function order_push($data)
    {
            $customer_key   = "7c446cd81e807a77a9c3bf436f48d1aa722bf768f22a145c85aeb2ec416216d6a12a6bfecd0906b712bafb17ee16b9fc";
            // $order_id      = $data->program_id."-".date('Y-m-d');
            $order_id       = $data->mid.rand(0,4);
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
        echo $response;        
          $result = json_decode($response,true);


          return $result;
          
        }

    }

    public function http_order()
    {
        $request = new HttpRequest();
        $request->setUrl('http://18.140.214.202:9010/api/v1/online_order/push');
        $request->setMethod('post');
        $request->setQueryData(array(
          'customer_key' => '7c446cd81e807a77a9c3bf436f48d1aa722bf768f22a145c85aeb2ec416216d6a12a6bfecd0906b712bafb17ee16b9fc'
        ));

        $request->setHeaders(array(
          'authorization' => 'Basic U3lVQWtXMTFPOmU0Skd5UzVCVHczLzVQSUdicmZ0aDJVT2tkSzl2bEtMaTdTa0taRE5zQk09',
          'content-type' => 'application/json'
        ));

        $request->setBody('{
            "source": {
                "name": "Nutridockfit",
                "id": "Syx3IXCI",
                "order_id": "1004"
            },
            "payments": {
                "type": "COD"
            },
            "discount": {
                "type": "fixed",
                "value": 10
            },
            "charges": [
                {
                    "name": "Delivery Charge",
                    "value": 30
                }
            ],
            "customer": {
                "firstname": "shiv",
                "mobile": "7838088743",
                "addType": "home",
                "address1": "A-10",
                "address2": "Sector 62",
                "city": "Noida"
            },
            "tabType": "delivery",
            "items": [
                {
                    "id": "60114ad73bb672176ede9446",
                    "quantity": 1,
                    "discounts": [
                        {
                            "value": 10,
                            "type": "percentage"
                        }
                    ]
                }
            ]
        }');

        try {
          $response = $request->send();

          echo"<pre>"; 
          print_r(json_decode($response->getBody(),true));
        } catch (HttpException $ex) {
          echo $ex;
        }
    }
    
}

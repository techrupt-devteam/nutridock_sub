<?php
namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use App\Http\Controllers\DateTime;
use App\Http\Requests;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Arr;


/* All the models included */
use App\Models\PhysicalActivity;
use App\Models\SubscribeNowPlan;
use App\Models\FoodAvoid;
use App\Models\MealType;
use App\Models\SubscribeNow;

use Session;
use Sentinel;
use DB;
use Validator;
use URL;


class PurchaseNewSubscriptionController extends Controller
{
    function __construct() {
        // $this->PhysicalActivity = new PhysicalActivity();
    }
    
   public function purchaseNewSubscription() {
        if(Session::get('subscriber_mobile') && Session::get('subscriber_email'))
        {
            return redirect('subscribe-info');
        }

   }     

}
?>
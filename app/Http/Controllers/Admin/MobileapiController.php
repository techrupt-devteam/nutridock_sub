<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Session;
use Sentinel;
use Validator;
use Razorpay\Api\Api;


class MobileapiController extends Controller
{
    public function __construct()
    {
        if (isset($_SERVER['HTTP_ORIGIN']))
        {
                // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
                // you want to allow, and if so:
                header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
                header('Access-Control-Allow-Credentials: true');
                header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }

        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            {
                // may also be using PUT, PATCH, HEAD etc
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");                         
            }    

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            {
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            }

            exit(0);
        }
        define('GOOGLE_API_KEY', 'AAAAiRGzWrQ:APA91bFM4WP5EtMe-UXi6NgqsxVJeZ_MtyNs3u6g98Fq_lwLTrmlncbIcQzQLjH8ekTCHHLA2Mwqmplt5616GkGLWMprLWpQNiw4Cda8d-FWiiCBB8DCVlcM7U2yL_OKBsZ7UdEJA0M8');
        $this->min_order_value = 1;
        $this->delivery_fees   = 1;
    }

    public function capture_payment(Request $request)
    {
       // $arr_data['transaction_id']    = $request->input('transaction_id');
        
        $token_id = base64_decode($request->input('token_id'));
        $booking = \DB::table('booking')->where(['id'=>$token_id])->first();       
        $amount_ = $booking->amount;
        date_default_timezone_set("Asia/Kolkata");
  
        try 
        {
            $api      = new Api('rzp_live_qW1poYrCW3uQa9', 'JvZheGKSrCC9aeBkWaN9SV6O');
            $payment  = $api->payment->fetch($request->input('razorpay_payment_id'))->capture(array('amount'=>$amount_*100));
            $payment  = $api->payment->fetch($request->input('razorpay_payment_id'));
        }
        catch(Exception $e) 
        {
            header("Location: http://marutiseva.com/demo/failed.php");
            exit();
        }
        if($payment->status=="captured")
        {
            \DB::table('booking')->where(['id'=>$token_id])->update(['status'=>'Paid','booking_date'=>date('d/m/Y h:i:s A'),'transaction_id'=>$request->input('razorpay_payment_id')]);

            $full_name = $booking->name;
            $vehicle = $booking->car;
            $varient=$booking->varient;
            $amount = $booking->amount;
            $phone_no = $booking->mobile;


                $s = ucfirst($vehicle);
                    $bar = ucwords(strtolower($s));
                    $car = preg_replace('/\s+/', '', $bar);

                    $v = ucfirst($varient);
                    $va = ucwords(strtolower($v));
                    $var = preg_replace('/\s+/', '', $va);
                    
                    $n = ucfirst($full_name);
                    $na = ucwords(strtolower($n));
                    $name = preg_replace('/\s+/', '', $na);

                    $url="http://www.smsjust.com/sms/user/urlsmstemp.php?username=sevanashik&pass=3701@seva&senderid=SEVAgp&dest_mobileno=91".$phone_no."&tempid=78592&F1=".$name."&F2=".$car. ' ' .$var."&F3=".$amount."&response=Y";

                    $ch = curl_init($url);
                    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
                    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                    $result = curl_exec($ch );
                   
                  
                    if(curl_errno($ch))
                    {
                    echo 'error:' . curl_error($ch);
                    }

                    curl_close( $ch );
            $from = "it@sevagroup.co.in";
            $to = $booking->email;
            $subject = 'Seva Booking Receipt';
            $headers = "From:". $from;
            $headers .= "Reply-To: it@sevagroup.co.in\r\n";
            $headers .= "CC: it@sevagroup.co.in\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";



            $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Receipt</title>
</head>

<body>
<table width="900px" border="0" cellspacing="0" cellpadding="10" style="margin:0 auto; font-family:Arial, Helvetica, sans-serif; font-size:12px">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td><img src="http://marutiseva.com/demo/assets/images/logo.png" /></td>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" style="font-size:14px; text-transform:uppercase; font-weight:bold; padding:5px 0">Receipt</td>
  </tr>
  <tr>
    <td align="center" style="font-size:20px; text-transform:uppercase; font-weight:bold; padding:5px 0">Seva Automotive PVT.LTD.</td>
  </tr>
  <tr>
    <td align="center" style="padding:5px 0">x-46, MIDC, AMBAD, Nashik - 422010.</td>
  </tr>
  <tr>
    <td align="center" style="padding:5px 0">TEL :(0253) 6644444 (30 Lines), E-mail: seva.nsk.sal1@marutidealers.com</td>
  </tr>
  <tr>
    <td align="center">
    <ul style="padding-left:0; list-style:disc; margin:5px 0">
    <li style="display:inline-block; padding:0 10px"><strong>GST No.: 27AAACS7220H1ZI </strong></li>
    <li style="display:inline-block; padding:0 10px"><strong>CIN No. : U34300MH1981PTC023666</strong></li>
    <li style="display:inline-block; padding:0 10px"><strong>PAN No.: AAACS7220H</strong></li>
    </ul>
    </td>
  </tr>
    </table>
</td>
    <td align="center"><img src="http://marutiseva.com/admin/admin_css_js/css_and_js/maruti-suzuki-logo.png" width="180" /></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="70%"><table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td>Receipt No.</td>
            <td>#000'.$booking->id.'</td>
          </tr>
          <tr>
            <td>Name</td>
            <td>'.$booking->name.'</td>
          </tr>
          <tr>
            <td>Address</td>
            <td>'.$booking->address.'</td>
          </tr>
          <tr>
            <td>Remarks</td>
            <td>Good</td>
          </tr>
          <tr>
            <td>Order/ Inv No:</td>
            <td>#00'.$booking->id.'</td>
          </tr>
          <tr>
            <td>Model</td>
            <td>'.$booking->varient.'</td>
          </tr>
        </table></td>
        <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td>Receipt Date</td>
            <td>'.$booking->created_at.'</td>
          </tr>
          <tr>
            <td>Receipt Amount</td>
            <td>'.$booking->amount.'</td>
          </tr>
         
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Srl</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Mode</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>DD/CC/CHQ No.</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Date</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Favouring</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Drwan On</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Deposit Bank Name</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Amount</strong></td>
      </tr>
      <tr>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">1</td>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">Cash</td>
        <td height="40" align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">'.$booking->amount.'</td>
      </tr>
      
      <tr>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td>Total</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Amount In Words</td>
            <td>Rupees: Five Thousand</td>
          </tr>
          <tr>
            <td>Terms &amp; Conditions</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
        <td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
          <tr>
            <td align="center">For Seva Automotive PVT.LTD.</td>
          </tr>
          <tr>
            <td height="60" align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="center">authorized by</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>

';
 mail($to, $subject, $message, $headers); //customer Mail
            $from = "it@sevagroup.co.in";
            $headers1 = "From:". $from;
            $headers1 .= "Reply-To: it@sevagroup.co.in\r\n";
            $headers1 .= "CC: it@sevagroup.co.in\r\n";
            $headers1 .= "MIME-Version: 1.0\r\n";
            $headers1 .= "Content-Type: text/html; charset=UTF-8\r\n";
            $subject1 = 'Seva Booking Receipt';
            if($booking->city == 'Nashik'){
                $admin="seva.nsk.sm1@marutidealers.com";
                // $admin="mayuri.hoh@gmail.com";
            }elseif($booking->city == 'Nagpur'){
                 $admin="seva.ngp.sal1@marutidealers.com";
            }elseif($booking->city == 'Nanded'){
                 $admin="seva.nnd.sm1@marutidealers.com";
            }else{
                $admin="seva.dhl.sm1@marutidealers.com";
            }
            $message1 = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Receipt</title>
</head>

<body>
<table width="900px" border="0" cellspacing="0" cellpadding="10" style="margin:0 auto; font-family:Arial, Helvetica, sans-serif; font-size:12px">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td><img src="http://marutiseva.com/assets/images/logo.png" /></td>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" style="font-size:14px; text-transform:uppercase; font-weight:bold; padding:5px 0">Receipt</td>
  </tr>
  <tr>
    <td align="center" style="font-size:20px; text-transform:uppercase; font-weight:bold; padding:5px 0">Seva Automotive PVT.LTD.</td>
  </tr>
  <tr>
    <td align="center" style="padding:5px 0">x-46, MIDC, AMBAD, Nashik - 422010.</td>
  </tr>
  <tr>
    <td align="center" style="padding:5px 0">TEL :(0253) 6644444 (30 Lines), E-mail: seva.nsk.sal1@marutidealers.com</td>
  </tr>
  <tr>
    <td align="center">
    <ul style="padding-left:0; list-style:disc; margin:5px 0">
    <li style="display:inline-block; padding:0 10px"><strong>GST No.: 27AAACS7220H1ZI </strong></li>
    <li style="display:inline-block; padding:0 10px"><strong>CIN No. : U34300MH1981PTC023666</strong></li>
    <li style="display:inline-block; padding:0 10px"><strong>PAN No.: AAACS7220H</strong></li>
    </ul>
    </td>
  </tr>
    </table>
</td>
    <td align="center"><img src="http://marutiseva.com/admin/admin_css_js/css_and_js/maruti-suzuki-logo.png" width="180" /></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="70%"><table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td>Receipt No.</td>
            <td>#000'.$booking->id.'</td>
          </tr>
          <tr>
            <td>Name</td>
            <td>'.$booking->name.'</td>
          </tr>
          <tr>
            <td>Address</td>
            <td>'.$booking->address.'</td>
          </tr>
          <tr>
            <td>Remarks</td>
            <td>Good</td>
          </tr>
          <tr>
            <td>Order/ Inv No:</td>
            <td>#00'.$booking->id.'</td>
          </tr>
          <tr>
            <td>Model</td>
            <td>'.$booking->varient.'</td>
          </tr>
        </table></td>
        <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td>Receipt Date</td>
            <td>'.$booking->created_at.'</td>
          </tr>
          <tr>
            <td>Receipt Amount</td>
            <td>'.$booking->amount.'</td>
          </tr>
         
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Srl</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Mode</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>DD/CC/CHQ No.</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Date</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Favouring</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Drwan On</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Deposit Bank Name</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Amount</strong></td>
      </tr>
      <tr>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">1</td>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">Cash</td>
        <td height="40" align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">'.$booking->amount.'</td>
      </tr>
      
      <tr>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td>Total</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Amount In Words</td>
            <td>Rupees: Five Thousand</td>
          </tr>
          <tr>
            <td>Terms &amp; Conditions</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
        <td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
          <tr>
            <td align="center">For Seva Automotive PVT.LTD.</td>
          </tr>
          <tr>
            <td height="60" align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="center">authorized by</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>

';
 mail($admin, $subject1, $message1, $headers1);   //admin mail

             header("Location: http://marutiseva.com/success.php");
            exit();
        }
        else
        {
            header("Location: http://marutiseva.com/failed.php");
            exit();
        }
    }

    public function offer_capture_payment(Request $request)
    {
       // $arr_data['transaction_id']    = $request->input('transaction_id');
        
        $token_id = base64_decode($request->input('token_id'));
        $offer_enquiries = \DB::table('offer_enquiries')->where(['id'=>$token_id])->first();       
        $amount_ = $offer_enquiries->amount;
        date_default_timezone_set("Asia/Kolkata");
  
        try 
        {
            $api      = new Api('rzp_live_qW1poYrCW3uQa9', 'JvZheGKSrCC9aeBkWaN9SV6O');
            $payment  = $api->payment->fetch($request->input('razorpay_payment_id'))->capture(array('amount'=>$amount_*100));
            $payment  = $api->payment->fetch($request->input('razorpay_payment_id'));
        }
        catch(Exception $e) 
        {
            header("Location: http://marutiseva.com/demo/failed.php");
            exit();
        }
        if($payment->status=="captured")
        {
            \DB::table('offer_enquiries')->where(['id'=>$token_id])->update(['status'=>'Paid','booking_date'=>date('d/m/Y h:i:s A'),'transaction_id'=>$request->input('razorpay_payment_id')]);

            $full_name = $offer_enquiries->full_name;
            $vehicle = $offer_enquiries->car_maker;
            $varient=$offer_enquiries->varient;
            $amount = $offer_enquiries->amount;
            $phone_no = $offer_enquiries->phone_no;


                $s = ucfirst($vehicle);
                    $bar = ucwords(strtolower($s));
                    $car = preg_replace('/\s+/', '', $bar);

                    $v = ucfirst($varient);
                    $va = ucwords(strtolower($v));
                    $var = preg_replace('/\s+/', '', $va);
                    
                    $n = ucfirst($full_name);
                    $na = ucwords(strtolower($n));
                    $name = preg_replace('/\s+/', '', $na);

                    $url="http://www.smsjust.com/sms/user/urlsmstemp.php?username=sevanashik&pass=3701@seva&senderid=SEVAgp&dest_mobileno=91".$phone_no."&tempid=78592&F1=".$name."&F2=".$car. ' ' .$var."&F3=".$amount."&response=Y";

                    $ch = curl_init($url);
                    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
                    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                    $result = curl_exec($ch );
                   
                  
                    if(curl_errno($ch))
                    {
                    echo 'error:' . curl_error($ch);
                    }

                    curl_close( $ch );
            $from = "it@sevagroup.co.in";
            $to = $offer_enquiries->email;
            $subject = 'Seva Booking Receipt';
            $headers = "From:". $from;
            $headers .= "Reply-To: it@sevagroup.co.in\r\n";
            $headers .= "CC: it@sevagroup.co.in\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";



            $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Receipt</title>
</head>

<body>
<table width="900px" border="0" cellspacing="0" cellpadding="10" style="margin:0 auto; font-family:Arial, Helvetica, sans-serif; font-size:12px">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td><img src="http://marutiseva.com/demo/assets/images/logo.png" /></td>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" style="font-size:14px; text-transform:uppercase; font-weight:bold; padding:5px 0">Receipt</td>
  </tr>
  <tr>
    <td align="center" style="font-size:20px; text-transform:uppercase; font-weight:bold; padding:5px 0">Seva Automotive PVT.LTD.</td>
  </tr>
  <tr>
    <td align="center" style="padding:5px 0">x-46, MIDC, AMBAD, Nashik - 422010.</td>
  </tr>
  <tr>
    <td align="center" style="padding:5px 0">TEL :(0253) 6644444 (30 Lines), E-mail: seva.nsk.sal1@marutidealers.com</td>
  </tr>
  <tr>
    <td align="center">
    <ul style="padding-left:0; list-style:disc; margin:5px 0">
    <li style="display:inline-block; padding:0 10px"><strong>GST No.: 27AAACS7220H1ZI </strong></li>
    <li style="display:inline-block; padding:0 10px"><strong>CIN No. : U34300MH1981PTC023666</strong></li>
    <li style="display:inline-block; padding:0 10px"><strong>PAN No.: AAACS7220H</strong></li>
    </ul>
    </td>
  </tr>
    </table>
</td>
    <td align="center"><img src="http://marutiseva.com/admin/admin_css_js/css_and_js/maruti-suzuki-logo.png" width="180" /></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="70%"><table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td>Receipt No.</td>
            <td>#000'.$offer_enquiries->id.'</td>
          </tr>
          <tr>
            <td>Name</td>
            <td>'.$offer_enquiries->full_name.'</td>
          </tr>
          
          <tr>
            <td>Remarks</td>
            <td>Good</td>
          </tr>
          <tr>
            <td>Order/ Inv No:</td>
            <td>#00'.$offer_enquiries->id.'</td>
          </tr>
          <tr>
            <td>Model</td>
            <td>'.$offer_enquiries->varient.'</td>
          </tr>
        </table></td>
        <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td>Receipt Date</td>
            <td>'.$offer_enquiries->created_at.'</td>
          </tr>
          <tr>
            <td>Receipt Amount</td>
            <td>'.$offer_enquiries->amount.'</td>
          </tr>
         
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Srl</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Mode</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>DD/CC/CHQ No.</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Date</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Favouring</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Drwan On</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Deposit Bank Name</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Amount</strong></td>
      </tr>
      <tr>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">1</td>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">Cash</td>
        <td height="40" align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">'.$offer_enquiries->amount.'</td>
      </tr>
      
      <tr>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td>Total</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Amount In Words</td>
            <td>Rupees: Five Thousand</td>
          </tr>
          <tr>
            <td>Terms &amp; Conditions</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
        <td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
          <tr>
            <td align="center">For Seva Automotive PVT.LTD.</td>
          </tr>
          <tr>
            <td height="60" align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="center">authorized by</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>

';
 mail($to, $subject, $message, $headers); //customer Mail
            $from = "it@sevagroup.co.in";
            $headers1 = "From:". $from;
            $headers1 .= "Reply-To: it@sevagroup.co.in\r\n";
            $headers1 .= "CC: it@sevagroup.co.in\r\n";
            $headers1 .= "MIME-Version: 1.0\r\n";
            $headers1 .= "Content-Type: text/html; charset=UTF-8\r\n";
            $subject1 = 'Seva Booking Receipt';
            $admin="mayuri.hoh@gmail.com";
            // if($offer_enquiries->city == 'Nashik'){
            //     $admin="seva.nsk.sm1@marutidealers.com";
            //     // $admin="mayuri.hoh@gmail.com";
            // }elseif($offer_enquiries->city == 'Nagpur'){
            //      $admin="seva.ngp.sal1@marutidealers.com";
            // }elseif($offer_enquiries->city == 'Nanded'){
            //      $admin="seva.nnd.sm1@marutidealers.com";
            // }else{
            //     $admin="seva.dhl.sm1@marutidealers.com";
            // }
            $message1 = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Receipt</title>
</head>

<body>
<table width="900px" border="0" cellspacing="0" cellpadding="10" style="margin:0 auto; font-family:Arial, Helvetica, sans-serif; font-size:12px">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td><img src="http://marutiseva.com/assets/images/logo.png" /></td>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" style="font-size:14px; text-transform:uppercase; font-weight:bold; padding:5px 0">Receipt</td>
  </tr>
  <tr>
    <td align="center" style="font-size:20px; text-transform:uppercase; font-weight:bold; padding:5px 0">Seva Automotive PVT.LTD.</td>
  </tr>
  <tr>
    <td align="center" style="padding:5px 0">x-46, MIDC, AMBAD, Nashik - 422010.</td>
  </tr>
  <tr>
    <td align="center" style="padding:5px 0">TEL :(0253) 6644444 (30 Lines), E-mail: seva.nsk.sal1@marutidealers.com</td>
  </tr>
  <tr>
    <td align="center">
    <ul style="padding-left:0; list-style:disc; margin:5px 0">
    <li style="display:inline-block; padding:0 10px"><strong>GST No.: 27AAACS7220H1ZI </strong></li>
    <li style="display:inline-block; padding:0 10px"><strong>CIN No. : U34300MH1981PTC023666</strong></li>
    <li style="display:inline-block; padding:0 10px"><strong>PAN No.: AAACS7220H</strong></li>
    </ul>
    </td>
  </tr>
    </table>
</td>
    <td align="center"><img src="http://marutiseva.com/admin/admin_css_js/css_and_js/maruti-suzuki-logo.png" width="180" /></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="70%"><table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td>Receipt No.</td>
            <td>#000'.$offer_enquiries->id.'</td>
          </tr>
          <tr>
            <td>Name</td>
            <td>'.$offer_enquiries->full_name.'</td>
          </tr>
         
          <tr>
            <td>Remarks</td>
            <td>Good</td>
          </tr>
          <tr>
            <td>Order/ Inv No:</td>
            <td>#00'.$offer_enquiries->id.'</td>
          </tr>
          <tr>
            <td>Model</td>
            <td>'.$offer_enquiries->varient.'</td>
          </tr>
        </table></td>
        <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td>Receipt Date</td>
            <td>'.$offer_enquiries->created_at.'</td>
          </tr>
          <tr>
            <td>Receipt Amount</td>
            <td>'.$offer_enquiries->amount.'</td>
          </tr>
         
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Srl</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Mode</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>DD/CC/CHQ No.</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Date</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Favouring</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Drwan On</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Deposit Bank Name</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Amount</strong></td>
      </tr>
      <tr>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">1</td>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">Cash</td>
        <td height="40" align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">'.$offer_enquiries->amount.'</td>
      </tr>
      
      <tr>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td>Total</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Amount In Words</td>
            <td>Rupees: Five Thousand</td>
          </tr>
          <tr>
            <td>Terms &amp; Conditions</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
        <td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
          <tr>
            <td align="center">For Seva Automotive PVT.LTD.</td>
          </tr>
          <tr>
            <td height="60" align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="center">authorized by</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>

';
 mail($admin, $subject1, $message1, $headers1);   //admin mail

             header("Location: http://marutiseva.com/success.php");
            exit();
        }
        else
        {
            header("Location: http://marutiseva.com/failed.php");
            exit();
        }
    }
 public function hardcoded_receipt(Request $request)
    {       
            $from = "it@sevagroup.co.in";
            $admin = 'mayulondhe16@gmail.com';    
            $to = 'mayuri.hoh@gmail.com';
            $subject = 'Seva Booking Receipt';
            $headers1 = "From:". $from;
            $headers1 .= "Reply-To: it@sevagroup.co.in\r\n";
            // $headers1 .= "CC: it@sevagroup.co.in\r\n";
            $headers1 .= "MIME-Version: 1.0\r\n";
            $headers1 .= "Content-Type: text/html; charset=UTF-8\r\n";
            $subject1 = 'Seva Booking Receipt';
            // if($offer_enquiries->city == 'Nashik'){
            //     $admin="seva.nsk.sm1@marutidealers.com";
            //     // $admin="mayuri.hoh@gmail.com";
            // }elseif($offer_enquiries->city == 'Nagpur'){
            //      $admin="seva.ngp.sal1@marutidealers.com";
            // }elseif($offer_enquiries->city == 'Nanded'){
            //      $admin="seva.nnd.sm1@marutidealers.com";
            // }else{
            //     $admin="seva.dhl.sm1@marutidealers.com";
            // }
            $message1 = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Receipt</title>
</head>

<body>
<table width="900px" border="0" cellspacing="0" cellpadding="10" style="margin:0 auto; font-family:Arial, Helvetica, sans-serif; font-size:12px">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td><img src="http://marutiseva.com/assets/images/logo.png" /></td>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" style="font-size:14px; text-transform:uppercase; font-weight:bold; padding:5px 0">Receipt</td>
  </tr>
  <tr>
    <td align="center" style="font-size:20px; text-transform:uppercase; font-weight:bold; padding:5px 0">Seva Automotive PVT.LTD.</td>
  </tr>
  <tr>
    <td align="center" style="padding:5px 0">x-46, MIDC, AMBAD, Nashik - 422010.</td>
  </tr>
  <tr>
    <td align="center" style="padding:5px 0">TEL :(0253) 6644444 (30 Lines), E-mail: seva.nsk.sal1@marutidealers.com</td>
  </tr>
  <tr>
    <td align="center">
    <ul style="padding-left:0; list-style:disc; margin:5px 0">
    <li style="display:inline-block; padding:0 10px"><strong>GST No.: 27AAACS7220H1ZI </strong></li>
    <li style="display:inline-block; padding:0 10px"><strong>CIN No. : U34300MH1981PTC023666</strong></li>
    <li style="display:inline-block; padding:0 10px"><strong>PAN No.: AAACS7220H</strong></li>
    </ul>
    </td>
  </tr>
    </table>
</td>
    <td align="center"><img src="http://marutiseva.com/admin/admin_css_js/css_and_js/maruti-suzuki-logo.png" width="180" /></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="70%"><table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td>Receipt No.</td>
            <td>#000169</td>
          </tr>
          <tr>
            <td>Name</td>
            <td>testing profile</td>
          </tr>
          <tr>
            <td>Address</td>
            <td>test address for testing</td>
          </tr>
          <tr>
            <td>Remarks</td>
            <td>Good</td>
          </tr>
          <tr>
            <td>Order/ Inv No:</td>
            <td>#00169</td>
          </tr>
          <tr>
            <td>Model</td>
            <td>S-Presso Vxi (O) AGS</td>
          </tr>
        </table></td>
        <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td>Receipt Date</td>
            <td>18/07/2020 04:57:22 PM</td>
          </tr>
          <tr>
            <td>Receipt Amount</td>
            <td>5000</td>
          </tr>
         
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Srl</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Mode</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>DD/CC/CHQ No.</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Date</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Favouring</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Drwan On</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Deposit Bank Name</strong></td>
        <td style="border:1px solid #000; border-width:1px 0"><strong>Amount</strong></td>
      </tr>
      <tr>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">1</td>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">Cash</td>
        <td height="40" align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td align="left" valign="top" style="border:1px solid #000; border-width:0 0 1px 0">5000</td>
      </tr>
      
      <tr>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
        <td style="border:1px solid #000; border-width:0 0 1px 0">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td>Total</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Amount In Words</td>
            <td>Rupees: Five Thousand</td>
          </tr>
          <tr>
            <td>Terms &amp; Conditions</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
        <td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
          <tr>
            <td align="center">For Seva Automotive PVT.LTD.</td>
          </tr>
          <tr>
            <td height="60" align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="center">authorized by</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>

';
 $send = mail($to, $subject1, $message1, $headers1); //admin mail
 if($send)  {
    header("Location: http://marutiseva.com/success.php");
    exit();

 }
    }

}

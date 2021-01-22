@extends('layouts.master') @section('content')

<style type="text/css">
    .customer-details td, th {
    border: 0px;
    }
    .customer-details td span {
    font-size: 15px;
    font-weight: 600;
}
.customer-details td label {
    color: #333;
    font-size: 14px;
}
</style>
<section class="breadcrumbs-custom">
  <div class="parallax-container"data-parallax-img="{{url('')}}/public/front/img/faq-bg.jpg">
    <div class="material-parallax parallax"><img alt=""src="{{url('')}}/public/front/img/faq-bg.jpg"style="display:block;transform:translate3d(-50%,149px,0)"></div>
    <div class="breadcrumbs-custom-body context-dark parallax-content">
      <div class="container">
        <h2 class="breadcrumbs-custom-title">Pay Now </h2>
      </div>
    </div>
  </div>
  
</section>
<section class="contact"id="contact">
  <div class="container-fluid"data-aos="fade-up">
    
    <div class="row"data-aos="fade-up"data-aos-delay="100">
      
      <div class="col-lg-12 align-self-center">

        <div class="formsection col-md-10 mx-auto">
        <div class="formsection">
        <div class="my-4">
            <h5 style="border-bottom: 1px dashed #222;padding-bottom: 15px;">Customer Details</h5></div>
        <div class="box-body">
        <?php foreach($subscribe_now_data as $row); 
        $no_of_days_id = $row->subscribe_now_plan_duration_id;
          $duration_value     = \DB::table('subscribe_now_plan_duration')
                        ->where('subscribe_now_plan_duration_id',$no_of_days_id)
                        ->get();
        if($duration_value)
        {
            $duration_data = $duration_value->toArray();
        }
        foreach($duration_data as $duration_data_row);
        $meal_type_id = $row->meal_type_id;
        $explode_data = explode(",",$meal_type_id);

        ?>
        <div class="form-group">
        
        <table class="table border-0 customer-details" width="100%" border="0">
            <tr>
                <td>
                    <label for="oldpassword">Full Name</label>: </td>
                    <td>           
                    <span><?php echo $row->name; ?> </span>    
                </td>
                <td>
                    <label for="oldpassword">Mobile No</label>:</td>
                    <td>            
                    <span><?php echo $row->phone_no; ?></span>
                </td>
            </tr>
             <tr>
                <td>
                    <label for="oldpassword">Email Id</label>: </td>       
                    <td>           
                    <span><?php echo $row->email; ?> </span>
                </td>
                <td>
                    <label for="oldpassword">Start Date</label>:</td>
                    <td>           
                    <span><?php echo date('d-m-Y', strtotime( $row->start_date)); ?> </span>   
                </td>
            </tr>
             <tr>
                <td>
                    <label for="oldpassword">No. of days</label>: </td>
                    <td>           
                    <span><?php echo $duration_data_row->subscribe_now_duration; ?> </span>
                </td>
                <td>
                    <label for="oldpassword">Meal Type</label>: </td>
                    <td>           
                    <?php for($i=0;$i<count($explode_data); $i++){
                    //print_r($explode_data[$i]); die;
                    $meal_type_data = \DB::table('meal_type')->select('meal_type_name')->where('meal_type_id',$explode_data[$i])->get();
                    for($j=0;$j<count($meal_type_data); $j++){
                    foreach($meal_type_data as $meal_type_row):
                    ?>  
                    <span style="padding: 4px;"><b><u>
                    <?php echo $meal_type_row->meal_type_name; ?></u></b></span><!-- color: #000; --><?php endforeach;
                        }  
                    }?>    
                </td>
            </tr>
             <tr>
                <td>
                    <label for="oldpassword">Price</label>:</td> 
                     <td>    

                    <span><?php echo $row->price; ?>/- (5% GST applicable)</span>
                </td>
                <td>
                    <label for="oldpassword">Total Price</label>: </td>  
                    <td>           
                        <span><?php $total = $row->price; 
                        $gst = $total * 5 / 100;
                        $final_total = $total + $gst;
                        echo round($final_total).'/-';
                        ?></span>
                </td>
            </tr>
            <tr>
                <td><label for="oldpassword">Address 1</label>:</td><td><span><?php echo $row->address1; ?></span></td>
                <td><label for="oldpassword">Pincode 1</label>:</td><td><span><?php echo $row->pincode1; ?></span></td>
            </tr>
            <tr>
                 <td><label for="oldpassword">Address 2</label>:</td><td><span><?php echo $row->address2; ?></span></td>
                <td><label for="oldpassword">Pincode 2</label>:</td><td><span><?php echo $row->pincode2; ?></span></td>
            </tr>
             <tr>
                 <td><label for="oldpassword">Meal Type 1</label>:</td><td><span><?php echo $row->address1_meal; ?></span></td>
                 <td><label for="oldpassword">Meal Type 2</label>:</td><td><span><?php echo $row->address2_meal; ?></span></td>
            </tr>
        </table>
    </div>
</div>
</div>
</div>

    <center>
          <button type="button" id="rzp-button" class='btn btn-next btn-fill btn-success btn-wd'>Pay Now</button>
    </center>

    <form id="web_order_summery_form" action="{{url('')}}/payment" method="post">
        {{csrf_field()}}
        <!-- https://rushabh2w.com/admin/admin/capture_payment /<?php //echo $id; ?> -->
        <input type="hidden" id="razorpay_payment_id" name="razorpay_payment_id" >
        <input type="hidden" id="token_id" name="token_id" value="<?php echo base64_encode($row->id); ?>">
      </form>
      </div>
    </div>
  </div>
</section>

 <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script type="text/javascript">
     <?php $final_amount = round($final_total)*100; ?>
      var options = {
    "key": "rzp_test_KcySdv9YlIpqGP", 
    //rzp_live_IZMQ4kxcwLhCKH
    //test rzp_test_hqnjkaxFJyZfE6
    //live rzp_live_IZMQ4kxcwLhCKH
    //"amount": 100, 
    "amount": "<?php echo $final_amount; ?>", 
    "currency": "INR",
    "name": "Nutridock",
    "description": "",
    "image": "{{url('')}}/public/front/img/logo.png",

    "handler": function (response){
      console.log(response.razorpay_payment_id);
      $('#razorpay_payment_id').val(response.razorpay_payment_id);
      document.getElementById("web_order_summery_form").submit();
    },
    "prefill": {
        "name": "<?php echo $row->name; ?>",
        "email": "<?php echo $row->email; ?>",
        "contact": "<?php echo $row->phone_no; ?>"
    },
    "notes": {
        "address": "<?php echo $row->address1;?>"
    },
    "theme": {
        "color": "#000"
    }
};

/* options = {
    "key": "rzp_test_KcySdv9YlIpqGP",
    "amount": razor_amount*100, 
    "currency": "INR",
    "name": "Nutridock",
    "description": "",
    "image": "{{url('')}}/public/front/img/logo.png",
    "handler": function (response){
      $('#razorpay_payment_id').val(response.razorpay_payment_id);
      $('#id').val(razor_id);
      document.getElementById("web_order_summery_form").submit();
    },
    "prefill": {
        "name": razor_name,
        "email": razor_email,
        "contact": razor_phone_no
    },
    "notes": {
        "address": razor_address
    },
    "theme": {
        "color": "#000"
    }
  };*/


var rzp1 = new Razorpay(options);
document.getElementById('rzp-button').onclick = function(e){
  console.log(rzp1);
  rzp1.open();
  e.preventDefault();
}
    </script>
@endsection
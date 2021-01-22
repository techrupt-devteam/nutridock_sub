<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-GB">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Email Design</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

  <style type="text/css">
    a[x-apple-data-detectors] {color: inherit !important;}
  </style>

</head>
<body style="margin: 0; padding: 0;">
  <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
      <td style="padding: 20px 0 30px 0;">
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">
          <tr>
            <td align="center" bgcolor="#70bbd9">
              <img src="https://nutridock.com/uploads/images/thank-you.jpg" alt="Thank You" width="600"  style="display: block;" />
            </td>
          </tr>
          <tr>
            <?php $explode_data = explode(",",$meal_type_id);$meal_type_data = []; 
                $abc = explode(",",$avoid_or_dislike_food_id);
                 $food_avoid_data = [];
                //print_r($explode_data_meal); die;
            ?>
            <td style="padding: 20px 25px 10px 25px;background-color: #d8ffcf;">
              <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
                <tr>
                  <td style="color: #1a2127; font-family: Arial, sans-serif;">
                    <h1 style="font-size: 24px; color: #6dc83c;">Welcome to Nutridock</h1>
                    <h2 style="margin: 0px;text-transform: uppercase">Hello <?php echo $name ?>,</h2>
                  </td>
                </tr>
                <tr>
                  <td style="color: #222; font-family: Arial, sans-serif; font-size: 16px; line-height: 24px; padding: 20px 0 30px 0;">
                    <p style="margin: 0;">Thank you for joining the Subscription plan of Nutridock.</p>
                    <p>We look forward to give you a wonderful and wholesome experience.</p>
                    <p>Please find below your booking details-</p>

                        <strong>Subscription ID:</strong> <?php echo $subscription_id; ?><br><strong>Name:</strong> <?php echo $name ?><br><strong>Contact Number: </strong><?php echo $phone_no; ?><br><strong>Start Date: </strong><?php
$newDate = date("d-m-Y", strtotime($start_date)); echo $newDate; ?><br><strong>Plan: </strong> <?php echo $subscribe_plan; ?><br>
            <strong>Number of Meals:</strong> 
            <?php echo count($explode_data); ?><br>
            
            <strong>Dislike Food:</strong>
            <?php if($avoid_or_dislike_food_id!="Other") { 
            for($i=0;$i<count($abc); $i++){ 
                $food_avoid_data = \DB::table('food_avoid')->select('food_avoid_name')->where('food_avoid_id',$abc[$i])->get();
            for($j=0;$j<count($food_avoid_data); $j++){
            foreach($food_avoid_data as $food_avoid_row): ?>
            <span><?php echo $food_avoid_row->food_avoid_name; ?></span><?php endforeach;
        } 
    } }if($avoid_or_dislike_food_id=="None"){ ?>    
                <strong><?php echo $avoid_or_dislike_food_id; ?></strong>
            <?php }?><br>
                
                <?php if($other_food){ ?>
                <strong>Other: <?php echo $other_food; ?></strong>
            <?php }?>
                <span>Kindly note our nutritionist will get in touch with you soon to take this forward.</span><br><span>For any queries, please reach out to us via whatsapp/call at +91 744-7725922 or e-mail us at customercare@nutridock.com.</span><br>Thanks & Regards<br>Team Nutridock.<br></span></span>
                  </td>
                </tr>
                <!-- <tr>
                  <td style="color: #222; font-family: Arial, sans-serif; font-size: 16px; line-height: 24px; padding: 20px 0 30px 0;">
                    <p style="margin: 0">Thanks in advance for your patience.</p>
                    <p style="margin: 0">Have a great day!</p>
                  </td>
                </tr> -->
              </table>
            </td>
          </tr>
          <tr>
            <td bgcolor="#33363d" style="padding: 20px 20px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
                <tr>
                  <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;">
                    <p style="margin: 0;">The Nutridock Team</p>
                  <p style="margin: 0"> <a href="https://nutridock.com" style="color: #0087ff;font-weight: 600;letter-spacing: 0.5px;">https://nutridock.com
                  </p>
                  </td>
                  <td align="right">
                    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                      <tr>
                        <td>
                          <a href="https://www.facebook.com/nutridock0/" target="_blank">
                            <img src="https://nutridock.com/uploads/images/facebook.png" alt="Facebook" width="30" height="30" style="display: block;" border="0" />
                          </a>
                        </td>
                        <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                        <td>
                          <a href="https://www.instagram.com/nutri_dock/?igshid=1iz93rjouag24" target="_blank">
                            <img src="https://nutridock.com/uploads/images/instagram.png" alt="Instagram" width="30" height="30" style="display: block;" border="0" />
                          </a>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>

      </td>
    </tr>
  </table>
</body>
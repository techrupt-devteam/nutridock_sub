<?php 
 $value= $data['get_subscriber_details'];
 $get_meal_type= $data['get_meal_type'];
 $get_food_avoid= $data['get_food_avoid'];
 $get_meal_type2= $data['get_meal_type2'];
 $get_meal_type3= $data['get_meal_type3'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title> Subscriber Details </title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	 <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>-->
	<style>
		.container{
			border:3px solid !important;
			padding:10px;
		}
		@page {
			header: page-header;
			footer: page-footer;
		}
		body {
			font-family: 'examplefont', sans-serif;
		}
		#watermark {
			position: fixed;
			bottom: 5px;
			right: 5px;
			opacity: 0.5;
			text-align: right;
			color: red;
		}
	</style>
</head>
<body>
  <div class="container" >
   <div class="row">
   	 <div class="col-md-12">	 
   	 	<div class="col-md-6">
           <table cellpadding="10px" width="100%" >
   	 		 <tr><td><img src="{{url('')}}/public/front/img/logo.png" class="login-logo"></td><td> <h4>Subscriber Name : {{ucfirst($value->subscriber_name)}}</h4><br/><h4> Subcription Plan : {{ucfirst($value->sub_name)}}</h4></td></tr>
		   </table>
   	 	</div>
   	 </div>
   	 <hr style="color:black !important;"/>	
   </div>
    <div class="row">
   	 	<div class="col-md-12">
		   <table class="table table-bordered" cellpadding="10px" width="100%">
		   	 <tr style="border-bottom: 1px solid !important;">
		   	 	<td><strong>Start Date:</strong> {{date('d-m-Y',strtotime($value->start_date))}} </td>
		   	 	<td><strong>End Date:</strong> {{date('d-m-Y',strtotime($value->expiry_date))}}</td>
		   	 </tr>

		   	 <tr>
		   	 	<td><strong>Subscription Duration:</strong> {{ $value->duration }} Days</td>
		   	 	<td><strong>Payment Status:</strong>{{ ucfirst($value->payment_status)}}</td>
		   	 </tr>
		   	 <tr>
		   	 	<td><strong>Meal Type: </strong><br/><br/>
		   	 		<ul>
			@foreach ($get_meal_type as $mvalue)
			<li class='btn-sm btn-warning'>{{ $mvalue->meal_type_name }}</li>
			@endforeach
					</ul>
		        </td>
		   	 	<td><strong>Avoid / Dislike Food: </strong><br/><br/>  <ul>
		   	 		@foreach($get_food_avoid as $advalue)
                        <li class='btn-sm btn-warning'>{{ $advalue->food_avoid_name }} </li> 
                    @endforeach
                </ul></td></tr>
             <tr>
		   	 	<td><strong>Mobile:</strong> {{ $value->mobile }} Days</td>
		   	 	<td><strong>Email:</strong>{{ $value->email}}</td>
		   	 </tr>
		   	  <tr>
		   	 	<td><strong>Age:</strong> {{ $value->subscriber_age }}</td>
		   	 	<td><strong>Gender:</strong>{{ ucfirst($value->subscriber_gender)}}</td>
		   	 </tr>
		   	  <tr>
		   	 	<td><strong>Weight:</strong> {{ (!empty($value->subscriber_weight))?$value->subscriber_weight:"NA" }}</td>
		   	 	<td><strong>Height:</strong>{{ (!empty($value->subscriber_height_in_feet))?$value->subscriber_height_in_feet.".".$value->subscriber_height_in_inches:"NA"}}</td>
		   	 </tr>
		   	 <tr>
		   	 	<td><strong>Physical Activity:</strong> {{ (!empty($value->physical_activity))?$value->physical_activity:"NA" }}</td>
		   	 	<td><strong>Other Food:</strong>{{ (!empty($value->other_food))?$value->other_food:"NA"}}</td>
		   	 </tr>
		   	 <tr>
		   	 	<td colspan="2">
		   	 		<strong>Any lifestyle disease:</strong><br>
		   	 		<p>{{(!empty($value->lifestyle_disease))?ucfirst($value->lifestyle_disease):"NA"}}</p>
		   	 	</td>
		   	 </tr>
		   	 <tr>
		   	 	<td colspan="2">
		   	 		<strong>Any food preparation instructions:</strong><br>
		   	 		<p>{{(!empty($value->food_precautions))?ucfirst($value->food_precautions):"NA"}}</p>
		   	 	</td>
		   	 </tr>
		   	 <tr>
		   	 	<td>
		   	 		<strong>Address1:</strong><br>
		   	 	<p>{{(!empty($value->address))?ucfirst($value->address):"NA"}}</p>
		   	 	</td>
		   	 	<td>
		   	 		<strong>Address2:</strong><br>
		   	 		<p>{{(!empty($value->address2))?ucfirst($value->address2):"NA"}}</p>
		   	 	</td>
		   	 </tr>
		   	 <tr>
		   	 	<td>
		   	 		<strong>Pincode1</strong><br>
		   	 		<p>{{(!empty($value->pincode1))?ucfirst($value->pincode1):"NA"}}</p>
		   	 	</td>
		   	 	<td>
		   	 		<strong>Pincode2</strong><br>
		   	 		<p>{{(!empty($value->pincode2))?ucfirst($value->pincode2):"NA"}}</p>
		   	 	</td>
		   	 </tr>
		   	 <tr>
		   	 	<td>
		   	 		<strong>Meal Type1</strong><br>
		   	 		@if(count($get_meal_type2)!=0)
		   	 		<ul>
		   	 		  @foreach ($get_meal_type2 as $m2value)
                       <li class='btn-sm btn-warning'>{{ ucfirst($m2value->meal_type_name)}}</li>
                      @endforeach  
		   	 		</ul>
		   	 		@else
		   	 		 {{'NA'}}
		   	 		@endif
		   	 	</td>
		   	 	<td>
		   	 		<strong>Meal Type2</strong><br>
		   	 		@if(count($get_meal_type3)!=0)
					<ul>
						@foreach ($get_meal_type3 as $m3value)
						<li class='btn-sm btn-warning'>{{ ucfirst($m3value->meal_type_name)}}</li>
						@endforeach  
					</ul>
					@else
		   	 		 {{'NA'}}
		   	 		@endif
		   	 	</td>
		   	 </tr>
		   	 
		   </table>
   		</div>
  	</div>
<div>
<!-- <htmlpagefooter name="page-footer" style="background-color: green!important ;color:white !important;">
<p style="text-align: center;"><strong>© Nutridock 2020. All rights reserved.</strong></p>
</htmlpagefooter> -->
</div>  </div>
</body>
</html>


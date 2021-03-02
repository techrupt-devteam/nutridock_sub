<?php 
 $value= $data['get_subscriber_details'];
 $get_meal_type= $data['get_meal_type'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title> Subscriber Details </title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
  <div class="container">
   <div class="row">
   	 <div class="col-md-12">
   	  	<h4>Subscriber Name : {{ucfirst($value->subscriber_name)}}</h4> 
   	 </div>
   	 <hr/>	
   </div>
    <div class="row">
   	 	<div class="col-md-12">
		   <table class="table table-bordered" cellpadding="10px">
		   	 <tr>
		   	 	<td>Start Date: </td>
		   	 	<td>End Date: </td>
		   	 </tr>
		   	 <tr>
		   	 	<td>Subscription Duration:</td>
		   	 	<td>Payment Status: </td>
		   	 </tr>
		   	 <tr>
		   	 	<td><b>Meal Type: </b><br/>
			@foreach ($get_meal_type as $mvalue)
			<span class='btn-sm btn-warning'>{{ $mvalue->meal_type_name }}</span>
			@endforeach</td>
		   	 	<td></td>
		   	 </tr>
		   </table>
   		</div>
  	</div>
  </div>
</body>
</html>
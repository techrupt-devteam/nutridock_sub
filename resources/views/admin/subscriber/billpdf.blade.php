<?php
$value = $data['get_subscriber_details'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title> Subscriber Details </title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
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
		#invoice{
    padding: 10px;
}

.invoice {
    position: relative;
    background-color: #FFF;
    min-height: 680px;
    padding: 10px
}

.invoice header {
    padding: 5px 0;
    margin-bottom: 10px;
    border-bottom: 1px solid #3989c6
}

.invoice .company-details {
    text-align: right
}

.invoice .company-details .name {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .contacts {
    margin-bottom: 20px
}

.invoice .invoice-to {
    text-align: left
}

.invoice .invoice-to .to {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .invoice-details {
    text-align: right
}

.invoice .invoice-details .invoice-id {
    margin-top: 0;
    color: #3989c6
}

.invoice main {
    padding-bottom: 50px
}

.invoice main .thanks {
    margin-top: -100px;
    font-size: 2em;
    margin-bottom: 50px
}

.invoice main .notices {
    padding-left: 6px;
    border-left: 6px solid #3989c6
}

.invoice main .notices .notice {
    font-size: 1.2em
}

.invoice table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 20px
}

/*.    padding: 15px;
    background: #eee;
    border-bottom: 1px solid #fff
}

invoice table th {
    white-space: nowrap;
    font-weight: 400;
    font-size: 16px
}

.invoice table td h3 {
    margin: 0;
    font-weight: 400;
    color: #3989c6;
    font-size: 1.2em
}

.invoice table .qty,.invoice table .total,.invoice table .unit {
    text-align: right;
    font-size: 1.2em
}

.invoice table .no {
    color: #fff;
    font-size: 1.6em;
    background: #3989c6
}

.invoice table .unit {
    background: #ddd
}

.invoice table .total {
    background: #3989c6;
    color: #fff
}

.invoice table tbody tr:last-child td {
    border: none
}*/

/*..invoice table tfoot td {
    background: 0 0;
    border-bottom: none;
    white-space: nowrap;
    text-align: right;
    padding: 10px 20px;
    font-size: 1.2em;
    border-top: 1px solid #aaa
}

invoice table tfoot tr:first-child td {
    border-top: none
}*/

/*.invoice table tfoot tr:last-child td {
    color: #3989c6;
    font-size: 1.4em;
    border-top: 1px solid #3989c6
}*/

/*.invoice table tfoot tr td:first-child {
    border: 1px solid;
}
*/
.invoice footer {
    width: 100%;
    text-align: center;
    color: #777;
    border: 1px solid #aaa;
    padding: 8px 0
}
.font{
    font-size: 10px !important;
}

	</style>
</head>
<body>
   <div id="invoice">
    <div class="invoice overflow-auto">
        <div style="min-width: 100%">
            <header>
                <div class="row">
                    <div class="col">
                        <a target="_blank" href="https://lobianijs.com">
                           <img src="{{url('')}}/public/front/img/logo.png" class="login-logo">
                            </a>
                    </div>
                    <div class="col company-details">
                        <h3 class="name">
                            Address
                        </h3>
                        <div>B-17, next to SEVA NEXA Service Center,</div>
                        <div>MIDC Ambad, Nashik,Maharashtra 422010</div>
                        <div>www.nutridock.com</div>
                    </div>
                </div>
            </header>
            <main>
                <div class="row contacts">
                    <!--<div class="col invoice-to">
                        <div class="text-gray-light">
                        	INVOICE TO:<br/>
                        	<p><b>John Doe</b></p><br/>
                        	<p><a href="mailto:john@example.com">john@example.com</a></p>
                        </div>
                        
                       
                    </div>
                    <div class="col invoice-details">
                    	 <br/>
                        <div class="date">Date of Invoice: 01/10/2018</div>
                        <div class="date">Due Date: 30/10/2018</div>
                    </div>-->
                </div>
                <div class="row contacts">
                	<div class="col-md-6">
                		<p class="text-left">Invoice To:</p>
                		<p class="text-left"><b>{{ucfirst($value->subscriber_name)}}</b><br/><a href="mailto:{{$value->email}}">{{$value->email}}</a></p>
                	
                	</div>
                	<!-- <div class="col-md-6 ">
                		 <div class="date text-right"></div>
                		 <div class="date text-right">Date of Invoice: {{date('d-m-Y')}}</div>
                        
                	</div> -->
                </div>
                <table border="1" cellspacing="1" cellpadding="10">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="text-cenetr">Date</th>
                            <th class="text-cenetr">Plan</th>
                            <th class="text-left">Days</th>
                            <th class="text-left">Type</th>
                            <th class="text-left">Amount</th>

                         </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>{{date('d-m-Y',strtotime($value->start_date))}}</td>
                            <td>{{ucfirst($value->sub_name)}}</td>
                            <td>{{ $value->no_of_days}} Days</td>
                            <td>{{ $value->is_price_per_mealorpack}} 
							</td>
                            <td style="text-align: right !important;"><strong><small>  ₹ {{$value->price_per_meal}}</small></strong></td>
                        </tr>
                    </tbody>
                    <tfoot >
                        <tr>
                            <td colspan="4"></td>
                            <td colspan=""><strong class="font">Discount Price</strong></td>
                            <td class="text-center"><strong class="font">  ₹ {{$value->discount_price}}</strong></td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td colspan=""><strong class="font">MRP</strong></td>
                            <td class="text-center"><strong class="font">  ₹ {{$value->mrp}}</strong></td>
                        </tr> <tr>
                            <td colspan="4"></td>
                            <td colspan=""><strong class="font">Sales Price</strong></td>
                            <td class="text-center"><strong class="font">  ₹ {{$value->sale_price}}</strong></td>
                        </tr>
                         <tr>
                            <td colspan="4"></td>
                            <td colspan=""><strong class="font">Gst Amt</strong></td>
                            <td class="text-center"><strong class="font">  ₹ {{$value->sale_price}}</strong></td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td colspan=""><strong class="font">Grand Total</strong></td>
                            <td class="text-center"><strong class="font">  ₹ {{$value->total_amount}}</strong></td>
                        </tr>
                        <tr>
                            <td>In Word</td>
                            <td colspan="5"><strong class="font">  ₹ {{$value->total_amount}}</strong></td>
                        </tr>
                    </tfoot>
                </table>
             <!--    <div class="thanks">Thank you!</div> -->
                <!-- <div class="notices">
                    <div>NOTICE:</div>
                    <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
                </div> -->
            </main>
            <hr/>
            <p style="text-align:center !important;">
                Invoice was created on a computer and is valid without the signature and seal.
            </p>
        </div>
        <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
        <div></div>
    </div>
</div>
</body>
</html>


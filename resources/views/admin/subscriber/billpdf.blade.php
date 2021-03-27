<?php
$value = $data['get_subscriber_details'];
?>
<!DOCTYPE html>
<html lang="en">
<html>
<head>
    <title>Bill pdf</title>
</head>
<style type="text/css">
h1 { font: bold 100% sans-serif; letter-spacing: 0.5em; text-align: center; text-transform: uppercase; }

/* table */

table { font-size: 90%; table-layout: fixed; width: 100% }
table { border-collapse: separate; border-spacing: 2px; }
th, td { border-width: 1px; padding: 0.5em; position: relative; text-align: left; }
th, td { border-radius: 0.25em; border-style: solid; }
th { background: #EEE; border-color: #444; }
td { border-color: #444; }

body { box-sizing: border-box; height: 11in; margin: 0 auto; overflow: hidden; padding: 0.5in; width: 7.5in; }
body { background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); }

/* header */

header { margin: 0 0 3em; }
header:after { clear: both; content: ""; display: table; }

header h1 { background: #8bc34a; border-radius: 0.25em; color: #FFF; margin: 0 0 1em; padding: 0.5em 0; }
header address { float: left; font-size: 95%; font-style: normal; line-height: 1.25; margin: 0 1em 1em 0; }
article address.norm h4 {
    font-size: 125%;
    font-weight: bold;
}
article address.norm { float: left; font-size: 95%; font-style: normal; font-weight: normal; line-height: 1.25; margin: 0 1em 1em 0; }
header address p { margin: 0 0 0.25em; }
header span, header img { display: block; float: right; }
header span { margin: 0 0 1em 1em; max-height: 25%; max-width: 60%; position: relative; }
header img { max-height: 100%; max-width: 100%; }
header input { cursor: pointer; -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)"; height: 100%; left: 0; opacity: 0; position: absolute; top: 0; width: 100%; }

/* article */

article, article address, table.meta, table.inventory { margin: 0 0 3em; }
article:after { clear: both; content: ""; display: table; }
article h1 { clip: rect(0 0 0 0); position: absolute; }

article address { float: left; font-size: 125%; font-weight: bold; }

/* table meta & balance */

table.meta, table.balance { float: right; width: 36%; }
table.meta:after, table.balance:after { clear: both; content: ""; display: table; }

/* table meta */

table.meta th { width: 40%; }
table.meta td { width: 60%; }

/* table items */

table.inventory { clear: both; width: 100%; }
table.inventory th:first-child {
    width:50px;
}
table.inventory th:nth-child(2) {
    width:300px;
}
table.inventory th { font-weight: bold; text-align: center; }

table.inventory td:nth-child(1) { width: 26%; }
table.inventory td:nth-child(2) { width: 38%; }
table.inventory td:nth-child(3) { text-align: right; width: 12%; }
table.inventory td:nth-child(4) { text-align: right; width: 12%; }
table.inventory td:nth-child(5) { text-align: right; width: 12%; }

/* table balance */

table.balance th, table.balance td { width: 50%; }
table.balance td { text-align: right; }

/* aside */

aside h1 { border: none; border-width: 0 0 1px; margin: 0 0 1em;text-align: center !important; }
aside h1 { border-color: #999; border-bottom-style: solid;text-align: center !important; }

table.sign {
    float: left;
    width: 220px;
}
table.sign img {
    width: 100%;
}
table.sign tr td {
    border-color: transparent;
}
@media print {
    * { -webkit-print-color-adjust: exact; }
    html { background: none; padding: 0; }
    body { box-shadow: none; margin: 0; }
    span:empty { display: none; }
    .add, .cut { display: none; }
}

@page { margin: 0; }
@page {
            header: page-header;
            footer: page-footer;
        }


@page {
            header: page-header;
            footer: page-footer;
            margin: 10px;
        }
</style>
<body >
 
      <header>
            <h1>EInvoice</h1>
      </header>
      <table style="border: 0 !important;text-align:center" >
        <tr>
         <td style="border: 0 !important; text-align: left">
            <span> <img src="{{url('')}}/public/front/img/logo.png" class="login-logo" alt="einvoicenutridock"></span>
         </td>
         <td style="border: 0 !important;text-align: right;font-family: arial !important;font-style: normal !important;">
            <address style="font-style: normal !important;">
                <p style="font-style: normal !important;">  <img src="{{url('')}}/uploads/images/email.svg" width="10" class="login-logo" alt="mail-icon"> info@nutridockfit.com</p>
                <p style="font-style: normal !important;"> B-17, next to SEVA NEXA Service Center,</p>
                <p style="font-style: normal !important;"> MIDC Ambad, Nashik,Maharashtra 422010 </p>
               <!--  <p> P: 1-800-961-4952 </p>-->
                <p style="font-style: normal !important;"> <img src="{{url('')}}/uploads/images/phone-call.svg" width="10" class="login-logo" alt="mail-icon"> +91-808-234-**** </p> 
                <p style="font-style: normal !important;"> <img src="{{url('')}}/uploads/images/earth-globe.svg" width="10" class="login-logo" alt="mail-icon"> https://www.nutridockfit.com </p>

            </address>
         </td>
     </tr>
      
      <tr>
          <td colspan="2" style="border: 0 !important;">
            <table style="border: 0 !important;">
                <tr>
                    <td style="border: 0 !important;width: 60%">
                         <h1>Recipient</h1>
                        <address class="norm" style="font-style: normal !important;margin-top: 5px !important;">
                           <h4 style="font-style: normal !important;">{{ucfirst($value->subscriber_name)}}</h4>
                            <p style="font-style: normal !important;"> {{$value->email}} <br>
                            <p style="font-style: normal !important;"> {{ucfirst($value->address1)}} <br>
                            <p style="font-style: normal !important;"> pincode: {{$value->pincode1}}<br>
                            <p style="font-style: normal !important;"> {{$value->mobile}}</p>
                        </address>
                    </td>
                    <td style="border: 0 !important;width: 40%">
                        <table class="meta" style="width: 100%">
                            <tr>
                                <th><span >Transaction ID#</span></th>
                                <td><span >{{$value->transaction_id}}</span></td>
                            </tr>
                            <tr>
                                <th><span >Date</span></th>
                                <td><span >{{ date('d F Y', strtotime(Now())) }}</span></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table class="inventory" style="border:1px solid #444">
                <thead>
                    <tr>
                        <th style="width:10% !important;"><span>S. No</span></th>
                        <th align="left" style="width:10% !important;"><span>Date</span></th>
                        <th align="left"><span>Plan</span></th>
                        <th align="left"><span>Days</span></th>
                        <th align="left"><span>Type</span></th>
                        <th style="width:20% !important;text-align: right !important;" align="right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="width:10% !important;"><span>1.</span></td>
                        <td style="width:10% !important;" align="left"><span>{{date('d-m-Y',strtotime($value->start_date))}}</span></td>
                        <td align="left"><span>{{ucfirst($value->sub_name)}}</span></td>
                        <td align="left"><span>{{ $value->no_of_days}} Days</span></td>
                        <td style="text-align:left !important;"><span>{{ $value->is_price_per_mealorpack}}</span></td>
                        <td style="text-align:right !important;"  align="right">₹ {{number_format($value->price_per_meal,2)}}</td> 
                    </tr> 
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" rowspan="5" style="border:0px" align="center">
                            <img src="{{url('')}}/uploads/images/paid.png">
                        </td>
                         <th colspan="" style="text-align: left !important;">
                            Discount Price
                        </th>
                        <td style="text-align:right!important;"  align="right"  >
                            <span style="text-align:right!important;"  align="right">₹</span><span style="text-align:right!important;"  align="right">{{number_format(round($value->discount_price),2)}}</span>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="" style="text-align: left !important;">
                            MRP Price
                        </th>
                        <td style="text-align:right!important;"  align="right" >
                            <span style="text-align:right!important;"  align="right">₹</span><span style="text-align:right!important;"  align="right">{{number_format(round($value->mrp),2)}}</span>
                        </td>
                    </tr>
                    <tr>
                         <th colspan="" style="text-align: left !important;">
                            Sales Price
                        </th>
                        <td style="text-align:right!important;"  align="right" >
                            <span style="text-align:right!important;"  align="right">₹</span><span style="text-align:right!important;"  align="right">{{number_format(round($value->sale_price),2)}}</span>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="" style="text-align: left !important;">
                            Gst Amt
                        </th>
                        <td style="text-align:right!important;"  align="right" >
                            <span style="text-align:right!important;"  align="right">₹</span><span style="text-align:right!important;"  align="right">{{number_format(round($value->gst_price),2)}}</span>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="" style="text-align: left !important;">
                            Grand Total
                        </th>
                        <td style="text-align:right!important;"  align="right" >
                            <span style="text-align:right!important;"  align="right">₹</span><span style="text-align:right!important;"  align="right">{{number_format(round($value->total_amount),2)}}</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            Inwards :
                            <b>{{ucfirst($data['inword'])}} only/- </b>
                        </td>
                    </tr>
                </tfoot>
            </table>
        <article>
            <hr/>

            <aside>
                <table style="width: 100%;text-align: center;border: 0px !important">
                    <tr>
                        <td style="text-align: center;border: 0px !important">
                           <h1> Additional Notes</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;border: 0px !important">
                             <p style="text-align: center;">This is computer generated invoice, no signature required.</p>
                             <p>For more details: <b>info@nutridockfit.com</b></p>
                        </td>
                    </tr>
                </table>
            </aside>
            
       </td>
      </tr>    
    </table>


</body>
</html>
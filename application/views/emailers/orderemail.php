<html>
<?php
if($data->paymentmode == 1)
{
  $paymentmode = "Credit Card";
}
elseif($data->paymentmode == 2)
{
  $paymentmode = "Debit Card";
}
elseif($data->paymentmode == 3)
{
  $paymentmode = "Net Banking";
}
elseif($data->paymentmode == 4)
{
  $paymentmode = "Cash On Delivery";
}
?>
<head>

</head>

<body>
    <table style="width:600px;margin: 0 auto;border:1px solid #f1ecec;">
        <tr>
            <th style="border-bottom: 4px solid #ff8849;padding:15px 3px;">
                <img width="250p" src="assets/images/logo1.png" alt=""
                    style="float:left;">
            </th>
        </tr>
        <tr>
            <td style="padding:25px 10px;">
                <h1 style="font-family: 'PT Sans', sans-serif;font-size:1.3em;line-height:1.2em;
                    text-align:center;color:#636060;">
                    Thanks for your order</h1>
                <p
                    style="font-family: 'PT Sans', sans-serif;font-size:1em;line-height:1.4em;color: #928b8b;text-align:center;">
                    Hi <b style="text-transform: uppercase;"> Dear <?php echo $data->first_name ." ". $data->last_name; ?></b> , we've received order no. <b
                        style="text-transform: uppercase;"><?php echo $data->id; ?></b> and are working on it now.
                    We'll email you an update when we've shipped it.</p>
                <a href="" style="text-decoration:none;">
                    <button style="background-color: #ff8849;color:#fff;border-radius:2px;padding:10px 18px;
                                        display:block;margin:0 auto;border:none;font-size: 1em;">
                        View Your Order Details
                    </button>
                </a>
            </td>
        </tr>

        <tr>
            <td>
                <table style="width:578px;margin: 0 auto;border: 1px solid #efe8e8;border-radius:3px;
                    padding:13px 10px;text-align: center;background-color: #fcfcfc;">
                    <tr>
                        <td style="border-right: 1px solid #efe8e8; vertical-align: top;">
                           
                            <table style="width:284px;text-align: left;">
                                <tr>
                                    <td colspan="2" style="font-family: 'PT Sans', sans-serif;font-size:1.1em;font-weight: normal;
                                        color:#e20000;padding-bottom: 13px;"> Order Summary</td>
                                </tr>
                                <tr style="font-family: 'PT Sans', sans-serif;font-size:0.9em;margin:6px 0px 30px;
                                        color: #928b8b;">
                                    <td style="padding-bottom: 4px;">Order ID:</td>
                                    <td style="padding-bottom: 4px;"><?php echo $data->id; ?></td>
                                </tr>
                                <tr style="font-family: 'PT Sans', sans-serif;font-size:0.9em;margin:6px 0px 30px;
                                        color: #928b8b;">
                                    <td style="padding-bottom: 4px;">Date:</td>
                                    <td style="padding-bottom: 4px;"><?php echo date("d F Y h:i a",strtotime( $data->date)); ?></td>
                                </tr>
                                <tr style="font-family: 'PT Sans', sans-serif;font-size:0.9em;margin:6px 0px 30px;
                                        color: #928b8b;">
                                    <td style="padding-bottom: 4px; width: 116px;">Mode of payment: </td>
                                    <td style="padding-bottom: 4px;"><?php echo $paymentmode; ?></td>
                                </tr>
                            </table>

                        </td>
                        <td>
                               <table style="padding-left: 9px;">
                                <tr style="font-family: 'PT Sans', sans-serif;font-size:1.1em;font-weight: normal;
                                color:#e20000;text-align: left;">
                                    <td style="padding-bottom: 7px;"> Delivery Address</td>
                                </tr>
                                <tr style="font-family: 'PT Sans', sans-serif;font-size:0.9em;margin:6px 0px 5px;
                                color: #928b8b; line-height: 1.6em;text-align: left;">
                                    <td><?php echo $data->shipping_name?></td>
                                </tr>
                                <tr style="font-family: 'PT Sans', sans-serif;font-size:0.9em;margin:6px 0px 5px;
                                color: #928b8b; line-height: 1.6em;text-align: left;">
                                    <td><?php echo $data->shipping_address;?>,</td>
                                </tr>
                                <tr style="font-family: 'PT Sans', sans-serif;font-size:0.9em;margin:6px 0px 5px;
                                color: #928b8b; line-height: 1.6em;text-align: left;">
                                    <td> <?php echo $data->shipping_city." - ".$data->shipping_pincode ;?>,</td>
                                </tr>
                                <tr style="font-family: 'PT Sans', sans-serif;font-size:0.9em;margin:6px 0px 5px;
                                color: #928b8b; line-height: 1.6em;text-align: left;">
                                    <td><?php echo $data->shipping_state ." - ".$data->shipping_country ;?></td>
                                </tr>
                                <tr style="font-family: 'PT Sans', sans-serif;font-size:0.9em;margin:6px 0px 5px;
                                color: #928b8b; line-height: 1.6em;text-align: left;">
                                    <td>Mobile: <?php echo $data->shipping_contact; ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>

        <tr>
            <td>
                <table style="padding: 25px 10px 0px;">
                    <tr style="font-family: 'PT Sans', sans-serif;line-height:1.4em;color: #ff8849;">
                        <th colspan="2" style="width:50%; border-bottom: 1px solid #ff8849; padding-bottom: 10px;">
                            <span style="font-size: .93em;">ITEMS</span></th>

                        <th style="border-bottom: 1px solid #ff8849; padding-bottom: 10px;">
                            <span style="font-size: .93em;">QUANTITY</span></th>
                        <th style="border-bottom: 1px solid #ff8849; padding-bottom: 10px;">
                            <span style="font-size: .93em;width: 19%;">AMOUNT</span></th>
                    </tr>


<?php
 foreach($items as $value)
 {
   $name = $value['name'];
   $image = $value['image_name'];
   $oprice = $value['price'];
   $qty =$value['quantity'];
   $price = number_format($oprice,2);
   $total = $value['price'] * $value['quantity'];
 ?>


<tr style="font-family: 'PT Sans', sans-serif;font-size:.9em;line-height:1.4em;color: #928b8b;">
                        <td style="text-align:center;padding:11px 0;border-bottom: 1px solid #efe8e8;">
                            <img width="45" src='<?php echo $image; ?>' alt="">
                        </td>
                        <td style="text-align:left;padding:11px 0px 11px 6px;border-bottom: 1px solid #efe8e8;">
                        <?php echo $name; ?></td>
                        <td style="text-align:center;padding:11px 0;border-bottom: 1px solid #efe8e8;"><?php echo $qty; ?></td>
                        <td style="text-align:center;padding:11px 0;border-bottom: 1px solid #efe8e8;"><?php echo $data->default_currency." ".$price; ?></td>
                        <td style="text-align:center;padding:11px 0;border-bottom: 1px solid #efe8e8;"><?php echo $data->default_currency." ".number_format($total,2); ?></td>
                    </tr>


</tbody>
<?php
$finalpricetotal2=$total;
//$totalvat2 = $totalvat2+$ovat;

}

$totalamount= number_format($data->total,2);
$shippingamount= number_format(0,2);
$famt = $data->total + $shippingamount;
$finalamount= number_format($famt,2);
?>

                 
                </table>
                <div
                    style="background-color: #fff9f6;padding:20px 20px 20px 10px;border: 1px solid #ffdcc9; width: 544px;margin: 0 auto;">
                    <table style="font-family: 'PT Sans', sans-serif;font-size:.99em; margin-bottom: 0px;
                                color: #4e4c4c; width: 100%;">
                        <tr>
                            <td style="width:81%;text-align: right;padding: 0px 8px 3px 0px;">Sub Total : </td>
                            <td style="font-size: .93em;padding-bottom: 3px;    text-align: right;"><?php echo $data->default_currency." ".$totalamount; ?></td>
                        </tr>
                        <!-- <tr>
                            <td style="width:80%;text-align: right; padding: 0px 8px 3px 0px;"> Order Value : </td>
                            <td style="font-size: .93em;padding-bottom: 3px;    text-align: right;">₹ 18,900.00</td>
                        </tr> -->
                        <tr>
                            <td style="width:80%;text-align: right;padding: 0px 8px 3px 0px;">Delivery Charges : </td>
                            <td style="font-size: .93em;padding-bottom: 3px;    text-align: right;">₹ 0.00</td>
                        </tr>
                        <tr>
                            <td style="width:80%;text-align: right; padding: 0px 8px 3px 0px;">C.O.D : </td>
                            <td style="font-size: .93em;padding-bottom: 3px;    text-align: right;">₹ 0.00</td>
                        </tr>
                        <tr>
                            <td
                                style="width:80%;text-align: right;font-size: 1.2em; padding: 0px 8px 3px 0px;color:#e20000;">
                                Total : </td>
                            <td style="font-size: 1em;padding-bottom: 3px;color:#e20000;    text-align: right;">
                            <?php echo $data->default_currency." ".$finalamount; ?></td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>

        <tr>
            <td style="padding:25px 10px;">
                <p style="font-family: 'PT Sans', sans-serif;font-size:1em;line-height:1.4em;color: #928b8b;">In case
                    you have
                    any queries regarding your order, please call us on +917744402345 or leave us a mail on
                    <a href="mailto:info@shreeyantraindia.com" style="color:#e20000;">info@shreeyantraindia.com</a></p>
                <p style="font-family: 'PT Sans', sans-serif;font-size:1em;line-height:1.4em;color: #928b8b;">Thank
                    You,<br>Team Shree Yantra India !</p>
            </td>
        </tr>
      
    </table>
</body>

</html>
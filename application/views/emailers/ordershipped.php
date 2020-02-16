<html>

<head>

</head>

<body>
    <div style="width: 100%;">
        <table style="width:600px;margin: 0 auto;border:1px solid #f1ecec;">
            <tr>
                <th style="border-bottom: 4px solid #7f1a1a; padding:15px 3px; background-color: #780002;background-image: linear-gradient(#450102, #780002, #450102);">
                    <!-- <h1
                        style="font-size: 1.4em;line-height: 1.5em;color: #7f1a1a; font-family:arial;text-align:left;    margin-bottom: 0;">
                        Mukesh Jewellers</h1> -->
                        <img src="http://virarcity.com/mukeshjewellers/images/logo1.png"  width="160" alt="">
                </th>
            </tr>
            <tr>
                <td style="padding:25px 10px;">
                    <h1
                        style="font-family: 'PT Sans', sans-serif;font-size:1.7em;text-align:center;line-height:1.2em;font-weight: 600;color:#636060;">
                        Your Order Has Been Dispatched!</h1>
                    <p style="font-family: 'PT Sans', sans-serif;font-size:1em;line-height:1.4em;color: #928b8b;">
                        Hi <b style="text-transform: uppercase;"> <?php echo $data->name; ?></b> ,Thank you for your order from Mukesh Jewellers.
                        You can check the status of your order by logging into your account.</p>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="https://www.mukeshjewellers.in/orderorderdetails/<?php echo $data->id; ?>" style="text-decoration:none;">
                        <button style="background-color: #7f1a1a; color:#fff;border-radius:2px;padding:14px 22px;
                            display:block;margin:0 auto;border:none;font-size: 1.1em;">
                            View Order
                        </button>
                    </a>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="width:500px;margin: 0 auto;border: 1px solid #efe8e8;border-radius:3px;
                        padding:25px 10px;text-align: center;background-color: #fcfcfc;margin-top: 20px;">
                        <h2 style="font-family: 'PT Sans', sans-serif;font-size:1.2em;font-weight: normal;
                            color:#e20000;">
                            Estimated Delivery Date:</h2>
                        <p style="font-family: 'PT Sans', sans-serif;font-size:1em; margin-bottom: 20px;
                            color: #928b8b;">
                            <?php echo date('Y-M-d', strtotime($data->date. ' + 5 days')) ?> </p>

                        <a href="" style="text-decoration:none;">
                            <button style="background-color: #7f1a1a; color:#fff;border-radius:2px;padding:10px 18px;
                                    display:block;margin:0 auto;border:none;font-size: 1em;">
                                Track Your Order
                            </button>
                        </a>

                    </div>
                </td>
            </tr>
            <tr>
                <td style="padding:25px 10px;">
                    <p style="font-family: 'PT Sans', sans-serif;font-size:1em;line-height:1.4em;color: #928b8b;">In
                        case
                        you have
                        any queries regarding your order, please call us on 022-28124195 or leave us a mail on
                        <a href="mailto:info@mukeshjewellers.in" style="color:#e20000;">info@mukeshjewellers.in</a>
                    </p>
                    <p style="font-family: 'PT Sans', sans-serif;font-size:1em;line-height:1.4em;color: #928b8b;">Thank
                        You,<br>Team Mukesh Jewellers !</p>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="background-color:  #7f1a1a; padding:0px 10px">
                        <table>
                            <tr>
                                <td width="500">
                                    <p
                                        style="font-family: 'PT Sans', sans-serif;font-size:0.85em;text-align: left;color: #fff;">
                                        Contact Us:+ 022-28124195</p>
                                </td>
                               
                            </tr>
                        </table>


                    </div>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
<html>
<body>
    <div style="width: 100%;">
        <table style="width:600px;margin: 0 auto;border:1px solid #f1ecec;">
            <tr>
                <th style="border-bottom: 2px solid #7f1a1a;padding:15px 3px;">
                    <img width="250p" src="http://mukeshjewellers.in/images/logo.png" alt=""
                        style="float:left;">
                </th>
            </tr>
            <tr>
                <td style="padding:25px 10px;">
                    <h1
                        style="font-family: 'PT Sans', sans-serif;font-size:1.2em;text-transform:capitalize;line-height:1.2em;font-weight: normal;color:#636060;">
                        Dear  <?php echo $data->name; ?> ,</h1>
                    <p style="font-family: 'PT Sans', sans-serif;font-size:1em;line-height:1.4em;color: #928b8b;">We are
                        very excited
                        to have you on board Mukesh Jewellers.
                        You have registered successfully, please find below deatils to login</p>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="width:500px;margin: 0 auto;border: 1px solid #efe8e8;border-radius:3px;
                        padding:25px 10px;text-align: center;background-color: #fcfcfc;">
                        <h2 style="font-family: 'PT Sans', sans-serif;font-size:1.25em;font-weight: normal;
                            color:#e20000;">
                            Your account information:</h2>
                        <p style="font-family: 'PT Sans', sans-serif;font-size:1em; margin-bottom: 0px;
                            color: #928b8b;">
                            Username : <?php echo $data->username ?> </p>
                        <p style="font-family: 'PT Sans', sans-serif;font-size:1em;margin:6px 0px 30px;
                            color: #928b8b;">
                            Password : <?php echo $data->password ?></p>
                        <a href="http://mukeshjewellers.in/login.php" style="text-decoration:none;">
                            <button style="background-color: #7f1a1a;color:#fff;border-radius:2px;padding:10px 18px;
                                display:block;margin:0 auto;border:none;font-size: 1em;">
                                Log In Now
                            </button>
                        </a>

                    </div>
                </td>
            </tr>
            <tr>
                <td style="padding:25px 10px;">
                    <p style="font-family: 'PT Sans', sans-serif;font-size:1em;line-height:1.4em;color: #928b8b;">Stay
                        tuned for latest news and updates from the team at Mukesh Jewellers.</p>
                    <p style="font-family: 'PT Sans', sans-serif;font-size:1em;line-height:1.4em;color: #928b8b;">Thank
                        You,<br>Mukesh Jewellers !</p>
                </td>
            </tr>
          
        </table>
    </div>

</body>

</html>
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
                   
                    <p style="font-family: 'PT Sans', sans-serif;font-size:1em;line-height:1.4em;color: #928b8b;">We are
                        New Enquiry from <b><?php echo $data->name; ?><b>, here are the details</p>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="width:500px;margin: 0 auto;border: 1px solid #efe8e8;border-radius:3px;
                        padding:25px 10px;text-align: center;background-color: #fcfcfc;">
                      
                        <p style="font-family: 'PT Sans', sans-serif;font-size:1em; margin-bottom: 0px;
                            color: #928b8b;">
                            Name : <?php echo $data->name ?> </p>
                        <p style="font-family: 'PT Sans', sans-serif;font-size:1em; margin-bottom: 0px;
                            color: #928b8b;">
                            Phone : <?php echo $data->phone ?> </p>
                        <p style="font-family: 'PT Sans', sans-serif;font-size:1em; margin-bottom: 0px;
                            color: #928b8b;">
                            Email : <?php echo $data->email ?> </p>
                        <p style="font-family: 'PT Sans', sans-serif;font-size:1em;margin:6px 0px 30px;
                            color: #928b8b;">
                            Subject : <?php echo $data->subject ?></p>
                        <p style="font-family: 'PT Sans', sans-serif;font-size:1em;margin:6px 0px 30px;
                            color: #928b8b;">
                            Message : <?php echo $data->message ?></p>
                       

                    </div>
                </td>
            </tr>
          
          
        </table>
    </div>

</body>

</html>
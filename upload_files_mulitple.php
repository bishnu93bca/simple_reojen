<?php

require("connect/db.php");
require("libraries/helper.php");

require("PHPMailer/class.phpmailer.php");

//print_r($_POST);exit;
// for($i=0; $i<count($_FILES['file']['name']); $i++){
//     $target_path = "uploads/";
//     $ext = explode('.', basename( $_FILES['file']['name'][$i]));
//     $target_path = $target_path . md5(uniqid()) . "." . $ext[count($ext)-1]; 
//     if(move_uploaded_file($_FILES['file']['tmp_name'][$i], $target_path)) {
//         echo "The file has been uploaded successfully <br />";
//     } else{
//         echo "There was an error uploading the file, please try again! <br />";
//     }
// }
function generateRandomString($length = 16) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function confirmSupport_mail($emailid, $subj, $ticket_no, $contact_name, $contact_message) {
    $subjct = 'Support request delivery confirmation notification [' . $ticket_no . ']:' . $subj;
    $email_tmp = '<html lang="en"><body><table style="width:600px; margin:0 auto; text-align:left; border:1px solid #4f8db3;font-size: 15px;font-family: arial, sans-serif;"><thead style="background:#00a1ff; color:#fff;"><tr><th style="padding: 12px; font-size: 30px;line-height: 21px;"><img src="img/logo.png" alt="logo"><br></tr></thead><tbody><tr>
      <td style="padding:20px;">
      	<table>
              <tr>
                <td style="padding-bottom: 15px;">Hello ' . $contact_name . ', </td>
              </tr>
              <tr>
                <td style="font-style:italic;padding-bottom: 15px;"> Your ticket has been sent successfully.</strong></td>
              </tr>
              <tr>
                <td style="padding-top: 50px;">
                    <table style="border: 1px solid #4f8db3;width: 100%;background: #eeeeee; padding-left: 10px;padding-right: 10px;">
                        <tr>
                          <td style="padding-bottom: 15px;padding-top: 15px;font-size: 17px;"><strong><span style="text-transform:uppercase;">Ticket</span></strong></td>
                        </tr>
						<tr>
                          <td style="padding-bottom: 15px;"><strong>Ticket Number: </strong> ' . $ticket_no . '</td>
                        </tr>
						<tr>
                          <td style="padding-bottom: 15px;"><strong>Subject: </strong> ' . $subj . '</td>
                        </tr>
			<tr>
                          <td style="padding-bottom: 15px;"> ' . $contact_message . '</td>
                        </tr>
                  </table>
                </td>
              </tr>
        </table>
      </td>
    </tr><tr><td style="background:#ffa124; color:#fff; padding:10px;" align="center">Copyright &copy; ' . date('Y') . ' Reojen Co. All rights reserved.</td></tr></tbody></table></body></html>';

    $to = $emailid;
    $mail = new PHPMailer; // Enable verbose debug output
    $mail->isSMTP();     // Set mailer to use SMTP
    $mail->SMTPDebug = 2;
    //$mail->CharSet="iso-8859-1";
    $mail->SMTPAuth = true;  // enable SMTP authentication
    if(config("smtp_security"))
	{
		$mail->SMTPSecure 	= config("smtp_security"); 
	}
	
    $mail->Host = config("smtp_host"); // change host detail as per requirement
    $mail->Port = config("smtp_port");                 // set the SMTP port for the GMAIL server
    $mail->Username = config("smtp_user");               //   set username(Email)   
    $mail->Password = config("smtp_password");           //   set password
    $mail->setFrom(config("mail_from"), config("mail_from_name")); //change example@example.com as per your requirement
    $mail->addAddress($to, $contact_name);
    $mail->Subject = $subjct;
    $mail->msgHTML($email_tmp);
    //$mail->Body     = $message;
    if (!$mail->send()) {
        echo 'Message was not sent.';
        echo 'Mailer error: ' . $mail->ErrorInfo;
        exit;
    } else {
        echo 'Message has been sent.';
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    global $connection;

    //mail("loveurik@gmail.com",'Test','Test');
    $contact_name = trim($_POST['log_name']);
    $contact_email = trim($_POST['log_email']); //thomasmcampbell01@gmail.com
    $contact_country = trim($_POST['log_country']);
    $contact_mobile = trim($_POST['log_mobile']);
    $contact_subject = trim($_POST['log_subject']);
    $contact_message = trim($_POST['log_message']);


    if (strpos($_SERVER['HTTP_REFERER'], "insupport.php") === false) {

        $country = $connection->query("select name from countrycode where code='" . $contact_country . "'");

        $country_name = $country->fetch_assoc();
        $contact_country = $country_name['name'];
    }




    $mail = new PHPMailer();
    $mail->IsSMTP(); // telling the class to use SMTP
    //$mail->Host       = "mail.yourdomain.com"; // SMTP server
    $mail->SMTPDebug = 2;                     // enables SMTP debug information (for testing)
    // 1 = errors and messages
    // 2 = messages only

    $mail->SMTPAuth = true;                  // enable SMTP authentication
    /* $mail->SMTPSecure 	= 'ssl'; 
      $mail->Host 		= 'smtp.gmail.com';
      $mail->Port 		= 465;                    // set the SMTP port for the GMAIL server
      $mail->Username  	= "harinder.kaur@digimantra.com";  // GMAIL username
      $mail->Password   	= "wonderful@123";            // GMAIL password
      $mail->SetFrom('no-reply@reojen.com', 'Reojen'); */


    $mail->Host = config("smtp_host"); // change host detail as per requirement
    $mail->Port = config("smtp_port");                 // set the SMTP port for the GMAIL server
    $mail->Username = config("smtp_user");               //   set username(Email)   
    $mail->Password = config("smtp_password");             //   set password
    $mail->setFrom($contact_email, $contact_name); //change example@example.com as per your requirement
//    $mail->AddReplyTo($contact_email, $contact_name);

    $random_no = generateRandomString(16);

    $support_email = "support@reojen.com";  // add support email address such as suuport@reojen.com

    $email_subject = '[' . $random_no . '] : ' . $contact_subject;


    //$email_subject='['.$random_no.'] – Support request delivery confirmation - '.$contact_subject;

    $mail->Subject = $email_subject;
    //$mail->AltBody    	= "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

    $email_template = '<html lang="en"><body><table style="width:600px; margin:0 auto; text-align:left; border:1px solid #4f8db3;font-size: 15px;font-family: arial, sans-serif;"><thead style="background:#00a1ff; color:#fff;"><tr><th style="padding: 12px; font-size: 30px;line-height: 21px;"><img src="img/logo.png" alt="logo"><br></tr></thead><tbody><tr>
      <td style="padding:20px;">
      	<table>
              <tr>
                <td style="padding-bottom: 15px;">Hi Admin, </td>
              </tr>
              <tr>
                <td style="font-style:italic;padding-bottom: 15px;"> A new ticket has been received.</strong></td>
              </tr>
              
              <tr>
                <td style="padding-top: 50px;">
                    <table style="border: 1px solid #4f8db3;width: 100%;background: #eeeeee; padding-left: 10px;padding-right: 10px;">
                        <tr>
                          <td style="padding-bottom: 15px;padding-top: 15px;font-size: 17px;"><strong><span style="text-transform:uppercase;">Ticket</span> #' . $random_no . '</strong></td>
                        </tr>
						<tr>
                          <td style="padding-bottom: 15px;"><strong>Name: </strong> ' . $contact_name . '</td>
                        </tr>
						<tr>
                          <td style="padding-bottom: 15px;"><strong>Country: </strong> ' . $contact_country . '</td>
                        </tr>
						<tr>
                          <td style="padding-bottom: 15px;"><strong>Mobile number: </strong> ' . $contact_mobile . '</td>
                        </tr>
                        <tr>
                          <td style="padding-bottom: 15px;"><strong>Subject: </strong> ' . $contact_subject . '</td>
                        </tr>
                        <tr>
                          <td style="padding-bottom: 15px;"><strong>Message:</strong></td>
                        </tr>
                        <tr>
                          <td style="padding-bottom: 15px;">' . $contact_message . '</td>
                        </tr>
                  </table>
                </td>
              </tr>
        </table>
      </td>
    </tr><tr><td style="background:#ffa124; color:#fff; padding:10px;" align="center">Copyright &copy; ' . date('Y') . ' Reojen Co. All rights reserved.</td></tr></tbody></table></body></html>';

    //<tr><td style="padding-bottom: 15px;"><strong>Name: </strong> '.$contact_name.'</td></tr>

    $mail->msgHTML($email_template);


    $mail->addAddress($support_email);

    if (file_exists($_FILES['file']['tmp_name'][0]) || is_uploaded_file($_FILES['file']['tmp_name'][0])) {
        $target_path = "uploads/";
        $success = true;
        $allowedTypes = array('jpg', 'jpeg', 'pdf', 'png', 'gif', 'bmp');
        for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
            $error = $_FILES['file']['error'][$i];
            $ext = pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION);
            if ($error != '4') {
                if (!in_array($ext, $allowedTypes)) {
                    $success = true;
                }
                //10485760 for 10MB
                if ($_FILES['file']['size'][$i] > 5000000) {
                    $success = true;
                }

                if ($success) {
                    $target_path = $target_path . md5(uniqid()) . "." . $ext;
                    if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $target_path)) {
                        $mail->AddAttachment($target_path);
                    }
                }
            }
        }
    }

    if (!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "Successfully";
        confirmSupport_mail($contact_email, $contact_subject, $random_no, $contact_name, $contact_message);
    }
}
?>
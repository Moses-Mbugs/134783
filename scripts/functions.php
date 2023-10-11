<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';


/**
 * A function that generates random numbers .
 * You can modify how many by passing various digit values i.e. 3 for 3 numbers, 4 for 4 numbers etc\
 * 
 * Source : https://stackoverflow.com/questions/8215979/php-random-x-digit-number
 * 
 * 
 * xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
 * 
 * Source : https://github.com/PHPMailer/PHPMailer - this is for the stmp
 * Source : https://app-smtp.brevo.com/real-time - this is for the stmp credentials
 */
function numberGenerator($digits){

    return rand(pow(10, $digits-1), pow(10, $digits)-1);

}

function sendCode($recipient,$recipientName,$code){

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try{
        //Server settings
      //  $mail->SMTPDebug = SMTP::DEBUG_SERVER;                             //Enable verbose debug output
        $mail->isSMTP();                                                     //Send using SMTP
        $mail->Host       = 'smtp-relay.sendinblue.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                            //Enable SMTP authentication
        $mail->Username   = 'moses.muigai@strathmore.edu';                   //SMTP username
        $mail->Password   = 'CIsgBYq83bO57Tpf';                              //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;                  //Enable implicit TLS encryption
        $mail->Port       = 587;                                             //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
        //Recipients
        $mail->setFrom('info@aprrentice.com', 'Do Not Reply');
        $mail->addAddress($recipient, $recipientName);                       //Add a recipient
        //Content
        $mail->isHTML(true);                                                 //Set email format to HTML
        $mail->Subject = 'OTP | Apprentice System';
        $mail->Body    = $code ;
        $mail->AltBody = 'Enjoy a photo of gojo';
        $mail->send();

        //Attachments
        $mail->addAttachment('../images/gojo.jpg');                         //Optional name
            
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}
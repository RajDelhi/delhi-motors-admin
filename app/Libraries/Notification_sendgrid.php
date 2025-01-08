<?php
namespace App\Libraries;
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notification_sendgrid {
    
    public function send_email($from, $from_name,  $to, $subject, $message, $reply_to = false) {

        require_once(APPPATH . '/libraries/sendgrid/vendor/autoload.php');

        $email = new \SendGrid\Mail\Mail();

        if($from == '') {
            $email->setFrom('noreply@commissionverification.com', 'commission verification');
        }
        else {
            $email->setFrom($from, $from_name);
        }
        
        if(!empty($reply_to)) {
            $email->setReplyTo($reply_to);
        }  

        $email->addTo($to);
        $email->setSubject($subject);
        $email->addContent("text/html", $message);

        $sendgrid = new \SendGrid(SEND_GRID_API_KEY);

        $response = $sendgrid->send($email);
        if ($response) { 
            if (trim($response->statusCode()) == 202) {
                return true;
            } else {
                print $response->statusCode() . "\n";
                print_r($response->headers());
                print $response->body() . "\n";
                echo "<pre>";
                print_r($response);
                die("___END___");
            }
        } 
        
        return false;
    }
}

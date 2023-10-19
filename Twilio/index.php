
<?php


// Update the path below to your autoload.php,
// see https://getcomposer.org/doc/01-basic-usage.md
require_once '../Twilio/autoload.php';
use Twilio\Rest\Client;



function sendMessage($messagetxt,$sent_to){
    $sid    = "ACe466e6df8a915fb70215bb97f25d6f44";
    $token  = "63d590352ec7a560fa2018aca11478ae";
    $twilio = new Client($sid, $token);
    $new_number = "";

    $firstStringCharacter = substr($sent_to, 0, 3);
    if($firstStringCharacter == "+44"){
        $new_number = $sent_to;
    }else{
        $firstStringCharacter = substr($sent_to, 0, 1);
        if($firstStringCharacter == "0"){

            $new_number = substr_replace($sent_to,'+44',0,1);
        }else{
            $new_number = substr_replace($sent_to,'+44',0,0);
        }
    }

    $message = $twilio->messages
    ->create($new_number, // to
        array(
            "messagingServiceSid" => "MG9d9a18dddbcd3df4e556a4498b4d7592",
            "body" => $messagetxt
        )
    );
    
    return $message;
}

//print($message);

?>
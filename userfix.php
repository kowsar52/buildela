<?php 

include_once "serverside/functions.php";
include_once "serverside/session.php";
require_once 'Twilio/autoload.php';

date_default_timezone_set('Europe/London');

$func = new Functions();
<?php

use Twilio\Rest\Client;

// Your Account SID and Auth Token from twilio.com/console
// To set up environmental variables, see http://twil.io/secure
$sid    = "ACe466e6df8a915fb70215bb97f25d6f44";
$token  = "63d590352ec7a560fa2018aca11478ae";


// A Twilio number you own with SMS capabilities
$twilio_number = "+15017122661";

$client = new Client($sid, $token);
$client->messages->create(
    // Where to send a text message (your cell phone?)
    '+8801722611182',
    array(
        'from' => $twilio_number,
        'body' => 'I sent this message in under 10 minutes!'
    )
);

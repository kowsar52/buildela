<?php
include 'serverside/functions.php';
$Functions = new Functions();
$title = "You have a new lead";
$body =  "You have a new Electrician lead in UK: FIX Frigge";

$notification = [
    'title' => $title,
    'body' => $body,
    'sound' => "default",
    'priority' => high,
    'click_action' => FLUTTER_NOTIFICATION_CLICK,
    'data' => [
        'type' => 'leads_detail',
        'job_id' => 335,
        'job_title' => 'FIX Frigge',
    ]
];

$tokens = ["f7hbOiyB3UHInhKxiLZy4O:APA91bFDvcxNN66HJFRYAXcHuJ8MEPEZeU0v95N0F7x7OddXubdiJNibrApGLJk1KCY7idYxLQXFr5SrW73Ar_032qLqXiIBzIM3Mt2LdkVKT7_ouHG0GfcuJqizb7Uv-M3MvtsjYtky","eIK_KDCbTM-bYPV_MmpX5Z:APA91bFTSfwS0uZZ_Dy_bQ466Qz8DfOETQwLeK98kYs2woYzRUVCeS1xySsfNge7N8Zrc0ZGL2X72GLWVGe5kJj4wvTEn8x1mhamSzFIUj-i_JfoDXuX37H2WJWPHkYROew_aSKROeif"];
$Functions->sendNotification($tokens, $notification);
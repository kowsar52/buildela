<?php
include 'serverside/functions.php';
$Functions = new Functions();
$title = "You have a new lead";
$body =  "You have a new Electrician lead in UK: FIX Frigge";

$notification = [
    'title' => $title,
    'body' => $body
];

$tokens = ["endQxOgVQZKdcFLsZ69tRw:APA91bFrQEzIUyJQmFVKn7t-aCYbQeD5PIKva432UR4YJ2gvsDjYjJ13UOphw0J-mVZ_T7z5_sZuV94gMnipdS3-1REykJ5cH5X5sum7cuyps_C_z5FjGSRgOrlD_oaIrgs2V991IZ9i",
"cllpKmfCq8pif05orPgINE:APA91bGpC3HlvOsaHDV1nt3jIpuQhX7TILsUzU8BKw2jyRXN-HClaLBY13wvMmBfGorWjszcPPGe4pptkjxgAD796XwRCQy7P5lCEM6lPzUtQ12ZEYKwEAdhy4N38FD8VpUdZOmecBiw"];
$Functions->sendNotification($tokens, $notification);
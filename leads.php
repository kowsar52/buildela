<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="css/style.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
<style type="text/css">
    .mfp-wrap,.mfp-bg{
        z-index: 999999999 !important;
    }
    .three-fraction {
        order: 1;
    }
    
    .six-fraction {
        order: 2;
    }
    .single-leads-interested-tradepeople-feedback span {
        margin-left: -4px;
        margin-bottom: 3px;
        display: inline-block;
    }
    .single-lead-complete-job-description {
        padding: 20px;
    }
    .single-lead-complete-job-description-heading.h4 {
        text-transform: capitalize;
    }

    .single-lead-complete-job-name,.single-lead-complete-customer-description-heading {

        font-size: 17px;
        font-weight: 700;
    }

    .single-lead-complete-customer-description p {
        font-size: 14px;
        margin-bottom: 0px;
        line-height: 20px;
        color: #777;
    }
    .leads-job-photos.row a img {
        height: 100%;
        width: 100%;
        object-fit: cover;
        max-height: 195px;
    }
    video.img-fluid.rounded {
        height: 125px;
        width: 100%;
        margin-top: 15px;

    }
    .total-counts {
        background-color: #F8F9FF;
        padding: 10px 7px;
        font-weight: 600;
        border: 1px solid rgb(237, 237, 237);
        border-top: 0;
        font-size: 13px;
        line-height: 1;
    }

    .btn-bg-general {
        background-color: #2d7af1;
        border: 5px solid #006bf5;
        color: #fff!important;
        cursor: pointer;
    }
    .btn-bg-general:hover {
        background-color: #1861d1;
        color: #fff !important;
        border: 5px solid #1861d1;
    }
    .btn-div-general a:hover{
        color: #1861d1;
    }

    .single-lead-desc-first-sec-loc-address a {
        color: #2d7af1;
        line-height: 1.3;

    }

    .single-lead-desc-first-sec-loc-address a i {
        color: #2d7af1;
        padding-top: 0;
        font-size: 13px;

        margin-right: 4px;
    }

    .single-lead-desc-first-sec-loc-address a:hover,.single-lead-desc-first-sec-loc-address a:hover i {
        color: #1861D1;
    }
    .single-lead-desc-first-sec-loc-address p {
        margin-bottom: 0;
    }
    .time-sec {
        font-size: 14px;
    }
    .verified-badge {
        color: #17A950;
        display: flex;
        align-items: center;
        gap: 3px;
        padding: 2px 6px;
        font-weight: 600;
        font-size: 14px;
        line-height: 1.2;
        border-radius: 3px;
        background-color: #dfffec;
        border: 1px solid #17A950;
    }

    .phoneNumber {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .phoneNumber p {
        margin-bottom: 0;
    }
    .phoneNumber p i {
        color: #007bff;
        font-size: 13px;
        margin-right: 4px;

    }

    .single-leads-interested-tradepeople-feedback span {
        margin-left: -2px;

    }
    .single-leads-interested-tradepeople-feedback {
        font-size: 14px;

    }

    .w-dropdown-list {
        z-index: 10;
    }

    

</style>

<?php
require_once "serverside/functions.php";
include_once "serverside/session.php";
include_once "includes/header.php";
date_default_timezone_set('Europe/London');
error_reporting(0);
$func           =   new Functions();

if(!$func->checkSubscription()){
    echo "<script>window.location.href='trademember-my-account';</script>";
    exit;
}




$userInfo       =   $func->UserInfo($_SESSION['user_id']);
$my_skills      =   $func->getMySkills($_SESSION['user_id']);
$func->set_last_seen($_SESSION['user_id']);

$my_check       =   $func->checkMyapprove($_SESSION['user_id']);
$my_checkuserdoc=   $func->checkUsergasorele($_SESSION['user_id']);
$user           =   $func->UserInfo($_SESSION['user_id']);
$subscription_id=   $user[0]['cus_id_stripe'];
$payuser_id     =   $user[0]['id'];
$readcount      =   0;
$countjobs      =   0;



$jobPostCodes      = [];
$showJobs          = [];
$distanceOfJobs    = [];
$jobids            = [];


$user_post_code     =   $userInfo[0]['post_code'];
$jobPostCodes       =   [];
$filterarray        =   [0, 1, 2];
$interestedJobs     =   [];
$shortlistedJobs    =   [];
$jobswon            =   [];

$inrestedcount      =   0;
$shortlistedcount   =   0;
$jobswoncount       =   0;

$leadfilter         =   null; 




/*
 *
 * Setting read unread status based on $_GET variable's value
 * 
 */

 if(isset($_GET['id']) && isset($_GET['d']) && isset($_GET['r']) && isset($_GET['j']) ) {
    $posts = [
        'job_id'        =>  htmlspecialchars(stripslashes($_GET['id'])),
        'distance'      =>  htmlspecialchars(stripslashes($_GET['d'])),
        'jobscount'     =>  htmlspecialchars(stripslashes($_GET['j'])),
        'reading'       =>  htmlspecialchars(stripslashes($_GET['r'])),
        'identifiyer'   =>  htmlspecialchars(stripslashes($_GET['i'])),       
        'postcode'      =>  htmlspecialchars(stripslashes($_GET['p'])),       
    ];

    $dis                =   $func->batchDistance($user_post_code, [$posts['postcode']], 'mile');                       
    $jobid              =   $posts['job_id'];
    $distance           =   $posts['distance'];
    $reading            =   $posts['reading'];
    $identifiyer        =   $posts['identifiyer'];
    $jobscount          =   $posts['jobscount'];

    $dis                =   $_GET['d'];
    $reaading           =   $_GET['r'];
    $indentity          =   $_GET['i'];
    $incomingjobscount  =   $_GET['j'];

    if($posts['identifiyer'] == 'leads') $identifier = 'leads';
    elseif($posts['identifiyer'] == 'interested') $identifier = 'interested';
    elseif($posts['identifiyer'] == 'shortlisted') $identifier = 'shortlisted';
    elseif($posts['identifiyer'] == 'jobswon') $identifier = 'jobswon';

    if(!$func->isLeadRead($jobid, $identifier)){
        $func->setLeadRead($jobid, $identifier);
    }

    if($reading === 'unread'){
        $func->leadCountManager($identifiyer, true);
    }

}elseif($_GET['leadfilter'] == 0) {
    $posts['identifiyer']   =  'interested';
}elseif($_GET['leadfilter'] == 1) { 
    $posts['identifiyer']   =  'shortlisted';
}elseif($_GET['leadfilter'] == 2){
    $posts['identifiyer']   =  'jobswon';
}else {
    $posts['identifiyer']   =  'leads';
}

if(isset($_GET['id']) & isset($_GET['i'])){

    

}

// Read unread satatus setup closed ------------------------------




    
if (isset($_GET['leadfilter']))
    $leadfilter = (int) $_GET['leadfilter'];
elseif(isset($_GET['i']) && $_GET['i'] == 'leads')
    $leadfilter = 5;
elseif(isset($_GET['i']) && $_GET['i'] == 'interested')
    $leadfilter = 0;
elseif(isset($_GET['i']) && $_GET['i'] == 'shortlisted')
    $leadfilter = 1;
elseif(isset($_GET['i']) && $_GET['i'] == 'jobswon')
    $leadfilter = 2;
else $leadfilter = 5;



if((isset($_GET['leadfilter']) && $leadfilter  == 0) || (isset($_GET['i']) && $_GET['i'] == 'interested')) {
    $identifyer =  "interested";
    $leadfilter = 0;
}elseif ((isset($_GET['leadfilter']) && $leadfilter  == 1) || (isset($_GET['i']) && $_GET['i'] == 'shortlisted')){
    $identifyer =  "shortlisted";
    $leadfilter = 1;
}elseif((isset($_GET['leadfilter']) && $leadfilter  == 2) || (isset($_GET['i']) && $_GET['i'] == 'jobswon')) {
    $identifyer =  "jobswon";
    $leadfilter = 2;
}else {
    $identifyer =  "leads";
    $leadfilter = 5;
}


if($leadfilter  == 5){
    $Main_jobs_array = $func->getMatchJobs($_SESSION['user_id']);
    $identifyer      =  "leads";
} elseif ($leadfilter  == 0 || $leadfilter  == 1 || $leadfilter  == 2) {
    $Main_jobs_array = $func->getSearchJobs($leadfilter, $_SESSION['user_id'])[0];
}elseif(isset($_GET['category'])){
    $categories = array_map('htmlspecialchars', $_GET['category']);
    $Main_jobs_array=$func->getFilterJobs($categories);
    $identifyer      =  "leads";
}else {
    $Main_jobs_array = $func->getMatchJobs($_SESSION['user_id']);
    $identifyer      =  "leads";
}



for($i=0; count($filterarray) > $i; $i++){

    $filterjobs = $func->getSearchJobs($i,$_SESSION['user_id'])[0];


    foreach ($filterjobs as $job){
        $job_post_code=$job['post_code'];
        $job_post_code = preg_replace('/\s+/', '', $job_post_code);
        $user_post_code = preg_replace('/\s+/', '', $user_post_code);

        $distance = $func->DistanceCalculation($user_post_code, $job_post_code);

        if($distance <= $userInfo[0]['distance']){

            if($i === 0 && !$func->isLeadRead($job['id'], 'interested')) $inrestedcount++;
            if($i === 1 && !$func->isLeadRead($job['id'], 'shortlisted')) $shortlistedcount++;
            if($i === 2 && !$func->isLeadRead($job['id'], 'jobswon')) $jobswoncount++;
        }
    }

}

$inrestedcount = $inrestedcount - 1;

 // Collect job post codes
 foreach ($Main_jobs_array as $jobs) $jobPostCodes[] = $jobs['post_code'];
 


$startIndex            = 0;
$batchSize             = 25;
$jobPostCodeBatches    = array_chunk($jobPostCodes, $batchSize);
$user_post_code        = $userInfo[0]['post_code'];
$user_post_code        = str_replace(' ', '', $user_post_code);





foreach ($jobPostCodeBatches as $batch) {

    $limit_ch = count($batch);

     $result = $func->batchDistance($user_post_code, $batch, 'mile');

     $Main_jobs_array_slice = array_slice($Main_jobs_array, $startIndex, 25);
     $startIndex += $limit_ch;

     $i = 0;
    foreach ($Main_jobs_array_slice as $index => $jobs) {
            $distance = array(
                 "meters" => $result[$i] * 1609.34,
                 "kilometers" => $result[$i] * 1.60934,
                 "yards" => $result[$i] * 1760,
                 "miles" => $result[$i]
            );


            if ($distance['miles'] <= $userInfo[0]['distance']) {
                $showJobs[]        = $jobs;
                $distanceOfJobs[]  = $distance['miles'];
                $jobids[]          = $jobs['id'];
            }
            $i++;
    }
}

$countjobs = count($showJobs);
if($countjobs) foreach($showJobs as $jobs) if(!$func->isLeadRead($jobs['id'], $identifyer)) $readcount++;



// This is job counter for lead section once it is other than new lead section
if(isset($_GET['j']) || $leadfilter  == 0 || $leadfilter  == 1 || $leadfilter  == 2) {

    $p_codes        = [];
    $leadscounter   = null;
    $lead_jobs      = [];

    $leadjobs = $func->getMatchJobs($_SESSION['user_id']);
    // Collect job post codes
    foreach ($leadjobs as $jobs) $p_codes[] = $jobs['post_code'];   


    $start              = 0;
    $batchlimit         = 25;
    $batches            = array_chunk($p_codes, $batchlimit);


    foreach ($batches as $batch) {

        $limit_ch = count($batch);

        $result = $func->batchDistance($user_post_code, $batch, 'mile');

        $leadjobs_slice = array_slice($leadjobs, $start, 25);
        $start += $limit_ch;
        $i = 0;
        foreach ($leadjobs_slice as $index => $jobs) {
                $durutto = array(
                    "meters" => $result[$i] * 1609.34,
                    "kilometers" => $result[$i] * 1.60934,
                    "yards" => $result[$i] * 1760,
                    "miles" => $result[$i]
                );


                if ($durutto['miles'] <= $userInfo[0]['distance']) {
                    $lead_jobs[]        = $jobs;
                }
                $i++;
                
        }
    }
    if($lead_jobs) foreach($lead_jobs as $jobs) if(!$func->isLeadRead($jobs['id'], 'leads')) $leadscounter++;

}



echo '
<script>
function checkSubscription(user_id, subscription_id) {
    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        data: {
            func: 371, 
            user_id: user_id,
            subscription_id: subscription_id, // sending subscription id
        },
        success: function (data) {

            if (data.trim() == "false") { // if the subscription has expired
                swal("No Subscription", "Kindly make subscription and try again", "info").then((value) => {
                    window.location.href="trademember-my-account";
                });
            }
        }
    });
}


var subscription_id = "' . $subscription_id . '";
var user_id = "' . $payuser_id . '";
checkSubscription(user_id, subscription_id);
</script>
';


$dis = $func->batchDistance($user_post_code, [$showJobs[0]['post_code']], 'mile');                                
                                
$posts = [
    'job_id'        =>  $showJobs[0]['id'],
    'distance'      =>  $dis[0],
    'jobscount'     =>  count($showJobs),
    'reading'       =>  'read',
    'identifiyer'   =>  'interested',       
];

if(isset($_GET['id']) && isset($_GET['d']) && isset($_GET['r']) && isset($_GET['j']) ) {
    $posts = [
        'job_id'        =>  htmlspecialchars(stripslashes($_GET['id'])),
        'distance'      =>  htmlspecialchars(stripslashes($_GET['d'])),
        'jobscount'     =>  htmlspecialchars(stripslashes($_GET['j'])),
        'reading'       =>  htmlspecialchars(stripslashes($_GET['r'])),
        'identifiyer'   =>  htmlspecialchars(stripslashes($_GET['i'])),       
    ];
}elseif($_GET['leadfilter'] == 0) {
    $posts['identifiyer']   =  'interested';
}elseif($_GET['leadfilter'] == 1) { 
    $posts['identifiyer']   =  'shortlisted';
}elseif($_GET['leadfilter'] == 2){
    $posts['identifiyer']   =  'jobswon';
}else {
    $posts['identifiyer']   =  'leads';
}

if(isset($_GET['id']) && isset($_GET['i']) ){
    if($func->isMobileDevice() && $func->checkUrlQueryString()){?>
    <div id="my-mobile-modal" class="mobile-modal" style="width: 100%;">
        <?php require_once "includes/single_lead_mobile.php"; ?>
    </div>
    <script>
        // $(document).ready(function(){
        //     $('#newleads').click();
        // });        
    </script>
<?php }  } ?>

<script>
    /*------------------------------------------------------
                 Open Leads using a modal function
    -------------------------------------------------------*/

    var job_ids = [];

    function _openModal(id,distance,countjobs, clickedelement=null){

        let leadsunread         =   $('#newleads .show_counter_label'),
            interestedunread    =   $('#filter1 .show_counter_label'),
            shortlistedunread   =   $('#filter2 .show_counter_label'),
            jobswonunread       =   $('#filter3 .show_counter_label'),
            readingStatus       =   '',
            counter             =   0,
            identifyer          =   $(clickedelement).attr('data-identity'),
            countholder         =   $('.show_counter');

        if($(clickedelement).hasClass('unreadlead')) {
            readingStatus = 'unread';
        } else {
            readingStatus = 'read';
        }

        if(identifyer === 'leads'){
            counter = parseInt(leadsunread.text())
        }else if (identifyer === 'interested') {
            counter = parseInt(interestedunread.text())
        }else if (identifyer === 'shortlisted') {
            counter = parseInt(shortlistedunread.text())
        }else if (identifyer === 'jobswon') {
            counter = parseInt(jobswonunread.text())
        }    


        $.ajax({
            url: "single_lead.php",
            type: "POST",
            data:{
                job_id:id,
                distance:distance,
                reading: readingStatus,
                jobscount: countjobs,
                identifyer: identifyer
            },
            success: function (data) {

                var protocol    = window.location.protocol;
                var host        = window.location.hostname;
                var port        = window.location.port ? ':' + window.location.port : '';
                var baseUrl     = protocol + '//' + host + port;
                var baseURL     = baseUrl + '/leads';
                var url         = baseURL + '?id=' + id + '&d=' + distance + '&r=' + readingStatus + '&j=' + countjobs + '&i=' + identifyer;

                history.pushState({
                    id: id,
                    d: distance,
                    r: readingStatus,
                    j: countjobs,
                    i: identifyer
                }, null, url);


                if($(clickedelement).hasClass('unreadlead')) {
                    counter--;
                    if(counter < 1 ) {
                        counter = 0;
                        $(clickedelement).find('.active-lead').remove();

                    }
                    countholder.text(counter);

                    if(identifyer === 'leads'){
                        if(counter < 1 ) $('#newleads').find('.active-lead').remove();
                        else leadsunread.text(counter);
                    }else if (identifyer === 'interested') {
                        if(counter < 1 ) $('#filter1').find('.active-lead').remove();
                        else interestedunread.text(counter);
                    }else if (identifyer === 'shortlisted') {
                        if(counter < 1 ) $('#filter2').find('.active-lead').remove();
                        else shortlistedunread.text(counter);
                    }else if (identifyer === 'jobswon') {
                        if(counter < 1 ) $('#filter3').find('.active-lead').remove();
                        else jobswonunread.text(counter);
                    }

                    $(clickedelement).removeClass('unreadlead');
                }



                $(".six-fraction").html(data);
                var element = document.getElementById("six-fraction");
                element.style.display = "block";
                $("#my-mobile-modal").css('width', '100%');

                $('#job_id1').val($('#apply_btn').data('job_id'));
                $('#job_location').val($('#apply_btn').data('post_code'));


                // initMagnificPopup();

                $('.image-blocks').magnificPopup({
                    delegate: 'a',
                    type: 'image',
                    tLoading: 'Loading image #%curr%...',
                    mainClass: 'mfp-img-mobile',
                    gallery: {
                        enabled: true,
                        navigateByImgClick: true,
                        preload: [0,1]
                    },
                    image: {
                        tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                        titleSrc: function(item) {
                            var $gallery = $('.image-blocks');
                            var $result = '';
                            if ($gallery.find('a').length > 0) {
                                var numThumbs = $gallery.find('a').length; // Get the total number of thumbs
                                var numVisibleThumbs = 4; // Set the number of initially visible thumbs
                                var startThumbIndex = Math.floor(item.index / numVisibleThumbs) * numVisibleThumbs; // Calculate the start index of the visible thumbs

                                $result = '<div class="mfp-pager">' +
                                    '<div class="arrow_prev">' +
                                        '<button type="button" class="prev arrow" onclick="javascript:$(\'.image-blocks\').magnificPopup(\'prev\');return false;"><i class="fa-solid fa-angle-left"></i></button>' +
                                    '</div>' +
                                    '<div class="dots">' +
                                    '<div class="dots-container" style="display: flex; overflow-x: auto;">';

                                for (var i = startThumbIndex; i < startThumbIndex + numVisibleThumbs && i < numThumbs; i++) {
                                    var $cl_active = '';
                                    if (item.index == i) $cl_active = ' active';
                                    var $thumb = $gallery.find('a:eq('+i+')').find('img').attr('src');
                                    $result += '<div class="dot-item' + $cl_active + '">' + '<button type="button" onclick="javascript:$(\'.image-blocks\').magnificPopup(\'goTo\', '+i+');return false;"><img src="' + $thumb + '" width="50"></button>' + '</div>';
                                }
                                $result += '</div>' + '</div>';

                                if (numThumbs > numVisibleThumbs) {
                                    $result += '<div class="arrow_next">' + '<button type="button" class="next arrow" onclick="javascript:$(\'.image-blocks\').magnificPopup(\'next\');return false;"><i class="fa-solid fa-angle-right"></i></button>' + '</div>';
                                }

                                $result += '</div>';
                            }

                            return $result;
                        }
                    }
                });


                $('.openVideo').magnificPopup({

                    type: 'inline',
                    gallery: {
                        enabled: true,
                        navigateByImgClick: true,
                        preload: [0,1]
                    },

                    callbacks: {
                        open: function() {
                            $('html').css('margin-right', 0);
                            $('html').addClass('htmlopenvideo');

                            // Play video on open:
                            // $(this.content).find('video')[0].play();

                        },
                        close: function() {

                            // Reset video on close:
                            $(this.content).find('video')[0].load();

                        }
                    }
                });

            }
        });

        $.ajax({
            url: "single_lead_mobile.php",
            type: "POST",
            data:{
                job_id:id,
                distance:distance,
                reading: readingStatus,
                jobscount: countjobs,
                identifyer: identifyer
            },
            success: function (data) {

                $("#my-mobile-modal").html(data);
                var element = document.getElementById("six-fraction");
                element.style.display = "block";
                $("#my-mobile-modal").css('width', '100%');

                $('#job_id1').val($('#apply_btn').data('job_id'));
                $('#job_location').val($('#apply_btn').data('post_code'));
                $('.image-blocks-mobile').magnificPopup({
                    delegate: 'a',
                    type: 'image',
                    tLoading: 'Loading image #%curr%...',
                    mainClass: 'mfp-img-mobile',
                    gallery: {
                        enabled: true,
                        navigateByImgClick: true,
                        preload: [0,1]
                    },
                    image: {
                        tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                        titleSrc: function(item) {
                            var $gallery = $('.image-blocks');
                            var $result = '';
                            if ($gallery.find('a').length > 0) {
                                var numThumbs = $gallery.find('a').length; // Get the total number of thumbs
                                var numVisibleThumbs = 4; // Set the number of initially visible thumbs
                                var startThumbIndex = Math.floor(item.index / numVisibleThumbs) * numVisibleThumbs; // Calculate the start index of the visible thumbs

                                $result = '<div class="mfp-pager">' +
                                    '<div class="arrow_prev">' +
                                        '<button type="button" class="prev arrow" onclick="javascript:$(\'.image-blocks\').magnificPopup(\'prev\');return false;"><i class="fa-solid fa-angle-left"></i></button>' +
                                    '</div>' +
                                    '<div class="dots">' +
                                    '<div class="dots-container" style="display: flex; overflow-x: auto;">';

                                for (var i = startThumbIndex; i < startThumbIndex + numVisibleThumbs && i < numThumbs; i++) {
                                    var $cl_active = '';
                                    if (item.index == i) $cl_active = ' active';
                                    var $thumb = $gallery.find('a:eq('+i+')').find('img').attr('src');
                                    $result += '<div class="dot-item' + $cl_active + '">' + '<button type="button" onclick="javascript:$(\'.image-blocks\').magnificPopup(\'goTo\', '+i+');return false;"><img src="' + $thumb + '" width="50"></button>' + '</div>';
                                }
                                $result += '</div>' + '</div>';

                                if (numThumbs > numVisibleThumbs) {
                                    $result += '<div class="arrow_next">' + '<button type="button" class="next arrow" onclick="javascript:$(\'.image-blocks\').magnificPopup(\'next\');return false;"><i class="fa-solid fa-angle-right"></i></button>' + '</div>';
                                }

                                $result += '</div>';
                            }

                            return $result;
                        }
                    }
                });


            }//success
        });//ajax

    }

    function modalHTTP(id,distance,countjobs, postcode, clickedelement=null){

        let leadsunread         =   $('#newleads .show_counter_label'),
            interestedunread    =   $('#filter1 .show_counter_label'),
            shortlistedunread   =   $('#filter2 .show_counter_label'),
            jobswonunread       =   $('#filter3 .show_counter_label'),
            readingStatus       =   '',
            counter             =   0,
            identifyer          =   $(clickedelement).attr('data-identity'),
            countholder         =   $('.show_counter');
                

        if($(clickedelement).hasClass('unreadlead')) {
            readingStatus = 'unread';
        } else {
            readingStatus = 'read';
        }

        if(identifyer === 'leads'){
            counter = parseInt(leadsunread.text())
        }else if (identifyer === 'interested') {
            counter = parseInt(interestedunread.text())
        }else if (identifyer === 'shortlisted') {
            counter = parseInt(shortlistedunread.text())
        }else if (identifyer === 'jobswon') {
            counter = parseInt(jobswonunread.text())
        }  
        
        var protocol    = window.location.protocol;
        var host        = window.location.hostname;
        var port        = window.location.port ? ':' + window.location.port : '';
        var baseUrl     = protocol + '//' + host + port;
        var baseURL     = baseUrl + '/leads';
        var url         = baseURL + '?id=' + id + '&d=' + distance + '&r=' + readingStatus + '&j=' + countjobs + '&i=' + identifyer + '&p='+ postcode + '#job'+id;

        localStorage.setItem("lastClickedItem", $(clickedelement).attr("data-jid"));
        window.location = url;

        
    }

    $(document).on('click', '.cross', function(){
        var protocol = window.location.protocol;
        var host = window.location.hostname;
        var port = window.location.port ? ':' + window.location.port : '';
        var baseUrl = protocol + '//' + host + port;
        var baseURL = baseUrl + '/leads';

        if(fixingUnread() === 'newleads') baseURL = baseURL + '?leadfilter=0';
        else if(fixingUnread() === 'interested') baseURL = baseURL + '?leadfilter=0';
        else if(fixingUnread() === 'shortlisted') baseURL = baseURL + '?leadfilter=1';
        else if(fixingUnread() === 'jobswon') baseURL = baseURL + '?leadfilter=2';
         
        history.replaceState(null, null, baseURL);


    });

    $(document).on('click', '#leadItems a', function(e){
        
        let clickX =    e.clientX;
        let clickY =    e.clientY;
        localStorage.setItem("clickX", clickX);
        localStorage.setItem("clickY", clickY);
    });

    $(document).ready(function(){
        const hash = window.location.hash.substr(1);
        if (hash) {
            const targetElement = $("#" + hash);
            if (targetElement.length) {
                const storedClickX = localStorage.getItem("clickX") || 0;
                const storedClickY = localStorage.getItem("clickY") || 0;

                const offsetY = targetElement.offset().top - storedClickY;
                $(".single-leads-list-links-wrapper").animate({
                    scrollTop: offsetY
                }, 1000);
            }
        }
    });


</script>




<?php
if($_SESSION['user_role']=='home_owner'){
    ?>
    <script type="text/javascript">
        window.location.href="my-posted-jobs";
    </script>
    <?php

}

if(isset($_GET['job_id']) && isset($_GET['backl']) && is_numeric($_GET['job_id']) && $_GET['backl'] == '1'){


  ?>
    <script>
        // $(document).ready(function() {
        //     openModal(<?php echo $_GET['job_id']; ?>, <?php echo $_GET['ds']; ?>);
        // });
    </script>
    <?php
} elseif ($userInfo[0]['subscription_status'] == 1) {

} else {
    ?>
    <script type="text/javascript">
        // $(document).ready(function () {
        //    swal("No Subscription", "Kindly subscribe and try again", "info").then((value) => {
        //        window.location.href="trademember-my-account";
        //    });
        // });
    </script>
    <?php
    // exit();
}

//    if user hava no skills

if (isset($my_checkuserdoc[0]) && count($my_check[0]['status']) == 0 && count($my_skills)==0) {
    ?>
    <script type="text/javascript">
        $(document).ready(function (){
            swal("", "Your application is being verified. We aim to have your account processed within the next 24hours", "info").then((value) => {
                window.location.href="my-profile";
            });
        });

    </script>
    <?php
    exit();
}


if(count($my_skills)==0){

    ?>
    <script type="text/javascript">
        $(document).ready(function (){
            swal("", "Take a quiz in your chosen trades, to start receiving leads in your area", "info").then((value) => {
                window.location.href="my-profile";
            });
        });

    </script>
    <?php
    exit();
}
?>

<style>
* {
    transition: all 0.3s ease-in-out;
}
.body {
    background-color: var(--page-bg);
}

section.footer-dark.wf-section {
    display: none!important;
}
.d-flex.justify-content-end {
    align-self: flex-start;
}
img.pl-2.img-fluid {

    width: 35px;
    margin-right: 20px;
}
.filter-conatiner{
    right: 0;
    z-index: 99999;
}
.filter-header{
    background-color: rgba(66,133,244,1);
    padding: 10px 5px;
}
.filter-heading{
    /*font-family: Raleway-Black;*/
    font-weight: bold;
    font-size: 22px;
    color: #000 !important;
}
.filter-conatiner{
    display: none;
}
.filter-label , .filter-input{
    cursor: pointer;
}
.alert td {
    color: #595656 !important;
    font-weight: 700;
}
.unread {
    font-family: inherit;
    font-size: 16px;
  line-height: 23px;
    display: inline-flex;
}
.unread span {
    color: #fff;
    border: 0;
    margin-right: 5px;
    background: var(--blue-color);

}
a#filter-jobs {
    margin-left: 10px;
}

.lead-desc-first-sec-loc {


    font-weight: 600!important;
}
.lead-desc-first-sec-loc i {
    color: var(--blue-color);
    padding-right: 2px;
    font-size: 13px;
}
.lead-desc-first-sec-address span {
    font-family: inherit;
    color: #777;
    border: 0;
    border-radius: 0;
    margin-right: 0;
}

.single-lead-posted-date {
    color: grey;


}
.single-lead-posted-customer-name {
    color: gray;
    border-top: 1px solid #ddd;

}
.single-lead-posted-customer-name a {

    font-weight: 600;

}
.job-photos-heading, .lead-shortlisted-heading {

    font-size: 17px;
    font-weight: 700;
}

.leads-job-photos-wrapper, .single-lead-complete-customer-description-wrapper, .lead-shortlisted-wrapper {
    border-bottom: 3px solid #dedede;
}
.lead-shortlisted-content span:nth-of-type(1) {
    font-size: 16px;

}
.leads-interested-tradepeople-heading {
    font-size: 17px;
    font-weight: 700;
}
.leads-job-photos h6 {
    margin-top: 0;
    margin-bottom: 5px;
}

/* NEW CODE*/


.swal-button {
    background-color: #006bf5!important;
    color: #fff;
    border: none;
    box-shadow: none;
    border-radius: 5px;
    font-weight: 600;
    font-size: 14px;
    padding: 10px 24px;
    margin: 0;
    cursor: pointer;
}.swal-text {

    text-align: center;
}
.hidden-div.h4.text-center {
    font-size: 0.9rem;
}
img.pl-2.img-fluid.imessage-img {
    width: 55px;
    display: block;
    margin-left: auto;
    margin-right: auto;
    margin-bottom: 20px;
    text-align: center;
}

#load-more {
    display: flex;
    align-items: center;
    justify-content: center;
}

#load-more img {
    max-width: 100px;
}

@-webkit-keyframes svg-text-anim {
    40% {
        stroke-dashoffset: 0;
        fill: transparent;
    }
    60% {
        stroke-dashoffset: 0;
        fill: #3115bc;
    }
    100% {
        stroke-dashoffset: 0;
        fill: #3115bc;
    }

}
/* Most browsers */
@keyframes svg-text-anim {
    40% {
        stroke-dashoffset: 0;
        fill: transparent;
    }
    60% {
        stroke-dashoffset: 0;
        fill: #3115bc;
    }
    100% {
        stroke-dashoffset: 0;
        fill: #3115bc;
    }

}
.new-lead-icon1 {
    border: 2px solid #fff;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
}
.new-lead-icon.active-filter,.job-won-peoples-icon.active-filter {
    border-color: var(--golden-border);
}
.interested-peoples-icon.active-filter{
  border-color:#006BF5;
}
.shortlisted-peoples-icon.active-filter{
  border-color: var(--green-color);
}
.new-lead-icon1.active-filter a,.job-won-peoples-icon.active-filter a {
    color: var(--golden-border);
}
.interested-peoples-icon.active-filter a{
  color:#006BF5;
}
.shortlisted-peoples-icon.active-filter a{
  color: var(--green-color);
}
.image-blocks a,.video-blocks a {
    /* display: initial; */
    border: 1px solid rgb(237, 237, 237);
    border-bottom: 0;
    border-radius: 0!important;
    overflow: hidden;
}
.image-blocks img {
    max-width: 100%;
    object-fit: cover;
    border-radius: 0!important;

    transition: filter 0.3s ease 0s;
        height: 188px;
    width: 100%;

}

.video-blocks video {

    width: 100%;
    padding: 0;
    object-fit: cover;
    border-radius: 0!important;
    transition: transform 0.3s ease-in-out 0s, filter 0.3s ease 0s;
    height: 100%;
    max-height: 195px;
}
.video-blocks video:hover,.image-blocks img:hover{

    filter: brightness(75%);
}
.image-blocks a:not(:nth-of-type(1)) {
    display: none;
}
.video-blocks .openVideo:not(:nth-of-type(1)) {
    display: none;
}

.mfp-pager {
    width: 100%;
    position: absolute;
    z-index: 20;
    top: 0px;
    left: 0;
    right: 0;
    margin: 0 auto;
    text-align: center;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}
.mfp-pager::after { clear: both; display: block; content: ''; }
.mfp-pager li { padding: 0; margin: 0; display: inline-block; }
.mfp-pager .arrow_next,
.mfp-pager .arrow_prev { display: inline-block; }
.mfp-pager .arrow_next button,
.mfp-pager .arrow_prev button { vertical-align: middle; border: none; color: #fff;    background: transparent;font-size: 20px;}
.mfp-pager .arrow_next button:focus, .mfp-pager .arrow_prev button:focus {
    outline: 0;
}

.mfp-pager .arrow_prev button i,.mfp-pager .arrow_next button i {
    color: #fff;
}

.mfp-pager .dots {
    vertical-align: top;
    text-align: center;
    display: inline-block;
    margin: 0 8px;
    position: relative;
    padding: 0;
}
.mfp-pager .dots .dot-item {
    opacity: .8;
}
.mfp-pager .dots .dot-item.active, .mfp-pager .dots .dot-item:hover {
    opacity: 1;
}

.mfp-gallery .mfp-image-holder .mfp-figure {
    cursor: pointer;
    max-width: 1000px;
}
.mfp-figure:after {
    content: none!important;
}
.mfp-pager .dots .dot-item button {

    background-size: cover;
    background-position: center center;
    flex: 1 1 0%;
    height: 65px;
    width: 65px;
    min-height: 65px;
    box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px;
    border: 2px solid rgb(255, 255, 255);
    transition: all 250ms ease 0s;
    position: relative;
    overflow: hidden;
    cursor: pointer;
}
.mfp-pager .dots .dot-item button:focus{
    outline: 0;
}
.mfp-bg {
    opacity: .9!important;
    border-radius: 0!important;
}



.video-popup video {
    width: 100%;
    height: 100%;
}
.htmlopenvideo .mfp-content {
    max-width: 1000px;
}

.mfp-inline-holder .mfp-close{
    color: #fff!important;
    right: -6px;
    top: -40px;
    text-align: right;
    padding-right: 6px;
    width: 100%;
}
.mfp-inline-holder .mfp-close:active {
    top: -40px!important;
}

.video-blocks .openVideo:not(:nth-of-type(1)) {
    display: none;
}
button.mfp-close:focus, button.mfp-arrow:focus{
    outline: 0;
}
.video-counter {
    color: #fff;
}

@media(max-width:767.98px){
    .video-blocks,.image-blocks {
    padding-right: 0!important;
}

}


@media(max-width:480px){
    .dots-container {
    max-width: 260px;
}
.mfp-counter {

    top: 73px;
    right: 50%;

    transform: translateX(50%);
}
}
/*
  ##Device = Most of the Smartphones Mobiles (Portrait)
  ##Screen = B/w 320px to 479px
*/

@media (min-width: 320px) and (max-width: 480px) {
    .active-lead {
        position: absolute;
        z-index: 1000;
        top: -18px;
	right: -11px;
  line-height: 1.3;
    }

        .leads-detail-header.bg-white.p-3.position-relative {
        padding: 0px 5px 0px 29px!important;
    }
    .leads-table.mt-1.bg-white.p-3 {
        padding: 6px 20px!important;
    }

    .new-lead-icon1 {
        width: 100%!important;
    }
    .one-fraction-inner {

        align-content: flex-start!important;
        column-gap: 5px;
    }
        a.btn-bg-general.tooltip-show.btn-block.text-white.text-center.px-5.py-2.text-decoration-none.font-weight-bold.rounded {
        padding: 5px 0px!important;
        line-height: 23px;
    }
    p.lead-desc-first-sec-address.ft2 {
        font-size: 13px;
    }
    .one-fraction-inner.d-flex {
        display: grid!important;
        grid-template-columns: repeat(4, 1fr);
        grid-template-rows: auto;
        grid-column-gap: 10px;
        grid-row-gap: 0px;
        width: 100%;
    }
    @media(max-width:480px){
        .new-lead-icon a, .interested-peoples-icon a, .shortlisted-peoples-icon a, .job-won-peoples-icon a {
        font-size: 11px;
    }
    }
    .unread {
        display: inline-flex;
    }

    span.px-2.py-1 {
    display: inline-block!important;
    margin-top: 6px;
}
    .single-lead-posted-customer-name {
        color: #4a4a4a;

        font-size: 16px;
    }
    .mobile-modal {

        z-index: 99999;
    }
    .leads-browse-job-btn-div.my-auto {
        margin-top: 30px!important;
    }



    .hidden-div.h4.text-center {
        display: none;
    }
    .px-4 {
        padding-left: 0.2rem!important;
        padding-right: 0.2rem!important;
    }

}


@media screen and (max-width: 768px){
a#apply_btn {
    padding: 0px 0px!important;
    height: 60px;
}

.job-photos-heading.h4.my-2 span.d-block {
    font-size: 0.9rem;
    margin-top: 5px;
}
.single-lead-complete-job-description-heading {

    font-weight: 550;
    font-size: 1.1rem;
}
.mobile-onlyfl .total-result {
    display: inline-block;
}

.mobile-onlyfl .unread {
    float: right;
}
.row.mx-0.justify-content-between.mobile-onlyfl {
     padding: 5px 15px 5px 15px!important;
    background: #fff!important;
    margin-bottom: 0!important;
}
}


@media (max-width: 375px) {
img.pl-2.img-fluid {
    width: 62px;
    margin-right: 0px;
    margin-left: 0px;
    padding-right: 5px;
}

}


.position-relative.chatbx {
    float: right;
}
.position-relative.chatbx a:hover i {
    transform: scale(1.1);
}
span.px-2.py-1.new-ld {
    border: 1px solid;
    background: #fff;
    color: #d10a38;
    margin-left: 15px;
}
.single-lead-complete-description-first-section {
    margin-bottom: 20px!important;
    padding: 20px;
}
@media (min-width: 320px) and (max-width: 480px) {
    .someonestarted {
    font-size: 13px;
    width: 156px;
    line-height: 33px;
    height: 44px!important;
}
.one-fraction-inner.d-flex {
    margin-top: 5px;
    margin-bottom: 5px;
}
.navigation.container.w-nav {
    z-index: 1001;
}
}
@media(max-width:992px){
    .main_leads_container_loader_img{
        height: 100vh !important;
    }
}
@media (min-width: 320px) and (max-width: 480px) {
.someonestarted {
    font-size: 12px;
    width: 146px;
    line-height: 29px;
    height: 41px!important;
}
.express-in {
    line-height: 23px!important;
    height: auto!important;
}
}

@media screen and (max-width: 320px) {
    .someonestarted {
        font-size: 10px;
        width: 121px;
        line-height: 29px;
        height: 41px!important;
    }
}

a.lead-detail-link {

    margin: 4px 0;
    box-shadow: 0 0 3px rgba(0,0,0,.15);
}
.listings {
    position: relative;
}
@media screen and (min-width: 767px) {
    .listings {
        max-height: 820px;
        overflow-x: hidden;
        overflow-y: auto;
    }
}

.listings::-webkit-scrollbar-track {
    background-color: #EBEAEC;
}

.listings::-webkit-scrollbar-thumb {
  background: #C1C1C1;

}

.listings::-webkit-scrollbar-thumb:hover {
  background: #A8A8A8;
}
.listings::-webkit-scrollbar {
  width: 6px;

}
#loading_gif {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
}

.single-leads-list-links-wrapper {
    position: relative;
}

#loading_gif img {
    max-width: 150px;
}

.unreadlead .alert td {
    font-weight: 700;
    color: #007bff!important;
}

.unreadlead .leads-table {
    background: #f4f4f4 !important;
}

.single-lead-complete-job-description ul {
    margin: 0 0 15px;
    padding-left: 20px;
}

.single-lead-complete-job-description ul li {
    margin-bottom: 5px;
    font-size: 14px;
    color: #777;
}


.lead-detail-link .leads-table {
    border: 0;
    margin: 0;
}
.lead-detail-link:hover .leads-table {
        background-color: #eee!important;
}
.new-lead {
    border: 2px solid var(--golden-border)!important;
    color: var(--golden-border)!important;
    line-height: 1;
    display: inline-block;
    font-size: 13px;
    border-radius: 4px!important;
    font-weight: 600;
    margin-right: 4px!important;
    margin-left: 7px;
}
@media(max-width:480px){
  .new-lead{
    margin-left: 0;
    border-width: 1px!important;
  }
}
.image-blocks2 a:not(:first-child) {
    display: none;
}

/*Video Light box cSS*/
.lightbox .lb-outerContainer video {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  z-index: 9999;
  width: 100%;
  height: auto;
  opacity: 1;
  transition: opacity 300ms ease-in-out;
  border: none;
  outline: none;
}
.lightbox .lb-outerContainer video:hover, .lightbox .lb-outerContainer video:focus {
  border: none;
  outline: none;
}
.lightbox .lb-outerContainer.animating video {
  opacity: 0;
}
.lightbox .lb-container {
  position: relative;
}
.lightbox .lb-container .lb-image {
  border: none;
}

.leads-inner{
    grid-template-columns: 1fr 9fr!important;
}
.main_leads_container_image{
    position: relative;
    z-index: 1;
}
.main_leads_container_loader{
    display: grid;
    grid-gap: 10px;
    grid-template-columns: 2fr 4fr;

}
.main_leads_container_loader_img{
    width: 100%;
    background: #f0f0f5;
    height: 100%;
    position: absolute;
    z-index: 23457;
    border: 2px solid #ccc;
}
.main_leads_popup{
    top: 0px;
    bottom: 0px;
    margin: auto;
    left: 0px;
    right: 0px;
    z-index: 213456789;
    text-align: center;
    position: absolute;
    width: 100%;
    transform: translateY(20%);
    max-width: 300px;
}
.main_leads_popup h3{
    font-size: 20px;
    color: #969494;
}
.main_leads_container_loader_img img{
    width: 100%;
    max-width: 170px;
    height: 170px;
    border-radius: 52%;
    border: 2px solid #fff;
    display: block;
    object-fit: cover;
    margin: auto;
}
.main_leads_container_loader .three-fraction{
    height: auto!important;
}
@media(max-width: 768px){
    .leads-inner , .main_leads_container_loader {
        display: grid;
        grid-gap: 10px;
        grid-template-columns: 12fr !important;
    }

}
</style>

<div class="leads-wrapper py-5">
    <div class="leads-inner">
        <div class="one-fraction px-4 ">
            <div class="one-fraction-inner d-flex">
                <div class="new-lead-icon1 new-lead-icon bg-white mt-1 justify-content-center text-center py-2 px-1 shadow <?php if($leadfilter==5 || $identifyer == 'leads') echo 'active-filter'; ?>">
                    <a class="text-decoration-none ld-option " id="newleads">
                        <div class="active-lead-wrapper ">
                            <?php if($readcount > 0): ?>
                                <div class="active-lead">
                                    <span class="text-white bg-golden px-2 py-1 rounded show_counter_label"><?= (!$leadscounter)? $readcount : $leadscounter; ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <i class="fa-solid fa-magnifying-glass px-2 text-center"></i>
                        <span class="d-block pt-1">New Leads</span>
                    </a>
                </div>
                <div class="new-lead-icon1 interested-peoples-icon bg-white mt-1 justify-content-center text-center py-2 px-1 shadow <?php if($leadfilter== 0 || $identifyer == 'interested') echo 'active-filter'; ?>">
                    <a class="text-decoration-none ld-option" id="filter1">
                        <div class="active-lead-wrapper">
                            <?php if($inrestedcount > 0): ?>
                                <div class="active-lead">
                                    <span class="text-white bg-golden px-2 py-1 rounded show_counter_label"><?=$inrestedcount?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <i class="fa fa-thumbs-up"></i>
                        <span class="d-block pt-1">Interested</span>
                    </a>
                </div>
                <div class="new-lead-icon1 shortlisted-peoples-icon bg-white mt-1 justify-content-center text-center py-2 px-1 shadow <?php if($leadfilter==1 || $identifyer == 'shortlisted') echo 'active-filter'; ?>">
                    <a class="text-decoration-none ld-option" id="filter2">
                        <div class="active-lead-wrapper">
                            <?php if($shortlistedcount > 0): ?>
                                <div class="active-lead">
                                    <span class="text-white bg-golden px-2 py-1 rounded show_counter_label"><?=$shortlistedcount?></span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <i class="fa-solid fa-ranking-star"></i>
                        <span class="d-block pt-1">Shortlisted</span>
                    </a>
                </div>
                <div class="new-lead-icon1 job-won-peoples-icon bg-white mt-1 justify-content-center text-center py-2 px-1 shadow <?php if($leadfilter==2 || $identifyer == 'jobswon') echo 'active-filter'; ?>">
                    <a class="text-decoration-none ld-option" id="filter3">
                        <div class="active-lead-wrapper">
                            <?php if($jobswoncount > 0): ?>
                                <div class="active-lead">
                                    <span class="text-white bg-golden px-2 py-1 rounded show_counter_label"><?=$jobswoncount?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <i class="fa fa-trophy"></i>
                        <span class="d-block pt-1">Jobs Won</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- <div class="mobile-modal py-5 bg-white"> </div> -->
        <div class="main_leads_container_image">
            <?php if(empty($showJobs)): ?>
                <div class="main_leads_container_loader_img">
                    <div class="main_leads_popup">
                        <img src="admin/images/loading.png">
                        <h3>NO LEADS FOUND</h3>
                    </div>
                </div>
            <?php endif; ?>
            <div class="main_leads_container_loader">                
                <div id="six-fraction" class="six-fraction" style="<?php if(isset($_GET['id']) && isset($_GET['i'])) echo 'display:block;'; ?>">
                    <?php 
                        if(!isset($_GET['id']) && !isset($_GET['d']) && !isset($_GET['r']) && !isset($_GET['j']) ) {
                            $dis = $func->batchDistance($user_post_code, [$showJobs[0]['post_code']], 'mile');  
                            $posts = [
                                'job_id'        =>  $showJobs[0]['id'],
                                'distance'      =>  $dis[0],
                                'jobscount'     =>  count($showJobs),
                                'reading'       =>  'read',
                                'identifiyer'   =>  $identifyer,
                                'postcode'      =>  $showJobs[0]['post_code']    
                            ];
                        }

                        if(!$func->isMobileDevice()) include "single_lead.php"; 
                        
                        
                    ?> 
                </div>
            </div>
                    
                    <div class="three-fraction">
                        <div class="row mx-0 justify-content-between mobile-onlyfl">
                            <div class="total-result"><span class="totaljobs"><?=$countjobs?></span><span>results</span></div>
                            <div class="unread ">
                                <span class="px-2 rounded font-weight-bold show_counter" id="unreadcounter"><?=$readcount ?></span> unread | <a id="filter-jobs" href="javascript:void(0)">filter</a>
                                <div class="filter-conatiner position-absolute bg-white w-75 shadow ">
                                    <div class="filter-header text-white h3">Filter</div>
                                    <div class="filter-body p-3">
                                        <div class="filter-heading">Trades</div>
                                        <?php
                                        foreach($my_skills as $skill){
                                            $main_name=$func->SingleMainCategory($skill['main_category']);

                                            ?>
                                            <div class="form-check">
                                                <label class="form-check-label filter-label" >
                                                    <input class="form-check-input filter-input" value="<?=$skill['main_category']?>" name="category_name" type="checkbox">
                                                    <?=$main_name[0]['category_name']?>
                                                </label>
                                            </div>

                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="filter-footer d-flex justify-content-between px-3 pb-2 align-items-center">
                                        <a href="leads">Reset</a>
                                        <a class="text-decoration-none btn btn-primary text-white py-1 set-category-btn" id="setCategoryMobile">Done</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php 

                            // echo "Skills<br>";
                            // $func->dump($my_skills, false);


                            // echo "Post<br>";
                            // $func->dump($_GET['category'], false);
                        
                        ?>


                        <div class="leads-detail-header bg-white px-3 position-relative">
                            <div class="row mx-0 justify-content-between desktop-onlyfl">
                                <div class="total-result show_counter_rs"><span class="totaljobs"><?=$countjobs?></span><span>results</span></div>
                                <div class="unread ">
                                    <span class="px-1 rounded font-weight-bold show_counter"><?=$readcount ?></span> unread | <a id="filter-jobs2" href="javascript:void(0)">filter</a>
                                    <div class="filter-conatiner position-absolute bg-white w-75 shadow ">
                                        <div class="filter-header text-white h3">Filter</div>
                                        <div class="filter-body p-3">
                                            <div class="filter-heading">Trades</div>
                                            <?php
                                            foreach($my_skills as $skill){
                                                $main_name=$func->SingleMainCategory($skill['main_category']);

                                                if(isset($_GET['category'])) $isChecked = in_array($skill['main_category'], $_GET['category']) ? 'checked' : '';
                                                else $isChecked = null;                                                
                                                
                                                ?>
                                                    <div class="form-check">
                                                        <label class="form-check-label filter-label" >
                                                            <input class="form-check-input filter-input" value="<?=$skill['main_category']?>" name="category_name" type="checkbox" <?=$isChecked;?>>
                                                            <?=$main_name[0]['category_name']?>
                                                        </label>
                                                    </div>
                                                <?php
                                                
                                            }
                                            ?>


                                        </div>
                                        <div class="filter-footer d-flex justify-content-between px-3 pb-2 align-items-center">
                                            <a href="leads">Reset</a>
                                            <a class="text-decoration-none btn btn-primary text-white py-1 set-category-btn" id="setCategory">Done</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="listings">
                            <div id="listings_container">



                            <div class="single-leads-list-links-wrapper" id="leadItems">
                            <!-- Listing -->
                            <?php
                            $offset = 0;
                            $limit = 50;

                            // $func->dump($showJobs);

                            // if(isset($_GET['id']) && isset($_GET['i']) && $func->isMobileDevice() && $func->checkUrlQueryString()){

                            // }else 
                            if($showJobs){

                                for ($i = $offset ; $i < ($offset + $limit) && $i < count($showJobs) ; $i++){

                                    if ($identifyer == 'jobswon') $identifyer = 'jobswon';

                                    $main       =   $func->SingleMainCategory($showJobs[$i]['main_type']);
                                    $sub        =   $func->SingleSubCategory($showJobs[$i]['sub_type']);
                                    $options    =   $func->getSingleOptions($showJobs[$i]['options']);
                                    $user       =   $func->getuserdetails($showJobs[$i]['user_id']);
                                    $new_chat   =   $func->getAllNewChates($showJobs[$i]['user_id'],$showJobs[$i]['id']);
                                    $check_chat_exist=$func->isChatexist($showJobs[$i]['id']);
                                    $subdate    =   $showJobs[$i]['created_date'];
                                    $earlier    =   new DateTime($subdate);
                                    $later      =   new DateTime(date("Y-m-d H:i:s"));
                                    $diff       =   $later->diff($earlier)->format("%a");
                                    $isRead     =   $func->isLeadRead($showJobs[$i]['id'], $identifyer);
                                    

                                    ?>
                                    <a onclick="modalHTTP(<?=$showJobs[$i]['id']?>,<?=round($distanceOfJobs[$i],1)?>,<?=$countjobs?>,'<?=$showJobs[$i]['post_code']?>', this);openmbui();" class="lead-detail-link <?php if(!$isRead) echo "unreadlead"; if(isset($_GET['id']) && $_GET['id'] === $showJobs[$i]['id']) echo ' active'; ?>" data-jid="<?=$showJobs[$i]['id']?>" data-identity="<?= $identifyer; ?>" id="job<?=$showJobs[$i]['id']?>">
                                        <div class="single-lead ">
                                            <div class="border-wrapper">
                                                <div class="leads-table  bg-white p-3">
                                                    <table class="leads-table-inner">
                                                        <?php if( isset($_GET['filter']) && (!empty($check_chat_exist))){ ?>

                                                            <div class="position-relative chatbx">
                                                                <a href="chat?touserid=<?=$showJobs[$i]['user_id']?>&jobid=<?=$showJobs[$i]['id']?>" >
                                                                    <i class="fa-solid fa-envelope fa-2xl"></i>
                                                                </a>
                                                                <?php if( isset($_GET['filter']) && count($new_chat)>0 ){ ?>
                                                                    <span   style="top: -6px;
                                                                            right: -4px;
                                                                            font-size: 10px;
                                                                            color: #fff;
                                                                            min-width: 14px;
                                                                            min-height: 14px;
                                                                            text-align: center;
                                                                            line-height: 14px;
                                                                            border-radius: 25px!important;"
                                                                            class="bg-danger position-absolute rounded-circle px-1"><?= count($new_chat)?>
                                                                    </span>
                                                                <?php } ?>

                                                            </div>

                                                        <?php  } ?>

                                                        <tr class="alert">
                                                            <td><i class="fas fa-bolt px-2 text-center"></i></td>
                                                            <td>
                                                                <?=$showJobs[$i]['title']?> <?php if($diff==0){
                                                                    $houre = $later->diff($earlier);
                                                                    $houres=$houre->h;
                                                                    if($houres == 0){
                                                                        $time.="";
                                                                    }else{
                                                                        $time.="";
                                                                    }
                                                                    if($houres<=12){
                                                                        $new_leades='<span class="px-2 py-1 new-ld"> New lead</span>';
                                                                    }
                                                                } ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fas fa-tools px-2 text-center"></i></td>
                                                            <td><?=$main[0]['category_name']?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fas fa-map-marker-alt px-2"></i></td>
                                                            <td><?=$func->getCityName($showJobs[$i]['post_code']) .", ".strtoupper($func->breakPostalCode($showJobs[$i]['post_code']))?><span class="grayed">&nbsp; | &nbsp;<?php $distance = round($distanceOfJobs[$i], 1); if ($distance > 1) { echo $distance . ' miles'; } else { echo $distance . ' mile';}?></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fas fa-calendar-alt px-2 text-center"></i></td>
                                                            <td class="grayed">
                                                                <?php
                                                                if($diff==0){
                                                                    $houre = $later->diff($earlier);
                                                                    echo $func->formatPostedTime($houre->h);

                                                                }else{
                                                                    echo $func->formatPostedDay($diff);
                                                                }

                                                                ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <?php
                                                        if(isset($_GET['id']) && $_GET['id'] === $showJobs[$i]['id']){
                                                            echo '<div class="openLead"><i class="fa fa-envelope-open-o" aria-hidden="true"></i></div>';
                                                        }elseif($showJobs[$i] == 0) {
                                                            echo '<div class="openLead"><i class="fa fa-envelope-open-o" aria-hidden="true"></i></div>';
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </a>

                                    <?php }  }?>

                            </div>



                            </div>
                            <div id="loading_gif" style="display: none;">
                                <img src="images/spinning.svg" alt="Loading..." />
                            </div>
                        </div>

                        <div id="load-more">
                            <!-- <img src="images/spinning.svg" alt="Spinning"> -->
                        </div>
                    </div>

                    

                    
            </div>
        </div>

        <div class="mobile-modal-wrapper bg-white">
            <div id="my-mobile-modal" class="mobile-modal"></div>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Apply for this lead</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="apply_job">
                    <input type="hidden" id="job_id1" value="">
                    <input type="hidden" id="job_location" value="">
                    <div class="modal-body form-group">
                        <textarea id="message" cols="" rows="4" class="form-control-lg form-control" placeholder="Your message to the customer.">

                        </textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="send_applcation" class="btn btn-primary">Send message</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="jobcountnm" name="jobcountnm" value="<?=$countjobs?>">
<?php include_once "includes/footer-no-cta.php"?>
<script>
    document.getElementById("message").innerHTML = document.getElementById("message").innerHTML.trim();
</script>
<script>

    const   limit           =   50,
            queryString     =   window.location.search,
            urlParams       =   new URLSearchParams(queryString);
    let     offset          =   0,
            cat             =   [],
            loading         =   false;
            loadoffset      =   0,
            loadmore        =   <?php if(count($showJobs) > 50):?> true <?php else: ?> false<?php endif;?>,
            clickleads      =   false,
            catleads        =   false,
            clickcounter    =   0,
            
            protocol    = window.location.protocol,
            host        = window.location.hostname,
            port        = window.location.port ? ':' + window.location.port : '',
            baseUrl     = protocol + '//' + host + port,
            baseURL     = baseUrl + '/leads';



    cat.push(urlParams.get("category"));
    if (urlParams.has("category")) {
        cat[0].split(",").forEach((item, index) => {
            $(":checkbox[value=" + item + "]").prop("checked", "true");
        });
    }

    function applyFilter(filter, clickedElement, loadingcheck='') {
        clickleads  = true;
        catleads    = false;
        $("#listings_container a").remove();

        loadListings(filter, clickedElement, [], null, 'filter', loadingcheck);

    }
    function loadNewLeads (clickedElement) {
        clickleads  = true;
        catleads    = false;
        $("#listings_container a").remove();

        loadListings(null, clickedElement, [], offset);

    }


    function setActiveFilter(clickedElement, count = null) {
        // $(clickedElement).closest(".new-lead-icon1").addClass("active-filter");
        let wrapper = $(clickedElement).find('.active-lead-wrapper');
        let active = $(clickedElement).find('.active-lead');

        if (active.length === 0) {
            wrapper.html('<div class="active-lead"><span class="text-white bg-golden px-2 py-1 rounded show_counter_label">'+ count +'</span></div>');
        }

        $("#jobcountnm").trigger("change");
    }

    jQuery(window).on("load", function(){    
        var windowWidth = $(window).width();       
        if (windowWidth > 992) {
        //    $("#listings_container .single-leads-list-links-wrapper a:first-child").trigger("click");
        }

    //  setTimeout(function() {   
    //     jQuery('.main_leads_container_loader_img').hide();
    //  }, 2000);
    });

    <?php

    if(!isset($_GET['id']) && !isset($_GET['d']) && !isset($_GET['r']) && !isset($_GET['j']) ) {
        
        $dis = $func->batchDistance($user_post_code, [$showJobs[0]['post_code']], 'mile');  

        $parameters = [
            'job_id'        =>  $showJobs[0]['id'],
            'distance'      =>  $dis[0],
            'jobscount'     =>  count($showJobs),
            'reading'       =>  'read',
            'identifiyer'   =>  $identifyer,
            'postcode'      =>  $showJobs[0]['post_code']    
        ];

        ?>
            $(document).ready(function(){   

                var protocol    = window.location.protocol;
                var host        = window.location.hostname;
                var port        = window.location.port ? ':' + window.location.port : '';
                var baseUrl     = protocol + '//' + host + port;
                var baseURL     = baseUrl + '/leads';
                var url         = baseURL + "?id=<?= $parameters['job_id'] ?>&d=<?= $parameters['distance'] ?>&r=<?= $parameters['reading'] ?>&j=<?= $parameters['jobscount'] ?>&i=<?= $parameters['identifiyer'] ?>&p=<?= $parameters['postcode'] ?>";

                <?php if($parameters['job_id']): ?>

                    history.pushState({
                        id: <?= $parameters['job_id'] ?>,
                        d: <?= $parameters['distance'] ?>,
                        r: '<?= $parameters['reading'] ?>',
                        j: <?= $parameters['jobscount'] ?>,
                        i: '<?= $parameters['identifiyer'] ?>',
                        p: '<?= $posts['postcode'] ?>',
                    }, null, url);

                <?php endif; ?>

            });

        <?php 
    }
    ?>

    $(document).on('click', '#newleads', function(){        
        let url = baseURL+'?leadfilter=5';
        window.location = url;
        
        // loadNewLeads($(this));
        // loadmore    =  true;
        // loadoffset  =  0;
    });
    $(document).on('click', '#filter1', function(){
        let url = baseURL+'?leadfilter=0';
        window.location = url;

        // applyFilter('0', $(this));
        // loadmore    =  true;
        // loadoffset  =  0;
    });
    $(document).on('click', '#filter2', function(){
        let url = baseURL+'?leadfilter=1';
        window.location = url;

        // applyFilter('1', $(this));
        // loadmore    =  true;
        // loadoffset  =  0;
    });
    $(document).on('click', '#filter3', function(){
        let url = baseURL+'?leadfilter=2';
        window.location = url;


        // applyFilter('2', $(this));
        // loadmore    =  true;
        // loadoffset  =  0;
    });

    $(document).on('click', "#setCategory", function (e) {
        e.preventDefault();

        // clickleads      = false;
        // catleads        = true;
        // loadmore        = true;
        // loadoffset      = 0;

        // var category = [];
        // $('input[name="category_name"]:checked').each(function () {
        //     category.push(this.value);
        // });

        // var categoryQueryString = category.join('&category[]=');
        // let url = baseURL + '?category[]=' + categoryQueryString;

        // console.log(url);

        // window.location = url;

        // loadListings("", null, category);

    });


    function loadListings(filter = null, clickedElement = null, category = [], offset = 0, identifier = 'normal', loadingcheck = '') {

        if (loading) {
            return;
        }


        // $("#loading_gif").show();

        // setTextAnimation(0.1,2.8,2,'linear','#3115bc',true);

        let requestData = {};

        if (filter !== null) {
            requestData.filter = filter;
        }

        if (category.length > 0) {
            requestData.category = category;
        }

        if(loadingcheck === 'loadmore'){
            loadoffset = loadoffset + limit;
            requestData.offset = loadoffset;
        } else {
            requestData.offset = offset;
        }

        requestData.ajaxid = 1;

        loading = true;

        $.ajax({
            url: "ajaxlisting.php",
            type: "GET",
            data: requestData,
            dataType: "html",
            success: function (response) {
                let data = JSON.parse(response);
                loadmore = data.morejobs;
                $("#loading_gif").hide();
                loading = false;

                // console.log(data);

                if (loadoffset > 0) {
                    $("#listings_container").append(data.html);
                } else {
                    $("#listings_container").html(data.html);
                }

                if(identifier === 'filter'){
                    if (loadoffset > 0) {
                        $("#listings_container").append(data.html);
                    } else {
                        $("#listings_container").html(data.html);
                    }
                }
                if(identifier === 'normal'){
                    if (loadoffset > 0) {
                        $("#listings_container").append(data.html);
                    } else {
                        $("#listings_container").html(data.html);
                    }
                }


                if (clickedElement) {
                    setActiveFilter(clickedElement);
                }

                if(loadingcheck != 'loadmore'){
                    $(".show_counter").html(parseInt(data.unread));
                    if(clickedElement){
                        if(data.unread < 1) {
                            $(clickedElement).find('.active-lead').remove()
                        }else{
                            $(clickedElement).find('.show_counter_label').text(parseInt(data.unread));
                        }
                    }else {
                        $(".show_counter_label").text(parseInt(data.unread));
                    }
                    $(".totaljobs").text(parseInt(data.counter));
                }


                $("#jobcountnm").val(parseInt(data.counter));
            },

            error: function () {
                $("#loading_gif").hide();
                loading = false;

                swal("Failed to load! ", "Failed to load listings. Please try again later.", "error");
            },
        });
    }



    $(document).on('click', "#load-more", function () {

        let homelead    =   $('.new-lead-icon1').find('#newleads');
            homelead    =   homelead.parent();

        if(clickleads === false && catleads === false && loadmore === true){
            loadListings(null, homelead, [], offset, 'normal', 'loadmore');
        }

        if(clickleads === true && loadmore === true){
            let filter      =   $('.active-filter'),
                filterid    =   filter.find('a').attr('id');


                if(filterid === 'newleads'){
                    // loadListings(null, homelead, [], offset,'normal', 'loadmore');
                }
                if(filterid === 'filter1'){
                    applyFilter('0', filter, 'loadmore')
                }
                if(filterid === 'filter2'){
                    applyFilter('1', filter, 'loadmore')
                }
                if(filterid === 'filter3'){
                    applyFilter('2', filter, 'loadmore')
                }
        }

        if(catleads === true && loadmore === true){
            var loadcats = [];
            $('input[name="category_name"]:checked').each(function () {
                loadcats.push(this.value);
            });
            // loadListings("", homelead, loadcats, offset, 'normal', 'loadmore');
        }
    });


    $(document).ready(function () {
        $(".single-lead").click(function () {
            $("body").addClass("modal-open");
        });
    });


    $(document).on('change', "#jobcountnm", function () {
        // Get the current job count
        var jobCount = parseInt($(this).val());
        // If all jobs have been loaded, hide the "Load More" button
        if (offset >= jobCount) {
            $("#load-more").hide();
        } else {
            // Otherwise, show the "Load More" button
            $("#load-more").show();
        }
    });

    $(document).on('click', ".ld-option", function () {
        $("#jobcountnm").trigger("change");
    });


    let lastScrollPosition = 0;

    function handleScroll() {
        const currentScrollPosition = $(window).scrollTop();
        const windowHeight = $(window).height();
        const documentHeight = $(document).height();

        if (currentScrollPosition > lastScrollPosition && currentScrollPosition + windowHeight > documentHeight - 1200) {
            $('#load-more').trigger('click');
        }

        lastScrollPosition = currentScrollPosition;
    }

    $(window).scroll(handleScroll);
    $('.listings').scroll(handleScroll);




    

    $('.image-blocks').magnificPopup({
        delegate: 'a',
        type: 'image',
        tLoading: 'Loading image #%curr%...',
        mainClass: 'mfp-img-mobile',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0,1] 
        },
        image: {
            tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
            titleSrc: function(item) {
                var $gallery = $('.image-blocks');
                var $result = '';
                if ($gallery.find('a').length > 0) {
                    var numThumbs = $gallery.find('a').length; // Get the total number of thumbs
                    var numVisibleThumbs = 4; // Set the number of initially visible thumbs
                    var startThumbIndex = Math.floor(item.index / numVisibleThumbs) * numVisibleThumbs; // Calculate the start index of the visible thumbs

                    $result = '<div class="mfp-pager">' + 
                        '<div class="arrow_prev">' +
                            '<button type="button" class="prev arrow" onclick="javascript:$(\'.image-blocks\').magnificPopup(\'prev\');return false;"><i class="fa-solid fa-angle-left"></i></button>' +
                        '</div>' + 
                        '<div class="dots">' +
                        '<div class="dots-container" style="display: flex; overflow-x: auto;">';

                    for (var i = startThumbIndex; i < startThumbIndex + numVisibleThumbs && i < numThumbs; i++) {
                        var $cl_active = '';
                        if (item.index == i) $cl_active = ' active';
                        var $thumb = $gallery.find('a:eq('+i+')').find('img').attr('src');
                        $result += '<div class="dot-item' + $cl_active + '">' + '<button type="button" onclick="javascript:$(\'.image-blocks\').magnificPopup(\'goTo\', '+i+');return false;"><img src="' + $thumb + '" width="50"></button>' + '</div>';
                    }
                    $result += '</div>' + '</div>';

                    if (numThumbs > numVisibleThumbs) {
                        $result += '<div class="arrow_next">' + '<button type="button" class="next arrow" onclick="javascript:$(\'.image-blocks\').magnificPopup(\'next\');return false;"><i class="fa-solid fa-angle-right"></i></button>' + '</div>';
                    }

                    $result += '</div>';
                }

                return $result;
            }
        }
    });


    $('.openVideo').magnificPopup({

        type: 'inline',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0,1]
        },

        callbacks: {
            open: function() {
                $('html').css('margin-right', 0);
                $('html').addClass('htmlopenvideo');

                // Play video on open:
                $(this.content).find('video')[0].play();

            },
            close: function() {

                // Reset video on close:
                $(this.content).find('video')[0].load();

            }
        } 
    });



    /*---------------------------------------------------
                        My Functions
    -----------------------------------------------------*/
    let checkRunning = false;

    function counterCheck(){

        if(checkRunning == true) return;
        checkRunning = true;

        let requestData  = {
            ajaxid: 2
        }
        $.ajax({
            url: "ajaxlisting.php",
            type: "GET",
            data: requestData,
            dataType: "html",
            success: function (response) {
                    let data = JSON.parse(response);
                    checkRunning = false;

                    if(fixingUnread() === 'newleads') $('#unreadcounter').text(data.leads_count);
                    if(fixingUnread() === 'interested') $('#unreadcounter').text(data.interested_count);
                    if(fixingUnread() === 'shortlisted') $('#unreadcounter').text(data.shortlisted_count);
                    if(fixingUnread() === 'jobswon') $('#unreadcounter').text(data.jobswon_count);

                    if(data.leads_count != undefined){

                        let leads = document.querySelector('#newleads');
                        if(data.leads_count > 0){
                            $(leads).find('.active-lead').remove();
                            setActiveFilter(leads, data.leads_count);
                        }else {
                            $(leads).find('.active-lead').remove();
                        }

                    }
                    
                    if (data.interested_count != undefined) {

                        let interested = document.querySelector('#filter1');

                        if(data.interested_count > 0){
                            $(interested).find('.active-lead').remove();
                            setActiveFilter(interested, data.interested_count);
                        }else {
                            $(interested).find('.active-lead').remove();
                        }

                    }
                    
                    if (data.shortlisted_count != undefined) {

                        let shortlisted = document.querySelector('#filter2');
                        if(data.shortlisted_count > 0){
                            $(shortlisted).find('.active-lead').remove();
                            setActiveFilter(shortlisted, data.shortlisted_count);
                        }else {
                            $(shortlisted).find('.active-lead').remove();
                        }

                    }
                    
                    if (data.jobswon_count != undefined) {
                        let jobswon = document.querySelector('#filter3');

                        if(data.jobswon_count > 0){
                            $(jobswon).find('.active-lead').remove();
                            setActiveFilter(jobswon, data.jobswon_count);
                        }else {
                            $(jobswon).find('.active-lead').remove();
                        }

                    }


            },

            error: function () {
                $("#loading_gif").hide();
                checkRunning = false;

                // swal("Failed to load! ", "Failed to load listings. Please try again later.", "error");
            },
        });
    }

    function fixingUnread(){
        var parentDiv = $('.one-fraction-inner');
        var activeChildId = null;
        parentDiv.children().each(function() {
            var childElement = $(this);
            if (childElement.hasClass('active-filter') || childElement.find('.active-filter').length > 0) {

                activeChildId = childElement.find('a').attr('id');

                if(activeChildId === 'filter1') activeChildId = 'interested';
                else if(activeChildId === 'filter2') activeChildId = 'shortlisted';
                else if(activeChildId === 'filter3') activeChildId = 'jobswon';

                return false;                
            }
        });
        return activeChildId;
    }

    let intervalID = setInterval(counterCheck, 1000);



    $(document).ready(function () {



        // Get the value of the hidden input
        var jobCountValue = $("#jobcountnm").val();
        $("#jobcountnm").trigger("change");

        $("#filter-jobs").click(function (e) {
            $(".filter-conatiner").toggle();
            e.preventDefault();
            e.stopPropagation();
        });
        $(".filter-conatiner").click(function (e) {
            e.stopPropagation();
        });
        $(document).click(function () {
            $(".filter-conatiner").hide();
        });

        $("#filter-jobs2").click(function (e) {
            $(".filter-conatiner").toggle();
            e.preventDefault();
            e.stopPropagation();
        });
        $(".filter-conatiner").click(function (e) {
            e.stopPropagation();
        });
        $(document).click(function () {
            $(".filter-conatiner").hide();
        });

        $(".set-category-btn").click(function (e) {
            e.preventDefault();

            var category = [];
            $('input[name="category_name"]:checked').each(function () {
                category.push(this.value);
            });
            
            var categoryQueryString = category.join('&category[]=');
            let url = baseURL + '?&category[]=' + categoryQueryString;
            if(category.length < 1 ){
                window.location = baseURL;
            }else {
                $(".filter-conatiner").hide();
                window.location = url;
            }
            // loadListings("", null, category);
        });

        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var cat = [];
        cat.push(urlParams.get("category"));
        if (urlParams.has("category")) {
            cat[0].split(",").forEach((item, index) => {
                $(":checkbox[value=" + item + "]").prop("checked", "true");
            });
        }

        $("#jobcountnm").on("change", function () {
            // Get the current job count
            var jobCount = parseInt($(this).val());

            // If all jobs have been loaded, hide the "Load More" button
            if (offset + limit >= jobCount) {
                $("#load-more").hide();
            } else {
                // Otherwise, show the "Load More" button
                $("#load-more").show();
            }
        });

        $(".ld-option").on("click", function () {
            // Trigger the change event
            $("#jobcountnm").trigger("change");
        });


        
        // Scroll to the clicked item on leads page
        // const lastClickedItemId = localStorage.getItem("lastClickedItem");
        // if (lastClickedItemId) {
        //     const lastClickedItem = $("#" + lastClickedItemId);
        //     if (lastClickedItem.length) {
        //         const container = $("#leadItems");
        //         const scrollTo = lastClickedItem.offset().left - container.offset().left + container.scrollLeft();
        //         container.animate({ scrollLeft: scrollTo }, 1000);
        //     }
        // }

    });

</script>

<style>
    .swal-overlay {
        z-index: 900009;
    }
    
    .lightbox {
        width: 100%;
        z-index: 999998;
        font-weight: 400;
        outline: 0;
    }
    .lightboxOverlay {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 999998;
        background-color: #000;
        filter: alpha(Opacity=80);
        opacity: .8;
        display: none;
    }
    button#load-more {
        margin-bottom: 20px;
        margin-top: 10px;
        background: #006bf5;
        color: #fff;
        padding: 8px 10px;
    }
    


    .sticky-bottom-btn {
        background-color: #fff;
        padding: 10px;
        border-radius: 0!important;
        position: sticky;
        bottom: 0;
        margin-left: -1.5rem;
        margin-right: -1.5rem;

        margin-bottom: -10px;
        box-shadow: 0px 0px 6px 2px rgba(0,0,0,.1) !important;

    }
    .sticky-bottom-btn a#apply_btn {
        height: auto;
        padding: 5px!important;
    }

    
    .grayed {
        color: #978c8c;
    }

    @media(max-width:767.98px){
        .sticky-bottom-btn {
        margin-top: auto;
    }
    .six-fraction-inner,.single-lead-complete-description{
        height: 100%;
    }
    .single-lead-complete-job-description {
        /*height: 100%;*/
        display: flex;
        flex-direction: column;
    }
    .single-lead-complete-description {
        display: flex;
        flex-direction: column;
    }
    }
    .fa-envelope{
        font-size: 24px;
        padding-top: 10px;
        color: #2d7af1;
    }
    .lead-detail-link.active {
        border: 0.1rem solid #1861D1;
    }
</style>

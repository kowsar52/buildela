<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="css/style.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="css/leads.css?v=<?php echo time(); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
<?php

require_once "serverside/functions.php";
require_once "serverside/api/functions.php";
include_once "serverside/session.php";
include_once "includes/header.php";
date_default_timezone_set('Europe/London');
error_reporting(0);
$func           =   new Functions();

if(!$func->checkSubscription()){
    echo "<script>window.location.href='trademember-my-account';</script>";
    exit;
}
if($_SESSION['user_role']=='home_owner')  echo '<script type="text/javascript">window.location.href="my-posted-jobs"; </script>';

$userInfo       =   $func->UserInfo($_SESSION['user_id']);
$skills         =   $func->getMySkills($_SESSION['user_id']);
$func->setlastSeen($_SESSION['user_id']);

$checkapproval  =   $func->checkMyapprove($_SESSION['user_id']);
$checkdocs      =   $func->checkUsergasorele($_SESSION['user_id']);
$user           =   $func->UserInfo($_SESSION['user_id']);
$subscription_id=   $user[0]['stripe_subscription_id'];
$$userpostcode  =   $userInfo[0]['post_code'];



//  Setting for leads page --------------------------------------------
$leadfilter  = isset($_GET['leadfilter'])? $_GET['leadfilter'] : false;

switch ($leadfilter) {
    case 'interested':
        $jobs = $func->fetchleads('interested', true);
        $leads = $jobs['jobs'];
        $counts = $jobs['counts'];
        $total = $counts['interested']['total'];
        $unread = $counts['interested']['unread'];
        $posts['identifiyer']   =  'interested';
        $identifier = 'interested';
        break;
    case 'shortlisted':
        $jobs = $func->fetchleads('shortlisted', true);
        $leads = $jobs['jobs'];
        $counts = $jobs['counts'];
        $total = $counts['shortlisted']['total'];
        $unread = $counts['shortlisted']['unread'];
        $posts['identifiyer']   =  'shortlisted';
        $identifier = 'shortlisted';
        break;
    case 'jobswon':
        $jobs = $func->fetchleads('hired', true);
        $leads = $jobs['jobs'];
        $counts = $jobs['counts'];
        $total = $counts['hired']['total'];
        $unread = $counts['hired']['unread'];
        $posts['identifiyer']   =  'jobswon';
        $identifier = 'jobswon';
        break;
    case 'leads':
        $jobs = $func->fetchleads('leads', true);
        $leads = $jobs['jobs'];
        $counts = $jobs['counts'];
        $total = $counts['leads']['total'];
        $unread = $counts['leads']['unread'];
        $posts['identifiyer']   =  'leads';
        $identifier = 'leads';
        break;
    case false:
        $jobs = $func->fetchleads('leads', true);
        $leads = $jobs['jobs'];
        $counts = $jobs['counts'];
        $total = $counts['leads']['total'];
        $unread = $counts['leads']['unread'];
        $posts['identifiyer']   =  'leads';
        $identifier = 'leads';
        break;
}


if(isset($_GET['category'])){
    $categories = array_map('htmlspecialchars', $func->sanitizeInput($_GET['category']));
    $jobs = $func->fetchleads('filter', true, $categories);
    $leads = $jobs['jobs'];
    $counts = $jobs['counts'];
    $total = $counts['filter']['total'];
    $unread = $counts['filter']['unread'];
}

// $func->dump($jobs['counts'], false);


// Settings when it is single lead open--------------------------------
if(isset($_GET['id']) && isset($_GET['r']) && isset($_GET['j']) ) {
    $datas = $func->sanitizeInput($_GET);
    $posts = [
        'job_id'        =>  $datas['id'],
        'jobscount'     =>  $datas['j'],
        'reading'       =>  $datas['r'],
        'identifiyer'   =>  $datas['i'],       
        'postcode'      =>  $datas['p']       
    ];
                     
    $jobid              =   $posts['job_id'];
    $reading            =   $posts['reading'];
    $identifiyer        =   $posts['identifiyer'];
    $jobscount          =   $posts['jobscount'];

    $reaading           =   $datas['r'];
    $indentity          =   $datas['i'];
    $incomingjobscount  =   $datas['j'];

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

    

}



// $func->dump($identifier);


if(isset($_GET['id']) && isset($_GET['i']) ){
    if($func->isMobileDevice() && $func->checkUrlQueryString()){?>
    <div id="my-mobile-modal" class="mobile-modal" style="width: 100%;">
        <?php require_once "includes/single_lead_mobile.php"; ?>
    </div>
<?php 
}  

} 



//    if user hava no skills
if (isset($checkdocs[0]) && count($checkapproval[0]['status']) == 0 && count($skills)==0) {
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


if(count($skills)==0){ ?>
    <script type="text/javascript">
        $(document).ready(function (){
            swal("", "Take a quiz in your chosen trades, to start receiving leads in your area", "info").then((value) => {
                window.location.href="my-profile";
            });
        });

    </script>
    <?php
    exit();
} ?>

<script>
    function modalHTTP(id,distance,total, postcode, clickedelement=null){

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
        var url         = baseURL + '?id=' + id + '&d=' + distance + '&r=' + readingStatus + '&j=' + total + '&i=' + identifyer + '&p='+ postcode + '#job'+id;

        localStorage.setItem("lastClickedItem", $(clickedelement).attr("data-jid"));
        window.location = url;


    }
</script>

<div class="leads-wrapper py-5">
    <div class="leads-inner">
        <div class="one-fraction px-4 ">
            <div class="one-fraction-inner d-flex">
                <div class="new-lead-icon1 new-lead-icon bg-white mt-1 justify-content-center text-center py-2 px-1 shadow <?php if($leadfilter=='leads' || $identifier == 'leads') echo 'active-filter'; ?>">
                    <a class="text-decoration-none ld-option " id="newleads">
                        <div class="active-lead-wrapper ">
                            <?php if($counts['leads']['unread'] > 0): ?>
                                <div class="active-lead">
                                    <span class="text-white bg-golden px-2 py-1 rounded show_counter_label"><?= $counts['leads']['unread']; ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <i class="fa-solid fa-magnifying-glass px-2 text-center"></i>
                        <span class="d-block pt-1">New Leads</span>
                    </a>
                </div>
                <div class="new-lead-icon1 interested-peoples-icon bg-white mt-1 justify-content-center text-center py-2 px-1 shadow <?php if($leadfilter== 'interested' || $identifier == 'interested') echo 'active-filter'; ?>">
                    <a class="text-decoration-none ld-option" id="filter1">
                        <div class="active-lead-wrapper">
                            <?php if($counts['interested']['unread'] > 0): ?>
                                <div class="active-lead">
                                    <span class="text-white bg-golden px-2 py-1 rounded show_counter_label"><?=$counts['interested']['unread']?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <i class="fa fa-thumbs-up"></i>
                        <span class="d-block pt-1">Interested</span>
                    </a>
                </div>
                <div class="new-lead-icon1 shortlisted-peoples-icon bg-white mt-1 justify-content-center text-center py-2 px-1 shadow <?php if($leadfilter=='shortlisted' || $identifier == 'shortlisted') echo 'active-filter'; ?>">
                    <a class="text-decoration-none ld-option" id="filter2">
                        <div class="active-lead-wrapper">
                            <?php if($counts['shortlisted']['unread'] > 0): ?>
                                <div class="active-lead">
                                    <span class="text-white bg-golden px-2 py-1 rounded show_counter_label"><?=$counts['shortlisted']['unread']?></span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <i class="fa-solid fa-ranking-star"></i>
                        <span class="d-block pt-1">Shortlisted</span>
                    </a>
                </div>
                <div class="new-lead-icon1 job-won-peoples-icon bg-white mt-1 justify-content-center text-center py-2 px-1 shadow <?php if($leadfilter=='jobswon' || $identifier == 'jobswon') echo 'active-filter'; ?>">
                    <a class="text-decoration-none ld-option" id="filter3">
                        <div class="active-lead-wrapper">
                            <?php if($counts['hired']['unread'] > 0): ?>
                                <div class="active-lead">
                                    <span class="text-white bg-golden px-2 py-1 rounded show_counter_label"><?=$counts['hired']['unread']?></span>
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
            <?php if(empty($leads)): ?>
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
                            $dis = $func->batchDistance($$userpostcode, [$leads[0]['post_code']], 'mile');  
                            $posts = [
                                'job_id'        =>  $leads[0]['id'],
                                'jobscount'     =>  count($leads),
                                'reading'       =>  'read',
                                'identifiyer'   =>  $identifier,
                                'postcode'      =>  $leads[0]['post_code']    
                            ];
                        }

                        if(!$func->isMobileDevice()) include "single_lead.php"; 
                        
                        
                    ?> 
                </div>
            </div>
                    
                    <div class="three-fraction">
                        <div class="row mx-0 justify-content-between mobile-onlyfl">
                            <div class="total-result"><span class="totaljobs"><?=$total?></span><span>results</span></div>
                            <div class="unread ">
                                <span class="px-2 rounded font-weight-bold show_counter" id="ununreader"><?=$unread ?></span> unread | <a id="filter-jobs" href="javascript:void(0)">filter</a>
                                <div class="filter-conatiner position-absolute bg-white w-75 shadow ">
                                    <div class="filter-header text-white h3">Filter</div>
                                    <div class="filter-body p-3">
                                        <div class="filter-heading">Trades</div>
                                        <?php
                                        foreach($skills as $skill){
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


                        <div class="leads-detail-header bg-white px-3 position-relative">
                            <div class="row mx-0 justify-content-between desktop-onlyfl">
                                <div class="total-result show_counter_rs"><span class="totaljobs"><?=$total?></span><span>results</span></div>
                                <div class="unread ">
                                    <span class="px-1 rounded font-weight-bold show_counter"><?=$unread ?></span> unread | <a id="filter-jobs2" href="javascript:void(0)">filter</a>
                                    <div class="filter-conatiner position-absolute bg-white w-75 shadow ">
                                        <div class="filter-header text-white h3">Filter</div>
                                        <div class="filter-body p-3">
                                            <div class="filter-heading">Trades</div>
                                            <?php
                                            foreach($skills as $skill){
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
                            $limit = 30;

                            
                            if($leads){

                                for ($i = $offset ; $i < ($offset + $limit) && $i < count($leads) ; $i++){

                                    if ($identifyer == 'jobswon') $identifyer = 'jobswon';

                                    $main       =   $func->SingleMainCategory($leads[$i]['main_type']);
                                    $sub        =   $func->SingleSubCategory($leads[$i]['sub_type']);
                                    $options    =   $func->getSingleOptions($leads[$i]['options']);
                                    $user       =   $func->getuserdetails($leads[$i]['user_id']);
                                    $new_chat   =   $func->getAllNewChates($leads[$i]['user_id'],$leads[$i]['id']);
                                    $check_chat_exist=$func->isChatexist($leads[$i]['id']);
                                    $subdate    =   $leads[$i]['created_date'];
                                    $earlier    =   new DateTime($subdate);
                                    $later      =   new DateTime(date("Y-m-d H:i:s"));
                                    $diff       =   $later->diff($earlier)->format("%a");
                                    $isRead     =   ($leads[$i]['read_lead']);

                                    // $func->dump($leads[$i]["read_lead"], false);
                                    
                                    

                                    ?>
                                    <a onclick="modalHTTP(<?=$leads[$i]['id']?>,<?=round($distanceOfJobs[$i],1)?>,<?=$total?>,'<?=$leads[$i]['post_code']?>', this);openmbui();" class="lead-detail-link <?php if(!$isRead) echo "unreadlead"; if(isset($_GET['id']) && $_GET['id'] === $leads[$i]['id']) echo ' active'; ?>" data-jid="<?=$leads[$i]['id']?>" data-identity="<?= $identifier; ?>" id="job<?=$leads[$i]['id']?>">
                                        <div class="single-lead ">
                                            <div class="border-wrapper">
                                                <div class="leads-table  bg-white p-3">
                                                    <table class="leads-table-inner">
                                                        <?php if( isset($_GET['filter']) && (!empty($check_chat_exist))){ ?>

                                                            <div class="position-relative chatbx">
                                                                <a href="chat?touserid=<?=$leads[$i]['user_id']?>&jobid=<?=$leads[$i]['id']?>" >
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
                                                                <?=$leads[$i]['title']?> <?php if($diff==0){
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
                                                            <td><?=$leads[$i]['category_name']?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fas fa-map-marker-alt px-2"></i></td>
                                                            <td><?=$leads[$i]['location'] .", ".strtoupper($func->breakPostalCode($leads[$i]['post_code']))?><span class="grayed">&nbsp; | &nbsp;<?php $distance = round($distanceOfJobs[$i], 1); if ($distance > 1) { echo $distance . ' miles'; } else { echo $distance . ' mile';}?></span></td>
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
                                                        if(isset($_GET['id']) && $_GET['id'] === $leads[$i]['id']){
                                                            echo '<div class="openLead"><i class="fa fa-envelope-open-o" aria-hidden="true"></i></div>';
                                                        }elseif($leads[$i] == 0) {
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
<input type="hidden" id="jobcountnm" name="jobcountnm" value="<?=$total?>">
<?php include_once "includes/footer-no-cta.php"?>
<script>

document.getElementById("message").innerHTML = document.getElementById("message").innerHTML.trim();
    
    /*------------------------------------------------------
                 Open Leads using a modal function
    -------------------------------------------------------*/

    var job_ids = [];

    function _openModal(id,distance,total, clickedelement=null){

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
                jobscount: total,
                identifyer: identifyer
            },
            success: function (data) {

                var protocol    = window.location.protocol;
                var host        = window.location.hostname;
                var port        = window.location.port ? ':' + window.location.port : '';
                var baseUrl     = protocol + '//' + host + port;
                var baseURL     = baseUrl + '/leads';
                var url         = baseURL + '?id=' + id + '&d=' + distance + '&r=' + readingStatus + '&j=' + total + '&i=' + identifyer;

                history.pushState({
                    id: id,
                    d: distance,
                    r: readingStatus,
                    j: total,
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
                jobscount: total,
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
    

    const   limit           =   50,
            queryString     =   window.location.search,
            urlParams       =   new URLSearchParams(queryString);
    let     offset          =   0,
            cat             =   [],
            loading         =   false;
            loadoffset      =   0,
            loadmore        =   <?php if(count($leads) > 50):?> true <?php else: ?> false<?php endif;?>,
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
        let wrapper = $(clickedElement).find('.active-lead-wrapper');
        let active = $(clickedElement).find('.active-lead');
        if (active.length === 0) {
            wrapper.html('<div class="active-lead"><span class="text-white bg-golden px-2 py-1 rounded show_counter_label">'+ count +'</span></div>');
        }
        $("#jobcountnm").trigger("change");
    }



    <?php

    if(!isset($_GET['id']) && !isset($_GET['d']) && !isset($_GET['r']) && !isset($_GET['j']) ) {        

        $parameters = [
            'job_id'        =>  $leads[0]['id'],
            'distance'      =>  $leads[0]['distance_in_miles'],
            'jobscount'     =>  count($leads),
            'reading'       =>  'read',
            'identifiyer'   =>  $identifyer,
            'postcode'      =>  $leads[0]['post_code']    
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
        let url = baseURL+'?leadfilter=leads';
        window.location = url;
    });
    $(document).on('click', '#filter1', function(){
        let url = baseURL+'?leadfilter=interested';
        window.location = url;
    });
    $(document).on('click', '#filter2', function(){
        let url = baseURL+'?leadfilter=shortlisted';
        window.location = url;
    });
    $(document).on('click', '#filter3', function(){
        let url = baseURL+'?leadfilter=jobswon';
        window.location = url;
    });

    


    function loadListings(filter = null, clickedElement = null, category = [], offset = 0, identifier = 'normal', loadingcheck = '') {

        if (loading) {
            return;
        }

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
                        Counter Check
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

                    if(fixingUnread() === 'newleads') $('#ununreader').text(data.leads.unread);
                    if(fixingUnread() === 'interested') $('#ununreader').text(data.interested.unread);
                    if(fixingUnread() === 'shortlisted') $('#ununreader').text(data.shortlisted.unread);
                    if(fixingUnread() === 'jobswon') $('#ununreader').text(data.hired.unread);

                    if(data.leads.unread != undefined){

                        let leads = document.querySelector('#newleads');
                        if(data.leads.unread > 0){
                            $(leads).find('.active-lead').remove();
                            setActiveFilter(leads, data.leads.unread);
                        }else {
                            $(leads).find('.active-lead').remove();
                        }

                    }
                    
                    if (data.interested.unread != undefined) {

                        let interested = document.querySelector('#filter1');

                        if(data.interested.unread > 0){
                            $(interested).find('.active-lead').remove();
                            setActiveFilter(interested, data.interested.unread);
                        }else {
                            $(interested).find('.active-lead').remove();
                        }

                    }
                    
                    if (data.shortlisted.unread != undefined) {

                        let shortlisted = document.querySelector('#filter2');
                        if(data.shortlisted.unread > 0){
                            $(shortlisted).find('.active-lead').remove();
                            setActiveFilter(shortlisted, data.shortlisted.unread);
                        }else {
                            $(shortlisted).find('.active-lead').remove();
                        }

                    }
                    
                    if (data.hired.unread != undefined) {
                        let jobswon = document.querySelector('#filter3');

                        if(data.hired.unread > 0){
                            $(jobswon).find('.active-lead').remove();
                            setActiveFilter(jobswon, data.hired.unread);
                        }else {
                            $(jobswon).find('.active-lead').remove();
                        }

                    }


            },

            error: function () {
                $("#loading_gif").hide();
                checkRunning = false;
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

    let intervalID = setInterval(counterCheck, 4000);



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

    });
</script>

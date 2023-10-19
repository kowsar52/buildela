<style>
    .single-leads-interested-tradepeople-feedback span {
    margin-left: -4px;
    margin-bottom: 3px;
    display: inline-block;
}
</style>


<?php


if (isset($_SESSION['user_id']) && isset($_GET['id'])) {


}else
{
    ?>
    <script type="text/javascript">window.location.href="index";</script>
    <?php
    exit();
}

$distance           =   $_GET['d'];
$reading            =   $_GET['r'];
$identifiyer        =   $_GET['i'];
$incomingjobscount  =   $_GET['j'];
$initjobcount       =   0;
$jobsarray          =   $func->getSingleJob($_GET['id']);
$main               =   $func->SingleMainCategory($jobsarray[0]['main_type']);
$sub                =   $func->SingleSubCategory($jobsarray[0]['sub_type']);
$options            =   $func->getSingleOptions($jobsarray[0]['options']);
$user               =   $func->getuserdetails($jobsarray[0]['user_id']);
$jobImages          =   $func->getJobsImages($_GET['id']);
$applyJob           =   $func->getSingleApplyJob($_GET['id']);
$totalAppliedUser   =   $func->getAllApplyUser($_GET['id']);
$shortListedUser    =   $func->shortlistedusers($_GET['id']);
$checkStatus        =   $func->getApplyUserStatus($_SESSION['user_id'],$_GET['id']);
$usersStatus        =   $func->getjobposteduserinfo($_GET['id']);
$check_chat_exist   =   $func->isChatexist($jobsarray[0]['id']);
$new_chat           =   $func->getAllNewChates($jobsarray[0]['user_id'],$jobsarray[0]['id']);
$newDescription     =   $func->getNewDescriptionOfJob($_GET['id']);



if(!$func->isLeadRead($_GET['id'])){
    $func->setLeadRead($_GET['id']);
}

if($reading === 'unread'){
    $func->leadCountManager($identifiyer, true);
}

if(!empty($usersStatus)){
    $userstatus=$usersStatus[0];
}
$contact= '';
$phonenumber = "<p><i class='fa-solid fa-phone'></i> ".$func->maskPhoneNumber($user[0]['phone'])."</p>";

if(isset($userstatus) && $userstatus['status']!=0 ){
    $contact='<div class="job-photos-heading h4 my-2 d-none" style="margin-left: -3px !important;border-radius: 1px !important;border-color: #007bff !important;background-color: #007bff17 !important;box-shadow: 0px 0px 6px 2px rgba(0,0,0,.1) !important;padding-top: 5px !important;padding-right: 15px !important;padding-left: 10px !important;padding-bottom: 5px !important;margin-bottom: 7px;">Contact Details
        <span class="d-block"><a href="mailto:'.$user[0]['email'].'">'.$user[0]['email'].'</a></span>
        <span class="d-block">'.$user[0]['phone'].'</span></div>';
    $phonenumber = "<a href='tel:".$user[0]['phone']."'><i class='fa-solid fa-phone'></i> ".$user[0]['phone']."</a>";
}


$date=date_create($jobsarray[0]['created_date']);

//apply button status
$apply_button="";
$applyJobnew=$func->getAllApplyUser_new($_GET['id']);
if((!empty($applyJobnew) )&&($applyJobnew[0]['worker_status']==1)){
    $apply_button.='<a id="apply_btn" class="btn-bg-general tooltip-show btn-block text-white text-center px-3 py-2 
text-decoration-none font-weight-bold rounded" style="padding-bottom: .3rem !important;padding-top: .3rem !important;">Someone started Job</a>';

}else if(($_SESSION['user_role'] !='home_owner') && (count($checkStatus)==0)){
    $apply_button.='<a id="apply_btn" class="btn-bg-general tooltip-show btn-block text-white text-center px-3 py-2 text-decoration-none font-weight-bold rounded" style="padding-bottom: .3rem !important;padding-top: .3rem !important;"
                        data-toggle="modal" data-target="#exampleModal" data-post_code="'.$jobsarray[0]['post_code'].'" data-id="'.$jobsarray[0]['id'].'" >Express Interest</a>';

}else if(($_SESSION['user_role'] !='home_owner') &&
    ($checkStatus[0]['status']==0) &&
    ($checkStatus[0]['worker_status']==0 )&&
    ($checkStatus[0]['employer_status']==0 )){
    $apply_button.='<a class="btn-bg-general tooltip-show btn-block text-white text-center px-3 py-2 text-decoration-none font-weight-bold rounded" style="padding-bottom: .3rem !important;padding-top: .3rem !important;">Already applied</a>';

}else if(($_SESSION['user_role'] !='home_owner') &&
    ($checkStatus[0]['status']==1) &&
    ( $checkStatus[0]['worker_status']==0) &&
    ($checkStatus[0]['employer_status']==0)){
    $apply_button.='<a class="btn-bg-general tooltip-show btn-block text-white text-center px-3 py-2 text-decoration-none font-weight-bold rounded" style="padding-bottom: .3rem !important;padding-top: .3rem !important;">Short Listed</a>';

}else if(($_SESSION['user_role'] !='home_owner') &&
    ($checkStatus[0]['status']==1) &&
    ( $checkStatus[0]['worker_status']==0) &&
    ($checkStatus[0]['employer_status']==1)){
    $apply_button.='<a class="btn-bg-general tooltip-show btn-block text-white text-center px-3 py-2 text-decoration-none font-weight-bold rounded" style="padding-bottom: .3rem !important;padding-top: .3rem !important;" id="startJob" onclick="workerstartJob('.$applyJob[0]['user_id'].','.$applyJob[0]['id'].')">Accept Job</a>';

}else if(($_SESSION['user_role'] !='home_owner') &&
    ($checkStatus[0]['status']==1) &&
    ( $checkStatus[0]['worker_status']==1) &&
    ($checkStatus[0]['employer_status']==1)){
    $apply_button.='<a class="btn-bg-general tooltip-show btn-block text-white text-center px-3 py-2 text-decoration-none font-weight-bold rounded" style="padding-bottom: .3rem !important;padding-top: .3rem !important;" id="completeJob" onclick="completeJob('.$applyJob[0]['user_id'].','.$applyJob[0]['id'].')">Complete</a>';

}else if(($_SESSION['user_role'] !='home_owner') &&
    ($checkStatus[0]['status']==2) &&
    ($checkStatus[0]['worker_status']==1) &&
    ($checkStatus[0]['employer_status']==1)){
    $apply_button.='<a class="btn-bg-general tooltip-show btn-block text-white text-center px-3 py-2 text-decoration-none font-weight-bold rounded" style="padding-bottom: .3rem !important;padding-top: .3rem !important;" >Completed</a>';

}
//chat
$chat="";
if( count($checkStatus)>0 && (!empty($check_chat_exist) )){
    $check='';
    if(count($new_chat)>0){
        $check.='<span style="top: 0px;right: -6px;font-size: 13px;width: 22px;height: 22px;text-align: center;color: #fff;
    margin-right: 0;    line-height: 19px;" class="bg-danger position-absolute rounded-circle px-1">'.count($new_chat).'</span>';
    }
    $chat.='<div class="position-relative">
                <a href="chat?touserid='.$jobsarray[0]['user_id'].'&jobid='.$jobsarray[0]['id'].'">
               <i class="fa-solid fa-envelope" style="font-size: 3.9em;"></i>
                </a>
                '.$check.'
             </div>';
}

//concate images
$videoCount = 0;
$imageCount = 0;
$imagesdata = "";
$videoBlock = '<div class="video-blocks2">';
$imageBlock = '<div class="image-blocks2">';

foreach ($jobImages as $files) {
    $image = explode("/", $files["img_path"]);
    $img = $image[1] . '/' . $image[2];
    
    if ($files['file_type'] == "video") { $videoCount++;
        $videoBlock .= '
            <a href="'.$img.'" data-href="'.$img.'#t=0.001" data-lightbox="Videos">
                <video class="img-fluid rounded" controls>
                    <source src="'.$img.'#t=0.001" type="video/mp4" about="job video">
                    Error Message
                </video>
            </a>';
    } else if ($files['file_type'] == 'image') { $imageCount++;
        $imageBlock .= '
            <a href="'.$img.'" data-lightbox="leads">
                <img class="img-fluid rounded" src="'.$img.'" alt="job image">
            </a>';
    }
}
if ($imageCount == 0) {
    $imageBlock .= '<style>.image-blocks { display: none; }</style>';
} else {
    $imageBlock .= '<div class="total-counts">Total Images: ' . $imageCount . '</div>';
}

if ($videoCount == 0) {
    $videoBlock .= '<style>.video-blocks { display: none; }</style>';
} else {
    $videoBlock .= '<div class="total-counts">Total Videos: ' . $videoCount . '</div>';
} 

$videoBlock .= '</div>';
$imageBlock .= '</div>';

// Output the video and image blocks
$imagesdata = $videoBlock . $imageBlock;

// Use $imagesdata as needed




//concate intrested peoples
$intrested_people= "";
$more="";

if(count($totalAppliedUser)>2){
    $more='<p class="badge rounded-pill bg-success p-1 text-center text-white " >+ more</p>';
    $two="2";
}
$i=0;
$short_listed='';
$applied='';
if(count($shortListedUser)>2){
    $short_listed='2+';

}else{
    $short_listed="".count($shortListedUser);
}
if(count($totalAppliedUser)>2){
    $applied='2+';

}else{
    $applied="".count($totalAppliedUser);
}


$i=0;

foreach($totalAppliedUser as $appliedUser){
    if($i == 2){
        break;
    }
    
    $i++;
    $userinfo=$func->UserInfo($appliedUser['user_id']);
    $rateings=$func->getUserRatting($appliedUser['user_id']);
    $sumofStars=0;
    foreach($rateings as $rate){
        $sumofStars+=$rate['ratings'];
    }
    $count_rating=0;
    $show_status="";

    $stars="";
    if(count($rateings)>0){
        $count_rating=round($sumofStars/count($rateings),2);

        for ($j=0; $j <ceil($sumofStars/count($rateings)); $j++){
            $stars.='<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#FFC107" viewBox="0 0 18 18"><path d="M9,0L6.563,6.095L0,6.539l5.04,4.219l-1.594,6.352L9,13.617l5.555,3.492l-1.594-6.352L18,6.539l-6.563-0.444L9,0z"></path></svg>';
        }
    }

    $status="";

    if($count_rating==1){
        $status="";

    }else if($count_rating==2){
        $status="Good";

    }else if($count_rating==3){
        $status="Very Good";

    }else if($count_rating>3){
        $status="Excellent";
    }
    if(count($rateings)>0){
        $show_status='<div class="row mx-0">     
                <div class="">'. $status." ". round($sumofStars/count($rateings),2).'</div>
               </div>';
    }
    
    $avgrating = null;
    if(count($rateings) > 0){
        $avgrating = '<div class="single-leads-interested-tradepeople-feedback">Average star rating<br><span> '.$stars.'</span><br>
        '.count($rateings).' feedback
        </div>';
    }
    $intrested_people.='<div class="leads-interested-tradepeople-wrapper py-4">
                            <div class="leads-interested-tradepeople-heading h4">Interested Tradepeople</div>
                            <div class="single-leads-interested-tradepeople-wrapper mt-2">
                                <div class="single-leads-interested-tradepeople rounded  p-3 d-flex justify-content-between">
                                    <div class="single-leads-interested-tradepeople-name"><a href="user-profile?u_id='.$userinfo[0]['id'].'"style="font-size: 14px;">'.$userinfo[0]['trading_name'].'</a></div>
                                    '.$avgrating.'
                                </div>
                            </div>
                        </div>';
}

//time differance

$subdate=$jobsarray[0]['created_date'];
$earlier = new DateTime($subdate);
$later = new DateTime(date("Y-m-d H:i:s"));
$diff = $later->diff($earlier)->format("%a");

$time="";
$new_leades="";			   
if($diff==0){
    $houre = $later->diff($earlier);
    $houres=$houre->h;
    if($houres == 0){
        $time.="Lead posted few minutes ago";
    }else{

        $time.="Lead posted $houres hours ago";
    }
	  if($houres<=12){
        $new_leades='<span class="px-2 py-1 new-lead"> New lead</span>';

    }				

}else if ($diff == 1) {
    $time.="Lead posted 1 day ago";
}else if($diff == 2){

    $time.="Lead posted 2 days ago";
}else if ($diff == 3) {
    $time.="Lead posted 3 days ago";
}else if($diff == 4){
    $time.="Lead posted 4 days ago";
}else if ($diff == 5) {
    $time.="Lead posted 5 days ago";
}else if($diff == 6){
    $time.="Lead posted 6 days ago";
}else if ($diff == 7) {
    $time.="Lead posted 7 days ago";
}else if($diff > 7){
    $time.="Lead posted a week ago";
}
$more_description='';
foreach ($newDescription as $des){
    $more_description.='<div class="single-lead-complete-customer-description-heading h6">Extra information added on '.date('d/m/Y, g:i a',strtotime($des['create_date'])).' </div><p>'.$des['description'].'</p>';

}

if ($distance > 1) {
  $distanceStr = $distance . ' miles away';
} else {
  $distanceStr = $distance . ' mile away';
}

if($imageCount != 0 || $videoCount != 0){
    $jobimages = '<div class="leads-job-photos-wrapper py-4"><div class="job-photos-heading h4">Job Photos</div><div class="leads-job-photos row ml-auto">'.$imagesdata.'</div></div>';
} else {$jobimages = '';}

echo '<div class="six-fraction-inner ">
    <div class="single-lead-complete-description px-3">
        <div class="single-lead-complete-description-first-section bg-white">
            <div class="single-lead-complete-description-first-section-heading h4">'.$jobsarray[0]['title'].'  '.$new_leades.'</div>
            <div class="single-lead-desc-first-sec-loc-address d-flex justify-content-between">
                <div>
                    <p class="lead-desc-first-sec-loc font-weight-bold"><i class="fa fa-map"></i> '.$func->getCityName($jobsarray[0]['post_code']).", ".$func->breakPostalCode($jobsarray[0]['post_code']).'<br> <span> '.$distanceStr.'</span></p>
                    <div class="phoneNumber">
                    '.$phonenumber.' 
                    <div class="verified-badge">
                        <i class="fa-solid fa-check" style="font-size: 1.2em;"></i> Verified                   
                    </div>
                    </div>
                    <p class="lead-desc-first-sec-address"> <span class="time-sec"> '. $time.'</span></p>
                    
                    <div class="d-flex align-items-center">
                
                <div class="btn-div-general my-auto mr-2">
                    '.$apply_button.'
                </div>
                <div class="btn-div-general lead-desc-first-sec-address">
                    '.$chat.'
                </div>
				</div>
                </div>
				
				
				
            </div>
            <div class="hidden-div h4 text-center">
                <div class="tooltip-shape-wrapper">
                    <div class="tooltip-shape"></div>
                </div>
                Apply for as many jobs as you wish, no extra charges.
            </div>
        </div>
        <div class="single-lead-complete-job-description bg-white mt-2">
            <div class="single-lead-complete-job-description-heading h4">Job details</div>
            <div class="single-lead-complete-job-name h6">'.$main[0]['category_name'].'</div>
            <ul>
                <li>'.$sub[0]['category_name'].'</li>
            </ul>

            <div class="single-lead-complete-customer-description-wrapper pb-4">
                <div class="single-lead-complete-customer-description-heading h6">Customer Description</div>
                <div class="single-lead-complete-customer-description">
                    <p>
                        '.$jobsarray[0]['job_discription'].'
                    </p>
                    <div class="my-1">'.$more_description.'</div>
                <div class="single-lead-posted-date">
                    '.date_format($date,"D M-j-Y h:m").'
                </div>
                <div class="single-lead-posted-customer-name d-flex justify-content-between">
                    <span>Posted by '.$user[0]['fname'].'</span>
		
                    <span><a class="text-decoration-none" href="user-profile?u_id='.$user[0]['id'].'&job_id='.$jobsarray[0]['id'].'&usp=2&ds='.$distance.'&jc='.$initjobcount.'">View Profile <i class="fa-solid fa-chevron-right"></i></a></span>
                   
                </div>
        
                
                 '.$contact.'
            </div>
            '.$jobimages.'
            <div class="lead-shortlisted-wrapper py-4">
                <div class="lead-shortlisted-heading h3">Shortlist Activity</div>
                <div class="lead-shortlisted-content px-3 rounded py-4">
                    <div class="row mx-0 justify-content-between ">
                        <span>'.$short_listed.' Shortlisted</span>
                        <span>of</span>
                        <span>'.$applied.' Interested</span>
                    </div>
                </div>
            </div>
            
               '.$intrested_people.'
               <br>
               '.$more.'
        </div>
    </div>
</div> ';

// echo "<pre>";
// var_dump($newDescription);
// echo "</pre>";
?>
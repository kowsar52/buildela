<?php
require_once "serverside/functions.php";
include_once "serverside/session.php";
//if($_SESSION['user_role']=='jobs_person'){
//    ?>
<!--    <script type="text/javascript">-->
<!--        window.location.href="leads";-->
<!--    </script>-->
<!--    --><?php
//
//}

$ipAddress = $_SERVER["REMOTE_ADDR"];
$deviceInfo = $_SERVER["HTTP_USER_AGENT"];

$userInfo = array(
    'ip_address' => $ipAddress,
    'device_info' => $deviceInfo
);



$func=new Functions();
$jobs=$func->getSingleJob($_GET['job_id']);


if( (isset($_GET['job_id'])) && (($jobs[0]['user_id']==$_SESSION['user_id']) || ($_SESSION['user_type']==1))){

}else{
    ?>
    <script type="text/javascript">
        window.location.href="index";
    </script>
    <?php
    exit();
}


$main=$func->SingleMainCategory($jobs[0]['main_type']);
$sub=$func->SingleSubCategory($jobs[0]['sub_type']);
$options=$func->getSingleOptions($jobs[0]['options']);
$user=$func->getuserdetails($jobs[0]['user_id']);
$jobImages=$func->getJobsImages($_GET['job_id']);
$applyJob=$func->getSingleApplyJob($_GET['job_id']);
$totalAppliedUser=$func->getAllApplyUser($_GET['job_id']);
$shortListedUser=$func->shortlistedusers($_GET['job_id']);
$checkStatus=$func->getApplyUserStatus($_SESSION['user_id'],$_GET['job_id']);
$newDescription=$func->getNewDescriptionOfJob($_GET['job_id']);

include_once "includes/header.php";

?>
 <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>

.navigation.container {
box-shadow: 0px 0px 6px 2px rgba(0,0,0,.1) !important;
margin-bottom: 10px;
}
.profile-img {

    margin-top: 7px;
}
.profile-img img.image-15 {
    width: 100px;
    height: 100px;

}
a.rounded {
    width: 43px;
}
.heading-15 {
    display: inline-block;
    color: #6c6d71;
    font-weight: 600;
    text-align: center;
}
.text-block-24 {
    color: #5f5f5f;
    font-weight: 500;
    text-align: center;
}
.section.cc-home-wrap.posted-my-job.details {
    padding-top: 50px;
}
.button-9 {
    margin-top: 0px;
    border-radius: 10px;
    background-color: #006bf5;
    font-weight: 600;
}
.listed-jobs {

    border-radius: 10px;
    padding: 10px!important;

}
.edit-new-blue-btn {
    font-size: 16px;
}

.edit-new-blue-btn a {
    white-space: nowrap;
}
    img.chat-icon {
    width: 100px;
}
a#chat_btn {
    background: #fff;
    color: #007bff;
    cursor: pointer;
}
a#chat_btn:hover{
    color: inherit;
}
img.img-fluid.rounded.posted-img {
    width: 125px;
    height: 125px;
    object-fit: cover;
    margin-right: 20px;
}
.heading-8 {
    margin-bottom: 0px;
    color: inherit;
    font-size: 17px;
    font-weight: 700;
    margin-bottom: 7px;
}
.heading-8 a {
    color: #007bff!important;
    cursor: pointer;
    text-decoration: underline;
}
.heading-71{
    margin-bottom: 0px;
    color: inherit;
    font-size: 17px;
    font-weight: 700;
   
}
.div-block-8 {
    margin-bottom: 20px;
    padding: 0;
    border-radius: 20px;
    background-color: #006bf5;
}
input#images {
    background: transparent!important;
    border: 1.5px dashed #aaa!important;
    padding: 6px 12px!important;
}
#fa-icon-rotate.rotate {
    transform: rotate(90deg);
}
p.notes {
    margin-top: 1em;
    border: 1px solid #;
    padding: 7px 17px;
    background-color: #daeaff;
    border-radius: 9px;
    display: inline-block;
    position: relative;
}
p.notes:before {
    position: absolute;
    content: "";
    width: 0;
    height: 0;
    border-left: 10px solid transparent;
    border-right: 10px solid transparent;
    border-top: 10px solid #daeaff;
    left: -8px;
    top: 0;
    /* transform: rotate(45deg); */
}
/* 
  ##Device = Most of the Smartphones Mobiles (Portrait)
  ##Screen = B/w 320px to 479px
*/

@media (min-width: 320px) and (max-width: 480px) {

.uui-testimonial11_rating-wrapper {
    width: 100%;
    margin-left: auto;
    margin-right: auto;
    display: inline-flex;
    justify-content: center;
}

	
  
    .section.cc-home-wrap.posted-my-job.details {
    padding-top: 10px;
}
div#img_btn {
    width: 100%;
}
input#images {
    width: 100%;
}
label.upload__btn {
    width: 100%;
}
.button-12.profile {
    font-size: 13px;
    padding: 10px 10px;
    height: 40px;
}

h4.heading-71 {
    display: inline-block;
    width: 66%;
    padding-left: 0px;
}
h4.heading-10 {
    margin-top: 30px;
}
.profile-img img.image-15 {
    width: 60px;
    height: 60px;
}
.div-block-9 {
    text-align: left;
    padding-left: 0;
    padding-right: 0;
}
h5.heading-9.your-job.name {
    text-align: center;
    margin-left: 40px!important;
    margin-top: 2px!important;
    margin-right: 0px!important;
}
.uui-testimonial11_rating-wrapper {
    text-align: center;
    margin-left: auto;
    margin-right: auto;
    display: inline-flex;
    justify-content: flex-start;

   
}
i.fa-solid.fa-location-dot {
    color: #d10a38;
}
.text-block-18 {
    padding-right: 0px;
    color: #5f5f5f;
}

a#chat_btn {
    background: #fff;
    font-size: 13px;

}

.button-crt {

    grid-column-gap: 6px;
    justify-content: flex-start;

}
button#shortList23 {
    line-height: 13px;
    background: #006bf5;
}
p.notes {
    margin-top: 1em;
    margin-bottom: 0em;
}
h4.heading-10 {
    font-size: 32px;
}
.cta-note.w-container {
    padding: 15px;
}
.block-icon-w-text {
    display: block;
    padding-bottom: 40px;
}
img.chat-icon {
    width: 40px;
}
img.image-15 {
    margin-left: 0px;
}
h5.heading-9.your-job.name {
    margin-left: 0px;
    margin-right: 10px;
}
i.btn-color-bg.fa.fa-trophy, i.btn-color-bg.fa.fa-user{
    color: #006bf5;
    margin-left: 0px!important;
}
p.notes {
    margin-left: 0px;
    margin-top: 10px!important;
}

a.position-relative.px-4.py-2.mx-2.text-decoration-none.font-weight-bold {
    padding-left: 0px!important;
    padding-right: 0px!important;
}
i.btn-color-bg.fa.fa-location {
    color: #006bf5;
    margin-left: 0px!important;
}
	h5.heading-9.your-job.name {
		margin-left: 0px!important;
    width: 100%!important;
    text-align: center!important;
    display: block!important;
}
}

h4.heading-71 {
    display: inline-block;
    width: 85%;
	padding-left: 10px;
}
img.image-15 {
    border-radius: 100px;
}
.block-icon-w-text .fa-solid {
    color: #006bf5;
    font-size: 35px;
    text-align: center;
    margin-left: auto;
    margin-right: auto;
    display: block;
}.block-icon-w-text .fa-regular {
    color: #006bf5;
    font-size: 35px;
    text-align: center;
    margin-left: auto;
    margin-right: auto;
    display: block;
}


h3.heading-13 {
    margin-bottom: 30px;
}
.steps.w-container {
    margin-bottom: 25px;
}
.numbertitle {

    line-height: 28px;
    margin-left: -35px!important;
    border-radius: 1px!important;
    border-color: #e9eced!important;
    background-color: #ffffff!important;
    box-shadow: 0px 0px 6px 2px rgba(0,0,0,.1) !important;
    padding-top: 5px!important;
    padding-right: 15px!important;
    padding-left: 15px!important;
    padding-bottom: 5px!important;
    margin-bottom: 7px;
}
.headtitle {
    margin-top: 25px;
}
.text-block-24 {
    margin-bottom: 30px;
}
.block-icon-w-text .fa-solid {
    color: #006bf5;
    font-size: 26px;
}
.block-icon-w-text {
    display: block;
    padding-bottom: 40px;
}
.heading-10 {

    margin-bottom: 10px;

}
.no-result{
	margin-bottom: 30px;
}
.steps.w-container {
    max-width: 1280px;
}

p {
    margin-top: 0;
    margin-bottom: 0.rem;
}
h3.heading-16 {
    display: inline-block;
}
span.rating-number {
    color: #ffc107;
    padding-left: 5px;
    font-weight: 600;
}
img.pl-2.img-fluid {
    height: 35px;
    margin-bottom: 1px;
}
.second-section-job-title-heading.h4.d-flex.justify-content-between {
    font-weight: 600;
}
.columns-13.w-row {
    box-shadow: 1px 1px 20px 0 rgb(108 109 113 / 65%);
}

.steps.w-container {
    margin-bottom: 25px;
    margin-top: 25px;
}
p.no-result {
    text-align: center;
    font-weight: 600;
    color: #006bf5;
}
p {
    margin-bottom: 0.5rem;
}
.text-block-18.rv {
    padding-right: 0px;
    padding-left: 2px;
    line-height: 25px;
}
i.btn-color-bg.fa.fa-trophy,i.btn-color-bg.fa.fa-user {
    color: #006bf5;
}
.button-crt {
 
    grid-column-gap: 0px;
}

h5.heading-9.your-job.name {
    line-height: 34px;
    display: -webkit-inline-box;
    vertical-align: middle;
}
.uui-testimonial11_rating-wrapper {
    display: inline-flex;
    gap: 2px;
}
#approval{
    font-size: 0.75em;
    padding: 11px 25px!important;
}
.headtitle {
    text-align: left;
    display: block;
}
.text-block-23.num {
    color: #006bf5;
    font-size: 22px;
    font-weight: 800;
    line-height: 27px;
}
h4.heading-15 {
    font-size: 25px;
    line-height: 50px;
    font-weight: 700;
    color: #212529;
}
.text-block-24 {
    margin-bottom: 30px;
    color: #000;
    font-size: 17px;
    font-weight: 500;
    text-align: left;
}

h5.heading-9.your-job.name {

    margin-bottom: 7px;
}
h5.heading-9.your-job.name:hover {
    color: #0056b3;

}
button.btn-bg-general.text-white.text-center.px-4.py-2.text-decoration-none.rounded {
    color: #fff;
    font-weight:700;
}
button.btn-bg-general.text-white.text-center.px-4.py-2.text-decoration-none.rounded:hover{
  background-color:#1861D1; 
}
a#chat_btn:hover{
  color: #1861D1;
}
.uui-testimonial11_rating-wrapper:hover, span.rating-number:hover, .userpf-link:hover {
    text-decoration: none!important;
}
span.rating-number {
   color: #ffc107;
    padding-left: 4px;
	 font-weight: 600;
	     padding-right: 0;
	     font-size: 1.1rem;
	     padding-top: 1.9px;
}
i.btn-color-bg.fa.fa-location {
    color: #006bf5;
    /* margin-left: 150px; */
}
i.btn-color-bg.fa.fa-user {
    color: #006bf5;
    /* margin-left: 150px; */
}
.leads-job-photos img, .leads-job-photos video {
    object-fit: cover;
    width: 100px;
    height: 100px;
    display: block;
}

.leads-job-photos {
    gap: 5px;
    object-fit: cover;
    margin: 0;

}
.img-block {
    display: inline-block;
}
a.btn.btn-danger.d-block.bnt-sec {
    color: #fff;
    padding: 2px 2px;
    margin-top: 5px;
    font-size: 13px;
}
.recommendation {
    margin-bottom: 20px;
}
.recommendation h4{
  font-size: 18px;
}
.recommendation .btn-group {
    display: inline-block !important;
}
.recommendation input {
    width: 16px;
    height: 16px;
    position: relative;
    top: 1px;
}
.recommendation label {
    border: none;
    margin-right: 14px;
    font-size: 18px;
    margin-left: 3px;
}

.recommendation label:not(:disabled):not(.disabled).active{
    color: #fff !important;
    background-color: transparent !important;
    border-color: transparent !important;
}

.rating-head h4 {
  font-size: 18px;
    margin-bottom: 20px;

}
.rating-head h5,.rating-head h4{
  font-size: 18px;
}
@media (min-width: 768px) and (max-width: 1024px) {
  

img.chat-icon {
    width: 40px;
}
img.image-15 {
    margin-left: 0px;
}
h5.heading-9.your-job.name {
    margin-left: 0px;
    margin-right: 10px;
    
}
i.btn-color-bg.fa.fa-trophy {
    color: #006bf5;
    margin-left: 0px;
}
i.btn-color-bg.fa.fa-user {
    color: #006bf5;
    margin-left: 2px;
}
p.notes {
    margin-left: 0px;

}

a.position-relative.px-4.py-2.mx-2.text-decoration-none.font-weight-bold {
    padding-left: 0px!important;
    padding-right: 0px!important;
}
i.btn-color-bg.fa.fa-location {
    color: #006bf5;
    margin-left: 0px!important;
}

  
}




@media (min-width: 1024px) {
  
/* .profile-img a.userpf-link {
    margin-left: -125px;
} */
  
}
.uui-testimonial11_rating-wrapper.no-rt {
    width: 100%;
    display: none;
}
.text-block-18.rv.no-rt {
    width: 100%;
}
span.no-rating {
    font-family: Montserrat, sans-serif!important;
    color: #000;
    font-size: 12.9px;
}


/*styling for rating */
.rating-feedback {
    position: relative;
    display: inline-block;
    border: none;
    font-size: 14px;
    margin-bottom: 10px;

}
.rating_testimonial {
	left: 20% !important;
}
.rating-feedback input {
	border: 0;
	width: 1px;
	height: 1px;
	overflow: hidden;
	position: absolute !important;
	clip: rect(1px 1px 1px 1px);
	clip: rect(1px, 1px, 1px, 1px);
	opacity: 0;
}
.rating-feedback label {
	position: relative;
	float: right;
	color: #C8C8C8;
}
.rating-feedback label {
	padding: 5px;
	display: inline-block;
	font-size: 2em;
	fill: #ccc;
	user-select: none;
  cursor: pointer;
}
.rating-feedback label svg {
    width: 25px;
    height: auto;
    stroke: #FFC107;
    stroke-width: 1px;
}
.rating-feedback label svg path {
    fill: transparent;
}
.rating-feedback input:checked ~ label svg path {
	fill: #FFC107;
}
.rating-feedback label:hover ~ label svg path {
	fill: #FFDB70;
}
.rating-feedback label:hover svg path {
	fill: #FFC107;
}

@media(max-width:480px){
    h5.heading-9.your-job.name{

        text-align: left!important;
        line-height: 1.2;
    }
    .w-col-small-3 {
    width: 25%;
  }
.w-col-small-9 {
    width: 75%;
}
#approval {

    padding: 6px 25px!important;
    line-height: 1.2;
    height: 36px;
}
}




</style>





<!-- new design -->


<div class="section cc-home-wrap posted-my-job details">
    <section class="uui-section_testimonial11">
      <div class="uui-page-padding">
        <div class="uui-container-large"></div>
      </div>
    </section>
    <div class="w-container">
      <div class="listed-jobs">
	  
        <div class="second-section-job-details-col-inner  rounded p-3">

            <div class="second-section-Job-title pt-4">
                <div class="second-section-job-title-heading h4 d-flex justify-content-between"><?=$jobs[0]['title']?>
                    <span class="edit-new-blue-btn "><a class="text-decoration-none py-1 px-2" id="edit-1" href="#">Edit <i id="fa-icon-rotate" class="fa fa-angle-right" aria-hidden="true"></i></a></span>
                </div>
                <div id="details-1-edit">
                    <p><?=$main[0]['category_name']?></p>
                </div>
            </div>
            <div id="edit-whole-wrapper">
                <div  class="second-section-customer-description pb-4">
                    <div class="second-section-customer-description-heading h4 d-flex justify-content-between heading-8">Job Description<span>
                            <?php
                            if($jobs[0]['status']==0){
                                ?>
                                <a data-toggle="modal" data-target="#des_modal" >Edit</a></span></div>
                            <?php
                            }else{
                                ?>
                    <a data-toggle="modal" data-target="#des_modal_add" >Add to post</a></span></div>
                            <?php
                            }
                            ?>
                    <div id="">
                        <p><?=$jobs[0]['job_discription']?></p>
                    </div>
                    <div class="my-1">
                        <?php
                        foreach ($newDescription as $des){
                            ?>
                            <p><?=$des['description']?></p>

                            <?php
                        }
                        ?>

                    </div>
            


                </div>
                <div  class="second-section-add-photo">
                    <div class="heading-8">Photos & Videos</div>
                    <div class="add-photo-row row mx-0 pt-4 pb-3">
                        <div class="upload__box ">
                            <div class="upload__btn-box" id="img_btn">
                                <label class="upload__btn">
                                    <p class="mb-0 text-uppercase font-weight-bold">Upload photos & videos</p>
                                    <input type="hidden" id="jobsid" value="<?=$jobs[0]['id']?>" >
                                    <input type="file" name="multipleimages[]" multiple id="images" data-max_length="20" class="upload__inputfile">
                                </label>
                                <p>you can select multiple from your gallery</p>
                            </div>
                            <span id="uploadresponse"></span>
                            <span id="uploadresponse_spinner" style="display:none;"><i class="fa fa-spinner fa-spin"></i></span>
                            <!--                                        <div class="upload__img-wrap"></div>-->
                        </div>
                    </div>


        
        
                                
                                                    
            
                            
                    <?php
                    if (!empty($jobImages)) {
                        ?>
                        <div class="leads-job-photos-wrapper py-4">
                            <div class="job-photos-heading h4">Job Photos</div>
                            <div class="leads-job-photos row">
                                <?php
                                foreach ($jobImages as $files){
                                    $image=explode("/",$files['img_path']);
                                    $img= $image[1].'/'.$image[2];
                                    $imgid = $files['id'];
                                    if($files['file_type']=='video'){
                                        ?>
                                        <div class="img-block">
                                        <video class="img-fluid rounded"  controls>
                                            <source src="<?=$img?>" type="video/mp4">
                                            Error Message
                                        </video>
                                        <a class="btn btn-danger d-block bnt-sec"   onclick="deleteImagejob(<?=$imgid?>)">Delete</a>
                                        </div>
                                        <?php
                                    }else if($files['file_type']=='image'){
                                        ?>
<div class="img-block">
                                                    <img class="img-fluid rounded" src="<?=$img?>" >
													
													<a class="btn btn-danger d-block bnt-sec"   onclick="deleteImagejob(<?=$imgid?>)">Delete</a>
</div>
                                                    <?php
                                                }

                                            }

                                            ?>

                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
		
      </div> </div>
	  
      <h4 class="heading-10">Interested tradespeople</h4>
   
    <div class="container">
      <div class="motto-wrap"></div>
      <div class="about-story-wrap"></div>
    </div>
  </div>
  <div class="w-container">
       <?php
	    if (empty($totalAppliedUser)) {
            echo "<p class='no-result' >No one has applied yet. Please check back later.</p>";
	    }
        foreach($totalAppliedUser as $appliedUser){
            $userinfo=$func->UserInfo($appliedUser['user_id']);
            $rateings=$func->getUserRatting($appliedUser['user_id']);
            $checkChateStarted=$func->checkChatStarted($appliedUser['user_id'],$appliedUser['job_id']);

            $sumofStars=0;

            $oneStars=0;
            $towStars=0;
            $threeStars=0;
            $fourStars=0;
            $fiveStars=0;

            foreach($rateings as $rate){
                $sumofStars+=$rate['ratings'];
                if($rate['ratings']==1){
                    $oneStars++;

                }else if($rate['ratings']==2){
                    $towStars++;

                }else if($rate['ratings']==3){
                    $threeStars++;

                }else if($rate['ratings']==4){
                    $fourStars++;
                }else if($rate['ratings']==5){
                    $fiveStars++;
                }

            }//foreach




  ?>
									
    <div class="div-block-8 userprofile up">
      <div class="w-row">
        <div class="w-col-small-3 w-col w-col-2">
          <div class="profile-img">
		 
		          <?php
                                                if(empty($userinfo[0]['img_path']))
                                                {
                                                    ?>
                                                    <img class="image-15" src="images/avatar1.png" alt="no-image" loading="lazy" width="250" height="200" sizes="(max-width: 479px) 100vw, (max-width: 767px) 250px, (max-width: 991px) 157px, 210px">
                                                    <?php
                                                }else{
                                                    $image=explode('/',$userinfo[0]['img_path'] );

                                                    $img= $image[1].'/'.$image[2];
                                                    ?>
                                           <a  class="userpf-link" href=" user-profile?u_id=<?=$userinfo[0]['id']?>&job_id=<?=$jobs[0]['id']?>">         <img class="image-15" src="<?=$img?>" alt="no-image" loading="lazy" width="250" height="200"  sizes="(max-width: 479px) 100vw, (max-width: 767px) 250px, (max-width: 991px) 157px, 210px"></a>
                                                    <?php
                                                }
                                                ?>
		 
		 
		 </div>
        </div>
        <div class="column-15 w-col-small-9 w-col w-col-9 pr-0">
          <div class="div-block-9">
		   <?php
											 
											  
		  
			  
											 
								   
																																										 
														  
			  
	 
  
				   
                                                if(count($rateings)>0){

													
 
														 
                                                    if((count($rateings)>=100)&&( $sumofStars/count($rateings)>=4.5)){
                                                        ?>
                                                        <div class="buildela-hiring">
                                                            <span><i class="btn-color-bg fa fa-shield" aria-hidden="true"></i></span>
                                                            <span class="span-2">Top rated Builders</span>
                                                        </div>

                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <?php
		   
				  
                                                if($userinfo[0]['dbs_path']){
										 
										 
																	
								 
	
		 
																   

																												  
                                                    ?>
                                                    <div class="buildela-hiring">
                                                        <span><i class="btn-color-bg circle-size fa fa-circle-o"></i></span>
                                                        <span class="span-2"> DBS Verified</span>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
            <a  class="userpf-link" href=" user-profile?u_id=<?=$userinfo[0]['id']?>&job_id=<?=$jobs[0]['id']?>"><h5 class="heading-9 your-job name"><?=$userinfo[0]['trading_name']?></h5>
			
			   <div class="uui-testimonial11_rating-wrapper <?php if (count($rateings) == 0) { echo 'no-rt'; } ?> ">
    <?php
    if (count($rateings) > 0) {
        $rating = round($sumofStars / count($rateings), 1);
        $fullStars = floor($rating);
        $decimalPart = $rating - $fullStars;

        // Display full stars
        for ($i = 0; $i < $fullStars; $i++) {
            echo "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='#FFC107' viewBox='0 0 18 18'><path d='M9,0L6.563,6.095L0,6.539l5.04,4.219l-1.594,6.352L9,13.617l5.555,3.492l-1.594-6.352L18,6.539l-6.563-0.444L9,0z'/></svg>";
        }

        // Display half star
        if ($decimalPart >= 0.1 && $decimalPart <= 0.9) {
            echo "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 18 18'><path d='M9,0L7.406,6.095L0,6.539l5.04,4.219L3.446,16.11L9,13.617V0z' fill='#FFC107'></path><path d='M9,0L10.594,6.095L18,6.539l-5.04,4.219L14.554,16.11L9,13.617V0z' fill='#808080'></path>
          </svg>";
        }

        // Display remaining grey stars
        $remainingStars = 5 - $fullStars - ($decimalPart >= 0.1 && $decimalPart <= 0.9 ? 1 : 0);
        for ($i = 0; $i < $remainingStars; $i++) {
            echo "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='#808080' viewBox='0 0 18 18'><path d='M9,0L6.563,6.095L0,6.539l5.04,4.219l-1.594,6.352L9,13.617l5.555,3.492l-1.594-6.352L18,6.539l-6.563-0.444L9,0z'/></svg>";
        }

        // Display number
        echo "<span class='rating-number'>" . $rating . "</span>";
    }
    ?>
    <div class="text-block-18 rv <?php if (count($rateings) == 0) { echo 'no-rt'; } ?>">
        <strong class="bold-text-4 <?php if (count($rateings) == 0) { echo 'no-rt'; } ?>">
            <?php
            if (count($rateings) == 0) {

            } else {
                echo '<span class="total-rating">(' . count($rateings) . ')</span>';
            }
            ?>
        </strong>
    </div>
</div>




			</a>
         
		 <div class="buildela-hiring">
			
			   <?php
			   
        if (count($rateings) == 0) {
            echo '<span><i class="btn-color-bg fa fa-user" aria-hidden="true" style="margin-right: 2px;padding-left: 2px;"></i></span><span class="no-rating"> New User</span>';
        } else {
            echo '';
        }
        ?>
			
                                                    
                                            
                                                    <span style="margin-left: 0;"></span>
                                                    
                                                </div>
		 
		 
			<div class="buildela-hiring">
	
			
                                                    <span><i class="btn-color-bg fa fa-trophy" aria-hidden="true"></i></span>
                                                    <span class="span-2"> 	<?php
if (count($userinfo[0]['hired_counter']) > 1) {
    echo '' . count($userinfo[0]['hired_counter']) . ' hires';
} else {
    echo '' . count($userinfo[0]['hired_counter']) . ' hire';
}
?>		 on Buildela</span> 
						
                                                    <span style="margin-left: 5px;"></span>
                                                    
                                                </div>
												<div class="buildela-hiring">
                                                    <span><i class="btn-color-bg fa fa-location" aria-hidden="true" style="padding-left: 1px;"></i></span>
                                                   <span class="span-2"><?=$userinfo[0]['town']?> </span> 
						
                                                    <span style="margin-left: 5px;"></span>
                                                    
                                                </div>
			
            <div class="columns-7 w-row">
              <div class="w-col w-col-6">
                <p class="notes">"<?=$func->charlimit($appliedUser['message'], 15)?>"</p>
              </div>
              <div class="column-21 w-col w-col-6">
                <div class="button-crt">
                  <?php
                                            if($appliedUser['status']==0){
                                                ?>
                                                <button  onclick="shortList(<?=$appliedUser['user_id']?>,
                                                <?=$appliedUser['job_id']?>)" id="shortList<?=$appliedUser['user_id']?>" class="btn-bg-general text-white text-center px-4 py-2 text-decoration-none rounded">Shortlist</button>
                                                <?php	 
                                            }else if($appliedUser['status']==1&&$appliedUser['worker_status']==0&&$appliedUser['employer_status']==0){
                                                ?>
                                                <button id="hire_btn" onclick="employerstartJob(<?=$appliedUser['user_id']?>,<?=$appliedUser['job_id']?>)" class="btn-bg-general
                                                text-white text-center px-4 py-2 text-decoration-none rounded">Hire</button>

                                                <?php
                                            }else if($appliedUser['status']==1&&$appliedUser['worker_status']==0&&$appliedUser['employer_status']==1){
                                                ?>
                                                <button id="approval" class="btn-bg-general text-white text-center px-4 py-2 text-decoration-none rounded">Wait for trademen's approval</button>
                                                <?php
                                            }else if($appliedUser['status']==1&&$appliedUser['worker_status']==1&&$appliedUser['employer_status']==1){
                                                ?>
                                                <button class="btn-bg-general text-white text-center px-4 py-2 text-decoration-none rounded">Job Accepted</button>
                                                <?php
                                            }else if($appliedUser['status']==2&&$appliedUser['worker_status']==1&&$appliedUser['employer_status']==1 && $appliedUser['rating']==0){
                                                ?>
                                                <button  class="ratemodalopen btn-bg-general text-white text-center px-4 py-2 text-decoration-none
                                                font-weight-bold rounded" data-toggle="modal" data-target="#exampleModal" data-userid = "<?=$appliedUser['user_id']?>" data-jobid="<?=$appliedUser['job_id']?>">Rate this user</button>

                                                <?php
                                            }else if($appliedUser['status']==2&&$appliedUser['worker_status']==1&&$appliedUser['employer_status']==1 && $appliedUser['rating']==1){
                                                ?>
                                                <button class="btn-bg-general text-white text-center px-4 py-2 text-decoration-none rounded">Feedback left</button>
											
                                                <?php
                                            }
                                            ?>
																																												 
                                            <?php
										 
										  
		   
                                            if(empty($checkChateStarted)) {
                                                ?>
                                                <a onclick="startChat(<?=$appliedUser['user_id']?>,<?=$appliedUser['job_id']?>)" id="chat_btn"
                                                   class=" position-relative  px-2 py-1 mx-2 text-decoration-none font-weight-bold "><i class="fa-solid fa-envelope" style="font-size: 47px;"></i></a>
                                                <?php
                                            }else{
                                                $newchat=$func->getAllNewChatesbyjobs_person($appliedUser['user_id'],$appliedUser['job_id']);
                                                ?>
                                                <!--                                                <div class="position-relative">-->
                                                <a class="chatenvelop position-relative  px-2 py-1 mx-2 text-decoration-none font-weight-bold " href="chat?touserid=<?=$appliedUser['user_id']?>&jobid=<?=$appliedUser['job_id']?>" >
                                                    <i class="fa-solid fa-envelope" style="font-size: 47px;"></i>

                                                    <?php
                                                    if(count($newchat)>0 ){
                                                        ?>
                                                        <span style="top:3px; right: 0; font-size: 10px; width: 14px!important; height: 20px!important;" class="bg-danger text-white position-absolute rounded-circle px-1"><?= count($newchat)?></span>
                                                        <?php
                                                    }
                                                    ?>
                                                </a>

                                                <!--                                                </div>-->
                                                <?php
                                            }
                                            ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
	
	   <?php
                                }
                                ?>
  </div>
  
      <h4 class="heading-10">3 Simple Steps</h4>

  <div class="steps w-container">
    <div class="columns-13 w-row">
      <div class="column-27 w-col w-col-4">
        <div class="headtitle">
          <div class="numbertitle">
            <div class="text-block-23 num one">1</div>
          </div>
         
		 
        </div>
		 <h4 class="heading-15">Shortlist</h4>
        <div class="text-block-24"><p>Take your time and review each profile carefully.</p><p>Compare quotes and look through their feedback to help choose the right tradesperson </p><p>You can shortlist up to 5 interested tradespeople, to continue to discuss your job.</p></div>
      </div>
      <div class="column-28 w-col w-col-4">
        <div class="headtitle">
          <div class="numbertitle">
            <div class="text-block-23 num">2</div>
          </div>
         
        </div>
		 <h4 class="heading-15">Hire</h4>
        <div class="text-block-24"><p>Once you&#x27;re sure on which tradesperson to pick, click on &#x27;Hire&#x27; and this will notify your chosen tradesperson that you&#x27;ve selected them.</p></div>
      </div>
      <div class="column-29 w-col w-col-4">
        <div class="headtitle">
          <div class="numbertitle">
            <div class="text-block-23 num">3</div>
          </div>
          
        </div>
		<h4 class="heading-15">Leave feedback</h4>
        <div class="text-block-24"><p>Leave feedback once your job is complete.</p><p>Share with other customers how your experience was.</p><p>Once you&#x27;ve left feedback, you will be eligible to win one of our amazing rewards.</p></div>
      </div>
    </div>
  </div>
  <div class="cta-note w-container">
    <h3 class="heading-13"><strong>Why hire professionals on Buildela</strong></h3>
    <div class="block-icon-w-text">
      <div class="icon-box"><i class="fa-solid fa-sterling-sign" style="color: #006bf5;"></i></div>
      <h5 class="heading-14"><strong class="bold-text-7">Free to use</strong></h5>
      <div class="text-block-22">You will never have to pay to use Buildela. Get cost estimates, contact pros, and even book the job-all for no cost.</div>
    </div>
  
    <div class="block-icon-w-text">
	  <div class="icon-box"><i class="fa-regular fa-user" style="color: #006bf5;"></i></div>
      <h5 class="heading-14"><strong class="bold-text-7">Compare prices side-by-side</strong></h5>
      <div class="text-block-22">You&#x27;ll know how much your project costs even before booking a pro.</div>
    </div>
   
    <div class="block-icon-w-text">
	 <div class="icon-box"><i class="fa-solid fa-check" style="color: #006bf5;"></i></div>
      <h5 class="heading-14"><strong class="bold-text-7">Hire with confidence</strong></h5>
      <div class="text-block-22">With access to customer reviews and the pros&#x27; work history, you&#x27;ll have all the info you need to make a hire.</div>
    </div>
  </div>





</div>





<!-- Modal for rating -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Leave feedback</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="rateUser">
                <div class="modal-body">
                    <input type="hidden" id="userid" value="">
                    <input type="hidden" id="jobid" value="">
                    <div class="rating-head">
                        <h4>Share your experience with the community to help them make better decisions.</h4>
                        <h5>Overall rating:</h5>
                    </div>
                    <div class="rating-feedback">
                        <input type="radio" name="rating" id="st1" value="5" />
                        <label for="st1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12.332" height="12" viewBox="0 0 12.332 12">
                                <path id="Shape_2_copy_10" data-name="Shape 2 copy 10" d="M786.835,5504l2.032,3.771,4.134.813-2.878,3.144.522,4.273-3.811-1.83-3.811,1.83.522-4.273-2.877-3.144,4.134-.812,2.032-3.771" transform="translate(-780.669 -5503.998)" fill="#ECECEC" />
                            </svg>
                        </label>
                        <input type="radio" name="rating" id="st2" value="4" />
                        <label for="st2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12.332" height="12" viewBox="0 0 12.332 12">
                                <path id="Shape_2_copy_10" data-name="Shape 2 copy 10" d="M786.835,5504l2.032,3.771,4.134.813-2.878,3.144.522,4.273-3.811-1.83-3.811,1.83.522-4.273-2.877-3.144,4.134-.812,2.032-3.771" transform="translate(-780.669 -5503.998)" fill="#ECECEC" />
                            </svg>
                        </label>
                        <input type="radio" name="rating" id="st3" value="3" />
                        <label for="st3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12.332" height="12" viewBox="0 0 12.332 12">
                                <path id="Shape_2_copy_10" data-name="Shape 2 copy 10" d="M786.835,5504l2.032,3.771,4.134.813-2.878,3.144.522,4.273-3.811-1.83-3.811,1.83.522-4.273-2.877-3.144,4.134-.812,2.032-3.771" transform="translate(-780.669 -5503.998)" fill="#ECECEC" />
                            </svg>
                        </label>
                        <input type="radio" name="rating" id="st4" value="2" />
                        <label for="st4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12.332" height="12" viewBox="0 0 12.332 12">
                                <path id="Shape_2_copy_10" data-name="Shape 2 copy 10" d="M786.835,5504l2.032,3.771,4.134.813-2.878,3.144.522,4.273-3.811-1.83-3.811,1.83.522-4.273-2.877-3.144,4.134-.812,2.032-3.771" transform="translate(-780.669 -5503.998)" fill="#ECECEC" />
                            </svg>
                        </label>
                        <input type="radio" name="rating" id="st5" value="1" />
                        <label for="st5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12.332" height="12" viewBox="0 0 12.332 12">
                                <path id="Shape_2_copy_10" data-name="Shape 2 copy 10" d="M786.835,5504l2.032,3.771,4.134.813-2.878,3.144.522,4.273-3.811-1.83-3.811,1.83.522-4.273-2.877-3.144,4.134-.812,2.032-3.771" transform="translate(-780.669 -5503.998)" fill="#ECECEC" />
                            </svg>
                        </label>
                    </div>
                    <div class="recommendation">
                        <h4>Would you recommend this tradeperson to others?</h4>
                        <div class="btn-group recommend" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio" id="rateyes" autocomplete="off" value="yes" checked>
                            <label for="rateyes">Yes</label>

                            <input type="radio" class="btn-check" name="btnradio" id="rateno" value="no" autocomplete="off">
                            <label for="rateno">No</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea id="message" rows="4" required class="form-control-lg form-control" placeholder="Your message"></textarea>
                    </div>

  
                </div>
   
	  
									 
										
   
  
		   
				
	  


  
		
  




						   
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="rateUser_btn" class="btn btn-primary">Submit</button>
										  
																			   
																								
															   
							 
                </div>
            </form>
        </div>
    </div>
</div>
																  
																 

<!--Modal for discription -->
<div class="modal fade" id="des_modal" tabindex="-1" role="dialog" aria-labelledby="desMOdal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
																																																																					   
									  
									
																				   
											 
																														   
																																																																					   
									  
									
																				   
											 
																														   
																																																																					   
									  
									
																				   
											 
																														   
																																																																					   
									  
									
																				   
											 
																														   
																																																																					   
									  
									
							  
            <div class="modal-header">
                <h5 class="modal-title" id="desMOdal">Update Description</h5>
							  

						  
											  
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
					   
            </div>
			  
		  
								 
																													 
												  
									   
										  
																				 
																								
															   
							 
					  
            <form id="des_form">
                <div class="modal-body">
                    <input type="hidden" value="<?=$jobs[0]['id']?>" id="jobid1">
                    <div class="form-group">
                        <label for="note">Enter Description</label>
                        <textarea rows="3" type="text"  class="form-control-lg form-control" required id="note">
                            </textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
				  
        </div>
    </div>
</div>

<!--Modal for add discription -->
<div class="modal fade" id="des_modal_add" tabindex="-1" role="dialog" aria-labelledby="des" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="des">Add description to post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add_description_job">
                <div class="modal-body">
                    <input type="hidden" value="<?=$jobs[0]['id']?>" id="jobid1">
                    <div class="form-group">
                        <label for="description">Enter Description</label>
                        <textarea rows="3" type="text"  class="form-control-lg form-control" required id="description">
                            </textarea>
                    </div>

								 

 
 
 
 
														  
									  
											   
										 
                </div>
				  
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
											   
									  
												
				  
											
																																																				
				
											   
									  
												
                </div>
            </form>
																																																										  
				
        </div>
		
				
		


								  
																				   
								   
										  
																				  
																																						   
    </div>
								   
								  
																								  
																											  
</div>
								   
								
		

    <?php include_once "includes/footer-no-cta.php"?>


    <script type="text/javascript">
    $('.ratemodalopen').click(function(){
        var userid = $(this).data('userid');
        var jobid = $(this).data('jobid');

        $('#userid').val(userid);
        $('#jobid').val(jobid);

    });
    document.getElementById('message').innerHTML = document.getElementById('message').innerHTML.trim();
    document.getElementById('note').innerHTML = document.getElementById('note').innerHTML.trim();
    document.getElementById('description').innerHTML = document.getElementById('description').innerHTML.trim();

</script>

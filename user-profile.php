<?php
require_once "serverside/functions.php";
// include_once "serverside/session.php";



if(isset($_GET['u_id'])){

}else{
    //header('Location: sign-in');
    ?>
    <script type="text/javascript">
        window.location.href="index";
    </script>
    <?php
    exit();
}


$func=new Functions();
$user=$func->UserInfo($_GET['u_id']);
$user=$user[0];
$date=date_create($user['pub_insurance_date']);
$date1=date_create($user['pro_insurance_date']);
$last_seen=$func->last_seen($_GET['u_id']);
$func->set_last_seen($_SESSION['user_id']);
$social_media_links=$func->getSocialMediaLinks($_GET['u_id']);
$checkStatus=$func->getApplyUserStatus($_SESSION['user_id'],$_GET['job_id']);
$totalAppliedUser=$func->getAllApplyUser($_GET['job_id']);
$checkdocs=$func->Checkverifeddocs($_GET['u_id']);
$createddate = date_format(date_create($user['create_date']), "Y");
$recommend = $func->getRecommendation($_GET['u_id']);



if(isset($_GET['job_id']) && isset($_GET['u_id'])){

    if($user['user_role']=='jobs_person'){
        $usersStatus=$func->getApplyUsersInfo($_GET['u_id'],$_GET['job_id']);
    }else{
        $usersStatus=$func->getjobposteduserinfo($_GET['job_id']);
    }

    if(!empty($usersStatus)){
        $userstatus=$usersStatus[0];
    }

}



$rateings=$func->getUserRatting($_GET['u_id']);
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

$count_rating=0;
if(count($rateings)>0){
    $count_rating=round($sumofStars/count($rateings),2);
}
$status="";
if($count_rating==1){
    $status="";

}else if($count_rating==2){
    $status="";

}else if($count_rating==3){
    $status="";

}else if($count_rating>3){
    $status="";
}
$imgch=$func->getMyGalleryimage($_GET['u_id']);
$videoch=$func->getMyGalleryvideo($_GET['u_id']);
$images=$func->getMyGallery($_GET['u_id']);
$mySkills=$func->getMySkills($_GET['u_id']);

include_once "includes/header.php";

//$appliedUser['user_id'] = $_GET['u_id'];
//$appliedUser['job_id'] = $_GET['job_id'];
$userinfo=$func->UserInfo($_GET['u_id']);
//    $rateings=$func->getUserRatting($appliedUser['user_id']);
    $checkChateStarted=$func->checkChatStarted($_GET['u_id'],$appliedUser['job_id']);
//	$appliedUser = $_GET['u_id']; // assuming the first user in the array
//$checkChateStarted = $func->checkChatStarted($appliedUser['user_id'], $appliedUser['job_id']);
$appliedUsers=$func->getSingleApplyUser($_GET['job_id'],$_GET['u_id']);
$postedjobnm=$func->getuserjobspostednm($_GET['u_id']);


//var_dump($postedjobnm);
$appliedUser = $appliedUsers[0];
//echo var_dump($imgch);echo var_dump($videoch);
//echo var_dump($checkdocs);
//echo $checkdocs[0]["COUNT(*)"];
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js" integrity="sha512-Ixzuzfxv1EqafeQlTCufWfaC6ful6WFqIz4G+dWvK0beHw0NVJwvCKSgafpy5gwNqKmgUfIBraVwkKI+Cz0SEQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>

.navigation.container {
box-shadow: 0px 0px 6px 2px rgba(0,0,0,.1) !important;
margin-bottom: 10px;
}

i.fa-solid.fa-user-check {
    margin-left: 2px;
}
span.nm-text {
    color: #006bf5;
}
.stats-info {
    color: #4c5152;
}
.w-layout-grid.brix---grid-2-columns-instagram {
    width: 100%;
    margin-bottom: 27px;
}
span.bg-secondary.rounded.p-2.text-white {
    display: block;

}
.user-profile-rating{

	color: grey;
}
.rate {
	color: var(--full-black);
    /*float: left;*/
    /*height: 46px;*/
    /*padding: 0 10px;*/
}
.rate:not(:checked) > input {
    position:absolute;
    top:-9999px;
}
.rate:not(:checked) > label {
    float:right;
    width:1em;
    overflow:hidden;
    white-space:nowrap;
    cursor:pointer;
    font-size:16px;
    color:#ccc;
}
.rate:not(:checked) > label:before {
    content: 'â˜… ';
}
.rate > input:checked ~ label {
    color: var(--btn-green) !important;    
}
.rate:not(:checked) > label:hover,
.rate:not(:checked) > label:hover ~ label {
    color: var(--btn-green) !important;  
}
.rate > input:checked + label:hover,
.rate > input:checked + label:hover ~ label,
.rate > input:checked ~ label:hover,
.rate > input:checked ~ label:hover ~ label,
.rate > label:hover ~ input:checked ~ label {
    color: var(--btn-green) !important;
}
.job-name-heading{
	font-family: Raleway-Black;
}
.rated-text{
	color: grey;

}
.discount-div{

	font-size: 18px;
	background-color: #e1faef;
	color: var(--btn-green);
	border-radius: 10px;
}
.user-profile-seoond-section-col-inner .h5{
	font-family: Raleway-Black;
	color: var(--full-black);
}
.feature-projects-heading , .reviews-heading{
	font-family: Raleway-Black;
	color: var(--full-black);
}
.reviews-text{
	
	font-size: 16px;
}
.exelent{
	color: var(--btn-green);

}

.rate1:not(:checked) > label {
    font-size:32px !important;
}
.reviews-225{
	font-size: 18px;
	font-family:Quicksand-Regular;
	color: grey;
}
.review-col-inner-1{
margin-bottom: 15px;
}
.fa-star-size{
	font-size: 12px !important;
	color: lightgrey !important;
}
.w-40{
	width: 40% !important;
}
.gap-grid{
	grid-gap: 5px !important;
}
.bg-btn-color{
	background-color: green !important;
}
img.avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;


}
.comment-main-wrapper{
	border-bottom: 2px solid #dedede;
}
.height-2{
	height:1px;
	border-width:0;
	color:#dedede;
	width: 100%;
	background-color:#dedede;
}
.static-star-color{
	color: var(--btn-green) !important;
	font-size: 12px !important;
}
.comment-name{

	font-size: 22px;
}
.comment-text , .comment-title , .comment-link a{
	
	font-size: 16px;
}

/*OLD CODE*/

.my-3 {
    display: inline-flex;
}
a.button-14.w-button {
    border-radius: 5px;
}
.button-14.shortlist {

    border-radius: 5px;
    background-color: #51cf7f;
    color: #fff;
}
.combine-feature7_content-sticky.custom {
    padding-top: 10px;
    padding-right: 10px;
    padding-left: 10px;
    border-style: solid;
    border-width: 2px;
    border-color: #007bff!important;
    background-color: #F2F7FF;
    box-shadow: 0 2px 7px 0 rgba(20, 20, 43, 0.06)!important;
    grid-row-gap: inherit;
    border-radius: 7px!important;
}
.combine-text-size-regular.shortlistp {
    font-size: .87rem;
    font-weight: 400;

    margin-bottom: 15px;
    padding-right: 30px;
    color: inherit;
}
i.fa-solid {
    color: #006bf5;
}
.infop-vblock {
    padding-bottom: 10px;

}
.infop-vblock a {
    color: inherit;
    font-size: 13px;
    font-weight: 600;
}
.infop-vblock a:hover {
    color: #007bff;
}
p.overinfo {
    margin-bottom: 0.2rem;
}
.profile-text {
    margin-bottom: 1em;
}
.overviewbox {
	margin-bottom: 1em;
}
.profile-text {
    color: #000000;
    text-align: left;
}
.divider-line {
    display: block;
    border-bottom: 2px solid #c7c7c7;
    margin-bottom: 15px;
}
.user-profile-seoond-section-col-inner .h5{

	color: var(--full-black);
}
.feature-projects-heading , .reviews-heading{

	color: var(--full-black);
}
.reviews-text{

	font-size: 16px;
}
.exelent{
	color: var(--btn-green);

}

.rate1:not(:checked) > label {
    font-size:32px !important;
}
.reviews-225 {
    font-size: 18px;
    color: black;
    font-family: Montserrat, sans-serif;
}
.review-col-inner-1{

}
.fa-star-size{
	font-size: 12px !important;
	color: lightgrey !important;
}
.w-40{
	width: 40% !important;
}
.gap-grid{
	grid-gap: 5px !important;
}


.comment-main-wrapper{
	border-bottom: 2px solid #dedede;
}
.height-2{
	height:1px;
	border-width:0;
	color:#dedede;
	width: 100%;
	background-color:#dedede;
}
.static-star-color{
	color: var(--btn-green) !important;
	font-size: 12px !important;
}
.comment-name{

	font-size: 22px;
}
.comment-text , .comment-title , .comment-link a{

	font-size: 16px;
}


a.text-black {
    color: #000;
}






/* 
  ##Device = Most of the Smartphones Mobiles (Portrait)
  ##Screen = B/w 320px to 479px
*/
.heading-jumbo.profile.userprofile {
    display: inline-block;
	padding-right:15px;
	
}
.rate {
    display: inline-block;
}

.btn-info {
    color: #fff;
    background-color: #51c57f;
    border: none;
    font-weight: 500;
}
span.bg-secondary.rounded.p-2.text-white {
    display: block;


}

.overviewbox {
    margin-bottom: 0em;
}

button#shortList {
    height: 50px;
}
a#chat_btn {

height: 47px;
    align-items: stretch;
    width: auto;
    text-align: center;
    cursor: pointer;
}
a#chat_btn:hover i.fa-solid{
  color: #1861D1;
}
.button-cr {
    display: flex;
    width: 100%;
  padding-bottom: 0;
    justify-content: space-between;
        align-items: center;
}
.button-cr button {
    width: 100%;
}
.button-cr button:hover{
  background-color: #1861d1;
}
.shortlist {
    text-align: left;
    font-weight: 500;
    line-height: 23px;
    font-size: 19px;
    margin-bottom: 12px;
}
img.pl-2.img-fluid {
    height: 50px;
}

a.text-black {
    color: #006bf5!important;
    
}
.exelent.h5.b {
    font-weight: 700;
}
a.text-black {
    font-size: 14px;
}

.f-avatar-image-2.profle {
    width: 100px;
	height:100px;
    border-radius: 7em;
}
a.text-black {
    font-size: 14px;
    padding-left: 10px;
}
i.fa-solid.fa-location-dot {
    padding-right: 3px;
    padding-left: 3px;
}
.heading-jumbo.profile.userprofile {
    display: inline-block;
    padding-right: 0px;
    margin-left: -2px!important;
    margin-top: 0;
    line-height: 0;
    font-size: 22px;
    font-family: 'DM Sans', sans-serif!important;
}
.rate.top {
    display: inline-block;
    top: -4px;
    position: relative;
    gap: 2px;
}
span.bg-secondary.rounded.p-2.text-white {

}
a.text-black {

    font-weight: 500;
}
.comment-name-title {
    display: inline-block;
    font-size: 1.3rem;
	    padding-left: 10px;
    font-weight: 700;
        margin-left: 50px;
    position: relative;
    top: -22px;
}
img.avatar {
    display: inline-block;
}

a.text-black:hover {
    text-decoration: underline!important;
    cursor: pointer;
}
/*NEW CSSS*/
.exelent.h5 {
    font-weight: 700;
    margin-bottom: 0px;
}
.reviews-225 {
    font-size: 14px;
    color: black;
    font-family: Montserrat, sans-serif;
}
.rate.rate1 {
    font-size: 20px;
    gap: 4px;
    display: flex;
    align-items: center;
}

.progress {
    height: 0.5rem!important;
}
.comment-name-des {
    display: inline-block;
    margin-right: 5px;
    margin-left: 5px;
    font-weight: 700;
}
.rating-and-name {
    display: inline-block;
    line-height: 17px;
}

.comment-date {


    float: right;
}
.comment-name-title {
    display: inline-block;
    font-size: 1rem;
    padding-left: 0px;
    font-weight: 600;
}
.recomeendby {
    display: flex;
    justify-content: space-between;
    margin-top: 50px;
    align-items: center;
    vertical-align: middle;
}

.recomeendby p {
    font-size: 18px;
    color: #FFC107;
}

.recomeendby p span {
    font-size: 20px;
    font-weight: bold;
}
@media (min-width: 320px) and (max-width: 480px) {
	.user-profile-six-section-wrapper-inner.pt-5.px-0.mx-4 {
    margin-right: 0px!important;
}
.row.mx-0.main-comment-wrapper .col-md-12 {
    padding-right: 0px;
}
.review-col-inner-1 {

}
  
    .infop-vblock {
    padding: 0px;
}
.heading-jumbo.profile.userprofile {
    margin-top: 0px;
    font-size: 20px;
}

img.f-avatar-image-2.profle {

    width: 60px;
    height: 60px;

}

a.text-black {
 color: #006bf5!important;
    font-weight: 500;
    padding-left: 10px;
    font-size: 14px;
}

.paragraph-9.profile {
    padding-top: 20px;

}

p.overinfo i.fa-solid.fa-location-dot {
    padding-right: 2px;
    padding-left: 3px;
}
.my-3 span a img {
    height: 30px!important;
    width: 30px!important;
}
img.avatar {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    margin-right: 13px;
    margin-left: 13px;
}
.comment-name.mt-3 {
    margin-top: 6px!important;
    font-size: 21px;
}
.comment-text.pt-4 {
    padding-top: 0.1rem!important;
}
.row.mx-0.justify-content-between.px-4 {
    padding-left: 17px!important;
    padding-right: 17px!important;
}
span.bg-secondary.rounded.p-2.text-white {
    display: block;
    margin-bottom: 7px;
    background: #ffffff!important;

}

.comment-name {
    font-size: 14px;
}
  .comment-name.mt-3 {
    display: block;
}
.rating-and-name {
    display: inline-flex;
}

	.comment-name-title {
    display: inline-block;
    font-size: 1rem!important;
	}

}

@media(max-width: 480px){
    .comment-name-title {
        margin-left: 81px;
    }
    .usersboxes {
        display: grid !important;
        grid-template-columns: repeat(2, 1fr) !important;
    }
    .infotextpub {
        font-size: 0.78rem !important;
    }
    
}
comment-text.pt-4 {
    margin-top: 10px;
}
span.bg-secondary.rounded.p-2.text-white {
    display: block;
    margin-bottom: 7px;
    color: #000000!important;
    font-size: 14px;
    margin-top: -11px;
    background: #fff!important;
}


.comment-text.pt-4 {
    margin-top: 0;
}
h6.hdpf {
    margin-top: 10px;
    margin-bottom: 15px;
}
ul.list-unstyled li {
    margin-bottom: 3px;
}
span.bg-primary.rounded.p-2.text-white {

    gap: 5px;
    background: #f0f0f0!important;

}
span.rating-number {
    color: #ffc107;
    padding-left: 4px;
    font-weight: 600;
    padding-right: 5px;
    font-size: 1.5rem;
    padding-top: 2.9px;
}


@media (min-width: 320px) and (max-width: 480px) {

button#shortList23 {
    color: #fff;
    margin-right: 20px;
}
.combine-text-size-regular.shortlistp,h5.shortlist,h5.shortlist,.combine-text-size-regular.shortlistp {
    text-align: center!important;
}
h5.shortlist,.combine-text-size-regular.shortlistp {
    width: 100%;
}


}

@media(min-width:768px){
    .w-layout-grid.brix---grid-2-columns-instagram {
    width: 90%;
    grid-template-columns: 1fr 1fr 1fr;
}
}

.w-layout-grid.brix---grid-2-columns-instagram > div, .brix---instagram-image {
    position: relative;
    padding-top: 75%;
}

.brix---instagram-image .brix---image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

video.brix---instagram-video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
.review-info {
    display: flex;
    align-items: flex-start;
    gap: 3px;
        justify-content: space-between;
    width: 100%;
}
.review-info .left {
    display: flex;
    align-items: flex-start;
    gap: 5px;
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

    width: 100%;
    height: 17vh;

}

.video-blocks video {

    width: 100%;
    height: 17vh;
    object-fit: cover;
    border-radius: 0!important;
    transition: transform 0.3s ease-in-out 0s, filter 0.3s ease 0s;

}
@media(max-wdith:480px){
  .image-blocks img,.video-blocks video{
    height: 13vh;
  }
  
}
.video-blocks video:hover,.image-blocks img:hover{

    filter: brightness(75%);
}

.total-counts {
    background-color: #F8F9FF;
    border-radius: 0!important;
    padding: 10px 7px;
    font-weight: 600;
    border: 1px solid rgb(237, 237, 237);
    border-top: 0;
}

.mklbItem.video-item {
    display: inline;
}

h6.vidblockcs , h6.imgblockcs {
    font-size: 14px;
    font-weight: 500;
    margin-top: 7px;
}
.row.main-comment-wrapper {
    display: none;
}
.load-more {
    background-color: #006BF5;
    display: inline-block;
    color: #fff;
    padding: 7px 12px;
    margin-bottom: 30px;
    font-size: 1rem;
    border-radius: 4px;
}
.load-more:hover{
  background-color: #0069D9;
  color: #fff;
}
.btn-bg-general {

    color: #fff;
}
.uui-testimonial11_rating-wrapper {
    margin-left: -5px;
}
.text-block-18.rv {
    padding-left: 5px;
}

.image-blocks a:not(:nth-of-type(1)) {
    display: none;
}









/* pager */
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
        padding-right: 6px!important;
        padding-left: 6px!important;
    }

}


.pl {
    padding-left: 21px;
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

ul.social-media {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
    position: relative;
    margin-bottom: 0;
    padding-left: 10px;
}
  ul.social-media li{
    position: relative;
    list-style: none;
    width: 80px;
    height: 80px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    transition: 0.5s;
    margin-bottom: 0;
  }
  ul.social-media li::before{
    content: "";
    position: absolute;
    inset: 30px;
    box-shadow: 0 0 0 10px var(--clr),
    0 0 0 20px #fff,
    0 0 0 22px var(--clr);
    transition: 0.5s;
  }
  ul.social-media li::after{
    content: "";
    position: absolute;
    inset: 0;
    background: #fff;
    transform: rotate(45deg);
    transition: 0.5s;

  }

  ul.social-media li a{
    position: relative;
    text-decoration: none;
    z-index: 10;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  ul.social-media li a i{
    font-size: 1.5rem;
    transition: 0.5s;
    color: var(--clr);
  }
  ul.social-media li a:hover i{
    transform: translateY(-25%);
  }
  ul.social-media li a span{
    position: absolute;
    font-size: 12px;
    color: var(--clr);
    opacity: 0;
    transition: 0.5s;
    transform: scale(0) translateY(50%);

  }
  ul.social-media li:hover a span{
    opacity: 1;
    transform: scale(1) translateY(100%);
  }

  /* effect 01 */
  ul.social-media li:hover::before{
    inset: 15px;

  }
  ul.social-media li:hover::after{
    inset: -10px;
  }
  ul.social-media li:hover a i,
  ul.social-media li:hover a span{
    filter: drop-shadow(0 0 20px var(--clr)) drop-shadow(0 0 40px var(--clr)) drop-shadow(0 0 60px var(--clr));
  }



  

</style>


<div class="w-container container-lg my-5">
 <div class="columns-12 w-row">
 <div class="backbloxk">
 
<?php
if ((isset($_GET['u_id'])) && (isset($_GET['job_id'])) && $_GET['usp'] == '2') {
?>
    <b><p><a class="text-black" href="#" onclick="history.back();"><i class="fa-solid fa-arrow-left"></i> Back to leads</a></p></b>
<?php
} elseif ((isset($_GET['u_id'])) && (isset($_GET['job_id'])) && ($jobs[0]['user_id'] == $_SESSION['user_id'])) {
?>
    <a href="my-posted-jobs-details?job_id=<?= $_GET['job_id'] ?>" class="btn-bg-general text-white text-center px-4 my-1 py-2 text-decoration-none font-weight-bold rounded">View other interested Tradespeople</a>
<?php
} elseif ((isset($_GET['u_id'])) && (isset($_GET['job_id']))) {
?>
    <b><p><a class="text-black" onclick="history.back()"><i class="fa-solid fa-arrow-left"></i> View other interested Tradespeople</a></p></b>
<?php
} elseif (isset($_GET['usp']) && $_GET['usp'] == '1') {
?>
    <b><p><a class="text-black" onclick="history.back()"><i class="fa-solid fa-arrow-left"></i> Back to profile</a></p></b>
<?php
} elseif ($_SESSION['user_role'] == 'jobs_person') {
?>
    <b><p><a class="text-black" onclick="history.back()"><i class="fa-solid fa-arrow-left"></i> Back to leads</a></p></b>
<?php
} else {
?>
    <b><p><a class="text-black" onclick="history.back()"><i class="fa-solid fa-arrow-left"></i> Back to previous page</a></p></b>
<?php
}
?>


 

 </div>

    
      <div class="w-col w-col-8 w-col-tiny-tiny-stack pr-lg-5">
        <div class="profile-head">
          <div class="row mx-0">
            <div class="col col-auto">  <?php
                                    if(empty($user['img_path']))
                                    {
                                        ?>
                                        <img loading="lazy" width="50" height="50" sizes="(max-width: 479px) 100vw, 150px" class="f-avatar-image-2 profle" src="images/avatar1.png" alt="no-image">
                                        <?php
                                    }else{
                                        $image=explode('/',$user['img_path'] );

                                        $img= $image[1].'/'.$image[2];
                                        ?>
                                        <img loading="lazy" width="50" height="50" sizes="(max-width: 479px) 100vw, 150px" class="f-avatar-image-2 profle" src="<?=$img?>" alt="no-image">
                                        <?php
                                    }
                                    ?></div>
            <div class="col col-8">
			  <div class="infop-vblock">
              <div class="heading-jumbo profile userprofile"><?=$user['trading_name']?>  <?php if((isset($_GET['u_id'])) && (isset($_GET['job_id'])) && $_GET['usp'] == '2'){?> <?=$user['fname']?><?php } ?></div>
              <div class="mb-1">
                                    <?php
                                    if(isset($userstatus) && $userstatus['status']!=0 ){
                                        ?>
                                        <span class="icons"> <a href="mailto:<?=$user['email']?>"><?=$user['email']?></a></span>
                                 
                                        <span class="icons"> <a href="tel:<?=$user['phone']?>"><?=$user['phone']?></a></span>
                                        <?php
                                    }if(!isset($_GET['job_id'] )){
                                        ?>
                                        <!--                                            <span class="icons">Contact details are hidden</span>-->
                                        <?php
                                    }
                                    ?>
                                </div>

              <div class="div-block-11">
			  
			     <div  class="font-weight-bold" style="display: flex; font-size:12px; gap:5px;">
                                    <?php
                                    if($last_seen=="Online"){
                                        ?>
                                        <div class=" p-1 bg-success border border-light rounded-circle" style="height: 10px;align-self: center;">
                                        </div>

                                        <?php
                                    }
                                    ?>
                                    <div><?=$last_seen?></div>
        </div>
								
		

	 </div>
	 <?php if($_SESSION['user_role']=='jobs_person' & $_GET['usp'] == '2'){
                            ?>
	 
	 	 	 <div class="stats-info"><span class="nm-text"><?=$postedjobnm[0]['count'];?></span> Jobs Posted</div>
    <div class="stats-info"> Joined Buildela <?=$createddate;?></div>
			      <?php
                                                }
                                                ?>
            </div>
			 </div>
          </div>
         <?php
$note = $user['note'];
if(strlen($note) > 498) {
    $note_part_one = substr($note, 0, 498);
    $note_part_two = substr($note, 498);
?>
<p class="paragraph-9 profile">
    <?= $note_part_one ?>
    <span id="moreText" style="display: none;"><?= $note_part_two ?></span>
    <a href="#" id="moreLink" onclick="showMore(event)"><span>▾</span> Show More</a>
</p>
<?php
} else {
    echo "<p class=\"paragraph-9 profile\">{$note}</p>";
}
?>

<script>
    function showMore(event) {
        event.preventDefault();
        var moreText = document.getElementById('moreText');
        var moreLink = document.getElementById('moreLink');

        if(moreText.style.display === "none") {
            moreText.style.display = "inline";
            moreLink.innerHTML = "<span>▴</span> Show Less";
        } else {
            moreText.style.display = "none";
            moreLink.innerHTML = "<span>▾</span> Show More";
        }
    }
</script>
        </div>
        <div class="divider-line col-12"></div>
        <div class="row mx-0 mb-3 usersboxes">
		<div class="overviewbox col-md-4">
            <?php if($user['user_role']=='jobs_person'){
                            ?>
		        <h6 class="hdpf"><b>Overview</b></h6>
		
                <?php
                    if(count($rateings)>0){

                        if((count($rateings)>=100)&&( $sumofStars/count($rateings)>=4.5)){
                            ?>
                            <p class="overinfo mobtexts"> <i class="fa-solid fa-medal"></i> Top Pro</div></p>
                            <?php
                        }
                    }
                    if($checkdocs[0]["COUNT(*)"] == 1){ 
                        ?>
                    
                        <p class="overinfo mobtexts"> <i class="fa-solid fa-user-check"></i> User Verified </p>
                        <?php
                    }
                    ?>			 
                    <p class="overinfo mobtexts"><i class="fa-solid fa-trophy" style="margin-right: 4px;"></i>
                    <?php
                        $hired = (int)$user['hired_counter'];
                        if ($hired > 0) {
                            echo 'Hired ' . $hired . ' Times';
                        } else {
                            echo 'Hired ' . $hired . ' Time';
                        }                        
                    ?>	
                    </p>

                    <p class="overinfo">  <i class="fa-solid fa-location-dot" style="margin-right: 4px;"></i> <?=$user['town']?></p>
                    <?php if($recommend!= false): ?>
                        <p class="overinfo">  <i class="fa-sharp fa-solid fa-thumbs-up" style="margin-right: 4px;"></i> Recommended <?= $recommend?> times</p>
                    <?php endif; ?>
            
         </div>
           

       
				<div class="col-md-4">									   
													                                   <?php
if(isset($user['pub_insurance']) & $user['pub_insurance'] !== "") {
	echo'	<h6 class="hdpf "><b>Insurance</b>‍</h6>';
    echo'<div class="mb-2 infotextpub mobtexts">';
	echo' <i class="fa-solid fa-circle-check public " style="margin-right: 4px;"></i> Public liability <br>';
    echo '<div class="infotextpub pl mobtexts">£' . $user['pub_insurance'] . '</div>';
    echo '<div class="infotextpub pl mobtexts">' . date("d/m/y", strtotime($user['pub_insurance_date'])) . '</div>';
    echo'</div>';
}
?>
		                         <?php

if(isset($user['pro_insurance']) & $user['pro_insurance'] !== "")	{
  echo'<div class="mb-2 infotextpub">';
		echo'<i class="fa-solid fa-circle-check public" style="margin-right: 4px;"></i> Professional indemnity  <br>';
    echo '<div class="infotextpub pl mobtexts">£' . $user['pro_insurance'] . '</div>';
    echo '<div class="infotextpub pl mobtexts">' . date("d/m/y", strtotime($user['pro_insurance_date'])) . '</div>';
    echo'</div>';
}
?>	
	</div>
  <div class="col-md-4">	
    <?php                 
if(isset($user['qualification']) & $user['qualification'] !== "") {
		echo'<h6 class="hdpf"><b>Qualifications</b>‍</h6>
			<ul class="list-unstyled">';
        $qualifications = explode(',', $user['qualification']);
	
        foreach ($qualifications as $qualification) {
            echo '<li class="infotextpub mobtexts"><i class="fa-solid fa-medal" style="margin-right: 4px;"></i> ' . htmlspecialchars(trim($qualification)) . '</li>';
        }
}
    ?>
</ul>

</div>											   
</div>										   
  

  
  
<div class="row mx-0 our-album-holder">
    <div class="divider-line col-12 mb-4"></div>
    <h5 class="col-12"><b>Our Albums</b></h5>
    <?php
    $imageCount = 0; // Counter for images
    $videoCount = 0; // Counter for videos
    
    // Check if there are any images
    $hasImages = !empty($images) && is_array($images);
    // Check if there are any videos
    $hasVideos = false;

    // Display the image section if there are images
    if ($hasImages) {
        echo '<div class="image-blocks col-6 col-lg-5">';
        if (isset($imgch)) {
            echo '<h6 class="imgblockcs">Images</h6>';
        }

        foreach ($images as $imgs) {
            $image = explode('/', $imgs['img_path']);
            $img = $image[1] . '/' . $image[2];

            if ($imgs['file_type'] == 'image' && $imageCount < 6) {
                $imageCount++; // Increment image count
                ?>
                <a href="<?=$img?>"><img class="w-block" sizes="(max-width: 479px) 100vw, (max-width: 767px) 43vw, (max-width: 991px) 42vw, (max-width: 1439px) 20vw, 204px" src="<?=$img?>" alt="no-feature-image"></a>
                <?php
            }
        }
        
        // Hide the image-blocks div if no images are uploaded
        if ($imageCount == 0) {
            echo '<style>.image-blocks { display: none; }</style>';
        } else {
            echo '<div class="total-counts">Total Images: ' . $imageCount . '</div>';
        }
        
        echo '</div>';
    }

    // Display the video section if there are videos
    if ($hasImages) {
        echo '<div class="video-blocks col-6 col-lg-5">';
        if (isset($videoch) && $videoch !== "") {
            echo '<h6 class="vidblockcs">Videos</h6>';
        }

        $currentVideo = 1; // Counter for current video

        foreach ($images as $index => $imgs) {
            $image = explode('/', $imgs['img_path']);
            $img = $image[1] . '/' . $image[2];

            if ($imgs['file_type'] == 'video' && $videoCount < 6) {
                $hasVideos = true; // Set hasVideos to true
                $videoCount++; // Increment video count
                $videoGalId = 'videoGal' . $videoCount; // Generate dynamic id

                ?>
                <a href="#<?=$videoGalId?>" class="openVideo">
                    <div data-type="video" class="" data-src="<?=$img?>" data-video-src="<?=$img?>">
                        <video class="w-block" poster="">
                            <source src="<?=$img?>#t=0.001" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </a>
                <div id="<?=$videoGalId?>" class="video-popup mfp-hide">
                    <video controls>
                        <source src="<?=$img?>#t=0.001" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <div class="video-counter">Video <?=$currentVideo?></div>
                </div>
                <?php
                
                $currentVideo++; // Increment current video counter
            }
        }
        
        // Hide the video-blocks div if no videos are uploaded
        if ($videoCount == 0) {
            echo '<style>.video-blocks { display: none; }</style>';
        } else {
            echo '<div class="total-counts">Total Videos: ' . $videoCount . '</div>';
        }
        
        echo '</div>';
    }

    // Hide the album section if no images or videos are uploaded
    if (!$hasImages && !$hasVideos) {
        echo '<style>.our-album-holder { none!important; }</style>';
    }
    ?>
    <div class="divider-line col-12 pt-3 mb-0 mt-3"></div>
</div>








      
		 
       <div class="my-3 d-flex align-items-center flex-wrap" style="margin-left: -15px;">
                        <ul class="social-media">
                            <?php
                            foreach ($social_media_links as $link){

                                if($link['social_type']=='Facebook'){
                                    ?>
                                    <li style="--clr: #4267B2;"><a target="_blank" href="<?=$link['link']?>"> <i class="fa-brands fa-facebook-f"></i><span>Facebook</span></a></li>
                                    <?php
                                }else if($link['social_type']=='Instagram'){
                                    ?>
                                    <li style="--clr: #833AB4;"><a target="_blank" href="<?=$link['link']?>"> <i class="fa-brands fa-instagram"></i><span>Instagram</span></a></li>
                                    <?php
                                }else if($link['social_type']=='Twitter'){
                                    ?>
                                    <li style="--clr: #1DA1F2;"><a target="_blank" href="<?=$link['link']?>"><i class="fa-brands fa-twitter"></i><span>Twitter</span></a></li>
                                    <?php
                                }else if($link['social_type']=='YouTube'){
                                    ?>
                                    <li style="--clr: #FF0000;"><a target="_blank" href="<?=$link['link']?>"><i class="fa-brands fa-youtube"></i><span>Youtube</span></a></li>
                                    <?php
                                }else if($link['social_type']=='LinkedIn'){
                                    ?>
                                    <li style="--clr: #0072b1;"><a target="_blank" href="<?=$link['link']?>"><i class="fa-brands fa-linkedin"></i><span>Linkedin</span></a></li>
                                    <?php
                                }
                            }
                            ?>

                        </ul>

                        
                        </div>
						
						 <div class="divider-line mb-4"></div>
  <h5><b>Customer Reviews</b></h5>
  <p class="reviews-text ">Check out how our customers rated this tradesperson for professionalism, responsiveness, and work quality.</p>
                                        
                           <div class="user-profile-four-section-wrapper">
                            <div class="user-profile-four-section-wrapper-inner">
                             
                                <div class="row mx-0">
                                    <div class="col-md-12">
                                        <div class="row mx-0 mt-3">
                                            <div class="col-md-5">
                                                
                                                <?php
                                                if($user['dbs_path']){
                                                    ?>
                                                    <br>
                                                    DBS Verified <i class="fa fa-check-circle-o"></i>
                                                    <?php
                                                }
                                                ?>

                                                <div class="review-col-inner-1">
												<div class="exelent h5"> Overall Rating</div>
                                                    <div class="row mx-0">
                                                        <?php
                                                        if(count($rateings)>0){
                                                            ?>
                                                            <div class="exelent h5 b"> <?= $status;?></div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="row mx-0">
                                                        <div class="uui-testimonial11_rating-wrapper <?php if (count($rateings) == 0) { echo 'no-rt'; } ?> ">
    <?php
    if (count($rateings) > 0) {
        $rating = round($sumofStars / count($rateings), 1);
        $fullStars = floor($rating);
        $decimalPart = $rating - $fullStars;
        
        // Display number
        echo "<span class='rating-number'>" . $rating . "</span>";
        
        // Display full stars
        for ($i = 0; $i < $fullStars; $i++) {
            echo "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='#FFC107' viewBox='0 0 18 18'><path d='M9,0L6.563,6.095L0,6.539l5.04,4.219l-1.594,6.352L9,13.617l5.555,3.492l-1.594-6.352L18,6.539l-6.563-0.444L9,0z'/></svg>";
        }
        
        // Display half star
        if ($decimalPart >= 0.1 && $decimalPart <= 0.9) {
            echo "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 18 18'><path d='M9,0L7.406,6.095L0,6.539l5.04,4.219L3.446,16.11L9,13.617V0z' fill='#FFC107'></path><path d='M9,0L10.594,6.095L18,6.539l-5.04,4.219L14.554,16.11L9,13.617V0z' fill='#808080'></path>
          </svg>";
          $fullStars++; // Increment full stars count to account for the half star
        }
        
        // Display remaining grey stars
        $remainingStars = 5 - $fullStars;
        for ($i = 0; $i < $remainingStars; $i++) {
            echo "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='#808080' viewBox='0 0 18 18'><path d='M9,0L6.563,6.095L0,6.539l5.04,4.219l-1.594,6.352L9,13.617l5.555,3.492l-1.594-6.352L18,6.539l-6.563-0.444L9,0z'/></svg>";
        }
    }
    ?>
    <div class="text-block-18 rv d-none <?php if (count($rateings) == 0) { echo 'no-rt'; } ?>">
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


                                                    </div>
                                                    <div class="row mx-0">
                                                        <div class="reviews-225">
														<?php
if (count($rateings) > 1) {
    echo count($rateings) . ' Reviews';
} else {
    echo count($rateings) . ' Review';
}
?></div>
                                                    </div>

                                                </div>

                                            </div>
                                            <?php
                                            if(count($rateings)>0){
                                                ?>
                                                <div class="col-md-7">
                                                    <div class="review-col-inner">
                                                        <div class="row mx-0 gap-grid align-items-center">
    <div class="d-flex align-items-center"><span style="width: 12px;display: inline-block;">5</span> <svg xmlns='http://www.w3.org/2000/svg' width="13"
            height="13" fill='lightgrey' viewBox='0 0 18 18'>
            <path
                d='M9,0L6.563,6.095L0,6.539l5.04,4.219l-1.594,6.352L9,13.617l5.555,3.492l-1.594-6.352L18,6.539l-6.563-0.444L9,0z' />
        </svg></div>
    <div class="progress w-40">
        <div class="progress-bar bg-btn-color" role="progressbar"
            style="width: <?= round(($fiveStars/ count($rateings)*100),1)?>%" aria-valuenow="75" aria-valuemin="0"
            aria-valuemax="100"></div>
    </div>
    <div>
        <?= round(($fiveStars/ count($rateings)*100),1)?> %
    </div>
</div>
<div class="row mx-0 gap-grid align-items-center">
    <div class="d-flex align-items-center"><span style="width: 12px;display: inline-block; margin-left: -1px;">4</span> <svg xmlns='http://www.w3.org/2000/svg' width="13"
            height="13" fill='lightgrey' viewBox='0 0 18 18'>
            <path
                d='M9,0L6.563,6.095L0,6.539l5.04,4.219l-1.594,6.352L9,13.617l5.555,3.492l-1.594-6.352L18,6.539l-6.563-0.444L9,0z' />
        </svg></div>
    <div class="progress w-40">
        <div class="progress-bar bg-btn-color" role="progressbar"
            style="width: <?= round(($fourStars/ count($rateings)*100),1)?>%" aria-valuenow="75" aria-valuemin="0"
            aria-valuemax="100"></div>
    </div>
    <div>
        <?= round(($fourStars/ count($rateings)*100),1)?> %
    </div>
</div>

<div class="row mx-0 gap-grid align-items-center">
    <div class="d-flex align-items-center"><span style="width: 12px;display: inline-block;">3</span> <svg xmlns='http://www.w3.org/2000/svg' width="13"
            height="13" fill='lightgrey' viewBox='0 0 18 18'>
            <path
                d='M9,0L6.563,6.095L0,6.539l5.04,4.219l-1.594,6.352L9,13.617l5.555,3.492l-1.594-6.352L18,6.539l-6.563-0.444L9,0z' />
        </svg></div>
    <div class="progress  w-40">
        <div class="progress-bar bg-btn-color" role="progressbar"
            style="width: <?= round(($threeStars/ count($rateings)*100),1)?>%" aria-valuenow="75" aria-valuemin="0"
            aria-valuemax="100"></div>
    </div>
    <div>
        <?= round(($threeStars/ count($rateings)*100),1)?> %
    </div>
</div>
<div class="row mx-0 gap-grid align-items-center">
    <div class="d-flex align-items-center"><span style="width: 12px;display: inline-block;">2</span> <svg xmlns='http://www.w3.org/2000/svg' width="13"
            height="13" fill='lightgrey' viewBox='0 0 18 18'>
            <path
                d='M9,0L6.563,6.095L0,6.539l5.04,4.219l-1.594,6.352L9,13.617l5.555,3.492l-1.594-6.352L18,6.539l-6.563-0.444L9,0z' />
        </svg></div>
    <div class="progress w-40">
        <div class="progress-bar bg-btn-color" role="progressbar"
            style="width: <?= round(($towStars/ count($rateings)*100),1)?>%" aria-valuenow="75" aria-valuemin="0"
            aria-valuemax="100"></div>
    </div>
    <div>
        <?= round(($towStars/ count($rateings)*100),1)?> %
    </div>
</div>
<div class="row gap-grid mx-0 align-items-center">
    <div class="d-flex align-items-center"><span style="width: 12px;display: inline-block; margin-left: 1px;">1</span> <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="lightgrey" viewBox="0 0 18 18" style="margin-left: -1px;">
            <path
                d='M9,0L6.563,6.095L0,6.539l5.04,4.219l-1.594,6.352L9,13.617l5.555,3.492l-1.594-6.352L18,6.539l-6.563-0.444L9,0z' />
        </svg></div>
    <div class="progress w-40">
        <div class="progress-bar bg-btn-color w-75"
            style="width: <?= round(($oneStars/ count($rateings)*100),1)?>% !important;" role="progressbar"
            aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div>
        <?= round(($oneStars/ count($rateings)*100),1)?> %
    </div>
</div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>

                                        </div>
                                    </div>
                                </div>
                                <!--                                    <div class="row mx-0 pt-4">-->
                                <!--                                        <div class="col-md-9">-->
                                <!--                                            <div class="reviews-text text-center">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</div>-->
                                <!--                                        </div>-->
                                <!--                                    </div>-->
                            </div>
                        </div>
						
                            <div class="user-profile-six-section-wrapper">
                            <div class=" user-profile-six-section-wrapper-inner pt-5 px-0 mx-4">

                                <?php
                                if(!empty($rateings)){
                                    foreach($rateings as $rate){
                                        $reply=$func->getreplyOfthisReview($rate['id']);
//                                        $jobs=$func->getSingleJob($rate['job_id']);
//                                        $user1=$func->getuserdetails($jobs[0]['user_id']);
                                        $user1=$func->getuserdetails($rate['from_user_id']);
                                        $date=explode(' ',$rate['send_date']);
                                        $date=$date[0];
                                        $date=date_create($date);
                                        ?>
                                        <div class="row mx-0 main-comment-wrapper">
                                            <div class="col-md-12">

                                                <div class="row  mx-0 justify-content-between ">
                                                    <div class="review-info">
                                                        <div class="left">
                                                        <?php
                                                        if(!empty($user1)){
                                                            if(empty($user1[0]['img_path']))
                                                            {
                                                                ?>
                                                                <img class="avatar" src="images/avatar1.png" alt="no-image">
                                                                <?php
                                                            }else{
                                                                $image=explode('/',$user1[0]['img_path'] );

                                                                $img= $image[1].'/'.$image[2];
                                                                ?>

                                                                <img class="avatar" src="<?=$img?>" alt="no-image">

                                                                <?php
                                                            }
                                                            ?>
														
                                                            <div class="comment-name-des"><?=$user1[0]['fname']?></div>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <img class="avatar" src="images/avatar1.png" alt="no-image">
                                                            <div class="comment-name mt-3">Unknown</div>
                                                            <?php
                                                        }
                                                        ?>
														         
														   <div class="rating-and-name">
                                        <div class="d-inline-block">
                                            <?php
                                            $rating = $rate['ratings'];
                                            $fullStars = floor($rating);
                                            $decimalPart = $rating - $fullStars;
                                            
                                            // Display full stars
                                            for ($i = 0; $i < $fullStars; $i++) {
                                                echo "<svg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='#FFC107' viewBox='0 0 18 18'><path d='M9,0L6.563,6.095L0,6.539l5.04,4.219l-1.594,6.352L9,13.617l5.555,3.492l-1.594-6.352L18,6.539l-6.563-0.444L9,0z'/></svg>";
                                            }
                                            
                                            // Display half star
                                            if ($decimalPart >= 0.1 && $decimalPart <= 0.9) {
                                                echo "<svg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 18 18'><path d='M9,0L7.406,6.095L0,6.539l5.04,4.219L3.446,16.11L9,13.617V0z' fill='#FFC107'></path><path d='M9,0L10.594,6.095L18,6.539l-5.04,4.219L14.554,16.11L9,13.617V0z' fill='#808080'></path></svg>";
                                                $fullStars++; // Increment full stars count to account for the half star
                                            }
                                            
                                            // Display remaining grey stars
                                            $remainingStars = 5 - $fullStars;
                                            for ($i = 0; $i < $remainingStars; $i++) {
                                                echo "<svg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='#808080' viewBox='0 0 18 18'><path d='M9,0L6.563,6.095L0,6.539l5.04,4.219l-1.594,6.352L9,13.617l5.555,3.492l-1.594-6.352L18,6.539l-6.563-0.444L9,0z'/></svg>";
                                            }
                                            ?>
                                            <!-- <i class="fa fa-shield">. Hired By Company Name</i> -->
                                        </div>
                                    </div>

                                                    </div>
                                                   <div class="right">
                                                        <div class="comment-date">
                                                        <?php echo date_format($date,"M-j-Y")?>
                                                    </div>
                                                    </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="row mx-0">
                                                    <div class="col-md-12">
													
                                                        <div class="comment-text pt-4 ">
															<div class="comment-name-title"><?=$rate['job_title']?></div>
														
                                                            <span class="bg-secondary rounded p-2 text-white"><?=$rate['message']; ?></span>
                                                        </div>
                                                        <div class="ml-2 " >
                                                            <?php
                                                            if(!empty($reply)){
                                                                ?>
                                                                <span class="bg-primary rounded p-2 text-white d-flex align-items-start"><i class="fa-solid fa-reply" style="transform: rotate(180deg);"></i> <?=$reply[0]['message']; ?></span>

                                                                <?php
                                                            }
                                                            ?>

                                                        </div>
                                                        <div class="mt-2">
                                                            <?php
                                                            if($_SESSION['user_id']==$_GET['u_id']){
                                                                if(count($reply)>0){
                                                                    ?>
<!--                                                                    <button class="m-1 btn btn-info update_btn" data-reply_message="--><?//=$reply[0]['message']; ?><!--" data-reply_id="--><?//=$reply[0]['id']; ?><!--"   data-toggle="modal" data-target="#updateModal">Edit</button>-->
<!--                                                                    <button class="m-1 btn btn-danger" onclick="deleteReply(<?//=$reply[0]['id'];?>//)" >Delete</button>-->

                                                                    <?php
                                                                }else{
                                                                    ?>
                                                                    <button class="m-1 btn btn-primary edit_btn border-0" data-feedback_id="<?=$rate['id']; ?>"   data-toggle="modal" data-target="#exampleModal">Reply</button>

                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </div>

                                                        <hr class="height-2">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <?php
                                    }}else{
                                    ?>
                                    <div style="padding: 5px;" class="container select_skill login_form">
                                        <p>This tradesperson currently has no reviews.</p>

                                    </div>
                                    <?php
                                }

                                ?>
                            </div>
                            <?php 
                                if(count($rateings) < 4){

                                }else {
                                    echo '<a href="" class="load-more">Load More</a>';
                                }
                            ?>
                            
                        </div>
							  <?php
                        }
                        ?>
                         
  
      </div>
	    <?php if($_SESSION['user_role']=='home_owner'){?>
      <div class="column-20 w-col w-col-4 w-col-tiny-tiny-stack pl-xl-5">
	  
	
	  
        <div class="combine-feature7_content-sticky custom">
          <h5 class="shortlist">Shortlist up to 5 interested tradespeople</h5>
          <div class="combine-text-size-regular shortlistp">Contact details will be exchanged between yourself and those whom you shortlist</div>
          <h5 class="shortlist">Check profiles, receive quotes.</h5>
          <div class="combine-text-size-regular shortlistp">Then hire 1 tradesperson to carry out your job</div>
        
		  <div class="button-cr">
		  
            <?php
                                            if($appliedUser['status']==0){
                                                ?>
                                                <button  onclick="shortList(<?=$appliedUser['user_id']?>,
                                                <?=$appliedUser['job_id']?>)" id="shortList<?=$appliedUser['user_id']?>" class="btn-bg-general text-white text-center px-2 py-2 text-decoration-none font-weight-bold rounded">Short list</button>
                                                <?php
                                            }else if($appliedUser['status']==1&&$appliedUser['worker_status']==0&&$appliedUser['employer_status']==0){
                                                ?>
                                                <button id="hire_btn" onclick="employerstartJob(<?=$appliedUser['user_id']?>,<?=$appliedUser['job_id']?>)" class="btn-bg-general
                                                text-white text-center px-4 py-2 text-decoration-none font-weight-bold rounded">Hire</button>

                                                <?php
                                            }else if($appliedUser['status']==1&&$appliedUser['worker_status']==0&&$appliedUser['employer_status']==1){
                                                ?>
                                                <button  class="btn-bg-general text-white text-center px-2 py-2 text-decoration-none font-weight-bold rounded">Wait for trademen's approval</button>
                                                <?php
                                            }else if($appliedUser['status']==1&&$appliedUser['worker_status']==1&&$appliedUser['employer_status']==1){
                                                ?>
                                                <button class="btn-bg-general text-white text-center px-2 py-2 text-decoration-none font-weight-bold rounded">Job inprocessing</button>
                                                <?php
                                            }else if($appliedUser['status']==2&&$appliedUser['worker_status']==1&&$appliedUser['employer_status']==1 && $appliedUser['rating']==0){
                                                ?>
                                                <button  class="ratemodalopen btn-bg-general text-white text-center px-4 py-2 text-decoration-none
                                                font-weight-bold rounded" data-toggle="modal" data-target="#exampleModal" data-userid = "<?=$appliedUser['user_id']?>" data-jobid="<?=$appliedUser['job_id']?>">Rate this user</button>

                                                <?php
                                            }else if($appliedUser['status']==2&&$appliedUser['worker_status']==1&&$appliedUser['employer_status']==1 && $appliedUser['rating']==1){
                                                ?>
                                                <button class="btn-bg-general text-white text-center px-2 py-2 text-decoration-none font-weight-bold rounded">Feedback left</button>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            if(empty($checkChateStarted)) {
                                                ?>
                                                <a onclick="startChat(<?=$appliedUser['user_id']?>,<?=$appliedUser['job_id']?>)" id="chat_btn"
                                                   class="chatenvelop position-relative text-decoration-none font-weight-bold rounded"><i class="fa-solid fa-envelope ml-2" style="font-size: 47px"></i></a>
                                                <?php
                                            }else{
                                                $newchat=$func->getAllNewChatesbyjobs_person($appliedUser['user_id'],$appliedUser['job_id']);
                                                ?>
                                                <!--                                                <div class="position-relative">-->
                                                <a class="chatenvelop position-relative  px-4 py-2 mx-2 text-decoration-none font-weight-bold rounded" href="chat?touserid=<?=$appliedUser['user_id']?>&jobid=<?=$appliedUser['job_id']?>" >
                                                    <i class="fa-solid fa-envelope ml-2" style="font-size: 47px"></i>

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
	
        <section class="combine-section_feature7">
          <div class="combine-padding-global">
            <div class="combine-container-large">
              <div class="combine-padding-section-medium">
                <div class="combine-feature7_component">
                  <div class="combine-feature7_content-sticky">
                    <a href="#" class="combine-button-icon w-inline-block"></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
	    <?php }?>
    </div>
	 </div>
  </div>


<!-- Modal for reply -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Give reply</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="replyToUser">
                <div class="modal-body">
                    <input type="hidden" id="feedback_id" value="">

                    <div class="form-group">
                        <textarea id="message" rows="4" required class="form-control-lg form-control" placeholder="Your message"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for update reply -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update reply</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="Updatereply">
                <div class="modal-body">
                    <input type="hidden" id="reply_id" value="">

                    <div class="form-group">
                        <textarea id="reply_message" rows="4" required class="form-control-lg form-control" placeholder="Your message"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!--<link href="css/mklb.css" rel="stylesheet" type="text/css">-->
<!--<script src="js/mklb.js"></script>-->

<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" integrity="sha512-ZKX+BvQihRJPA8CROKBhDNvoc2aDMOdAlcm7TUQY+35XYtrd3yh95QOOhsPDQY9QnKE0Wqag9y38OIgEvb88cA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<?php include_once "includes/footer-no-cta.php"?>
<script>
    $(".edit_btn").click(function (e){
        e.preventDefault();
        $("#feedback_id").val($(this).data("feedback_id"));
    });

    $(".update_btn").click(function (e){
        e.preventDefault();
        $("#reply_id").val($(this).data("reply_id"));
        $("#reply_message").val($(this).data("reply_message"));
    });


</script>

<script>
    lightbox.option({
      'maxWidth': '800px',
      'wrapAround': true
    })
</script>

    <script type="text/javascript">
    $('.ratemodalopen').click(function(){
        var userid = $(this).data('userid');
        var jobid = $(this).data('jobid');

        $('#userid').val(userid);
        $('#jobid').val(jobid);

    });
    document.getElementById('message').innerHTML = document.getElementById('message').innerHTML.trim();
    document.getElementById('note').innerHTML = document.getElementById('note').innerHTML.trim();
    // document.getElementById('description').innerHTML = document.getElementById('description').innerHTML.trim();


</script>




<script>
    $(function () {
		$(".main-comment-wrapper").slice(0, 3).show();
		$("body").on('click touchstart', '.load-more', function (e) {
			e.preventDefault();
			$(".main-comment-wrapper:hidden").slice(0, 3).slideDown();
			if ($(".main-comment-wrapper:hidden").length == 0) {
				$(".load-more").css('visibility', 'hidden');
			}
			$('html,body').animate({
				scrollTop: $(this).offset().top
			}, 1000);
		});
        if($(".main-comment-wrapper").length <= 3){
            $('.load-more').hide();
        }
	});
</script>

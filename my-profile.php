<?php
include_once "serverside/functions.php";
include_once "serverside/session.php";

function isMobile() {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    $mobile_agents = array(
        'Mobile', 'Android', 'Silk/', 'Kindle', 'BlackBerry', 'Opera Mini', 'Opera Mobi'
    );

    $is_mobile = false;

    foreach ($mobile_agents as $mobile_agent) {
        if (strpos($user_agent, $mobile_agent) !== false) {
            $is_mobile = true;
            break;
        }
    }

    return $is_mobile;
}

function isTabletOrDesktop() {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    $mobile_agents = array(
        'Mobile', 'Android', 'Silk/', 'Kindle', 'BlackBerry', 'Opera Mini', 'Opera Mobi'
    );

    $is_mobile = false;

    foreach ($mobile_agents as $mobile_agent) {
        if (strpos($user_agent, $mobile_agent) !== false) {
            $is_mobile = true;
            break;
        }
    }

    return !$is_mobile;
}
function sortByCategoryName($a, $b) {
    return strcmp($a['category_name'], $b['category_name']);
}


if ($_SESSION['user_role']=='jobs_person') {


}else
{
    ?>
    <script type="text/javascript">window.location.href="account-details";</script>
    <?php
    exit();
}

$func=new Functions();
$settings=$func->getSettings();
$stripe_public_key = $settings[0]['stripe_public_key'];
$stripe_private_key = $settings[0]['stripe_private_key'];

//if (isset($_GET['userid'])&&$_SESSION['user_type']==1) {
//    $user=$func->UserInfo($_GET['userid']);
//    $mainCategory=$func->mainCategory();
//    $Skills=$func->getMySkills($_GET['userid']);
//    $gallery=$func->getMyGallery($_GET['userid']);
//
//}else

if(isset($_SESSION['user_id'])){
    $user=$func->UserInfo($_SESSION['user_id']);
    $currency_symbol=$user[0]['currency_symbol'];
    $referraluser=$func->getMyRefferaluser($user[0]['to_referral_code']);
    $date=date_create($user[0]['pub_insurance_date']);
    $date1=date_create($user[0]['pro_insurance_date']);
    $mainCategory=$func->mainCategory();
    $Skills=$func->getMySkills($_SESSION['user_id']);
    $gallery=$func->getMyGallery($_SESSION['user_id']);
    $func->set_last_seen($_SESSION['user_id']);
    $last_seen=$func->last_seen($_SESSION['user_id']);
    $withdraws=$func->getMyWithdraw($_SESSION['user_id']);

    $func->updateSubscriptionStatus($_SESSION['user_id']);
    // $func->autoCharge($_SESSION['user_id']);
    $account_details=$func->getAccountDetails($_SESSION['user_id']);
    $social_media_links=$func->getSocialMediaLinks($_SESSION['user_id']);
    $set_notification=$func->getMyNotificationSetting($_SESSION['user_id']);

						 
}
usort($mainCategory, 'sortByCategoryName');
include_once "includes/header.php";
?>
  <link href="css/bootstrap.min.css?v=1.00" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
.body {
    overflow: auto;
    background-color: #eeeeee;
    background: linear-gradient(to right, #d8d6de, #fcfcfc, #d8d6de);
  background-position-x: 0%;
  background-position-y: 0%;
  background-size: auto;
background-size: 60% 100%;
background-size: 300% 100%;
background-position: center center;
}


button.General-blue-btn {
    background: #006bf5!important;
	color:#fff;
  border:0;
}
button.General-blue-btn:hover {
    background: #1861d1!important;
    color: #fff;
}

form.form-inlinex {
    margin-left: 10px;
    margin-right: auto;
}
button.profile-blue-btn {
    border: 1px solid #006bf5!important;
    border-radius: 5px!important;
    font-size: 12px;
    color: #006bf5;
    background: transparent;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 4px;
    padding: 4px 6px;
}
button.profile-blue-btn:hover{
  color: #fff;
  background: #1861d1;
}
.btn-info {
    color: #fff;
    background-color: #006bf5;
    border-color: #006bf5;
}
.my-profile-general-wrapper.bg-white {


    border-radius: 10px;
    padding: 1em 1em;
    
    margin-bottom: 2em;
}
.intro-header.cc-subpage.userprofile {
    min-height: 160px;

    border-radius: 6px;
    background-color: #ffffff !important;
    box-shadow: none;
    padding-top: 5px !important;
    padding-right: 15px !important;
    padding-left: 15px !important;
    padding-bottom: 5px !important;
    margin-bottom: 7px;
    border: 1px solid #e9eced;
}
nav.navbar.navbar-light.bg-light {

	  background-color: #ffffff !important;

padding-top: 19px !important;
padding-right: 15px !important;
padding-bottom: 5px !important;
margin-bottom: 7px;
}
.my-profile-side-bar-2 {

    border-radius: 20px;
    padding: 1em 1em;
    margin-bottom: 2em;
    border-color: #e9eced !important;
    background-color: #ffffff !important;

    padding: 15px;
    margin-bottom: 12px;
    border: 1px solid;
}
h3.my-profile.h3 {
        background: #ffffff!important;
    color: #000;
    width: fit-content;
    border-radius: 5px;
    padding: 0 0 7px;
    
    font-size: 1.3rem;
    font-weight: 600;
}


.hero-heading-center {
    padding: 15px 0px!important;
}
.badge {

    font-size: 90%;

}
@media (min-width: 320px) and (max-width: 480px) {


	.description-list {
    word-break: break-word;
}
.lastseenbx.p-2.font-weight-bold {
    display: inline-block;
}
	.dataTables_wrapper {
    position: relative;
    clear: both;
    overflow: scroll;
}
	
	h3.my-profile.h3 {
    display: inline-block;
}
	.my-profile-general-wrapper.bg-white {
    padding: 0.5em 0em;
	}
	.section.cc-home-wrap {
    padding-top: 10px;
	}
	
	.hero-heading-center {
    padding: 15px 15px;
}
	.intro-header.cc-subpage.userprofile {
    margin-top: 0px;
    margin-bottom: 0px;
    padding-top: 15px;
    padding-bottom: 0px;
	}
  .intro-header.cc-subpage.userprofile.my-profile {
    display: block;
}
.heading-jumbo.profile.my-profile {
    font-size: 2rem;
    text-align: center;
}
.intro-content {
    width: 100%;
}

.my-profile-image {
    margin-left: auto;
    margin-right: auto;
    width: 135px;
}
a.navmain-blue-btn.btn.text-decoration-none.text-white.text-center {

    margin: 0 0.2em 10px;
}
  
}
.lastseen {
    gap: 5px;
}
	h2.profile.animate__animated.animate__slideInDown {
    font-family: Montserrat, sans-serif;
}
.my-profile-general-wrapper.bg-white {


    border-radius: 20px;
    padding: 1em 1em;
	
	    margin-bottom: 2em;
}
.bds-check {
    color: gray;

	}
.description-list li{

	
}
.description-list li:empty {
    display: none;
}


button.profile-blue-btn.btn.text-center {
    float: right;
}
h6.description-list {
    color: gray;
    font-weight: 400;
}
.description-list li {


}
.list-heading.h5 {

    
    font-size: 1rem;
    font-weight: 700;

}

.h3.working-address {

    
    font-size: 14px;
    font-weight: 700;

}
.working-address span {
    
    font-size: 0.9rem;
}
form#updatePassword1 label {
    text-transform: capitalize;
    color: grey;
    
    font-size: 0.9rem;
}
form#updatePassword1 input {
    border: solid 1px #c9c9c9!important;
    
    font-size: 0.9rem;
    margin-bottom: 1rem;

    border-radius: 4px;
}
button.profile-blue-btn.password {
    font-size: 14px;
    padding: .375rem .75rem;
    color: #fff;
    background-color: #006bf5;
    font-weight: normal;
}
button.profile-blue-btn.password:hover{
  background-color: #1861d1;
}
.register-trade {
  background: #ffffff!important;
    color: #000;
    width: fit-content;
    border-radius: 5px;
    padding: 7px 0px;
    
    font-size: 1.3rem;
    font-weight: 600;
}

	
	form#questionform,form#uploadImages, form#questionform label,form#uploadImages label{
	   
	   font-size: 0.9rem;
	   text-transform:capitalize;
	}
	select#select_main_category {
    font-size: 1rem;
    border: solid 1px #c6c6c6 !important;
}
input#images {
    font-size: 0.9rem;
    border: solid #b6b6b6 1px !important;
}
button.main-btn.btn-block {
    background: #006bf5;
    color: #ffffff;
    border-radius: 10px;
    
}

a.navmain-blue-btn {
    border-color: #006BF5!important;
    margin: 0em 0.5em;
    border-radius: 10px;
    color: #006bf5!important;
    font-weight: 500;
    font-size: 0.95rem;
    margin-bottom: 13px;
    border-radius: 4px!important;

}
a.navmain-blue-btn:hover {
    background-color: #1861D1;
    color: #fff!important;
}
nav.navbar.navbar-light.bg-light {


    border-radius: 20px;
    padding: 1em 0em;
    
	
}
form.form-inlinex {

}
.avatar-upload .avatar-edit input + label:after {
    content: "\f040";
    font-family: 'FontAwesome';
    color: #006bf5;
    position: absolute;
    left: 0px;
    right: -3px;
    bottom: 10px;
    text-align: center;
    margin: auto;
    font-size: 16px;
}
/*profile image change css */
.avatar-upload {
  position: relative;
  max-width: 205px;
}
.avatar-upload .avatar-edit {
  position: absolute;
  right: 12px;
  z-index: 1;
  top: 10px;
}
.avatar-upload .avatar-edit input {
  display: none;
}
.avatar-upload .avatar-edit input + label {
  display: inline-block;
  width: 28px;
  height: 28px;
  margin-bottom: 0;
  border-radius: 100%;
  background: #FFFFFF;
  border: 1px solid transparent;
  box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
  cursor: pointer;
  font-weight: normal;
  transition: all 0.2s ease-in-out;
}
.avatar-upload .avatar-edit input + label:hover {
  background: #f1f1f1;
  border-color: #d6d6d6;
}
.avatar-upload .avatar-edit input + label:after {
  content: "\f040";
  font-family: 'FontAwesome';
  color: #757575;
  position: absolute;
  top: 0;
  left: 1px;
  right: 0;
  text-align: center;
  margin: auto;
}
.avatar-upload .avatar-preview {
  width: 140px;
  height: 140px;
  position: relative;
  border-radius: 100%;
  border: 6px solid #F8F8F8;
  box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
}
.avatar-upload .avatar-preview > div {
  width: 100%;
  height: 100%;
  border-radius: 100%;
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
}
.intro-header.cc-subpage.userprofile.my-profile {
    background: #fff;
    justify-content: inherit;
}
button.General-blue-btn.btn-block.text-decoration-none.text-white.text-center.rounded.p-2 {
    background: #17a2b8;
}
h3.my-profile.h3 {
    display: inline-block;
    font-family: inherit;
}

.my-profile-general-wrapper-inner.py-3 .row.mx-0 {
	width:100%
}
.register-trade {
    background: #ffffff!important;
    color: #000;
    width: fit-content;
    border-radius: 5px;
    padding: 7px 0px;
    
    font-size: 1.3rem;
    font-weight: 600;
}
p.red-text.my-profile {
    color: #d10a38;

    margin-bottom: 0px!important;
}

.mobile-only-view{
	display: none;
	
}

.navigation.container {
box-shadow: 0px 0px 6px 2px rgba(0,0,0,.1) !important;
}

@media (min-width: 320px) and (max-width: 480px) {
	.register-trade-list.p-3 li {
    text-align: left;
    clear: both;
    width: 100%;
    display: list-item;
}
	.register-trade.rounded.h3.px-3.py-2 {
    text-align: center;
    width: 100%;
}
	table.dataTable tbody th, table.dataTable tbody td {
    padding: 8px 10px;
    max-width: 30px!important;
    overflow: scroll;
}
	
.register-trade-list.p-3 li {
    text-align: left;
}
.desktop-only-view{
	display: none;
	
}
.mobile-only-view{
	display: block;
	
}
}
.mobile-only-view-text{
	text-align:center;
}
p.red-text.my-profile.mobile-only-view-text {
    padding: 0px 0px;
    text-align: left;

}

.section.cc-home-wrap {

    background-color: rgba(255, 255, 255, 0)!important;
}


.intro-header.cc-subpage.userprofile {

}

nav.navbar.navbar-light.bg-light {
border-radius: 6px;
border: 1px solid #e9eced;

}

.my-profile-general-wrapper.bg-white {
    border-color: #e9eced !important;
    background-color: #ffffff !important;
    box-shadow: none;
    padding: 15px;
    margin-bottom: 12px;
    border-radius: 6px;
    border: 1px solid #e9eced;
}
.my-profile-side-bar-2 {

    border-radius: 7px;

    box-shadow: ;

}
.row.mx-0.padding-top-3 {
    padding-top: 2em;
}
.register-trade-list.p-3 ol {
      /* display: inline-grid; */
    text-align: left;
    padding: 0px;
    width: 100%;
    padding-left: 26px;
}
button#copy_code {


    font-size: 14px;
    border-color: 
}
button#copy_code_link {
    height: 40px;
    font-size: 14px;
    font-weight: 500;
}
span#code {

    display: block;
    border: 1px dashed;
    padding: 6px 8px;
    border-radius: 4px;
    background-color: antiquewhite;
}
button.btn-sm.btn.btn-info {

}

.mt-1.details {
    width: 100%;
}

button#copy_profile_link {
    background: #006bf5;
    color: #fff;
}
button#copy_profile_link:hover {
    background: #006bf5;
    color: #000;
}
td.sorting_1 {
    max-width: 30px!important;
    width: 30px;
}
td.sorting_1 i {
    font-size: 20px;
}
i.fa-brands.fa-facebook {
    color: #3f67a9;
}


i.fa-brands.fa-twitter {
    color: #1da1f2;
}
i.fa-brands.fa-linkedin {
    color: #2797cf;
}
i.fa-brands.fa-youtube {
    color: #c41f24;
}
button#share-button {

    font-size: 14px;


    border-color: #006BF5!important;
}
.qualification {
    display: inline-flex;
    width: 100%;
    column-gap: 10px;
    margin-bottom: 15px;
}


button#copy_profile_share {
    background: #006bf5;
    color: #fff;
    font-size: 14px;
}
button#copy_profile_share:hover {
    background: #006bf5;

}
button#copy_code {
    margin-right: 10px;
    margin-left: 10px;
    border-color: #006BF5!important;

}

.register-trade-list ol {
    padding-left: 10px;
}

h5.publicin,h5.prolicin {
  font-size: 15px;

}
.row.justify-content-between .col-md-6.px-0 {
    padding: 10px!important;
}
.profile-info {
    margin-bottom: 20px;
}

.profile-info p {
    margin-bottom: 10px;
    font-size: 14px;
}
.profile-info p a {
    display: inline;
}
.profile-info p i {
    width: 16px;
}


.description-list ul {
    list-style: disc;
    padding-left: 20px;
    margin-bottom: 0;
}


	</style>
 <div class="section cc-home-wrap">
   <div class="w-container container-3 mb-0">
    <div class="intro-header cc-subpage userprofile my-profile">
	
					
					<div class="my-profile-image">
                        <div class="avatar-upload">
                            <div class="avatar-edit">
                                <input type="hidden" id="userId" value="<?=$user[0]['id']?>" name="">
                                <input type='file' id="imageUpload" oninput="uploadImg()"  accept=".png, .jpg, .jpeg" />
                                <label for="imageUpload"></label>
                            </div>
                            <div class="avatar-preview">
                                <?php

                                if(empty($user[0]['img_path']))
                                {
                                    ?>
                                    <div id="imagePreview" style="background-image: url('images/avatar1.png');"></div>
                                    <?php
                                }else{
                                    $image=explode('/',$user[0]['img_path'] );

                                    $img= $image[1].'/'.$image[2];
                                    ?>
                                    <div id="imagePreview" style="background-image: url('<?=$img?>');"></div>
                                    <?php
                                }
                                ?>

                            </div>
                        </div>
					</div>
					
					
        <div class="profile-img-box">  </div>
          <div class="intro-content">
        <div class="heading-jumbo profile my-profile"><?=$user[0]['trading_name']?><br></div>
		      <div  class=" lastseenbx p-2 font-weight-bold" >
             <div class="online-block">
			    <div class="lastseen" style="display: flex;">
			  <?php
                if($last_seen=="Online"){
                    ?>
                    <div class=" p-1 bg-success border border-light rounded-circle" style="height: 10px;align-self: center; color:grey;">
                    </div>

                    <?php
                }
                ?>
                <div class="lastseen"style="color:grey;"><?=$last_seen?></div></div>
            </div>
            </div>
      </div>
    </div>
    </div>
    <div class="w-container container-3 mb-0">
      <div class="motto-wrap"></div>
      <div class="profile-story-wrap">
        <section class="hero-heading-center wf-section">
          
		  <div class="my-profile-wrapper">
 	<div class="my-profile-inner">
        <div class="row mx-0">
            <div class="col-md-12 pr-0">
                <nav class="navbar navbar-light bg-light">
  <form class="form-inlinex">

                    <a class="navmain-blue-btn btn text-decoration-none text-white text-center " href="user-profile?u_id=<?=$user[0]['id']?>&usp=1">My Public profile </a>
                
              <a class="navmain-blue-btn btn text-decoration-none text-white text-center" href="chat">Inbox </a>
			  
                    <a class="navmain-blue-btn btn text-decoration-none text-white text-center " href="trademember-my-account">My Account </a>
             
                    <a class="navmain-blue-btn btn text-decoration-none text-white text-center " href="view_gallery">My Work Gallery</a>
               
<a class="navmain-blue-btn btn text-decoration-none text-white text-center" data-toggle="modal" data-target="#notification_modal">Notifications</a>
              
                    
           
  </form>
</nav>
            </div>
        </div>
 		<div class="row mx-0 padding-top-3">
 			<div class="col-md-8 pr-0 pr-md-3">
 				<div class="my-profile-general-wrapper bg-white">
				<button class="profile-blue-btn btn text-center" data-toggle="modal" data-target="#bio_modal"><i class="fa-solid fa-pencil"></i> Edit Bio</button>
                    <div class="my-profile-general-wrapper-inner">
                        <div class="row mx-0">
                        <div class=" col-md-12">
                            <h3 class="my-profile h3 ">
                            <?=$user[0]['trading_name']?>                          </h3>   

							   
                        </div>
                        <div class="col-md-4">
<div class="btn-col-inner">
     
  </div>
                        </div>
                        </div>
                    </div>
                    <div class="description-list">
                          <div class="profile-info">
                            <p><i class="fa-regular fa-user"></i> <?=$user[0]['fname']?> <?=$user[0]['lname']?></p>
                            <p><i class="fa-regular fa-envelope"></i> <?=$user[0]['email']?></p>
                            <p><i class="fa-solid fa-mobile-retro"></i> <?=$user[0]['phone']?></p>
                          </div>
                          
                        <div class="list-heading h5 ">We specialise in:</div>
                        <ul class="list-unstyled ">
                                                  <?php
                            foreach($Skills as $skill){
                                $main_name=$func->SingleMainCategory($skill['main_category']);

                                ?>

                                <li style="clear: both;"><?=$main_name[0]['category_name']?></li>
                                <?php
                            }
                            ?>  </ul>

                    </div>
                </div>
				<?php
if (isMobile()) {
?>
				<div class="my-profile-general-wrapper bg-white mobile-only-view">
                    <h3 class="my-profile h3">Select Your Trades</h3>
					<p class="red-text my-profile mobile-only-view-text">Registration Form</p>
                    <div class="register-trade-list p-3 ">
					
                        <ol>
						 <?php
                            foreach($Skills as $skill){
                            $main_name=$func->SingleMainCategory($skill['main_category']);
                            ?>
                            <li><?=$main_name[0]['category_name']?></li>
                            <?php
                            }
                            ?>
                        </ol>
                        <form id="questionform" class="">                                
                            <select class="form-control" id="select_main_category">
                                <option>Please Select</option>
                                <?php
                                                                
                                foreach($mainCategory as $main){
                                    if($main['id'] != 41){
                                        ?>
                                        <option value="<?=$main['id']?>"><?=$main['category_name']?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </form>

<!--                    <div class="take-quiz-general py-2 my-2"  >-->
                        <a class=" take-quiz-general pt-2 text-decoration-none" style="display: none" id="checkskill" type="button">
                            <span><i class="fa fa-plus" aria-hidden="true"></i></span>
                            Start Quiz
                        </a>
<!--                    </div>-->

                    </div>           
                </div>
				<?php
}
?>
				
				
                <div class="my-profile-general-wrapper bg-white">
				<button id="insurebt"  type="button" class="profile-blue-btn btn text-center" data-toggle="modal" data-target="#qualification_modal"><i class="fa-solid fa-pencil"></i> Change</button>
                    <div class="my-profile-general-wrapper-inner">
                        <div class="row mx-0">
                        <div class=" col-md-12">
                            <h3 class="my-profile h3">
                                Qualifications
                            </h3>
							
                                   
                        </div>
                    
                        </div>
                    </div>
                    <div class="description-list">
                     <ul class="list-unstyled">
    <?php
        $qualifications = explode(',', $user[0]['qualification']);
        foreach ($qualifications as $qualification) {
            echo '<li>' . htmlspecialchars(trim($qualification)) . '</li>';
        }
    ?>
</ul>

                    </div>
                </div>
                <div class="my-profile-general-wrapper bg-white">
				<button data-toggle="modal" data-target="#insurance_modal" class="profile-blue-btn btn text-center" href=""><i class="fa-solid fa-pencil"></i> Change</button>
                    <div class="my-profile-general-wrapper-inner">
                        <div class="row mx-0">
                            <div class=" col-md-12">
                                <div class="my-profile-general ">
                                    <h3 class="my-profile h3">Insurance</h3>  
									  
                                </div>    
                            </div>
                          
                        </div>
                        <div class="row mx-0">
                            <div class="col-md-6">
                                <div class="insurance-col-inner pt-4">
                                    <div class="description-list">
                                        <div class="list-heading h5 ">Public liability <br> insurance</div>
                                        <ul class="list-unstyled ">
                                           
                                <?php
if(isset($user[0]['pub_insurance']) & $user[0]['pub_insurance'] !== "") {
	echo'<li>Limit of cover</li>';
    echo '<li><?=$currency_symbol?>' . $user[0]['pub_insurance'] . '</li>';
    echo '<li>valid until: ' . date("j M Y", strtotime($user[0]['pub_insurance_date'])) . '</li>';
}
?>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="insurance-col-inner pt-4">
                                    <div class="description-list">
                                        <div class="list-heading h5 ">Professional indemnity <br> insurance</div>
                                        <ul class="list-unstyled ">
                                                 
                             <?php

if(isset($user[0]['pro_insurance']) & $user[0]['pro_insurance'] !== "")	{
	echo'<li>Limit of cover</li>';
    echo '<li><?=$currency_symbol?>' . $user[0]['pro_insurance'] . '</li>';
    echo '<li>valid until: ' . date("j M Y", strtotime($user[0]['pro_insurance_date'])) . '</li>';
}
?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="my-profile-general-wrapper bg-white">
				<button type="button" class="profile-blue-btn btn text-center" data-toggle="modal" data-target="#about_modal">
        <i class="fa-solid fa-pencil"></i> Change
                                    </button>
                    <div class="my-profile-general-wrapper-inner">
                        <div class="row mx-0">
                            <div class=" col-md-12">
                                <div class="my-profile-general ">
                                    <h3 class="my-profile h3">About yourself to customers</h3>
									
									
                                </div>
                            </div>
                           
                        </div>
                        <div class="row mx-0">
                            <div class="col-md-12">
                                <div class="insurance-col-inner pt-4">
                                    <?php
                                      $note = $user[0]['note'];
                                      if(strlen($note) > 498) {
                                        $note_part_one = substr($note, 0, 498);
                                        $note_part_two = substr($note, 498);
                                    ?>
                                    <div class="bds-check">
                                      <?= $note_part_one ?>
                                      <span id="moreText" style="display: none;"><?= $note_part_two ?></span>
                                      <a href="#" id="moreLink" onclick="showMore(event)"><span>▾</span> Show More</a>
                                      
                                      
                                    </div>
                                    <?php
                                      } else {
                                          echo "<div class=\"bds-check\">{$note}</div>";
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="my-profile-general-wrapper bg-white">
				    <button type="button" class="profile-blue-btn btn text-center" data-toggle="modal" data-target="#address_modal"><i class="fa-solid fa-pencil"></i> Change</button>
                    <div class="my-profile-general-wrapper-inner">
                        <div class="row mx-0">
                            <div class=" col-md-12">
                                <div class="my-profile-general ">
                                    <h3 class="my-profile h3">Working Area</h3>   									
                                </div>    
                            </div>
                            <div class=" col-md-6">
                                <div class="btn-col-inner">
                                <!-- Button trigger modal -->
                              
                                </div>
                            </div>
                        </div>
                        <div class="row mx-0">
                            <div class="col-md-6">
                               <div class="working-address-wrapper pt-4">
                                
									
									  <div class="working-address h3">Address
                                       <?php
                                        $temp=explode("__",$user[0]['work_address']);

                                       ?>
                                        <span class="d-block h6 pt-2"><?=$temp[0]." ".$temp[1].",".$user[0]['town']?></span>
                                    </div>
                                   <div class="working-address h3">Distance
                                       <span class="d-block h6 pt-2 text-uppercase"><?=$user[0]['distance']?> Miles</span>
                                   </div>
                                    <div class="working-address h3">Postcode 
                                        <span class="d-block h6 text-uppercase pt-2"><?=$user[0]['post_code']?></span>
                                    </div>
									
									
                               </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="my-profile-general-wrapper bg-white">
                    <div class="my-profile-general ">
                        <h3 class="my-profile h3"> Change Password</h3>
                    </div>
                            <!-- Change Password -->
                            <div class="form-group">
                                <form id="updatePassword1">
                                    <input type="hidden" id="up_id" value="<?=$user[0]['id']?>" name="">
                                   
                                    <input type="password" placeholder="Old Password" class="form-control form-control-lg" id="currentpass">

                                   
                                    <input type="password" placeholder="New Password" class="form-control form-control-lg" id="newpass">

                                    <input type="password" placeholder="Confirm Password" class="form-control form-control-lg" id="cofirmpass">
                                    <button type="submit" class="profile-blue-btn btn password">Change Password</button>
                                </form>
                            </div>

                </div>


<div class="my-profile-general-wrapper bg-white">
                 <div class="my-profile-general ">

						<h3 class="my-profile h3"> Social media account</h3>
                    </div>
                    <button type="button" class="General-blue-btn text-decoration-none text-white text-center rounded btn" data-toggle="modal" data-target="#social_media_modal">
                        Link social media accounts
                    </button>

                    <div class="my-3 row justify-content-center">

                        <?php
                        foreach ($social_media_links as $link){

                            if($link['social_type']=='Facebook'){
                                ?>
                                
                                <?php
                            }else if($link['social_type']=='Instagram'){
                                ?>
                                
                                <?php
                            }else if($link['social_type']=='Twitter'){
                                ?>
                                
                                <?php
                            }else if($link['social_type']=='YouTube'){
                                ?>
        
                                <?php
                            }else if($link['social_type']=='LinkedIn'){
                                ?>
                                
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <table  id="socialTable" class="table bg-white table-striped">
                        <thead>
                        <tr>
                            <th>Social media type</th>
                            <th>Link</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($social_media_links as $link){
                            ?>
                            <tr>
                                <td> <?php
$icon = '';
switch ($link['social_type']) {
    case 'Facebook':
        $icon = 'fa-facebook';
        break;
    case 'Instagram':
        $icon = 'fa-instagram';
        break;
    case 'Twitter':
        $icon = 'fa-twitter';
        break;
    case 'YouTube':
        $icon = 'fa-youtube';
        break;
    case 'LinkedIn':
        $icon = 'fa-linkedin';
        break;
}
if ($icon !== '') {
    echo '<i class="fa-brands ' . $icon . '"></i>';
}
?></td>
                                <td><?=$link['link']?></td>
                                <td><i class="fa-regular fa-trash-can btn btn-danger" onclick="deleteSocialAccount(`<?=$link['id']?>`)"></i></td>
                            </tr>

                            <?php
                        }
                        ?>
                        </tbody>

                    </table>

                </div>
            
 			</div>
 			<div class="col-md-4 pr-0">
 				<div class="mb-3">

                <button id="copy_profile_share" class="General-blue-btn btn-block text-decoration-none text-white text-center rounded px-3 py-2"  >Share profile link</button>
				  </div>
							<?php
if (isTabletOrDesktop()) {
?>
				
                <div class="my-profile-side-bar-2 bg-white desktop-only-view">
                    <div class="register-trade rounded h3 pb-2">Select Your Trades</div>
					<p class="red-text my-profile">Registration Form</p>
                    <div class="register-trade-list py-3 ">
					
                        <ol>
						 <?php
                            foreach($Skills as $skill){
                            $main_name=$func->SingleMainCategory($skill['main_category']);
                            ?>
                            <li style="clear: both;"><?=$main_name[0]['category_name']?><i style="float: right;" class="fa-regular fa-trash-can btn btn-danger" onclick="deleteProfileMainCat(`<?php echo $skill['main_category'];?>`,`<?php echo $_SESSION['user_id'];?>`)"></i></li>
                            
                            <?php
                            }
                            ?>
                        </ol>

                        <form id="questionform" class="">
                            <label>Select Skills</label>
                            <select class="form-control" id="select_main_category">
                                <option>Please Select</option>
                                <?php

                                foreach($mainCategory as $main){
                                    if($main['id'] != 41){
                                        ?>
                                        <option value="<?=$main['id']?>"><?=$main['category_name']?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </form>

<!--                        <div class="take-quiz-general py-2 my-2"  >-->
                        <a class=" take-quiz-general pt-2 text-decoration-none" style="display: none" id="checkskill" type="button">
                            <span><i class="fa fa-plus" aria-hidden="true"></i></span>
                            Start Quiz
                        </a>
<!--                        </div>-->

                    </div>           
                </div>
        
				<?php
}
?>
						<div class="my-profile-side-bar-2 bg-white">
                    <div class="register-trade rounded h3 pb-2">Your Referral Code</div>
										<p class="red-text my-profile mobile-only-view-text">Earn <?=$currency_symbol?>3 per referral</p>
                    <div class="register-trade-list py-3 d-flex align-items-center flex-wrap">
                   <span style="color: black" class="text-center" id="code"><?=$user[0]['to_referral_code']?></span>
                    
                        <button class="btn btn-outline-primary" id="copy_code">Copy Code</button>
                      
                        <button class="btn btn-outline-primary" id="share-button">Share</button>
                        

                    

                    </div>           
                </div>
				
			
				
				
				
				
                <div class="my-profile-side-bar-2 bg-white ">
                    <div class="register-trade rounded h3 pb-2">Your Referral Users</div>
                  
                    <table  id="userTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Subscription Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($referraluser as $ref_user){
                            ?>
                            <tr>
                                <td><?=$ref_user['fname']?></td>
                                <td>
                                    <?php
                                    if($ref_user['subscription_status']==1){
                                        ?>
                                        <span class="badge badge-success">Active</span>
                                        <?php
                                    }else{
                                        ?>
                                        <span class="badge badge-danger">Inactive</span>
                                        <?php
                                    }
                                    ?>
                                </td>
                            </tr>

                            <?php
                        }
                        ?>
                        </tbody>

                    </table>
                </div>
				
				
				 <div class="my-profile-side-bar-2 bg-white ">
                    <div class="register-trade rounded h3 pb-2">Reward Balance </div>
                
                    <h3><?=$currency_symbol?><?=number_format($user[0]['balance'],2)?></h3>
                   
					<div class="row justify-content-between mx-0">

                                                        <?php
                        if(count($account_details)>0){

                            if($user[0]['balance']){
                                ?>
                                <button class="General-blue-btn btn-sm btn btn-outline-primary" id="withdraw"  onclick="withdraw(`<?=$_SESSION['user_id']?>`,`<?=$user[0]['balance']?>`)">Withdraw</button>
                                <?php
                            }
                            ?>

                            <button type="button" class="General-blue-btn btn-sm btn btn-outline-primary"
                                    data-toggle="modal" data-target="#update_account_details">Update Account Details </button>

                            <div class="mt-1 details">
                                <label class="d-block">Account Name: <span><?=$account_details[0]['account_name']?></span> </label>
                                <label class="d-block">Account Number: <span><?=$account_details[0]['account_number']?> </span></label>
                                <label class="d-block">Sort Code: <span><?=$account_details[0]['sort_code']?></span></label>
                                <label class="d-block">Date Card Added: <span><?=date('d-M-Y',strtotime($account_details[0]['create_date']))?></span></label>

                            </div>

                            <?php
                        }else{
                            ?>
                            <button type="button" class="btn-sm btn btn-primary border-0" data-toggle="modal" data-target="#add_account_details">Add Account Details </button>

                            <?php
                        }
                        ?>

                                                </div>
                </div>


 <div class="my-profile-side-bar-2 bg-white ">
                    <div class="register-trade rounded h3 pb-2">Your withdraw requests</div>
          
                    <table  id="withdrawTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($withdraws as $withdraw){
                            ?>
                            <tr>
                                <td><?=$withdraw['amount']?></td>
                                <td>
                                    <span class="badge badge-success">
                                    <?php
                                    if($withdraw['status']==1){
                                        ?>
                                        Approve
                                        <?php
                                    }else if($withdraw['status']==2){
                                        ?>
                                       Reject
                                        <?php
                                    }else{
                                        ?>
                                        Pending
                                        <?php
                                    }
                                    ?>
                                        </span>
                                        
                                </td>
                                <td><?=$withdraw['withdraw_date']?></td>
                            </tr>

                            <?php
                        }
                        ?>
                        </tbody>

                    </table>
                </div>
				
 			</div>
 		</div>
 	</div>
 </div>
		  
		      <a class="navmain-blue-btn btn text-decoration-none text-white text-center " onclick="deleteProfile(<?=$user[0]['id']?>)"><i class="fa-regular fa-trash-can"></i> Delete Account</a>
		  
        </section>
      </div>
    </div>
  </div>





<!--Modal for update bio-->
<div class="modal fade" id="bio_modal" tabindex="-1" role="dialog" aria-labelledby="demo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="demo">Update Bio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="bio_form">
                <input id="isphoneverifiy" value="1" type="hidden">
                <div class="modal-body">
                    <input type="hidden" value="<?=$user[0]['id']?>" id="u1_id">
                    <div class="form-group">
                        <label for="qualification">Enter trading name:</label>
                        <input type="text"  class="form-control"  required id="trading_name" value="<?=$user[0]['trading_name']?>" readonly>
                    </div>
					
					<div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text"  class="form-control"  required id="email" value="<?=$user[0]['email']?>" >
                    </div>
                    <div class="form-group">
                        <label for="qualification">Enter first name:</label>
                        <input type="text"  class="form-control"  required id="fname" value="<?=$user[0]['fname']?>" >
                    </div>
                    <div class="form-group">
                        <label for="qualification">Enter last name:</label>
                        <input type="text"  class="form-control"  required id="lname" value="<?=$user[0]['lname']?>" >
                    </div>
                    <input id="old_phone" type="hidden" value="<?=$user[0]['phone']?>">
                    <div class="form-group">
                        <label for="qualification">Enter phone number:</label>
                        <input type="text"  class="form-control"  required id="phone" value="<?=$user[0]['phone']?>" >
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="bio_btn" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--verifiy phone modal-->
<div class="modal fade" id="verifiymodal" tabindex="-1" role="dialog" aria-labelledby="example1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="example1">Verify your mobile number</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="verifiy_phone">
                <div class="modal-body">
                    <p class="my-2 text-center">We send a verification code on your mobile number</p>
                    <input value="" type="hidden" id="verification_phone">
                    <div class="form-group">
                        <label for="verification_code">Enter verification code:</label>
                        <input type="text" value="" class="form-control" required id="verification_code" >
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="verifiy_btn" class="btn btn-primary">Verify</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Modal for inter insurance-->
<div class="modal fade" id="insurance_modal" tabindex="-1" role="dialog" aria-labelledby="insuranceModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-1" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="insuranceModal">Update Insurance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="insurance_form">
                <div class="modal-body">
                    <input type="hidden" value="<?=$user[0]['id']?>" id="u00_id">
                    <div class="row justify-content-between">
                        <div class="col-md-6 px-0">
                            <h5 class="publicin">Public liability <br> insurance</h5>
                            <div class="form-group">
                                <label for="pub_insurance">Limit of cover <?=$currency_symbol?></label>
                                <input type="text" value="<?=$user[0]['pub_insurance']?>" class="form-control" id="pub_insurance"  >
                            </div>
                            <div class="form-group">
                                <label for="pub_insurance_date">Valid until</label>
                                <input type="date" value="<?=$user[0]['pub_insurance_date']?>" class="form-control" id="pub_insurance_date">
                            </div>

                        </div>
                        <div class="col-md-6 px-0">
                            <h5 class="prolicin">Professional indemnity <br> insurance</h5>
                            <div class="form-group">
                                <label for="pro_insurance">Limit of cover <?=$currency_symbol?></label>
                                <input type="text" value="<?=$user[0]['pro_insurance']?>" class="form-control" id="pro_insurance" >
                            </div>
                            <div class="form-group">
                                <label for="pro_insurance_date">Valid until</label>
                                <input type="date" value="<?=$user[0]['pro_insurance_date']?>" class="form-control" id="pro_insurance_date" >
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="insurance_btn" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Modal for inter qualification-->
<div class="modal fade" id="qualification_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Qualifications</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="qualification_form">
                <div class="modal-body">
                    <input type="hidden" value="<?=$user[0]['id']?>" id="u_id">
                    <div class="form-group">
                        <label for="qualifications">Enter Your Qualifications</label>
                        <div id="qualifications">
                            <div class="qualification">
                                <input type="text" class="form-control" required="" name="qualification[]">
                                <button type="button" class="remove-qualification btn btn-danger">-</button>
                            </div>
                        </div>
                        <button type="button" class="add-qualification btn btn-success">Add Qualification</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>

          
        </div>
    </div>
</div>

<!--Modal for inter about your self-->
<div class="modal fade" id="about_modal" tabindex="-1" role="dialog" aria-labelledby="aboutModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aboutModal">Introduce yourself to customers</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="about_form">
                <div class="modal-body">
                    <input type="hidden" value="<?=$user[0]['id']?>" id="u0_id">
                    <div class="form-group">
                        <label for="note">Enter Your Introduction</label>
                        <textarea rows="7" type="text" class="form-control" required id="note" >
 <?=$user[0]['note']?>   
                        </textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Modal Social media -->
<div class="modal fade" id="social_media_modal" tabindex="-1" role="dialog" aria-labelledby="example_social_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="example_social_modal">Link Your Social Media</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="social_media_link">
                <div class="modal-body">
                    <input type="hidden"  value="<?=$user[0]['id']?>" id="uuuu_id">
                    <div class="form-group">
                        <label for="qualification">Select social media</label>
                        <select class="form-control" id="social_type">

                            <option value="Facebook" >Facebook</option>
                            <option value="Instagram" >Instagram</option>
                            <option value="Twitter" >Twitter</option>
                            <option value="YouTube" >YouTube</option>
                            <option value="LinkedIn" >LinkedIn</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="qualification">Enter link</label>
                        <input type="text" placeholder="https://google.com/" class="form-control" id="link">
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

<!--Modal for DBS-->
<div class="modal fade" id="dbs_modal" tabindex="-1" role="dialog" aria-labelledby="example_dbs_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="example_dbs_modal">Update DBS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="dbs_form">
                <div class="modal-body">
                    <input type="hidden" value="<?=$user[0]['id']?>" id="uu_id">
                    <div class="form-group">
                        <label for="qualification">Upload Your DBS</label>
                        <input type="file" class="form-control" id="dbs" accept=".png, .jpg, .jpeg">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Modal for Address-->
<div class="modal fade" id="address_modal" tabindex="-1" role="dialog" aria-labelledby="example_address_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="example_address_modal">Edit Working Area</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="address_form">
                <div class="modal-body">
                    <input type="hidden" value="<?=$user[0]['id']?>" id="uuu_id">
                    <?php
                    $temp=explode("__",$user[0]['work_address']);

                    ?>
                    <div class="form-group">
                        <label for="work_address">First Line</label>
                        <input type="text" class="form-control" value="<?=$temp[0]?>" id="work_address" required placeholder="First Line">
                    </div>
                    <div class="form-group">
                        <label for="work_address1">Second Line</label>
                        <input type="text" class="form-control" value="<?=$temp[1]?>" id="work_address1" placeholder="Last Name">
                    </div>
                    <div class="form-group">
                        <label for="town">City</label>
                        <input type="text" class="form-control" value="<?=$user[0]['town']?>" id="town" required placeholder="City">
                    </div>
                    <div class="form-group">
                        <label for="post_code">
                            <?php
                            if($user[0]['country'] == "America" || $user[0]['country']=="Canada"){
                                ?>
                                Zip Code
                                <?php

                            }else
                            {
                                ?>
                                Post Code
                                <?php

                            }
                            ?>
                        </label>
                        <input type="text" class="form-control" value="<?=$user[0]['post_code']?>" id="post_code" required placeholder="">
                    </div>
                    <div class="form-group ">
                        <label for="distance">What is the maximum distance you are willing to travel for work</label>
                        <select class="form-control form-control-lg" id="distance">
                            <option>Please Select</option>
                            <option value="5">5 miles</option>
                            <option value="10">10 miles</option>
                            <option value="15">15 miles</option>
                            <option value="20">20 miles</option>
                            <option value="25">25 miles</option>
                            <option value="30">30 miles</option>
                            <option value="35">35 miles</option>
                            <option value="40">40 miles</option>
                            <option value="45">45 miles</option>
                            <option value="50">50 miles</option>
                            <option value="55">55 miles</option>
                            <option value="60">60 miles</option>
                            <option value="65">65 miles</option>
                            <option value="70">70 miles</option>
                            <option value="75">75 miles</option>
                            <option value="80">80 miles</option>
                            <option value="85">85 miles</option>
                            <option value="90">90 miles</option>
                            <option value="95">95 miles</option>
                            <option value="100">100 miles</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--add account details-->
<div class="modal fade" id="add_account_details" tabindex="-1" role="dialog" aria-labelledby="example" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="example">Add account details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add_account_details">
                <p class="mt-2 text-center p-1 "><strong>NOTE: </strong> Please ensure that your bank details are correct as we will not be held responsible for incorrect details, neither will we issue a second payment.</p>
                <div class="modal-body">
                    <input type="hidden" value="<?=$user[0]['id']?>" id="account_user_id">
					<div class="form-group">
                        <label for="account_number">Enter name on card: </label>
                        <input type="text" class="form-control" required id="account_name" >
                    </div>
                    <div class="form-group">
                        <label for="account_number">Enter account number:</label>
                        <input type="text" class="form-control" required id="account_number" >
                    </div>
                   
                    <div class="form-group">
                        <label for="account_number">Enter sort code:</label>
                        <input type="text" class="form-control" required id="sort_code" >
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

<!--update account details-->
<div class="modal fade" id="update_account_details" tabindex="-1" role="dialog" aria-labelledby="example1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="example1">Update account details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="updateAccount_details">
                <p class="mt-2 text-center p-1 "><strong>NOTE: </strong> Please ensure that your bank details are correct as we will not be held responsible for incorrect details, neither will we issue a second payment.</p>
                <div class="modal-body">
                    <input type="hidden" value="<?=$user[0]['id']?>" id="update_account_user_id">
                    <input type="hidden" value="<?=$account_details[0]['id']?>" id="update_account_id">
					
					 <div class="form-group">
                        <label for="update_account_name">Enter name on card: </label>
                        <input type="text" value="<?=$account_details[0]['account_name']?>" class="form-control" required id="update_account_name" >
                    </div>
                    <div class="form-group">
                        <label for="update_account_number">Enter account number:</label>
                        <input type="text" value="<?=$account_details[0]['account_number']?>" class="form-control" required id="update_account_number" >
                    </div>
                   
                    <div class="form-group">
                        <label for="update_account_number">Enter sort code:</label>
                        <input type="text" value="<?=$account_details[0]['sort_code']?>" class="form-control" required id="update_sort_code" >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--manage notification-->
<div class="modal fade" id="notification_modal" tabindex="-1" role="dialog" aria-labelledby="example2" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="example2">Manage notifications</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="update_notification">
                <input value="<?=$_SESSION['user_id']?>" id="user" type="hidden">
               <div class="my-1">
                  <table class="table table-striped bg-white ">
                      <thead>
                      <tr>
                          <th>Type</th>
                          <th>New leads</th>
                          <th>Shortlist</th>
                          <th>Hire</th>
                          <th>Feedback</th>
                      </tr>
                      </thead>
                      <tbody>
                     <tr>
    <td>SMS</td>
    <td><input type="checkbox" id="new_lead_phone" <?=isset($set_notification[0]['new_lead_phone']) && $set_notification[0]['new_lead_phone'] == 'true' ? 'checked' : 'checked disabled'?> class="d-none"></td>
    <td><input type="checkbox" id="shortlist_phone" <?=isset($set_notification[0]['shortlist_phone']) && $set_notification[0]['shortlist_phone'] == 'true' ? 'checked' : 'checked disabled'?> class="d-none"></td>
    <td><input type="checkbox" id="hire_phone" <?=isset($set_notification[0]['hired_phone']) && $set_notification[0]['hired_phone'] == 'true' ? 'checked' : 'checked disabled'?> class="" autocomplete="off"></td>
    <td><input type="checkbox" id="feedback_phone" <?=isset($set_notification[0]['feedback_phone']) && $set_notification[0]['feedback_phone'] == 'true' ? 'checked' : 'checked disabled'?> class="d-none"></td>
</tr>
<tr>
    <td>Email</td>
    <td><input type="checkbox" id="new_lead_email" <?=isset($set_notification[0]['new_lead_email']) && $set_notification[0]['new_lead_email'] == 'true' ? 'checked' : 'checked disabled'?> class="" autocomplete="off"></td>
    <td><input type="checkbox" id="shortlist_email" <?=isset($set_notification[0]['shortlist_email']) && $set_notification[0]['shortlist_email'] == 'true' ? 'checked' : 'checked disabled'?> class="" autocomplete="off"></td>
    <td><input type="checkbox" id="hire_email" <?=isset($set_notification[0]['hired_email']) && $set_notification[0]['hired_email'] == 'true' ? 'checked' : 'checked disabled'?> class="" autocomplete="off"></td>
    <td><input type="checkbox" id="feedback_email" <?=isset($set_notification[0]['feedback_email']) && $set_notification[0]['feedback_email'] == 'true' ? 'checked' : 'checked disabled'?> class="" autocomplete="off"></td>
</tr>
<tr>
    <td>App</td>
    <td><input type="checkbox" id="new_lead_app" <?=isset($set_notification[0]['new_lead_app']) && $set_notification[0]['new_lead_app'] == 'true' ? 'checked' : 'checked disabled'?> class="" autocomplete="off"></td>
    <td><input type="checkbox" id="shortlist_app" <?=isset($set_notification[0]['shortlist_app']) && $set_notification[0]['shortlist_app'] == 'true' ? 'checked' : 'checked disabled'?> class="" autocomplete="off"></td>
    <td><input type="checkbox" id="hire_app" <?=isset($set_notification[0]['hired_app']) && $set_notification[0]['hired_app'] == 'true' ? 'checked' : 'checked disabled'?> class="" autocomplete="off"></td>
    <td><input type="checkbox" id="feedback_app" <?=isset($set_notification[0]['feedback_app']) && $set_notification[0]['feedback_app'] == 'true' ? 'checked' : 'checked disabled'?> class="" autocomplete="off"></td>
</tr>

                      </tbody>
                  </table>
              </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once "includes/footer-no-cta.php"?>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
<script>


 $( document ).ready(function() {
        $("#userTable").DataTable({
            "pageLength": 5,
            searching: false,
            "responsive": true, "lengthChange": false, "autoWidth": false,
        });
        $("#socialTable").DataTable({
            "pageLength": 5,
            searching: false,
            "responsive": true, "lengthChange": false, "autoWidth": false,
        });

        $("#withdrawTable").DataTable({
            "pageLength": 5,
            searching: false,
            "responsive": true, "lengthChange": false, "autoWidth": false,
        });
    });
	
    let code=$("#code").text();
    $("#copy_code").click(function (e){
        navigator.clipboard.writeText(code);
        // swal("Success","Your Referral code copied successfuly","success");
        Swal.fire({
    title: "Success",
    text: "Your Referral code copied successfully",
    icon: "success",
});

    });
    $("#copy_code_link").click(function (e){
        navigator.clipboard.writeText("https://buildela.com/sign-up?ref_code="+code);
        // swal("Success","Your Invitation link copied successfuly","success");
    Swal.fire({
    title: "Success",
    text: "Your Invitation link copied successfully",
    icon: "success",
});

        
    });
	
	
    $("#copy_profile_link").click(function (e){
        navigator.clipboard.writeText("https://hellolandlord.co.uk/user-profile?u_id="+'<?= $user[0]['id']?>');
        // swal("Success","Profile link copied successfuly","success");
    
        Swal.fire({
    title: "Success",
    text: "Profile link copied successfully",
    icon: "success",
});

    });

    $("#distance").val('<?=$user[0]['distance']?>');

    $(document).ready(function() {
        let code=$("#code").text();
    $('#share-button').click(function() {
		console.log("CLICKED CODE")
        if (navigator.share) {
            navigator.share({
                title: 'Join Buildela as a tradesperson',
                text: 'Join Buildela as a tradesperson and get your first month for <?=$currency_symbol?>8.99',
                url: 'https://buildela.com/sign-up?ref_code='+code,
            })
            .then(() => console.log('Successful share'))
            .catch((error) => console.log('Error sharing:', error));
        } else {
            console.log('Web Share API not supported on this device');
        }
    });
});


$(document).ready(function() {
        let code=$("#code").text();
		console.log("CLICKED CODE")
    $('#copy_profile_share').click(function() {
        if (navigator.share) {
            navigator.share({
                title: 'Find me on buildela',
                text: 'Checkout my profile on Buildela as a tradesperson',
                url: 'https://buildela.com/user-profile?u_id='+'<?= $user[0]['id']?>',
            })
            .then(() => console.log('Successful share'))
            .catch((error) => console.log('Error sharing:', error));
        } else {
            console.log('Web Share API not supported on this device');
        }
    });
	
});

   document.getElementById('qualification').innerHTML = document.getElementById('qualification').innerHTML.trim();
    document.getElementById('note').innerHTML = document.getElementById('note').innerHTML.trim();
</script>

  <script>
                $(document).ready(function() {
					

					
                    // Add a new input box when the "Add Qualification" button is clicked
                    $('.add-qualification').click(function() {
                        var newInput = $('<div class="qualification"><input type="text" class="form-control" required="" name="qualification[]"><button type="button" class="remove-qualification btn btn-danger">-</button></div>');
                        $('#qualifications').append(newInput);
                    });
                    
                    // Remove the input box when the "Remove" button is clicked
                    $(document).on('click', '.remove-qualification', function() {
                        $(this).parent().remove();
                    });
                });
            </script>
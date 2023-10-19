<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require_once "serverside/crud.php";
require_once "serverside/functions.php";
include_once "serverside/session.php";

$db = new Database();
$db->connect();


$func=new  Functions();
$func->set_last_seen($_SESSION['user_id']);
$chatUsers = $func->getMyChatUsers();
$userInfo = $func->UserInfo($_SESSION['user_id']);

$messages=array();



if(isset($_GET['touserid']) && isset($_GET['jobid']) ){
    
    $touserid=$_GET['touserid'];
    $jobid=$_GET['jobid'];
    $my_id=$_SESSION['user_id'];
    $checkStatus=$func->getApplyUserStatus($_SESSION['user_id'],$_GET['jobid']);


    $result=$func->checkDeleteStatus($touserid,$jobid,$my_id);
    $sql="";
    if($result[0]['delete1']==$my_id) {

        $sql = "update user_chat set delete1=0 where (sender_id='$touserid' or receiver_id = '$touserid') and (job_id='$jobid') ";
        $db->sql($sql);
    }else if ($result[0]['delete2']==$my_id){

        $sql = "update user_chat set delete2=0 where (sender_id='$touserid' or receiver_id = '$touserid') and (job_id='$jobid') ";
        $db->sql($sql);
    }

    $chatUsers = $func->getMyChatUsers();

    $messages=$func->getAllMyChates($_GET['touserid'],$_GET['jobid']);
    $to_user=$func->UserInfo($_GET['touserid']);
    $job_info=$func->getSingleJob($_GET['jobid']);
    $to_last_seen=$func->last_seen($_GET['touserid']);
    $appliedUser=$func->getSingleApplyUser($_GET['jobid'],$_GET['touserid']);
    // var_dump($_SESSION);
    // if($_SESSION['user_role'] = 'home_owner'){
    //     $user_apply_description = $func->getApplyUsers($_GET['jobid'],$_GET['touserid']);
    // } elseif ($_SESSION['user_role'] = 'jobs_person')
    //     $user_apply_description = $func->getApplyUsers($_GET['jobid'],$_SESSION['user_id']);        
    // echo "JobID: ".$_GET['jobid']." and User ID: ".$_GET['touserid'];

    $res = $func->getApplyUsers($_GET['jobid'],$_GET['touserid']);
    if(count($res)>0){
        $user_apply_description=$func->getApplyUsers($_GET['jobid'],$_GET['touserid']);
        $applyJob_userinfo = $func->UserInfo($_GET['touserid']);
    }else{
        $user_apply_description=$func->getApplyUsers($_GET['jobid'],$_SESSION['user_id']);
        $applyJob_userinfo = $func->UserInfo($_SESSION['user_id']);
    }


}else{
    $chatUsers = $func->getMyChatUsers();
}

include_once "includes/header.php";



?>
<link href="css/style.css?v=001" rel="stylesheet" type="text/css">
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />


<style> 

.navigation.container {
box-shadow: 0px 0px 6px 2px rgba(0,0,0,.1) !important;
}

.row.justify-content-center.border-bottom {
    position: relative;
}
.w--current {
    background: #ffffff!important;
}
.button-actions {

}

.imessage {
  background-color: #fff;
  border: 1px solid #fff;
  border-radius: 0.25rem;
  display: flex;
  /*flex-direction: column;*/

  font-size: 1rem;
  margin: 0 auto 1rem;
  max-width: 600px;
  padding: 0rem 1.5rem;
}

.imessage p {
  border-radius: 1.15rem;
  line-height: 1.25;
  max-width: 75%;
  padding: 0.5rem .875rem;
  position: relative;
  word-wrap: break-word;
}

.imessage p::before,
.imessage p::after {
  bottom: -0.1rem;
  content: "";
  height: 1rem;
  position: absolute;
}
#sidebarCollapse {font-size: 15px;}

#sidebarCollapse i {
    color: #007bff;
    cursor: pointer;
}
p.from-me {
  align-self: flex-end;

  color: #fff; 
}

p.from-me::before {
  border-bottom-left-radius: 0.8rem 0.7rem;

  right: -0.35rem;
  transform: translate(0, -0.1rem);
}

p.from-me::after {

  border-bottom-left-radius: 0.5rem;
  right: -40px;
  transform:translate(-30px, -2px);
  width: 10px;
}

p[class^="from-"] {
  margin: 0.5rem 0;
  width: fit-content;
   min-width: 150px;
}

p.from-me ~ p.from-me {
  margin: 0.25rem 0 0;
}

p.from-me ~ p.from-me:not(:last-child) {
  margin: 0.25rem 0 0;
}

p.from-me ~ p.from-me:last-child {
  margin-bottom: 0.5rem;
}

p.from-them {
  align-items: flex-start;

  color: #000;
}

p.from-them:before {
  border-bottom-right-radius: 0.8rem 0.7rem;

  left: -0.35rem;
  transform: translate(0, -0.1rem);
}

p.from-them::after {

  border-bottom-right-radius: 0.5rem;
  left: 20px;
  transform: translate(-30px, -2px);
  width: 10px;
}

p[class^="from-"].emoji {
  background: none;
  font-size: 2.5rem;
}

p[class^="from-"].emoji::before {
  content: none;
}

.no-tail::before {
  display: none;
}

.margin-b_none {
  margin-bottom: 0 !important;
}

.margin-b_one {
  margin-bottom: 1rem !important;
}

.margin-t_one {
  margin-top: 1rem !important;
}

#attachment {
    min-width: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

#attachment i {
    font-size: 30px;
    color: blue;
}
#attachment input {
    position: absolute;
    opacity: 0;
    z-index: -9;
}

.image-navigation button {
    outline: none;
    padding: 10px;
    color: #fff;
    border-radius: 0px !important;
}

.image-navigation button i {
    font-size: 30px;
    padding: 10px;
}
.closse {
    position: absolute;
    top: 100px;
    right: 30px;
    color: white;
}

/* general styling */
@font-face {
  font-family: "SanFrancisco";
  src:
    url("https://cdn.rawgit.com/AllThingsSmitty/fonts/25983b71/SanFrancisco/sanfranciscodisplay-regular-webfont.woff2") format("woff2"),
    url("https://cdn.rawgit.com/AllThingsSmitty/fonts/25983b71/SanFrancisco/sanfranciscodisplay-regular-webfont.woff") format("woff");
}




.comment {
  color: #222;
  font-size: 1.25rem;
  line-height: 1.5;
  margin-bottom: 1.25rem;
  max-width: 100%;
  padding: 0;
}
i.fa-trash-can {
    padding: 9px 13px;
}
.chatperson {
    min-width: 40px;
    min-height: 40px;
}

@media (min-width: 320px) and (max-width: 768px){
.row.justify-content-center {
    width: 100%;
}
}

@media (min-width: 320px) and (max-width: 768px){
section.footer-dark.wf-section {
    margin-top: -265px;
}
}
@media(max-width:768px){
    .chat-message-image{
        display: none !important;
    }
}

 @media only screen and (min-width: 320px) and (max-width: 430px) {
 body.chat-page #sidebar {
    width: 100%;
  }
  
 



.chat-message-right.pb-4 {
    display: block;
    float: right;
}
.chat-message-left.pb-4 {
    display: block;
    float: left;
}

.chat-message-right.pb-4 .text-muted.small.text-nowrap.mt-2 {
    text-align: right;
        position: relative;
    top: 1px;
}
.chat-message-left.pb-4 .text-muted.small.text-nowrap.mt-2 {
    text-align: left;
    position: relative;
    top: 1px;
}
.imessage {
    margin-bottom: 0px;
}
.button-actions {
    margin-left: 60px;
}
}

 


.chat-message-right.pb-4 {
    display: block;
    float: right;
	width:100%;
}
.chat-message-left.pb-4 {
    display: block;
    float: left;
	width:100%;
}

.chat-message-left.pb-4 div.imessage {
	  float: left;
}

.chat-message-right.pb-4 div.imessage {
	  float: right;
}

.chat-message-right.pb-4 .text-muted.small.text-nowrap.mt-2 {
    text-align: right;
    position: relative;
    top: 1px;
}
.chat-message-left.pb-4 .text-muted.small.text-nowrap.mt-2 {
    text-align: left;
    position: relative;
    top: 1px;
}
.imessage {
    margin-bottom: 0px;
}
.imessage p br {
    display: none;
}
/*NEW CSSS*/
a.list-group-item.list-group-item-action.border-0 {
    border-bottom: 1px solid #e4e5e7!important;
}

.list-group-item:first-child {
    border-top: 1px solid #e4e5e7!important;
}

.flex-grow-1.ml-2.font-weight-bold {
    font-size: 0.9rem;
    max-width: calc(100% - 65px);
}
span.fas.fa-circle.chat-offline {
    position: absolute;
    top: 40px;
    left: 45px;
}
span.fas.fa-circle.chat-online {
    position: absolute;
    top: 40px;
    left: 45px;
}

.chat-offline {
    color: #c1c1c1;
}
.online-text {
    position: relative;
    margin-left: 13px;
}
.online-text .chat-offline,.online-text .chat-online {
    top: 2px !important;
    left: -13px!important;
}
.chat-message-right.pb-4 {
    display: block;
    float: left!important;
    width: 100%;
}
.chat-message-right.pb-4 .text-muted.small.text-nowrap.mt-2 {
    text-align: left;
}
.chat-message-right.pb-4 div.imessage {
    float: left;
}

p.from-me {
    align-self: flex-end;
 
    color: #000;
}
p.from-me b {
    display: block;
}
p.from-me::before {
    border-bottom-left-radius: 0.8rem 0.7rem;

}
p.from-them {
    align-items: flex-start;

    color: #000;
}
p.from-them:before {
    border-bottom-right-radius: 0.8rem 0.7rem;
  
}
p.from-me {
    align-self: start;
 
    color: #000;
}

element.style {
}
p[class^="from-"] {
    margin: 0.5rem 0;
    width: fit-content;
    min-width: 150px;
}
p.from-me {
    align-self: start;

    color: #000;
}
.imessage p {
    border-radius: 1.15rem;
    line-height: 1.25;
    max-width: 100%;
}
.imessage {
    width: 100%;
    /*display: block;*/
    max-width: none;
}
@media (min-width: 320px) and (max-width: 768px){
.chat-messages {
    display: flex;
    flex-direction: column;
    height: calc(100vh - 265px);
    overflow-y: auto;
}
.px-4.infobxchat {
    display: contents;
}
}

.imessage:hover {
    background: #f6f6f6;
}
.w--current{
	background:#eaf9ff;
}
section.footer-dark.wf-section{
	display:none;
}

#content {
    width: 100%;
    /* padding: 20px; */
    min-height: 100%!important;
    max-height: 100vh;
    transition: all 0.3s;
}

.date {
    float: right;
}

.chat-name {
    font-weight: 600;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    max-width: 100%;
}



.imessage p {
display: inline-block;
    font-size: 0.9rem;
    font-weight: 500;
    padding-top: 0px;
    margin-top: 0px;
    margin-bottom: 0px;
    padding-bottom: 0px;
    min-width:auto;
}


.text-muted.small.text-nowrap.mt-2 {
    display: inline-block;
}
.img-profile-left {
    display: inline;
    flex: 0 0 43px;
}
.msgimgholder {
    flex: 1;
}
b, strong {
    font-weight: 700;
}
/*.img-profile-left  {*/

/*    padding-top: 16px!important;*/
/*}*/
.imessage {
    padding-top: 16px;
	padding-bottom: 16px;
}
.text-muted.small.text-nowrap.mt-2 {



}
button.btn-bg-general.text-white.text-center.px-4.text-decoration-none.font-weight-bold.rounded {
    border: 0!important;
    background: #51c37d;
    font-weight: 500!important;
    padding: 7px 10px!important;
    color: #fff;

}
button#send_msg_btn {
    color: #fff;
    border: #006bf5;
}

button.btn-bg-general.text-white.text-center.px-4.text-decoration-none.font-weight-bold.rounded:hover {
  background: #56bd7e;
  color: #fff!important;
}
button.btn-bg-general.text-white.text-center.px-4.text-decoration-none.font-weight-bold.rounded:focus{
  outline: 0;
}
i.fa-trash-can {
    background: #fff;
    color: #dc3545;
    padding: 7.5px 10px!important;
    font-size: 18px;
    cursor: pointer;
    border: 1px solid;
    border-radius: 5px;
}
i.fa-trash-can:hover {
    color: #fff;
    background: #c82333;
}
.row.justify-content-center.border-bottom {
  padding-bottom: 4px;
    padding-top: 2px;
}

a.hm-hl {
    display: table;
    line-height: 1;
    color: inherit;
}

.text-center strong {
    color: #707070;
    font-weight: 500;
}

p.title-text {
    margin-bottom: 0;
    margin-top: 4px;
    font-weight: 700;
}
span.intersted-p {
    font-size: 0.7rem;
}
span.intersted-p a {
    text-decoration: underline;
}
input#message {
    height: 45px;
}
input#message:hover {
    background: #f7f7f7;
}
input#message:focus {
    background: #fff;
}

/* Desktop full screen*/
.chat-messages {
    display: flex;
    flex-direction: column;
    height: calc(100vh - 265px);
    overflow-y: auto;
}
#sidebar {
    min-width: 290px;
    max-width: 290px;
    background-color: #fff;
    color: #fff;
    transition: all 0.3s;
    height: calc(100vh - 68px);
    overflow-y: auto;
}
.row.justify-content-center.border-bottom {
    width: 100%;
    align-items: center;
    margin: 0;
    min-height: 76px;
}

#large-image-modal {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.8);
  display: flex;
  justify-content: center;
  align-items: center;
}

.large-image {
  max-width: 80%;
  max-height: 80%;
  height: auto;
}

.image-navigation {
    position: fixed;
    top: 50%;
    transform: translateY(-50%);
    left: 5%;
    right: 5%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #fff;
}


.navigation-btn {
  background-color: transparent;
  border: none;
  cursor: pointer;
  outline: none;
  padding: 5px 10px;
  font-size: 16px;
}
.closse i {
    cursor: pointer;
    padding: 10px;
    border: 1px solid #fff;
}

/* 
  ##Device = Tablets, Ipads (portrait)
  ##Screen = B/w 768px to 1024px
*/

@media (min-width: 768px) and (max-width: 1024px) {
  
    .chat-messages {
    display: flex;
    flex-direction: column;
    height: calc(100vh - 265px);
    overflow-y: auto;
}
  
}

.img-profile-left img,a.list-group-item.list-group-item-action.border-0 img,.infobxchat img {

    object-fit: cover;
}

/* 
  ##Device = Most of the Smartphones Mobiles (Portrait)
  ##Screen = B/w 320px to 479px
*/

@media (min-width: 320px) and (max-width: 480px) {
  
    .chat-messages {
    display: flex;
    flex-direction: column;

    overflow-y: auto;
}


}

/*a.hm-hl,.online-text {*/
/*    text-align: center;*/
/*}*/
/*.img-profile-left {*/
/*    display: inline-grid;*/
/*}*/
.online-text{
    
}
.text-muted.small.text-nowrap.mt-2 {
    display: block;
}

span.chat-d-flex {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 4px;
}
span.chat-d-flex .text-muted {
    margin-top: 2px;
}
.imgcontainer {
    margin-top: 15px;
    margin-left: 15px;
}

.imgcontainer img {
    width: 160px;
    height: 110px;
    object-fit: cover;
    cursor: pointer;
}

/*Collapse sidebar on mobile*/

@media(max-width:1024px){
  #sidebar.active + #content {
    position: relative;
}

#sidebar.active + #content .navbar {
    position: static;
}



#sidebar.active + #content .navbar #sidebarCollapse:after {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1;
    content: "";
}
}
.preview {
    font-size: 12px;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    max-width: 100%;
}
.chat-message-image {
    width: 100%;
    max-width: 300px;
    text-align: center;

    margin: auto;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: calc(100vh - 230px);
}
.chat-message-image img{

    width: 100%;
}
.chat-message-image p {
    padding-top: 20px;
    line-height: 24px;
    font-weight: 500;
    font-size: 16px;
}
.chat-inner-sidebar{
  height: 100%;
}
@media(max-width: 480px){
  .chat-inner-sidebar{
  height: 100vh;
}
}
</style>

<section>
    <div class="wrapper">
        <?php
        if(empty($chatUsers)){
            ?>
            <div id="content" class="my-5">
                <nav style="style="background-color: #ffff;border-bottom: 1px solid #e4e5e7; border-top: 1px solid #e4e5e7;" class="navbar navbar-expand-lg navbar-light bg-b">
                    <div class="mx-auto">
                        <a class="theme-btn mini green-bg brd-rd5 text-white mx-auto" >
                            No Chat available
                        </a>
                    </div>

                </nav>
            </div>
            <?php
        }else{
            ?>


            <nav id="sidebar">

                <div class=" border-right chat-inner-sidebar">

                    <?php
                    foreach ($chatUsers as &$user) {
                        if ($_SESSION['user_id'] == $user['receiver_id']) {
                            $user['create_date'] = $func->getChatpreview($user['job_id'])[0]['create_date'];
                        } else {
                            $user['create_date'] = $func->getChatpreview($user['job_id'])[0]['create_date'];
                        }
                    }

                    

                    // Sort the $chatUsers array by the 'create_date' field in descending order (most recent first)
                    usort($chatUsers, function ($a, $b) {
                        return strtotime($b['create_date']) - strtotime($a['create_date']);
                    });  


            foreach ($chatUsers as $users) {

                if ($_SESSION['user_id'] == $users['receiver_id']) {
                    $userinfo = $func->UserInfo($users['sender_id']);
                    $last_seen = $func->last_seen($users['sender_id']);
                    $new_messages = $func->mySendmebythisuser($_SESSION['user_id'], $users['sender_id'], $users['job_id']);
                    // $chat_preview = $func->getChatpreview($users['job_id'],$users['sender_id'], $_SESSION['user_id']);
                    $chat_preview = $func->getChatpreview($users['job_id']);
                    $isOnline = $func->checkOnlineStatus($users['sender_id']);
                } else {
                    $userinfo = $func->UserInfo($users['receiver_id']);
                    $last_seen = $func->last_seen($users['receiver_id']);
                    $new_messages = $func->mySendmebythisuser($_SESSION['user_id'], $users['receiver_id'], $users['job_id']);
                    // $chat_preview = $func->getChatpreview($users['job_id'],$users['sender_id'], $users['receiver_id']);
                    $chat_preview = $func->getChatpreview($users['job_id']);
                    $isOnline = $func->checkOnlineStatus($users['receiver_id']);
                }
                

                    ?>
                    <a href="chat?touserid=<?=$userinfo[0]['id']?>&jobid=<?=$users['job_id']?>" class="list-group-item list-group-item-action border-0" class="chat_person" data-userid="<?=$userinfo[0]['id']?>">
                        <!--<div class="badge bg-success float-right">New Msg</div>-->
                        <div class="d-flex align-items-start">
                            <?php
                            if(empty($userinfo[0]['img_path']))
                            {
                                ?>
                                <img class="rounded-circle mr-1 chatmain" src="images/avatar1.png" width="40" height="40" alt="no-image">
                                <?php
                            }else{
                                $image=explode('/',$userinfo[0]['img_path'] );

                                $img= $image[1].'/'.$image[2];
                                ?>
                                <img src="<?=$img?>" class="rounded-circle mr-1 chatperson" alt="" width="40" height="40">
                                <?php
                            }

                            if($isOnline){
                                ?>
                                <span class="fas fa-circle chat-online"></span>

                                <?php
                            }else{ ?>

                                <span class="fas fa-circle chat-offline"></span>
                                <!--<span class="fas fa-circle chat-offline"></span>-->
                                <?php
                            }
                            
                            ?>
                                
                            <div class="flex-grow-1 ml-2 font-weight-bold">
                                <?php if($_SESSION['user_role']=='home_owner'){ ?>
                                <div class="chat-name"><?=$userinfo[0]['fname']?> - <?=$userinfo[0]['trading_name']?></div>
                                <?php } else {?>
                                    <div class="chat-name"><?=$userinfo[0]['fname']?></div>
                                    <?php }; ?>
                                    <div class="position-relative" style="font-size: 10px">

                                <?php echo '<div class="preview">'. $chat_preview[0]['message']. "</div>";
                                    $create_date = $chat_preview[0]['create_date'];
                                    $date = new DateTime($create_date);
                                    $formatted_date = $date->format('d/m/y');
                                    echo '<div class="date">'. $func->timeAgo($create_date) .'</div>';
                                    //echo '<div class="date">' .$formatted_date.'</div>'; 
                                    ?>
                                    

                                    <?php
                                    if(count($new_messages)>0 ){
                                        ?>
                                        <span style="top: -20px;right: -28px;font-size: 15px;" class="bg-danger position-absolute text-white rounded-circle px-1 chat"><?= count($new_messages)?></span>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </a>

                    <?php
                    }
                    ?>
                 
                </div>

            </nav>

            <?php
            if(isset($_GET['touserid'])){
                ?>
                <div id="content">
                    <nav style="background-color: #ffff;border-bottom: 1px solid #e4e5e7;border-top: 1px solid #e4e5e7;" class="navbar navbar-expand-lg navbar-light bg-b">
                        <div class="">
                            <a class="theme-btn mini green-bg brd-rd5 text-white" id="sidebarCollapse" title="">
                                <i class="fa-solid fa-bars"></i>
                                Chats
                            </a>
                        </div>

                    </nav>

                    <div class="page-content-wrapper py-4 bg-white">
                        <div class="row justify-content-center border-bottom ">
                            <div class="px-4 infobxchat mr-auto ml-3" data-touserid="<?=$to_user[0]['id']?>">
                      
                                <div class="row justify-content-center">

                                    <div class="d-flex align-items-center">

                                        <div class="position-relative">
                                            <?php
                                            if(empty($to_user[0]['img_path']))
                                            {
                                                ?>
                                                <img class="rounded-circle mr-1" src="images/avatar1.png" width="40" height="40" alt="no-image">
                                                <?php
                                            }else{
                                                $image=explode('/',$to_user[0]['img_path'] );

                                                $img= $image[1].'/'.$image[2];
                                                ?>
                                                <img src="<?=$img?>" class="rounded-circle mr-1" alt="Vanessa Tucker" width="40" height="40">
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="flex-grow-1 pl-2">
                                        <div class="text-left">
                                    <?php
                                    if(isset($job_info[0]['title'])){
                                        ?>
                                        <p class="title-text"><?=$job_info[0]['title']?>

                                    </p>

                                        <?php
                                    }
                                    ?>
                                </div>


                                            <?php
                                            if(isset($to_user[0]['fname'])){
                                                ?>
                                                      <?php if($_SESSION['user_role']=='home_owner'){ ?>
                                                <a class="hm-hl" href="user-profile?u_id=<?=$to_user[0]['id']?>&job_id=<?=$job_info[0]['id']?>"><?=$to_user[0]['fname']?> - <?=$to_user[0]['trading_name']?></a>
                                                <?php }else{?>
                                                    <a class="hm-hl" href="user-profile?u_id=<?=$to_user[0]['id']?>">   <?=$to_user[0]['fname']?> </a>
                                                <?php }?>

                                            <?php }?>
                                            <!--                            <div class="text-muted small"><em>Typing...</em></div>-->
                                               <div class="  d-block online-text" style="font-size: 9px">
                                            <?php if($func->checkOnlineStatus($to_user[0]['id'])){ ?>
                                            <span class="fas fa-circle chat-online"></span>
                                            <?php  }else{ ?>
                                             <span class="fas fa-circle chat-offline"></span>
                                           <?php }?>
                                            <span id="status-text"><?=$to_last_seen?></span>
                                        </div>
                                        <div class="text-center">
                                    <?php
                                    if(isset($job_info[0]['title'])){
                                        ?>
                                        <strong>
                                        <?php
                                            if($job_info[0]['user_id']==$_SESSION['user_id']){
                                                ?>
                                                <span class="intersted-p"> <a href="my-posted-jobs-details?job_id=<?=$job_info[0]['id']?>">View interested tradespeople </a> </span>

                                                <?php
                                            }
                                            ?>

                                        </strong>

                                        <?php
                                    }
                                    ?>
                                </div>
                                        </div>
                                        <br>
                                     

                                    </div>
                                </div>
                            </div>
                            <?php
                            if((count($appliedUser)>0) && ($job_info[0]['user_id']==$_SESSION['user_id'])){
                                ?>

                                <div class="button-actions">
                                    <?php
                                    if($appliedUser[0]['status']==0){
                                        ?>
                                        <button  onclick="shortList(<?=$appliedUser[0]['user_id']?>,
                                        <?=$appliedUser[0]['job_id']?>)" id="shortList<?=$appliedUser[0]['user_id']?>" class="btn-bg-general text-white text-center px-4  text-decoration-none font-weight-bold rounded">Short list</button>
                                        <?php
                                    }else if($appliedUser[0]['status']==1&&$appliedUser[0]['worker_status']==0&&$appliedUser[0]['employer_status']==0){
                                        ?>
                                        <button id="hire_btn" onclick="employerstartJob(<?=$appliedUser[0]['user_id']?>,<?=$appliedUser[0]['job_id']?>)" class="btn-bg-general
                                                text-white text-center px-4  text-decoration-none font-weight-bold rounded">Hire</button>

                                        <?php
                                    }else if($appliedUser[0]['status']==1&&$appliedUser[0]['worker_status']==0&&$appliedUser[0]['employer_status']==1){
                                        ?>
                                        <button  class="btn-bg-general text-white text-center px-4  text-decoration-none font-weight-bold rounded">Wait for trademen's approval</button>
                                        <?php
                                    }else if($appliedUser[0]['status']==1&&$appliedUser[0]['worker_status']==1&&$appliedUser[0]['employer_status']==1){
                                        ?>
                                        <button class="btn-bg-general text-white text-center px-4  text-decoration-none font-weight-bold rounded">Job inprocessing</button>
                                        <?php
                                    }else if($appliedUser[0]['status']==2&&$appliedUser[0]['worker_status']==1&&$appliedUser[0]['employer_status']==1 && $appliedUser[0]['rating']==0){
                                        ?>
                                        <button  class="ratemodalopen btn-bg-general text-white text-center px-4  text-decoration-none
                                                font-weight-bold rounded" data-toggle="modal" data-target="#exampleModal" data-userid = "<?=$appliedUser[0]['user_id']?>" data-jobid="<?=$appliedUser[0]['job_id']?>">Rate this user</button>

                                        <?php
                                    }else if($appliedUser[0]['status']==2&&$appliedUser[0]['worker_status']==1&&$appliedUser[0]['employer_status']==1 && $appliedUser[0]['rating']==1){
                                        ?>
                                        <button class="btn-bg-general text-white text-center px-4  text-decoration-none font-weight-bold rounded">Feedback left</button>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                            }if( (count($checkStatus)>0) && ($checkStatus[0]['user_id']==$_SESSION['user_id']) &&
                                ($checkStatus[0]['job_id']==$_GET['jobid']) ) {
                                ?>
                                <div class="button-actions">
                                    <?php


                                    if(($_SESSION['user_role'] !='home_owner') &&
                                        ($checkStatus[0]['status']==1) &&
                                        ( $checkStatus[0]['worker_status']==0) &&
                                        ($checkStatus[0]['employer_status']==1)){
                                        ?>
                                        <button class="btn-bg-general text-white text-center px-4  text-decoration-none font-weight-bold rounded" id="startJob" onclick="workerstartJob(`<?=$checkStatus[0]['user_id']?>`,`<?=$checkStatus[0]['job_id']?>`)">Accept Job</button>
                                        <?php
                                    }else if(($_SESSION['user_role'] !='home_owner') &&
                                        ($checkStatus[0]['status']==1) &&
                                        ( $checkStatus[0]['worker_status']==1) &&
                                        ($checkStatus[0]['employer_status']==1)){
                                        ?>

                                        <button class="btn-bg-general text-white text-center px-4  text-decoration-none font-weight-bold rounded" id="completeJob" onclick="completeJob(`<?=$checkStatus[0]['user_id']?>`,`<?=$checkStatus[0]['job_id']?>`)">Complete</button>
                                        <?php
                                    }else if(($_SESSION['user_role'] !='home_owner') &&
                                        ($checkStatus[0]['status']==2) &&
                                        ($checkStatus[0]['worker_status']==1) &&
                                        ($checkStatus[0]['employer_status']==1)){
                                        ?>
                                        <button class="btn-bg-general text-white text-center px-4  text-decoration-none font-weight-bold rounded" >Completed</button>
                                        <?php

                                    }
                                    ?>
                                </div>
                                
                                <?php
                            }
                            ?>
                              <div class="ml-2 mr-4">
                                <i class="fa-solid fa-trash-can" onclick="deleteChat(`<?=$_GET['touserid']?>`,`<?=$_GET['jobid']?>`,`<?=$_SESSION['user_id']?>`)" ></i>
                            </div>
                        </div>

                        <script>
                            var lastmsg_id="";
                            var touser_id="";
                            var jobid ="";
                        </script>
                        <div class="">
                            <div id="messages" class="chat-messages ">

<!--                                load default message-->
                                <div class="chat-message-right pb-4">
                                  
                                    <div class=" imessage">
                                        <div class="img-profile-left">
                                            <img class="rounded-circle mr-1" src="images/fav-icon.png" width="40" height="40" alt="no-image">                                      
                                        </div>  
									 
                                        <p class="from-me">  Buildela automated friendly reminder Please respect all users on our platform, no abuse will be tolerated, and may result in account deletion. Here are some key point to discuss:
                                        <span class="d-block"> - The exact work to be carried out.
                                        <span class="d-block"> - A quote for the work.
                                        <span class="d-block"> - A start date & time of arrival.
                                        <span class="d-block"> - How long the job will take.
                                        <span class="d-block"> - Who will supply the parts.</p>
                                        <div class="text-muted small text-nowrap" style="font-size: 10px"><?=date('H:i a')?> </div>
                                    </div>
                                </div>
                                <?php
                                if($user_apply_description[0]['user_id']== $_SESSION['user_id']){
                                    ?>
                                    <div class="chat-message-right pb-4">
                                    
                                      <div class=" imessage">
                                            <div class="img-profile-left">
                                            <?php
                                            if(empty($applyJob_userinfo[0]['img_path']))
                                            {
                                            // var_dump($applyJob_userinfo);   ?>
                                                <img class="rounded-circle mr-1" src="images/avatar1.png" width="40" height="40" alt="no-image">
                                                <?php
                                            }else{
                                                $image=explode('/',$applyJob_userinfo[0]['img_path'] );

                                                $img= $image[1].'/'.$image[2];
                                                ?>
                                                <img src="<?=$img?>" class="rounded-circle mr-1" alt="" width="40" height="40">
                                                <?php
                                            }
                                            ?>
                                            
                                        </div>
									
									   <p class="from-me"><span class="chat-d-flex"><b><?= ($_SESSION['user_role'] === 'jobs_person')? 'Me' : $applyJob_userinfo[0]['fname']?></b> <span class="text-muted small text-nowrap" style="font-size: 10px"><?php //=date('Y-m-d',strtotime($user_apply_description[0]['apply_date']))?><?php echo $func->timeAgochat($user_apply_description[0]['apply_date']);?></span></span><br>
                                            <?=$user_apply_description[0]['message']?></p>                                    
                                        </div>
										
										
                                    </div>

                                <?php
                                }else{
                                    ?>
                                    <div class="chat-message-left pb-4">										
										<div class="imessage">
                                                   <div class="img-profile-left">
                                            <?php
                                            if(empty($applyJob_userinfo[0]['img_path']))
                                            {
                                                ?>
                                                <img class="rounded-circle mr-1" src="images/avatar1.png" width="40" height="40" alt="no-image">
                                                <?php
                                            }else{
                                                $image=explode('/',$applyJob_userinfo[0]['img_path'] );

                                                $img= $image[1].'/'.$image[2];
                                                ?>
                                                <img src="<?=$img?>" class="rounded-circle mr-1" alt="" width="40" height="40">
                                                <?php
                                            }
                                            ?>
                                            
                                        </div>
										
                                            <p class="from-them "><span class="chat-d-flex"><b><?=$applyJob_userinfo[0]['fname']?> </b><span class="text-muted small text-nowrap" style="font-size: 10px"><?php echo $func->timeAgochat($user_apply_description[0]['apply_date']);?></span></span><br>
                                           <?=$user_apply_description[0]['message']?></p>
										   	
                                        </div>
									
										
                                    </div>

                                <?php
                                }
                                ?>
                                <script>
                                    lastmsg_id = '0';
                                    touser_id = '<?=$_GET['touserid']?>';
                                    jobid = '<?=$_GET['jobid']?>';
                                </script>
                                
                                <?php

                                foreach ($messages as $message){
                                    ?>
                                    <script>
                                        lastmsg_id = '<?=$message['id']?>';
                                        touser_id = '<?=$_GET['touserid']?>';
                                        jobid = '<?=$_GET['jobid']?>';
                                    </script>
                                    <?php
                                    $sender=$func->UserInfo($message['sender_id']);
                                    // $receiver=$func->UserInfo($message['receiver_id']);
                                    $earlier = new DateTime($message['create_date']);
                                    $later = new DateTime(date("Y-m-d H:i:s"));
                                    $diff = $later->diff($earlier)->format("%a");

                                    $chatimages = $func->getChatImages($message['image_paths']);
                                    $chatimage = '';
                                    

                                    if($message['sender_id']==$_SESSION['user_id']){	
                                        if($chatimages) $chatimage = "<div class='chatimages image_of_your'>".$chatimages."</div>";							
                                    ?>
                                        <div class="chat-message-right pb-4">
                                            
                                            <div class=" imessage">
                                                <div class="img-profile-left">
                                                <?php
                                                if(empty($sender[0]['img_path']))
                                                {
                                                    ?>
                                                    <img class="rounded-circle mr-1" src="images/avatar1.png" width="40" height="40" alt="no-image">
                                                    <?php
                                                }else{
                                                    $image=explode('/',$sender[0]['img_path'] );

                                                    $img= $image[1].'/'.$image[2];
                                                    ?>
                                                    <img src="<?=$img?>" class="rounded-circle mr-1" alt="" width="40" height="40">
                                                    <?php
                                                }
                                                ?>
                                                
                                            </div>
                                                <div class="msgimgholder">
                                                    <p class="from-me">
                                                        <span class="chat-d-flex">
                                                            <b>Me</b>
                                                            <span class="text-muted small text-nowrap" style="font-size: 10px"><?php echo $func->timeAgochat($message['create_date']);?></span>
                                                        </span><br>
                                                        <?=$message['message']?>
                                                    </p>
                                                    <?=$chatimage?>
                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                        <?php
                                    }else{
                                        if($chatimages) $chatimage = "<div class='chatimages image_of_his'>".$chatimages."</div>";	
                                        ?>

                                        <div class="chat-message-left pb-4">
                                        
                                        
                                            <div class="imessage">
                                                <div class="img-profile-left">
                                                <?php
                                                if(empty($sender[0]['img_path']))
                                                {
                                                    ?>
                                                    <img class="rounded-circle mr-1" src="images/avatar1.png" width="40" height="40" alt="no-image">
                                                    <?php
                                                }else{
                                                    $image=explode('/',$sender[0]['img_path'] );

                                                    $img= $image[1].'/'.$image[2];
                                                    ?>
                                                    <img src="<?=$img?>" class="rounded-circle mr-1" alt="" width="40" height="40">
                                                    <?php
                                                }
                                                ?>
                                                
                                            </div>
                                                <div class="msgimgholder">
                                                    <p class="from-them "><span class="chat-d-flex"><b><?=$sender[0]['fname']?></b><span class="text-muted small text-nowrap" style="font-size: 10px"><?php//=$diff==0?date('H:i a',strtotime($message['create_date'])) :date('Y-m-d H:i a',strtotime($message['create_date']))?><?php echo $func->timeAgochat($message['create_date']);?></span></span><br>
                                                    <?=$message['message']?>  </p>
                                                    <?=$chatimage?>
                                                </div>
                                                
                                            
                                            </div>
                                        
                                            
                                        </div>
                                        <?php

                                    }
                                }
                                ?>

                            </div>
                        </div>

                        <div class="chat-message-right pb-4" id="TypingStatus">
                            <div class=" imessage">
                                <div class="img-profile-left">
                                    <?php 
                                        $typingsender   =   $func->UserInfo($_GET['touserid']);
                                        $image          =   explode('/',$typingsender[0]['img_path'] );
                                        $img            =   $image[1].'/'.$image[2];
                                    ?>
                                    <img src="<?=$img?>" class="rounded-circle mr-1" alt="" width="40" height="40">                                        
                                </div>
                                <div class="msgimgholder">
                                    <p class="from-me">
                                        <span class="chat-d-flex">
                                            <div class="chat-bubble" id="userTyping">
                                                <div class="typing">
                                                    <div class="dot"></div>
                                                    <div class="dot"></div>
                                                    <div class="dot"></div>
                                                </div>
                                            </div>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="custom-flex-grow-0 py-3 px-4 border-top sticky-chatbox">
                            <div class="input-group">
                                <div class="attachment" id="attachment">
                                    <i class="fa-solid fa-images"></i>
                                    <input type="file" class="form-control" id="inputimg" multiple>
                                </div>
                                <input type="hidden" class="form-control" value="<?=$_GET['jobid']?>" id="jobid">
                                <input type="hidden" class="form-control" value="<?=$_GET['touserid']?>" id="touserid">
                                <input type="text" class="form-control border border-primary rounded mx-2" id="message" placeholder="Type your message">
                                <button class="btn bg-blue-color text-white" id="send_msg_btn">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php

            }else{
                ?>
                <div id="content">
                    <nav style="background-color: #ffff;border-bottom: 1px solid #e4e5e7;border-top: 1px solid #e4e5e7;" class="navbar navbar-expand-lg navbar-light bg-b">
                        <div class="">
                            <a class="theme-btn mini green-bg brd-rd5 text-white text-center" id="sidebarCollapse" >
                            <i class="fa-solid fa-bars"></i>
                                Select a person to start chat
                            </a>
                        </div>

                    </nav>
                    <div class="chat-message-image">
                        <img src="admin/images/chat-img.png">
                        <p>Pick up where you left off<br>Select a conversation and chat away.</p>
                    </div>
                </div>
                <?php
            }
            ?>
            <?php
        }
        ?>

    </div>
</section>
<!-- Modal for rating -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Give feedback</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="rateUser">
                <div class="modal-body">
                    <input type="hidden" id="userid" value="">
                    <input type="hidden" id="jobid" value="">

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

<!--Modal for viewing images-->
<div id="large-image-modal" style="display: none;">
  <div class="closse"><i class="fa-solid fa-x"></i></div>
  <div class="image-navigation">
    <button id="prev-btn" class="navigation-btn"><i class="fa-solid fa-angle-left"></i></button>
    <button id="next-btn" class="navigation-btn"><i class="fa-solid fa-angle-right"></i></button>
  </div>
  <img src="" class="large-image" alt="Large Image">
</div>

<?php include_once "includes/footer-no-cta.php"?>

<?php
if(isset($_GET['touserid']) && isset($_GET['jobid'])){ ?>
<script>
    $(window).on("load",function () {
        // Get the chat messages container

        var chatContainer = $('html');

        // Scroll to the bottom of the chat container
        chatContainer.scrollTop(chatContainer[0].scrollHeight);


        var chatContainer = document.getElementById('messages');
        
        // Scroll to the bottom of the chat container
        chatContainer.scrollTop = chatContainer.scrollHeight;
    })
</script>
<?php }

?>
<script type="text/javascript">
    if(touser_id === undefined){
        let touser_id;
    }
    $('.ratemodalopen').click(function(){
        var userid = $(this).data('userid');
        var jobid = $(this).data('jobid');

        $('#userid').val(userid);
        $('#jobid').val(jobid);

    });
    document.getElementById('message').innerHTML = document.getElementById('message').innerHTML.trim();
    document.getElementById('note').innerHTML = document.getElementById('note').innerHTML.trim();

</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });
    });

    var objDiv = document.getElementById("messages");
    objDiv.scrollTop = objDiv.scrollHeight;

</script>
<script>

    const defaultTitle  = document.title;
    var isUserActive    = true,
        marqueeElement  = null,
        msgcounter      = 0,
        runinterval     = true,
        timer;
    
    

    $(document).on('mousemove keydown', function() {
        isUserActive = true;
        if(isUserActive) {
            window.clearTimeout(timer);
            restoreDefaultTitle();
            msgcounter = 0;
        }
    });

    $(document).on('visibilitychange', function() {
        isUserActive = !document.hidden;
    });

    $(window).on('focus', function() {
        isUserActive = true;
    });

    $(window).on('blur', function() {
        isUserActive = false;
    });

    function animateTitle(count, val=0) {
        var pos     = val,
            speed   = 1000;
        
        if(pos == 0){
            if (count < 2 ) msg = "(1) You have a new message";
            else msg = "("+count+") You have "+count+" new messages";
            pos = 1;
        } else if(pos == 1) {
            msg = defaultTitle;
            pos = 0;
        }

        document.title = msg;
        timer = window.setTimeout("animateTitle("+count+","+pos+")",speed); 

    }


    function restoreDefaultTitle() {
        if (marqueeElement) {
            document.head.removeChild(marqueeElement);
            marqueeElement = null;
        }
        document.title = defaultTitle;
    }

    

        setInterval(function(e){
            if(runinterval === true){
                
                if(runinterval == false)
                return;

                runinterval = false;

                var userIds = [];
                $('#sidebar [data-userid]').each(function() {
                    var userId = $(this).attr('data-userid');
                    if (userIds.indexOf(userId) === -1) {
                        userIds.push(userId);
                    }
                });

                $.ajax({
                    url:"serverside/post.php",
                    method:"post",
                    data:{
                        func:69,
                        touser_id:touser_id,
                        lastmsg_id:lastmsg_id,
                        jobid:jobid,
                        userids: userIds
                    },
                    success:function(data){
                        var data = JSON.parse(data);
                            runinterval = true;
                
                        if(!data.nomsg){
                            
                            lastmsg_id = data.lastmsgid;
                            $("#messages").append(data.msgsstring);
                            objDiv.scrollTo(0,objDiv.scrollHeight);

                            if (!isUserActive) {
                                msgcounter++;
                                window.clearTimeout(timer);
                                animateTitle(msgcounter);
                                playMessageSound();
                            }
                        }
                        // if (data.allIDsStatus) {
                        //     for (var userId in data.allIDsStatus) {
                        //         var element         = $('[data-userid="' + userId + '"]');
                        //         var circleElement   = element.find('.fas.fa-circle');

                        //         if (data.allIDsStatus[userId] === false) {
                        //             circleElement.removeClass('chat-online').addClass('chat-offline');
                        //         }else {
                        //             circleElement.removeClass('chat-offline').addClass('chat-online');
                        //         }
                        //     }
                        // }

                        if(data.currentUserStatus === false){
                            $('.online-text span').removeClass('chat-online').addClass('chat-offline');
                            $('#status-text').text('Offline');
                        }else {
                            $('.online-text span').removeClass('chat-offline').addClass('chat-online');
                            $('#status-text').text('Online');
                        }

                        if(data.chatUsers){
                            let sidebar = $('#sidebar .border-right');
                            let noChatUsers = '<div id="content" class="my-5"><nav style="style="background-color: #ffff;border-bottom: 1px solid #e4e5e7; border-top: 1px solid #e4e5e7;" class="navbar navbar-expand-lg navbar-light bg-b"><div class="mx-auto"><a class="theme-btn mini green-bg brd-rd5 text-white mx-auto" >No Chat available</a></div></nav></div>';
                            
                            sidebar.find('a').remove();
                            sidebar.append(data.chatUsers);
                        }

                    }
                });
            }
        },1500);
    

    $("#message").keypress(function (event){

        if (event.keyCode === 13) { // key code of the keybord key
            $("#send_msg_btn").click();
        }
    });



$(document).ready(function() {
  if (window.innerWidth <= 425) { // Only run on screens up to 425px wide
    var pathname = window.location.pathname;
    var search = window.location.search;

    if (pathname.endsWith("/chat") && search === "") {
      var sidebarCollapse = $("#sidebarCollapse");
      if (sidebarCollapse.length) {
        sidebarCollapse.trigger("click");
      }
    }

    var pathname = window.location.pathname;
    var search = window.location.search;
    if (pathname.endsWith("/chat") && search === "") {
      $("body").addClass("chat-page");
    }
  }
  $('.preview').each(function() {
  if ($(this).text().length > 22) {
    $(this).text($(this).text().substring(0, 22) + '...');
  }
});

});


</script>

<!-- <script>
    $(document).ready(function() {
      // Check if the device is larger than 767px (tablet and larger)
      if ($(window).width() > 768) {
        // Get the current device screen height
        var screenHeight = $(window).height();

        // Calculate the desired height for the .chat-messages class
        var chatMessagesHeight = screenHeight - 270;

        // Apply the calculated height to the .chat-messages class
        $('.chat-messages').css('height', chatMessagesHeight + 'px');
      }
    });
  </script> -->

<script>

    document.addEventListener('DOMContentLoaded', function() {
        var attachmentDiv = document.getElementById('attachment'),
            fileInput = attachmentDiv.querySelector('#attachment input[type="file"]');
        
        attachmentDiv.addEventListener('click', function() {
            fileInput.click();
        });
    });

    $(document).on('change', '#inputimg', function(){


        let files           = Array.from(this.files),
            allowedTypes    = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/jpg'],
            selectedFiles   = [],
            inputs          = $(this);

        for (var i = 0; i < files.length; i++) {
            if (allowedTypes.indexOf(files[i].type) !== -1) {
                selectedFiles.push(files[i]);
            }
        }

        if (selectedFiles.length > 4) {
            swal("Attention!", "Please select up to 4 image files", "error");
            selectedFiles.splice(4); // Remove extra files
            $(this).val('');
            return;
        } 

        if (selectedFiles.length !== files.length) {
            swal("Image file only!", "Please select image files only", "error");
            $(this).val('');
            return;
        }


        var formData = new FormData();

        // Append each selected file to the FormData object
        for (var i = 0; i < selectedFiles.length; i++) {
            formData.append('images[]', selectedFiles[i]);
        }

        formData.append('func', 68);
        formData.append('touserid', $("#touserid").val());
        formData.append('jobid', $("#jobid").val());
        formData.append('message', $("#message").val());

        $.ajax({
            url: 'serverside/post.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                // Handle the response from the backend
                if(data.trim() == "true"){
                    console.log('Files uploaded');
                }
                $("#message").val("");
                inputs.val('');
            },
            error: function(xhr, status, error) {
                // Handle error
                console.log('AJAX request failed');
                console.log(xhr.responseText);
            }
        });
    });

    // function for making chat image large
    $(document).ready(function() {

        
        var currentIndex = 0;
        var currentImages;
        var initialIndex;
        var typingTimer;
        var typingDelay = 2000;
        var isTyping = false;
        var tuserid = $('.infobxchat').attr('data-touserid') || null;

        let yourImages = $('.image_of_your .imgcontainer img'),
            hisImages = $('.image_of_his .imgcontainer img');
            
            if (yourImages.length) {
                $.each(yourImages, function(i) {
                    $(this).attr("data-imgid", i);
                });
            }

            if(hisImages.length){
                $.each(hisImages, function(i){
                    $(this).attr("data-imgid", i);
                });
            }


        // Open the large image view
        function openLargeImageView(index) {
            if (currentImages === undefined) {
                currentImages = $('.image_of_your .imgcontainer img');
            }

            var largeImageUrl = currentImages.eq(index).attr('src');
            $('.large-image').attr('src', largeImageUrl);
            $('#large-image-modal').fadeIn();
            currentIndex = index;
        }

        // Handle click event on your images
        $(document).on('click', '.image_of_your .imgcontainer img', function() {
            currentImages = $('.image_of_your .imgcontainer img');
            initialIndex = $(this).data('imgid');
            openLargeImageView(initialIndex);
        });

        // Handle click event on his images
        $(document).on('click', '.image_of_his .imgcontainer img', function() {
            currentImages = $('.image_of_his .imgcontainer img');
            initialIndex = $(this).data('imgid');
            openLargeImageView(initialIndex);
        });

        // Handle click event on previous button
        $('#prev-btn').click(function(e) {
            e.stopPropagation();
            if (currentIndex > 0) {
            currentIndex--;
            } else {
            currentIndex = currentImages.length - 1;
            }
            openLargeImageView(currentIndex);
        });

        // Handle click event on next button
        $('#next-btn').click(function(e) {
            e.stopPropagation();
            if (currentIndex < currentImages.length - 1) {
            currentIndex++;
            } else {
            currentIndex = 0;
            }
            openLargeImageView(currentIndex);
        });

        // Handle click event to close large image view
        $('#large-image-modal').click(function() {
            $(this).fadeOut();
        });

        // Set initial image if available
        if (initialIndex !== undefined) {
            openLargeImageView(initialIndex);
        }


        /*----------------------------------------------
                    Typing Status Functions
        ------------------------------------------------*/

        <?php if(isset($_GET['touserid']) && isset($_GET['jobid'])): ?>


        $('#message').on('keyup', function() {

            clearTimeout(typingTimer);

            if (!isTyping) {
                isTyping = true;
                updateTypingStatus(true);
            }

            typingTimer = setTimeout(function() {
                isTyping = false;
                updateTypingStatus(false);
            }, typingDelay);
            

        });

        function updateTypingStatus(status) {
            // console.log(status);
            $.ajax({
                url: 'serverside/post.php',
                method: 'POST',
                data: { typingStatus: status, userid:tuserid, func: 116 },
                success: function(response) {
                    let data  = JSON.parse(response);

                    console.log(data);
                
                },
                error: function(xhr, status, error) {
                    
                }
            });
        }

        
        function checkTypingStatus() {
            $.ajax({
                url: 'serverside/post.php',
                method: 'POST',
                data: { userid: tuserid,  func: 115},
                success: function(response) {
                    let data  = JSON.parse(response);
                    // console.log(data);
                    if (data.typingStatus === true) {
                        $('#TypingStatus').show();
                    } else {
                        $('#TypingStatus').hide();
                    }
                },
                error: function(xhr, status, error) {

                }
            });
        }

        
        setInterval(checkTypingStatus, 800);

        <?php endif; ?>


    });



  </script>
  <style>
    #TypingStatus {
        display: none;
        position: absolute;
        bottom: 60px;
    }  
    .chat-bubble {
        background-color: #E6F8F1;
        padding: 16px 28px;
        -webkit-border-radius: 20px;
        -webkit-border-bottom-left-radius: 2px;
        -moz-border-radius: 20px;
        -moz-border-radius-bottomleft: 2px;
        border-radius: 20px 20px 20px 0 !important;
        border-bottom-left-radius: 2px;
        display: inline-block;
    }
    .typing {
        align-items: center;
        display: flex;
        height: 17px;
    }
    .typing .dot {
        animation: mercuryTypingAnimation 1.8s infinite ease-in-out;
        background-color: #1f52cf; 
        border-radius: 50%;
        height: 7px;
        margin-right: 4px;
        vertical-align: middle;
        width: 7px;
        display: inline-block;
    }
    .typing .dot:nth-child(1) {
        animation-delay: 200ms;
    }
    .typing .dot:nth-child(2) {
        animation-delay: 300ms;
    }
    .typing .dot:nth-child(3) {
        animation-delay: 400ms;
    }
    .typing .dot:last-child {
        margin-right: 0;
    }

    @keyframes mercuryTypingAnimation {
    0% {
        transform: translateY(0px);
        background-color:#6CAD96; 
    }
    28% {
        transform: translateY(-7px);
        background-color:#9ECAB9; 
    }
    44% {
        transform: translateY(0px);
        background-color: #B5D9CB; 
    }
    }

    
    @media only screen and (max-width: 768px) {
        .chat-messages {
            height: calc(100vh - 290px);
/*                height: auto;*/
        }
        .sticky-chatbox {
        position: sticky;
        bottom: 0;
        z-index: 999;
        background-color: #fff;
        width: 100%;
        left: 0;
    }

    }
	
    
    @media only screen and (max-width: 425px) {

    }
  </style>
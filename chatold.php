<?php

require_once "serverside/functions.php";
require_once "serverside/crud.php";
include_once "serverside/session.php";

$db = new Database();
$db->connect();

$func=new  Functions();
$func->setlastSeen($_SESSION['user_id']);
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
    $res=$func->getApplyUsers($_GET['jobid'],$_GET['touserid']);

    if(count($res)>0){
        $user_apply_description=$func->getApplyUsers($_GET['jobid'],$_GET['touserid']);
    }else{
        $user_apply_description=$func->getApplyUsers($_GET['jobid'],$_SESSION['user_id']);
    }
    $applyJob_userinfo=$func->UserInfo($_GET['touserid']);
}else{
    $chatUsers = $func->getMyChatUsers();
}
include_once "includes/header.php";

?>


<section>
    <div class="wrapper">
        <?php
        if(empty($chatUsers)){
            ?>
            <div id="content" class="my-5">
                <nav style="background-color: #0067ce;" class="navbar navbar-expand-lg navbar-light bg-b">
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

                <div class=" border-right">

                    <?php
                    foreach ($chatUsers as $user){
                        if($_SESSION['user_id']==$user['receiver_id']){
                            $userinfo=$func->UserInfo($user['sender_id']);
                            $last_seen=$func->last_seen($user['sender_id']);
                            $new_messages=$func->mySendmebythisuser($_SESSION['user_id'],$user['sender_id'],$user['job_id']);
                        }else{
                            $userinfo=$func->UserInfo($user['receiver_id']);
                            $last_seen=$func->last_seen($user['receiver_id']);
                            $new_messages=$func->mySendmebythisuser($_SESSION['user_id'],$user['receiver_id'],$user['job_id']);
                        }


                        ?>
                        <a href="chat?touserid=<?=$userinfo[0]['id']?>&jobid=<?=$user['job_id']?>" class="list-group-item list-group-item-action border-0">
                            <!--                                                <div class="badge bg-success float-right">New Msg</div>-->
                            <div class="d-flex align-items-start">
                                <?php
                                if(empty($userinfo[0]['img_path']))
                                {
                                    ?>
                                    <img class="rounded-circle mr-1" src="images/avatar1.png" width="40" height="40" alt="no-image">
                                    <?php
                                }else{
                                    $image=explode('/',$userinfo[0]['img_path'] );

                                    $img= $image[1].'/'.$image[2];
                                    ?>
                                    <img src="<?=$img?>" class="rounded-circle mr-1" alt="Vanessa Tucker" width="40" height="40">
                                    <?php
                                }
                                ?>

                                <div class="flex-grow-1 ml-3 font-weight-bold">
                                    <?=$userinfo[0]['fname']?> - <?=$userinfo[0]['trading_name']?>
                                    <div class="position-relative" style="font-size: 10px">
                                        <?php
                                        if($last_seen=="Online"){
                                            ?>
                                            <span class="fas fa-circle chat-online"></span>

                                            <?php
                                        }else{
                                            ?>
                                            <!--                                            <span class="fas fa-circle chat-offline"></span>-->
                                            <?php
                                        }
                                        ?>
                                        <?=$last_seen?>

                                        <?php
                                        if(count($new_messages)>0 ){
                                            ?>
                                            <span style="top: -23px;right: -15px;font-size: 15px;" class="bg-danger position-absolute text-white rounded-circle px-1"><?= count($new_messages)?></span>
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
                    <hr class="d-block d-lg-none mt-1 mb-0">
                </div>

            </nav>

            <?php
            if(isset($_GET['touserid'])){
                ?>
                <div id="content">
                    <nav style="background-color: #0067ce;" class="navbar navbar-expand-lg navbar-light bg-b">
                        <div class="">
                            <a class="theme-btn mini green-bg brd-rd5 text-white" id="sidebarCollapse" title="">
                                <i class="fas fa-align-left pr-2" aria-hidden="true"></i>
                                Chats
                            </a>
                        </div>

                    </nav>

                    <div class="page-content-wrapper py-4 bg-white shadow rounded">
                        <div class="row justify-content-center ">
                            <div class="mt-2 mx-2">
                                <i class="fa fa-trash btn btn-danger" onclick="deleteChat(`<?=$_GET['touserid']?>`,`<?=$_GET['jobid']?>`,`<?=$_SESSION['user_id']?>`)" ></i>

                            </div>
                            <div class="px-4 border-bottom d-none d-lg-block">
                                <div class="text-center">
                                    <?php
                                    if(isset($job_info[0]['title'])){
                                        ?>
                                        <strong><?=$job_info[0]['title']?>
                                            <?php
                                            if($job_info[0]['user_id']==$_SESSION['user_id']){
                                                ?>
                                                <span> <a href="my-posted-jobs-details?job_id=<?=$job_info[0]['id']?>">view intrested tradespeople </a> </span>

                                                <?php
                                            }
                                            ?>

                                        </strong>

                                        <?php
                                    }
                                    ?>
                                </div>
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
                                        <div class="flex-grow-1 pl-3">
                                            <?php
                                            if(isset($to_user[0]['fname'])){
                                                ?>
                                                <strong><?=$to_user[0]['fname']?> - <?=$to_user[0]['trading_name']?></strong>
                                                <?php
                                            }
                                            ?>
                                            <!--                            <div class="text-muted small"><em>Typing...</em></div>-->
                                        </div>
                                        <br>
                                        <div class=" mx-2 d-block" style="font-size: 10px">
                                            <?php
                                            if($to_last_seen=="Online"){
                                                ?>
                                                <span class="fas fa-circle chat-online"></span>

                                                <?php
                                            }else{
                                                ?>
                                                <!--                                            <span class="fas fa-circle chat-offline"></span>-->
                                                <?php
                                            }
                                            ?>
                                            <?=$to_last_seen?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <?php
                            if((count($appliedUser)>0) && ($job_info[0]['user_id']==$_SESSION['user_id'])){
                                ?>

                                <div class="">
                                    <?php
                                    if($appliedUser[0]['status']==0){
                                        ?>
                                        <button  onclick="shortList(<?=$appliedUser[0]['user_id']?>,
                                        <?=$appliedUser[0]['job_id']?>)" id="shortList<?=$appliedUser[0]['user_id']?>" class="btn-bg-general text-white text-center px-4 py-2 text-decoration-none font-weight-bold rounded">Short list</button>
                                        <?php
                                    }else if($appliedUser[0]['status']==1&&$appliedUser[0]['worker_status']==0&&$appliedUser[0]['employer_status']==0){
                                        ?>
                                        <button id="hire_btn" onclick="employerstartJob(<?=$appliedUser[0]['user_id']?>,<?=$appliedUser[0]['job_id']?>)" class="btn-bg-general
                                                text-white text-center px-4 py-2 text-decoration-none font-weight-bold rounded">Hire</button>

                                        <?php
                                    }else if($appliedUser[0]['status']==1&&$appliedUser[0]['worker_status']==0&&$appliedUser[0]['employer_status']==1){
                                        ?>
                                        <button  class="btn-bg-general text-white text-center px-4 py-2 text-decoration-none font-weight-bold rounded">Wait for trademen's approval</button>
                                        <?php
                                    }else if($appliedUser[0]['status']==1&&$appliedUser[0]['worker_status']==1&&$appliedUser[0]['employer_status']==1){
                                        ?>
                                        <button class="btn-bg-general text-white text-center px-4 py-2 text-decoration-none font-weight-bold rounded">Job inprocessing</button>
                                        <?php
                                    }else if($appliedUser[0]['status']==2&&$appliedUser[0]['worker_status']==1&&$appliedUser[0]['employer_status']==1 && $appliedUser[0]['rating']==0){
                                        ?>
                                        <button  class="ratemodalopen btn-bg-general text-white text-center px-4 py-2 text-decoration-none
                                                font-weight-bold rounded" data-toggle="modal" data-target="#exampleModal" data-userid = "<?=$appliedUser[0]['user_id']?>" data-jobid="<?=$appliedUser[0]['job_id']?>">Rate this user</button>

                                        <?php
                                    }else if($appliedUser[0]['status']==2&&$appliedUser[0]['worker_status']==1&&$appliedUser[0]['employer_status']==1 && $appliedUser[0]['rating']==1){
                                        ?>
                                        <button class="btn-bg-general text-white text-center px-4 py-2 text-decoration-none font-weight-bold rounded">Feedback left</button>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                            }if( (count($checkStatus)>0) && ($checkStatus[0]['user_id']==$_SESSION['user_id']) &&
                                ($checkStatus[0]['job_id']==$_GET['jobid']) ) {
                                ?>
                                <div class="">
                                    <?php


                                    if(($_SESSION['user_role'] !='home_owner') &&
                                        ($checkStatus[0]['status']==1) &&
                                        ( $checkStatus[0]['worker_status']==0) &&
                                        ($checkStatus[0]['employer_status']==1)){
                                        ?>
                                        <button class="btn-bg-general text-white text-center px-4 py-2 text-decoration-none font-weight-bold rounded" id="startJob" onclick="workerstartJob(`<?=$checkStatus[0]['user_id']?>`,`<?=$checkStatus[0]['job_id']?>`)">Accept Job</button>
                                        <?php
                                    }else if(($_SESSION['user_role'] !='home_owner') &&
                                        ($checkStatus[0]['status']==1) &&
                                        ( $checkStatus[0]['worker_status']==1) &&
                                        ($checkStatus[0]['employer_status']==1)){
                                        ?>

                                        <button class="btn-bg-general text-white text-center px-4 py-2 text-decoration-none font-weight-bold rounded" id="completeJob" onclick="completeJob(`<?=$checkStatus[0]['user_id']?>`,`<?=$checkStatus[0]['job_id']?>`)">Complete</button>
                                        <?php
                                    }else if(($_SESSION['user_role'] !='home_owner') &&
                                        ($checkStatus[0]['status']==2) &&
                                        ($checkStatus[0]['worker_status']==1) &&
                                        ($checkStatus[0]['employer_status']==1)){
                                        ?>
                                        <button class="btn-bg-general text-white text-center px-4 py-2 text-decoration-none font-weight-bold rounded" >Completed</button>
                                        <?php

                                    }
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>

                        <script>
                            var lastmsg_id="";
                            var touser_id="";
                            var jobid ="";
                        </script>
                        <div class="position-relative">
                            <div id="messages" class="chat-messages p-4">

                                <!--                                load default message-->
                                <div class="chat-message-right pb-4">
                                    <div>

                                        <img class="rounded-circle mr-1" src="images/avatar1.png" width="40" height="40" alt="no-image">

                                        <div class="text-muted small text-nowrap mt-2" style="font-size: 10px"><?=date('H:i a')?></div>
                                    </div>
                                    <div class="flex-shrink-1 text-white rounded py-2 px-3 mr-3 bubble" style="background-color: #7EC8E3">
                                        <div class="font-weight-bold mb-1">Buildela automated friendly reminder </div>
                                        <p>Please respect all users on our platform, no abuse will be tolerated, and may result in account deletion.</p>
                                        <p><u>Here are some key point to discuss:</u></p>
                                        <span class="d-block"> - The work to be carried out.</span>
                                        <span class="d-block"> - The quote.</span>
                                        <span class="d-block"> - A start date & time.</span>
                                        <span class="d-block"> - The job duration.</span>
                                        <span class="d-block"> - Who will supply the parts.</span>


                                    </div>
                                </div>
                                <?php
                                if($user_apply_description[0]['user_id']== $_SESSION['user_id']){
                                    ?>
                                    <div class="chat-message-right pb-4">
                                        <div>
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
                                            <div class="text-muted small text-nowrap mt-2" style="font-size: 10px"><?=date('Y-m-d',strtotime($user_apply_description[0]['apply_date']))?></div>
                                        </div>
                                        <div class="flex-shrink-1 bg-blue-color text-white rounded py-2 px-3 mr-3 bubble">
                                            <div class="font-weight-bold mb-1">You</div>
                                            <?=$user_apply_description[0]['message']?>
                                        </div>
                                    </div>

                                    <?php
                                }else{
                                    ?>
                                    <div class="chat-message-left pb-4">
                                        <div>
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
                                            <div class="text-muted small text-nowrap mt-2" style="font-size: 10px"><?=date('Y-m-d',strtotime(
                                                    $user_apply_description[0]['apply_date']))?></div>
                                        </div>
                                        <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                                            <div class="font-weight-bold mb-1">
                                                <?=$applyJob_userinfo[0]['fname']?></div>
                                            <?=$user_apply_description[0]['message']?>
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
                                //                            $receiver=$func->UserInfo($message['receiver_id']);
                                $earlier = new DateTime($message['create_date']);
                                $later = new DateTime(date("Y-m-d H:i:s"));
                                $diff = $later->diff($earlier)->format("%a");

                                if($message['sender_id']==$_SESSION['user_id']){
                                ?>
                                    <div class="chat-message-right pb-4">
                                        <div>
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
                                            <div class="text-muted small text-nowrap mt-2" style="font-size: 10px"><?=$diff==0?date('H:i a',strtotime($message['create_date'])) :date('Y-m-d H:i a',strtotime($message['create_date']))?></div>
                                        </div>
                                        <div class="flex-shrink-1 bg-blue-color text-white rounded py-2 px-3 mr-3 bubble">
                                            <div class="font-weight-bold mb-1">You</div>
                                            <?=$message['message']?>
                                        </div>
                                    </div>
                                    <?php
                                }else{
                                    ?>

                                    <div class="chat-message-left pb-4">
                                        <div>
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
                                            <div class="text-muted small text-nowrap mt-2" style="font-size: 10px"><?=$diff==0?date('H:i a',strtotime($message['create_date'])) :date('Y-m-d H:i a',strtotime($message['create_date']))?></div>
                                        </div>
                                        <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                                            <div class="font-weight-bold mb-1"><?=$sender[0]['fname']?></div>
                                            <?=$message['message']?>
                                        </div>
                                    </div>
                                    <?php

                                }
                                }
                                ?>

                            </div>
                        </div>

                        <div class="custom-flex-grow-0 py-3 px-4 border-top">
                            <div class="input-group">
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
                    <nav style="background-color: #0067ce;" class="navbar navbar-expand-lg navbar-light bg-b">
                        <div class="">
                            <a class="theme-btn mini green-bg brd-rd5 text-white text-center" >
                                <!--                        <i class="fas fa-align-left pr-2" aria-hidden="true"></i>-->
                                Select a person to start chat
                            </a>
                        </div>

                    </nav>
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


<?php include_once "includes/footer.php"?>
<script type="text/javascript">
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
    setInterval(function(e){

        $.ajax({
            url:"serverside/post.php",
            method:"post",
            data:{
                func:69,
                touser_id:touser_id,
                lastmsg_id:lastmsg_id,
                jobid:jobid
            },
            success:function(data){
                // return;
                console.log(data);
                if(data.trim()!='no-msg'){
                    var msgdata = JSON.parse(data);
                    lastmsg_id = msgdata.msgsarray[msgdata.msgsarray.length-1].id;
                    // console.log(msgdata.msgsstring);
                    $("#messages").append(msgdata.msgsstring);
                    objDiv.scrollTo(0,objDiv.scrollHeight);
                    // console.log(newmsg);
                }

                // lastmsg_id = newmsg.

            }
        });
    },1500);

    $("#message").keypress(function (event){

        if (event.keyCode === 13) { // key code of the keybord key
            $("#send_msg_btn").click();
        }
    });

</script>





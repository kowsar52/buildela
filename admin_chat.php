<?php
include_once "includes/header.php";

require_once "serverside/functions.php";
include_once "serverside/session.php";
$func=new  Functions();


$messages=array();

if(isset($_GET['jobid']) ){
    $messages=$func->showChattoadmin($_GET['jobid']);
    $job_info=$func->getSingleJob($_GET['jobid']);
}
?>


<section>
    <div class="wrapper">


        <?php
        if(isset($_GET['jobid'])){
            ?>
            <div id="content" class="m-3" >
                <nav style="background-color: #0067ce;" class="navbar navbar-expand-lg navbar-light bg-b">
                    <div class="">
                        <a class="theme-btn mini green-bg brd-rd5 text-white" id="sidebarCollapse" title="">
                            <i class="fas fa-align-left pr-2" aria-hidden="true"></i>
                            Chats
                        </a>
                    </div>

                </nav>
                <div class="page-content-wrapper py-4 bg-white shadow rounded">

                    <div class="px-4 border-bottom d-none d-lg-block">
                        <div class="text-center">
                            <?php
                            if(isset($job_info[0]['title'])){
                                ?>
                                <strong><?=$job_info[0]['title']?></strong>

                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <script>
                        var lastmsg_id;
                        var touser_id;
                    </script>
                    <div class="position-relative">

                        <div id="messages" class="chat-messages1 p-4">

                            <?php
                            if(!empty($messages)){
                                $first_person=$messages[0]['sender_id'];
                            foreach ($messages as $message){
                                ?>
                                <script>
                                    lastmsg_id = '<?=$message['id']?>'
                                    touser_id = '<?=$message['sender_id']?>';
                                    jobid = '<?=$_GET['jobid']?>';
                                </script>
                            <?php
                            $sender=$func->UserInfo($message['sender_id']);
                            $earlier = new DateTime($message['create_date']);
                            $later = new DateTime(date("Y-m-d H:i:s"));
                            $diff = $later->diff($earlier)->format("%a");

                            if($message['sender_id']==$first_person){
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
                                        <div class="text-muted small text-nowrap" style="font-size: 10px"><?=$diff==0?date('H:i a',strtotime($message['create_date'])) :date('Y-m-d H:i a',strtotime($message['create_date']))?></div>
                                    </div>
                                    <div class="flex-shrink-1 bg-blue-color text-white rounded py-2 px-3 mr-3 bubble">
                                        <div class="font-weight-bold mb-1"><?=$sender[0]['fname']?></div>
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
                                        <div class="text-muted small text-nowrap" style="font-size: 10px"><?=$diff==0?date('H:i a',strtotime($message['create_date'])) :date('Y-m-d H:i a',strtotime($message['create_date']))?></div>
                                    </div>
                                    <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                                        <div class="font-weight-bold mb-1"><?=$sender[0]['fname']?></div>
                                        <?=$message['message']?>
                                    </div>
                                </div>
                            <?php

                            }//else
                            }//foreach
                            }else{
                            ?>
                                <h3>No Chat available on this job.</h3>
                                <?php
                            }
                            ?>

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
                            No Chat available on this job.
                        </a>
                    </div>

                </nav>
            </div>
            <?php
        }
        ?>


    </div>
</section>

<?php include_once "includes/footer-no-cta.php"?>
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
        // console.log("a");
        $.ajax({
            url:"serverside/post.php",
            method:"post",
            data:{
                func:69,
                touser_id:touser_id,
                lastmsg_id:lastmsg_id,
                jobid:jobid,
            },
            success:function(data){
                // console.log(data);
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


</script>





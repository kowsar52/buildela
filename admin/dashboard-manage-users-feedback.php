<?php
require_once "../serverside/functions.php";
if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
    // session isn't started
    session_start();
}
if((isset($_SESSION['user_id'])) &&( $_SESSION['user_type']==1 )){

}else{
    //header('Location: sign-in');
    ?>
    <script type="text/javascript">
        window.location.href="../login";
    </script>
    <?php
    exit();
}

$func=new Functions();
$feedbacks=$func->getAllFeedbacks();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All Users</title>
    <?php include "includes/dashboard-links.php"; ?>
    <style>
        /*styling for rating */
        .rating-feedback {
            position: relative;
            display: inline-block;
            border: none;
            font-size: 14px;
            margin: 0px auto;
            left: 50%;
            transform: translateX(-50%);
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
            margin: 5px;
            display: inline-block;
            font-size: 2em;
            fill: #ccc;
            user-select: none;
        }
        .rating-feedback label svg {
            width: 30px;
            height: auto;
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
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Preloader -->
    <!--    <div class="preloader flex-column justify-content-center align-items-center">-->
    <!--        <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">-->
    <!--    </div>-->

    <!-- Navbar -->
    <?php include "includes/header.php" ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include "includes/sidebar.php" ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Users feedbacks</h1>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <!-- Main row -->
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-between ">
                            <h1>Users feedbacks</h1>
                        </div>
                    </div>
                    <table id="userTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>To name</th>
                            <th>From name</th>
                            <th>Country</th>
                            <th>Job title</th>
                            <th>Stars</th>
                            <th>Send date</th>
                            <th>Message</th>
							                            <th>IP/Device</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($feedbacks as $temp){
                            $touser=$func->UserInfo($temp['user_id']);
                            $fromuser=$func->UserInfo($temp['from_user_id']);
                            if( isset($_SESSION['country']) && $_SESSION['country'] != "" ){

                                if(!empty($fromuser) && $fromuser[0]['country'] != $_SESSION['country'] ){
                                    continue ;
                                }
                            }//if
                            ?>
                            <tr>
                                <td><?=$touser[0]['fname']?></td>
                                <td><?=$fromuser[0]['fname']?></td>
                                <td><?=$fromuser[0]['country']?></td>
                                <td><?=$temp['job_title']?></td>
                                <td>
                                    <?php
                                    for($i=0;$i<$temp['ratings']; $i++){
                                        ?>
                                        <span class="fa fa-star" aria-hidden="true" style="color:#FFC107;"></span>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td><?=date('d-M-Y',strtotime($temp['send_date']))?></td>
                                <td><?=$temp['message']?></td>
         <td><?php
$userInfo = json_decode($temp['user_info'], true); // Decode the JSON string into an associative array

// Extract the IP address and device info
$ipAddress = $userInfo['ip_address'];
$deviceInfo = $userInfo['device_info'];

// Display the formatted information
echo "IP address: " . $ipAddress . " <br><br> Device info: " . $deviceInfo;
?></td>
                                <td class="action">
                                    <button class="btn btn-primary my-1 edit_btn" data-toggle="modal" data-feedback_id="<?=$temp['id']?>" data-message="<?=$temp['message']?>" data-stars="<?=$temp['ratings']?>" data-target="#exampleModal" >Edit</button>
                                    <button class="btn btn-danger my-1"  onclick="deleteFeedback(this.id)" id="<?=$temp['id']?>" ></i>Delete</button>
                                </td>
                            </tr>
                            <?php

                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

    </div>
    </section>
</div>


<aside class="control-sidebar control-sidebar-dark">
</aside>

</div>

<!-- Modal for rating -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Review</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="UpdaterateUser">
                <div class="modal-body">
                    <input value="" id="feedback_id" type="hidden">
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
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php include 'includes/footer.php' ?>
<script>
    $(".edit_btn").click(function (e){
        e.preventDefault();
        $("#feedback_id").val($(this).data("feedback_id"));
        let stars= $(this).data("stars");
        if(stars==1){
            $("#st5").attr('checked', 'checked');
        }else if(stars==2){
            $("#st4").attr('checked', 'checked');
        }else if(stars==3){
            $("#st3").attr('checked', 'checked');
        }else if(stars==4){
            $("#st2").attr('checked', 'checked');
        }else if(stars==5){
            $("#st1").attr('checked', 'checked');
        }

        $("#message").val($(this).data("message"));
    });
</script>
<script>
    $( document ).ready(function() {
        $("#usersfeedback").addClass("active");
        $("#userTable").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
        });

    });
</script>
</body>
</html>		


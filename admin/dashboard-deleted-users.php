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
$users=$func->getAllDeletedUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All Users</title>
    <?php include "includes/dashboard-links.php"; ?>
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
                        <h1 class="m-0">All Users</h1>
                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Main row -->
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-between ">
                            <h1>All Users</h1>
                        </div>

                    </div>
                    <table id="userTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>City</th>
                            <th>Reason Left</th>
                            <th>Date Left</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($users as $user){
                            $user_feedback=$func->getUserRatting($user['id']);
                            $date=explode(" ", $user['day_left']);
                            $mySkills=$func->getMySkills($user['id']);
                            $account=$func->getAccountDetails($user['id']);
                            ?>
                            <tr>
                                <td class="title"><a href="#"><?=$user['fname']?> <?=$user['lname']?></a></td>
                                 <?php
                                 if($user['user_role']=='home_owner'){
                                     ?>
                                     <td>HomeOwner</td>
                                        <?php

                                 }else if($user['user_role']=='jobs_person'){
                                     ?>
                                     <td>Tradesmember - Name: <?= empty($user['trading_name']) ? 'Not Set' : $user['trading_name'] ?>
</td>
                                     <?php
                                 }
                                 ?>
                                <td><?=$user['email']?></td>
                                <td><?=$user['phone']?></td>
                                <td><?=$user['town']?></td>
                                <td><?=$user['reason_left']?></td>
                                <td><?=$date[0]?></td>
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

<!--update account details-->
<div class="modal fade" id="view_account" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Account Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="append_account_details">


            </div>

        </div>
    </div>
</div>
<!--Give reward-->
<div class="modal fade" id="givereward" tabindex="-1" role="dialog" aria-labelledby="example" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="example">Give Reward</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body" id="reward_tradeperson">
                    <form id="reward_tradeperson1" class="my-2">
                        <h1 class="text-center card-header">Give reward to <span id="settrademembername"></span>
                            <small>(Tradesmember)</small> </h1>

                        <input type="hidden"  class="form-control" id="tradeperson_name">
                        <input type="hidden"  class="form-control" id="tradeperson_email">
                        <input type="hidden"  class="form-control" id="tradeperson_id">
<input type="hidden"  class="form-control" id="tradeperson_town">
                        <div class="row">
                            <div class="col-6 form-group input_parent">
                                <label for="reward_date">Select a date</label>
                                <input type="text" required class="form-control" id="reward_date1">
                            </div>
                            <div class="col-6 form-group input_parent">
                                <label for="reward_date">Select reward_type</label>
                                <select id="reward_type1" class="form-control">
                                    <option value="Premier league">Premier league</option>
                                    <option value="Screwfix">Screwfix</option>
                                    <option value="Jet2holidays">Jet2holidays</option>
                                </select>
                            </div>

                        </div>
                        <button type = 'button' id="tradesperson_btn" class="w-100 btn btn-info" >Submit</button>

                    </form>
                </div>
                <div class="card-body" id="reward_homeowner">
                    <form id="reward_homeowner1" class="form my-2">
                        <h1 class="text-center card-header">Give reward to <span id="sethomeownername"></span>
                            <small> (homeowner) </small></h1>

                        <input type="hidden" class="form-control" id="homeowner_name">
                        <input type="hidden" class="form-control" id="homeowner_email">
                        <input type="hidden"  class="form-control" id="homeowner_id">
                        <input type="hidden"  class="form-control" id="homeowner_town">

                        <div class="row">
                            <div class="col-6 form-group input_parent">
                                <label for="reward_date">Select a date</label>
                                <input type="text" required  class="form-control" id="reward_date">
                            </div>
                            <div class="col-6 form-group input_parent">
                                <label for="reward_type">Select reward_type</label>
                                <select id="reward_type" class="form-control">
                                    <option value="ASDA">ASDA</option>
                                    <option value="CAR">CAR</option>
                                    <option value="Jet2holidays">Jet2holidays</option>
                                </select>
                            </div>

                        </div>

                        <button type ='button' id="homeowner_btn" class="w-100 btn btn-info" >Submit</button>

                    </form>
                </div>


            </div>

        </div>
    </div>
</div>


<?php include 'includes/footer.php' ?>
<script>
    $( document ).ready(function() {
        $("#delete_users").addClass("active");

        $("#userTable").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
        });

    });
</script>
<script>
    $( document ).ready(function() {
        $("#reward_tradeperson").hide();
        $("#reward_homeowner").hide();
    });

    // $(".reward").click(function (e){
    //     e.preventDefault();
    //     user_type= $(this).data('user_type');

    //     if(user_type.trim()=='jobs_person'){

    //         $("#tradeperson_email").val($(this).data('useremail'))
    //         $("#tradeperson_id").val($(this).data('userid'))
    //         $("#tradeperson_name").val($(this).data('userfname'))

    //         $("#reward_tradeperson").show();
    //         $("#reward_homeowner").hide();

    //     }else if(user_type.trim()=='home_owner') {


    //         $("#homeowner_email").val($(this).data('useremail'))
    //         $("#homeowner_id").val($(this).data('userid'))
    //         $("#homeowner_name").val($(this).data('userfname'))

    //         $("#reward_homeowner").show();
    //         $("#reward_tradeperson").hide();
    //     }

    // })

    function showDiv(user_role,id,fname,lname,town,email){
        // console.log(user_role);
        // console.log(id);
        // console.log(fname);
        // console.log(email);

        user_type= user_role;

                if(user_type.trim()=='jobs_person'){
                    $("#tradeperson_email").val(email)
                    $("#tradeperson_id").val(id)
                    $("#tradeperson_town").val(town)
                    $("#tradeperson_name").val(fname + " " + lname);

                    $("#reward_tradeperson").show();
                    $("#reward_homeowner").hide();
                    $("#settrademembername").html(fname);
                    

                }else if(user_type.trim()=='home_owner') {


                    $("#homeowner_email").val(email)
                    $("#homeowner_id").val(id)
                    $("#homeowner_town").val(town)
                    $("#homeowner_name").val(fname + " " + lname);
                    $("#sethomeownername").html(fname);

                    $("#reward_homeowner").show();
                    $("#reward_tradeperson").hide();
                }
        
    }

    // $("#select_person").change(function (e){
    //     e.preventDefault();
    //     person=$("#select_person option:selected").val();
    //
    //     if(person==0){
    //         $("#reward_tradeperson").show();
    //         $("#reward_homeowner").hide();
    //     }else if(person==1){
    //         $("#reward_tradeperson").hide();
    //         $("#reward_homeowner").show();
    //     }else if(person==3){
    //         $("#reward_tradeperson").hide();
    //         $("#reward_homeowner").hide();
    //     }
    // })

    var dp=$("#reward_date").datepicker( {
        format: "yyyy-mm",
        startView: "months",
        minViewMode: "months"
    });
    var dp=$("#reward_date1").datepicker( {
        format: "yyyy-mm",
        startView: "months",
        minViewMode: "months"
    });

</script>
</body>
</html>

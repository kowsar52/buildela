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
$electrical=$func->getElectricalVerifyRequests();
$gas=$func->getGasVerifyRequests();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Users</title>
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
                        <h1 class="m-0">Verify Users</h1>
                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Main row -->
                <div class=" my-2 card">
                    <div class="card-body">
                        <div class="row justify-content-between ">
                            <h4>Electrical Certification</h4>
                        </div>

                    </div>
                    <table id="userTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Country</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($electrical as $req){
                            $user =$func->UserInfo($req['user_id']);
                            if( isset($_SESSION['country']) && $_SESSION['country'] != "" ){

                                if(!empty($user) && $user[0]['country'] != $_SESSION['country'] ){
                                    continue ;
                                }
                            }

                            ?>
                            <tr>
                                <td class="title"><a href="#"><?= empty($user) ? "" : $user[0]['fname']?></a></td>
                                <td><?= empty($user) ? "" : $user[0]['email']?></td>
                                <td><?= empty($user) ? "" : $user[0]['phone']?></td>
                                <td><?= empty($user) ? "" : $user[0]['country']?></td>
                                <td><?= empty($user) ? "" : $req['create_date']?></td>
                                <?php

                                if($req['status']==1){
                                    ?>
                                    <td class="badge m-1 bg-success">verified</td>
                                    <?php
                                }else{
                                    ?>
                                    <td class="badge m-1 bg-warning">Un verified</td>
                                    <?php
                                }
                                ?>
                                <td class="action">
                                    <a class="btn btn-primary m-1" href="certification?id=<?=$req['id']?>&type=electrical">View Certifications</a>
                                </td>
                            </tr>
                            <?php

                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <div class=" my-2 card">
                    <div class="card-body">
                        <div class="row justify-content-between ">
                            <h4>GAS Certification</h4>
                        </div>

                    </div>
                    <table id="userTable1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Country</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($gas as $req){
                            $user =$func->UserInfo($req['user_id']);
                            if( isset($_SESSION['country']) && $_SESSION['country'] != "" ){

                                if(!empty($user) && $user[0]['country'] != $_SESSION['country'] ){
                                    continue ;
                                }
                            }//if
                            ?>
                            <tr>
                                <td class="title"><a href="#"><?=empty($user) ? "" : $user[0]['fname']?></a></td>
                                <td><?= empty($user) ? "" : $user[0]['email']?></td>
                                <td><?=empty($user) ? "" : $user[0]['phone']?></td>
                                <td><?=empty($user) ? "" : $user[0]['country']?></td>
                                <td><?=$req['create_date']?></td>
                                <?php

                                if($req['status']==1){
                                    ?>
                                    <td class="badge m-1 bg-success">verified</td>
                                    <?php
                                }else{
                                    ?>
                                    <td class="badge m-1 bg-warning">Un verified</td>
                                    <?php
                                }
                                ?>
                                <td class="action">
                                    <a class="btn btn-primary m-1" href="certification?id=<?=$req['id']?>&type=gas">View Certifications</a>
                                </td>
                            </tr>
                            <?php

                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </section>
    </div>
    <aside class="control-sidebar control-sidebar-dark">
    </aside>

</div>

<?php include 'includes/footer.php' ?>
<script>
    $( document ).ready(function() {

        $("#verify_users").addClass("active");

        $("#userTable").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
        });
        $("#userTable1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
        });


    });
</script>
</body>
</html>

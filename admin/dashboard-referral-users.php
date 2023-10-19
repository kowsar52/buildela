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
if( isset($_SESSION['country']) && $_SESSION['country'] != "" ){

    $users=$func->getAllUsersByCountry($_SESSION['country']);

}else{

    $users=$func->getAllUsers();
}

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
                            <th>Email</th>
                            <th>Country</th>
                            <th>Referral Code</th>
                            <th>Referral By</th>
                            <th>Is Referred</th>
                            <th>Balance</th>
                            <th>Count</th>
                            <th>Actions</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($users as $user){
                            $count_ref_users=$func->getMyRefferaluser($user['to_referral_code']);

                            ?>
                            <tr>
                                <td class="title"><a href="#"><?=$user['fname']?></a></td>
                                <td><?=$user['email']?></td>
                                <td><?=$user['country']?></td>
                                <td><?=$user['to_referral_code']?></td>
                                <td><?=$user['from_referral_code']?></td>
                                <th>
                                <?php
                                if(!empty($user['from_referral_code'])){
                                    ?>
                                    <span class="badge badge-warning p-1">YES</span>
                                    <?php
                                }else{
                                    ?>
                                    <span class="badge badge-info p-1">NO</span>
                                <?php
                                }
                                ?>
                                </th>
                                <td><?=$user['balance']?></td>
                                <td><?=count($count_ref_users)?></td>

                                <td class="action">
                                    <a class="btn btn-info my-1" onclick="rewardUser(this.id)" id="<?=$user['id']?>" ></i>Give Reward</a>
                                </td>
                            </tr>
                            <?php

                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->


    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include 'includes/footer.php' ?>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<script>
    $( document ).ready(function() {
        $("#ref_users").addClass("active");

        $("#userTable").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "order": [[ 6, "desc" ]]
        });

    });
</script>
</body>
</html>

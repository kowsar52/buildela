<?php
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
require_once "../serverside/functions.php";
$func=new Functions();

$user=$func->UserInfo($_SESSION['user_id']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel = "icon" type = "image/jpeg" href = "../images/favicon.png">
    

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
                        <h1 class="m-0">User Profile</h1>
                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container">
                <!-- Main row -->
                <div class="card">
                    <div class="card-header">
                        <h4>Update User info</h4>
                    </div>
                    <div class="card-body">
                        <form id="update_profile">
                            <input type="hidden" id="uid" value="<?=$user[0]['id']?>">
                            <div class="row justify-content-center">
                                <div class="col-6">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" required  id="fname"  value="<?=$user[0]['fname']?>" >

                                    <label>Email</label>
                                    <input type="email" class="form-control" required id="email"  value="<?=$user[0]['email']?>" >
                                     <div class="text-center my-2">
                                        <button class="btn my-2 btn-success">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card my-4">
                    <div class="card-header">
                        <h4 class="text-danger">Update User Password</h4>
                    </div>
                    <div class="card-body">
                        <form id="updatePassword">
                            <input type="hidden" id="up_id" value="<?=$_SESSION['user_id']?>">
                            <div class="row justify-content-center">
                                <div class="col-6">
                                    <label>Current Password</label>
                                    <input type="password" class="form-control" id="currentpass">

                                    <label>New Password</label>
                                    <input type="password" class="form-control" id="newpass">

                                    <label>Confirm New Password</label>
                                    <input type="password" class="form-control" id="cofirmpass">

                                    <div class="text-center my-2">
                                        <button class="btn btn-success">Update Password</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
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
<script src="customjs/myjs.js"></script>
</body>
</html>
<script>
    $( document ).ready(function() {
        $("#profile").addClass("active");

    });

</script>

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
$settings=$func->getSettings();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Settings</title>
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
                        <h1 class="m-0">Settings</h1>
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
                    <h1 class="card-header text-center">Settings</h1>

                    <div class="card-body">
                        <form id="updateSettings" class="form m-5">
                            <div class="row justify-content-center">
                                <div class="col-8">
                                    <div class="form-group input_parent">
                                        <label for="fname">Subscription</label>
                                        <input type="text" class="form-control" value="<?=$settings[0]['subscription_price']?>" id="price">
                                    </div>
                                    <div class="form-group input_parent">
                                        <label for="lname">Stripe Public Key</label>
                                        <input type="text" class="form-control" value="<?=$settings[0]['stripe_public_key']?>" id="s_public_key">
                                    </div>
                                    <div class="form-group input_parent">
                                        <label for="email">Stripe Secret Key</label>
                                        <input type="text" class="form-control" value="<?=$settings[0]['stripe_private_key']?>" placeholder="Enter Email" id="s_private_key">
                                    </div>
                                    <div class="text-center my-2">
                                        <button type = 'submit' class="btn btn-primary" > Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>


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
        $("#settings").addClass("active");

    });
</script>
</body>
</html>

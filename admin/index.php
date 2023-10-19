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
$countApplicant=0;
$func=new Functions();
$user=$func->UserInfo($_SESSION['user_id']);
$myPostedjobs=$func->getMyPostedJobs($_SESSION['user_id']);
foreach ($myPostedjobs as $jobs) {
    $res=$func->countMyApply($jobs['id']);
    $countApplicant+=count($res);
}
$myPostedjobs=count($myPostedjobs);
if( isset($_GET['country']) && $_GET['country'] != "" ){

    $_SESSION['country']=$_GET['country'];
    $country=$_GET['country'];

    // $totalHomeOwners = count($func->totalHomeOwnersByCountry($country));
    // $totalPaidUsers = count($func->totalPaidUsersByCountry($country));
    // $totalUnPaidUsers = count($func->totalUnPaidUsersByCountry($country));
    // $totalDBSUser = count($func->totalDBSUsersByCountry($country)); //( Can be deleted )
    // $totalTopRatedUser = $func->totalTopRatedUserByCountry($country);
    // $totalJobs = count($func->getAllJobsByCountry($country));
    // $totalFeedbacks = count($func->AllfeedBacks());

    $totalHomeOwners = 0;
    $totalPaidUsers = 0;
    $totalUnPaidUsers = 0;
    $totalDBSUser = 0; //( Can be deleted )
    $totalTopRatedUser = 0;
    $totalJobs = 0;
    $totalFeedbacks = 0;


}else {


    unset($_SESSION["country"]);
    $totalHomeOwners = count($func->totalHomeOwners());
    $totalPaidUsers = count($func->totalPaidUsers());
    $totalUnPaidUsers = count($func->totalUnPaidUsers());
    $totalDBSUser = count($func->totalDBSUsers());
    $totalTopRatedUser = $func->totalTopRatedUser();
    $totalJobs = count($func->getAllJobs());
    $totalFeedbacks = count($func->AllfeedBacks());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>

    <?php include "includes/dashboard-links.php"; ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Preloader -->
    <!--  <div class="preloader flex-column justify-content-center align-items-center">-->
    <!--    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">-->
    <!--  </div>-->

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
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="container">

                                <div class="row">
                                    <div class="col-md-6 px-0 px-md-3">
                                        <label for="country">Search by country</label>
                                        <select class="form-control form-control-lg"  id="country">
                                            <option value="">--Select Country--</option>
                                            <option value="America">America</option>
                                            <option value="Australia">Australia</option>
                                            <option value="Canada">Canada</option>
                                            <option value="Ireland">Ireland</option>
                                            <option value="Italy">Italy</option>
                                            <!--                                            <option value="South Africa">South Africa</option>-->
                                            <option value="Turkey">Turkey</option>
                                            <option value="UK">UK</option>
                                            <!--                                            <option value="United Arab Emirates">United Arab Emirates</option>-->

                                        </select>
                                    </div>

                                    <div class="col-md-4 my-4 px-0 px-md-3">
                                        <button type="button" id="search" class=" mt-1 btn btn-primary">Search</button>
                                        <button type="button" id="reset" class=" mt-1 btn btn-primary">Clear</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- total home owner-->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><?=$totalHomeOwners?></h3>

                                <p>Total Home Owners</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-user"></i>
                            </div>
                            <!--                            <a href="dashboard-manage-users" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>-->
                        </div>
                    </div>
                    <!--total tradesman-->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3><?=$totalPaidUsers?></h3>

                                <p>Total Tradesmen</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-user"></i>
                            </div>
                            <!--                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>-->
                        </div>
                    </div>
                    <!-- unpaid tradesman-->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3><?=$totalUnPaidUsers?></h3>

                                <p>UnPaid Tradesmen</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-user"></i>
                            </div>
                            <!--                            <a href="messages" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>-->
                        </div>
                    </div>
                    <!-- DBS tradesman-->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><?=$totalDBSUser?></h3>

                                <p>DBS Verified Users</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-user-check"></i>
                            </div>
                            <!--                            <a href="dashboard-manage-users.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>-->
                        </div>
                    </div>

                </div>
                <div class="row">
                    <!-- top rated user-->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><?=$totalTopRatedUser?></h3>

                                <p>Top Rated Users </p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-medal"></i>
                            </div>
                            <!--                            <a href="dashboard-manage-users.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>-->
                        </div>
                    </div>
                    <!--total feedback-->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-secondary">
                            <div class="inner">
                                <h3><?=$totalFeedbacks?></h3>

                                <p>Total Messages</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-comment"></i>
                            </div>
                            <!--                            <a href="messages" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>-->
                        </div>
                    </div>
                    <!--  Active jobs-->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3><?=$totalJobs?></h3>

                                <p>Active Job Listings</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-home"></i>
                            </div>
                            <!--                            <a href="messages" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>-->
                        </div>
                    </div>


                </div>

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
<script>
    $( document ).ready(function() {
        $("#home").addClass("active");

    });
</script>
<script>
    $("#search").click(function (event){

        event.preventDefault();
        let location=$("#location").val();
        let country=$("#country").val();
        if(country!=""){
            window.location.href="index?country="+country;
        }


    });
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);

    $("#country").val(urlParams.get('country'));

    $("#reset").click(function (e){
        e.preventDefault();
        window.location.href="index";
    });

</script>
</body>
</html>

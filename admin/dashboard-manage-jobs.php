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

    $jobs=$func->getAllJobsByCountry($_SESSION['country']);


}else{

    $jobs=$func->getAllJobs();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All Jobs</title>
    <?php include "includes/dashboard-links.php"; ?>
    <style>
        #userTable tr {
            text-align: center;
        }
        #userTable td, #userTable th {
            vertical-align: middle;
        }
        .action {
            display: flex;
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
                        <h1 class="m-0">All Jobs</h1>
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
                            <h1>All Jobs</h1>
                        </div>

                    </div>
                    <table id="userTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Title</th>
                            <th>Country</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th style="min-width: 56px">Posted Date</th>
                            <th>Applicant</th>
                            <th>Status</th>
                            <th>Actions</th>

                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        foreach($jobs as $job){
                            $user=$func->UserInfo($job['user_id']);
                            $main=$func->SingleMainCategory($job['main_type']);
                            $count=$func->countApply($job['id']);
                            ?>

                            <tr>
                                <td><?=$user[0]['fname']?></td>
                                <td><?=$user[0]['email']?></td>
                                <td><?=$user[0]['phone']?></td>
                                <td title="<?=$job['title']?>"><?=$func->limitWords($job['title'], 7)?></td>
                                <td><?=$job['country']?></td>
                                <td><?=$main[0]['category_name']?></td>
                                <td title="<?=$job['job_discription']?>"><?=$func->limitWords($job['job_discription'], 7)?></td>
                                <td><?=$job['created_date']?></td>
                                <td><?=$count[0]['job_count']?></td>
                                <td>
                                    <?php
                                    if($job['status']==1){
                                        ?>
                                        <span class="badge badge-success">Active</span>

                                        <?php
                                    }else{
                                        ?>
                                        <span class="badge badge-danger">Inactive</span>
                                        <?php
                                    }
                                    ?>
                                </td>
                                <td class="action">
                                    <?php

                                    if($job['status']==1){
                                        ?>
                                        <a class="btn btn-danger m-1" onclick="blockJob(this.id)" id="<?=$job['id']?>" title="Block"><i class="fa fa-ban" aria-hidden="true"></i></a>
                                        <?php
                                    }else{
                                        ?>
                                        <a class="btn btn-success m-1" onclick="activeJob(this.id)" id="<?=$job['id']?>" title="Activate"><i class="fa fa-mouse-pointer" aria-hidden="true"></i></a>
                                        <?php
                                    }
                                    ?>
									
                                    <button  class="btn btn-warning m-1" onclick="RepostJob(<?=$job['id']?>)" title="Repost"><i class="fa fa-retweet" aria-hidden="true"></i></button>
									<button  class="btn btn-warning m-1" onclick="completeJobadmin(<?=$job['id']?>)" title="Mark as completed"><i class="fa fa-check" aria-hidden="true"></i></button>
                                    <button  class="btn btn-danger m-1" onclick="deleteJobs(<?=$job['id']?>)" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    <a class="btn btn-info m-1" href="../admin_chat?jobid=<?=$job['id']?>" target="_blank" title="Go to chat"><i class="fa fa-comments" aria-hidden="true"></i></a>
                                    <a class="btn btn-primary m-1" href="../my-posted-jobs-details?job_id=<?=$job['id']?>" title="View job"><i class="fa fa-eye" aria-hidden="true"></i></a>
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
        $("#jobs").addClass("active");

        $("#userTable").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "order": [[ 7, "desc" ]]
        });

    });
</script>
</body>
</html>

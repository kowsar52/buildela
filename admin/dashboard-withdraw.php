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
$withdraw=$func->getAllWithdraw();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Withdraw Request</title>
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
                        <h1 class="m-0">All Withdraw Requests</h1>
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
                            <h1>Withdraw Requests</h1>
                        </div>

                    </div>
                    <table id="userTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Country</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($withdraw as $with){
                            $user=$func->UserInfo($with['user_id']);
                            if( isset($_SESSION['country']) && $_SESSION['country'] != "" ){

                                if(!empty($user) && $user[0]['country'] != $_SESSION['country'] ){
                                    continue ;
                                }
                            }//if
                            ?>
                            <tr>
                                <td><?=$with['id']?></td>
                                <td class="title"><a href="#"><?= empty($user) ? "" :$user[0]['fname']?></a></td>
                                <td><?=empty($user) ? "" : $user[0]['email']?></td>
                                <td><?=empty($user) ? "" : $user[0]['country']?></td>
                                <td><?=$with['amount']?></td>
                                <td><?=$with['withdraw_date']?></td>
                                <th>
                                    <?php
                                    if( $with['status']==0 ){
                                        ?>
                                        <span class="badge badge-warning p-1">Pending</span>
                                        <?php
                                    }else if( $with['status']==1 ){
                                        ?>
                                        <span class="badge badge-success p-1">Approve</span>
                                        <?php
                                    }else if( $with['status']==2 ){
                                        ?>
                                        <span class="badge badge-danger p-1">Reject</span>
                                        <?php
                                    }
                                    ?>
                                </th>

                                <td class="action">
                                    <?php
                                    if( $with['status']==0 ){
                                        ?>
                                        <a class="btn btn-info my-1" onclick="withdrawapprove(`<?=$with['id']?>`,`<?=$user[0]['id']?>`)" id="" >Approve</i></a>
                                        <a class="btn btn-danger my-1" onclick="withdrawReject(`<?=$with['id']?>`,`<?=$user[0]['id']?>`)" id="<?=$user[0]['id']?>" >Reject</i></a>

                                        <?php
                                    }else if( $with['status']==1 ){
                                        ?>
                                        <a class="btn btn-success my-1" href="#">Approved</i></a>
                                        <?php
                                    }else if( $with['status']==2 ){
                                        ?>

                                        <a class="btn btn-danger my-1" href="#" >Rejected</i></a>

                                        <?php
                                    }
                                    ?>
                                    <button class="my-1 btn btn-success" onclick="showUserAccount(<?=$with['user_id']?>)" >View bank details</button>

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
        $("#withdrawli").addClass("active");

        $("#userTable").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "order": [[ 0, "desc" ]]
        });

    });
</script>
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

</body>
</html>

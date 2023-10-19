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
$messages=$func->getAllMessages();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Messages</title>
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
                                <h1 class="m-0">Messages</h1>
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
                                <h1>Messages</h1>
                                <table id="userTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Type</th>
                                            <th>Message</th>
                                            <th>Actions</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($messages as $message){
                                         ?>

                                         <tr>
                                            <td><?=$message['name']?></td>
                                             <td><?=$message['lname']?></td>
                                             <td><?=$message['phone']?></td>
                                            <td><?=$message['email']?></td>
                                             <td><?=$message['type']?></td>
                                            <td><p><?=$message['comment']?></p></td>

                                            <td>
                                                
                                                <button class="btn btn-danger" onclick="deleteMessage(<?=$message['id']?>)" ><i class="fa fa-trash" aria-hidden="true"></i></button>
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
            $("#messages").addClass("active");

            $("#userTable").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
        });
    

        });
    </script>
</body>
</html>

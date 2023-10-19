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
if($_GET['type']=="electrical"){
    $electrical=$func->getSingleElectrical($_GET['id']);
    $electrical=$electrical[0];
}else{
    $gas=$func->getSingleGas($_GET['id']);
    $gas=$gas[0];
}


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
                        <h1 class="m-0">Certifications</h1>
                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
           <?php
           if($_GET['type']=='electrical'){
           ?>
               <div class="card">
                   <div class="card-header text-center"><h2>Electrical Certification</h2> </div>
                   <div class="card-body">
                       <div class="row ">
                           <?php
                           if($electrical['NICEIC']!=""){
                               ?>
                               <div class="card mx-1">
                                   <div class="card-header"><h3 class="text-center">NICEIC Registered</h3></div>
                                   <div class="card-body">
                                       <img width="500px" height="auto" src="<?=$electrical['NICEIC']?>">
                                   </div>
                               </div>

                               <?php
                           }
                           ?>

                           <?php
                           if($electrical['ECA']!=""){
                               ?>
                               <div class="card mx-1">
                                   <div class="card-header"><h3 class="text-center">ECA Registered</h3></div>
                                   <div class="card-body">
                                       <img width="500px" height="auto" src="<?=$electrical['ECA']?>">
                                   </div>
                               </div>

                               <?php
                           }
                           ?>

                           <?php
                           if($electrical['NAPIT']!=""){
                               ?>
                               <div class="card mx-1">
                                   <div class="card-header"><h3 class="text-center">NAPIT Registered</h3></div>
                                   <div class="card-body">
                                       <img  width="500px" height="auto"src="<?=$electrical['NAPIT']?>">
                                   </div>
                               </div>

                               <?php
                           }
                           ?>

                           <?php
                           if($electrical['gold']!=""){
                               ?>
                               <div class="card mx-1">
                                   <div class="card-header"><h3 class="text-center">Gold JIB Card</h3></div>
                                   <div class="card-body">
                                       <img width="500px" height="auto" src="<?=$electrical['gold']?>">
                                   </div>
                               </div>

                               <?php
                           }
                           ?>

                           <?php
                           if($electrical['inspection']!=""){
                               ?>
                               <div class="card mx-1">
                                   <div class="card-header"><h3 class="text-center">2391 Inspection & Testing</h3></div>
                                   <div class="card-body">
                                       <img width="500px" height="auto" src="<?=$electrical['inspection']?>">
                                   </div>
                               </div>

                               <?php
                           }
                           ?>
                           <?php
                           if($electrical['edition']!=""){
                               ?>
                               <div class="card mx-1">
                                   <div class="card-header"><h3 class="text-center">18th Edition Regulations</h3></div>
                                   <div class="card-body">
                                       <img width="500px" height="auto" src="<?=$electrical['edition']?>">
                                   </div>
                               </div>

                               <?php
                           }
                           ?>
                           <?php
                           if($electrical['level3']!=""){
                               ?>
                               <div class="card mx-1">
                                   <div class="card-header"><h3 class="text-center">Level 3 Certificate (NVQ / Diploma)</h3></div>
                                   <div class="card-body">
                                       <img width="500px" height="auto" src="<?=$electrical['level3']?>">
                                   </div>
                               </div>

                               <?php
                           }
                           ?>

                           <?php
                           if($electrical['id_card']!=""){
                               ?>
                               <div class="card mx-1">
                                   <div class="card-header"><h3 class="text-center">Proof of ID (Passport/Driving License)</h3></div>
                                   <div class="card-body">
                                       <img width="500px" height="auto" src="<?=$electrical['id_card']?>">
                                   </div>
                               </div>

                               <?php
                           }
                           ?>

                       </div>
                       <?php
                       if($electrical['status']==0){
                       ?>
                       <div class="text-center my-2">
                           <button id="electrical_verify" onclick="electrical_verify(`<?=$electrical['id']?>`,`<?=$electrical['user_id']?>`)" class="btn btn-success">Verify</button>
                       </div>
                       <?php
                       }
                       ?>

                   </div>
                   <!-- /.row (main row) -->
               </div>
           <?php
           }else{
               ?>
               <div class="card">
                   <div class="card-header text-center"><h2>GAS Certification</h2> </div>
                   <div class="card-body">

                       <h2>Gas Safety Registration number: <?=$gas['registration_number']?></h2>

                       <div class="row ">
                           <?php
                           if($gas['certificate']!=""){
                               ?>
                               <div class="card mx-1">
                                   <div class="card-header"><h3 class="text-center">Gas Safety Registration</h3></div>
                                   <div class="card-body">
                                       <img width="500px" height="auto" src="<?=$gas['certificate']?>">
                                   </div>
                               </div>

                               <?php
                           }
                           ?>
                           <?php
                           if($gas['id_card']!=""){
                               ?>
                               <div class="card mx-1">
                                   <div class="card-header"><h3 class="text-center">Proof of ID (Passport/Driving License)</h3></div>
                                   <div class="card-body">
                                       <img  width="500px" height="auto" src="<?=$gas['id_card']?>">
                                   </div>
                               </div>

                               <?php
                           }
                           ?>
                       </div>
                       <?php
                       if($gas['status']==0){
                           ?>
                           <div class="text-center my-2">
                               <button id="gas_verify" onclick="gas_verify(`<?=$gas['id']?>`,`<?=$gas['user_id']?>`)" class="btn btn-success">Verify</button>
                           </div>
                           <?php
                       }
                       ?>

                   </div>

               </div>
           <?php
           }
           ?>
        </section>
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
        $("#").addClass("active");

        $("#userTable").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
        });


    });
</script>
</body>
</html>

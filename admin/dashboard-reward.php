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
$homeOwners=$func->getHomeOwnerRewards();
$tradesperson=$func->getTradesPersonReward();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rewards</title>
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
                        <h1 class="m-0">Rewards</h1>
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
                            <h1>Rewards</h1>
                        </div>

                    </div>
                    <div class="row justify-content-around" >
                        <button class="manage_category_btn btn btn-primary" id="subbutton">Give reward to homeowner</button>
                        <button class="manage_category_btn btn btn-primary" id="mainbutton">Give reward to trades member</button>
                       </div>
                    <div class="row justify-content-center">
                        <div class="col-8">
                            <div id="subCategoryForm" class="card my-3 shadow">
                                <div class="card-body">
                                    <form id="reward_homeowner" class="form my-2">
                                        <h1 class="text-center card-header">Give reward to homeowner </h1>

                                        <div class="form-group input_parent">
                                            <label for="homeowner_name">Enter homeowner full name</label>
                                            <input type="text" required class="form-control" id="homeowner_name">
                                        </div><div class="form-group input_parent">
                                            <label for="homeoner_city">Enter homeowner City</label>
                                            <input type="text" required class="form-control" id="homeowner_city">
                                        </div>
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

                                        <button type ='submit' class="w-100 btn btn-info" >Submit</button>

                                    </form>
                                </div>
                            </div>
                            <div id="mainCategoryForm"  class="card my-3 shadow">
                                <div class="card-body">
                                    <form id="reward_tradeperson" class="my-2">
                                        <h1 class="text-center card-header">Give reward to trades member </h1>

                                        <div class="form-group input_parent">
                                            <label for="tradeperson_name">Enter trades member full name</label>
                                            <input type="text" required class="form-control" id="tradeperson_name">
                                        </div>  

										<div class="form-group input_parent">
                                            <label for="tradeperson_city">Enter trades city</label>
                                            <input type="text" required class="form-control" id="tradeperson_city">
                                        </div>

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
                                        <button type = 'submit' class="w-100 btn btn-info" >Submit</button>

                                    </form>
                                </div>
                            </div>

                        </div>

                    </div>


                    <div class="card shadow m-3">
                        <div class="card-body">
                            <h2 class="text-center card-header my-1">REWARDS FOR OUR HOMEOWNERS</h2>
                            <table class="table table-bordered table-striped" id="mainCategory_table" >
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>HomeOwner Name</th>
									 <th>City</th>
                                    <th>Reward type</th>
                                    <th>Reward Date</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                foreach($homeOwners as $homeowner){
                                    ?>
                                    <tr>
                                        <td><?=$homeowner['id']?></td>
                                        <td><?=$homeowner['homeowner_name']?></td> 
										<td><?=$homeowner['city']?></td>
                                        <td><?=$homeowner['reward_type']?></td>
                                        <td><?=date('F Y',strtotime($homeowner['reward_date']))?></td>
                                        <td>
                                            <button class="btn btn-danger mx-1 " onclick="deleteHomeOwnerReward(<?=$homeowner['id']?>)"></i>Delete</button>

                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>

                            </table>

                        </div>
                    </div>
                    <!-- tradesperson -->
                    <div class="card shadow m-3">
                        <div class="card-body">
                            <h2 class="text-center card-header my-1">REWARDS FOR OUR TRADES PEOPLE</h2>
                            <table class="table table-bordered table-striped" id="subCategory_table" >

                                <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>Trades People Name</th>
									<th>City</th>
                                    <th>Reward type</th>
                                    <th>Reward Date</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>


                                <!-- Item #1 -->
                                <tbody>
                                <?php
                                foreach($tradesperson as $person){

                                    ?>
                                    <tr>
                                        <td><?=$person['id']?></td>
                                        <td><?=$person['tradesperson_name']?></td>
										<td><?=$person['city']?></td>
                                        <td><?=$person['reward_type']?></td>
                                        <td><?=date('F Y',strtotime($person['reward_date']))?></td>
                                        <td class="action">

                                            <button onclick="deleteTradesPeopleReward(<?=$person['id']?>)" class="mx-1 btn btn-danger">Delete</button>

                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>

                            </table>
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
        $("#reward").addClass("active");

        $("#mainCategory_table").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            order: [[0, 'desc']],
        });

        $("#subCategory_table").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            order: [[0, 'desc']],
        });

        $("#mainCategoryForm").hide();
        $("#subCategoryForm").hide();


    });

    $("#mainbutton" ).click(function() {

        $("#subCategoryForm" ).hide();
        $("#mainCategoryForm" ).show();
    });
    $("#subbutton" ).click(function() {

        $("#mainCategoryForm" ).hide();
        $("#subCategoryForm" ).show();
    });

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

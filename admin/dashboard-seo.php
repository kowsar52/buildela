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
$mainCategory=$func->mainlocation();
$mainservices=$func->mainserviceseo();
$subCategory=$func->subCategory();
$options=$func->allOptions();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All Category</title>
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
                        <h1 class="m-0">All Locations</h1>
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
                            <h1>All Locations</h1>
                        </div>

                    </div>
                    <div class="row justify-content-around" >
                    <button class="manage_category_btn btn btn-primary" id="mainarea">Add Area</button>
               <button class="manage_category_btn btn btn-primary" id="mainservice">Add Service</button>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-8">
                            <div id="subCategoryForm" class="card my-3 shadow">
                                <div class="card-body">
                                    <form id="subCategory" class="form my-2">
                                        <h1 class="text-center card-header">Sub Category</h1>

                                        <div class="form-group">
                                            <label for="">Select Main Category</label>
                                            <select class="form-control" id="select_category">
                                                <option>Please Select</option>

                                                <?php
                                                foreach($mainCategory as $main){

                                                    ?>
                                                    <option value="<?=$main['id']?>"><?=$main['category_name']?></option>

                                                    <?php
                                                }
                                                ?>

                                            </select>

                                        </div>

                                        <div class="form-group input_parent">
                                            <label for="sub_category_name">Category Name</label>
                                            <input type="text" required class="form-control" id="sub_category_name">
                                        </div>
                                        <div class="form-group input_parent">
                                            <label for="sub_category_index">Category Index</label>
                                            <input type="number" required class="form-control" id="sub_category_index">
                                        </div>

                                        <button type = 'submit' class="btn btn-info w-100">Submit</button>

                                    </form>


                                </div>
                            </div>
                            <!-- Add Options  -->
                            <div id="optionsForm" class="card my-3 shadow">
                                <div class="card-body">
                                    <form id="addoption" class="form my-2">
                                        <h1 class="text-center card-header">Add Options For Sub Category</h1>

                                        <div class="form-group ">
                                            <label for="">Select Sub Category</label>
                                            <select class="form-control" id="select_option">
                                                <option>Please Select</option>

                                                <?php
                                                foreach($subCategory as $sub){

                                                    ?>
                                                    <option value="<?=$sub['id']?>"><?=$sub['category_name']?></option>

                                                    <?php
                                                }
                                                ?>

                                            </select>

                                        </div>

                                        <div class="form-group input_parent">
                                            <label for="sub_category_name">Enter Option</label>
                                            <input type="text" required class="form-control" id="option_name">
                                        </div>

                                        <button type = 'submit' class="w-100 btn btn-info" >Submit</button>

                                    </form>
                                </div>
                            </div>

                            <!-- Add Area  -->
                            <div id="mainareaForm"  class="card my-3 shadow">
                                <div class="card-body">
								<form id="main_area_form" class="my-2">
                                        <h1 class="text-center card-header">Add Area</h1>

                                        <div class="form-group input_parent">
                                            <label for="area_name">Area Name</label>
                                            <input type="text" required class="form-control" id="area_name">
                                        </div>



                            

                                        <button type = 'submit' class="w-100 btn btn-info" >Submit</button>

                                    </form>
                                </div>
                            </div>      <!-- Add Service -->
                            <div id="mainservceForm"  class="card my-3 shadow">
                                <div class="card-body">
								<form id="main_service_form" class="my-2">
                                        <h1 class="text-center card-header">Add Service</h1>

                                        <div class="form-group input_parent">
                                            <label for="service_name">Area Name</label>
                                            <input type="text" required class="form-control" id="service_name">
                                        </div>



                                <div class="form-group input_parent" >
                                    <label>Cover image:</label>
                                    <input class="form-control" required  type="file" id="image">
                                </div>


                                        <button type = 'submit' class="w-100 btn btn-info" >Submit</button>

                                    </form>
                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- Main area Table-->
                    <div class="card shadow m-3">
                        <div class="card-body">
                            <h2 class="text-center card-header my-1">Main Locations</h2>
                            <table class="table table-bordered table-striped" id="mainCategory_table" >
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <!-- <th>Status</th> -->
                                             <!-- <th>Image</th> -->
                                    <th>Actions</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                foreach($mainCategory as $main){
                                    ?>
                                    <tr>
                                        <td><?=$main['city_name']?></td>
                                 
                 
                                        <td>
                                       <button onclick="deletearea(<?=$main['id']?>)" class="m-1 btn btn-danger">Delete</button>

                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>

                            </table>

                        </div>
                    </div>
           
		   
		   
		                <!-- Main service Table-->
                    <div class="card shadow m-3">
                        <div class="card-body">
                            <h2 class="text-center card-header my-1">Main Services</h2>
                            <table class="table table-bordered table-striped" id="mainCategory_table" >
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <!-- <th>Status</th> -->
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                foreach($mainservices as $mains){
                                    ?>
                                    <tr>
                                        <td><?=$mains['service_name']?></td>
                                 
                                        <td><?=$mains['image_path']?></td>
                                        <td>
                                       <button onclick="deletservicea(<?=$mains['id']?>)" class="m-1 btn btn-danger">Delete</button>

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

    <!--Edit Main Category Modal -->
    <div class="modal fade" id="edit_main_categoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Main Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form id="edit_mian_category_form" class="my-2">

                        <input type="hidden" id="edit_main_category_id">
                        <div class="form-group input_parent">
                            <label for="edit_main_category_name">Category Name</label>
                            <input type="text" required class="form-control" id="edit_main_category_name">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!--Edit Sub Category Modal -->
    <div class="modal fade" id="edit_sub_categoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Sub Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form id="edit_subCategory" class="form my-2">

                        <div class="form-group">
                            <label for="">Select Main Category</label>
                            <select class="form-control" id="edit_sub_main_category_id">
                                <option value="">Please Select</option>

                                <?php
                                foreach($mainCategory as $main){

                                    ?>
                                    <option value="<?=$main['id']?>"><?=$main['category_name']?></option>

                                    <?php
                                }
                                ?>

                            </select>

                        </div>

                        <div class="form-group input_parent">
                            <label for="sub_category_name">Category Name</label>
                            <input type="text" required class="form-control" id="edit_sub_category_name">
                        </div>
                        <div class="form-group input_parent">
                            <label for="edit_sub_category_index">Category Index</label>
                            <input type="number" required class="form-control" id="edit_sub_category_index">
                        </div>
                        <input type="hidden" class="form-control" id="edit_sub_category_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!--Edit Option Modal -->
    <div class="modal fade" id="edit_optionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Options</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit_option">
                        <div class="form-group ">
                            <label for="">Select Sub Category</label>
                            <select class="form-control" id="edit_option_sub_category">
                                <option value="">Please Select</option>

                                <?php
                                foreach($subCategory as $sub){

                                    ?>
                                    <option value="<?=$sub['id']?>"><?=$sub['category_name']?></option>

                                    <?php
                                }
                                ?>

                            </select>

                        </div>

                        <div class="form-group input_parent">
                            <label for="edit_option_name">Enter Option</label>
                            <input type="text" required class="form-control" id="edit_option_name">
                        </div>

                        <input id="edit_option_id" type="hidden">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                </form>
            </div>
        </div>
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
    $(".edit_main_category").click(function (e){
        e.preventDefault();
        $("#edit_main_category_name").val($(this).data("main_category_name"));
        $("#edit_main_category_id").val($(this).data("main_category_id"));

    });

    $(".edit_sub_category").click(function (e){
        e.preventDefault();
        $("#edit_sub_category_index").val($(this).data("sub_category_index"));
        $("#edit_sub_category_name").val($(this).data("sub_category_name"));
        $("#edit_sub_category_id").val($(this).data("sub_category_id"));
        $("#edit_sub_main_category_id").val($(this).data("main_category_id"));
    });

    $(".edit_option").click(function (e){
        e.preventDefault();
        $("#edit_option_name").val($(this).data("option_name"));
        $("#edit_option_id").val($(this).data("option_id"));
        $("#edit_option_sub_category").val($(this).data("sub_category_id"));
    });

</script>
<script>
    $( document ).ready(function() {
        $("#category").addClass("active");

        $("#mainCategory_table").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
        });

        $("#subCategory_table").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
        });

        $("#options_table").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
        });

        $("#mainareaForm").hide();
		$("#mainservceForm").hide();
        $("#subCategoryForm").hide();
        $("#optionsForm").hide();
		

    });

    $("#mainarea" ).click(function() {

        $("#subCategoryForm" ).hide();
        $("#optionsForm").hide();
		$("#mainservceForm").hide();
        $("#mainareaForm" ).show();
    }); 
	$("#mainservice" ).click(function() {

        $("#subCategoryForm" ).hide();
        $("#optionsForm").hide();
		$("#mainareaForm").hide();
        $("#mainservceForm" ).show();
    });
	
    $("#subbutton" ).click(function() {

        $("#mainCategoryForm" ).hide();
        $("#optionsForm").hide();
        $("#subCategoryForm" ).show();
    });
    $("#optionbutton" ).click(function() {

        $("#mainCategoryForm" ).hide();
        $("#subCategoryForm" ).hide();
        $("#optionsForm" ).show();
    });

</script>
</body>
</html>

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
$mainCategory=$func->mainCategory();
$blogCategory=$func->blogCategory();
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
                        <h1 class="m-0">All Category</h1>
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
                            <h1>All Category</h1>
                        </div>

                    </div>
                    <div class="row justify-content-around" >
                        <button class="manage_category_btn btn btn-primary" id="mainbutton">Add Main Category</button>
                        <button class="manage_category_btn btn btn-primary" id="blogbutton">Add Blog Category</button>
                        <button class="manage_category_btn btn btn-primary" id="subbutton">Add Sub Category</button>
                        <button class="manage_category_btn btn btn-primary" id="optionbutton">Add options for sub category</button>
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


                            <!-- Add Blog Category  -->
                            <div id="blogcatForm" class="card my-3 shadow">
                                <div class="card-body">
                                    <form id="addblogcat" class="form my-2">
                                        <h1 class="text-center card-header">Add Blog Category</h1>

                                        <div class="form-group ">
                                            <label for="">Select Category Type</label>
                                            <select class="form-control" id="select_blog_type" name="type" required>
                                                <option>Please Select</option>
                                                <option value="home_owners_category">Homeowners</option>
                                                <option value="tradespeople_category">Professionals</option>

                                            </select>

                                        </div>

                                        <div class="form-group input_parent">
                                            <label for="blog_cat_name">Enter Blog Category Name</label>
                                            <input type="text" required class="form-control" id="blog_cat_name">
                                        </div>

                                        <button type='submit' class="w-100 btn btn-info" >Submit</button>

                                    </form>
                                </div>
                            </div>

                            <!-- Add Mian Category -->
                            <div id="mainCategoryForm"  class="card my-3 shadow">
                                <div class="card-body">
                                    <form id="mian_category_form" class="my-2">
                                        <h1 class="text-center card-header">Main Category</h1>

                                        <div class="form-group input_parent">
                                            <label for="category_name">Category Name</label>
                                            <input type="text" required class="form-control" id="main_category_name">
                                        </div>

                                        <button type = 'submit' class="w-100 btn btn-info" >Submit</button>

                                    </form>
                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- Main Category Table-->
                    <div class="card shadow m-3">
                        <div class="card-body">
                            <h2 class="text-center card-header my-1">Main Categories</h2>
                            <table class="table table-bordered table-striped" id="mainCategory_table" >
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <!-- <th>Status</th> -->
                                    <th>Create Date</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                foreach($mainCategory as $main){
                                    ?>
                                    <tr>
                                        <td><?=$main['category_name']?></td>
                                        <!-- <td><?=$main['status']?></td> -->
                                        <td><?=$main['create_date']?></td>
                                        <td>
                                            <button type="button" class="btn btn-primary edit_main_category mx-1 " data-main_category_id="<?=$main['id']?>" data-main_category_name="<?=$main['category_name']?>" data-toggle="modal" data-target="#edit_main_categoryModal">
                                                Edit
                                            </button>
                                            <button class="btn btn-danger mx-1 " onclick="deleteMainCategory(<?=$main['id']?>)"></i>Delete</button>

                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>

                            </table>

                        </div>
                    </div>

                    <!-- Blog Category Table-->
                    <div class="card shadow m-3">
                        <div class="card-body">
                            <h2 class="text-center card-header my-1">Blog Categories</h2>
                            <table class="table table-bordered table-striped" id="blogCategory_table" >
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                foreach($blogCategory as $main){
                                    if($main['cat_type'] === 'home_owners_category'){
                                        $type = 'Homeowners';
                                    } else {
                                        $type = 'Professionals';
                                    }
                                    ?>
                                    <tr>
                                        <td><?=$main['name']?></td>
                                        <td><?= $type ?></td>
                                        <td>
                                            <button type="button" class="btn btn-primary edit_blog_category mx-1 " data-blog_category_id="<?=$main['id']?>" data-blog_category_name="<?=$main['name']?>" data-blog_category_type="<?=$main['cat_type']?>" data-toggle="modal" data-target="#edit_blog_categoryModal">
                                                Edit
                                            </button>
                                            <button class="btn btn-danger mx-1 " onclick="deleteBlogCategory(<?=$main['id']?>)"></i>Delete</button>

                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>

                            </table>

                        </div>
                    </div>

                    <!-- Sub Category Table -->
                    <div class="card shadow m-3">
                        <div class="card-body">
                            <h2 class="text-center card-header my-1">Sub Categories</h2>
                            <table class="table table-bordered table-striped" id="subCategory_table" >

                                <thead>
                                <tr>
                                    <th>Main Category</th>
                                    <th>Sub Category</th>
                                    <th>Index</th>
                                    <!-- <th>Status</th> -->
                                    <th>Create Date</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>


                                <!-- Item #1 -->
                                <tbody>
                                <?php
                                foreach($subCategory as $sub){
                                    $mainCategoryname=$func->SingleMainCategory($sub['main_category']);
                                    ?>
                                    <tr>
                                        <td><?=$mainCategoryname[0]['category_name']?></td>
                                        <td><?=$sub['category_name']?></td>
                                        <td><?=$sub['index']?></td>
                                        <!-- <td><?=$sub['status']?></td> -->
                                        <td><?=$sub['create_date']?></td>
                                        <td class="action">
                                            <button type="button" class="btn btn-primary edit_sub_category m-1 " data-sub_category_id="<?=$sub['id']?>" data-sub_category_index="<?=$sub['index']?>" data-main_category_id="<?=$sub['main_category']?>"
                                                    data-sub_category_name="<?=$sub['category_name']?>" data-toggle="modal" data-target="#edit_sub_categoryModal">
                                                Edit
                                            </button>
                                            <button onclick="deleteSubCategory(<?=$sub['id']?>)" class="m-1 btn btn-danger">Delete</button>

                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                    <!-- Options Table -->
                    <div class="card shadow m-3">
                        <div class="card-body">
                            <h2 class="text-center card-header my-1">Options of Sub Categories</h2>
                            <table class="table table-bordered table-striped" id="options_table">
                                <thead>
                                <tr>
                                    <th>Sub Category</th>
                                    <th>Option</th>
                                    <!-- <th>Status</th> -->
                                    <th>Create Date</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>


                                <!-- Item #1 -->
                                <tbody>
                                <?php
                                foreach($options as $opt){
                                    $subCategoryname=$func->SingleSubCategory($opt['sub_category'])
                                    ?>
                                    <tr>
                                        <td><?=$subCategoryname[0]['category_name']?></td>
                                        <td><?=$opt['option']?></td>
                                        <!-- <td><?=$sub['status']?></td> -->
                                        <td><?=$sub['create_date']?></td>
                                        <td class="action">
                                            <button type="button" class="btn btn-primary edit_option mx-1 " data-option_id="<?=$opt['id']?>" data-sub_category_id="<?=$opt['sub_category']?>"
                                                    data-option_name="<?=$opt['option']?>" data-toggle="modal" data-target="#edit_optionModal">
                                                Edit
                                            </button>
                                            <button onclick="deleteOptions(<?=$opt['id']?>)" class="mx-1 btn btn-danger">Delete</button>

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

    <!--Edit Option Modal -->
    <div class="modal fade" id="edit_blog_categoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Options</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit_blog_cat">
                        <div class="form-group ">
                            <label for="">Select Category Type</label>
                            <select class="form-control" id="edit_blog_type" name="type" required>
                                <option>Please Select</option>
                                <option value="home_owners_category">Homeowners</option>
                                <option value="tradespeople_category">Professionals</option>

                            </select>

                        </div>

                        <div class="form-group input_parent">
                            <label for="edit_blog_cat_name">Enter Blog Category Name</label>
                            <input type="text" required class="form-control" id="edit_blog_cat_name">
                        </div>

                        <input id="edit_blog_cat_id" type="hidden">

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

    $(".edit_blog_category").click(function (e){
        e.preventDefault();
        $("#edit_blog_cat_name").val($(this).data("blog_category_name"));
        $("#edit_blog_cat_id").val($(this).data("blog_category_id"));
        $("#edit_blog_type").val($(this).data("blog_category_type"));
    });

</script>
<script>
    $( document ).ready(function() {
        $("#category").addClass("active");

        $("#mainCategory_table").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
        });

        $("#blogCategory_table").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
        });
        $("#subCategory_table").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
        });

        $("#options_table").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
        });

        $("#mainCategoryForm").hide();
        $("#subCategoryForm").hide();
        $("#optionsForm").hide();

    });

    $("#mainbutton" ).click(function() {
        $("#blogcatForm" ).hide();
        $("#subCategoryForm" ).hide();
        $("#optionsForm").hide();
        $("#mainCategoryForm" ).show();
    });

    $("#blogbutton" ).click(function() {

        $("#subCategoryForm" ).hide();
        $("#optionsForm").hide();
        $("#mainCategoryForm" ).hide();  
        $("#blogcatForm" ).show();
    });

    

    $("#subbutton" ).click(function() {
        $("#blogcatForm" ).hide();
        $("#mainCategoryForm" ).hide();
        $("#optionsForm").hide();
        $("#subCategoryForm" ).show();
    });
    $("#optionbutton" ).click(function() {
        $("#blogcatForm" ).hide();
        $("#mainCategoryForm" ).hide();
        $("#subCategoryForm" ).hide();
        $("#optionsForm" ).show();
    });

</script>
</body>
</html>

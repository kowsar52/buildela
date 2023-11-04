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
$questions=$func->getAllQuestions();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Question</title>
    <?php include "includes/dashboard-links.php"; ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <?php include "includes/header.php" ?>

    <?php include "includes/sidebar.php" ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Add Question</h1>
                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-between ">
                            <h1>All Questions</h1>
                        </div>

                    </div>


                    <div class="row justify-content-center">

                        <button id="subbutton" class="btn btn-primary">Add Question</button>
                    </div>
                    <!-- ADD new Question -->
                    <div class="row justify-content-center">
                        <div class="col-8">
                            <div id="subCategoryForm1" class="card my-3 shadow">
                                <div class="card-body">
                                    <form id="questionform" class="form m-1">
                                        <h1 class="text-center card-header">Add Question</h1>
                                        <div class="form-group">
                                            <label for="select_main_category">Select Main Category</label>
                                            <select class="form-control"  id="select_main_category">
                                                <!-- remove from select onchange="setSubCategory1()" -->
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
                                        <!-- <div style="display: none;" id="subCategorydiv" class="form-group form_3_dropdown">
                                            <label for="select_sub_category">Select Sub Category</label>
                                            <select class="form-control" id="select_sub_category">
                                                <option>Please Select</option>

                                            </select>

                                        </div> -->

                                        <div class="form-group input_parent">
                                            <label for="question">Question</label>
                                            <input type="text" required class="form-control" id="question1">
                                        </div>

                                        <div class="form-group input_parent">
                                            <label for="option1">Option 1</label>
                                            <input type="text" required class="form-control" id="option1">
                                        </div>

                                        <div class="form-group input_parent">
                                            <label for="option2">Option 2</label>
                                            <input type="text" required class="form-control" id="option2">
                                        </div>

                                        <div class="form-group input_parent">
                                            <label for="option3">Option 3</label>
                                            <input type="text" required class="form-control" id="option3">
                                        </div>

                                        <div class="form-group input_parent">
                                            <label for="option4">Option 4</label>
                                            <input type="text" required class="form-control" id="option4">
                                        </div>

                                        <div class="form-group input_parent">
                                            <label for="ans">Correct Answer</label>
                                            <input type="text" required class="form-control" id="ans">
                                        </div>
                                        <button type ="submit" class="w-100 btn btn-info" >Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow m-3">
                        <div class="card-body">
                            <!-- Table -->
                            <h2 class="card-header text-center my-1" >All Questions</h2>
                            <table class="table table-bordered table-striped" id="userTable">
                                <thead>
                                <tr>
                                    <th>Main Category</th>
                                    <!-- <th>Sub Category</th> -->
                                    <th>Question</th>
                                    <th>Option 1</th>
                                    <th>Option 2</th>
                                    <th>Option 3</th>
                                    <th>Option 4</th>
                                    <th>Correct Answer</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach($questions as $q){
                                    $main=$func->SingleMainCategory($q['main_category_id']);
                                    // $sub=$func->SingleSubCategory($q['sub_category_id']);
                                    ?>
                                    <tr>
                                        <td><?=$main[0]['category_name']?></td>
                                        <!-- <td><=$sub[0]['category_name']?></td> -->
                                        <td><textarea><?=$q['question']?></textarea></td>
                                        <td><textarea><?=$q['option1']?></textarea></td>
                                        <td><textarea><?=$q['option2']?></textarea></td>
                                        <td><textarea><?=$q['option3']?></textarea></td>
                                        <td><textarea><?=$q['option4']?></textarea></td>
                                        <td><textarea><?=$q['right_ans']?></textarea></td>

                                        <td class="action">
                                            <button class="btn btn-info" onclick="editQuestion(<?=$q['id']?>)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                            <button  class="btn btn-danger" onclick="deleteQuestion(<?=$q['id']?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
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
            </div>

        </section>

    </div>

    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- Button trigger modal -->
<button type="button" style="display: none" id="show_modal" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Launch demo modal
</button>

<!--modal to edit a question-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog w-100" style="width: 750px !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- EDIT Question -->
                <form id="editquestionform" class="form m-5">
                    <h1 class="text-center">Edit Question</h1>
                    <input type="hidden" id="q_id" name="">

                    <div class="form-group">
                        <label for="select_main_category">Select Main Category</label>
                        <select class="form-control"  id="select_category1e">
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
                        <label for="questione">Question</label>
                        <input type="text" value="" class="form-control" id="questione">
                    </div>

                    <div class="form-group input_parent">
                        <label for="option1e">Option 1</label>
                        <input type="text" value="" class="form-control" id="option1e">
                    </div>

                    <div class="form-group input_parent">
                        <label for="option2e">Option 2</label>
                        <input type="text" value="" class="form-control" id="option2e">
                    </div>

                    <div class="form-group input_parent">
                        <label for="option3e">Option 3</label>
                        <input type="text"  value="" class="form-control" id="option3e">
                    </div>

                    <div class="form-group input_parent">
                        <label for="option4e">Option 4</label>
                        <input type="text" value="" class="form-control" id="option4e">
                    </div>

                    <div class="form-group input_parent">
                        <label for="anse">Correct Answer</label>
                        <input type="text" value="" class="form-control" id="anse">
                    </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
<script>
    $( document ).ready(function() {
        $("#question").addClass("active");
        $("#subCategoryForm1").hide();
        $("#userTable").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
        });

    });
</script>
<script type="text/javascript">
    function editQuestion(id){

        $.ajax({
            url: "../serverside/post.php",
            type: "POST",
            data: {
                func: 22,
                q_id:id,

            },
            success: function (data) {
                mydata=JSON.parse(data);
                if (mydata.length>0) {
                    $('#q_id').val(mydata[0]['id']);
                    $('#select_category1e').val(mydata[0]['main_category_id']);
                    $('#questione').val(mydata[0]['question']);
                    $('#option1e').val(mydata[0]['option1']);
                    $('#option2e').val(mydata[0]['option2']);
                    $('#option3e').val(mydata[0]['option3']);
                    $('#option4e').val(mydata[0]['option4']);
                    $('#anse').val(mydata[0]['right_ans']);

                }//if data
                $("#show_modal").click();
            }//success
        });//ajax
    }

    $("#subbutton" ).click(function() {
        $("#subCategoryForm1" ).toggle();

    });

</script>
</body>
</html>

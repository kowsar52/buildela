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
$blogs=$func->getAllBlogs();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Blogs</title>
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
                        <h1 class="text-center my-2">Blogs</h1>
                        <table class="table" id="userTable">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Author</th>
                                <th scope="col">Category</th>
                                <th scope="col">Job Main Category</th>
                                <th scope="col">Publish Date</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($blogs as $blog){
                                $job=$func->SingleMainCategory($blog['job_category']);
                                ?>
                                <tr>
                                    <th scope="row"><?=$blog['id']?></th>
                                    <td><?=$blog['title']?></td>
                                    <td><?=$blog['author_name']?></td>
                                    <td><?=$blog['category']?></td>
                                    <td><?=empty($job) ? "" : $job[0]['category_name'] ?></td>
                                    <td><?=$blog['create_date']?></td>
                                    <td>
                                        <a href="edit-blog?id=<?=$blog['id']?>"  class="  m-1  btn btn-info" >Edit</a>
                                        <a href="../blog-details?id=<?=$blog['id']?>" target="_blank" class="  m-1  btn btn-info" >View</a>
                                        <button class=" m-1 btn btn-danger" title="Delete" id="<?=$blog['id']?>" onclick="DeleteBlog(this.id)">Delete</button>
                                        <button class=" m-1 btn btn-primary" title="Send Blog notifications" id="notificationButton<?=$blog['id']?>" onclick="BlogNotification(`<?=$blog['id']?>`)">Send notification</button>

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
        $("#blogs").addClass("active");

        $("#userTable").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "order": [[ 0, "desc" ]]
        });


    });
</script>
</body>
</html>

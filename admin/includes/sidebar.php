
<?php


$totalverfitygas = count($func->getverifynmgas());
$totalverfityele = count($func->getverifynmele());
$totalwithdrawcn = count($func->withdrawcount());
$totaljobcn = count($func->jobstatuscount());

$total = $totalverfitygas + $totalverfityele;
$totalNumbervf = intval($total);

?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Admin Dashboard</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"> <=$_SESSION['firstname'].' '.$_SESSION['lastname']?></a>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="index" class="nav-link" id="home">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li  class="nav-item">
                    <a class="nav-link" id="users" href="dashboard-manage-users">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Manage Users</p>
                    </a>
                </li>
                <li  class="nav-item">
                    <a class="nav-link" id="delete_users" href="dashboard-deleted-users">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Deleted Users</p>
                    </a>
                </li>
                <li  class="nav-item">
                    <a class="nav-link" id="verify_users" href="dashboard-verify-users">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Verify Users</p> <span class="new-thing"><?=$totalNumbervf?><span>
                    </a>
                </li>
                <li  class="nav-item">
                    <a class="nav-link" id="ref_users" href="dashboard-referral-users">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Manage Referral Users</p>
                    </a>
                </li>
                <li  class="nav-item">
                    <a class="nav-link" id="withdrawli" href="dashboard-withdraw">
                        <i class="nav-icon fas fa-list"></i>
                        <p>Withdraw Request</p> <span class="new-thing"><?=$totalwithdrawcn?><span>
                    </a>
                </li>
                <li  class="nav-item">
                    <a class="nav-link" id="jobs" href="dashboard-manage-jobs">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Manage Jobs</p> <span class="new-thing"><?=$totaljobcn?><span>
                    </a>
                </li>
                <li  class="nav-item">
                    <a class="nav-link" id="usersfeedback" href="dashboard-manage-users-feedback">
                        <i class="nav-icon fas fa-sticky-note"></i>
                        <p>Manage feedbacks</p>
                    </a>
                </li>
                <li  class="nav-item">
                    <a class="nav-link" id="category" href="dashboard-category">
                        <i class="nav-icon fas fa-bars"></i>
                        <p>Manage Category</p>
                    </a>
                </li>
				  <li  class="nav-item">
                    <a class="nav-link" id="category" href="dashboard-seo">
                        <i class="nav-icon fas fa-bars"></i>
                        <p>Manage SEO Pages</p>
                    </a>
                </li>
                <li  class="nav-item">
                    <a class="nav-link" id="blogs" href="dashboard-manage-blogs">
                        <i class="nav-icon fa fa-blog"></i>
                        <p>Manage Blogs</p>
                    </a>
                </li>
                <li  class="nav-item">
                    <a class="nav-link" id="question" href="dashboard-add-question">
                        <i class="nav-icon fas fa-question"></i>
                        <p>Add Questions</p>
                    </a>
                </li>
                <li  class="nav-item">
                    <a class="nav-link" id="reward" href="dashboard-reward">
                        <i class="nav-icon fa fa-trophy"></i>
                        <p>Give Rewards</p>
                    </a>
                </li>
                <li  class="nav-item">
                    <a class="nav-link" id="settings" href="dashboard-settings">
                        <i class="nav-icon fa fa-bars"></i>
                        <p>Settings</p>
                    </a>
                </li>
                <li  class="nav-item">
                    <a class="nav-link" id="blog" href="dashboard-add-blog">
                        <i class="nav-icon fa fa-blog"></i>
                        <p>Add Blog</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="messages" class="nav-link" id="messages">
                        <i class="nav-icon fas fa-comment"></i>
                        <p>
                            Messages
                        </p>
                    </a>
                </li>
                
                <!-- <li class="nav-header">Profile</li> -->
                <li class="nav-item">
                    <a href="profile.php" id="profile" class="nav-link">
                        <i class="nav-icon far fa-user"></i>
                        <p>
                            My Profile
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="logout" class="nav-link">
                        <i class="nav-icon far fa-user"></i>
                        <p>
                           Logout
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<style>
span.new-thing {
    background: #ff8000;
    width: 30px;
    display: inline-block;
    text-align: center;
    border-radius: 37px;
    padding: 0px 6px;
    height: 28px;
    font-size: 18px;
    float: right;
}</style>
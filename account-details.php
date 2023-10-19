<?php
include_once "includes/header.php";
include_once "serverside/functions.php";
include_once "serverside/session.php";
$func=new Functions();
$user=$func->UserInfo($_SESSION['user_id']);
?>
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /*profile image change css */
        .avatar-upload {
            position: relative;
            max-width: 205px;
        }
        .avatar-upload .avatar-edit {
            position: absolute;
            right: 12px;
            z-index: 1;
            top: 10px;
        }
        .avatar-upload .avatar-edit input {
            display: none;
        }
        .avatar-upload .avatar-edit input + label {
            display: inline-block;
            width: 28px;
            height: 28px;
            margin-bottom: 0;
            border-radius: 100%;
            background: #FFFFFF;
            border: 1px solid transparent;
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
            cursor: pointer;
            font-weight: normal;
            transition: all 0.2s ease-in-out;
        }
        .avatar-upload .avatar-edit input + label:hover {
            background: #f1f1f1;
            border-color: #d6d6d6;
        }
        .avatar-upload .avatar-edit input + label:after {
            content: "\f040";
            font-family: 'FontAwesome';
            color: #757575;
            position: absolute;
            top: 0;
            left: 1px;
            right: 0;
            text-align: center;
            margin: auto;
        }
        .avatar-upload .avatar-preview {
            width: 140px;
            height: 140px;
            position: relative;
            border-radius: 100%;
            border: 6px solid #F8F8F8;
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
        }
        .avatar-upload .avatar-preview > div {
            width: 100%;
            height: 100%;
            border-radius: 100%;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }



        /*
          ##Device = Most of the Smartphones Mobiles (Portrait)
          ##Screen = B/w 320px to 479px
        */

        @media (min-width: 320px) and (max-width: 480px) {
            .columns-5.w-row {
                display: block;
            }

            .intro-header.cc-subpage.userprofile.account-details {
                display: inline;
                background-color: #fff;
            }

            a.button-6.w-button {
                margin-bottom: 10px;
            }

            .intro-content {
                width: 95%;
            }
            a.button-6.close-account.w-button {
                border-radius: 5px;
            }
            a.button-6.w-button {
                border-radius: 5px;
            }
            .section.cc-home-wrap {
                padding-top: 5px;
            }
            .avatar-upload .avatar-preview {
                width: 100px;
                height: 100px;
                position: relative;
                border-radius: 100%;
                border: 6px solid #F8F8F8;
                box-shadow: 0px 2px 4px 0px rgb(0 0 0 / 10%);
                margin-left: 30px;
            }
            .avatar-upload .avatar-edit input + label {

                position: relative;
                left: -65px;
            }
            .heading-jumbo.profile.account-details {
                margin-left: 20px;
                color: #006bf5;
                font-size: 29px;
                text-align: left;
            }
        }
        form#updatePassword1 label {
            text-transform: capitalize;
            color: grey;
            font-family: Montserrat, sans-serif !important;
            font-size: 0.9rem;
        }
        form#updatePassword1 input {
            border: solid 1.5px #c9c9c9!important;
            font-family: Montserrat, sans-serif !important;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            margin-top: 1rem;
            border-radius: 8px;
        }
        .my-profile-general-wrapper.bg-white {
            padding: 35px;
        }
    </style>

    <div class="section cc-home-wrap account-details">
        <div class="intro-header cc-subpage userprofile account-details">


            <div class="my-profile-image">
                <div class="avatar-upload">
                    <div class="avatar-edit">
                        <input type="hidden" id="userId" value="<?=$user[0]['id']?>" name="">
                        <input type='file' id="imageUpload" oninput="uploadImg()"  accept=".png, .jpg, .jpeg" />
                        <label for="imageUpload"></label>
                    </div>
                    <div class="avatar-preview">
                        <?php

                        if(empty($user[0]['img_path']))
                        {
                            ?>
                            <div id="imagePreview" style="background-image: url('images/avatar1.png');"></div>
                            <?php
                        }else{
                            $image=explode('/',$user[0]['img_path'] );

                            $img= $image[1].'/'.$image[2];
                            ?>
                            <div id="imagePreview" style="background-image: url('<?=$img?>');"></div>
                            <?php
                        }
                        ?>

                    </div>
                </div>
            </div>

            <div class="intro-content">
                <div class="heading-jumbo profile account-details">Hi, <?=$user[0]['fname']." ".$user[0]['lname']?><br></div>
                <div class="columns-5 w-row">
                    <div class="w-col w-col-6">
                        <div class="text-block-11"><strong>Phone number: </strong><?=$user[0]['phone']?><br><strong>Email: </strong><?=$user[0]['email']?><br><strong>Address: </strong>   <?php
                            $temp=explode("__",$user[0]['work_address']);
                            ?>
                            <?php
                            if(count($temp)>1){
                                ?>
                                <?=$temp[0]." ".$temp[1].", ".$user[0]['town'].", ".$user[0]['post_code']?>
                                <?php
                            }else{
                                ?>
                                <?=$user[0]['work_address'].", ".$user[0]['town'].", ".$user[0]['post_code']?>
                                <?php
                            }
                            ?></div>
                    </div>
                    
                </div>
                <div class="columns-4 row mx-0 pl-4 text-left">
                    <div class="col-12 col-md-auto">
                        <a href="#" class="button-6 w-button" data-toggle="modal" data-target="#address_modal">Update Details</a>
                    </div>
                    <div class="col-12 col-md-auto">

                        <a href="#" class="button-6 w-button" data-toggle="modal" data-target="#password">Update Password      </a>
                    </div>
                    <div class="col-12 col-md-auto">
                        <a href="post-a-job" class="button-6 w-button">Post a Job</a>
                    </div>
                    <div class="col-12 col-md-auto">
                        <a href="my-posted-jobs" class="button-6 w-button">My Posted Jobs</a>
                    </div>

                </div>
                <div class="row">
                  <div class="column-11 w-col w-col-6 text-left">
                        <a onclick="deleteProfile(<?=$user[0]['id']?>)" class="button-6 close-account w-button">Close Account</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="motto-wrap"></div>
            <div class="about-story-wrap"></div>
        </div>
    </div>




    <!--Modal for account details-->
    <div class="modal fade" id="address_modal" tabindex="-1" role="dialog" aria-labelledby="example_address_modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="example_address_modal">Edit Account details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="account_form">
                    <div class="modal-body">
                        <input type="hidden" value="<?=$_SESSION['user_id']?>" id="uuu_id">
                        <div class="form-group">
                            <label for="fname">First Name</label>
                            <input type="text" class="f-field-input-2 w-input"  required id="fname" required placeholder="First name" value="<?=$user[0]['fname']?>">
                        </div>
                        <div class="form-group">
                            <label for="lname">Last Name</label>
                            <input type="text" class="f-field-input-2 w-input" id="lname" required placeholder="Last name" value="<?=$user[0]['lname']?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="f-field-input-2 w-input" required id="email" value="<?=$user[0]['email']?>" placeholder="Email address">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone number</label>
                            <input type="text" class="f-field-input-2 w-input" required id="phone" placeholder="Phone number" value="<?=$user[0]['phone']?>">
                        </div>
                        <h5>Address Details</h5>
                        <div class="form-group">
                            <label for="work_address">First Line</label>
                            <input type="text" class="f-field-input-2 w-input" required id="work_address" required placeholder="First Line" value="<?=$user[0]['work_address']?>">
                        </div>
                        <div class="form-group">
                            <label for="work_address1">Second Line</label>
                            <input type="text" class="f-field-input-2 w-input" id="work_address1" placeholder="Last Name" value="<?=$user[0]['work_address1']?>">
                        </div>
                        <div class="form-group">
                            <label for="town">City</label>
                            <input type="text" class="f-field-input-2 w-input" id="town" required placeholder="City" value="<?=$user[0]['town']?>">
                        </div>
                        <div class="form-group">
                            <label for="post_code">
                                <?php
                                if($user[0]['country'] == "America" || $user[0]['country'] == "Canada"){
                                    ?>
                                    ZIP Code
                                    <?php
                                }else{
                                    ?>
                                    Post Code
                                    <?php
                                }
                                ?>

                            </label>
                            <input type="text" class="f-field-input-2 w-input" required id="post_code" required placeholder="" value="<?=$user[0]['post_code']?>">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="update_btn" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!--password phone modal-->
    <div class="modal fade" id="password" tabindex="-1" role="dialog" aria-labelledby="example1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="my-profile-general-wrapper bg-white">
                    <div class="my-profile-general ">
                        <h3 class="my-profile h3"> Change Password</h3>
                    </div>
                    <!-- Change Password -->
                    <div class="form-group">
                        <form id="updatePassword1">
                            <input type="hidden" id="up_id" value="<?=$user[0]['id']?>" name="">

                            <input type="password" placeholder="Old Password" class="form-control form-control-lg" id="currentpass">


                            <input type="password" placeholder="New Password" class="form-control form-control-lg" id="newpass">

                            <input type="password" placeholder="Confirm Password" class="form-control form-control-lg" id="cofirmpass">
                            <button type="submit" class="profile-blue-btn btn password btn btn-primary">Change Password</button>
                        </form>
                    </div>

                </div>
            </div>


        </div>

    </div>

<?php include_once "includes/footer-no-cta.php"?>
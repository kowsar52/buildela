<?php

if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
    // session isn't started
    session_start();
}

include "crud.php";
include "functions.php";
date_default_timezone_set('Europe/London');
//connect to database
$db = new Database();
$db->connect();
//create functions object
$Functions = new Functions();
$func = $_POST['func'];


function compressImage($source, $destination, $compressionPercentage) {
    // Create Imagick instance
    $imagick = new Imagick($source);

    $imagick->setImageCompression(imagick::COMPRESSION_JPEG);

    // Get original image format
    $imageFormat = $imagick->getImageFormat();
    $imagick->setImageCompressionQuality($compressionPercentage);
    $imagick->setformat('jpg');
    // // Calculate new quality based on the desired percentage

    // Write the compressed image to the destination
    $imagick->writeImage($destination);

    // Destroy the Imagick instance
    $imagick->destroy();
}





if ($func == 1) {

    $fname = htmlspecialchars(stripslashes($_POST['fname']));
    $fname = $db->escapeString($fname);

    $lname = htmlspecialchars(stripslashes($_POST['lname']));
    $lname = $db->escapeString($lname);

    $email = htmlspecialchars(stripslashes($_POST['email']));
    $email = $db->escapeString($email);

    $pass1 = htmlspecialchars(stripslashes($_POST['pass1']));
    $pass1 = $db->escapeString($pass1);
    $haspass = md5($pass1);

    $phone = htmlspecialchars(stripslashes($_POST['phone']));
    $phone = $db->escapeString($phone);

    $builder1 = htmlspecialchars(stripslashes($_POST['builder1']));
    $builder1 = $db->escapeString($builder1);

    $builder2 = htmlspecialchars(stripslashes($_POST['builder2']));
    $builder2 = $db->escapeString($builder2);

    $operat = htmlspecialchars(stripslashes($_POST['operat']));
    $operat = $db->escapeString($operat);

    $trading_name = htmlspecialchars(stripslashes($_POST['trading_name']));
    $trading_name = $db->escapeString($trading_name);

    $work_address = htmlspecialchars(stripslashes($_POST['work_address']));
    $work_address = $db->escapeString($work_address);

    $work_address1 = htmlspecialchars(stripslashes($_POST['work_address1']));
    $work_address1 = $db->escapeString($work_address1);

    $work_address=$work_address."__".$work_address1;

    $town = htmlspecialchars(stripslashes($_POST['town']));
    $town = $db->escapeString($town);

    $country = htmlspecialchars(stripslashes($_POST['country']));
    $country = $db->escapeString($country);

    $post_code = htmlspecialchars(stripslashes($_POST['post_code']));
    $post_code = $db->escapeString($post_code);

    $distance = htmlspecialchars(stripslashes($_POST['distance']));
    $distance = $db->escapeString($distance);

    $note = htmlspecialchars(stripslashes($_POST['note']));
    $note = $db->escapeString($note);

    $from_referral_code = htmlspecialchars(stripslashes($_POST['from_referral_code']));
    $from_referral_code = $db->escapeString($from_referral_code);
    if(!empty($_FILES['dbs'])){
        $image=$_FILES['dbs'];
        $filename=$image['name'];
        $file_tmp=$image['tmp_name'];
        $target="../uploads/";
        $timestamp=time();
        $file=$timestamp.'-'.$filename;
        $upload_to=$target.$file;
        move_uploaded_file($file_tmp,$upload_to);
    }else{
        $upload_to=null;
    }


    if ($Functions->CheckEmailExists($email)) {
        echo 'email-exist';
        return;
    }
    $to_referral_code=$Functions->randomReferralCode();

    $currency_symbol='£';

    if($country=='UK'){
        $currency_symbol='£';
    }else if($country=='America'){
        $currency_symbol='$';
    }else if($country=='Australia'){
        $currency_symbol='$';
    }else if($country=='Canada'){
        $currency_symbol='$';
    }else if($country=='Ireland'){
        $currency_symbol='€';
    }else if($country=='Italy'){
        $currency_symbol='€';
    }else if($country=='South Africa'){
        $currency_symbol='R';
    }else if($country=='Turkey'){
        $currency_symbol='₺';
    }else if($country=='United Arab Emirates'){
        $currency_symbol='د.إ';
    }


    $sql = "insert into users(user_role,fname,lname,email,phone,password,builder1,builder2,operate,
        trading_name,work_address,town,post_code,distance,note,dbs_path,to_referral_code,from_referral_code,`country`,`currency_symbol`) values 
        ('jobs_person','$fname','$lname','$email','$phone','$haspass','$builder1','$builder2','$operat',
       '$trading_name','$work_address','$town','$post_code','$distance','$note','$upload_to','$to_referral_code','$from_referral_code','$country','$currency_symbol')";

    if ($db->sql($sql)) {

//        if(!empty($from_referral_code)){
//            $user=$Functions->getuserbyRefferal($from_referral_code);
//            $balance=$user[0]['balance'];
//            $balance+=3;
//            $sql ="update users set balance='$balance' where to_referral_code ='$from_referral_code' ";
//            $db->sql($sql);
//        }

        $userid = $db->insert_id();
        $sql="insert into  set_notification (new_lead_phone,new_lead_email,new_lead_app,shortlist_phone,shortlist_email,shortlist_app,hired_phone,hired_email,hired_app,feedback_phone,feedback_email,feedback_app,user_id) values 
                                            ('false','true','true','false','true','true','true','true','true','false','true','true','$userid')";
        $db->sql($sql);

        $sql = "SELECT * FROM users where id='$userid'";
        if ($db->sql($sql)) {
            $result = $db->getResult();
            if (!empty($result)) {
                if (strcasecmp($result[0]["email"], $email) == 0) {

                    foreach ($result as $row) {

                        $_SESSION['user_id'] = $row["id"];
                        $_SESSION['user_type']=$row['user_type'];
                        $_SESSION['user_status']=$row['status'];
                        $_SESSION['user_role']=$row['user_role'];
                        $_SESSION['subscription_status']=$row['subscription_status'];
                        $_SESSION['islogin'] = 1;
                        $Functions->set_last_seen($_SESSION['user_id']);
                        echo "true";
                    }
                } else {
                    echo "false";
                }
            }else{
                echo 'false';
            }

        }else{
            echo 'false';
        }
    }//if sql()

}//register new user

//upload img
else if ($func == 2) {
    $id = htmlspecialchars(stripslashes($_POST['uid']));
    $id = $db->escapeString($id);

    if(!empty($_FILES['img1'])){
        $image = $_FILES['img1'];
        $filename = $image['name'];
        $file_tmp = $image['tmp_name'];
        $target = "../uploads/";

        // Generate a unique file name
        $timestamp = time();
        $random_string = substr(md5(uniqid(rand(), true)), 0, 8); // Generate a random string
        $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
        $file = $timestamp . '-' . $random_string . '.' . $file_extension;
        $upload_to = $target . $file;

        move_uploaded_file($file_tmp, $upload_to);

        compressImage($upload_to, $upload_to, 25);

    } else {
        $upload_to = null;
    }

    $sql = "UPDATE users SET img_path='$upload_to' WHERE id='$id'";

    if ($db->sql($sql)) {
        echo "true";
    } else {
        echo "false";
    }
}


//update Profile

else if ($func == 3) {
    $id = htmlspecialchars(stripslashes($_POST['id']));
    $id = $db->escapeString($id);

    $fname = htmlspecialchars(stripslashes($_POST['fname']));
    $fname = $db->escapeString($fname);

    $email = htmlspecialchars(stripslashes($_POST['email']));
    $email = $db->escapeString($email);

    $phone = htmlspecialchars(stripslashes($_POST['phone']));
    $phone = $db->escapeString($phone);

    $email = htmlspecialchars(stripslashes($_POST['email']));
    $email = $db->escapeString($email);

    if($_SESSION['user_role'] != 'home_owner'){

        $operat = htmlspecialchars(stripslashes($_POST['operat']));
        $operat = $db->escapeString($operat);

        $trading_name = htmlspecialchars(stripslashes($_POST['trading_name']));
        $trading_name = $db->escapeString($trading_name);

        $company_name = htmlspecialchars(stripslashes($_POST['company_name']));
        $company_name = $db->escapeString($company_name);

        $company_number = htmlspecialchars(stripslashes($_POST['company_number']));
        $company_number = $db->escapeString($company_number);

        $work_address = htmlspecialchars(stripslashes($_POST['work_address']));
        $work_address = $db->escapeString($work_address);

        $town = htmlspecialchars(stripslashes($_POST['town']));
        $town = $db->escapeString($town);

        $post_code = htmlspecialchars(stripslashes($_POST['post_code']));
        $post_code = $db->escapeString($post_code);

        $distance = htmlspecialchars(stripslashes($_POST['distance']));
        $distance = $db->escapeString($distance);

        $note = htmlspecialchars(stripslashes($_POST['note']));
        $note = $db->escapeString($note);

        if(!empty($_FILES['dbs'])){
            $image=$_FILES['dbs'];
            $filename=$image['name'];
            $file_tmp=$image['tmp_name'];
            $target="../uploads/";
            $timestamp=time();
            $file=$timestamp.'-'.$filename;
            $upload_to=$target.$file;
            move_uploaded_file($file_tmp,$upload_to);
        }else{
            $upload_to=null;
        }

        $sql = "update users set fname='$fname',email='$email',phone='$phone',operate='$operat',company_name='$company_name',distance='$distance',
        company_number='$company_number',trading_name='$trading_name',
        work_address='$work_address',town='$town',
        post_code='$post_code',note='$note', dbs_path='$upload_to'  where id='$id'";
    }else{
        $sql = "update users set fname='$fname',email='$email', phone='$phone' where id='$id'";

    }

    if ($db->sql($sql)) {

        echo "true";
    } else {

        echo "false";
    }


} //add category
else if($func == 4){
    $oldpass = htmlspecialchars(stripslashes($_POST['oldpass']));
    $oldpass = $db->escapeString($oldpass);

    $newpass = htmlspecialchars(stripslashes($_POST['newpass']));
    $newpass = $db->escapeString($newpass);

    $confirmpass = htmlspecialchars(stripslashes($_POST['confirmpass']));
    $confirmpass = $db->escapeString($confirmpass);

    $userId = htmlspecialchars(stripslashes($_POST['userid']));
    $userId = $db->escapeString($userId);

    if (!empty($oldpass) && !empty($newpass)) {

        if ($Functions->UpdatePassword($userId,$confirmpass,$oldpass)) {
            echo "true";
        } else {
            echo "false";
        }
    }
}//update password

else if($func==5){
    $userId = htmlspecialchars(stripslashes($_POST['userid']));
    $userId = $db->escapeString($userId);

    $work_area = htmlspecialchars(stripslashes($_POST['work_area']));
    $work_area = $db->escapeString($work_area);

    $sql = "update users set work_area='$work_area' WHERE id='$userId'";

    if ($db->sql($sql)) {
        echo "true";
    } else {

        echo "false";
    }
}

//login user
else if ($func == 6) {

    $email = htmlspecialchars(stripslashes($_POST['email']));
    $email = $db->escapeString($email);

    $password = htmlspecialchars(stripslashes($_POST['password']));
    $password = $db->escapeString($password);

    $hashpass = md5($password);
    $sql = "SELECT * FROM users WHERE email='$email' and password='$hashpass'";
    if ($db->sql($sql)) {

        $result = $db->getResult();
        if (!empty($result)) {

            if (strcasecmp($result[0]["email"], $email) == 0) {


                foreach ($result as $row) {
                    if ($row["status"]==1) {

                        $_SESSION['user_id'] = $row["id"];
                        $_SESSION['user_type']=$row['user_type'];
                        $_SESSION['user_status']=$row['status'];
                        $_SESSION['user_role']=$row['user_role'];
                        $_SESSION['subscription_status']=$row['subscription_status'];
                        $_SESSION['islogin'] = 1;
                        $Functions->set_last_seen($_SESSION['user_id']);
                        // echo "true";
                        if($row['user_type'] == 1 || $row['user_type'] == "1"){
                            echo "admin";
                        
                        } elseif($row['user_role'] == "jobs_person"){
                        echo "jobs_person";
                        
                        }else{
                            echo "true";
                            $Functions->updateSubscriptionStatus($_SESSION['user_id']);
//                            $Functions->autoCharge($_SESSION['user_id']);
                        }
                    }else{
                        echo "blocked";
                    }
                }
                $Functions->setOnlineStatus($result[0]["id"]);

            } else {
                echo "false";
            }
        }else{
            echo 'false';
        }
    }else{
        echo 'false';
    }


}//func6


else if ($func == 7) {
    $id = htmlspecialchars(stripslashes($_POST['id']));
    $id = $db->escapeString($id);
    $sql = "update users set status=0 where id='$id'";
    if ($db->sql($sql)) {
        echo "true";
    } else {
        echo "false";
    }
} //blockUser
else if ($func == 8) {
    $id = htmlspecialchars(stripslashes($_POST['id']));
    $id = $db->escapeString($id);
    $sql = "update users set status=1 where id='$id'";
    if ($db->sql($sql)) {

        echo "true";
    }
    else {
        echo "false";
    }

}//ActiveUser

//recover password
else if ($func==9) {

    $email = htmlspecialchars(stripslashes($_POST['email']));
    $email = $db->escapeString($email);

    if (!$Functions->CheckEmailExists($email)) {
        echo 'email not exist';

    }else{

        $pass=$Functions->randomPassword();
        $userinfo=$Functions->getUserByEmail($email);
        $sql = "UPDATE `users` SET `reset_token`='$pass' WHERE email='$email'";

        if ($db->sql($sql)) {
            echo "true";
            $Functions->sendrecoveremail($email,$pass,$userinfo[0]['phone']);
        } else {
            echo "false";
        }
    }
    // code...
}
else if ($func==10) {

    $password = htmlspecialchars(stripslashes($_POST['password']));
    $password = $db->escapeString($password);
    $password1=md5($password);

    $reset_token = htmlspecialchars(stripslashes($_POST['reset_code']));
    $reset_token = $db->escapeString($reset_token);

    $sql = "SELECT * from users WHERE reset_token='$reset_token'";
    $db->sql($sql);
    $c=count($db->getResult());

    if($c!=1) {
        echo "Token not found";

    }else{
        $sql = "UPDATE `users` SET `password`='$password1',`reset_token`='' WHERE 
       reset_token='$reset_token'";

        if ($db->sql($sql)) {
            echo "true";
        } else {
            echo "false";
        }


    }
}
else if($func == 11){
    $main_type  = htmlspecialchars(stripslashes($_POST['main_type']));
    $main_type  = $db->escapeString($main_type);

    $options    = htmlspecialchars(stripslashes($_POST['options']));
    $options    = $db->escapeString($options);

    $sub_type   = htmlspecialchars(stripslashes($_POST['sub_type']));
    $sub_type   = $db->escapeString($sub_type);

    $title      = htmlspecialchars(stripslashes($_POST['title']));
    $title      = $db->escapeString($title);

    $post_code  = htmlspecialchars(stripslashes($_POST['post_code']));
    $post_code  = $db->escapeString($post_code);

    $pcountry   = htmlspecialchars(stripslashes($_POST['note']));
    $note       = $db->escapeString($note);

    $note       = htmlspecialchars(stripslashes($_POST['note']));
    $note       = $db->escapeString($note);

    $user_id=$_SESSION['user_id'];
    $later = date("Y-m-d H:i:s");

    $users=$Functions->UserInfo($user_id);

    $country= $users[0]['country'];

    if(empty($country)) $country = $pcountry;


    $sql="insert into post_job 
    (user_id,title,post_code,main_type,sub_type,options,job_discription,created_date,`country`)values 
    ('$user_id','$title','$post_code','$main_type','$sub_type','$options','$note','$later','$country')";

    // echo $sql;

    if ($db->sql($sql)) {
        $insert_id=$db->insert_id();
        echo  $insert_id."-true";

        $sql="insert into crone_jobs (job_id) values ('$insert_id')";
        $db->sql($sql);

        $upload_to = "";
        $type="";
        $upload_path_for_all_files = "";
        // if(!empty($_FILES)){
        //     foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name) {
        //         $file_name=$_FILES["files"]["name"][$key];
        //         $file_tmp=$_FILES["files"]["tmp_name"][$key];
        //         $file_type=$_FILES["files"]["type"][$key];


        //         if($file_type=='video/mp4' || $file_type == 'MOV' || $file_type == 'video/quicktime'){
        //             $type='video';
        //         }else{
        //             $type='image';
        //         }

        //         $timestamp=time();
        //         $target="../jobsUploads/";
        //         $file=$timestamp.'-'.$file_name;
        //         $upload_to=$target.$file;
        //         if(move_uploaded_file($file_tmp,$upload_to)){

        //             $sql="insert into jobs_gallery (job_id,file_type,img_path) values ('$insert_id','$type','$upload_to') ";
        //             $db->sql($sql);
        //         }

        //     }
        // }//if to check if _FILES is empty



        if (!empty($_FILES)) {
            foreach ($_FILES["files"]["tmp_name"] as $key => $tmp_name) {
                $file_name = $_FILES["files"]["name"][$key];
                $file_tmp = $_FILES["files"]["tmp_name"][$key];
                $file_type = $_FILES["files"]["type"][$key];

                if ($file_type == 'video/mp4' || $file_type == 'video/quicktime' || $file_type == 'MOV') {
                    // For video files, use FFmpeg to compress before moving
                    $type = 'video';
                    $timestamp = time();
                    $target = "../jobsUploads/";
                    $file = $timestamp . '-' . $file_name;
                    $upload_to = $target . $file;
                    move_uploaded_file($file_tmp, $upload_to);
                } else {
                    // For image files, compress before moving
                    $type = 'image';
                    $timestamp = time();
                    $target = "../jobsUploads/";
                    $file = $timestamp . '-' . $file_name;
                    $upload_to = $target . $file;

                    move_uploaded_file($file_tmp, $upload_to);


                    // Compress the image with 50% quality (you can adjust the quality as needed)
                    compressImage($upload_to, $upload_to, 25);
                }

                // if (move_uploaded_file($file_tmp, $upload_to)) {
                    $sql = "INSERT INTO jobs_gallery (job_id, file_type, img_path) VALUES ('$insert_id', '$type', '$upload_to')";
                    $db->sql($sql);
                // }
            }
        }

    }else{
        echo "false";
    }


}//update
//Delete Main Category     
else if ($func == 12) {
    $id = htmlspecialchars(stripslashes($_POST['id']));
    $id = $db->escapeString($id);
    $sql = "DELETE from main_category where id='$id'";
    if ($db->sql($sql)) {
        $sql = "DELETE from sub_category where main_category='$id'";
        $db->sql($sql);

        $sql = "DELETE from question where main_category_id='$id'";
        $db->sql($sql);

        echo "true";
    }
    else {
        echo "false";
    }

}
//Delete Sub Category
else if ($func == 13) {
    $id = htmlspecialchars(stripslashes($_POST['id']));
    $id = $db->escapeString($id);
    $sql = "DELETE from sub_category where id='$id'";
    if ($db->sql($sql)) {
        $sql = "DELETE from add_options where sub_category='$id'";
        $db->sql($sql);

        echo "true";
    }
    else {
        echo "false";
    }

}
//Delete area
else if ($func == 130) {
    $id = htmlspecialchars(stripslashes($_POST['id']));
    $id = $db->escapeString($id);
    $sql = "DELETE from citiesseo where id='$id'";
    if ($db->sql($sql)) {
    

        echo "true";
    }
    else {
        echo "false";
    }

}//Delete area
else if ($func == 131) {
    $id = htmlspecialchars(stripslashes($_POST['id']));
    $id = $db->escapeString($id);
    $sql = "DELETE from services where id='$id'";
    if ($db->sql($sql)) {
    

        echo "true";
    }
    else {
        echo "false";
    }

}
//Add new Category
else if ($func == 14) {
    $name = htmlspecialchars(stripslashes($_POST['name']));
    $name = $db->escapeString($name);

    $sql="insert into main_category (category_name) values('$name')";

    if($name==""){
        echo "fill-fields";
        return;
    }

    if ($db->sql($sql)) {

        echo "true";
    }
    else {

        echo "false";
    }

}
//Add new Category
//Add new service
else if ($func == 140) {
    $name = htmlspecialchars(stripslashes($_POST['name']));
    $name = $db->escapeString($name);
    
if(!empty($_FILES['image'])){
    if ($_FILES['image']['error'] > 0) {
        echo 'An error ocurred while uploading.';
        return;
    }

    $image = $_FILES['image'];
    $filename = $image['name'];
    $file_tmp = $image['tmp_name'];
    $target = "../uploads/";
    $timestamp = time();
    $file = $timestamp . '-' . $filename;
    $upload_to = $target . $file;
    
    if (!move_uploaded_file($file_tmp, $upload_to)) {
        echo 'Failed to move uploaded file.';
        return;
    }
}else{
    $upload_to = null;
}
    
    $sql="insert into services (service_name,image_path) values ('$name','$upload_to')";

    if($name==""){
        echo "fill-fields";
        return;
    }

    if ($db->sql($sql)) {

        echo "true";
    }
    else {

        echo "false";
    }

}
//Add new service
//Add new area
else if ($func == 141) {
    $name = htmlspecialchars(stripslashes($_POST['name']));
    $name = $db->escapeString($name);
    

    
    $sql="insert into citiesseo (city_name) values ('$name')";

    if($name==""){
        echo "fill-fields";
        return;
    }

    if ($db->sql($sql)) {

        echo "true";
    }
    else {

        echo "false";
    }

}
//Add new area
else if ($func == 15) {
    $name = htmlspecialchars(stripslashes($_POST['name']));
    $name = $db->escapeString($name);
    $index = htmlspecialchars(stripslashes($_POST['index']));
    $index = $db->escapeString($index);

    $type = htmlspecialchars(stripslashes($_POST['type']));
    $type = $db->escapeString($type);

    if($name==""||$type==""){
        echo "fill-fields";
        return;
    }


    $sql="insert into sub_category (main_category,category_name,`index`) values('$type','$name','$index')";
    if ($db->sql($sql)) {

        echo "true";
    }
    else {
        echo "false";
    }

}
else if ($func == 16) {
    $selectedID = htmlspecialchars(stripslashes($_POST['selectedID']));
    $selectedID = $db->escapeString($selectedID);

    $sql="SELECT * from sub_category where main_category='$selectedID'";
    if ($db->sql($sql)) {
        echo json_encode($db->getResult());
    }
    else {
        echo "false";
    }

}
else if ($func == 50) {
    $selectedID = htmlspecialchars(stripslashes($_POST['selectedID']));
    $selectedID = $db->escapeString($selectedID);

    $sql="SELECT * from add_options where sub_category='$selectedID'";
    if ($db->sql($sql)) {
        echo json_encode($db->getResult());
    }
    else {
        echo "false";
    }

}
else if ($func == 17) {
    $name = htmlspecialchars(stripslashes($_POST['name']));
    $name = $db->escapeString($name);

    $lname = htmlspecialchars(stripslashes($_POST['lname']));
    $lname = $db->escapeString($lname);

    $phone = htmlspecialchars(stripslashes($_POST['phone']));
    $phone = $db->escapeString($phone);

    $email = htmlspecialchars(stripslashes($_POST['email']));
    $email = $db->escapeString($email);

    $comment = htmlspecialchars(stripslashes($_POST['comment']));
    $comment = $db->escapeString($comment);

    $sql="insert into comment (`name`,`email`,`lname`,`phone`,`type`,`comment`) values ('$name','$email','$lname','$phone','Contact Message','$comment')";
    if ($db->sql($sql)) {
        echo "true";
    }
    else {
        echo "false";
    }

}//17

else if ($func == 18) {
    $id = htmlspecialchars(stripslashes($_POST['id']));
    $id = $db->escapeString($id);
    $sql = "DELETE from post_job where id='$id'";

    if ($db->sql($sql)) {

        $sql = "DELETE from apply_job where job_id='$id'";
        $db->sql($sql);

//        $sql="select * from jobs_gallery where job_id = $id ";
//        $this->db->sql($sql);
//        $result=$this->db->getResult();
//        foreach($result as $res){
//            if(file_exists($res['image_path'])) {
//                unlink($res['image_path']);
//            }
//
//        }//foreach


        $sql = "SELECT img_path FROM jobs_gallery WHERE job_id='$id'";
        $db->sql($sql);
        $result = $db->getResult();
        foreach ($result as $res) {
            $file_path = $res['img_path'];
            // Check if the file exists before attempting to delete it
            if (file_exists($file_path)) {
                // Delete the file from the server
                unlink($file_path);
            }
        }





        $sql = "DELETE from jobs_gallery where job_id='$id'";
        $db->sql($sql);


//        $sql = "DELETE from rateuser where job_id='$id'";
//        $db->sql($sql);


        echo "true";
    }
    else {
        echo "false";
    }

}
//Add new Category
else if ($func == 19) {
    $question = htmlspecialchars(stripslashes($_POST['question']));
    $question = $db->escapeString($question);

    $option1 = htmlspecialchars(stripslashes($_POST['option1']));
    $option1 = $db->escapeString($option1);

    $option2 = htmlspecialchars(stripslashes($_POST['option2']));
    $option2 = $db->escapeString($option2);

    $option3 = htmlspecialchars(stripslashes($_POST['option3']));
    $option3 = $db->escapeString($option3);

    $option4 = htmlspecialchars(stripslashes($_POST['option4']));
    $option4 = $db->escapeString($option4);

    $ans = htmlspecialchars(stripslashes($_POST['ans']));
    $ans = $db->escapeString($ans);

    $main_type = htmlspecialchars(stripslashes($_POST['main_type']));
    $main_type = $db->escapeString($main_type);

    // $sub_type = htmlspecialchars(stripslashes($_POST['sub_type']));
    // $sub_type = $db->escapeString($sub_type);

//    if($question==""||$option1==""||$option2==""||$option3==""||$option4==""||$ans==""||$main_type==""){
//
//        echo "fill-fields";
//        return;
//    }

    $sql="insert into question (main_category_id,sub_category_id,question,option1,option2,option3,option4,right_ans) values
    ('$main_type',0,'$question','$option1','$option2','$option3','$option4','$ans')";
    if ($db->sql($sql)) {

        echo "true";
    }
    else {
        echo "false";
    }

}
//Delete Question     
else if ($func == 20) {
    $id = htmlspecialchars(stripslashes($_POST['id']));
    $id = $db->escapeString($id);
    $sql = "DELETE from question where id='$id'";
    if ($db->sql($sql)) {

        echo "true";
    }
    else {
        echo "false";
    }
}
//Add new Category
else if ($func == 21) {

    $q_id = htmlspecialchars(stripslashes($_POST['q_id']));
    $q_id = $db->escapeString($q_id);

    $question = htmlspecialchars(stripslashes($_POST['question']));
    $question = $db->escapeString($question);

    $option1 = htmlspecialchars(stripslashes($_POST['option1']));
    $option1 = $db->escapeString($option1);

    $option2 = htmlspecialchars(stripslashes($_POST['option2']));
    $option2 = $db->escapeString($option2);

    $option3 = htmlspecialchars(stripslashes($_POST['option3']));
    $option3 = $db->escapeString($option3);

    $option4 = htmlspecialchars(stripslashes($_POST['option4']));
    $option4 = $db->escapeString($option4);

    $ans = htmlspecialchars(stripslashes($_POST['ans']));
    $ans = $db->escapeString($ans);


    $type = htmlspecialchars(stripslashes($_POST['type']));
    $type = $db->escapeString($type);


    $sql="update question set main_category_id='$type',question='$question',option1='$option1',option2='$option2',option3='$option3',option4='$option4',right_ans='$ans' where id='$q_id'";
    if ($db->sql($sql)) {

        echo "true";
    }
    else {
        echo "false";
    }

}
else if ($func == 22) {
    $id = htmlspecialchars(stripslashes($_POST['q_id']));
    $id = $db->escapeString($id);
    $result=$Functions->getSingleQuestion($id);
    if (isset($result)) {
        echo json_encode($result);
    }
    else {
        echo "false";
    }

}
else if ($func == 23) {
    $id = htmlspecialchars(stripslashes($_POST['q_id']));
    $id = $db->escapeString($id);
    $result=$Functions->getQuestion($id);
    if (isset($result)) {
        echo json_encode($result);
    }
    else {
        echo "false";
    }

}

else if ($func == 24) {
    $id = htmlspecialchars(stripslashes($_POST['selectedID']));
    $id = $db->escapeString($id);

    $user_id=$_SESSION['user_id'];
    // if already do the test of this category

    $sql="select * from verify_skill where user_id='$user_id' and main_category = '$id' and status=0";
    $db->sql($sql);
    $res=$db->getResult();

    if(count($res)>0){
        $sql="delete from verify_skill where user_id='$user_id' and main_category = '$id'";
        $db->sql($sql);
    }

    //Check how many test is passed
    $sql="select COUNT(*) as skill_total from verify_skill where user_id='$user_id' and status = 1 ";
    $db->sql($sql);
    $result1=$db->getResult();



    //Check a user is alredy passed this catagory

    $sql = "SELECT * from verify_skill where main_category='$id' and user_id='$user_id' ";
    $db->sql($sql);
    $result=$db->getResult();

    // print_r($result);

    if($result1[0]['skill_total']>=5){

        echo "cross_limit";

    } else if((!empty($result)) &&( $result[0]['status'] == 1 || $result[0]['status'] == "1")){

        echo "verify";
    }else{

        $sql = "SELECT * from main_category where id='$id'";
        if ($db->sql($sql)) {

            echo json_encode($db->getResult());
        }
        else {
            echo "false";
        }

    }
}
else if($func == 25){
    $main_category_id = htmlspecialchars(stripslashes($_POST['main_category_id']));
    $main_category_id = $db->escapeString($main_category_id);

    $sub_category_id = htmlspecialchars(stripslashes($_POST['sub_category_id']));
    $sub_category_id = $db->escapeString($sub_category_id);

    $score = htmlspecialchars(stripslashes($_POST['score']));
    $score = $db->escapeString($score);
    $user_id = $_SESSION['user_id'];
    $status = htmlspecialchars(stripslashes($_POST['status']));
    $status = $db->escapeString($status);
    $verify=1;

    if($main_category_id==18 || $main_category_id==23){

        $verify=0;
    }


    $sql="insert into verify_skill (user_id,main_category,sub_category,status,score,verify) values 
    ('$user_id','$main_category_id','$sub_category_id','$status','$score','$verify')";

    if ($db->sql($sql)) {

        echo "true";
    } else {
        echo "false";
    }

}//Add Uuser scrore

//Delete Main Category     
else if ($func == 26) {
    $id = htmlspecialchars(stripslashes($_POST['id']));
    $id = $db->escapeString($id);
    $sql = "DELETE from verify_skill where id='$id'";
    echo $db->getSql();
    if ($db->sql($sql)) {

        echo "true";
    }
    else {
        echo "false";
    }

}
//Apply for Job
else if ($func == 27) {
    $job_id = htmlspecialchars(stripslashes($_POST['job_id']));
    $job_id = $db->escapeString($job_id);

    $location = htmlspecialchars(stripslashes($_POST['job_location']));
    $location = $db->escapeString($location);

    $message = htmlspecialchars(stripslashes($_POST['message']));
    $message = $db->escapeString($message);
    $user_id=$_SESSION['user_id'];

    //Email detailes

    //applied User details
    $sql="select * from users where id='$user_id'";
    $db->sql($sql);
    $appliedUserDetails=$db->getResult();
    $appliedUsername=$appliedUserDetails[0]['fname'];
    $appliedUserID=$appliedUserDetails[0]['id'];

    //job details
    $sql="select * from post_job where id='$job_id'";
    $db->sql($sql);
    $jobDetails=$db->getResult();
    $jobTitle=$jobDetails[0]['title'];
    //to user details
    $jobOwnerID=$jobDetails[0]['user_id'];
    $sql="select * from users where id='$jobOwnerID'";
    $db->sql($sql);
    $toUserDetails=$db->getResult();
    $toUsername=$toUserDetails[0]['fname'];
    $toUseremail=$toUserDetails[0]['email'];

    if ($message=="") {
        echo "fill-fields";
        return;
    }

    
    $sql="select * from apply_job where user_id='$user_id' and job_id='$job_id'";
    $db->sql($sql);

    
    if($db->numRows()>0) {
        echo "already-apply";
    }else{

        $sql="insert into apply_job (job_id,job_location,user_id,message) values ('$job_id','$location','$user_id','$message')";
        if ($db->sql($sql)) {         

            // updating statu_date for sorting of most recent leads
            $later = date("Y-m-d H:i:s");
            $sql = "update post_job set interested_date='$later' where id='$job_id'"; 
            if($db->sql($sql)) echo "true";

            // $Functions->UserApplyemail($appliedUsername,$appliedUserID,$jobTitle,$toUseremail,$toUserDetails[0]['phone']);
        }
        else {
            echo "false";
        }//else

    }//else

}//27

//Home person signup 
if ($func == 28) {

    $fname = htmlspecialchars(stripslashes($_POST['fname']));
    $fname = $db->escapeString($fname);

    $lname = htmlspecialchars(stripslashes($_POST['lname']));
    $lname = $db->escapeString($lname);

    $email = htmlspecialchars(stripslashes($_POST['email']));
    $email = $db->escapeString($email);

    $pass1 = htmlspecialchars(stripslashes($_POST['pass1']));
    $pass1 = $db->escapeString($pass1);
    $haspass = md5($pass1);

    $phone = htmlspecialchars(stripslashes($_POST['phone']));
    $phone = $db->escapeString($phone);

    $address = htmlspecialchars(stripslashes($_POST['address']));
    $address = $db->escapeString($address);

    $address1 = htmlspecialchars(stripslashes($_POST['address1']));
    $address1 = $db->escapeString($address1);

    $address=$address1."__".$address1;

    $post_code = htmlspecialchars(stripslashes($_POST['post_code']));
    $post_code = $db->escapeString($post_code);

    if ($Functions->CheckEmailExists($email)) {
        echo 'email-exist';
        return;
    }
    else {
        $sql = "insert into users(user_role,fname,lname,email,phone,password,work_address,
        post_code) values 
        ('home_owner','$fname','$lname','$email','$phone','$haspass','$address','$post_code')";
        if ($db->sql($sql)) {
            $userid = $db->insert_id();

            $sql = "SELECT * FROM users where id='$userid'";
            if ($db->sql($sql)) {

                $result = $db->getResult();
                if (!empty($result)) {

                    if (strcasecmp($result[0]["email"], $email) == 0) {


                        foreach ($result as $row) {

                            $_SESSION['user_id'] = $row["id"];
                            $_SESSION['user_type']=$row['user_type'];
                            $_SESSION['user_status']=$row['status'];
                            $_SESSION['user_role']=$row['user_role'];
                            $_SESSION['islogin'] = 1;
                            $Functions->set_last_seen($_SESSION['user_id']);
                            echo "true";
                        }
                    } else {
                        echo "false";
                    }
                }else{
                    echo 'false';
                }

            }else{
                echo 'false';
            }
        } else {

            echo "false";
        }
    }//else

}//register new Home Person

//add user at job post time
if ($func == 29) {

    $fname = htmlspecialchars(stripslashes($_POST['fname']));
    $fname = $db->escapeString($fname);

    $lname = htmlspecialchars(stripslashes($_POST['lname']));
    $lname = $db->escapeString($lname);

    $email = htmlspecialchars(stripslashes($_POST['email']));
    $email = $db->escapeString($email);

    $pass = htmlspecialchars(stripslashes($_POST['pass']));
    $pass = $db->escapeString($pass);

    $country = htmlspecialchars(stripslashes($_POST['country']));
    $country = $db->escapeString($country);

    $pass1=md5($pass);

    $phone = htmlspecialchars(stripslashes($_POST['phone']));
    $phone = $db->escapeString($phone);

    if ($Functions->CheckEmailExists($email)) {
        echo 'email-exist';
        return;
    }
    else {
        $sql = "insert into users(user_role,fname,lname, email,phone,password,`country`) values 
        ('home_owner','$fname','$lname', '$email','$phone','$pass1','$country')";

        if ($db->sql($sql)) {
            $userid = $db->insert_id();

            $sql = "SELECT * FROM users where id='$userid'";
            if ($db->sql($sql)) {

                $result = $db->getResult();
                if (!empty($result)) {

                    if (strcasecmp($result[0]["email"], $email) == 0) {


                        foreach ($result as $row) {

                            $_SESSION['user_id'] = $row["id"];
                            $_SESSION['user_type']=$row['user_type'];
                            $_SESSION['user_status']=$row['status'];
                            $_SESSION['user_role']=$row['user_role'];
                            $_SESSION['subscription_status']=$row['subscription_status'];
                            $_SESSION['islogin'] = 1;

                            echo "true";

                        }

                    } else {
                        echo "false";
                    }
                }else{
                    echo 'false';
                }

            }else{
                echo 'false';
            }
        }
    }//else

}//register new user a job post time

else if ($func == 30) {
    $id = htmlspecialchars(stripslashes($_POST['id']));
    $id = $db->escapeString($id);
    $sql = "DELETE from apply_job where id='$id'";
    if ($db->sql($sql)) {

        echo "true";
    }
    else {
        echo "false";
    }

}
else if ($func == 31) {

    $userid = htmlspecialchars(stripslashes($_POST['userid']));
    $userid = $db->escapeString($userid);

    $jobid = htmlspecialchars(stripslashes($_POST['jobid']));
    $jobid = $db->escapeString($jobid);

    $my_id=$_SESSION['user_id'];

    $user=$Functions->UserInfo($userid);

    $sql = "update apply_job set status=1 where user_id='$userid' and job_id='$jobid'";
    if ($db->sql($sql)) {

        echo "true";

        $later = date("Y-m-d H:i:s");
        $sql = "update post_job set shortlisted_date='$later' where id='$jobid'"; 
        $db->sql($sql);

        $job_info=$Functions->getSingleJob($_POST['jobid']);
        $job_title=$job_info[0]['title'];
        $homeownerinfo=$Functions->UserInfo($job_info[0]['user_id']);

        $Functions->UserShortlistedemail($job_title,$_POST['jobid'],$user[0]['email'],$user[0]['phone'],$user[0]['id'],$homeownerinfo[0]['fname'],$homeownerinfo[0]['id']);

        $res=$Functions->checkChatStarted($userid,$jobid);
        if(count($res)==0){

            $last_activity=date('Y-m-d H:i:s');
            $sql = "insert into user_chat (sender_id,receiver_id,job_id,last_activity) values ('$userid','$my_id','$jobid','$last_activity')";
            if ($db->sql($sql)) {

                $homeowner=$Functions->UserInfo($job_info[0]['user_id']);
                $Functions->UserChatemail($job_title,$homeowner[0]['fname'],$user[0]['fname'],$user[0]['email'],$user[0]['phone']);
//                $Functions->UserChateMessageMobile($job_title,$homeowner[0]['fname'],$user[0]['fname'],$user[0]['phone']);
            }
        }


    }else {
        echo "false";
    }

}
else if ($func == 32) {
    $user_id = htmlspecialchars(stripslashes($_POST['user_id']));
    $user_id = $db->escapeString($user_id);

    $job_id = htmlspecialchars(stripslashes($_POST['job_id']));
    $job_id = $db->escapeString($job_id);

    $sql = "update apply_job set worker_status=1 where user_id='$user_id' and job_id='$job_id' ";
    if ($db->sql($sql)) {
        echo "true";

        $job_info=$Functions->getSingleJob($job_id);
        $homeownerinfo=$Functions->UserInfo($job_info[0]['user_id']);
        $tradespersoninfo=$Functions->UserInfo($user_id);

        $Functions->jobaccpetemail($job_info[0]['title'],$homeownerinfo[0]['phone'],$homeownerinfo[0]['email'],$tradespersoninfo[0]['fname']);
    }
    else {
        echo "false";
    }

}//32
//Apply for Job
else if ($func == 33) {
    $user_id = htmlspecialchars(stripslashes($_POST['userid']));
    $user_id = $db->escapeString($user_id);

    $job_id = htmlspecialchars(stripslashes($_POST['jobid']));
    $job_id = $db->escapeString($job_id);

    $stars = htmlspecialchars(stripslashes($_POST['stars']));
    $stars = $db->escapeString($stars);

    $message = htmlspecialchars(stripslashes($_POST['message']));
    $message = $db->escapeString($message);

    $recommedns = htmlspecialchars(stripslashes($_POST['recommends']));
    $recommedns = $db->escapeString($recommedns);
    if(empty($recommedns)) $recommedns = 'nothing said';

    $res=$Functions->getSingleJob($job_id);
    $job_title=$res[0]['title'];
    $from_user_id=$_SESSION['user_id'];

    if ($message=="") {
        echo "fill-fields";
        return;
    }
    // Escape and format the user_info JSON string
    $user_info = $_POST['user_info'];
    $escapedUserInfo = addslashes($user_info);

    // echo $recommedns;



    // Construct the SQL query
    $sql = "INSERT INTO rateuser (from_user_id, user_id, job_id, job_title, ratings,recommendation, message, user_info)
        VALUES ('$from_user_id', '$user_id', '$job_id', '$job_title', '$stars', '$recommedns', '$message', '$escapedUserInfo')";
    if ($db->sql($sql)) {
        $sql="update apply_job set rating=1 where user_id='$user_id'";
        $db->sql($sql);
        echo "true";

        $homeownerinfo=$Functions->UserInfo($from_user_id);
        $jobspersoninfo=$Functions->UserInfo($user_id);
        $Functions->UserFeedbackEmail($job_title,$homeownerinfo[0]['fname'],$jobspersoninfo[0]['phone'],$jobspersoninfo[0]['id'],$jobspersoninfo[0]['email']);
    }
    else {
        echo "false";
        // echo "SQL Error: " . $db->error();
    }

}

else if ($func == 34) {
    $userid = htmlspecialchars(stripslashes($_POST['userid']));
    $userid = $db->escapeString($userid);
    $jobid = htmlspecialchars(stripslashes($_POST['jobid']));
    $jobid = $db->escapeString($jobid);
    $sql = "update apply_job set employer_status=1 where user_id='$userid' and job_id='$jobid'";
    if ($db->sql($sql)) {

        echo "true";

        $later = date("Y-m-d H:i:s");
        $sql = "update post_job set jobswon_date='$later' where id='$jobid'"; 
        $db->sql($sql);

        $sql="select * from users where id = '$userid'";
        $db->sql($sql);
        $res=$db->getResult();

        $count_hire=$res[0]['hired_counter'];
        $count_hire+=1;
        $sql="update users set hired_counter='$count_hire' where id = '$userid'";
        $db->sql($sql);
        $job_info=$Functions->getSingleJob($_POST['jobid']);
        $homeownerinfo=$Functions->UserInfo($job_info[0]['user_id']);
        $Functions->UserHireemail($job_info[0]['id'],$res[0]['fname'],$res[0]['email'],$res[0]['phone'],$res[0]['id'],$job_info[0]['user_id'],$homeownerinfo[0]['fname']);

    }
    else {
        echo "false";
    }

}
else if ($func == 35) {
    $user_id = htmlspecialchars(stripslashes($_POST['user_id']));
    $user_id = $db->escapeString($user_id);

    $job_id = htmlspecialchars(stripslashes($_POST['job_id']));
    $job_id = $db->escapeString($job_id);

    $sql = "update apply_job set status=2 where user_id='$user_id' and job_id='$job_id'";
    if ($db->sql($sql)) {
        echo "true";

        $job_info=$Functions->getSingleJob($_POST['job_id']);
        $homeownerinfo=$Functions->UserInfo($job_info[0]['user_id']);
        $jobspersoninfo=$Functions->UserInfo($_POST['user_id']);

        $Functions->jobCompletedmail($job_info[0]['title'],$job_info[0]['id'],$jobspersoninfo[0]['fname'],$homeownerinfo[0]['phone'],$homeownerinfo[0]['email']);

    }
    else {
        echo "false";
    }

}else if ($func == 350) {
  
    $job_id = htmlspecialchars(stripslashes($_POST['id']));
    $job_id = $db->escapeString($job_id);


    $sql = "update apply_job set status=2 WHERE `job_id` = '$job_id' AND `status` = 1 AND `employer_status` = 1";
    $sql = "UPDATE apply_job SET status = 2 WHERE job_id = '$job_id' AND status = 1 AND employer_status = 1";
    if ($db->sql($sql)) {
        echo "true";

     //   $job_info=$Functions->getSingleJob($_POST['job_id']);
      //  $homeownerinfo=$Functions->UserInfo($job_info[0]['user_id']);
        //$jobspersoninfo=$Functions->UserInfo($_POST['user_id']);

   //     $Functions->jobCompletedmail($job_info[0]['title'],$job_info[0]['id'],$jobspersoninfo[0]['fname'],$homeownerinfo[0]['phone'],$homeownerinfo[0]['email']);

    }
    else {
        echo "false";
    }

}

//update settings
else if($func==36){
    $price = htmlspecialchars(stripslashes($_POST['price']));
    $s_public_key= htmlspecialchars(stripslashes($_POST['s_public_key']));
    $s_private_key = htmlspecialchars(stripslashes($_POST['s_private_key']));

    $sql ="UPDATE `settings` SET `subscription_price`='$price',`stripe_public_key`='$s_public_key',`stripe_private_key`='$s_private_key'";
    if ($db->sql($sql)) {
        echo "true";
    } else {
        echo "false";
    }
}

else if ($func == 370) {
    
    $settings = $Functions->getSettings();
    $secret_key = $settings[0]['stripe_private_key'];
    include "../vendor/stripe/stripe-php/init.php";
    \Stripe\Stripe::setApiKey($secret_key);

    $subscription_id = $_POST['cus_stripe_id']; // Assuming this is actually a Subscription ID now

    // Fetch the subscription object
    $subscription = \Stripe\Subscription::retrieve($subscription_id);
    
    // Extract the Customer ID from the subscription
    $customer_id = $subscription->customer;

    // Fetch the customer object, including sources
    $customer = \Stripe\Customer::retrieve([
      'id' => $customer_id,
      'expand' => ['default_source'],
    ]);

    $card_last4 = "";
    if($customer->default_source){
        $card_last4 = $customer->default_source->last4;
    }

    $object = new stdClass();
    $object->card_last4 = $card_last4;

    echo json_encode($object);
    
}else if ($func == 371) {
    
    $settings = $Functions->getSettings();
    $secret_key = $settings[0]['stripe_private_key'];
    include "../vendor/stripe/stripe-php/init.php";
    \Stripe\Stripe::setApiKey($secret_key);

    // Note the change here from 'cus_stripe_id' to 'subscription_id'
    $subscription_id = $_POST['subscription_id'];

    if(empty($subscription_id) || strpos($subscription_id, 'cus') === 0) {
        echo "false"; // Send response to the client side
        exit; // Stop further execution
    }

    $subscription = \Stripe\Subscription::retrieve($subscription_id);

    $end_date = $subscription->current_period_end;

    $now = time(); // current unix timestamp

    if($now > $end_date) {
        $subscription_expired = true;
        echo "false"; // Send response to the client side
    } else {
        $subscription_expired = false;
        echo "true"; // Send response to the client side
    }
}else if ($func == 372) {
    
    $settings = $Functions->getSettings();
    $secret_key = $settings[0]['stripe_private_key'];
    include "../vendor/stripe/stripe-php/init.php";
    \Stripe\Stripe::setApiKey($secret_key);

    $subscription_id = $_POST['cus_stripe_id']; 

    // Fetch the subscription object
    $subscription = \Stripe\Subscription::retrieve($subscription_id);
    
    // Get the subscription status
    $sub_status = $subscription->status;

    // Get the subscription end date and format it to a timestamp
    $end_date = $subscription->current_period_end;

    $object = new stdClass();
    $object->sub_status = $sub_status;
    $object->sub_end_date = $end_date;

    echo json_encode($object);
    
}

else if ($func == 37) {

    $monthly = $Functions->getplans('monthly', false);
    $yearly  = $Functions->getplans('yearly', false);
    
    $settings=$Functions->getSettings();
    $secret_key = $settings[0]['stripe_private_key'];
    include "../vendor/stripe/stripe-php/init.php";

    \Stripe\Stripe::setApiKey($secret_key);
    
    

    $user_id = $_SESSION['user_id'];
    // $amount = $settings[0]['subscription_price'];
    $amount = htmlspecialchars(stripslashes($_POST['amount']));
  
    $user_info=$Functions->UserInfo($user_id);
    $token = htmlspecialchars(stripslashes($_POST['token']));
    $referral_code_used=0;
    $planid = null; 
    
    
    if($amount == $monthly) {

        // create plan
        $plan = \Stripe\Plan::create([
            'product' => ['name' => 'Buildela Subscription '],
            'currency' => 'GBP',
            'interval' => 'month',
            'amount' =>  ($monthly * 100), // amount in cents
        ]);

        $plan = \Stripe\Plan::create([
            'product' => 'prod_OKrsHOzTZL63ml',
            'currency' => 'GBP',
            'interval' => 'month',
            'amount' =>  ($monthly * 100), // amount in cents
        ]);
        
        $planid = $plan->id;

    } else if($amount == $yearly) {

        // create plan
        $plan = \Stripe\Plan::create([
            'product' => ['name' => 'Buildela Subscription '],
            'currency' => 'GBP',
            'interval' => 'year',
            'amount' =>  ($yearly * 100), // amount in cents
        ]);

        $plan = \Stripe\Plan::create([
            'product' => 'prod_OKrxYesuq47hZt',
            'currency' => 'GBP',
            'interval' => 'year',
            'amount' =>  ($yearly * 100), // amount in cents
        ]);
        
        $planid = $plan->id;
    }
   
    //create customer
    $customer = \Stripe\Customer::create([
        'source' => $token,
        'name' => $user_info[0]['fname'],
        'email' => $user_info[0]['email'],
    ]);
    
    
    $object = new stdClass();
    $trial = strtotime('+14 days'); 
    

    if(($user_info[0]['referral_code_used']== 0)&&($user_info[0]['from_referral_code'] !="" )){
        
        $referral_code_used=1;
        
        if($amount == $yearly){
            
            $coupon = \Stripe\Coupon::create([
                'name' => $user_info[0]['from_referral_code'],
                'percent_off' => 8.25, // A percentage discount (you can use 'amount_off' for a fixed amount).
                'duration' => 'once', // 'once' for a one-time use coupon.
                'max_redemptions' => 1, // Limit the coupon to one use.
                'redeem_by' => strtotime('+30 days'), // Optional: Set an expiration date for the coupon.
            ]);
            
            
        } elseif($amount == $monthly){
            
            $coupon = \Stripe\Coupon::create([
                'name' => $user_info[0]['from_referral_code'],
                'percent_off' => 25, // A percentage discount (you can use 'amount_off' for a fixed amount).
                'duration' => 'once', // 'once' for a one-time use coupon.
                'max_redemptions' => 1, // Limit the coupon to one use.
                'redeem_by' => strtotime('+30 days'), // Optional: Set an expiration date for the coupon.
            ]);
            
        }
        
        
        $subscription = \Stripe\Subscription::create([
            'customer' => $customer->id,
            'items' => [['plan' => $plan->id]],
            'coupon' => $coupon->id,
            // 'trial_end' => $trial
        ]);
        
        

    }else{
        
        $subscription = \Stripe\Subscription::create([
            'customer' => $customer->id,
            'items' => [['plan' => $plan->id]],
            'trial_end' => $trialEndTimestamp,
        ]);

    }    

    $latestInvoice = \Stripe\Invoice::retrieve($subscription->latest_invoice);
    $chargeId = $latestInvoice->charge;

    $subsData = $subscription->jsonSerialize();

    if ($subsData['status'] == 'active') {

        $cus_stripe_id =$subsData['id'];

        $sql = "update users set cus_id_stripe='$cus_stripe_id',referral_code_used='$referral_code_used' where id='$user_id'";
        $db->sql($sql);

        $object = new stdClass();
        $object->success = true;
        $object->userid = $user_id;
        $object->result = $subsData;
        $object->cus_stripe_id=$cus_stripe_id;
        $object->chargeId = $chargeId;
        $object->msg = "success";
        echo json_encode($object);
    }else{
        $object = new stdClass();
        $object->success = false;
        $object->userid = $user_id;
        $object->result = $subsData;
        $object->msg = "false";
        echo json_encode($object);
    } 
   

} //add transaction
else if ($func == 38) {

    $user_id = $_SESSION['user_id'];
    $monthly = $Functions->getplans('monthly', false);
    $yearly  = $Functions->getplans('yearly', false);

    $amount = htmlspecialchars(stripslashes($_POST['amount']));

    if($amount == $monthly){

        $day=30;
        $s_type ="Monthly";
        $start_date = date("Y-m-d");
        $end_date = date('Y-m-d', strtotime("+" . $day . "days"));

    } elseif($amount == $yearly) {
        $year=365;
        $s_type ="Yearly";

        $start_date = date("Y-m-d");
        $end_date = date('Y-m-d', strtotime("+" . $year . "days"));
    }   

    $status_stripe = 'COMPLETED';
    $tranx_type = "stripe";
    $object = $_POST['object'];
    $json_object = json_encode($object);
    $final_amount = $amount;
    $cus_stripe_id=$_POST['cus_stripe_id'];
    $chargeId=$_POST['chargeId'];

    $user_info=$Functions->UserInfo($user_id);
    $from_referral_code=$user_info[0]['from_referral_code'];

    if(isset($from_referral_code) && ($from_referral_code!="") && ($user_info[0]['referral_code_used']==0) ){
        $user=$Functions->getuserbyRefferal($from_referral_code);
        $balance=$user[0]['balance'];
        $balance+=3;
        $sql ="update users set balance='$balance' where to_referral_code ='$from_referral_code' ";
        $db->sql($sql);
    }

    $referral_code_used=2;
    if(isset($from_referral_code) && ($from_referral_code!="") && ($user_info[0]['referral_code_used']==0) ){
        $referral_code_used=1;
    }

    $sql ="update users set referral_code_used='$referral_code_used', subscription_type='$s_type',subscription_cancel=0 , subscription_status=1 , subscription_date='$start_date' , subscription_end='$end_date' where id='$user_id' ";
    $db->sql($sql);

    $create_transaction = "INSERT INTO `transactions`(`tranx_id`,`charge_id`,`payment_amount`, `payment_status`, `user_id`,`payment_type`,`object`,`s_type`) VALUES ('$cus_stripe_id','$chargeId','$final_amount','$status_stripe','$user_id','$tranx_type','$json_object','$s_type')";

    if ($db->sql($create_transaction)) {
        echo "true";
    } else {
        echo "false";
    }
}else if ($func == 381) {

    echo $Functions->stripeSubscriptionModifier('on');
    exit;
}
//upload gallery
else if ($func == 39) {
    $id = htmlspecialchars(stripslashes($_POST['userId']));
    $id = $db->escapeString($id);

    if(!empty($_FILES['images'])){
        $image=$_FILES['images'];
        $filename=$image['name'];
        $file_tmp=$image['tmp_name'];
        $file_type=$image['type'];
        $type='';


        if ($file_type == 'video/mp4' || $file_type == 'MOV' || $file_type == 'video/quicktime' || $file_type == 'video/mov') {
            $type = 'video';
        } elseif ($file_type == 'image/jpeg' || $file_type == 'image/jpg' || $file_type == 'image/png' || $file_type == 'image/webp' || $file_type == 'image/gif' || $file_type == 'image/tiff') {
            $type = 'image';
        } else {
            echo "Invalid file type. Only MP4, MOV, JPG, JPEG, PNG, WebP, GIF, and TIFF files are allowed.";
            exit;
        }       

        
        $target="../uploads/";
        $timestamp=time();
        $file=$timestamp.'-'.$filename;
        $upload_to=$target.$file;

        // Check if user reached max 6 video limit
        if($type === 'video'){
            $sql = "SELECT COUNT(*) AS count_videos FROM gallery WHERE user_id = '$id' AND file_type = 'video'";
            $result = $db->sql($sql);
            $numVideos = $db->getResult();
            $videos = $numVideos[0]['count_videos'];
    
            if ($videos >= 6) {
                echo "You have reached the maximum limit of 6 videos.";
                exit;
            }

        }
        // Check if user reached max 6 image limit
        if( $type === 'image'){
            $sql = "SELECT COUNT(*) AS count_image FROM gallery WHERE user_id = '$id' AND file_type = 'image'";
            $result = $db->sql($sql);
            $numImages = $db->getResult();
            $images = $numImages[0]['count_image'];
    
            if ($images >= 6) {
                echo "You have reached the maximum limit of 6 images.";
                exit;
            }
            
        }

        move_uploaded_file($file_tmp,$upload_to);
        if($type === 'image'){
            
            compressImage($upload_to, $upload_to, 25);
        }

    }else{

        $upload_to=null;
    }



    $sql = "insert into gallery (user_id,img_path,file_type) values ('$id','$upload_to','$type')";

    if ($db->sql($sql)) {
        echo "true";
    } else {
        echo "false";
    }

}

else if ($func == 40) {
    $email = htmlspecialchars(stripslashes($_POST['email']));
    $email = $db->escapeString($email);

    if ($Functions->CheckEmailExists($email)) {
        echo "true";
    }
    else {
        echo "false";
    }

}//40
//Add new Options
else if ($func == 41) {
    $name = htmlspecialchars(stripslashes($_POST['name']));
    $name = $db->escapeString($name);

    $type = htmlspecialchars(stripslashes($_POST['type']));
    $type = $db->escapeString($type);

    if($name==""||$type==""){
        echo "fill-fields";
        return;
    }


    $sql="insert into add_options (sub_category,option) values('$type','$name')";
    if ($db->sql($sql)) {

        echo "true";
    }
    else {
        echo "false";
    }

}
//Delete Option
else if ($func == 42) {
    $id = htmlspecialchars(stripslashes($_POST['id']));
    $id = $db->escapeString($id);
    $sql = "DELETE from add_options where id='$id'";
    if ($db->sql($sql)) {
        echo "true";
    }
    else {
        echo "false";
    }

}
//Delete Image
else if ($func == 43) {
    $id = htmlspecialchars(stripslashes($_POST['id']));
    $id = $db->escapeString($id);

    // $sql = "DELETE from gallery where id='$id'";
    // if ($db->sql($sql)) {
    //     echo "true";
    // }
    // else {
    //     echo "false";
    // }
    
    $id = htmlspecialchars(stripslashes($_POST['id']));
    $id = $db->escapeString($id);

    // Get the file path from the 'jobs_gallery' table
    $sql = "SELECT img_path FROM gallery WHERE id='$id'";
    $db->sql($sql);
    $result = $db->getResult();

    if ($db->numRows() > 0) {
        // Fetch the 'img_path' from the result
        $file_path = $result[0]['img_path'];
        
        // Check if the file exists before attempting to delete it
        if (file_exists($file_path)) {
            // Delete the file from the server
            unlink($file_path);
        }

        // Delete the record from the 'jobs_gallery' table
        $sql = "DELETE FROM gallery WHERE id='$id'";
        if ($db->sql($sql)) {
            echo "true";
        } else {
            echo "false";
        }
    } else {
        echo "false"; // Record not found in the 'jobs_gallery' table
    }










}//Delete job Image
else if ($func == 430) {
    // $id = htmlspecialchars(stripslashes($_POST['id']));
    // $id = $db->escapeString($id);

    // $sql = "DELETE from jobs_gallery where id='$id'";
    // if ($db->sql($sql)) {
    //     echo "true";
    // }
    // else {
    //     echo "false";
    // }


    $id = htmlspecialchars(stripslashes($_POST['id']));
    $id = $db->escapeString($id);

    // Get the file path from the 'jobs_gallery' table
    $sql = "SELECT img_path FROM jobs_gallery WHERE id='$id'";
    $db->sql($sql);
    $result = $db->getResult();

    if ($db->numRows() > 0) {
        // Fetch the 'img_path' from the result
        $file_path = $result[0]['img_path'];
        
        // Check if the file exists before attempting to delete it
        if (file_exists($file_path)) {
            // Delete the file from the server
            unlink($file_path);
        }

        // Delete the record from the 'jobs_gallery' table
        $sql = "DELETE FROM jobs_gallery WHERE id='$id'";
        if ($db->sql($sql)) {
            echo "true";
        } else {
            echo "false";
        }
    } else {
        echo "false"; // Record not found in the 'jobs_gallery' table
    }






}
else if ($func == 44) {
    $email = htmlspecialchars(stripslashes($_POST['email']));
    $email = $db->escapeString($email);

    if ($Functions->CheckEmailExists($email)) {
        echo "true";
    }
    else {
        echo "false";
    }
   

}
else if($func == 45){
    $main_type = htmlspecialchars(stripslashes($_POST['main_type']));
    $main_type = $db->escapeString($main_type);

    $options = htmlspecialchars(stripslashes($_POST['options']));
    $options = $db->escapeString($options);

    $sub_type = htmlspecialchars(stripslashes($_POST['sub_type']));
    $sub_type = $db->escapeString($sub_type);

    $title = htmlspecialchars(stripslashes($_POST['title']));
    $title = $db->escapeString($title);

    $job_id = htmlspecialchars(stripslashes($_POST['job_id']));
    $job_id = $db->escapeString($job_id);

    $post_code = htmlspecialchars(stripslashes($_POST['post_code']));
    $post_code = $db->escapeString($post_code);

    $note= htmlspecialchars(stripslashes($_POST['note']));
    $note = $db->escapeString($note);

    if($sub_type=="undefined"){
        $sql="update post_job set title='$title', main_type='$main_type',post_code='$post_code', options='$options', job_discription='$note' where id='$job_id'";

    }else if($options=="undefined"){
        $sql="update post_job set title='$title', main_type='$main_type',post_code='$post_code',
        sub_type='$sub_type', job_discription='$note' where id='$job_id'";

    }else if($options=="undefined" && $sub_type=="undefined"){
        $sql="update post_job set title='$title', main_type='$main_type',post_code='$post_code',job_discription='$note' where id='$job_id'";

    }else{
        $sql="update post_job set title='$title', main_type='$main_type',post_code='$post_code',
        sub_type='$sub_type', options='$options', job_discription='$note' where id='$job_id'";

    }



    if ($db->sql($sql)) {
        echo "true";
    }else{
        echo "false";
    }


}//update

//Delete Image
else if ($func == 46) {
    $id = htmlspecialchars(stripslashes($_POST['id']));
    $id = $db->escapeString($id);

    $sql = "DELETE from jobs_gallery where id='$id'";
    if ($db->sql($sql)) {
        echo "true";
    }
    else {
        echo "false";
    }

}

//upload gallery
else if ($func == 47) {
    // $job_id = htmlspecialchars(stripslashes($_POST['job_id']));
    // $job_id = $db->escapeString($job_id);

    // if(!empty($_FILES)){
    //     foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name) {
    //         $filename=$_FILES["files"]["name"][$key];
    //         $file_tmp=$_FILES["files"]["tmp_name"][$key];
    //         $file_type=$_FILES["files"]["type"][$key];
    //         $type='';
    //         if($file_type=='video/mp4' || $file_type == 'MOV' || $file_type == 'video/quicktime'){
    //             $type='video';
    //         }else{
    //             $type='image';
    //         }
    //         $upload_to = "";
    //         $target="../uploads/";
    //         $timestamp=time();
    //         $file=$timestamp.'-'.$filename;
    //         $upload_to=$target.$file;

    //         if(move_uploaded_file($file_tmp,$upload_to)){
    //             $sql = "insert into jobs_gallery (job_id,file_type,img_path) values ('$job_id','$type','$upload_to')";
    //             $db->sql($sql);
    //         }
    //     }//foreach
    //     echo "true";
    // }else{
    //     echo "false";
    // }



    $job_id = htmlspecialchars(stripslashes($_POST['job_id']));
    $job_id = $db->escapeString($job_id);

    if (!empty($_FILES)) {
        foreach ($_FILES["files"]["tmp_name"] as $key => $tmp_name) {
            $filename = $_FILES["files"]["name"][$key];
            $file_tmp = $_FILES["files"]["tmp_name"][$key];
            $file_type = $_FILES["files"]["type"][$key];
            $type = '';

            if ($file_type == 'video/mp4' || $file_type == 'MOV' || $file_type == 'video/quicktime') {
                $type = 'video';
               $upload_to = "";
               $target="../uploads/";
               $timestamp=time();
               $file=$timestamp.'-'.$filename;
               $upload_to=$target.$file;
                move_uploaded_file($file_tmp, $upload_to);

            } else {
                $type = 'image';
                $target = "../uploads/";
                $timestamp = time();
                $file = $timestamp . '-' . $filename;
                $upload_to = $target . $file;

                move_uploaded_file($file_tmp, $upload_to);

                // Compress the image with 50% quality (you can adjust the quality as needed)
                compressImage($upload_to, $upload_to, 25);
                // compressImage($file_tmp, $upload_to, 50); // Compress the image with 50% quality (you can adjust the quality as needed)
            }


            $sql = "INSERT INTO jobs_gallery (job_id, file_type, img_path) VALUES ('$job_id', '$type', '$upload_to')";
            $db->sql($sql);
        }

        echo "true";
    } else {
        echo "false";
    }







}//47
else if ($func == 51) {
    $id = htmlspecialchars(stripslashes($_POST['id']));
    $surveyAnswer_val = (int)$_POST['surveyAnswer'];
    switch ($surveyAnswer_val) {
        case 0:
            $surveyAnswer = 'Unhappy with the service that we are offering.';
            break;
        case 1:
            $surveyAnswer = 'Frustrated with our customer service team.';
            break;
        case 2:
            $surveyAnswer = 'Too expensive.';
            break;
        case 3:
            $surveyAnswer = 'Found another service offering a more suitable product.';
            break;
        case 4:
            $surveyAnswer = 'Not winning enough leads.';
            break;
    }
    $id = $db->escapeString($id);
    $deleted_users_table = "canceled_users_new";
    $days_left_value = 0;
    $result_data = $db->sql("SHOW TABLES LIKE '$newTable'");
    if ($result_data && $result_data->num_rows > 0) {
        // The new table already exists
    } else {
        $db->sql("CREATE TABLE $deleted_users_table AS
                  SELECT *,  NOW() AS day_left, '' AS reason_left FROM users WHERE 1=0");
    }

    // insert the data 
    $db->sql("INSERT INTO $deleted_users_table 
              SELECT *,NOW() AS day_left, '$surveyAnswer' AS reason_left FROM users WHERE id='$id'");
    
    $Functions->deleteStripeSubscription();
    
    $sql = "DELETE from users where id='$id'";
    if ($db->sql($sql)) {

        $sql = "DELETE from rateuser where user_id='$id'";
        $db->sql($sql);

        $sql = "DELETE from verify_skill where user_id='$id'";
        $db->sql($sql);

        $sql = "DELETE from post_job where user_id='$id'";
        $db->sql($sql);

        $sql = "DELETE from gallery where user_id='$id'";
        $db->sql($sql);

        $sql = "DELETE from apply_job where user_id='$id'";
        $db->sql($sql);
        
        echo "true";
        
    }
    else {
        echo "false";
    }

}//51

else if($func == 52){
    $address= $_POST['post_code'];
    if ($Functions->PostVerify($address)) {
        echo "200";
    } else {
        echo "404";
    }
}//52
else if($func == 52.1){
    $address= $_POST['post_code'];
        
    if ($Functions->PostVerify($address)) {
        echo "OK";
    } else {
        echo "error";
    }

}//52.1
// update qualification
else if ($func == 53) {
    $userid = $_POST['userid'];
    $qualifications = $_POST['qualification'];
    $qualifications = urldecode($qualifications);
    $qualifications = explode('&', $qualifications);
    $qualificationValues = array();
    foreach ($qualifications as $qualification) {
        $qualification = explode('=', $qualification);
        $qualificationValue = htmlspecialchars(stripslashes($qualification[1]));
        $qualificationValue = $db->escapeString($qualificationValue);
        array_push($qualificationValues, $qualificationValue);
    }
    $qualificationValues = implode(',', $qualificationValues);
    $sql = "UPDATE users SET qualification = '$qualificationValues' WHERE id = '$userid'";
    if ($db->sql($sql)) {
        echo "true";
    } else {
        echo "false";
    }
}//53

else if ($func == 200) {

   $userid = $_POST['userid'];
    $sql = "SELECT qualification FROM users WHERE id = '$userid'";
    if ($db->sql($sql)) {
  
        echo json_encode($db->getResult());
    } else {
        echo "false";
    }
}
//update dbs
else if ($func == 54) {

    if(!empty($_FILES['dbs'])){
        $image=$_FILES['dbs'];
        $filename=$image['name'];
        $file_tmp=$image['tmp_name'];
        $target="../uploads/";
        $timestamp=time();
        $file=$timestamp.'-'.$filename;
        $upload_to=$target.$file;
        move_uploaded_file($file_tmp,$upload_to);
    }else{
        $upload_to=null;
    }

    $userid=$_POST['userid'];

    $sql = " update users set dbs_path='$upload_to' where id='$userid' ";
    if ($db->sql($sql)) {
        echo "true";
    }
    else {
        echo "false";
    }

}//54

// update address
else if ($func == 55) {
    $work_address = htmlspecialchars(stripslashes($_POST['work_address']));
    $work_address = $db->escapeString($work_address);

    $work_address1 = htmlspecialchars(stripslashes($_POST['work_address1']));
    $work_address1 = $db->escapeString($work_address1);

    $work_address=$work_address."__".$work_address1;

    $town = htmlspecialchars(stripslashes($_POST['town']));
    $town = $db->escapeString($town);

    $post_code=$_POST['post_code'];
    $userid=$_POST['userid'];
    $distance=$_POST['distance'];

    $sql = " update users set `work_address`='$work_address', `distance`='$distance' ,`post_code`='$post_code',`town`='$town'  where `id`='$userid' ";
    if ($db->sql($sql)) {
        echo "true";
    }
    else {
        echo "false";
    }

}//55

// update job description
else if ($func == 56) {
    $note = htmlspecialchars(stripslashes($_POST['note']));
    $note = $db->escapeString($note);
    $jobid=$_POST['jobid'];
    $sql = " update post_job set job_discription='$note' where id='$jobid' ";
    if ($db->sql($sql)) {

        echo "true";
    }
    else {
        echo "false";
    }

}//56

// update account details
else if ($func == 57) {

    $fname = htmlspecialchars(stripslashes($_POST['fname']));
    $fname = $db->escapeString($fname);

    $lname = htmlspecialchars(stripslashes($_POST['lname']));
    $lname = $db->escapeString($lname);

    $phone = htmlspecialchars(stripslashes($_POST['phone']));
    $phone = $db->escapeString($phone);

//    $email = htmlspecialchars(stripslashes($_POST['email']));
//    $email = $db->escapeString($email);

    $work_address = htmlspecialchars(stripslashes($_POST['work_address']));
    $work_address = $db->escapeString($work_address);

    $work_address1 = htmlspecialchars(stripslashes($_POST['work_address1']));
    $work_address1 = $db->escapeString($work_address1);

    $work_address = $work_address . "__" . $work_address1;

    $town = htmlspecialchars(stripslashes($_POST['town']));
    $town = $db->escapeString($town);

    $post_code = $_POST['post_code'];
    $userid = $_POST['userid'];

//    if ($Functions->CheckEmailExists($email)) {
//        echo 'email-exist';
//        return;
//    }


    $sql = "update users set `fname` = '$fname' , `lname` = '$lname',`phone`= '$phone',`work_address`='$work_address',`post_code`='$post_code',`town`='$town'  where `id`='$userid' ";
    if ($db->sql($sql)) {
        echo "true";
    } else {
        echo "false";
    }
}//57
else if ($func == 58) {
    $message_id = htmlspecialchars(stripslashes($_POST['message_id']));
    $message_id = $db->escapeString($message_id);
    $sql = " delete from comment where id='$message_id' ";
    if ($db->sql($sql)) {
        echo "true";
    }
    else {
        echo "false";
    }

}//58
//update user profile
else if($func==59){
    $id=htmlspecialchars(stripslashes($_POST['userid']));
    $id=$db->escapeString($id);

    $fname=htmlspecialchars(stripslashes($_POST['fname']));
    $fname=$db->escapeString($fname);

    $email=htmlspecialchars(stripslashes($_POST['email']));
    $email=$db->escapeString($email);

    $sql="update users set fname='$fname' , email='$email'  where id='$id'";
    if($db->sql($sql)){
        echo "true";
    }else{
        echo "false";
    }
}
//update user password
else if($func==60){
    $oldpass=htmlspecialchars(stripslashes($_POST['oldpass']));
    $oldpass=$db->escapeString($oldpass);

    $newpass=htmlspecialchars(stripslashes($_POST['newpass']));
    $newpass=$db->escapeString($newpass);

    $confirmpass=htmlspecialchars(stripslashes($_POST['confirmpass']));
    $confirmpass=$db->escapeString($confirmpass);

    $userId=htmlspecialchars(stripslashes($_POST['userId']));
    $userId=$db->escapeString($userId);
    //========================================

    //========================================
    if(!empty($oldpass) && !empty($newpass)){
        if($Functions->UpdatePassword($userId,$confirmpass,$oldpass)){

            echo "true";
        }else{
            echo "false";
        }
    }
}//update password

// update insurance
else if ($func == 61) {
    $pub_insurance = htmlspecialchars(stripslashes($_POST['pub_insurance']));
    $pub_insurance = $db->escapeString($pub_insurance);

    $pub_insurance_date = htmlspecialchars(stripslashes($_POST['pub_insurance_date']));
    $pub_insurance_date = $db->escapeString($pub_insurance_date);

    $pro_insurance = htmlspecialchars(stripslashes($_POST['pro_insurance']));
    $pro_insurance = $db->escapeString($pro_insurance);

    $pro_insurance_date = htmlspecialchars(stripslashes($_POST['pro_insurance_date']));
    $pro_insurance_date = $db->escapeString($pro_insurance_date);

    $userid=$_POST['userid'];

    $sql = " update users set `pub_insurance`='$pub_insurance',`pub_insurance_date`='$pub_insurance_date',
                  `pro_insurance`='$pro_insurance',`pro_insurance_date`='$pro_insurance_date' where id='$userid' ";
    if ($db->sql($sql)) {
        echo "true";
    }
    else {
        echo "false";
    }


}//61

// update qualification
else if ($func == 53) {
    $qualification = htmlspecialchars(stripslashes($_POST['qualification']));
    $qualification = $db->escapeString($qualification);
    $userid=$_POST['userid'];
    $sql = " update users set qualification='$qualification' where id='$userid' ";
    if ($db->sql($sql)) {
        echo "true";
    }
    else {
        echo "false";
    }

}//53
// update intoduction
else if ($func == 62) {
    $note = htmlspecialchars(stripslashes($_POST['note']));
    $note = $db->escapeString($note);
    $userid=$_POST['userid'];
    $sql = " update users set note='$note' where id='$userid' ";
    if ($db->sql($sql)) {
        echo "true";
    }
    else {
        echo "false";

    }

}//62


else if ($func == 63) {
    $id = htmlspecialchars(stripslashes($_POST['id']));
    $id = $db->escapeString($id);
    $sql = "update post_job set status=0 where id='$id'";
    if ($db->sql($sql)) {
        echo "true";
    } else {
        echo "false";
    }
} //blockJob


else if ($func == 64) {
    $id = htmlspecialchars(stripslashes($_POST['id']));
    $id = $db->escapeString($id);
    $sql = "update post_job set status=1 where id='$id'";
    if ($db->sql($sql)) {
        echo "true";
    }
    else {
        echo "false";
    }

}//ActiveJob
//check referral code exist
else if ($func == 65) {
    $from_referral_code = htmlspecialchars(stripslashes($_POST['from_referral_code']));
    $from_referral_code = $db->escapeString($from_referral_code);

    $refdetails = $Functions->CheckReferralCodeExists($from_referral_code); 
    
    if ($refdetails) {
        echo $refdetails['fname'];
    }
    else {
        echo "false";
    }

}
else if ($func == 66) {

    $id = htmlspecialchars(stripslashes($_POST['id']));
    $id = $db->escapeString($id);
    $sql = "update users set balance=0 where id='$id'";
    if ($db->sql($sql)) {

        echo "true";
    }
    else {
        echo "false";
    }

}//ActiveJob

else if ($func == 67) {
    $userid = htmlspecialchars(stripslashes($_POST['userid']));
    $userid = $db->escapeString($userid);

    $jobid = htmlspecialchars(stripslashes($_POST['jobid']));
    $jobid = $db->escapeString($jobid);

    $my_id=$_SESSION['user_id'];
    $last_activity=date('Y-m-d H:i:s');
    $res=$Functions->checkChatStarted($userid,$jobid);

    if(count($res)==0){

        $sql = "insert into user_chat (sender_id,receiver_id,job_id,last_activity) values ('$userid','$my_id','$jobid','$last_activity')";
        if ($db->sql($sql)) {
            $job_info=$Functions->getSingleJob($jobid);
            $user=$Functions->UserInfo($userid);
            $user=$Functions->UserInfo($_POST['userid']);
            $homeowner=$Functions->UserInfo($job_info[0]['user_id']);
            $Functions->UserChatemail($job_info[0]['title'],$homeowner[0]['fname'],$user[0]['fname'],$user[0]['email'],$user[0]['phone']);
//            $Functions->UserChateMessageMobile($job_info[0]['title'],$homeowner[0]['fname'],$user[0]['fname'],$user[0]['phone']);

            echo "true";

        }else{

            echo "false";
        }

    }else{
        echo "true";
    }


}//67

// Sending chat messages
else if ($func == 68) {
    $touserid = htmlspecialchars(stripslashes($_POST['touserid']));
    $touserid = $db->escapeString($touserid);

    $jobid = htmlspecialchars(stripslashes($_POST['jobid']));
    $jobid = $db->escapeString($jobid);

    $message = htmlspecialchars(stripslashes($_POST['message']));
    $message = $db->escapeString($message);
    $my_id = $_SESSION['user_id'];
    $create_date = date('Y-m-d H:i:s');

    if($_SESSION['user_role'] == 'home_owner'){
        $tradepersonid = $touserid;
    }elseif($_SESSION['user_role'] == 'jobs_person') {
        $tradepersonid = $_SESSION['user_id'];
    }

    // Handle image uploads
    $imageUploadPath = '../uploads/chats/'; // Replace with the actual path on your server

    if (!empty($_FILES['images'])) {
        $images = $_FILES['images'];

        $uploadedImagePaths = array();

        // Loop through each uploaded image
        for ($i = 0; $i < count($images['name']); $i++) {
            $imageName = $images['name'][$i];
            $imageTmpPath = $images['tmp_name'][$i];
            $imageError = $images['error'][$i];

            // Check if the file is an image
            $imageFileType = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
            $allowedTypes = array('jpeg', 'jpg', 'png', 'gif', 'webp');
            if (!in_array($imageFileType, $allowedTypes)) {
                echo 'false';
                return;
            }

            // Generate a unique filename for the image
            $uniqueFilename = uniqid('image_') . '.' . $imageFileType;
            $destinationPath = $imageUploadPath . $uniqueFilename;

            // Move the uploaded image to the server
            if (move_uploaded_file($imageTmpPath, $destinationPath)) {
                $uploadedImagePaths[] = $destinationPath;
                    compressImage($destinationPath, $destinationPath, 25);
            }
        }
    }

    $sql = "insert into chat_messages (job_id, sender_id, receiver_id,tradeperson_id, message, create_date, image_paths) values ('$jobid', '$my_id', '$touserid', '$tradepersonid', '$message', '$create_date', '".implode(",", $uploadedImagePaths)."')";
    if ($db->sql($sql)) {
        $sql = "update user_chat set last_activity='$create_date' where (sender_id='$my_id' and receiver_id= '$touserid') or (sender_id='$touserid' and receiver_id= '$my_id') ";
        $db->sql($sql);

        $result = $Functions->checkDeleteStatus($touserid, $jobid, $my_id);
        $sql = "";
        if (($result[0]['delete1'] == $touserid) or ($result[0]['delete2'] == $touserid)) {
            $sql = "update user_chat set delete1=0, delete2=0 where (sender_id='$touserid' or receiver_id = '$touserid') and (job_id='$jobid') ";
            $db->sql($sql);
        }

        echo "true";
    } else {
        echo "false";
    }
}//68

// New and old chat message loading 
else if($func == 69){


    $touserid = $_POST['touser_id'];
    $lastmsg_id = $_POST['lastmsg_id'];
    $jobid = $_POST['jobid'];
    $Functions->getAllMyChates($touserid,$jobid);
    $newmsgs = $Functions->getAllMyChates_new($touserid, $lastmsg_id,$jobid);
    
    // $userInfo = $func->UserInfo($_SESSION['user_id']);
    $chatUsers = $Functions->getMyChatUsers();

    $reply = [];
    $reply['currentUserStatus'] = $Functions->checkOnlineStatus($touserid);

    
    ob_start();
    // list user starts
    if($chatUsers){

        foreach ($chatUsers as &$user) {
            if ($_SESSION['user_id'] == $user['receiver_id']) {
                $user['create_date'] = $Functions->getChatpreview($user['job_id'])[0]['create_date'];
            } else {
                $user['create_date'] = $Functions->getChatpreview($user['job_id'])[0]['create_date'];
            }
        }

        // Sort the $chatUsers array by the 'create_date' field in descending order (most recent first)
        usort($chatUsers, function ($a, $b) {
            return strtotime($b['create_date']) - strtotime($a['create_date']);
        });  


        foreach ($chatUsers as $users) {

            if ($_SESSION['user_id'] == $users['receiver_id']) {
                $userinfo = $Functions->UserInfo($users['sender_id']);
                $last_seen = $Functions->last_seen($users['sender_id']);
                $new_messages = $Functions->mySendmebythisuser($_SESSION['user_id'], $users['sender_id'], $users['job_id']);
                $chat_preview = $Functions->getChatpreview($users['job_id']);
                $isOnline = $Functions->checkOnlineStatus($users['sender_id']);
            } else {
                $userinfo = $Functions->UserInfo($users['receiver_id']);
                $last_seen = $Functions->last_seen($users['receiver_id']);
                $new_messages = $Functions->mySendmebythisuser($_SESSION['user_id'], $users['receiver_id'], $users['job_id']);
                $chat_preview = $Functions->getChatpreview($users['job_id']);
                $isOnline = $Functions->checkOnlineStatus($users['receiver_id']);
            }
        

            ?>
            <a href="chat?touserid=<?=$userinfo[0]['id']?>&jobid=<?=$users['job_id']?>" class="list-group-item list-group-item-action border-0" class="chat_person" data-userid="<?=$userinfo[0]['id']?>">
                <!--<div class="badge bg-success float-right">New Msg</div>-->
                <div class="d-flex align-items-start">
                    <?php
                    if(empty($userinfo[0]['img_path']))
                    {
                        ?><img class="rounded-circle mr-1 chatmain" src="images/avatar1.png" width="40" height="40" alt="no-image"><?php

                    }else{
                        $image=explode('/',$userinfo[0]['img_path'] );

                        $img= $image[1].'/'.$image[2];
                        ?> <img src="<?=$img?>" class="rounded-circle mr-1 chatperson" alt="" width="40" height="40"><?php
                    }

                    if($isOnline){
                        ?><span class="fas fa-circle chat-online"></span><?php
                    }else{ 
                        
                        ?><span class="fas fa-circle chat-offline"></span><?php
                    }
                    
                    ?>
                        
                    <div class="flex-grow-1 ml-2 font-weight-bold">
                        <?php if($_SESSION['user_role']=='home_owner'){ ?>
                        <div class="chat-name"><?=$userinfo[0]['fname']?> - <?=$userinfo[0]['trading_name']?></div>
                        <?php } else {?>
                            <div class="chat-name"><?=$userinfo[0]['fname']?></div>
                            <?php }; ?>
                            <div class="position-relative" style="font-size: 10px">

                        <?php echo '<div class="preview">'. $chat_preview[0]['message']. "</div>";
                            $create_date = $chat_preview[0]['create_date'];
                            $date = new DateTime($create_date);
                            $formatted_date = $date->format('d/m/y');
                            echo '<div class="date">'. $Functions->timeAgo($create_date) .'</div>';
                            // echo '<div class="date">' .$formatted_date.'</div>'; 
                            ?>
                            

                            <?php
                            if(count($new_messages)>0 ){
                                ?>
                                <span style="top: -20px;right: -28px;font-size: 15px;" class="bg-danger position-absolute text-white rounded-circle px-1 chat"><?= count($new_messages)?></span>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </a><?php
        }
    }
    // list user ends

    $reply['chatUsers'] = ob_get_clean();

    if(count($newmsgs)>0){      

        // msgs starts here
        $newmsgstring = "";
        foreach ($newmsgs as $message){
            

            $sender=$Functions->UserInfo($message['sender_id']);
            $earlier = new DateTime($message['create_date']);
            $later = new DateTime(date("Y-m-d H:i:s"));
            $diff = $later->diff($earlier)->format("%a");

            $chatimages = $Functions->getChatImages($message['image_paths']);
            $chatimage = '';
            if($chatimages) $chatimage = "<div class='chatimages'>".$chatimages."</div>";

            if($message['sender_id']==$_SESSION['user_id']){
                if($chatimages) $chatimage = "<div class='chatimages image_of_your'>".$chatimages."</div>"; 

                $newmsgstring .='<div class="chat-message-right pb-4">
                                    <div class="imessage">
                                        <div class="img-profile-left">';
                if (empty($sender[0]['img_path'])) {
                            $newmsgstring .= '<img class="rounded-circle mr-1" src="images/avatar1.png" width="40" height="40" alt="no-image">';
                } else {
                    $image = explode('/', $sender[0]['img_path']);
                    $img = $image[1] . '/' . $image[2];
                    $newmsgstring .= '<img src="' . $img . '" class="rounded-circle mr-1" alt="" width="40" height="40">';
                }
                    $newmsgstring .= '</div>
                                    <div class="msgimgholder">
                                        <p class="from-me">
                                            <span class="chat-d-flex">
                                                <b>Me</b>
                                                <span class="text-muted small text-nowrap" style="font-size: 10px">';
                                                $newmsgstring .= $diff==0? $Functions->timeAgoChat($message['create_date']) : $Functions->timeAgoChat($message['create_date']);
                                                // $newmsgstring .= $diff==0?date('H:i a',strtotime($message['create_date'])) :date('d M Y, H:i',strtotime($message['create_date']));
                                                $newmsgstring .= '
                                                </span>
                                            </span><br>';
                                            $newmsgstring .= $message['message'];
                                            $newmsgstring .= '
                                        </p>
                                    '.$chatimage.'
                                    </div>
                                </div>
                            </div>';
                
                    $reply['lastmsgid'] = $message['id'];
                    $reply['lastmsg'] = $message['message'];

                if ($chatimage)
                    $reply['chatimage'] = true;
                else $reply['chatimage'] = false;



            }else{
              
                if($chatimages) $chatimage = "<div class='chatimages image_of_his'>".$chatimages."</div>";
                    
                $newmsgstring .= '<div class="chat-message-left pb-4">
                                        <div class="imessage">
                                            <div class="img-profile-left">';
                if (empty($sender[0]['img_path'])) {
                    $newmsgstring .= '<img class="rounded-circle mr-1" src="images/avatar1.png" width="40" height="40" alt="no-image">';
                } else {
                    $image = explode('/', $sender[0]['img_path']);
                    $img = $image[1] . '/' . $image[2];
                    $newmsgstring .= '<img src="' . $img . '" class="rounded-circle mr-1" alt="" width="40" height="40">';
                }
                $newmsgstring .= '
                        </div>
                        <div class="msgimgholder">
                            <p class="from-them">
                                <span class="chat-d-flex">
                                    <b>' . $sender[0]['fname'] . '</b>
                                    <span class="text-muted small text-nowrap" style="font-size: 10px">';
                                        $newmsgstring .= $diff==0? $Functions->timeAgoChat($message['create_date']) : $Functions->timeAgoChat($message['create_date']);
                                        // $newmsgstring .= $diff==0? $Functions->timeAgoChat($message['create_date'])  date('H:i a',strtotime($message['create_date'])) : date('d M Y, H:i',strtotime($message['create_date']));
                                        $newmsgstring .= '
                                    </span>
                                </span><br>';
                                $newmsgstring .= $message['message'];
                                $newmsgstring .= '
                            </p>
                            '.$chatimage.'
                        </div>
                    </div>
                </div>';

                $reply['lastmsgid'] = $message['id'];
                $reply['lastmsg'] = $message['message'];
                if ($chatimage)
                    $reply['chatimage'] = true;
                else $reply['chatimage'] = false;

            }
        } //msgs end here

        $reply['msgsstring'] = $newmsgstring;
        

    }else{
        $reply['nomsg']= true;;
    }

    echo json_encode($reply);

}


//Edit main Category
else if ($func == 70) {
    $name = htmlspecialchars(stripslashes($_POST['name']));
    $name = $db->escapeString($name);
    $id=$_POST['id'];

    $sql="update main_category set category_name='$name' where id='$id'";

    if ($db->sql($sql)) {

        echo "true";
    }
    else {

        echo "false";
    }

}

else if ($func == 71) {
    $name = htmlspecialchars(stripslashes($_POST['name']));
    $name = $db->escapeString($name);

    $index = htmlspecialchars(stripslashes($_POST['index']));
    $index = $db->escapeString($index);

    $type = htmlspecialchars(stripslashes($_POST['type']));
    $type = $db->escapeString($type);

    $id=$_POST['id'];

    $sql="update sub_category set main_category='$type',`index`='$index',category_name='$name' where id='$id' ";
    if ($db->sql($sql)) {

        echo "true";
    }
    else {
        echo "false";
    }

}
else if ($func == 72) {
    $name = htmlspecialchars(stripslashes($_POST['name']));
    $name = $db->escapeString($name);

    $type = htmlspecialchars(stripslashes($_POST['type']));
    $type = $db->escapeString($type);

    $id=$_POST['id'];

    $sql="update add_options set sub_category='$type',option='$name' where id='$id' ";
    if ($db->sql($sql)) {

        echo "true";
    }
    else {
        echo "false";
    }

}
else if ($func == 73) {
    $name = htmlspecialchars(stripslashes($_POST['main_type_name']));
    $name = $db->escapeString($name);

    $sql = "SELECT sub.main_category as main_id, sub.id as id, sub.category_name as sub_category, main.category_name as main_category FROM `sub_category` 
    sub join main_category main on sub.main_category=main.id where sub.category_name not like '%not sure' and ((sub.category_name like '%$name%') or (main.category_name like '%$name%')) order by main.category_name asc, sub.index asc ";

    if ($db->sql($sql)) {
        echo json_encode($db->getResult());
    }
    else {
        echo "false";
    }

}

else if ($func == 74) {
    $sql = "SELECT distinct sub.main_category as id, main.category_name as main_category,main.id as main_id FROM `sub_category` 
    sub join main_category main on sub.main_category=main.id  where (main.category_name in('Electrician','Plumber','Carpenter','Gardener','Painter','Builder','Boiler','Tiler','Heating','Locksmith','Bathrooms','Handyman')) order by main.category_name asc ";

    if ($db->sql($sql)) {
        echo json_encode($db->getResult());
    }
    else {
        echo "false";
    }

}

else if ($func == 75) {

    $user_id=$_POST['user_id'];
    $amount=$_POST['amount'];
    $date=date('Y-m-d');

    $sql="insert into withdraw (user_id,amount,withdraw_date) values ('$user_id','$amount','$date')";

    if ($db->sql($sql)) {
        $sql = "update users set balance=0 where id='$user_id'";

        if($db->sql($sql)){

            echo "true";

        }else{

            echo "false";

        }
    }
    else {
        echo "false";
    }

}

else if ($func == 76) {

    $user_id=$_POST['user_id'];
    $request_id=$_POST['request_id'];

    $sql=" update  withdraw set  status=1 where user_id= '$user_id' and id='$request_id' ";

    if ($db->sql($sql)) {
        echo "true";
    }
    else {
        echo "false";
    }

}
else if ($func == 77) {

    $user_id=$_POST['user_id'];
    $request_id=$_POST['request_id'];

    $sql=" update  withdraw set  status=2 where user_id= '$user_id' and id='$request_id'  ";

    if ($db->sql($sql)) {
        echo "true";
    }
    else {
        echo "false";
    }

}

else if ($func == 78) {


    echo $Functions->stripeSubscriptionModifier('off');

    exit;

    $user_id=$_SESSION['user_id'];

    $settings=$Functions->getSettings();
    $secret_key = $settings[0]['stripe_private_key'];
    include_once "../vendor/stripe/stripe-php/init.php";
    try{
        \Stripe\Stripe::setApiKey($secret_key);

        $sql="select * from users where id='$user_id'";
        if($db->sql($sql)){
            $res=$db->getResult();

            // Retrieve the subscription object from Stripe
            $subscription_id = $res[0]['cus_id_stripe'];
            if(!empty($subscription_id) ) {
                $subscription = \Stripe\Subscription::retrieve($subscription_id);
                $subscription->cancel();

                $subscription_status = \Stripe\Subscription::retrieve($subscription_id);
                if ($subscription_status->status != 'active') {

                    $sql = "update users set  subscription_cancel=1 and subscription_status = 0 where id= '$user_id' ";

                    if ($db->sql($sql)) {
                        echo "true";
                    } else {
                        echo "false";
                    }

                } else {
                    echo "not_cancel";
                }
            }else{

                echo "no_subscription";
            }
        }else{
            echo "false";
        }

    }catch (Exception $exception){

    }

}

else if ($func == 79) {
    $feedback_id=$_POST['feedback_id'];
    $sql="delete  from rateuser where id= '$feedback_id' ";
    if ($db->sql($sql)) {
        echo "true";
    }
    else {
        echo "false";
    }
}
//Update feedback
else if ($func == 80) {
    $id = htmlspecialchars(stripslashes($_POST['id']));
    $id = $db->escapeString($id);

    $stars = htmlspecialchars(stripslashes($_POST['stars']));
    $stars = $db->escapeString($stars);

    $message = htmlspecialchars(stripslashes($_POST['message']));
    $message = $db->escapeString($message);

    $sql="update rateuser set `ratings`='$stars' , `message`='$message' where  id ='$id' ";

    if ($db->sql($sql)) {
        echo "true";
    }
    else {
        echo "false";
    }
}

//reply to user
else if ($func == 81) {
    $feedback_id = htmlspecialchars(stripslashes($_POST['feedback_id']));
    $feedback_id = $db->escapeString($feedback_id);

    $message = htmlspecialchars(stripslashes($_POST['message']));
    $message = $db->escapeString($message);

    $send_date=date('d-m-Y');

    $sql="insert into replyrateuser (`rateuser_id`,`message`,`send_date`) values 
                                    ('$feedback_id','$message','$send_date')";

    if ($db->sql($sql)) {
        echo "true";
    }
    else {
        echo "false";
    }
}
//update  reply
else if ($func == 82) {
    $reply_id = htmlspecialchars(stripslashes($_POST['reply_id']));
    $reply_id = $db->escapeString($reply_id);

    $message = htmlspecialchars(stripslashes($_POST['message']));
    $message = $db->escapeString($message);

    $sql="update  replyrateuser set message= '$message' where  id ='$reply_id' ";

    if ($db->sql($sql)) {
        echo "true";
    }
    else {
        echo "false";
    }
}

//delete reply
else if ($func == 83) {
    $id = htmlspecialchars(stripslashes($_POST['id']));
    $id = $db->escapeString($id);

    $sql="delete from replyrateuser  where  id ='$id' ";

    if ($db->sql($sql)) {
        echo "true";
    }
    else {
        echo "false";
    }
}

//add bank details of a user
else if ($func == 84) {
    $user_id = htmlspecialchars(stripslashes($_POST['user_id']));
    $user_id = $db->escapeString($user_id);

    $account_name = htmlspecialchars(stripslashes($_POST['account_name']));
    $account_name = $db->escapeString($account_name);

    $account_number = htmlspecialchars(stripslashes($_POST['account_number']));
    $account_number = $db->escapeString($account_number);

    $sort_code = htmlspecialchars(stripslashes($_POST['sort_code']));
    $sort_code = $db->escapeString($sort_code);

    $create_date=date("d-m-Y");

    $sql="insert into users_account (`user_id`,`account_name`,`account_number`,`sort_code`,`create_date`) 
                values ('$user_id','$account_name','$account_number','$sort_code','$create_date') ";

    if ($db->sql($sql)) {
        echo "true";
    }
    else {
        echo "false";
    }
}

//update bank details of a user
else if ($func == 85) {
    $user_id = htmlspecialchars(stripslashes($_POST['user_id']));
    $user_id = $db->escapeString($user_id);

    $account_name = htmlspecialchars(stripslashes($_POST['account_name']));
    $account_name = $db->escapeString($account_name);

    $account_number = htmlspecialchars(stripslashes($_POST['account_number']));
    $account_number = $db->escapeString($account_number);

    $sort_code = htmlspecialchars(stripslashes($_POST['sort_code']));
    $sort_code = $db->escapeString($sort_code);

    $update_account_id = htmlspecialchars(stripslashes($_POST['update_account_id']));
    $update_account_id = $db->escapeString($update_account_id);

    $create_date=date("d-m-Y");

    $sql="update users_account set status=0 where user_id='$user_id' ";
    $db->sql($sql);

    $sql="insert into users_account (`user_id`,`account_name`,`account_number`,`sort_code`,`create_date`) 
                values ('$user_id','$account_name','$account_number','$sort_code','$create_date') ";

    if ($db->sql($sql)) {

        echo "true";
    }
    else {
        echo "false";
    }
}


else if ($func == 86) {
    $user_id = htmlspecialchars(stripslashes($_POST['user_id']));
    $user_id = $db->escapeString($user_id);

    $sql="select * from users_account where user_id= '$user_id' order by id desc ";
    $object = new stdClass();

    if ($db->sql($sql)) {
        $object->status = true;
        $object->result = $db->getResult();
        echo json_encode($object);

    } else {
        $object->status = false;
    }
}

//Reward to homeowner
else if ($func == 87) {
    $name = htmlspecialchars(stripslashes($_POST['name']));
    $name = $db->escapeString($name);
    $city = $_POST['city'];


    $reward_date = htmlspecialchars(stripslashes($_POST['reward_date']));
    $reward_date = $db->escapeString($reward_date);

    $reward_type = $_POST['reward_type'];

    $sql = "insert into homeowner_reward (`homeowner_name`,`reward_date`,`reward_type`,`city`) values ('$name','$reward_date','$reward_type','$city')";
    if ($db->sql($sql)) {

        echo "true";
    }
    else {
        echo "false";
    }


}
//Reward to tradesperson
else if ($func == 88) {
    $name = htmlspecialchars(stripslashes($_POST['name']));
    $name = $db->escapeString($name);

    $city = $_POST['city'];


    $reward_date = htmlspecialchars(stripslashes($_POST['reward_date']));
    $reward_date = $db->escapeString($reward_date);

    $reward_type = $_POST['reward_type'];

    $sql = "insert into tradesperson_reward (`tradesperson_name`,`reward_date`,`reward_type`,`city`) values ('$name','$reward_date','$reward_type','$city')";
    if ($db->sql($sql)) {

        echo "true";
    }
    else {
        echo "false";
    }

}

//Delete homeowner reward
else if ($func == 89) {
    $id = htmlspecialchars(stripslashes($_POST['id']));
    $id = $db->escapeString($id);


    $sql = " delete from homeowner_reward where  id ='$id' ";
    if ($db->sql($sql)) {

        echo "true";
    }
    else {
        echo "false";
    }

}

//Delete trades person reward
else if ($func == 90) {
    $id = htmlspecialchars(stripslashes($_POST['id']));
    $id = $db->escapeString($id);


    $sql = " delete from tradesperson_reward where  id ='$id' ";
    if ($db->sql($sql)) {

        echo "true";
    }
    else {
        echo "false";
    }
}

//Add social media links
else if ($func == 91) {
    $userid = htmlspecialchars(stripslashes($_POST['userid']));
    $userid = $db->escapeString($userid);

    $link = htmlspecialchars(stripslashes($_POST['link']));
    $link = $db->escapeString($link);

    $social_type = htmlspecialchars(stripslashes($_POST['social_type']));
    $social_type = $db->escapeString($social_type);


    $sql = " insert into social_media_links (`user_id`,`link`,`social_type`) values ('$userid','$link','$social_type')";
    if ($db->sql($sql)) {
        echo "true";
    }
    else {

        echo "false";
    }
}

//delete social media links
else if ($func == 92) {


    $link_id = htmlspecialchars(stripslashes($_POST['link_id']));
    $link_id = $db->escapeString($link_id);


    $sql = " delete from social_media_links where id = '$link_id' ";
    if ($db->sql($sql)) {
        echo "true";
    } else {
        echo "false";
    }
}


//Reward to homeowner from users table
else if ($func == 93 ) {
    $name = htmlspecialchars(stripslashes($_POST['name']));
    $name = $db->escapeString($name);

    $town = htmlspecialchars(stripslashes($_POST['town']));
    $town = $db->escapeString($town);

    $reward_date = htmlspecialchars(stripslashes($_POST['reward_date']));
    $reward_date = $db->escapeString($reward_date);

    $email = htmlspecialchars(stripslashes($_POST['email']));
    $email = $db->escapeString($email);

    $user_id = htmlspecialchars(stripslashes($_POST['user_id']));
    $user_id = $db->escapeString($user_id);

    $reward_type = $_POST['reward_type'];

    $Functions->sendRewardEmail($name,$email,$reward_type);

    $sql = "insert into homeowner_reward (`user_id`,`homeowner_name`,`reward_date`,`reward_type`,`city`) values ('$user_id','$name','$reward_date','$reward_type','$town')";
    if ($db->sql($sql)) {

        echo "true";
    }
    else {
        echo "false";
    }


}
//Reward to tradesperson users table
else if ($func == 94) {
    $name = htmlspecialchars(stripslashes($_POST['name']));
    $name = $db->escapeString($name);
    
    $town = htmlspecialchars(stripslashes($_POST['town']));
    $town = $db->escapeString($town);

    $reward_date = htmlspecialchars(stripslashes($_POST['reward_date']));
    $reward_date = $db->escapeString($reward_date);

    $email = htmlspecialchars(stripslashes($_POST['email']));
    $email = $db->escapeString($email);

    $user_id = htmlspecialchars(stripslashes($_POST['user_id']));
    $user_id = $db->escapeString($user_id);

    $reward_type = $_POST['reward_type'];

    $Functions->sendRewardEmail($name,$email,$reward_type);

    $sql = "insert into tradesperson_reward (`user_id`,`tradesperson_name`,`reward_date`,`reward_type`,`city`) values ('$user_id','$name','$reward_date','$reward_type','$town')";
    if ($db->sql($sql)) {

        echo "true";
    }
    else {
        echo "false";
    }
}

//delete chat
else if ($func == 95) {

    $touserid = htmlspecialchars(stripslashes($_POST['touserid']));
    $touserid = $db->escapeString($touserid);

    $jobid = htmlspecialchars(stripslashes($_POST['jobid']));
    $jobid = $db->escapeString($jobid);

    $userid = htmlspecialchars(stripslashes($_POST['userid']));
    $userid = $db->escapeString($userid);

    $result=$Functions->checkDeleteStatus($touserid,$jobid,$userid);

    $sql="";
    if($result[0]['delete1']==0) {

        $sql = "update user_chat set delete1='$userid' where (sender_id='$userid' or receiver_id = '$userid') and (sender_id='$touserid' or receiver_id = '$touserid') and (job_id='$jobid') ";
    }else if ($result[0]['delete2']==0){
        $sql = "update user_chat set delete2='$userid' where (sender_id='$userid' or receiver_id = '$userid') and (sender_id='$touserid' or receiver_id = '$touserid') and (job_id='$jobid')";
    }


    if ($db->sql($sql)) {

        echo "true";
    }
    else {

        echo "false";
    }

}

else if ($func == 96) {
    
   
    $send = [];
    $phone = htmlspecialchars(stripslashes($_POST['phone']));
    $phone = $db->escapeString($phone);

    $sql="select * from phone_verification where phone = '$phone' and status = 1";
    $db->sql($sql);

    $checkPhoneexist=$db->getResult();
    if(count($checkPhoneexist)>0){
        $send['exist'] = 'yes';

    }else {

        $code=$Functions->randomReferralCode();
        $sql = "insert into phone_verification (phone,code) values ('$phone','$code')";
        $message = "Your phone verification code is " . $code . ". ";

        if ($db->sql($sql)) {
            $send['success'] = 'yes';
            $Functions->sendMessageOnMobile($message, $phone);          
        } else {
            $send['success'] = 'no';
        }
    }
    

    echo json_encode($send);
     
}


else if ($func == 97) {
    $verification_phone = htmlspecialchars(stripslashes($_POST['verification_phone']));
    $verification_phone = $db->escapeString($verification_phone);

    $verification_code = htmlspecialchars(stripslashes($_POST['verification_code']));
    $verification_code = $db->escapeString($verification_code);

    $code=$Functions->randomReferralCode();
    $sql="select * from phone_verification where phone='$verification_phone' and code = '$verification_code' ";

    if ($db->sql($sql)) {
        $data=$db->getResult();
        if(count($data)>0){
            echo "true";
            $sql="update  phone_verification set status=1 where phone='$verification_phone' and code = '$verification_code' ";
            $db->sql($sql);
        }else{
            echo "false";
        }
    }
    else {
        echo "false";
    }
}
//update bio
else if ($func == 98) {
    $userid=$_POST['userid'];

    $trading_name = htmlspecialchars(stripslashes($_POST['trading_name']));
    $trading_name = $db->escapeString($trading_name);

    $fname = htmlspecialchars(stripslashes($_POST['fname']));
    $fname = $db->escapeString($fname);

    $lname = htmlspecialchars(stripslashes($_POST['lname']));
    $lname = $db->escapeString($lname);

    $phone = htmlspecialchars(stripslashes($_POST['phone']));
    $phone = $db->escapeString($phone);

    $sql = " update users set trading_name='$trading_name',fname='$fname',lname='$lname',phone='$phone'  where id='$userid' ";

    if ($db->sql($sql)) {
        echo "true";
    } else {
        echo "false";
    }

}//98
else if ($func == 99) {
    $jobid = htmlspecialchars(stripslashes($_POST['jobid']));
    $jobid = $db->escapeString($jobid);

    $description = htmlspecialchars(stripslashes($_POST['description']));
    $description = $db->escapeString($description);
    $create_date=date("Y-m-d H:i:s");

    $sql="insert into job_description (`job_id`,`description`,`create_date`) values ('$jobid','$description','$create_date')";

    if ($db->sql($sql)) {
        echo "true";
    }
    else {
        echo "false";
    }

}//99
//Repost a job
else if ($func == 100) {
    $id = htmlspecialchars(stripslashes($_POST['id']));
    $id = $db->escapeString($id);

    $sql = "DELETE from apply_job where job_id='$id'";
    if ($db->sql($sql)) {

        $later = date("Y-m-d H:i:s");
        $sql = "update post_job set created_date='$later' where id='$id'"; 
        if($db->sql($sql)) echo "true";
        else echo "false";

        // updating the read/unread status for the repost lead
        $sql = "SELECT * FROM read_leads_counter";
        $db->sql($sql);
        $res = $db->getResult();
        
        if($res) {
            
            foreach($res as $data){

                $idArray1 = explode(',', $data['lead_ids']);
                $idArray2 = explode(',', $data['interested_ids']);
                $idArray3 = explode(',', $data['shortlisted_ids']);
                $idArray4 = explode(',', $data['jobswon_ids']);

                $keyToRemove1 = array_search($id, $idArray1);
                $keyToRemove2 = array_search($id, $idArray2);
                $keyToRemove3 = array_search($id, $idArray3);
                $keyToRemove4 = array_search($id, $idArray4);
                
                if ($keyToRemove1 !== false)  unset($idArray1[$keyToRemove1]);
                if ($keyToRemove2 !== false)  unset($idArray2[$keyToRemove2]);
                if ($keyToRemove3 !== false)  unset($idArray3[$keyToRemove3]);
                if ($keyToRemove4 !== false)  unset($idArray3[$keyToRemove4]);
                
                $leads = implode(',', $idArray1);
                $interested = implode(',', $idArray2);
                $shortlisted = implode(',', $idArray3);
                $jobswon = implode(',', $idArray4);
                $cid= $data['id'];
                
                
                $sql = "update read_leads_counter set lead_ids='$ids', interested_ids='$interested', shortlisted_ids='$shortlisted', jobswon_ids='$jobswon' where id='$cid'"; 
                $db->sql($sql);
            }
        
        }

    } else {
        echo "false";
    }

}//100
else if ($func == 101) {
    $phone = htmlspecialchars(stripslashes($_POST['phone']));
    $phone = $db->escapeString($phone);
    $result = $Functions->CheckPhoneExists($phone);
    if (count($result)==0) {
        echo 'phone-not-exist';

    }else {
        $message="Your email is ".$result[0]['email']." use this email for login.";
        $Functions->sendMessageOnMobile($message,$phone);
        echo "true";
    }
}//101

else if ($func == 102) {
    $user_id=$_POST['user_id'];
    $new_lead_phone=$_POST['new_lead_phone'];
    $new_lead_email=$_POST['new_lead_email'];
    $new_lead_app=$_POST['new_lead_app'];

    $shortlist_phone=$_POST['shortlist_phone'];
    $shortlist_email=$_POST['shortlist_email'];
    $shortlist_app=$_POST['shortlist_app'];

    $hire_phone=$_POST['hire_phone'];
    $hire_email=$_POST['hire_email'];
    $hire_app=$_POST['hire_app'];

    $feedback_phone=$_POST['feedback_phone'];
    $feedback_email=$_POST['feedback_email'];
    $feedback_app=$_POST['feedback_app'];



    $sql="select * from set_notification where user_id='$user_id'";
    $db->sql($sql);
    $res=$db->getResult();
    if(count($res)>0){
        $sql="update set_notification set new_lead_phone='$new_lead_phone',new_lead_email='$new_lead_email',new_lead_app='$new_lead_app',
                                        shortlist_phone='$shortlist_phone',shortlist_email='$shortlist_email',shortlist_app='$shortlist_app',
                                        hired_phone='$hire_phone',hired_email='$hire_email',hired_app='$hire_app',
                                        feedback_phone='$feedback_phone',feedback_email='$feedback_email',feedback_app='$feedback_app' where user_id ='$user_id'";

        if ($db->sql($sql)) {
            echo "true";
        }
        else {
            echo "false";
        }

    }else{
        $sql="insert into  set_notification (new_lead_phone,new_lead_email,new_lead_app,shortlist_phone,shortlist_email,shortlist_app,hired_phone,hired_email,hired_app,feedback_phone,feedback_email,feedback_app,user_id) values 
                                            ('$new_lead_phone','$new_lead_email','$new_lead_app','$shortlist_phone','$shortlist_email','$shortlist_app','$hire_phone','$hire_email','$hire_app','$feedback_phone','$feedback_email','$feedback_app','$user_id')";

        if ($db->sql($sql)) {
            echo "true";
        }
        else {
            echo "false";
        }
    }
}//102
//add blog
else if($func==103){
    $author =$_POST['author'];
    $title =$_POST['title'];
    $category =$_POST['category'];
    $select_main_category =$_POST['select_main_category'];
    $blog_category =$_POST['blog_category'];
    $publish_date =$_POST['publish_date'];
    $short_des =$_POST['short_des'];
    $long_des =$_POST['long_des'];

    $short_des = str_replace("'",'"',$short_des);
    $long_des = str_replace("'",'"',$long_des);

    if(!empty($_FILES['image'])){
        $image=$_FILES['image'];
        $filename=$image['name'];
        $file_tmp=$image['tmp_name'];
        $target="../uploads/blogimages/";
        $timestamp=time();
        $file=$timestamp.'-'.$filename;
        $upload_to=$target.$file;
        move_uploaded_file($file_tmp,$upload_to);
        compressImage($upload_to, $upload_to, 25);
    }else{
        $upload_to=null;
    }
    $slug=str_replace(' ', '-', $title);
    $slug = str_replace("'", '&#39;', $slug);
    $title = str_replace("'", '&#39;', $title);
    $sql=" insert into blogs (`job_category`,`blog_category`,`slug`,`title`,`category`,`author_name`,`create_date`,`short_description`,`long_description`,`image_path`)
                              values ('$select_main_category','$blog_category','$slug','$title','$category','$author','$publish_date','$short_des','$long_des','$upload_to') ";


    if ($db->sql($sql)) {
        echo 'true';
    } else {
        echo 'false';
    }


}//103
else if ($func == 104) {
    $blog_id = htmlspecialchars(stripslashes($_POST['blog_id']));
    $blog_id = $db->escapeString($blog_id);

    $sql="delete from blogs where  id= '$blog_id'";
    if ($db->sql($sql)) {
        echo "true";
    }
    else {
        echo "false";
    }
}//104
//update blog
else if($func==105){
    $id =$_POST['id'];
    $author =$_POST['author'];
    $title =$_POST['title'];
    $category =$_POST['category'];
    $select_main_category =$_POST['select_main_category'];
    $blog_category =$_POST['blog_category'];

    $publish_date =$_POST['publish_date'];
    $short_des =$_POST['short_des'];
    $long_des =$_POST['long_des'];
    $short_des = str_replace("'",'"',$short_des);
    $long_des = str_replace("'",'"',$long_des);
    
    $slug=str_replace(' ', '-', $title);
    $slug = str_replace("'", '&#39;', $slug);
    $title = str_replace("'", '&#39;', $title);

    if(!empty($_FILES['image'])){
        $image=$_FILES['image'];
        $filename=$image['name'];
        $file_tmp=$image['tmp_name'];
        $target="../uploads/blogimages/";
        $timestamp=time();
        $file=$timestamp.'-'.$filename;
        $upload_to=$target.$file;
        move_uploaded_file($file_tmp,$upload_to);
        compressImage($upload_to, $upload_to, 25);
        $sql=" update  blogs set `job_category`='$select_main_category' , `blog_category`='$blog_category' , `slug`='$slug',`title`='$title',`category`='$category',`author_name`='$author',`create_date` = '$publish_date',
                   `short_description`='$short_des',`long_description`='$long_des',`image_path`='$upload_to' 
                    where id ='$id' ";
    }else{
        $sql=" update  blogs set `job_category`='$select_main_category' , `blog_category`='$blog_category' , `slug`='$slug',`title`='$title',`category`='$category',`author_name`='$author',`create_date` = '$publish_date',
                   `short_description`='$short_des',`long_description`='$long_des' where id ='$id' ";
    }

    if($db->sql($sql)){
        echo 'true';
    }else{
        echo "false";
    }

}//105
//send new blog notification

else if ($func == 106) {

    $id = htmlspecialchars(stripslashes($_POST['id']));
    $blog_id = $db->escapeString($id);

    $blog=$Functions->getBlogByID($id);

 
    $link='https://buildela.com/blog-details?slug='.$blog[0]['slug'];
    $temp=explode('/',$blog[0]['image_path']);

    $path=$temp[1]."/".$temp[2]."/".$temp[3];

    $image='https://buildela.com/'.$path;

    $users=array();

    if($blog[0]['category']=='Homeowners'){
        $users=$Functions->getAllHomeowners();

    }else if ($blog[0]['category']=='Professionals'){

        if($blog[0]['job_category']==0){

            $users=$Functions->getAllTradespersons();

        }else{
            $users=$Functions->getAllTradespersonsPassedInCategory($blog[0]['job_category']);
        }


    }

    foreach ($users as $user){
        $Functions->sendNewBlogNotification($user['email'],$link,$image,$blog[0]['title'],$blog[0]['short_description']);

    }
    echo "true";
}//106

else if($func==107){

    $NICEIC=null;
    $ECA=null;
    $NAPIT=null;
    $level3=null;
    $inspection=null;
    $gold=null;
    $edition=null;
    $id_card=null;

    $no_files=0;

    if(!empty($_FILES['NICEIC'])){
        $no_files++;
    }if(!empty($_FILES['ECA'])){
        $no_files++;
    }if(!empty($_FILES['NAPIT'])){
        $no_files++;
    }if(!empty($_FILES['gold'])){
        $no_files++;
    }if(!empty($_FILES['inspection'])){
        $no_files++;
    }if(!empty($_FILES['edition'])){
        $no_files++;
    }if(!empty($_FILES['level3'])){
        $no_files++;
    }

    if($no_files<3){
        echo "<3";
        return;

    }

    if(!empty($_FILES['NICEIC'])){
        $image=$_FILES['NICEIC'];
        $filename=$image['name'];
        $file_tmp=$image['tmp_name'];
        $target="../uploads/electrical/";
        $timestamp=time();
        $file=$timestamp.'-'.$filename;
        $NICEIC=$target.$file;
        move_uploaded_file($file_tmp,$NICEIC);
        compressImage($NICEIC, $NICEIC, 25);
    }
    if(!empty($_FILES['ECA'])){
        $image=$_FILES['ECA'];
        $filename=$image['name'];
        $file_tmp=$image['tmp_name'];
        $target="../uploads/electrical/";
        $timestamp=time();
        $file=$timestamp.'-'.$filename;
        $ECA=$target.$file;
        move_uploaded_file($file_tmp,$ECA);
        compressImage($ECA, $ECA, 25);

    }
    if(!empty($_FILES['NAPIT'])){
        $image=$_FILES['NAPIT'];
        $filename=$image['name'];
        $file_tmp=$image['tmp_name'];
        $target="../uploads/electrical/";
        $timestamp=time();
        $file=$timestamp.'-'.$filename;
        $NAPIT=$target.$file;
        move_uploaded_file($file_tmp,$NAPIT);
        compressImage($NAPIT, $NAPIT, 25);

    }
    if(!empty($_FILES['gold'])){
        $image=$_FILES['gold'];
        $filename=$image['name'];
        $file_tmp=$image['tmp_name'];
        $target="../uploads/electrical/";
        $timestamp=time();
        $file=$timestamp.'-'.$filename;
        $gold=$target.$file;
        move_uploaded_file($file_tmp,$gold);
        compressImage($gold, $gold, 25);

    }
    if(!empty($_FILES['inspection'])){
        $image=$_FILES['inspection'];
        $filename=$image['name'];
        $file_tmp=$image['tmp_name'];
        $target="../uploads/electrical/";
        $timestamp=time();
        $file=$timestamp.'-'.$filename;
        $inspection=$target.$file;
        move_uploaded_file($file_tmp,$inspection);
        compressImage($inspection, $inspection, 25);

    }
    if(!empty($_FILES['edition'])){
        $image=$_FILES['edition'];
        $filename=$image['name'];
        $file_tmp=$image['tmp_name'];
        $target="../uploads/electrical/";
        $timestamp=time();
        $file=$timestamp.'-'.$filename;
        $edition=$target.$file;
        move_uploaded_file($file_tmp,$edition);
        compressImage($edition, $edition, 25);

    }
    if(!empty($_FILES['level3'])){
        $image=$_FILES['level3'];
        $filename=$image['name'];
        $file_tmp=$image['tmp_name'];
        $target="../uploads/electrical/";
        $timestamp=time();
        $file=$timestamp.'-'.$filename;
        $level3=$target.$file;
        move_uploaded_file($file_tmp,$level3);
        compressImage($level3, $level3, 25);

    }
    if(!empty($_FILES['id_card'])){
        $image=$_FILES['id_card'];
        $filename=$image['name'];
        $file_tmp=$image['tmp_name'];
        $target="../uploads/electrical/";
        $timestamp=time();
        $file=$timestamp.'-'.$filename;
        $id_card=$target.$file;
        move_uploaded_file($file_tmp,$id_card);
        compressImage($id_card, $id_card, 25);

    }

    $user_id=$_SESSION['user_id'];
    $create_date=date('Y-m-d');

    $sql="insert into electrical_verification (`user_id`,`create_date`,`NICEIC`,`ECA`,`NAPIT`,`gold`,`level3`,`inspection`,`edition`,`id_card`) values 
                                           ('$user_id','$create_date','$NICEIC','$ECA','$NAPIT','$gold','$level3','$inspection','$edition','$id_card') ";

    if($db->sql($sql)){
        echo 'true';
    }else{
        echo "false";
    }
}//107
else if($func==108){

    $certificate=null;
    $id_card_gas=null;

    $registration_number = htmlspecialchars(stripslashes($_POST['registration_number']));
    $registration_number = $db->escapeString($registration_number);

    $check_number=$Functions->CheckRegistrationNumberExists($registration_number);

    if($check_number){
        echo "same_number";
        return;

    }


    if(!empty($_FILES['certificate'])){
        $image=$_FILES['certificate'];
        $filename=$image['name'];
        $file_tmp=$image['tmp_name'];
        $target="../uploads/gas/";
        $timestamp=time();
        $file=$timestamp.'-'.$filename;
        $certificate=$target.$file;
        move_uploaded_file($file_tmp,$certificate);
        compressImage($certificate, $certificate, 25);
    }
    if(!empty($_FILES['id_card_gas'])){
        $image=$_FILES['id_card_gas'];
        $filename=$image['name'];
        $file_tmp=$image['tmp_name'];
        $target="../uploads/gas/";
        $timestamp=time();
        $file=$timestamp.'-'.$filename;
        $id_card_gas=$target.$file;
        move_uploaded_file($file_tmp,$id_card_gas);
        compressImage($id_card_gas, $id_card_gas, 25);
    }

    $user_id=$_SESSION['user_id'];
    $create_date=date('Y-m-d');

    $sql="insert into gas_verification (`user_id`,`create_date`,`certificate`,`id_card`,`registration_number`) values 
                                           ('$user_id','$create_date','$certificate','$id_card_gas','$registration_number') ";

    if($db->sql($sql)){
        echo 'true';
    }else{
        echo "false";
    }
}//108

else if ($func == 109) {

    $id = htmlspecialchars(stripslashes($_POST['id']));
    $id = $db->escapeString($id);

    $user_id = htmlspecialchars(stripslashes($_POST['user_id']));
    $user_id = $db->escapeString($user_id);

    $sql="update electrical_verification set status=1 where  id= '$id'";
    if ($db->sql($sql)) {
        echo "true";
        $sql="update verify_skill set verify=1 where main_category=18  and user_id= '$user_id'";
        $db->sql($sql);

        $user=$Functions->UserInfo($user_id);
        $Functions->CertificationVerifyMail($user[0]['email']);

    } else {
        echo "false";
    }
}//109
else if ($func == 109) {

    $id = htmlspecialchars(stripslashes($_POST['id']));
    $id = $db->escapeString($id);

    $user_id = htmlspecialchars(stripslashes($_POST['user_id']));
    $user_id = $db->escapeString($user_id);

    $sql="update electrical_verification set status=1 where  id= '$id'";
    if ($db->sql($sql)) {
        echo "true";
        $sql="update verify_skill set verify=1 where main_category=18  and user_id= '$user_id'";
        $db->sql($sql);

        $user=$Functions->UserInfo($user_id);
        $Functions->CertificationVerifyMail($user[0]['email']);

    } else {
        echo "false";
    }
}//109
else if ($func == 110) {

    $id = htmlspecialchars(stripslashes($_POST['id']));
    $id = $db->escapeString($id);

    $user_id = htmlspecialchars(stripslashes($_POST['user_id']));
    $user_id = $db->escapeString($user_id);

    $sql="update gas_verification set status=1 where  id= '$id'";

    if ($db->sql($sql)) {
        echo "true";
        $sql="update verify_skill set verify=1 where main_category=23  and user_id= '$user_id'";
        $db->sql($sql);

        $user=$Functions->UserInfo($user_id);
        $Functions->CertificationVerifyMail($user[0]['email']);

    }
    else {
        echo "false";
    }
}//110

// Trade person reward details
else if ($func == 111) {
    if(isset($_POST['date']) && !empty($_POST['date'])){
        $date   =   date('Y-m',strtotime($_POST['date']));
        $users  =   $Functions->TradesPersonReward($date);        
    }else{
        $date   =   date('Y-m');
        $users  =   $Functions->TradesPersonReward($date);
    }

    echo json_encode($users);
    exit;
} // 111

// Home woner rewards details
else if ($func == 112) {
    if(isset($_POST['date']) && !empty($_POST['date'])){
        $date=date('Y-m',strtotime($_POST['date']));
        $users=$Functions->HomeOwnerRewards($date);
    }else{
        $date=date('Y-m');
        $users=$Functions->HomeOwnerRewards(date('Y-m'));
    }

    echo json_encode($users);
    exit;
} // 112

else if ($func == 113) {
    
    $reply          =   [];
    $userID         =   $_SESSION['user_id'];
    $tradeUserID    =   $_POST['userid'];
    $jobid          =   $_POST['jobid'];
    $new_messages   =   $Functions->getAllNewChatesforme($userID);
    $tradeUsrMsg    =   $Functions->getAllNewChatesbyjobs_person($tradeUserID, $jobid);
    $currentURL     =   $_POST['url'];
    // $userinfo       =   $Functions->UserInfo($userID);

    if (preg_match("/\/chat/", $currentURL)) {
        $reply['currentURL']    =   true;
        $reply['messages']      =   $new_messages;
    } else {
        $reply['currentURL']    =   false;
    }
    
    $reply['userid']            =   $userID;
    $reply['newmsgcount']       =   count($new_messages);
    $reply['newsmgoftradprsn']  =   count($tradeUsrMsg);

    echo json_encode($reply);
    exit;

}

else if ($func == 114) {
    if($func->setOnlineStatus($_SESSION['user_id'], 'offline'))
    echo true;
    exit;
}

else if ($func == 115) {
    $userid             =       $db->escapeString(htmlspecialchars(stripslashes($_POST['userid'])));
    $send               =       [];

    $send['typingStatus'] = $Functions->isTyping($userid);

    echo json_encode($send);
    exit;


}

else if ($func == 116) {
    
    $typingStatus       =       $db->escapeString(htmlspecialchars(stripslashes($_POST['typingStatus'])));
    $userid             =       $db->escapeString(htmlspecialchars(stripslashes($_POST['userid'])));
    $send               =       [];
    
    if($typingStatus === 'true') $typingStatus = true;
    else $typingStatus = false;
        
    $send['typing']     = $typingStatus;
    $send['uid']     = $userid;
    $send['update'] = $Functions->updateTyping($userid, $typingStatus);
    
    // $send['check'] = $Functions->checkTypingStatus(116, 122);
    echo json_encode($send);
    exit;


} else if ($func == 117) {

    $cat_id = htmlspecialchars(stripslashes($_POST['cat_id']));
    $user_id = htmlspecialchars(stripslashes($_POST['user_id']));
    $cat_id = $db->escapeString($cat_id);


    $sql = " delete from social_media_links where id = '$cat_id' ";
    $sql="delete from verify_skill where user_id='$user_id' and main_category='$cat_id'";
    if ($db->sql($sql)) {
        echo "true";
    } else {
        echo "false";
    }
} else if ($func == 118) {
    $name = htmlspecialchars(stripslashes($_POST['name']));
    $name = $db->escapeString($name);

    $type = htmlspecialchars(stripslashes($_POST['type']));
    $type = $db->escapeString($type);

    if($name==""||$type==""){
        echo "fill-fields";
        return;
    }


    $sql="insert into blog_category (cat_type,name) values('$type','$name')";
    if ($db->sql($sql)) {

        echo "true";
    }
    else {
        echo "false";
    }

}  
else if ($func == 119) {
    $id = htmlspecialchars(stripslashes($_POST['id']));
    $id = $db->escapeString($id);
    $sql = "DELETE from blog_category where id='$id'";
    if ($db->sql($sql)) {
        echo "true";
    } else {
        echo "false";
    }

}
else if ($func == 120) {
    $name = htmlspecialchars(stripslashes($_POST['name']));
    $name = $db->escapeString($name);

    $type = htmlspecialchars(stripslashes($_POST['type']));
    $type = $db->escapeString($type);

    $id=$_POST['id'];

    $sql="update blog_category set cat_type='$type', name='$name' where id='$id' ";
    if ($db->sql($sql)) {

        echo "true";
    }
    else {
        echo "false";
    }

}
else if($func == 121){
    
}
?>

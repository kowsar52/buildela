<?php
// error_reporting(0);

require_once 'crud.php';
// require '../vendor/autoload.php';
date_default_timezone_set('Europe/London');


//if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
//    // session isn't started
//    session_start();
//}
class Functions
{
    private $db;


    function __construct()
    {
        $this->db = new Database();
        $this->db->connect();
    }



    function CheckEmailExists($email)
    {
        $sql = "SELECT * from users WHERE email='$email'";
        $this->db->sql($sql);
        $res = $this->db->numRows();
        if ($res > 0) {
            return true;
        } else {
            return false;
        }
    }//checkEmail Exist

    function CheckRegistrationNumberExists($number)
    {
        $sql = "SELECT * from gas_verification WHERE registration_number='$number'";
        $this->db->sql($sql);
        $res = $this->db->numRows();
        if ($res > 0) {
            return true;
        } else {
            return false;
        }
    }//checkEmail Exist

    function CheckPhoneExists($phone)
    {
        $sql = "SELECT * from users WHERE phone='$phone'";
        $this->db->sql($sql);
        return $this->db->getResult();

    }//checkEmail Exist

    function CheckReferralCodeExists($from_referral_code)
    {
        $sql = "SELECT * from users WHERE to_referral_code='$from_referral_code'";
        $this->db->sql($sql);
        $res = $this->db->numRows();
        if ($res > 0) {
            return $this->db->getResult()[0];
        } else {
            return false;
        }
    }//CheckReferralCodeExists



    function UserInfo($id)
    {

        $sql = "select * from users where id='$id'";
        if ($this->db->sql($sql)) {
            return $this->db->getResult();
        }
    }

    function totalHomeOwners()
    {

        $sql = "select * from users where user_role='home_owner'";
        if ($this->db->sql($sql)) {
            return $this->db->getResult();
        }
    }
    function totalPaidUsers()
    {

        $sql = "select * from users where user_role='jobs_person' and user_type=2 ";
        if ($this->db->sql($sql)) {
            return $this->db->getResult();
        }
    }
    function totalUnPaidUsers()
    {

        $sql = "select * from users where user_role = 'jobs_person' and user_type =2 and subscription_status=0 ";
        if ($this->db->sql($sql)) {
            return $this->db->getResult();
        }
    }

    function totalDBSUsers()
    {

        $sql = "select * from users where user_role = 'jobs_person' and user_type =2 and dbs_path !=''";
        if ($this->db->sql($sql)) {
            return $this->db->getResult();
        }
    }

    function getUserRatting($id)
    {

        $sql = "select * from rateuser where user_id=$id ORDER BY id DESC";
        if ($this->db->sql($sql)) {
            return $this->db->getResult();
        }
    }
    function totalTopRatedUser(){
        $sql="select * from users where user_role = 'jobs_person' and user_type =2";
        $this->db->sql($sql);
        $allusers=$this->db->getResult();
        $topUsers=0;

        foreach($allusers as $user){


            $rateings=$this->getUserRatting($user['id']);
            $sumofStars=0;

            foreach($rateings as $rate){
                $sumofStars+=$rate['ratings'];

            }
            if(count($rateings)>=100 && ($sumofStars/count($rateings)>=4.5)){
                $topUsers++;

            }
        }

        return $topUsers;
    }
    function getJobs()
    {

        $sql = "select * from post_job";
        if ($this->db->sql($sql)) {
            return $this->db->getResult();
        }
    }

    function getAllMessages(){

        $sql = "select * from comment";
        if ($this->db->sql($sql)) {
            return $this->db->getResult();
        }

    }

    function getJobsImages($id)
    {

        $sql = "select * from jobs_gallery where job_id='$id'";
        if ($this->db->sql($sql)) {
            return $this->db->getResult();
        }
    }


    function getSearchJobs($status,$id)
    {
        $my_id=$_SESSION['user_id'];

        $result=array();
        $dateque = 'interested_date';

        $sql="select * from apply_job where status='$status' and user_id='$id' ";

        if($status==1){
          $sql="select * from apply_job where status='1' and worker_status = '0' and employer_status = '0' and user_id='$id' ";
          $dateque = 'shortlisted_date';
        }
        if($status==2){
         $sql="select * from apply_job where (status='2' or employer_status = '1') and user_id='$id' ";
         $dateque = 'jobswon_date';
        }
        $this->db->sql($sql);
        $res=$this->db->getResult();
        $r1 = array();
        foreach($res as $r){
            $r1[] = $r['job_id'];
        }
        $job_ids = implode(",",$r1);

        if(count($res)>0) {
           $sql = "select * from post_job where id in ($job_ids) and user_id!='$my_id' order by $dateque desc ";
            $this->db->sql($sql);
            if ($this->db->numRows() > 0) {
                $result[] = $this->db->getResult();
            }
        }
        return $result;
    }//getSearchJobs

    
    
    function getSearchJobsCount($status,$id=null)
    {
        if(empty($id)) $id = $_SESSION['user_id'];

        $sql="select count(*) as count from apply_job where status='$status' and user_id='$id' ";
        if($status==1){
        $sql="select count(*) as count from apply_job where status='1' and worker_status = '0' and employer_status = '0' and user_id='$id' ";
        }
        if($status==2){
        $sql="select count(*) as count from apply_job where (status='2' or employer_status = '1') and user_id='$id' ";
        }
        $this->db->sql($sql);
        $res=$this->db->getResult();

        if(count($res) > 0) {
            return $res[0]['count'];
        } else {
            return 0;
        }
    }//getSearchJobsCount
    
    function getSingleJob($id)
    {

        $sql = "SELECT * from post_job where id='$id'";
        if ($this->db->sql($sql)) {
            return $this->db->getResult();
        }
    }
    function getSingleApplyJob($id)
    {
        $user_id=$_SESSION['user_id'];
        $sql = "select * from apply_job where job_id='$id' and user_id='$user_id'";
        if ($this->db->sql($sql)) {
            return $this->db->getResult();
        }
    }
    function getAllApplyUser($id)
    {
        $user_id = $_SESSION['user_id'];
        $sql = "select * from apply_job where job_id='$id' ";
        if ($this->db->sql($sql)) {
            return $this->db->getResult();
        }
    }

    function getSingleApplyUser($jobs_id,$user_id)
    {
        $sql = "select * from apply_job where job_id='$jobs_id' and user_id ='$user_id' ";
        if ($this->db->sql($sql)) {
            return $this->db->getResult();
        }
    }

    function countJobStatus($jobs_id,$user_id, $status = 'interested', $time = false)
    {
        if($status === 'interested')
            $sql = "SELECT *, COUNT(*) AS total_count FROM apply_job WHERE status = 1 AND job_id='$jobs_id' AND user_id ='$user_id'";
        elseif($status === 'shortlisted')
            $sql = "SELECT *, COUNT(*) AS total_count FROM apply_job WHERE employer_status = 1 AND job_id='$jobs_id' AND user_id ='$user_id'";
        elseif($status === 'jobswon')
            $sql = "SELECT *, COUNT(*) AS total_count FROM apply_job WHERE worker_status = 1 AND job_id='$jobs_id' AND user_id ='$user_id'";


        if ($this->db->sql($sql)) {
            $count = $this->db->getResult();
            if($count){
                return $count[0]['total_count'];
            }else {
                return 0;
            }
        }else {
            return 0;
        }
    }

    function getAllApplyUser_new($id)
    {
        $user_id = $_SESSION['user_id'];
        $sql = "select * from apply_job where job_id='$id' and user_id != '$user_id' and worker_status = '1'";

        if ($this->db->sql($sql)) {
            return $this->db->getResult();
        }
    }

    function last_seen($id)
    {
        $sql = "SELECT last_seen from users where id='$id' ";
        $this->db->sql($sql);
        $result= $this->db->getResult();

        return $this->get_last_seen($result[0]['last_seen']);
    }
    function set_last_seen($id){

        $date1= date("Y-m-d H:i:s");
        $sql = "update users set last_seen ='$date1' where id='$id' ";
        $this->db->sql($sql);
    }

    function checkOnlineStatus($id){
        $sql = "SELECT online_status from users where id='$id' ";
        $this->db->sql($sql);
        $result= $this->db->getResult();

        if($result[0]['online_status'] === 'online') return true;
        else return false;
    }
    function setOnlineStatus($id, $status = 'online'){
        $sql = "update users set online_status ='$status' where id='$id' ";
        $this->db->sql($sql);
    }

    function shortlistedusers($id)
    {

        $sql = "SELECT * from apply_job where job_id='$id' and status != '0' ";
        if ($this->db->sql($sql)) {
            return $this->db->getResult();
        }
    }

    function getSingleOptions($id)
    {

        $sql = "SELECT * from add_options where id='$id'";
        if ($this->db->sql($sql)) {
            return $this->db->getResult();
        }
    }

    function SingleSubCategory($id)
    {

        $sql = "select * from sub_category where id='$id'";
        if ($this->db->sql($sql)) {
            return $this->db->getResult();
        }
    }

    function RepostJobAfter36Hours(){
        $later = date("Y-m-d H:i:s");
        $sql = "SELECT id from post_job where id not in (select job_id from apply_job) and created_date <= NOW() - INTERVAL 36 HOUR";
        if ($this->db->sql($sql)) {
            $jobs= $this->db->getResult();
        }
        foreach ($jobs as $job){
            $id=$job['id'];
            $sql = "update post_job set created_date='$later' where id='$id'";
            $this->db->sql($sql);
        }

    }

    function getMyNotificationSetting($user_id){

        $sql="select * from set_notification where user_id='$user_id'";
         if ($this->db->sql($sql)) {
             return $this->db->getResult();
         }

    }

    function getAllJobs()
    {
        $sql = "SELECT * from post_job ORDER BY created_date DESC";
        if ($this->db->sql($sql)) {
            return $this->db->getResult();
        }
    }
    
    function deleteOldJobs()
       {
           // Calculate the date and time 120 days ago from the current date and time
           $date120DaysAgo = date('Y-m-d H:i:s', strtotime('-120 days'));

           // Get the details of jobs to be deleted (including gallery info)
           $sql = "SELECT * FROM post_job WHERE created_date < '$date120DaysAgo'";
           if ($this->db->sql($sql)) {
               $jobsToDelete = $this->db->getResult();
           } else {
               return false; // No jobs to delete
           }

           foreach ($jobsToDelete as $job) {
               $jobId = $job['id'];

               // Delete the job from the database
               // $sql = "DELETE FROM post_job WHERE id = '$jobId'";
               // $this->db->sql($sql);

               // Delete the job's gallery entries from the database


               // Delete associated files from the server
               $filesToDelete = array();
               // $filesToDelete[] = $job['file_path']; // Add the job's file to delete (adjust the column name as needed)

               // Fetch and add gallery files to delete
               $sql = "SELECT img_path FROM jobs_gallery WHERE job_id = '$jobId'";
               if ($this->db->sql($sql)) {
                   $galleryFiles = $this->db->getResult();
                   foreach ($galleryFiles as $galleryFile) {
                       $filesToDelete[] = $galleryFile['img_path'];
                   }
               }

               // Now, delete the files from the server
               foreach ($filesToDelete as $fileToDelete) {
                   if (file_exists($fileToDelete)) {
                       unlink($fileToDelete);
                   }
               }

               $sql = "DELETE FROM jobs_gallery WHERE job_id = '$jobId'";
               $this->db->sql($sql);

           }

           return $jobsToDelete; // Successfully deleted old jobs, galleries, and files
       }

    function getOldJobs()
       {
           // Calculate the date and time 120 days ago from the current date and time
           $date120DaysAgo = date('Y-m-d H:i:s', strtotime('-120 days'));

           // Construct the SQL query to get jobs older than 120 days
           $sql = "SELECT * FROM post_job WHERE created_date < '$date120DaysAgo' ORDER BY created_date DESC";

           if ($this->db->sql($sql)) {
               return $this->db->getResult();
           }
       }


        function getverifynmgas()
    {
        $sql = "SELECT *  FROM `gas_verification` WHERE `status` = 0";
        if ($this->db->sql($sql)) {
            return $this->db->getResult();
        }
    }   
    
    function getverifynmele()
    {
        $sql = "SELECT *  FROM `electrical_verification` WHERE `status` = 0";
        if ($this->db->sql($sql)) {
            return $this->db->getResult();
        }
    }
        
    function withdrawcount()
    {
        $sql = "SELECT * FROM `withdraw` WHERE `status` = 0";
        if ($this->db->sql($sql)) {
            return $this->db->getResult();
        }
    }
        
    function jobstatuscount()
    {
        $sql = "SELECT * FROM `post_job` WHERE `status` = 0";
        if ($this->db->sql($sql)) {
            return $this->db->getResult();
        }
    }


    function getMatchJobs($id, $offset= null, $limit=null){

        $my_id=$_SESSION['user_id'];
        $result=array();
        $sql="select * from verify_skill where user_id='$id' and status=1 and verify=1";
        $this->db->sql($sql);
        $res=$this->db->getResult();
        $r1 = array();

        foreach($res as $r){
            $r1[] = $r['main_category'];
        }
        $categories_ids = implode(",",$r1);
        $main_category=$r['main_category'];

        if(!empty($offset) && !empty(!$limit)){
            $sql= $sql = "SELECT * FROM post_job
            WHERE main_type IN ($categories_ids)
            AND status = 1
            AND user_id != '$my_id'
            AND id NOT IN (
                SELECT job_id FROM apply_job
                WHERE user_id = '$my_id'
                AND status = 2
                AND worker_status = 1
                AND employer_status = 1
            )
            ORDER BY created_date DESC
            LIMIT $offset, $limit;";
        }else {
            $sql= $sql = "SELECT * FROM post_job
            WHERE main_type IN ($categories_ids)
            AND status = 1
            AND user_id != '$my_id'
            AND id NOT IN (
                SELECT job_id FROM apply_job
                WHERE user_id = '$my_id'
                AND status = 2
                AND worker_status = 1
                AND employer_status = 1
            )
            ORDER BY created_date DESC";
        }
        
        $this->db->sql($sql);
        if($this->db->numRows() > 0){
            return $this->db->getResult();
        }

    }//getMatchJobs
    

    function isLeadRead($job_id, $identifyer = 'leads')
    {
        $job_ids = []; 
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM `read_leads_counter` WHERE `user_id` = '$user_id'";

        if($identifyer == 'leads') $identifier = 'lead_ids';
        elseif($identifyer == 'interested') $identifier = 'interested_ids';
        elseif($identifyer == 'shortlisted') $identifier = 'shortlisted_ids';
        elseif($identifyer == 'jobswon') $identifier = 'jobswon_ids';

        

        if ($this->db->sql($sql)) {
            $idstrings = $this->db->getResult();
            $job_ids = $idstrings[0][$identifier];

            if($job_ids){

                $jobs_ids = explode(',', $job_ids);

                foreach($jobs_ids as $id){
                    if (in_array($job_id, $jobs_ids)) {
                        return true;
                    }else {                        
                        return false;
                    }
                }

            }else {
                return false;
            }
        } else {
            return false;
        }
    }

    function setLeadRead($job_id, $identifyer = "leads")
    {
        if($identifyer == 'leads') $identifier = 'lead_ids';
        elseif($identifyer == 'interested') $identifier = 'interested_ids';
        elseif($identifyer == 'shortlisted') $identifier = 'shortlisted_ids';
        elseif($identifyer == 'jobswon') $identifier = 'jobswon_ids';

        $user_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM `read_leads_counter` WHERE `user_id` = '$user_id'";

        if($this->db->sql($sql)){

            $idstrings = $this->db->getResult();

            $leads          = $idstrings[0]['lead_ids'];
            $interested     = $idstrings[0]['interested_ids'];
            $shortlisted    = $idstrings[0]['shortlisted_ids'];
            $jobswon        = $idstrings[0]['jobswon_ids'];
            
            if ($leads || $interested || $shortlisted || $jobswon) {

                $job_ids = $idstrings[0][$identifier];

                $idlist = explode(',', $job_ids);

                $ids = array_filter($idlist, function($value) {
                    return $value !== "";
                });

                if (!in_array($job_id, $ids)) {
                    array_push($ids, $job_id);
                }

                $idlist = implode(',',$ids);
                
                $sql = "update read_leads_counter set $identifier='$idlist' where user_id='$user_id'";
                if ($this->db->sql($sql)) return true;
                else return false;          

            }else {
                $job_id = $job_id.',';
                $sql = "INSERT INTO `read_leads_counter`(`user_id`,`$identifier`) VALUES ('$user_id','$job_id')";
                
                if ($this->db->sql($sql)) return true;
                else  return false;
            } 
        }

    }


    function getTotalMatchJobsCount($id)
    {
        $my_id = $_SESSION['user_id'];
        $result = array();
        $sql="select * from verify_skill where user_id='$id' and status=1 and verify=1";
        $this->db->sql($sql);
        $res = $this->db->getResult();
        $r1 = array();

        foreach($res as $r) {
            $r1[] = $r['main_category'];
        }

        $categories_ids = implode(",",$r1);
        $main_category = $r['main_category'];
        $sql = "SELECT COUNT(*) AS total FROM post_job  WHERE main_type IN ($categories_ids) AND status=1 AND user_id!='$my_id' AND id NOT IN ( SELECT job_id FROM apply_job WHERE user_id='$my_id' AND status=2 AND worker_status=1 AND employer_status=1);";
        $this->db->sql($sql);

        if($this->db->numRows() > 0) {
            $res = $this->db->getResult();
            return $res[0]['total'];
        }

        return 0;
    }



    function getFilterJobs(array $ids)
    {
        $my_id=$_SESSION['user_id'];
        // $sql="select * from post_job where main_type in ($categories_ids) and status=1 and user_id!='$my_id' order by id desc";
        $categories_ids = implode(',', $ids);
        $sql = "SELECT * FROM post_job WHERE main_type IN ($categories_ids) AND status = 1 AND user_id != $my_id ORDER BY id created_date";


        $this->db->sql($sql);
        if($this->db->numRows() > 0){
            return $this->db->getResult();
        }

    }//getFilterJobs
    
    function getFilterJobsCount($ids)
{
    $my_id=$_SESSION['user_id'];

    $categories_ids = $ids;

    $sql="select count(*) as count from post_job where main_type in ($categories_ids) and status=1 and user_id!='$my_id'";

    $this->db->sql($sql);
    $res=$this->db->getResult();

    if(count($res) > 0){
        return $res[0]['count'];
    } else {
        return 0;
    }
}//getFilterJobsCount
    function getJobsFormail()
    {
        $my_id=$_SESSION['user_id'];
        $sql="select * from post_job where  status=1 and email_status=0 and user_id!='$my_id'";


        if($this->db->sql($sql)){
            $result=$this->db->getResult();
        }
        return $result;

    }//getJobsFormail
    

    function getShortListedUsers($id){
        $shortlisteddata = array();
        $sql = "select * from post_job where user_id = '$id'";
        if ($this->db->sql($sql)) {
            $jobs_result =  $this->db->getResult();
            // print_r($jobs_result);
            foreach($jobs_result as $job){
                $job_id = $job['id'];
                $sql = "SELECT * from apply_job where status !=0 and job_id ='$job_id'";
                $this->db->sql($sql);
                // print_r($this->db->getSql());
                if($this->db->numRows() > 0)
                    $shortlisteddata[] = $this->db->getResult();

            }
            // exit();
        }

        return $shortlisteddata;

    }
    function getMyPostedJobs($id)
    {

        $sql = "SELECT * from post_job where user_id='$id' ORDER BY created_date DESC ";
        if ($this->db->sql($sql)) {
            return $this->db->getResult();
        }
    }
    function getMyAppliedJobs($id)
    {
        $sql = "SELECT * from apply_job where user_id='$id' ORDER BY apply_date DESC ";
        if ($this->db->sql($sql)) {
            return $this->db->getResult();
        }
    }

    function countMyApply($id)
    {

        $sql = "SELECT * FROM apply_job WHERE job_id='$id'";
        if ($this->db->sql($sql)) {
            return $this->db->getResult();
        }
    }

    function countApply($id)
    {

        $sql = "SELECT COUNT(job_id) as job_count FROM apply_job WHERE job_id='$id'";
        if ($this->db->sql($sql)) {
            return $this->db->getResult();
        }
    }
    function getAllBlogs(){
        $sql="Select * from blogs order by id desc ";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }
    function getProfessionalBlogs(){
        $sql="Select * from blogs where category ='Professionals' ORDER BY blog_category, create_date DESC";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }
    function getBlogsByBlogCatID($id){
        $sql="Select * from blogs where blog_category ='$id' ORDER BY blog_category, create_date DESC";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }
    function getHomeownerBlogs(){
        $sql = "SELECT * FROM blogs WHERE category = 'Homeowners' ORDER BY blog_category, create_date DESC";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }

    function getBlogBySlug($slug){
        $sql="Select * from blogs where slug ='$slug' ";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }

    }
    function getBlogByID($id){
        $sql="Select * from blogs where id ='$id' ";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }

    }
    function getMyGallery($id){

        $sql = "SELECT * from gallery  WHERE user_id='$id'";
        if ($this->db->sql($sql)) {
            return $this->db->getResult();
        }
    }   
    
    function getMyGalleryvideo($id){

      
        $sql = "SELECT * FROM `gallery` WHERE `user_id` = '$id' AND `file_type` = 'video'";
          if ($this->db->sql($sql)) {
        $result = $this->db->getResult();
        if (!empty($result)) {
            return $result;
        } else {
            // Array is empty
            return null; // or you can return false, an empty array, or any other value as per your requirement
        }
    }
    }   
    function getMyGalleryimage($id){

      
     $sql = "SELECT * FROM `gallery` WHERE `user_id` = '$id' AND `file_type` = 'image'";
    if ($this->db->sql($sql)) {
        $result = $this->db->getResult();
        if (!empty($result)) {
            return $result;
        } else {
            // Array is empty
            return null; // or you can return false, an empty array, or any other value as per your requirement
        }
    }
    }


    function CheckOldPass($userid,$oldpass)
    {
        $hashPassword = md5($oldpass);
        $sql = "SELECT password from users where id='$userid' and password='$hashPassword'";
        $this->db->sql($sql);
        $res = $this->db->numRows();
        if ($res > 0) {
            return true;
        } else {
            return false;
        }
    }   

    function Checkverifeddocs($userid)
    {
    
     $sql = "SELECT COUNT(*) FROM electrical_verification WHERE user_id = '$userid' AND status = '1'";


 if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }

    function UpdatePassword($userid,$confirmpass,$oldpass)
    {
        if ($this->CheckOldPass($userid,$oldpass)) {
            $hashPassword = md5($confirmpass);

            $sql = "update users set password='$hashPassword' where id='$userid'";
            if ($this->db->sql($sql)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }//update password

    function getSkills(){
        $sql="select * from verify_skill where status=1";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }

    function getMySkills($id){                                                                       
        $sql="select * from verify_skill where user_id='$id' and status=1";
        $sql="select * from verify_skill where user_id='$id' and status=1 and verify=1";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }


   function checkUsergasorele($id){                                                                      
        $sql="SELECT main_category
FROM `verify_skill`
WHERE user_id = '$id' AND (main_category = 18 OR main_category = 23);";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }


   function checkMyapprove($id){                                                                         
        $sql="SELECT status
FROM `electrical_verification`
WHERE user_id = '$id' AND status = 1

UNION ALL

SELECT status
FROM `gas_verification`
WHERE user_id = '$id' AND status = 1;";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }



    function getAllUsers(){
        $sql="select * from users where user_type=2";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }


    function getAllDeletedUsers(){
        $sql="select * from canceled_users_new";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }


    function getAllMyChates($touser_id,$jobid){
        $my_id=$_SESSION['user_id'];
        $sql="update  chat_messages set status=1 where sender_id='$touser_id' and  receiver_id= '$my_id' and job_id ='$jobid' ";
        $this->db->sql($sql);

        $sql="select * from chat_messages where ((sender_id='$my_id' and receiver_id='$touser_id') or (sender_id= '$touser_id' and receiver_id= '$my_id')) and (job_id ='$jobid')  ";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }

    function getChatpreview($jobid, $sender = false, $receiver = false){

        // $sql="select * from chat_messages where ((sender_id='$touser_id' and receiver_id='$reciver_id') or (sender_id= '$reciver_id' and receiver_id= '$touser_id')) and (job_id ='$jobid')  ";
        if($sender && !$receiver) 
            $sql="select * from chat_messages where job_id ='$jobid' AND sender_id = '$sender' ORDER BY `chat_messages`.`create_date`  DESC";
        elseif(!$sender && $receiver) 
            $sql="select * from chat_messages where job_id ='$jobid' AND receiver_id = '$receiver' ORDER BY `chat_messages`.`create_date`  DESC";
        elseif(!$sender && $receiver) 
            $sql="select * from chat_messages where job_id ='$jobid' AND sender_id = '$sender' AND receiver_id = '$receiver' ORDER BY `chat_messages`.`create_date`  DESC";
        else 
            $sql="select * from chat_messages where job_id ='$jobid' ORDER BY `chat_messages`.`create_date`  DESC";

        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }


    function getChatAdmin($touser_id,$jobid,$reciver_id){

        $sql="select * from chat_messages where ((sender_id='$touser_id' and receiver_id='$reciver_id') or (sender_id= '$reciver_id' and receiver_id= '$touser_id')) and (job_id ='$jobid')  ";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }

    function getAllNewChates($touser_id,$jobid){
        $my_id=$_SESSION['user_id'];
        $sql="select * from chat_messages where  receiver_id= '$my_id' and status=0  and job_id ='$jobid'    ";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }

    function getAllNewChatesforme($touser_id){
        $sql="select * from chat_messages where  receiver_id= '$touser_id' and status=0";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }

    function getChatImages($imglist){
        if(!empty($imglist)){
            $array = explode(",", $imglist);
            $cleanedArray = array_map(function($url) {
                return str_replace("..", "", $url);
            }, $array);
            $output = '';
            foreach($cleanedArray as $image){
                $output .= "<div class='imgcontainer'><img class='img-fluid' src='".$image."' alt='chat Image' data-imgid='0' /></div>";
            }
            return $output;
        }else {
            return false;
        }    
    
    }

    function mySendmebythisuser($reviver_id,$sender_id,$job_id){

        $sql="select * from chat_messages where  receiver_id= '$reviver_id' and sender_id='$sender_id' and job_id = '$job_id' and status=0 ";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }



    function showChattoadmin($jobid){

        $sql="select * from chat_messages where  job_id ='$jobid'    ";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }
    
    

    function isChatExist($jobId) {

        $myId = $_SESSION['user_id'];        
        $sql = "SELECT 1  FROM user_chat WHERE receiver_id = '$myId'  AND job_id = '$jobId' LIMIT 1";
    
        if ($this->db->sql($sql)) {
            return $this->db->numRows() > 0; 
        }else {
            return false;
        }
    
}

    function getAllNewChatesbyjobs_person($touser_id,$jobid){

        $my_id=$_SESSION['user_id'];
        $sql="select * from chat_messages where  receiver_id= '$my_id' and sender_id= '$touser_id' and status=0  and job_id ='$jobid'    ";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }

    function getAllMyChates_new($touser_id,$lastmsgid,$jobid){
        $my_id=$_SESSION['user_id'];
        $sql="select * from chat_messages where ((sender_id='$my_id' and receiver_id='$touser_id') or (sender_id= '$touser_id' and receiver_id= '$my_id')) and job_id ='$jobid'  and id > '$lastmsgid'";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }

    function getApplyUsers($job_id,$user_id){
        $sql="select * from apply_job where job_id='$job_id' and user_id='$user_id' ";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }


    function getApplyUsersInfo($user_id,$job_id){
        $sql="select * from apply_job where job_id='$job_id' and user_id='$user_id'";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }
    function getjobposteduserinfo($job_id){
        $user_id=$_SESSION['user_id'];
        $sql="select * from apply_job where job_id='$job_id' and user_id='$user_id'";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }
    function getApplyUserStatus($user_id,$job_id){
        $sql="select * from apply_job where user_id='$user_id' and job_id='$job_id'";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }

   function getuserjobspostednm($user_id){
        $sql="SELECT COUNT(*) AS count FROM post_job WHERE user_id='$user_id'";
       if ($this->db->sql($sql)) {
            return $this->db->getResult();
        }
    }

function getServiceInfo($service_name)
{
    $service_name = $this->db->escapeString($service_name);
    $sql = "SELECT * from services WHERE service_name='{$service_name}'";
    $this->db->sql($sql);
    
    if ($this->db->numRows() > 0) {
        return $this->db->getResult();
    } else {
        return false;
    }
}

function base_url($path = '') {
    $scheme = $_SERVER['REQUEST_SCHEME'];
    $host = $_SERVER['HTTP_HOST'];
    return $scheme . '://' . $host . '/' . $path;
}


function getCityInfo($city_name)
{
    $city_name = $this->db->escapeString($city_name);
    $sql = "SELECT * from citiesseo WHERE city_name='{$city_name}'";
    $this->db->sql($sql);

    if ($this->db->numRows() > 0) {
        return $this->db->getResult();
    } else {
        return false;
    }
}

function getCities() {
    $sql = "SELECT city_name FROM citiesseo";
    $this->db->sql($sql);
    $res = $this->db->getResult();
    return $res;
}

function getServices() {
    $sql = "SELECT service_name FROM services";
    $this->db->sql($sql);
    $res = $this->db->getResult();
    return $res;
}



    function getAllQuestions(){
        $sql="select * from question";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }

    function getElectricalVerifyRequests(){

        $sql="SELECT * FROM `electrical_verification`  ORDER BY `electrical_verification`.`create_date`  DESC";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }
    function getGasVerifyRequests(){

        $sql="select * from gas_verification order by create_date desc ";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }

    function getSingleElectrical($id){

        $sql="select * from electrical_verification where id='$id'";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }
    function getSingleGas($id){

        $sql="select * from gas_verification where id = '$id' ";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }

    function getMyElectricalDocs($user_id){

        $sql="select * from electrical_verification where user_id='$user_id'";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }
    function getMyGasDocs($user_id){

        $sql="select * from gas_verification where user_id = '$user_id' ";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }

    function getQuestion($id){
        $sql = "SELECT * FROM question WHERE main_category_id='$id' ORDER BY RAND() LIMIT 15";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }

    function mainCategory(){
        $sql="select * from main_category";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }   
    function blogCategory(){
        $sql="select * from blog_category";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }   
    function mainCategorybyID($id){
        $sql="select * from main_category where id='$id'";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    } 
    function blogCategorybyID($id){
        $sql="select * from blog_category where id='$id'";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }   
    function mainlocation(){
        $sql="select * from citiesseo";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }   
    function mainserviceseo(){
        $sql="select * from services";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }
    function getSingleQuestion($q_id){
        $sql="select * from question where id='$q_id'";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }

    function SingleMainCategory($id){
        $sql="select * from main_category where id='$id'";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }
    function subCategory(){
        $sql="select * from sub_category";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }

    function getSearchedUsers($value){
        $sql="SELECT * from users WHERE email='$vale' or mobile_number='$vale' or bussiness_name='$vale'or bussiness_address='$vale'";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }
    function getAllMsg(){
        $sql="select * from msg";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }
    function AllfeedBacks(){
        $sql="select * from comment";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }

    function getuserdetails($user_id){
        $sql="select * from users where id='$user_id'";
        if($this->db->sql($sql)){

            return $this->db->getResult();
        }
    }
    function updateSubscriptionStatus($user_id){

        $sql="select * from users where id='$user_id'";
        if($this->db->sql($sql)){
            $res=$this->db->getResult();
            $datenow=date('Y-m-d',strtotime( '-1 day'));
            if($datenow>$res[0]['subscription_end']){
                $sql="update users set subscription_status = 0 where id='$user_id'";
                $this->db->sql($sql);
            }
        }
    }

    function checkSubscription($userid = null, $subscription_id = null) {

        if(!$userid) $userid=$_SESSION['user_id'];        
        $userinfo = $this->UserInfo($userid)[0];

        if(!$subscription_id) $subscription_id= $userinfo['stripe_subscription_id'];   
        
        $settings = $this->getSettings();
        $secret_key = $settings[0]['stripe_private_key'];
        require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/stripe/stripe-php/init.php';
        \Stripe\Stripe::setApiKey($secret_key);
    
        if(empty($subscription_id) || strpos($subscription_id, 'cus') === 0)  return false; 
    
        $subscription = \Stripe\Subscription::retrieve($subscription_id);
        $end_date = $subscription->current_period_end;
        $now = time();
    
        if($now < $end_date){
            return true;
        }else {
            return false;
        }
    }

    function autoCharge($user_id){
        $settings=$this->getSettings();
        $secret_key = $settings[0]['stripe_private_key'];
        include "vendor/stripe/stripe-php/init.php";

        $sql="select * from users where id='$user_id'";
        if($this->db->sql($sql)){

            $res=$this->db->getResult();
            $datenow=date('Y-m-d');


            if( ($res[0]['subscription_status'] ==0 ) && ($datenow>$res[0]['subscription_end']) && ($res[0]['subscription_cancel']==0)){

                $amount=$settings[0]['subscription_price'];
                //below code for later charge, without card for subscription usually
                //    \Stripe\Stripe::setApiKey("sk_test_51KiyFEK7MTYjUl7bVHKoi89JLIaHBQo9uDlukufe5wNJeH5HUC2LtdhOoptzAwqXluLkxxeDKmhnEVOqeRGOrnUN00R7MM6qP5");
                \Stripe\Stripe::setApiKey($secret_key);
                $paymentmethod = \Stripe\PaymentMethod::all([
                    'customer' => $res[0]['stripe_subscription_id'],
                    'type' => 'card',
                ]);
                $intent = \Stripe\PaymentIntent::create([
                    'amount' => ($amount * 100),
                    'currency' => 'GBP',
                    'customer' =>  $res[0]['stripe_subscription_id'],
                    'payment_method' => $paymentmethod->data[0]->id,
                    'off_session' => true,
                    'confirm' => true,
                ]);
            }


            if((isset($intent))  && ($intent['status']=="succeeded")){

                $day=30;
                $s_type ="Monthly";
                $stripe_subscription_id=$res[0]['stripe_subscription_id'];

                $start_date = date("Y-m-d");
                $end_date = date('Y-m-d', strtotime("+" . $day . "days"));

                $status_stripe = 'COMPLETED';
                $tranx_type = "stripe";
                $json_object = json_encode($intent);
                $final_amount = $amount;

                $sql ="update users set subscription_type='$s_type', subscription_status=1 , subscription_date='$start_date' , subscription_end='$end_date' where id='$user_id' ";
                $this->db->sql($sql);

                $create_transaction = "INSERT INTO `transactions`(`stripe_subscription_id`,`payment_amount`, `payment_status`, `user_id`,`payment_type`,`object`,`s_type`) VALUES ('$stripe_subscription_id','$final_amount','$status_stripe','$user_id','$tranx_type','$json_object','$s_type')";
                $this->db->sql($create_transaction);


            }

        }
    }

    function deleteStripeSubscription($user_id=null){

        if(!$user_id)$user_id = $_SESSION['user_id'];
        $settings             =   $this->getSettings();
        $secret_key           = $settings[0]['stripe_private_key'];
        include_once $_SERVER['DOCUMENT_ROOT']."/vendor/stripe/stripe-php/init.php";
        
        
        try{
            \Stripe\Stripe::setApiKey($secret_key);
            $sql="select * from users where id='$user_id'";
            
            if($this->db->sql($sql)){
                
                $res=$this->db->getResult();
                $subscription_id = $res[0]['stripe_subscription_id'];
                
                if(!empty($subscription_id) ) {
                
                    $subscription = \Stripe\Subscription::retrieve($subscription_id);                    
                    $subscription->cancel();
                    
                    if ($subscription->status != 'active') return true;
                    else return false;
                    
                }else{
                    return false;
                }
            }else{
                return false;
            }

        }catch (Exception $exception){
            return false;
        }
    }
    
    function stripeSubscriptionModifier($activate = 'on', $user_id = null){

        
        $settings             =   $this->getSettings();
        $secret_key           = $settings[0]['stripe_private_key'];
        include_once $_SERVER['DOCUMENT_ROOT']."/vendor/stripe/stripe-php/init.php";
        
        if(!$user_id){
            $user_id = $_SESSION['user_id'];
            try{
                
                \Stripe\Stripe::setApiKey($secret_key);
                $sql="select * from users where id='$user_id'"; 
                
                if($this->db->sql($sql)){
                    
                    $res=$this->db->getResult();
                    $subscription_id = $res[0]['stripe_subscription_id'];
                    
                    if(!empty($subscription_id) ) {
    
                        $subscription = \Stripe\Subscription::retrieve($subscription_id);
                        
                        if ($activate == 'on') $subscription->cancel_at_period_end = false;
                        elseif($activate == 'off') $subscription->cancel_at_period_end = true;
                        $subscription->save();
                        
                        $check = \Stripe\Subscription::retrieve($subscription_id); 
                        
                        if ($check->status === 'active' && $check->cancel_at_period_end === false && $activate === 'on') {
                            
                            $sql = "update users set subscription_cancel=0 and subscription_status = 1 where id= '$user_id' ";
                            if ($this->db->sql($sql)) {
                                return "true";
                            } else {
                                $subscription->cancel_at_period_end = true;
                                $subscription->save();
                                return "false";
                            }
    
                        } else {
                            $sql = "update users set  subscription_cancel=1 and subscription_status = 0 where id= '$user_id' ";
                            if ($this->db->sql($sql)) {
                                return "true";
                            } else {
                                $subscription->cancel_at_period_end = false;
                                $subscription->save();
                                return "false";
                            }
                        }
                    }else{
                        return "no_subscription";
                    }
                }else{
                    return "no_user";
                }
    
            }catch (Exception $exception){
                return "false";
            }
        } else {
            try{
                \Stripe\Stripe::setApiKey($secret_key);
                $subscription = \Stripe\Subscription::retrieve($subscription_id);
                        
                if ($activate == 'on') $subscription->cancel_at_period_end = false;
                elseif($activate == 'off') $subscription->cancel_at_period_end = true;
                $subscription->save();
                
                $check = \Stripe\Subscription::retrieve($subscription_id); 
                
                if ($check->status === 'active' && $check->cancel_at_period_end === false && $activate === 'on') {
                    
                    $sql = "update users set subscription_cancel=0 and subscription_status = 1 where id= '$user_id' ";
                    if ($this->db->sql($sql)) {
                        return "true";
                    } else {
                        $subscription->cancel_at_period_end = true;
                        $subscription->save();
                        return "false";
                    }

                } else {
                    $sql = "update users set  subscription_cancel=1 and subscription_status = 0 where id= '$user_id' ";
                    if ($this->db->sql($sql)) {
                        return "true";
                    } else {
                        $subscription->cancel_at_period_end = false;
                        $subscription->save();
                        return "false";
                    }
                }
    
            }catch (Exception $exception){
    
            }
        }
    }
    
    function stripeSubscriptionStatus($isOnlyCancel=false, $cusid=null){
        
       
        $user_id = $_SESSION['user_id'];
        $settings             =   $this->getSettings();
        $secret_key           = $settings[0]['stripe_private_key'];
        include_once $_SERVER['DOCUMENT_ROOT']."/vendor/stripe/stripe-php/init.php";
        
        try{
            
            \Stripe\Stripe::setApiKey($secret_key);

            $sql="select * from users where id='$user_id'";
            
            if($this->db->sql($sql)){

                $res=$this->db->getResult();
                if(!$cusid)$cusid = $res[0]['stripe_subscription_id'];
                
                if(!empty($cusid) ) {
                    
                    $subscription = \Stripe\Subscription::retrieve($cusid); 
                    if(!$isOnlyCancel){
                        if ($subscription->status == 'active' && $subscription->cancel_at_period_end == false) return true;
                        else return false;
                    }else {
                        if ($subscription->status == 'active') return true;
                        else return false;
                    } 
                }
            }

        }catch (Exception $exception){
            return false;
        }
        
    }

    function stripeTrialCheck($customerId=null){

        $user_id = $_SESSION['user_id'];
        $settings             =   $this->getSettings();
        $secret_key           = $settings[0]['stripe_private_key'];
        include_once $_SERVER['DOCUMENT_ROOT']."/vendor/stripe/stripe-php/init.php";
        
        \Stripe\Stripe::setApiKey($secret_key);

        try {            

            $sql="select * from users where id='$user_id'";
            $this->db->sql($sql);
            $res=$this->db->getResult();
            if(!$customerId) $customerId = $res[0]['stripe_subscription_id'];

            if($customerId){
                $subscriptions = \Stripe\Subscription::all([
                    'customer' => $customerId,
                ]);
        
                if (!empty($subscriptions->data)) {
                    $subscription = $subscriptions->data[0];
                    if ($subscription->status === 'active' && $subscription->trial_end >= time()) {
                        return true;
                    }else {
                        return false;
                    }
                }
            }
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return false;
        }
    }

    function checkMoneybackPeriod($customerId=null){        

        $user_id              = $_SESSION['user_id'];
        $settings             =   $this->getSettings();
        $secret_key           = $settings[0]['stripe_private_key'];
        include_once $_SERVER['DOCUMENT_ROOT']."/vendor/stripe/stripe-php/init.php";
        
        \Stripe\Stripe::setApiKey($secret_key);

        try {

            $sql="select * from users where id='$user_id'";
            $this->db->sql($sql);
            $res=$this->db->getResult();
            if(!$customerId) $customerId = $res[0]['stripe_subscription_id'];
            
            if($customerId){

                $subscription = \Stripe\Subscription::retrieve($customerId); 

                $subscriptionStartDate = $subscription->current_period_start;
                $currentDate = time();
                $timeDifference = $currentDate - $subscriptionStartDate;
                $daysDifference = floor($timeDifference / (60 * 60 * 24));
                $isWithin14Days = $daysDifference <= 14;
                
                return $isWithin14Days;
            }
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return false;
        }
    }


    public function stripeRefund($user_id=null){
        
        

        if(!$user_id)$user_id = $_SESSION['user_id'];
        $settings             =   $this->getSettings();
        $secret_key           = $settings[0]['stripe_private_key'];
        include_once $_SERVER['DOCUMENT_ROOT']."/vendor/stripe/stripe-php/init.php";
        
        \Stripe\Stripe::setApiKey($secret_key);

        $sql="select * FROM transactions WHERE user_id='$user_id '";
        $this->db->sql($sql);

        $customer=$this->db->getResult()[0];
        $chargeid = $customer['stripe_charge_id'];
        $refundamount = $customer['payment_amount'];
        $invoiceId = $customer['stripe_invoice_id'];
        $subsid = $customer['stripe_subscription_id'];  

        try { 
            
            $refund = \Stripe\Refund::create([
                'charge' => $chargeid,
                'amount' => $this->dollarsToCents($refundamount),
            ]);
            

            if($refund->status == 'succeeded'){
                $sql = "INSERT INTO `refunds`(`stripe_refund_id`, `stripe_subscription_id`, `amount_refunded`, `user_id`, `last_stripe_charge_id`, `stripe_invoice_id`) VALUES ('$refund->id', '$subsid', '$refundamount', $user_id, '$chargeid', '$invoiceId');";
                $this->db->sql($sql);            
                return true;
            }else {
                return false;
            }

        } catch (\Stripe\Exception\CardException $e) {
            return false;
        } catch (\Stripe\Exception\RateLimitException $e) {
            return false;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            return false;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            return false;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            return false;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return false;
        }
    }

    public function checkDefaultCard($last4){
        
        // include_once $_SERVER['DOCUMENT_ROOT']."/vendor/stripe/stripe-php/init.php";
        
        // $settings       =   $this->getSettings()[0];
        // $secret_key     =   $settings['stripe_private_key'];
        // $user_id        =   $_SESSION['user_id'];
        // $userinfo       =   $this->UserInfo($user_id)[0];
        // $customer_id    =   $userinfo['stripe_customer_id'];    
        // $stripe = new \Stripe\StripeClient($secret_key);
        
        
        // $cards = $stripe->customers->allSources( $customer_id,  ['object' => 'card'] );
        
        // if($cards->data){
        //     foreach($cards->data as $card){

        //     }
        // }
        
    }

    public function addCard($token){
        
        include_once $_SERVER['DOCUMENT_ROOT']."/vendor/stripe/stripe-php/init.php";
        
        $settings       =   $this->getSettings()[0];
        $secret_key     =   $settings['stripe_private_key'];
        $user_id        =   $_SESSION['user_id'];
        $userinfo       =   $this->UserInfo($user_id)[0];
        $customer_id    =   $userinfo['stripe_customer_id'];

        $stripe = new \Stripe\StripeClient($secret_key);        
        
        $newCard = $stripe->customers->createSource(
            $customer_id,
            ['source' => $token]
        );

        return $newCard;
        
    }

    public function retrieveCards($cardId = null){
        
        include_once $_SERVER['DOCUMENT_ROOT']."/vendor/stripe/stripe-php/init.php";
        
        $settings       =   $this->getSettings()[0];
        $secret_key     =   $settings['stripe_private_key'];
        $user_id        =   $_SESSION['user_id'];
        $userinfo       =   $this->UserInfo($user_id)[0];
        $customer_id    =   $userinfo['stripe_customer_id'];    
        $stripe = new \Stripe\StripeClient($secret_key);
        
        if($cardId){
            $card = $stripe->customers->retrieveSource(
              $customer_id,
              $cardId,
              []
            );
            return $card;
        }else {
            $cards = $stripe->customers->allSources( $customer_id,  ['object' => 'card'] );
            return $cards->data;
        }

        
    }

    public function updateCard($args=[], $last4){
        
        include_once $_SERVER['DOCUMENT_ROOT']."/vendor/stripe/stripe-php/init.php";
        
        $settings       =   $this->getSettings()[0];
        $secret_key     =   $settings['stripe_private_key'];
        $user_id        =   $_SESSION['user_id'];
        $userinfo       =   $this->UserInfo($user_id)[0];
        $customer_id    =   $userinfo['stripe_customer_id'];    
        $stripe = new \Stripe\StripeClient($secret_key);
        
        
        $cards = $stripe->customers->allSources( $customer_id,  ['object' => 'card'] );
        if($cards->data){
            foreach($cards->data as $card){
                if($card->last4 === $last4) {
                    $update = $stripe->customers->updateSource(
                        $customer_id,
                        $card->id,
                        $args
                    );
                    return $update;
                }
            }
        }else {
            return false;
        }

        
    }

    public function deleteCards($last4){
        
        include_once $_SERVER['DOCUMENT_ROOT']."/vendor/stripe/stripe-php/init.php";
        
        $settings       =   $this->getSettings()[0];
        $secret_key     =   $settings['stripe_private_key'];
        $user_id        =   $_SESSION['user_id'];
        $userinfo       =   $this->UserInfo($user_id)[0];
        $customer_id    =   $userinfo['stripe_customer_id'];    
        $stripe = new \Stripe\StripeClient($secret_key);
        $cards = $stripe->customers->allSources( $customer_id,  ['object' => 'card'] );
        
        if($cards->data){
            foreach($cards->data as $card){
                $card4 = (int) $card->last4;
                $last4 = (int) $last4;
                if($card4 === $last4) {
                    
                    $delete = $stripe->customers->deleteSource(
                        $customer_id,
                        $card->id,
                        []
                    );
                    if($delete->deleted) return $delete;
                    else return false;
                }
            }
        }else {
            return false;
        }
        
    }

    

    function stripeFloat($number) {
        if (is_numeric($number)) {
            $numberStr = strval($number);
            $length = strlen($numberStr);
            
            if ($length >= 2) {
                $formattedNumber = substr($numberStr, 0, $length - 2) . '.' . substr($numberStr, -2);
                return (float)$formattedNumber;
            }
        }
        
        return $number;
    }

    function stripeDecimal($input) {
        if (is_numeric($input)) {
            return $input;
        } else if (is_string($input)) {
            $cleanedString = preg_replace('/[^0-9]/', '', $input);
            return $cleanedString;
        }
        
        return $input; // Return the input as is if it can't be cleaned
    }

    function dollarsToCents($dollars) {
        return $dollars * 100;
    }


    function checktokenexist($token){
        $sql = "SELECT * from users WHERE reset_token='$token'";
        $this->db->sql($sql);
        $res = $this->db->numRows();
        // echo $res;
        if ($res > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getPopular_search()
    {
        $sql = "SELECT distinct sub.main_category as id, main.category_name as main_category, main.id as main_id FROM `sub_category` 
    sub join main_category main on sub.main_category=main.id  where  (main.category_name in('Electrician','Plumber','Carpenter','Gardener','Painter','Builder','Boiler','Tiler','Heating','Locksmith','Bathrooms','Handyman')) order by main.category_name asc  ";
        if ($this->db->sql($sql)) {
            return $this->db->getResult();
        }
    }
    function getMyWithdraw($id){
        $sql="select * from withdraw where  user_id= '$id' ";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }
    function getNewDescriptionOfJob($job_id){

        $sql="select * from job_description where job_id='$job_id'";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }


    }
    function getAllWithdraw(){
        $sql="select * from withdraw ";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }


    }
    function allOptions(){
        $sql="select * from add_options";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }

    }
    function getMyRefferaluser($code){
        $sql="select * from users where from_referral_code='$code' ";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }
    function checkChatStarted($reciver_id,$job_id){

        $my_id=$_SESSION['user_id'];

        $sql="select * from  user_chat where ((sender_id='$my_id' and receiver_id='$reciver_id')
                           OR (sender_id='$reciver_id' and receiver_id='$my_id')) and job_id='$job_id' ";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }

    }

    function getMyChatUsers(){
        $my_id=$_SESSION['user_id'];
        $sql="select * from  user_chat where (sender_id='$my_id' or receiver_id = '$my_id')
                           and ( `delete1` != '$my_id' and `delete2` !='$my_id' ) order by last_activity desc ";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }

    function getuserbyRefferal($code){
        $sql="select * from users where to_referral_code='$code' ";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }

    function getHomeOwnerRewards(){
        $sql="select * from homeowner_reward order by id desc ";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }
    function getAllHomeowners(){
        $sql="select * from users where user_role='home_owner' ";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }
    function getAllTradespersons(){
        $sql="select * from users where user_role='jobs_person' ";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }


    function getTradesPersonReward(){
        $sql="select * from tradesperson_reward order by id desc  ";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }

    function getSocialMediaLinks($user_id){

        $sql="select * from social_media_links  where user_id = '$user_id'  ";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }

    }
    function HomeOwnerRewards($date){

        $sql="select * from homeowner_reward where reward_date='$date' ";

        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }
    function checkDeleteStatus($touserid,$jobid,$userid){

        $sql="select * from user_chat where (sender_id='$userid' or receiver_id = '$userid') 
                          and (sender_id='$touserid' or receiver_id = '$touserid') and (job_id='$jobid') ";

        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
//        echo $this->db->getSql();
    }

    function TradesPersonReward($date){
        $sql="select * from tradesperson_reward where reward_date='$date' ";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }


    function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        $pass1=implode($pass);//turn the array into a string
        if($this->checktokenexist($pass1)){
            randomPassword();
        }else{
            return $pass1;
        }


    }
    function randomReferralCode() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 6; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        $pass1=implode($pass);//turn the array into a string
        if($this->CheckReferralCodeExists($pass1)){
            randomReferralCode();
        }else{
            return $pass1;
        }
    }
    function getUserByEmail($email){
        $sql="select * from users where email='$email' ";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }

    function CertificationVerifyMail($email){

        include_once "../phpmailer/sendmailfunction.php";

        $to = $email;
        $message = "We have successfully verified your documents.<br><br> To begin receiving leads, please ensure that you have completed the following steps:<br><br> 
                    1. Activate your subscription by visiting \"My Account\" and initiating your monthly direct debit payment.<br>
                    2. If you have not yet done so, kindly complete the quiz for your selected trade by navigating to \"My Profile\" and selecting your registered trade from the provided list.<br><br>
                    Once these requirements have been met, you may proceed to \"Leads\" to start applying for unlimited job opportunities.<br><br>
                    Welcome to Buildela, we wish you all the best in your business and we look forward to supporting you in achieving your goals.";
        $subject = "Thank you for choosing Buildela.";                             
        sendemailsmtp($to, $message, $subject);


    }

    function sendrecoveremail($email,$pass,$phone){

        include_once "../phpmailer/sendmailfunction.php";
        $link = '<a href="https://buildela.com/recover_password?resetpsw='.$pass.'">Reset password Link.</a>';

        $to = $email;
        $message = "You have requested to reset your password, please click on below link to reset your password. <br>".$link."<br><br> Thank you!";
        $subject = "Password recovery";
        sendemailsmtp($to, $message, $subject);
        $message1 = "You have requested to reset your password, please click on below link to your the password. \n https://buildela.com/recover_password?resetpsw=".$pass."\n Thank you!";

//        $this->sendMessageOnMobile($message1,$phone);
    }

    function UserApplyemail($appliedUsername,$appliedUsereID,$jobTitle,$toUseremail,$toUserPhone){
        include_once "../phpmailer/sendmailfunction.php";
        $to = $toUseremail;
        $subject = "Great news, " .$appliedUsername. " has expressed interest in your job.";
        $link = '<a target="_blank" href="https://buildela.com/user-profile?u_id='.$appliedUsereID.'">'.$appliedUsername.'.</a>';

        $site_link='<a target="_blank"  href="https://buildela.com/">Buildela.com</a> ';
        $message="Congratulations! ".$appliedUsername." has shown interest in your ".$jobTitle." Job posting on ".$site_link." <br><br>We encourage you to review their profile by clicking on the provided link ".$link."
                 <br><br>To ensure the best fit for your project, we recommend shortlisting up to five of your top choices from the list of interested tradespeople, and discussing the job further with them before making a final decision on who to hire.
                 <br><br>Once you have made a decision on the trade person to hire for your project, simply press the Hire button on their profile. Then, wait for them to accept your job request and begin the project.";
        sendemailsmtp($to, $message, $subject);

        $message1="Congratulations! ".$appliedUsername." has shown interest in your ".$jobTitle." job posting on https://buildela.com/. We encourage you to review their profile by clicking on the provided link https://buildela.com/user-profile?u_id=".$appliedUsereID.".
                 \nTo ensure the best fit for your project, we recommend shortlisting up to five of your top choices from the list of interested tradespeople, and discussing the job further with them before making a final decision on who to hire.
                 \nOnce you have made a decision on the trade person to hire for your project, simply press the Hire button on their profile. Then, wait for them to accept your job request and begin the project.";
    //    $this->sendMessageOnMobile($message1,$toUserPhone);
    }
    function UserChatemail($jobtitle,$homeownername,$appliedUsername,$toUseremail,$toUserPhone){
        include_once "../phpmailer/sendmailfunction.php";
        $message1="";
        $to = $toUseremail;
        $subject = " Hey ".$appliedUsername.", ".$homeownername." has messaged you regarding their job";

        $link='<a target="_blank" href="https://buildela.com/chat">View Chat.</a>';
        $site_link='<a target="_blank" href="https://buildela.com/">Buildela.com</a> ';


        $message= " Hello " .$appliedUsername.", you have received a message regarding the job: ".$jobtitle." on ".$site_link."<br><br> 
                ".$message1."<br> To respond, please visit the chat via the site ".$link." or the Buildela app ".$link;
     //   sendemailsmtp($to, $message, $subject);

        $message2="Hello, you have received a message regarding your job ".$jobtitle." on https://buildela.com/ from ".$homeownername."\nThe message reads:\n 
                ".$message1."\n To respond, please visit the chat via the site https://buildela.com/chat or the Buildela app https://buildela.com/chat";

//        $this->sendMessageOnMobile($message2,$toUserPhone);
    }

    function jobaccpetemail($jobtitle,$homeownerPhone,$homeowneremail,$tradespersonname){
        include_once "../phpmailer/sendmailfunction.php";
        $to = $homeowneremail;
        $subject = "Fantastic, ".$tradespersonname." has accepted your job.";
        $link = '<a target="_blank" href="https://buildela.com/homeowner-reward">Buildela Gives Away All Inclusive Holidays & More</a>';
        $site_link='<a target="_blank"  href="https://buildela.com/">Buildela.com</a> ';

        $message=nl2br("Fantastic, ".$tradespersonname." has accepted your job for ".$jobtitle." on ".$site_link."\n\nRemember to leave feedback on how your job went to win the chance of receiving one of our fantastic rewards. Check out our rewards here.\n\n".$link);
        sendemailsmtp($to, $message, $subject);
        $message1= "\n\nFantastic, ".$tradespersonname." has accepted your job for ".$jobtitle." on https://buildela.com \n\nRemember to leave feedback on how your job went to win the chance of receiving one of our fantastic rewards.\n\nhttps://buildela.com/homeowner-reward";

        $this->sendMessageOnMobile($message1,$homeownerPhone);

    }

    function UserShortlistedemail($jobTitle,$jobid,$toUseremail,$toUserePhone,$toUsereID,$homeownername,$homeownerid){
        include_once "../phpmailer/sendmailfunction.php";
        $notification=$this->getMyNotificationSetting($toUsereID);
        $to = $toUseremail;
        $subject = "Fantastic news, ".$homeownername." has shortlisted you.";
        $link = '<a target="_blank" href="https://buildela.com/chat?touserid='.$homeownerid.'&jobid='.$jobid.'"> Chat</a>';
        $site_link='<a target="_blank" href="https://buildela.com/">Buildela.com</a> ';

        $message=nl2br("Great job, ".$homeownername." has shortlisted you for their job: ".$jobTitle." on ".$site_link."\n <br><br>Please click on the link to discuss a quote and secure the job ".$link);
       if( (!empty($notification)) && ($notification[0]['shortlist_email']=='true')){
           sendemailsmtp($to, $message, $subject);
       }


        $message1="Great job, ".$homeownername." has shortlisted you for their job: ".$jobTitle." on https://buildela.com/.\n Please click on the link to discuss a quote and secure the job. https://buildela.com/chat?touserid=".$homeownerid."&jobid=".$jobid;
        if( (!empty($notification)) && ($notification[0]['shortlist_phone']=='true')){
            $this->sendMessageOnMobile($message1,$toUserePhone);
        }


    }

    function UserHireemail($jobid,$toUsername,$toUseremail,$toUserePhone,$toUsereID,$homeownerid,$homeownername){
        include_once "../phpmailer/sendmailfunction.php";
        $notification=$this->getMyNotificationSetting($toUsereID);
        $to = $toUseremail;
        $subject = "Congratulations ".$toUsername."! ".$homeownername." has hired you.";
        $link1 = '<a target="_blank" href="https://buildela.com/chat?touserid='.$homeownerid.'&jobid='.$jobid.'"> Chat</a>';
        $link2 = '<a target="_blank" href="https://buildela.com/leads?filter=2"> Complete job</a>';

        $message= nl2br("We're confident you'll do a fantastic job.<br><br> Remember, giving your best effort will help you receive positive feedback and more jobs in the future.\n Please click on the link below to mark the job as complete once you've finished, so that ".$toUsername." can leave you some feedback.\n".$link1."\n ".$link2);
        if( (!empty($notification)) && ($notification[0]['hired_email']=='true')){
            sendemailsmtp($to, $message, $subject);
        }

        $message1= " \n\n Congratulations ".$toUsername.", ".$homeownername." has hired you.\n\nWe're confident that you'll do a fantastic job.\n\nRemember, giving your best effort will help you receive positive feedback and more jobs in the future.\n\nOnce you've finished the job, please click on the link below to mark the job as complete, so that ".$homeownername." can leave you some feedback.\nhttps://buildela.com/chat?touserid=".$homeownerid."&jobid=".$jobid."\n\n https://buildela.com/leads?filter=2";

        if( (!empty($notification)) && ($notification[0]['hired_phone']=='true')){
            $this->sendMessageOnMobile($message1,$toUserePhone);
        }


    }

    function jobCompletedmail($jobtitle,$jobid,$toUsername,$toUserePhone,$toUseremail){
        include_once "../phpmailer/sendmailfunction.php";
        $to = $toUseremail;
        $subject = "Job Completion - ".$jobtitle;
        $site_link='<a target="_blank"  href="https://buildela.com/">Buildela.com</a> ';
        $link='<a target="_blank"  href="https://buildela.com/my-posted-jobs-details?job_id='.$jobid.'">Leave feedback</a> ';

        $message= nl2br("<b>Congratulations, ".$toUsername." has successfully completed your ".$jobtitle." for you.<br><br>As a valued customer of ".$site_link.", we would greatly appreciate it if you could take a moment to leave your feedback on how your job went.<br><br>By doing so, you will be entered into both our monthly and yearly draws, for a chance to win one of our amazing rewards that include All Inclisive family holidays, Brand new cars & more.<br><br>To leave your feedback, please click on this link: ".$link." <br><br>We hope that your experience with us was positive and that you will consider using our services again in the future.<br><br>Thank you for choosing ".$site_link);
        sendemailsmtp($to, $message, $subject);

        $message1= "\nCongratulations, ".$toUsername." has successfully\n
            completed your ".$jobtitle." for you. As a valued customer of https://buildela.com/, we would greatly appreciate it if you could take a moment to leave your feedback on how your job went.\nBy doing so, you will be entered into a monthly and yearly draw for a chance to win one of our amazing rewards that include holidays, brand new cars & more.\nTo leave your feedback, please click on this link: https://buildela.com/my-posted-jobs-details?job_id=".$jobid.".\nWe hope that your experience with us was positive and that you will consider using our services again in the future.\nThank you for choosing https://buildela.com/";

//        $this->sendMessageOnMobile($message1,$toUserePhone);
    }

    function UserFeedbackEmail($jobtitle,$homeownername,$jobspersonPhone,$toUsereID,$jobspersonemail){
        include_once "../phpmailer/sendmailfunction.php";
        $notification=$this->getMyNotificationSetting($toUsereID);
        $to = $jobspersonemail;
        $subject = "Hey, ".$homeownername." has left feedback on how the job went";
        $message= nl2br($homeownername." has provided feedback on the job: ".$jobtitle.". In regards to positive feedback, we encourage you to thank the customer for their kind words and appreciation of your work.\n\nOn the other hand, if the feedback is negative, we recommend expressing regret and providing an explanation of the situation from your perspective in order to address any concerns.");

        if( (!empty($notification)) && ($notification[0]['feedback_email']=='true')){
            sendemailsmtp($to, $message, $subject);
        }


        $message1= $homeownername." has provided feedback on the job: ".$jobtitle.". In regards to positive feedback, we encourage you to thank the customer for their kind words and appreciation of your work.\nOn the other hand, if the feedback is negative, we recommend expressing regret and providing an explanation of the situation from your perspective in order to address any concerns.";
        if( (!empty($notification)) && ($notification[0]['feedback_phone']=='true')){
            $this->sendMessageOnMobile($message1,$jobspersonPhone);
        }

    }
    function sendNewJobEmailToSelecteduser($questions,$jobdescription,$jobCategory,$homeownername,$jobspersonPhone,$toUsereID,$jobspersonemail){

        include_once "../phpmailer/sendmailfunction.php";
        $notification=$this->getMyNotificationSetting($toUsereID);
        $to = $jobspersonemail;
        $subject = $homeownername." needs a ".$jobCategory;
        $site_link='<a target="_blank"  href="https://buildela.com/">Buildela.com</a> ';
        $link='<a target="_blank"  href="https://buildela.com/leads">Express interest.</a> ';
        $link_reward_page = '<a target="_blank" href="https://buildela.com/trademember-reward">View Reward.</a>';


        $message= nl2br($jobdescription."\nIf you're interested, simply express interest by visiting lead page or by clicking the express interest button below.
        \nProject details:\n".$questions."\n
        We are excited to inform you that as a member of our platform, you have the opportunity to apply for as many jobs as you desire and have the potential to win unlimited job offers.
        \nThis is all included in your monthly subscription, providing you with the peace of mind that there will be no additional costs.
        \nAlongside this we giveaway monthly and yearly rewards to our members to show appreciation for choosing ".$site_link.".
        \nPlease visit our rewards page to find out more. ".$link_reward_page."
        \nTake advantage of this opportunity and apply for an unlimited amount jobs that align with your skills and experience. We wish you all the best in finding local work and look forward to supporting you in your business journey.
        <br>".$link);

        if( (!empty($notification)) && ($notification[0]['new_lead_email']=='true')){
            sendemailsmtp($to, $message, $subject);
        }
        $message1= $jobdescription."\nIf you're interested, simply express interest by visiting lead page or by clicking the express interest button below.
        \nProject details:\n".$questions."\n
        We are excited to inform you that as a member of our platform, you have the opportunity to apply for as many jobs as you desire and have the potential to win unlimited job offers.
        \nThis is all included in your monthly subscription, providing you with the peace of mind that there will be no additional costs.
        \nAlongside this we giveaway monthly and yearly rewards to our members to show appreciation for choosing https://buildela.com/s.
        \nPlease visit our rewards page to find out more. https://buildela.com/trademember-reward
        \nTake advantage of this opportunity and apply for an unlimited amount jobs that align with your skills and experience. We wish you all the best in finding local work and look forward to supporting you in your business journey.
        \nhttps://buildela.com/leads";

        if( (!empty($notification)) && ($notification[0]['new_lead_phone']=='true')){
            $this->sendMessageOnMobile($message1,$jobspersonPhone);
        }

    }

    function sendRewardEmail($name,$email,$reward_type){

        include_once "../phpmailer/sendmailfunction.php";
        $to = $email;
        $message = "Dear $name! We hope this email finds you in high spirits. We are thrilled to announce that you have been selected as a winner in our latest giveaway! <br><br>Congratulations on this achievement!<br><br>

After careful consideration, you have been chosen as a lucky recipient of one of our exciting rewards. Your participation in using our service has truly paid off, and we are delighted to extend this token of appreciation to you.<br><br>

Without further ado, we are pleased to inform you that you have won our $reward_type reward. To claim this, please follow these simple instructions:<br><br>

    1. Respond to this email by providing us with your up-to-date mobile number and mailing address.<br>
    2. Include your mobile number and address in the body of the email, ensuring their accuracy.<br>
    3. Double-check that the provided information is correct, as any errors may delay the delivery of your reward.<br><br>

Please respond with the requested details no later than 30 days to ensure the smooth processing and delivery of your prize. Once we receive your information, our team will verify it and make arrangements for the reward to be sent to you.<br><br>

Once again, we would like to extend our warmest congratulations on your accomplishment. We deeply appreciate your participation in our contest and hope that this experience has been enjoyable for you. We are grateful for your continued support and look forward to your future engagement with our brand.<br><br>

Should you have any questions or require further assistance, please feel free to reply to this email. We are more than happy to help!<br><br>

Thank you for being a part of our community, and we wish you all the best in your future endeavors. <br><br>
Sincerely,"; 


        $subject = "Congratulations $name, You've Won Our Giveaway!";
        sendemailsmtp($to, $message, $subject);
    }
function sendNewBlogNotification($email,$link,$image,$title,$short_des){
    include_once "../phpmailer/sendmailfunction.php";
    $to = $email;

    $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html data-editor-version="2" class="sg-campaigns" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <!--user entered Head Start--><link href="https://fonts.googleapis.com/css?family=Chivo&display=swap" rel="stylesheet"><style>
    body {font-family: "Chivo", sans-serif;}
  </style><!--End Head user entered-->
</head>
<body>
  <center class="wrapper" data-link-color="#1188E6" data-body-style="font-size:14px; font-family:inherit; color:#000000; background-color:#FFFFFF;">
    <div class="webkit">
      <table cellpadding="0" cellspacing="0" border="0" width="100%" class="wrapper" bgcolor="#FFFFFF">
        <tr>
          <td valign="top" bgcolor="#FFFFFF" width="100%">
            <table width="100%" role="content-container" class="outer" align="center" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td width="100%">
                  <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                      <td>
      <table width="100%" cellpadding="0" cellspacing="0" border="0" style="width:100%; max-width:600px;" align="center">
        <tr>
          <td role="modules-container" style="padding:0px 0px 0px 0px; color:#000000; text-align:left;" bgcolor="#FFFFFF" width="100%" align="left"><table class="module preheader preheader-hide" role="module" data-type="preheader" border="0" cellpadding="0" cellspacing="0" width="100%" style="display: none !important; mso-hide: all; visibility: hidden; opacity: 0; color: transparent; height: 0; width: 0;">
            <tr>
              <td role="module-content">
                <p></p>
              </td>
            </tr>
          </table><table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" role="module" data-type="columns" style="padding:30px 20px 30px 30px;" bgcolor="#f7f9f5" data-distribution="1">
            <tbody>
              <tr role="module-content">
                <td height="100%" valign="top"><table width="530" style="width:530px; border-spacing:0; border-collapse:collapse; margin:0px 10px 0px 10px;" cellpadding="0" cellspacing="0" align="left" border="0" bgcolor="" class="column column-0">
                  <tbody>
                    <tr>
                      <td style="padding:0px;margin:0px;border-spacing:0;"><table class="wrapper" role="module" data-type="image" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="4740d4a3-815f-419b-9116-37d2b61f2d83">
                        <tbody>
                          <tr>
                            <td style="font-size:6px; line-height:10px; padding:0px 0px 0px 0px;" valign="top" align="center">
                             <a href="https://buildela.com/"> <img class="max-width" border="0" style="display:block; color:#000000; text-decoration:none; font-family:Helvetica, arial, sans-serif; font-size:16px; max-width:100% !important; width:100%; height:auto !important;" width="530" alt="" data-proportionally-constrained="true" data-responsive="true" src="https://hellolandlord.co.uk/images/emailheaderlogo.png"></a> 
                            </td>
                          </tr>
                        </tbody>
                      </table></td>
                    </tr>
                  </tbody>
                </table></td>
              </tr>
            </tbody>
          </table><table class="module" role="module" data-type="divider" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="2d3862ba-e4da-4865-8605-53fb723d695b">
            <tbody>
              <tr>
                <td style="padding:0px 0px 0px 0px;" role="module-content" height="100%" valign="top" bgcolor="">
                  <table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" height="1px" style="line-height:1px; font-size:1px;">
                    <tbody>
                      <tr>
                        <td style="padding:0px 0px 1px 0px;" bgcolor="#e2efd4"></td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table><table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" role="module" data-type="columns" style="padding:30px 20px 40px 30px;" bgcolor="#f7f9f5" data-distribution="1">
            <tbody>
              <tr role="module-content">
                <td height="100%" valign="top"><table width="530" style="width:530px; border-spacing:0; border-collapse:collapse; margin:0px 10px 0px 10px;" cellpadding="0" cellspacing="0" align="left" border="0" bgcolor="" class="column column-0">
                  <tbody>
                    <tr>
                      <td style="padding:0px;margin:0px;border-spacing:0;"><table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="8c54c8a5-caee-4b33-b6b0-e8aaed51c545" data-mc-module-version="2019-10-22">
                        <tbody>
                          <tr>
                            <td style="padding:18px 10px 18px 10px; line-height:32px; text-align:inherit;" height="100%" valign="top" bgcolor="" role="module-content"><div><div style="font-family: inherit; text-align: center"><span style="color: #79a6ff; font-size: 50px">'.$title.'</span></div><div></div></div></td>
                          </tr>
                        </tbody>
                      </table><table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="6cf92250-86a4-41d8-865a-ae5fb2569556.1" data-mc-module-version="2019-10-22">
                        <tbody>
                          <tr>
                            <td style="padding:0px 0px 18px 0px; line-height:22px; text-align:inherit;" height="100%" valign="top" bgcolor="" role="module-content"><div><div style="font-family: inherit; text-align: center">'.$short_des.'</div>
                              <div style="font-family: inherit; text-align: center"></div><div></div></div></td>
                            </tr>
                          </tbody>
                        </table><table class="wrapper" role="module" data-type="image" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="3923e4a3-acc3-4c88-bb58-8e5cd32f0162">
                          <tbody>
                            <tr>
                              <td style="font-size:6px; line-height:10px; padding:0px 0px 0px 0px;" valign="top" align="center">
                                <img class="max-width" border="0" style="display:block; color:#000000; text-decoration:none; font-family:Helvetica, arial, sans-serif; font-size:16px; max-width:70% !important; width:70%; height:auto !important;" width="NaN" alt="" data-proportionally-constrained="true" data-responsive="true" src="'.$image.'">
                              </td>
                            </tr>
                          </tbody>
                        </table><table class="module" role="module" data-type="spacer" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="2edb1546-1598-49eb-995c-baf7d429f31c.1">
                          <tbody>
                            <tr>
                              <td style="padding:0px 0px 30px 0px;" role="module-content" bgcolor="">
                              </td>
                            </tr>
                          </tbody>
                        </table><table border="0" cellpadding="0" cellspacing="0" class="module" data-role="module-button" data-type="button" role="module" style="table-layout:fixed;" width="100%" data-muid="4bcb53df-57db-48a5-9aa3-4060ac494a64.1">
                          <tbody>
                            <tr>
                              <td align="center" bgcolor="" class="outer-td" style="padding:0px 0px 0px 0px;">
                                <table border="0" cellpadding="0" cellspacing="0" class="wrapper-mobile" style="text-align:center;">
                                  <tbody>
                                    <tr>
                                      <td align="center" bgcolor="#79a6ff" class="inner-td" style="border-radius:6px; font-size:16px; text-align:center; background-color:inherit;">
                                        <a href="'.$link.'" style="background-color:#79a6ff; border:1px solid #79a6ff; border-color:#79a6ff; border-radius:0px; border-width:1px; color:#ffffff; display:inline-block; font-size:14px; font-weight:normal; letter-spacing:0px; line-height:normal; padding:12px 60px 12px 60px; text-align:center; text-decoration:none; border-style:solid;" target="_blank">View post</a>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table></td>
                      </tr>
                    </tbody>
                  </table></td>
                </tr>
              </tbody>
            </table><table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="ba2cc448-1854-4e31-b50f-551e3101d5b2" data-mc-module-version="2019-10-22">
              <tbody>
                <tr>
                  <td style="padding:40px 30px 40px 30px; line-height:22px; text-align:inherit; background-color:#79a6ff;" height="100%" valign="top" bgcolor="#79a6ff" role="module-content"><div><div style="font-family: inherit; text-align: center"><span style="color: #ffffff">Need help with any of our features? Questions about accounts or billing?</span></div>
                    <div style="font-family: inherit; text-align: center"><span style="color: #ffffff">We\'re here to help. Our customer services team are available. <br> <span style="text-align: center; ">09:00 - 17:00 Monday - Friday</span></span></div>
                    <div style="font-family: inherit; text-align: center"><br></div>
                    <div style="font-family: inherit; text-align: center"><a href="https://buildela.com/contact-us"><span style="color: #ffffff"><u><strong>Contact Us</strong></u></span></a></div><div></div></div></td>
                  </tr>
                </tbody>
              </table></td>
            </tr>
          </table>

                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </div>
      </center>
    </body>
    </html>';

    $subject = "".$title;
    sendemailsmtp($to, $message, $subject);
}

    function getplans($type = null, $all = true){
        $sql ="select * from plans";
        if($this->db->sql($sql)){
            if(!$all){
                $plans = $this->db->getResult();            
                if($plans) {
                    foreach($plans as $plan) {
                        if($plan['type'] === $type) return $plan['price'];
                        else false;
                    }
                }
            }else {
                return $this->db->getResult(); 
            }
        }else{
            return false;
        }
    }

    function getSettings(){
        $sql ="select * from settings";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }else{
            return $this->db->getSql();
        }
    }
    function sendNewJobEmail(){
        $alljobs=$this->getJobsFormail();
        $users=$this->getAllUsers();

        foreach ($alljobs as $job1){
            foreach ($users as $user){

                $jobs=$this->getMatchJobs($user['id']);
                foreach ($jobs as $job){
                    if($job['id']==$job1['id']) {
                        $main_category=$this->SingleMainCategory($job['main_type']);
                        $homeowner=$this->UserInfo($job['user_id']);

                        $job_post_code = preg_replace('/\s+/', '', $job['post_code']);
                        $user_post_code = preg_replace('/\s+/', '', $user['post_code']);

                        $distance = $this->DistanceCalculation($user_post_code, $job_post_code);                        

                        if ($distance <= $user['distance']) {
                            $questions = "";
                            $this->sendNewJobEmailToSelecteduser($questions, $job['job_discription'],$main_category[0]['category_name'],$homeowner[0]['fname'],$user['phone'],$user['id'], $user['email']);

                        }
                    }
                }//foreach
            }//users
            $this->updateJobEmailStatus($job1['id']);
        }//$alljobs

    }
    function sendNewUserEmail()
    {
        $users= $this->getAllUsers();
        foreach ($users as $user){
            if($user['subscription_status'] && strcmp($user['user_role'], 'jobs_person') == 0){
                $id = $user['id'];
                $email = $user['email'];
                $day = $user['email_days_left'];
                $name = $user['fname'];
                $day = (int)$day + 1;
                if($day<8 && !empty($email)){
                    $this->sendEmailtoNewUser($id,$day,$email,$name);
                    // $this->sendEmailtoNewUser($id,$day,"chaidy550@gmail.com",$name);
                    die();                
                }                
            }

        }
    }
    function sendEmailtoNewUser($id,$day,$email,$name)
    {
        $email_signature = '<div><style>.sh-src a{text-decoration:none!important;}</style></div> <br> <table cellpadding="0" cellspacing="0" border="0" class="sh-src" style="margin: 0px; border-collapse: collapse;"><!----> <tr><td style="padding: 0px 1px 5px 0px; font-family: Tahoma, sans-serif; font-size: 11px; line-height: 14px; white-space: nowrap;"><!----> <!----> <p style="font-family: Tahoma, sans-serif; font-size: 11px; line-height: 14px; white-space: nowrap; color: rgb(136,136,136); margin: 1px;">Customer Support</p> <p style="font-family: Tahoma, sans-serif; font-size: 11px; line-height: 14px; white-space: nowrap; color: rgb(136,136,136); margin: 1px;">Buildela</p></td></tr> <tr><td style="padding: 0px 1px 0px 0px;"><table cellpadding="0" cellspacing="0" border="0" style="margin: 0px; border-collapse: collapse;"><tr><td style="padding: 5px 1px 5px 0px; border-top-width: 2px; border-top-style: solid; border-top-color: rgb(0,123,255); border-bottom-width: 2px; border-bottom-style: solid; border-bottom-color: rgb(0,123,255);"><table cellpadding="0" cellspacing="0" border="0" style="margin: 0px; border-collapse: collapse;"><tr><td valign="middle" style="padding: 0px 14px 0px 0px;"><table cellpadding="0" cellspacing="0" border="0" style="margin: 0px; border-collapse: collapse;"><tr><td style="padding: 0px 1px 0px 0px;"><p style="margin: 1px;"><a href="https://buildela.com/" target="_blank"><img src="https://signaturehound.com/api/v1/file/2fdmjnlcdz570o" alt="" title="Logo" width="150" height="28" style="display: block; border: 0px; max-width: 150px;"></a></p></td></tr></table></td> <td width="10" style="padding: 0px 1px 0px 0px;"></td> <td style="padding: 0px 1px 0px 0px;"><table cellpadding="0" cellspacing="0" border="0" style="margin: 0px; border-collapse: collapse;"><tr><td valign="middle" style="padding: 1px 5px 1px 0px; vertical-align: middle;"><p style="margin: 1px;"><img src="https://signaturehound.com/api/v1/png/email/square/007bff.png" alt="" width="19" height="19" style="display: block; border: 0px; max-width: 19px;"></p></td> <td style="font-family: Tahoma, sans-serif; font-size: 11px; line-height: 14px; white-space: nowrap; color: rgb(136,136,135) !important; padding: 1px 0px; vertical-align: middle;"><p style="margin: 1px;"><a href="mailto:info@buildela.com" target="_blank" style="font-family: Tahoma, sans-serif; font-size: 11px; line-height: 14px; white-space: nowrap; color: rgb(136,136,136); text-decoration: none !important;"><span style="font-family: Tahoma, sans-serif; font-size: 11px; line-height: 14px; white-space: nowrap; color: rgb(136,136,136); text-decoration: none !important;">info@buildela.com</span></a></p></td></tr>  <tr><td valign="top" style="padding: 1px 5px 1px 0px; vertical-align: top;"><p style="margin: 1px;"><img src="https://signaturehound.com/api/v1/png/map/square/007bff.png" alt="" width="19" height="19" style="display: block; border: 0px; max-width: 19px;"></p></td> <td style="font-family: Tahoma, sans-serif; font-size: 11px; line-height: 14px; white-space: nowrap; color: rgb(136,136,135) !important; padding: 1px 0px; vertical-align: middle;"><p style="margin: 1px;"><span style="font-family: Tahoma, sans-serif; font-size: 11px; line-height: 14px; white-space: nowrap; color: rgb(136,136,136); text-decoration: none !important;">124 City Road<br>London <br>EC1V 2NX<br></span></p></td></tr> <tr><td valign="middle" style="padding: 1px 5px 1px 0px; vertical-align: middle;"><p style="margin: 1px;"><img src="https://signaturehound.com/api/v1/png/website/square/007bff.png" alt="" width="19" height="19" style="display: block; border: 0px; max-width: 19px;"></p></td> <td style="font-family: Tahoma, sans-serif; font-size: 11px; line-height: 14px; white-space: nowrap; color: rgb(0,123,254) !important; font-weight: 700; padding: 1px 0px; vertical-align: middle;"><p style="margin: 1px;"><a href="https://buildela.com/" target="_blank" style="font-family: Tahoma, sans-serif; font-size: 11px; line-height: 14px; white-space: nowrap; color: rgb(0,123,255); font-weight: 700; text-decoration: none !important;"><span style="font-family: Tahoma, sans-serif; font-size: 11px; line-height: 14px; white-space: nowrap; color: rgb(0,123,255); font-weight: 700; text-decoration: none !important;">buildela.com</span></a></p></td></tr></table></td> <td width="15" style="padding: 0px 1px 0px 0px;"></td></tr></table></td></tr></table></td></tr> <tr><td style="padding: 0px 1px 0px 0px;"><table cellpadding="0" cellspacing="0" border="0" style="margin: 0px; border-collapse: collapse;"><tr><td width="28" style="font-size: 0px; line-height: 0px; padding: 5px 1px 0px 0px;"><p style="margin: 1px;"><a href="https://www.facebook.com/profile.php?id=100088727517545" target="_blank"><img src="https://signaturehound.com/api/v1/png/facebook/square/007bff.png" alt="" width="28" height="28" style="display: block; border: 0px; max-width: 28px;"></a></p></td> <td width="3" style="padding: 0px 0px 1px;"></td><td width="28" style="font-size: 0px; line-height: 0px; padding: 5px 1px 0px 0px;"><p style="margin: 1px;"><a href="https://twitter.com/BuildelaUK" target="_blank"><img src="https://signaturehound.com/api/v1/png/twitter/square/007bff.png" alt="" width="28" height="28" style="display: block; border: 0px; max-width: 28px;"></a></p></td> <td width="3" style="padding: 0px 0px 1px;"></td><td width="28" style="font-size: 0px; line-height: 0px; padding: 5px 1px 0px 0px;"><p style="margin: 1px;"><a href="https://www.instagram.com/buildelauk/" target="_blank"><img src="https://signaturehound.com/api/v1/png/instagram/square/007bff.png" alt="" width="28" height="28" style="display: block; border: 0px; max-width: 28px;"></a></p></td> <td width="3" style="padding: 0px 0px 1px;"></td><td width="28" style="font-size: 0px; line-height: 0px; padding: 5px 1px 0px 0px;"><p style="margin: 1px;"><a href="https://www.youtube.com/@buildela" target="_blank"><img src="https://signaturehound.com/api/v1/png/youtube/square/007bff.png" alt="" width="28" height="28" style="display: block; border: 0px; max-width: 28px;"></a></p></td> <td width="3" style="padding: 0px 0px 1px;"></td></tr></table></td></tr> <!----> <tr><td style="padding: 0px 1px 0px 0px;"><table cellpadding="0" cellspacing="0" border="0" style="max-width: 600px; margin: 0px; border-collapse: collapse;"><tr><td style="padding: 6px 1px 0px 0px; font-family: Tahoma, sans-serif; font-size: 10px; line-height: 13px; color: rgb(136,136,136);"><p style="font-family: Tahoma, sans-serif; font-size: 10px; line-height: 13px; color: rgb(136,136,136); margin: 1px;">The content of this email is confidential and intended for the recipient specified in message only. It is strictly forbidden to share any part of this message with any third party, without a written consent of the sender. If you received this message by mistake, please reply to this message and follow with its deletion, so that we can ensure such a mistake does not occur in the future.</p></td></tr></table></td></tr> <!----></table>';
        include_once "../phpmailer/sendmailfunction.php";
        switch ($day) {
                    case 1:
                        $to = $email;
                        $subject = 'Welcome to Buildela - Your Gateway to Unlimited Leads and Amazing Rewards!';


                        $message= nl2br('<div style="padding: 50px 0px;"><div style="max-width: 700px; margin: 0px auto; padding: 0px 15px;"><p style="font-size: 20px; margin: 0px; padding-bottom: 15px;">Dear '.$name.',</p>
                                    <p style="font-size: 17px; margin: 0px; line-height: 24px; padding-bottom: 15px;">Welcome to Buildela - the ultimate platform that empowers you with the tools to thrive in the construction trade industry! We are thrilled to have you on board and can\'t wait to show you all the incredible benefits and opportunities that await you as a valued member.</p>
                                    <p style="font-size: 17px; margin: 0px; padding-bottom: 15px; line-height: 22px;">At Buildela, our commitment is to serve our trade members like yourself and ensure you have access to unbeatable perks that will enhance your business and personal life. As promised, we are here to deliver on everything we offered when you joined, and we\'ll start by highlighting the fantastic benefits you can enjoy:</p>
                                    <div style="padding: 25px; background-color: #f3f4f5;"><p style="margin: 0px; font-size: 17px; line-height: 22px;"><span style="font-size: 28px; font-weight:800;display: block;text-align: center;margin-bottom: 15px;"> Unlimited Leads</span> Say goodbye to the struggle of finding leads! As a Buildela member, you now have access to an endless stream of high-quality leads, giving you the potential to grow your business like never before.</p><p style="margin: 0px; font-size: 17px; padding: 15px 0px; line-height: 22px;"><span style="font-size: 28px; font-weight:800;display: block;text-align: center;margin-bottom: 15px;"> Amazing Rewards</span> Get ready for some incredible surprises! By being a part of Buildela, you automatically enter our exclusive rewards program. You can win premier league tickets, all-inclusive family holidays, and Screwfix vouchers - just our way of saying "Thank You" for choosing us.</p><p style="margin: 0px; font-size: 17px; line-height: 22px;"><span style="font-size: 28px; font-weight:800;display: block;text-align: center;margin-bottom: 15px;"> Constantly Expanding Offers</span> Our focus is on your success! We continuously collaborate with relevant suppliers to bring exclusive offers and deals that directly benefit your business.</p></div>
                                    <p style="font-size: 17px; margin: 0px; padding-top: 15px; line-height: 22px;">As you embark on your journey with us, rest assured that we are dedicated to building a community that supports each other and thrives together. You can count on our friendly team to assist you at every step and provide any guidance you may need.</p>
                                    <p style="font-size: 17px; margin: 0px; padding-top: 15px; line-height: 22px;">Remember, Buildela is not just a platform; it\'s a network of like-minded professionals who share the same passion for the construction trade. We encourage you to explore the community forums, engage in discussions, and connect with other members - you never know what incredible opportunities may arise!</p>
                                    <p style="font-size: 17px; margin: 0px; padding-top: 15px; line-height: 22px;">If you have any questions or need assistance, don\'t hesitate to contact our support team. We are here to make your Buildela experience outstanding.</p>
                                    <p style="font-size: 17px; margin: 0px; padding-top: 15px; line-height: 22px;">Once again, welcome to Buildela! We are excited to have you with us and can\'t wait to see the remarkable achievements you\'ll accomplish as a member of our community.</p>
                                    <p style="font-size: 17px; margin: 0px; padding-top: 15px; line-height: 22px;">Best regards,</p><p style="font-size: 17px; margin: 0px; padding-top: 10px; line-height: 22px;">The Buildela Team</p>
                                '.$email_signature.'</div>
                            </div>
                            ');
                        sendemailsmtp($to, $message, $subject);
                    break;
                    case 2:
                        $to = $email;
                        $subject = ' Meet the Extraordinary Team Behind Buildela\'s Success!';


                        $message= nl2br('<div style="padding: 50px 0px;"><div style="max-width: 700px; margin: 0px auto; padding: 0px 15px;"><p style="font-size: 20px; margin: 0px; padding-bottom: 15px;">Dear '.$name.',</p>
                            <p style="font-size: 17px; margin: 0px; padding-bottom: 15px; line-height: 22px;">We hope this email finds you thrilled with your exciting journey with Buildela. As promised, we are back to share another important aspect that sets us apart - our incredible team of leaders devoted to serving our subscribers like you!</p>
                            <p style="font-size: 17px; margin: 0px; padding-bottom: 15px; line-height: 22px;">Here at Buildela, we firmly believe that people don\'t just buy products; they buy into the passion and expertise of the team behind those products. Our team is the driving force behind our success, and we can\'t wait to introduce you to the individuals who work tirelessly to deliver unparalleled value to each and every one of our members.</p>
                            <div style="padding: 25px; background-color: #f3f4f5;"><p style="margin: 0px; font-size: 17px; line-height: 22px;">Allow us to proudly present some of the key players who make Buildela possible:</p><p style="margin: 0px; padding: 15px 0px; font-size: 17px; line-height: 22px;">1. John Doe - CEO and Founder: With over two decades of experience in the construction industry, John\'s vision and passion laid the foundation for Buildela. His leadership and dedication inspire the entire team to push the boundaries of what\'s possible for our subscribers.</p><p style="margin: 0px; font-size: 17px; line-height: 22px;">2. Sarah Johnson - Head of Customer Success: Sarah\'s infectious enthusiasm and commitment to delivering exceptional experiences make her the perfect person to lead our customer success team. She\'s always ready to go the extra mile to ensure our subscribers achieve their goals.</p><p  style="margin: 0px; padding: 15px 0px; font-size: 17px; line-height: 22px;">3. Michael Lee - Lead Technical Architect: Behind our robust platform is Michael, the mastermind who designs and implements the technology that fuels Buildela\'s efficiency. His expertise guarantees you a seamless experience every step of the way.</p><p style="margin: 0px; font-size: 17px; line-height: 22px;">4. Emily Baker - Content Strategist: Emily\'s creative flair and deep understanding of the industry make her an invaluable asset. She curates and develops valuable content that equips you with the knowledge and insights to excel in your trade.</p><p  style="margin: 0px;font-size: 17px; padding-top: 15px; line-height: 22px;">5. Alex Turner - Community Manager: Alex is the heart and soul of our thriving community. With a passion for bringing people together, he ensures our forums and groups buzz with helpful discussions and meaningful connections.</p></div>
                            <p style="font-size: 17px; margin: 0px; padding-top: 15px; line-height: 22px;">Each member of our team brings a unique set of skills and experiences, and together, we are united by a common goal: to see you succeed. Your achievements and growth drive us daily, and we are committed to providing you with nothing less than excellence.</p>
                            <p style="font-size: 17px; margin: 0px; padding-top: 15px; line-height: 22px;">Knowing the faces and stories behind our team creates a strong bond between you and Buildela. We want you to feel confident that our team is knowledgeable and deeply invested in your progress. Appreciating the efforts of those working on your behalf fosters a sense of respect and collaboration that fuels even more outstanding results.</p>
                            <p style="font-size: 17px; margin: 0px; padding-top: 15px; line-height: 22px;">As you continue exploring Buildela, don\'t hesitate to reach out to any team member if you have questions, ideas or want to say hello. We are all here to support you in your journey to success!</p>
                            <p style="font-size: 17px; margin: 0px; padding-top: 15px; line-height: 22px;">Thank you for being a part of our vibrant community. Together, we\'ll build a brighter future for the construction trade industry.</p>
                            <p style="font-size: 17px; margin: 0px; padding-top: 15px; line-height: 22px;">Best regards,</p><p style="font-size: 17px; margin: 0px; padding-top: 10px; line-height: 22px;">The Buildela Team</p>
                            '.$email_signature.'
                        </div>
                    </div>');
                        sendemailsmtp($to, $message, $subject);
                    break;
                    case 3:
                        $to = $email;
                        $subject = 'Your Secret to Success: Buildela - Where One Job Covers Your Entire Subscription!';


                        $message= nl2br('<div style="padding: 50px 0px;"><div style="max-width: 700px; margin: 0px auto; padding: 0px 15px;"><p style="font-size: 20px; margin: 0px; padding-bottom: 15px;">Dear '.$name.',</p>
                            <p style="font-size: 17px;color:#000; margin: 0px; padding-bottom: 15px; line-height: 22px;">We hope you\'ve been enjoying your time on Buildela, discovering all the fantastic opportunities the platform has to offer. As we celebrate your journey with us, we want to add a little extra sparkle to your experience by giving you a quick win that will leave you feeling excited and confident about the value Buildela brings to your professional life.</p>
                            <div style="padding: 25px; background-color: #f3f4f5;"><p style="margin: 0px; font-size: 17px;color:#000; line-height: 22px;"><span style="font-size: 20px; font-weight:800;text-align: center;display: block;margin-bottom: 15px;color: #000;">🏆 Your Quick Win: Access to Our Quarterly Magazine! 🏆</span> We\'re thrilled to present you with a valuable resource that will save you money and keep you informed and inspired in your trade. You now have exclusive access to our quarterly magazine, filled to the brim with fantastic offers on various trade-relevant goods. These irresistible deals will help you save big on your business expenses, giving you an instant win that showcases the tangible value of your Buildela subscription. But that\'s not all - our magazine offers captivating reads, industry insights, and opportunities to feature your work and expertise. It\'s a hub of inspiration, knowledge, and rewards, specially crafted to empower you on your journey to success.</p><p style="margin: 0px; font-size: 17px;color:#000; padding: 15px 0px; line-height: 22px;"><span style="font-size: 20px; font-weight:800;text-align: center;display: block;margin-bottom: 15px;color: #000;">💡 The Power of Your Quick Win: Proof of Buildela\'s Value 💡</span> When someone questions the value of your Buildela subscription - be it a mate, a business partner, or anyone curious about your investment - you can proudly point to the quick win you\'ve already achieved. With access to our quarterly magazine and the incredible offers, you\'re already reaping the rewards of being a Buildela member. This quick win is just the start of the exciting benefits you\'ll enjoy on our platform.</p><p  style="margin: 0px; font-size: 17px;color:#000; line-height: 22px;"><span style="font-size: 20px; font-weight:800;text-align: center;display: block;margin-bottom: 15px;color: #000;">🎁 The Path Ahead: More Rewards Await You! 🎁</span> We\'re genuinely grateful to have you as part of our community, and we\'re dedicated to ensuring your continued success. The quarterly magazine is just one example of the many rewards and opportunities that Buildela has in store for you. As you actively engage with the platform, you\'ll unlock even more ways to grow your business, save money, and make valuable connections with like-minded professionals.</p></div>
                            <p style="font-size: 17px;color:#000; margin: 0px; padding-top: 15px; line-height: 22px;">Embrace your quick win, and let it be the first stepping stone to an extraordinary journey with Buildela! Thank you for choosing Buildela - your gateway to unlimited leads, incredible rewards, and boundless possibilities in the construction trade industry.</p>
                            <p style="font-size: 17px;color:#000; margin: 0px; padding-top: 15px; line-height: 22px;">Best regards,</p><p style="font-size: 17px; margin: 0px; padding-top: 10px; line-height: 22px;">The Buildela Team</p>
                            '.$email_signature.'
                        </div>
                    </div>');
                        sendemailsmtp($to, $message, $subject);
                    break;
                    case 4:
                        $to = $email;
                        $subject = 'Debunking Myths: Unleash Your True Potential with Buildela!';


                        $message= nl2br('<div style="padding: 50px 0px;"><div style="max-width: 700px; margin: 0px auto; padding: 0px 15px;"><p style="font-size: 20px; margin: 0px; padding-bottom: 15px;">Dear '.$name.',</p>
                            <p style="font-size: 17px; margin: 0px; padding-bottom: 15px; line-height: 22px;">As we continue our incredible journey together on Buildela, we want to address some common misconceptions that might be lingering in your mind. It\'s not uncommon for subscribers to have preconceived beliefs about solutions like ours, especially if they\'ve tried other tools in the past. We\'re here to shed light on these false beliefs and show you why Buildela is the game-changer you\'ve been waiting for!</p>
                            <div style="padding: 25px; background-color: #f3f4f5;"><p style="margin: 0px; font-size: 17px; line-height: 22px;">🚫 Myth #1: "I\'ve tried similar platforms before, and they didn\'t work for me." Reality: We understand that past experiences may have left you sceptical, but Buildela is unlike anything you\'ve encountered before. Our platform is carefully designed with your success in mind. We offer a powerful suite of tools, unlimited leads, and a supportive community that sets us apart from any other solution out there. Give Buildela a chance, and you\'ll quickly discover why our subscribers have achieved remarkable results with our platform.</p><p style="margin: 0px; font-size: 17px; padding: 15px 0px; line-height: 22px;">🚫 Myth #2: "I\'m not sure if I can compete with other professionals on Buildela." Reality: Building your reputation on any platform takes time, but with dedication and our support, you\'ll thrive on Buildela. Our platform empowers you to showcase your skills, experience, and projects to stand out in the crowd. Remember, like you, every successful professional on Buildela started from scratch. Embrace the opportunity, engage with the community, and watch your profile grow into a valuable asset that attracts clients and projects.</p><p  style="margin: 0px; font-size: 17px; line-height: 22px;">🚫 Myth #3: "I might not find enough opportunities in my area." Reality: Buildela\'s reach extends far and wide, and we actively work on bringing in thousands of leads per month from various locations. Whether you\'re a local expert or open to exploring opportunities in new territories, Buildela offers diverse projects to suit your preferences. Our platform connects you with clients from different regions, ensuring your chances of finding the perfect fit for your skills and expertise.<p><p style="margin: 0px; font-size: 17px; padding: 15px 0px; line-height: 22px;">🚫 Myth #4: "I don\'t have enough time to invest in a new platform." Reality: We understand that time is precious, but consider this - by dedicating time to perfecting your profile and engaging with our community, you\'re making an investment in your future success. The more effort you put in initially, the more rewards you\'ll reap down the line. Buildela is designed to streamline your lead generation process, making it easier and quicker to find the right projects. The time you invest now will save you countless hours searching for opportunities elsewhere.</p><p  style="margin: 0px; font-size: 17px; line-height: 22px;">🚫 Myth #5: "I\'m not tech-savvy enough to use Buildela effectively." Reality: Don\'t let technology hold you back! Buildela\'s user-friendly interface and intuitive tools are designed to be accessible to everyone, regardless of technical expertise. Our support team is always here to guide you through any challenges you may encounter. Embrace the learning curve, and you\'ll soon find yourself confidently navigating the platform to unlock your true potential.</p></div>
                            <p style="font-size: 17px; margin: 0px; padding-top: 15px; line-height: 22px;">Break free from these misconceptions and embrace the reality of what Buildela has to offer. Your subscription is a powerful solution to elevate your career and achieve unparalleled success in the construction trade industry. We\'re excited to see you thrive with Buildela and are here to support you at every step of your journey!</p>
                            <p style="font-size: 17px; margin: 0px; padding-top: 15px; line-height: 22px;">Best regards,</p><p style="font-size: 17px; margin: 0px; padding-top: 10px; line-height: 22px;">The Buildela Team</p>
                            '.$email_signature.'
                        </div>
                    </div>');
                        sendemailsmtp($to, $message, $subject);
                    break;
                    case 5:
                        $to = $email;
                        $subject = 'Congratulations! Your First Quick Win with Buildela Awaits!';


                        $message= nl2br('<div style="padding: 50px 0px;"><div style="max-width: 700px; margin: 0px auto; padding: 0px 15px;"><p style="font-size: 20px; margin: 0px; padding-bottom: 15px;">Dear '.$name.',</p>
                            <p style="font-size: 17px; margin: 0px; padding-bottom: 15px; line-height: 22px;">We hope you\'ve been enjoying your time on Buildela, discovering all the fantastic opportunities the platform has to offer. As we celebrate your journey with us, we want to add a little extra sparkle to your experience by giving you a quick win that will leave you feeling excited and confident about the value Buildela brings to your professional life.</p>
                            <div style="padding: 25px; background-color: #f3f4f5;"><p style="margin: 0px; font-size: 17px; line-height: 22px;"><span style="font-size: 20px; font-weight:800;text-align: center;display: block;margin-bottom: 15px;color: #000;">🏆 Your Quick Win: Access to Our Quarterly Magazine! 🏆</span> We\'re thrilled to present you with a valuable resource that will save you money and keep you informed and inspired in your trade. You now have exclusive access to our quarterly magazine, filled to the brim with fantastic offers on various trade-relevant goods. These irresistible deals will help you save big on your business expenses, giving you an instant win that showcases the tangible value of your Buildela subscription. But that\'s not all - our magazine offers captivating reads, industry insights, and opportunities to feature your work and expertise. It\'s a hub of inspiration, knowledge, and rewards, specially crafted to empower you on your journey to success.</p><p style="margin: 0px; font-size: 17px; padding: 15px 0px; line-height: 22px;"><span style="font-size: 20px; font-weight:800;text-align: center;display: block;margin-bottom: 15px;color: #000;">💡 The Power of Your Quick Win: Proof of Buildela\'s Value 💡</span> When someone questions the value of your Buildela subscription - be it a mate, a business partner, or anyone curious about your investment - you can proudly point to the quick win you\'ve already achieved. With access to our quarterly magazine and the incredible offers, you\'re already reaping the rewards of being a Buildela member. This quick win is just the start of the exciting benefits you\'ll enjoy on our platform.</p><p  style="margin: 0px; font-size: 17px; line-height: 22px;"><span style="font-size: 20px; font-weight:800;text-align: center;display: block;margin-bottom: 15px;color: #000;">🎁 The Path Ahead: More Rewards Await You! 🎁</span> We\'re genuinely grateful to have you as part of our community, and we\'re dedicated to ensuring your continued success. The quarterly magazine is just one example of the many rewards and opportunities that Buildela has in store for you. As you actively engage with the platform, you\'ll unlock even more ways to grow your business, save money, and make valuable connections with like-minded professionals.</p></div>
                            <p style="font-size: 17px; margin: 0px; padding-top: 15px; line-height: 22px;">Embrace your quick win, and let it be the first stepping stone to an extraordinary journey with Buildela! Thank you for choosing Buildela - your gateway to unlimited leads, incredible rewards, and boundless possibilities in the construction trade industry.</p>
                            <p style="font-size: 17px; margin: 0px; padding-top: 15px; line-height: 22px;">Best regards,</p><p style="font-size: 17px; margin: 0px; padding-top: 10px; line-height: 22px;">The Buildela Team</p>
                            '.$email_signature.'
                        </div>
                    </div>');
                        sendemailsmtp($to, $message, $subject);
                    break;
                    case 6:
                        $to = $email;
                        $subject = 'Embrace a Thriving Future: Buildela - Your Gateway to Success!';


                        $message= nl2br('<div style="padding: 50px 0px;"><div style="max-width: 700px; margin: 0px auto; padding: 0px 15px;"><p style="font-size: 20px; margin: 0px; padding-bottom: 15px;">Dear '.$name.',</p>
                            <p style="font-size: 17px; margin: 0px; padding-bottom: 15px; line-height: 22px;">As we journey together towards success on Buildela, we understand that it might sometimes feel overwhelming. But fear not, for your success story is within reach, and we\'re here to guide you every step of the way. Today, we\'re excited to paint a clear picture of how Buildela makes achieving your goals in the construction trade industry simple, attainable, and incredibly rewarding.</p>
                            <div style="padding: 25px; background-color: #f3f4f5;"><p style="margin: 0px; font-size: 17px; line-height: 22px;"><span style="font-size: 20px; font-weight:800;text-align: center;display: block;margin-bottom: 15px;color: #000;">🚀 Your Journey to Success - Unveiling the Path 🚀</span> Imagine your path to success on Buildela as a thrilling adventure filled with opportunities to connect with local homeowners, tenants, landlords, and companies. As a valued member of our community, you\'re equipped with the tools to receive more leads and never be stuck for work again. Buildela becomes your secret weapon to fill in the blank spots in your diary, ensuring a consistent stream of exciting projects.</p><p style="margin: 0px; font-size: 17px; padding: 15px 0px; line-height: 22px;"><span style="font-size: 20px; font-weight:800;text-align: center;display: block;margin-bottom: 15px;color: #000;">🏡 Connecting with Your Local Community</span> Buildela is your gateway to connect with the heart of your trade - the local community. Whether it\'s homeowners looking for skilled professionals to renovate their spaces, tenants seeking expert contractors for maintenance, landlords needing reliable tradespeople, or companies seeking specialists for projects - you\'ll find them all within your reach on Buildela. With your profile shining brightly, you\'ll become the go-to expert for all their needs.</p><p style="margin: 0px; font-size: 17px; line-height: 22px;"><span style="font-size: 20px; font-weight:800;text-align: center;display: block;margin-bottom: 15px;color: #000;">🔍 More Leads, More Opportunities</span> Gone are the days of endlessly searching for work. Buildela brings you a wealth of leads and opportunities right to your doorstep. Our platform is designed to match your skills and expertise with clients actively seeking your services. With a steady flow of leads, you\'ll no longer have to worry about gaps in your schedule; instead, you\'ll have the freedom to focus on delivering top-notch results.</p><p style="margin: 0px; font-size: 17px; padding: 15px 0px; line-height: 22px;"><span style="font-size: 20px; font-weight:800;text-align: center;display: block;margin-bottom: 15px;color: #000;">📆 Filling in the Blank Spots with Buildela</span> Think of Buildela as your trusty tool to fill in the blank spots in your diary. Whenever you have a gap in your schedule, turn to Buildela, and we\'ll connect you with short-term projects and gigs to keep your calendar booked and thriving. Say goodbye to downtime and hello to continuous opportunities!</p><p  style="margin: 0px; font-size: 17px; line-height: 22px;"><span style="font-size: 20px; font-weight:800;text-align: center;display: block;margin-bottom: 15px;color: #000;">💡 Embrace the Success You Deserve</span> The journey to your success is now clearer than ever before. Each step you take on Buildela leads you to new heights, connecting you with local clients, providing you with more leads, and ensuring you always have work. The thriving future you envision is within your grasp, and we\'re here to ensure you reach it.</p></div>
                            <p style="font-size: 17px; margin: 0px; padding-top: 15px; line-height: 22px;">Let\'s create a success story that will inspire others to join the vibrant Buildela community.</p>
                            <p style="font-size: 17px; margin: 0px; padding-top: 15px; line-height: 22px;">Best regards,</p><p style="font-size: 17px; margin: 0px; padding-top: 10px; line-height: 22px;">The Buildela Team</p>
                            '.$email_signature.'
                        </div>
                    </div>');
                        sendemailsmtp($to, $message, $subject);
                    break;
                    case 7:
                        $to = $email;
                        $subject = 'Meet Your Fellow Champions: Buildela Success Stories that Inspire!';


                        $message= nl2br('<div style="padding: 50px 0px;"><div style="max-width: 700px; margin: 0px auto; padding: 0px 15px;"><p style="font-size: 20px; margin: 0px; padding-bottom: 15px;">Dear '.$name.',</p><p style="font-size: 17px; margin: 0px; padding-bottom: 15px; line-height: 22px;">Congratulations on completing your first week with Buildela! We hope you\'re feeling the excitement and promise that our platform holds for your success in the construction trade industry. Today, we want to introduce you to some of our most successful members - individuals just like you who have achieved remarkable feats through Buildela. Their stories are living proof that your dreams are not only attainable but also incredibly within your reach.</p>
                            <div style="padding: 25px; background-color: #f3f4f5;"><p style="margin: 0px; font-size: 20px; font-weight:800; line-height: 22px;text-align:center;">🌟 Meet the Champions of Buildela 🌟</p><p style="margin: 0px; font-size: 17px; padding: 15px 0px; line-height: 22px;">🏆 James Miller - Rising Star in Home Renovations: James joined Buildela as an aspiring contractor, unsure if he could stand out in a competitive market. But with determination and support from our vibrant community, James quickly became a rising star. Today, he\'s renowned for his exceptional home renovation services, and his calendar is booked solid with happy clients. With Buildela\'s limitless opportunities, James transformed his career and elevated his life to new heights.</p><p style="margin: 0px; font-size: 17px; line-height: 22px;">💼 Sarah Johnson - Scaling Her Business to New Heights: Sarah had been running her small construction business for years but struggled to find steady work. That changed the moment she joined Buildela. The platform\'s constant stream of leads and the power of Buildelato allowed Sarah to scale her business like never before. Now, her team is thriving and taking on high-profile projects that they previously thought were out of reach. Buildela unlocked a world of possibilities for Sarah and her team, and it can do the same for you!</p><p style="margin: 0px; font-size: 17px; padding: 15px 0px; line-height: 22px;">🚀 Paul Anderson - From Local Hero to Regional Expert: Paul was a well-respected tradesman in his local area, but he dreamed of expanding his reach. Buildela connected him with clients from all corners of his region, turning him into a regional expert. His reputation soared, and he now enjoys an elite status as one of the most sought-after professionals in his field. Buildela\'s expansive network and supportive community propelled Paul\'s career to unforeseen heights.</p><p  style="margin: 0px; font-size: 17px; line-height: 22px;">🏅 Your Success Story Awaits 🏅 These are just a few of the countless success stories created on Buildela. People from diverse backgrounds, experiences, and locations have thrived here, and you have all the ingredients needed to join their ranks.</p><p style="margin: 0px; font-size: 17px; padding: 15px 0px; line-height: 22px;">🌠 Believe in Yourself and Your Journey 🌠 As you embark on your path to success, remember that we believe in you wholeheartedly. Buildela is not just a platform; it\'s a community of like-minded professionals supporting each other to achieve greatness. Your dreams are valid, and we have every confidence that you can and will succeed in this program.</p><p  style="margin: 0px; font-size: 17px; line-height: 22px;">💪 Take Inspiration from Your Fellow Champions 💪 The success stories of your fellow champions are not meant to intimidate you; instead, they are here to inspire and motivate you. Their journeys began just like yours, and they faced similar doubts and hesitations. But they took the leap of faith and reaped incredible rewards. Now it\'s your turn to shine.</p></div>
                                <p style="font-size: 17px; margin: 0px; padding-top: 15px; line-height: 22px;">Believe in yourself, embrace the journey, and we\'ll be right here, cheering you on every step of the way!</p>
                            <p style="font-size: 17px; margin: 0px; padding-top: 15px; line-height: 22px;">Best regards,</p><p style="font-size: 17px; margin: 0px; padding-top: 10px; line-height: 22px;">The Buildela Team</p>
                            '.$email_signature.'
                        </div>
                    </div>');
                        sendemailsmtp($to, $message, $subject);
                    break;
                }
                if($day < 8){
                    $db_1 = new Database();
                    $db_1->connect();
                    // $day++;
                    $users = "users";
                    print_r("UPDATE $users SET email_days_left = '$day' WHERE id = '$id'");
                    print_r($db_1->sql("UPDATE $users SET email_days_left = '$day' WHERE id = '$id'"));
                     // $this->db->getResult();


                }   

    }
    function getAllFeedbacks(){
        $sql = "select * from rateuser ";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }

    }
    function updateJobEmailStatus($job_id){
        $sql = " update post_job set email_status=1 where id = '$job_id'  ";
        if($this->db->sql($sql)){

        }
    }

    function setFcmToken($user_id , $web_fcm){
        $sql = "UPDATE users set web_fcm='$web_fcm' where id = '$user_id'  ";
        if($this->db->sql($sql)){
            return true;
        }
    }

    
    function sendNotification($tokens, $notification){
        //send push notificaiton by firebase
        $url = "https://fcm.googleapis.com/fcm/send";

        $serverKey = 'AAAABhv8N4A:APA91bHNahn1FaKUh201mSQeV5m9GBRV98nmQFfDLIOsoE8XUNyJLTGDCLGdjuOPANIxfDg-sGAk45WkE1ZiOum43LRGjDXC0t2pdBi84ilBcoEhTKQ1bkGfBBlNv4ktTsFf0fiwUO5x';  // Replace with your Cloud Messaging Key from Firebase Console

        $arrayToSend = [
            'registration_ids' => $tokens,
            'notification' => $notification,
            'priority' => 'high'
        ];

        $json = json_encode($arrayToSend);

        $headers = [
            'Authorization: key=' . $serverKey,
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);

        if ($response === FALSE) {
            // die('FCM Send Error: ' . curl_error($ch));
        }

        curl_close($ch);

        return $response;



    }

    function sendMessageOnMobile($messagetxt,$sent_to){

        include_once "../Twilio/index.php";

        sendMessage($messagetxt,$sent_to);

    }
    function getAccountDetails($user_id){
        $sql = "select * from users_account where user_id='$user_id' and status = 1";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }

    }
    function getreplyOfthisReview($rateuser_id){
        $sql = "select * from replyrateuser where rateuser_id='$rateuser_id' ";

        if($this->db->sql($sql)){
            return $this->db->getResult();
        }

    }

    function getAllTransaction(){
        if($_SESSION['user_type']=='1'){
            $sql = "select * from transactions inner join users on transactions.user_id=users.id";
            if($this->db->sql($sql)){
                return $this->db->getResult();
            }
        }else{
            $sql = "select * from transactions inner join users on transactions.user_id=users.id where user_id=".$_SESSION['user_id'];
            if($this->db->sql($sql)){
                return $this->db->getResult();
            }
        }

    }

    function get_last_seen($subdate){
        $result="";

        $earlier = new DateTime($subdate);
        $later = new DateTime(date("Y-m-d H:i:s"));
        $diff = $later->diff($earlier)->format("%a");

        if($diff==0){
            $houre = $later->diff($earlier);
            $houres=$houre->h;

            if($houres == 0){
                $min=$houre->i;
                if($min<=3){
                    $result="Online";

                }else{
                    $result="Last seen ".$min." minutes ago";

                }


            }else{

                $result="Last seen ".$houres." hours ago";

            }

        }else if ($diff == 1) {

            $result="Last seen 1 day ago";

        }else if($diff == 2){

            $result="Last seen 2 days ago";

        }else if ($diff == 3) {

            $result="Last seen 3 days ago";

        }else if($diff == 4){

            $result="Last seen 4 days ago";

        }else if ($diff == 5) {

            $result="Last seen 5 days ago";

        }else if($diff == 6){

            $result="Last seen 6 days ago";

        }else if ($diff == 7) {

            $result="Last seen 7 days ago";

        }else if($diff > 7){

            $result="Last seen a week ago";
        }

        return $result;
    }//get_last_seen



    function charlimit($string, $limit) {
        if (mb_strlen($string) <= $limit) return $string;
        else return mb_substr($string, 0, $limit) . '...';
    }

    function getCityName($postalCode) {

        $apiUrl = "https://api.postcodes.io/postcodes/$postalCode";
        $response = file_get_contents($apiUrl);

        if ($response === false) {
            return false;
        } else {
            $data = json_decode($response, true);
            if ($data['status'] === 200) {
                return $data['result']['admin_district'];
            }
        }
        
    }

    function breakPostalCode($postcode) {
        // Apply regex pattern to extract the first three characters
        $pattern = '/^(.{1,3}).*$/';
        $replacement = '$1';
        $result = preg_replace($pattern, $replacement, $postcode);
    
        return strtoupper($result);
    }

    function maskPhoneNumber($phoneNumber) {
    

        $countryCode = '+44';
        if (strpos($phoneNumber, $countryCode) === 0) {
            $phoneNumber = substr($phoneNumber, strlen($countryCode));
        }
    
        $phoneNumber = preg_replace('/\D/', '', $phoneNumber);
    
        if (strlen($phoneNumber) >= 3) {
            $firstFourDigits = substr($phoneNumber, 0, 3);
            $maskedDigits = str_repeat('*', strlen($phoneNumber) - 3);
            $maskedNumber = $firstFourDigits . $maskedDigits;
        } else {
            $maskedNumber = $phoneNumber;
        }
    
        return $maskedNumber;
    }

    function getRecommendation($userid, $answer = 'yes'){
        
        if($answer === 'yes') {
            $sql="SELECT COUNT(*) AS recommend_count FROM rateuser WHERE user_id = $userid AND recommendation = 'yes';";
        } else if ($answer === 'no'){
            $sql="SELECT COUNT(*) AS recommend_count FROM rateuser WHERE user_id = $userid AND recommendation = 'no';";
        }

        $this->db->sql($sql);
        if($this->db->numRows() > 0){
            $recommender = $this->db->getResult();
            $count = $recommender[0]['recommend_count'];
            if($count >= 5)
                return $count;
        }else {
            return false;
        }

    }


    function timeAgo($timestamp) {
        $datetime1 = new DateTime($timestamp);
        $datetime2 = new DateTime();
        $interval = $datetime1->diff($datetime2);
        $output = '';
    
        if ($interval->y) {
            $output .= $interval->y > 1 ? $interval->format('%y years ago') : '1 year ago';
        } elseif ($interval->m) {
            $output .= $interval->m > 1 ? $interval->format('%m months ago') : '1 month ago';
        } elseif ($interval->d) {
            $output .= $interval->d > 1 ? $interval->format('%d days ago') : '1 day ago';
        } elseif ($interval->h) {
            $output .= $interval->h > 1 ? $interval->format('%h hours ago') : '1 hour ago';
        } elseif ($interval->i) {
            $output .= $interval->i > 1 ? $interval->format('%i minutes ago') : '1 minute ago';
        } else {
            $output .= $interval->s > 1 ? $interval->format('%s seconds ago') : '1 second ago';
        }
    
        return $output;
    }
    
    function timeAgoChat($timestamp) {
        $datetime = new DateTime($timestamp);
        return $datetime->format('d M Y, H:i');
    }

    function workAreaFixer($distance){
        $distance = $distance - 2;
        return $distance;
    }

    function leadCountManager($leadtype='leads', $count = false)
    {
        $user_id = $_SESSION['user_id'];

        if($count === false){

            if($leadtype === 'leads')  { 
                $sql = "SELECT lead_count FROM `read_leads_counter` WHERE `user_id` = '$user_id'";
                if ($this->db->sql($sql)) {
                    return $this->db->getResult()[0]['lead_count'];
                }
            } elseif($leadtype === 'interested') {
                $sql = "SELECT interested_count FROM `read_leads_counter` WHERE `user_id` = '$user_id'";
                if ($this->db->sql($sql)) {
                    return $this->db->getResult()[0]['interested_count'];
                }
            }elseif($leadtype === 'shortlisted')  {
                $sql = "SELECT shortlisted_count FROM `read_leads_counter` WHERE `user_id` = '$user_id'";
                if ($this->db->sql($sql)) {
                    return $this->db->getResult()[0]['shortlisted_count'];
                }       
            }elseif($leadtype === 'jobswon')  {
                $sql = "SELECT jobsown_count FROM `read_leads_counter` WHERE `user_id` = '$user_id'";
                if ($this->db->sql($sql)) {
                    return $this->db->getResult()[0]['jobsown_count'];
                }
            }     
            
        } elseif ($count === true){

            if($leadtype === 'leads')  {

                $counter = 0;
                $sql = "SELECT lead_count FROM read_leads_counter WHERE `user_id` = '$user_id'";
                $this->db->sql($sql);
                $result = $this->db->getResult();
                if ($result) {     
                    $counter = (int) $result[0]['lead_count'] + 1;
                    $sql = "update read_leads_counter set lead_count ='$counter' where user_id='$user_id' ";
                    if($this->db->sql($sql)) return true;
                }else {
                    $sql = "INSERT INTO `read_leads_counter`(`user_id`,`lead_count`) VALUES ('$user_id','1')";
                    if ($this->db->sql($sql)) return true;
                } 


            } elseif($leadtype === 'interested') {

                $counter = 0;
                $sql = "SELECT interested_count FROM read_leads_counter WHERE `user_id` = '$user_id'";
                $this->db->sql($sql);
                $result = $this->db->getResult();
                if ($result) {     
                    $counter = (int) $result[0]['interested_count'] + 1;
                    $sql = "update read_leads_counter set interested_count ='$counter' where user_id='$user_id' ";
                    if($this->db->sql($sql)) return true;
                }else {
                    $sql = "INSERT INTO `read_leads_counter`(`user_id`,`interested_count`) VALUES ('$user_id','1')";
                    if ($this->db->sql($sql)) return true;
                } 

            }elseif($leadtype === 'shortlisted')  {

                $counter = 0;
                $sql = "SELECT shortlisted_count FROM read_leads_counter WHERE `user_id` = '$user_id'";
                $this->db->sql($sql);
                $result = $this->db->getResult();
                if ($result) {     
                    $counter = (int) $result[0]['shortlisted_count'] + 1;
                    $sql = "update read_leads_counter set shortlisted_count ='$counter' where user_id='$user_id' ";
                    if($this->db->sql($sql)) return true; 
                }else {
                    $sql = "INSERT INTO `read_leads_counter`(`user_id`,`shortlisted_count`) VALUES ('$user_id','1')";
                    if ($this->db->sql($sql)) return true;
                }  

            }elseif($leadtype === 'jobswon')  {
                
                $counter = 0;
                $sql = "SELECT jobsown_count FROM read_leads_counter WHERE `user_id` = '$user_id'";
                $this->db->sql($sql);
                $result = $this->db->getResult();
                if ($result) {     
                    $counter = (int) $result[0]['jobsown_count'] + 1;
                    $sql = "update read_leads_counter SET jobsown_count ='$counter' WHERE user_id='$user_id' ";
                    if($this->db->sql($sql)) return true; 
                }else {
                    $sql = "INSERT INTO `read_leads_counter`(`user_id`,`jobsown_count`) VALUES ('$user_id','1')";
                    if ($this->db->sql($sql)) return true;
                } 
            }
        }

    }


    // function fixUsers() {
        
      
    //         $sql="SELECT id, fname, lname FROM users WHERE `user_role` = 'home_owner';";
    //         $this->db->sql($sql);
    //         $users = $this->db->getResult();

    //         foreach($users as $user) {
    //             $namearray = explode(' ', $user['fname']);
    //             $filterednames = array_filter($namearray);

    //             $userid = $user['id'];

    //             if(count($filterednames) > 1 && count($filterednames) <= 2 ){
    //                 $sql = "update users set fname ='$filterednames[0]', lname= '$filterednames[1]' where id='$userid' ";
    //             }elseif (count($filterednames) > 2){
    //                 $lastname = $filterednames[1]." ".$filterednames[2];
    //                 $sql = "update users set fname ='$filterednames[0]', lname= '$lastname' where id='$userid' ";
    //             }
                
    //             if($this->db->sql($sql)) echo "Updated!";
    //         }

    // }

    function typingManager($userid, $status = 'check'){
        $sql="SELECT id, is_typing, typing_for FROM users WHERE `id` = 'home_owner';";
    }

    function isTyping ($who, $forwhom = null) {
        if(!$forwhom){
            $myid = $_SESSION['user_id'];
            $sql="SELECT id, is_typing, typing_for FROM users WHERE `id` = '$who' AND `typing_for`='$myid';";
        }elseif($forwhom){
            $sql="SELECT id, is_typing, typing_for FROM users WHERE `id` = '$who' AND `typing_for`='$forwhom';";
        }
        if($this->db->sql($sql)){
            if($this->db->getResult()[0]['is_typing'] === '1' ) return true;
        }else {
            return false;
        }

    }

    function updateTyping($typing_for, $istyping = true) {
        $userid = $_SESSION['user_id'];
        if($istyping != true) $istyping = 0;
        else $istyping = 1;
        $sql = "update users set is_typing ='$istyping', typing_for= '$typing_for' where id='$userid' ";        
        if($this->db->sql($sql)) return true;
        else return false;
    }
    
    function getAllTradespersonsPassedInCategory($main_category){

        $sql="select * from users  inner join verify_skill on users.id = verify_skill.user_id  where users.user_role='jobs_person' and verify_skill.main_category ='$main_category' and verify_skill.status=1 and verify_skill.verify=1 ";
        if($this->db->sql($sql)){
            return $this->db->getResult();
        }
    }
    
     function getCountryIdFromIP($remoteAddress) {
        $apiUrl = "http://ipinfo.io/{$remoteAddress}/json";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        

        $data = json_decode($response, true);
        $countryId = $data['country'];
        
        return $countryId;
    }
    
    function isMobileDevice() {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
    
        $mobileKeywords = array(
            'Mobile', 'Android', 'iPhone', 'iPad', 'Windows Phone', 'BlackBerry', 'Opera Mini', 'IEMobile'
        );
    
        foreach ($mobileKeywords as $keyword) {
            if (stripos($userAgent, $keyword) !== false) {
                return true;
            }
        }
    
        return false;
    }

    function checkUrlQueryString() {
        if (!isset($_SERVER['QUERY_STRING']) || empty($_SERVER['QUERY_STRING'])) {
            return false;
        } else {
            return true;
        }
    }
    
    function pageChecker($textToCheck) {
        $currentURL = $_SERVER['REQUEST_URI'];
        if(strpos($currentURL, $textToCheck) !== false) return true;
        else false;
    }


    function DistanceCalculation($postcodes = [], $value = 'mile'){

        // Radius of the Earth in kilometers
        $earthRadius = 6371;
    
        // Radius of Earth in miles
        $earthRadiusMiles = 3959;
        $c = 0;
    
        if(!empty($postcodes)){
    
            $cordinates = [];
            
            $i = 0;
            foreach($postcodes as $code){ $i++;
    
                $apiUrl = "https://api.postcodes.io/postcodes/$code";
                $response = file_get_contents($apiUrl);
    
                // Check if the request was successful
                if ($response === false) {
                    return false;
                } else {
                    $data = json_decode($response, true);
                    
    
                    if ($data['status'] === 200) {
                        if($i === 1){
                            $cordinates['origin']['latitude'] = $data['result']['latitude'];
                            $cordinates['origin']['longitude'] = $data['result']['longitude'];
                        }else if($i === 2){
                            $cordinates['destination']['latitude'] = $data['result']['latitude'];
                            $cordinates['destination']['longitude'] = $data['result']['longitude'];
                        }
    
                    }
                }
    
            }
    
            if(!empty($cordinates)){
    
                // Convert latitude and longitude from degrees to radians
                $lat1Rad = deg2rad($cordinates['origin']['latitude']);
                $lon1Rad = deg2rad($cordinates['origin']['longitude']);
                $lat2Rad = deg2rad($cordinates['destination']['latitude']);
                $lon2Rad = deg2rad($cordinates['destination']['longitude']);
            
                // Haversine formula to calculate distance between two points on the Earth's surface
                $deltaLat = $lat2Rad - $lat1Rad;
                $deltaLon = $lon2Rad - $lon1Rad;
                $a = sin($deltaLat / 2) * sin($deltaLat / 2) + cos($lat1Rad) * cos($lat2Rad) * sin($deltaLon / 2) * sin($deltaLon / 2);
                $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
            
            }
        
            if($value === 'km')
                $distance = $earthRadius * $c;
            else if ($value === 'mile')
                $distance = $earthRadiusMiles * $c;
            else $distance = false;
        
            return number_format($distance, 2);
    
            
    
        }
    
    }


    function batchDistance($origin, $batchcodes, $value = 'mile'){
       
        // Radius of the Earth in kilometers
        $earthRadius = 6371;

        // Radius of Earth in miles
        $earthRadiusMiles = 3959;

        
        $distances  =	[];
        $origins 	=	[
            'latitude' 	=> null,
            'longitude'	=> null
        ];	
        $c = 0;
    
    
        $apiUrl = "https://api.postcodes.io/postcodes/$origin";
        $response = file_get_contents($apiUrl);
        if ($response === false) {
            return false;
        } else {
    
            $data = json_decode($response, true);
            
            if ($data['status'] === 200) {
                $origins['latitude'] = $data['result']['latitude'];
                $origins['longitude'] = $data['result']['longitude'];
            } 
    
        }
    
        
        $data = [
            "postcodes" => $batchcodes
        ];
        $jsonData = json_encode($data);    
  
        $ch = curl_init();
    
        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, "https://api.postcodes.io/postcodes/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
    
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            return false;
        }
    
        curl_close($ch);
        $result = json_decode($response, true);
    
        if (!empty($result['result'][0]['result'])) {
            foreach ($result["result"] as $postcodeData) {
    
                
    
                if($origins['latitude']){
    
                    // Convert latitude and longitude from degrees to radians
                    $lat1Rad = deg2rad($origins['latitude']);
                    $lon1Rad = deg2rad($origins['longitude']);
                    $lat2Rad = deg2rad($postcodeData['result']['latitude']);
                    $lon2Rad = deg2rad($postcodeData['result']['longitude']);
                
                    // Haversine formula to calculate distance between two points on the Earth's surface
                    $deltaLat = $lat2Rad - $lat1Rad;
                    $deltaLon = $lon2Rad - $lon1Rad;
                    $a = sin($deltaLat / 2) * sin($deltaLat / 2) + cos($lat1Rad) * cos($lat2Rad) * sin($deltaLon / 2) * sin($deltaLon / 2);
                    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                
                }
            
                if($value === 'km')
                    $distance = $earthRadius * $c;
                else if ($value === 'mile')
                    $distance = $earthRadiusMiles * $c;
    
                    
                
                array_push($distances, (float) number_format($distance, 2));
            }
    
    
        } else {
            array_push($distances, 'NA');
        }
    
        return $distances;    
    }
    
    
    function PostVerify($code) {
        $apiUrl = "https://api.postcodes.io/postcodes/".$code."/validate";
        $response = file_get_contents($apiUrl);
    
        if ($response === false) {
            return false;
        } else {
            $data = json_decode($response, true);
            if ($data['status'] === 200) {
                if($data['result'] === true) return true;
                else return false;
            }
        }
    
        
    }

    function formatPostedDay($diff) {
        if ($diff == 1) {
            return "Lead posted one day ago";
        } elseif ($diff <= 7) {
            return "Lead posted $diff days ago";
        } elseif ($diff <= 14) {
            return "Lead posted a week ago";
        } elseif ($diff <= 28) {
            return "Lead posted " . floor($diff / 7) . " weeks ago";
        } elseif ($diff <= 365) {
            return "Lead posted " . floor($diff / 30) . " months ago";
        } elseif ($diff > 365) {
            return "Lead posted " . floor($diff / 365) . " years ago";
        } else {
            return "Lead posted today";
        }
    }

    function formatPostedTime($hours) {

        $seconds = $hours * 3600;    
        $hours = floor($hours);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;
    
        $timeString = "";
    
        if ($hours > 0) {
            $timeString .= "Lead posted ". $hours . " hour" . ($hours > 1 ? "s" : "") . " ago.";
        }
    
        if ($minutes > 0) {
            $timeString .= "Lead posted ". $minutes . " minute" . ($minutes > 1 ? "s" : "") . " ago.";
        }
    
        if ($seconds > 0) {
            $timeString .= "Lead posted ". $seconds . " second" . ($seconds > 1 ? "s" : "") . " ago.";
        }
    
        return trim($timeString);
    }

    function countryCurrency($countryName) {
        $countryToCurrency = array(
            'Afghanistan' => [
                'currency' => 'AFN',
                'symbol' => '؋',
            ],
            'Albania' => [
                'currency' => 'ALL',
                'symbol' => 'L',
            ],
            'Algeria' => [
                'currency' => 'DZD',
                'symbol' => 'د.ج',
            ],
            'Andorra' => [
                'currency' => 'EUR',
                'symbol' => '€',
            ],
            'Angola' => [
                'currency' => 'AOA',
                'symbol' => 'Kz',
            ],
            'Antigua and Barbuda' => [
                'currency' => 'XCD',
                'symbol' => '$',
            ],
            'Argentina' => [
                'currency' => 'ARS',
                'symbol' => '$',
            ],
            'Armenia' => [
                'currency' => 'AMD',
                'symbol' => '֏',
            ],
            'Australia' => [
                'currency' => 'AUD',
                'symbol' => '$',
            ],
            'Austria' => [
                'currency' => 'EUR',
                'symbol' => '€',
            ],
            'Azerbaijan' => [
                'currency' => 'AZN',
                'symbol' => '₼',
            ],
            'Bahamas' => [
                'currency' => 'BSD',
                'symbol' => '$',
            ],
            'Bahrain' => [
                'currency' => 'BHD',
                'symbol' => 'BD',
            ],
            'Bangladesh' => [
                'currency' => 'BDT',
                'symbol' => '৳',
            ],
            'Barbados' => [
                'currency' => 'BBD',
                'symbol' => '$',
            ],
            'Belarus' => [
                'currency' => 'BYN',
                'symbol' => 'Br',
            ],
            'Belgium' => [
                'currency' => 'EUR',
                'symbol' => '€',
            ],
            'Belize' => [
                'currency' => 'BZD',
                'symbol' => 'BZ$',
            ],
            'Benin' => [
                'currency' => 'XOF',
                'symbol' => 'CFA',
            ],
            'Bhutan' => [
                'currency' => 'BTN',
                'symbol' => 'Nu.',
            ],
            'Bolivia' => [
                'currency' => 'BOB',
                'symbol' => 'Bs.',
            ],
            'Bosnia and Herzegovina' => [
                'currency' => 'BAM',
                'symbol' => 'KM',
            ],
            'Botswana' => [
                'currency' => 'BWP',
                'symbol' => 'P',
            ],
            'Brazil' => [
                'currency' => 'BRL',
                'symbol' => 'R$',
            ],
            'Brunei' => [
                'currency' => 'BND',
                'symbol' => '$',
            ],
            'Bulgaria' => [
                'currency' => 'BGN',
                'symbol' => 'лв',
            ],
            'Burkina Faso' => [
                'currency' => 'XOF',
                'symbol' => 'CFA',
            ],
            'Burundi' => [
                'currency' => 'BIF',
                'symbol' => 'Fr',
            ],
            'Cambodia' => [
                'currency' => 'KHR',
                'symbol' => '៛',
            ],
            'Cameroon' => [
                'currency' => 'XAF',
                'symbol' => 'FCFA',
            ],
            'Canada' => [
                'currency' => 'CAD',
                'symbol' => '$',
            ],
            'Cape Verde' => [
                'currency' => 'CVE',
                'symbol' => '$',
            ],
            'Central African Republic' => [
                'currency' => 'XAF',
                'symbol' => 'FCFA',
            ],
            'Chad' => [
                'currency' => 'XAF',
                'symbol' => 'FCFA',
            ],
            'Chile' => [
                'currency' => 'CLP',
                'symbol' => '$',
            ],
            'China' => [
                'currency' => 'CNY',
                'symbol' => '¥',
            ],
            'Colombia' => [
                'currency' => 'COP',
                'symbol' => '$',
            ],
            'Comoros' => [
                'currency' => 'KMF',
                'symbol' => 'Fr',
            ],
            'Congo' => [
                'currency' => 'XAF',
                'symbol' => 'FCFA',
            ],
            'Costa Rica' => [
                'currency' => 'CRC',
                'symbol' => '₡',
            ],
            'Croatia' => [
                'currency' => 'HRK',
                'symbol' => 'kn',
            ],
            'Cuba' => [
                'currency' => 'CUP',
                'symbol' => '$',
            ],
            'Cyprus' => [
                'currency' => 'EUR',
                'symbol' => '€',
            ],
            'Czech Republic' => [
                'currency' => 'CZK',
                'symbol' => 'Kč',
            ],
            'Denmark' => [
                'currency' => 'DKK',
                'symbol' => 'kr',
            ],
            'Djibouti' => [
                'currency' => 'DJF',
                'symbol' => 'Fdj',
            ],
            'Dominica' => [
                'currency' => 'XCD',
                'symbol' => '$',
            ],
            'Dominican Republic' => [
                'currency' => 'DOP',
                'symbol' => 'RD$',
            ],
            'East Timor' => [
                'currency' => 'USD',
                'symbol' => '$',
            ],
            'Ecuador' => [
                'currency' => 'USD',
                'symbol' => '$',
            ],
            'Egypt' => [
                'currency' => 'EGP',
                'symbol' => '£',
            ],
            'El Salvador' => [
                'currency' => 'USD',
                'symbol' => '$',
            ],
            'Equatorial Guinea' => [
                'currency' => 'XAF',
                'symbol' => 'FCFA',
            ],
            'Eritrea' => [
                'currency' => 'ERN',
                'symbol' => 'Nfk',
            ],
            'Estonia' => [
                'currency' => 'EUR',
                'symbol' => '€',
            ],
            'Ethiopia' => [
                'currency' => 'ETB',
                'symbol' => 'Br',
            ],
            'Fiji' => [
                'currency' => 'FJD',
                'symbol' => 'FJ$',
            ],
            'Finland' => [
                'currency' => 'EUR',
                'symbol' => '€',
            ],
            'France' => [
                'currency' => 'EUR',
                'symbol' => '€',
            ],
            'Gabon' => [
                'currency' => 'XAF',
                'symbol' => 'FCFA',
            ],
            'Gambia' => [
                'currency' => 'GMD',
                'symbol' => 'D',
            ],
            'Georgia' => [
                'currency' => 'GEL',
                'symbol' => '₾',
            ],
            'Germany' => [
                'currency' => 'EUR',
                'symbol' => '€',
            ],
            'Ghana' => [
                'currency' => 'GHS',
                'symbol' => '₵',
            ],
            'Greece' => [
                'currency' => 'EUR',
                'symbol' => '€',
            ],
            'Grenada' => [
                'currency' => 'XCD',
                'symbol' => '$',
            ],
            'Guatemala' => [
                'currency' => 'GTQ',
                'symbol' => 'Q',
            ],
            'Guinea' => [
                'currency' => 'GNF',
                'symbol' => 'Fr',
            ],
            'Guinea-Bissau' => [
                'currency' => 'XOF',
                'symbol' => 'CFA',
            ],
            'Guyana' => [
                'currency' => 'GYD',
                'symbol' => '$',
            ],
            'Haiti' => [
                'currency' => 'HTG',
                'symbol' => 'G',
            ],
            'Honduras' => [
                'currency' => 'HNL',
                'symbol' => 'L',
            ],
            'Hungary' => [
                'currency' => 'HUF',
                'symbol' => 'Ft',
            ],
            'Iceland' => [
                'currency' => 'ISK',
                'symbol' => 'kr',
            ],
            'India' => [
                'currency' => 'INR',
                'symbol' => '₹',
            ],
            'Indonesia' => [
                'currency' => 'IDR',
                'symbol' => 'Rp',
            ],
            'Iran' => [
                'currency' => 'IRR',
                'symbol' => '﷼',
            ],
            'Iraq' => [
                'currency' => 'IQD',
                'symbol' => 'ع.د',
            ],
            'Ireland' => [
                'currency' => 'EUR',
                'symbol' => '€',
            ],
            'Israel' => [
                'currency' => 'ILS',
                'symbol' => '₪',
            ],
            'Italy' => [
                'currency' => 'EUR',
                'symbol' => '€',
            ],
            'Ivory Coast' => [
                'currency' => 'XOF',
                'symbol' => 'CFA',
            ],
            'Jamaica' => [
                'currency' => 'JMD',
                'symbol' => 'J$',
            ],
            'Japan' => [
                'currency' => 'JPY',
                'symbol' => '¥',
            ],
            'Jordan' => [
                'currency' => 'JOD',
                'symbol' => 'د.ا',
            ],
            'Kazakhstan' => [
                'currency' => 'KZT',
                'symbol' => '₸',
            ],
            'Kenya' => [
                'currency' => 'KES',
                'symbol' => 'KSh',
            ],
            'Kiribati' => [
                'currency' => 'AUD',
                'symbol' => '$',
            ],
            'Kuwait' => [
                'currency' => 'KWD',
                'symbol' => 'د.ك',
            ],
            'Kyrgyzstan' => [
                'currency' => 'KGS',
                'symbol' => 'с',
            ],
            'Laos' => [
                'currency' => 'LAK',
                'symbol' => '₭',
            ],
            'Latvia' => [
                'currency' => 'EUR',
                'symbol' => '€',
            ],
            'Lebanon' => [
                'currency' => 'LBP',
                'symbol' => 'ل.ل',
            ],
            'Lesotho' => [
                'currency' => 'LSL',
                'symbol' => 'L',
            ],
            'Liberia' => [
                'currency' => 'LRD',
                'symbol' => '$',
            ],
            'Libya' => [
                'currency' => 'LYD',
                'symbol' => 'ل.د',
            ],
            'Liechtenstein' => [
                'currency' => 'CHF',
                'symbol' => 'Fr',
            ],
            'Lithuania' => [
                'currency' => 'EUR',
                'symbol' => '€',
            ],
            'Luxembourg' => [
                'currency' => 'EUR',
                'symbol' => '€',
            ],
            'Macedonia' => [
                'currency' => 'MKD',
                'symbol' => 'ден',
            ],
            'Madagascar' => [
                'currency' => 'MGA',
                'symbol' => 'Ar',
            ],
            'Malawi' => [
                'currency' => 'MWK',
                'symbol' => 'MK',
            ],
            'Malaysia' => [
                'currency' => 'MYR',
                'symbol' => 'RM',
            ],
            'Maldives' => [
                'currency' => 'MVR',
                'symbol' => 'ރ.',
            ],
            'Mali' => [
                'currency' => 'XOF',
                'symbol' => 'CFA',
            ],
            'Malta' => [
                'currency' => 'EUR',
                'symbol' => '€',
            ],
            'Marshall Islands' => [
                'currency' => 'USD',
                'symbol' => '$',
            ],
            'Mauritania' => [
                'currency' => 'MRO',
                'symbol' => 'UM',
            ],
            'Mauritius' => [
                'currency' => 'MUR',
                'symbol' => '₨',
            ],
            'Mexico' => [
                'currency' => 'MXN',
                'symbol' => '$',
            ],
            'Micronesia' => [
                'currency' => 'USD',
                'symbol' => '$',
            ],
            'Moldova' => [
                'currency' => 'MDL',
                'symbol' => 'L',
            ],
            'Monaco' => [
                'currency' => 'EUR',
                'symbol' => '€',
            ],
            'Mongolia' => [
                'currency' => 'MNT',
                'symbol' => '₮',
            ],
            'Montenegro' => [
                'currency' => 'EUR',
                'symbol' => '€',
            ],
            'Morocco' => [
                'currency' => 'MAD',
                'symbol' => 'د.م.',
            ],
            'Mozambique' => [
                'currency' => 'MZN',
                'symbol' => 'MT',
            ],
            'Myanmar (Burma)' => [
                'currency' => 'MMK',
                'symbol' => 'Ks',
            ],
            'Namibia' => [
                'currency' => 'NAD',
                'symbol' => 'N$',
            ],
            'Nauru' => [
                'currency' => 'AUD',
                'symbol' => '$',
            ],
            'Nepal' => [
                'currency' => 'NPR',
                'symbol' => 'रू',
            ],
            'Netherlands' => [
                'currency' => 'EUR',
                'symbol' => '€',
            ],
            'New Zealand' => [
                'currency' => 'NZD',
                'symbol' => '$',
            ],
            'Nicaragua' => [
                'currency' => 'NIO',
                'symbol' => 'C$',
            ],
            'Niger' => [
                'currency' => 'XOF',
                'symbol' => 'CFA',
            ],
            'Nigeria' => [
                'currency' => 'NGN',
                'symbol' => '₦',
            ],
            'North Korea' => [
                'currency' => 'KPW',
                'symbol' => '₩',
            ],
            'Norway' => [
                'currency' => 'NOK',
                'symbol' => 'kr',
            ],
            'Oman' => [
                'currency' => 'OMR',
                'symbol' => 'ر.ع.',
            ],
            'Pakistan' => [
                'currency' => 'PKR',
                'symbol' => '₨',
            ],
            'Palau' => [
                'currency' => 'USD',
                'symbol' => '$',
            ],
            'Palestine' => [
                'currency' => 'ILS',
                'symbol' => '₪',
            ],
            'Panama' => [
                'currency' => 'PAB',
                'symbol' => 'B/.',
            ],
            'Papua New Guinea' => [
                'currency' => 'PGK',
                'symbol' => 'K',
            ],
            'Paraguay' => [
                'currency' => 'PYG',
                'symbol' => '₲',
            ],
            'Peru' => [
                'currency' => 'PEN',
                'symbol' => 'S/.',
            ],
            'Philippines' => [
                'currency' => 'PHP',
                'symbol' => '₱',
            ],
            'Poland' => [
                'currency' => 'PLN',
                'symbol' => 'zł',
            ],
            'Portugal' => [
                'currency' => 'EUR',
                'symbol' => '€',
            ],
            'Qatar' => [
                'currency' => 'QAR',
                'symbol' => 'ر.ق',
            ],
            'Romania' => [
                'currency' => 'RON',
                'symbol' => 'lei',
            ],
            'Russia' => [
                'currency' => 'RUB',
                'symbol' => '₽',
            ],
            'Rwanda' => [
                'currency' => 'RWF',
                'symbol' => 'Fr',
            ],
            'Saint Kitts and Nevis' => [
                'currency' => 'XCD',
                'symbol' => '$',
            ],
            'Saint Lucia' => [
                'currency' => 'XCD',
                'symbol' => '$',
            ],
            'Saint Vincent and the Grenadines' => [
                'currency' => 'XCD',
                'symbol' => '$',
            ],
            'Samoa' => [
                'currency' => 'WST',
                'symbol' => 'T',
            ],
            'San Marino' => [
                'currency' => 'EUR',
                'symbol' => '€',
            ],
            'Sao Tome and Principe' => [
                'currency' => 'STN',
                'symbol' => 'Db',
            ],
            'Saudi Arabia' => [
                'currency' => 'SAR',
                'symbol' => 'ر.س',
            ],
            'Senegal' => [
                'currency' => 'XOF',
                'symbol' => 'CFA',
            ],
            'Serbia' => [
                'currency' => 'RSD',
                'symbol' => 'din',
            ],
            'Seychelles' => [
                'currency' => 'SCR',
                'symbol' => '₨',
            ],
            'Sierra Leone' => [
                'currency' => 'SLL',
                'symbol' => 'Le',
            ],
            'Singapore' => [
                'currency' => 'SGD',
                'symbol' => '$',
            ],
            'Slovakia' => [
                'currency' => 'EUR',
                'symbol' => '€',
            ],
            'Slovenia' => [
                'currency' => 'EUR',
                'symbol' => '€',
            ],
            'Solomon Islands' => [
                'currency' => 'SBD',
                'symbol' => 'SI$',
            ],
            'Somalia' => [
                'currency' => 'SOS',
                'symbol' => 'Sh',
            ],
            'South Africa' => [
                'currency' => 'ZAR',
                'symbol' => 'R',
            ],
            'South Korea' => [
                'currency' => 'KRW',
                'symbol' => '₩',
            ],
            'South Sudan' => [
                'currency' => 'SSP',
                'symbol' => '£',
            ],
            'Spain' => [
                'currency' => 'EUR',
                'symbol' => '€',
            ],
            'Sri Lanka' => [
                'currency' => 'LKR',
                'symbol' => '₨',
            ],
            'Sudan' => [
                'currency' => 'SDG',
                'symbol' => 'ج.س.',
            ],
            'Suriname' => [
                'currency' => 'SRD',
                'symbol' => '$',
            ],
            'Swaziland' => [
                'currency' => 'SZL',
                'symbol' => 'E',
            ],
            'Sweden' => [
                'currency' => 'SEK',
                'symbol' => 'kr',
            ],
            'Switzerland' => [
                'currency' => 'CHF',
                'symbol' => 'Fr',
            ],
            'Syria' => [
                'currency' => 'SYP',
                'symbol' => '£',
            ],
            'Taiwan' => [
                'currency' => 'TWD',
                'symbol' => 'NT$',
            ],
            'Tajikistan' => [
                'currency' => 'TJS',
                'symbol' => 'ЅМ',
            ],
            'Tanzania' => [
                'currency' => 'TZS',
                'symbol' => 'TSh',
            ],
            'Thailand' => [
                'currency' => 'THB',
                'symbol' => '฿',
            ],
            'Togo' => [
                'currency' => 'XOF',
                'symbol' => 'CFA',
            ],
            'Tonga' => [
                'currency' => 'TOP',
                'symbol' => 'T$',
            ],
            'Trinidad and Tobago' => [
                'currency' => 'TTD',
                'symbol' => 'TT$',
            ],
            'Tunisia' => [
                'currency' => 'TND',
                'symbol' => 'د.ت',
            ],
            'Turkey' => [
                'currency' => 'TRY',
                'symbol' => '₺',
            ],
            'Turkmenistan' => [
                'currency' => 'TMT',
                'symbol' => 'T',
            ],
            'Tuvalu' => [
                'currency' => 'AUD',
                'symbol' => '$',
            ],
            'Uganda' => [
                'currency' => 'UGX',
                'symbol' => 'USh',
            ],
            'Ukraine' => [
                'currency' => 'UAH',
                'symbol' => '₴',
            ],
            'United Arab Emirates' => [
                'currency' => 'AED',
                'symbol' => 'د.إ',
            ],
            'United Kingdom' => [
                'currency' => 'GBP',
                'symbol' => '£',
            ],
            'United States' => [
                'currency' => 'USD',
                'symbol' => '$',
            ],
            'Uruguay' => [
                'currency' => 'UYU',
                'symbol' => '$U',
            ],
            'Uzbekistan' => [
                'currency' => 'UZS',
                'symbol' => 'soʻm',
            ],
            'Vanuatu' => [
                'currency' => 'VUV',
                'symbol' => 'VT',
            ],
            'Vatican City' => [
                'currency' => 'EUR',
                'symbol' => '€',
            ],
            'Venezuela' => [
                'currency' => 'VES',
                'symbol' => 'Bs.S.',
            ],
            'Vietnam' => [
                'currency' => 'VND',
                'symbol' => '₫',
            ],
            'Yemen' => [
                'currency' => 'YER',
                'symbol' => '﷼',
            ],
            'Zambia' => [
                'currency' => 'ZMW',
                'symbol' => 'ZK',
            ],
            'Zimbabwe' => [
                'currency' => 'ZWL',
                'symbol' => 'Z$',
            ],
        );
    
        $countryName = ucwords(strtolower($countryName));
    
        if (isset($countryToCurrency[$countryName])) {
            return $countryToCurrency[$countryName];
        } else {
            return false;
        }
    }

    
    

    function convertCurrency($amount, $fromCurrency, $toCurrency) {
    
        $apiKey = '91a6eb0a74dc767adfb7ea5d';
        $baseUrl = "https://open.er-api.com/v6/latest/$fromCurrency";
    
        try {
            $response = file_get_contents($baseUrl);
    
            if ($response === false) {
                return false;
            }
    
            $data = json_decode($response, true);
    
            if (!isset($data['rates'][$toCurrency])) {
                throw new Exception("Currency not supported.");
            }
    
            $rate = $data['rates'][$toCurrency];
            $convertedAmount = $amount * $rate;
    
            return number_format($convertedAmount, 0);
            
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function getClientlocation($ip) {

        $apiUrl = "http://ip-api.com/json/{$ip}";

        try {
            $response = file_get_contents($apiUrl);
            $data = json_decode($response);

            if ($data->status === 'success') {

                if ($data->status === 'success') {

                    return [
                        'country'   =>  $data->country,
                        'region'    =>  $data->regionName,
                        'city'      =>  $data->city,
                        'latitude'  =>  $data->lat,
                        'logitude'  =>  $data->lon
                    ];
                    
                } else {
                    return false;
                }

            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public static function countries($buildela = false){

        if($buildela){
            
            return [
                "United States",
                "Australia",
                "Canada",
                "Ireland",
                "Italy",
                "South Africa",
                "Turkey",
                "United Kingdom",
                "United Arab Emirates"
            ];

        }else {

            return [
                'Afghanistan',
                'Albania',
                'Algeria',
                'Andorra',
                'Angola',
                'Antigua and Barbuda',
                'Argentina',
                'Armenia',
                'Australia',
                'Austria',
                'Azerbaijan',
                'Bahamas',
                'Bahrain',
                'Bangladesh',
                'Barbados',
                'Belarus',
                'Belgium',
                'Belize',
                'Benin',
                'Bhutan',
                'Bolivia',
                'Bosnia and Herzegovina',
                'Botswana',
                'Brazil',
                'Brunei',
                'Bulgaria',
                'Burkina Faso',
                'Burundi',
                'Cambodia',
                'Cameroon',
                'Canada',
                'Cape Verde',
                'Central African Republic',
                'Chad',
                'Chile',
                'China',
                'Colombia',
                'Comoros',
                'Congo',
                'Costa Rica',
                'Croatia',
                'Cuba',
                'Cyprus',
                'Czech Republic',
                'Denmark',
                'Djibouti',
                'Dominica',
                'Dominican Republic',
                'East Timor',
                'Ecuador',
                'Egypt',
                'El Salvador',
                'Equatorial Guinea',
                'Eritrea',
                'Estonia',
                'Ethiopia',
                'Fiji',
                'Finland',
                'France',
                'Gabon',
                'Gambia',
                'Georgia',
                'Germany',
                'Ghana',
                'Greece',
                'Grenada',
                'Guatemala',
                'Guinea',
                'Guinea-Bissau',
                'Guyana',
                'Haiti',
                'Honduras',
                'Hungary',
                'Iceland',
                'India',
                'Indonesia',
                'Iran',
                'Iraq',
                'Ireland',
                'Israel',
                'Italy',
                'Ivory Coast',
                'Jamaica',
                'Japan',
                'Jordan',
                'Kazakhstan',
                'Kenya',
                'Kiribati',
                'Kuwait',
                'Kyrgyzstan',
                'Laos',
                'Latvia',
                'Lebanon',
                'Lesotho',
                'Liberia',
                'Libya',
                'Liechtenstein',
                'Lithuania',
                'Luxembourg',
                'Macedonia',
                'Madagascar',
                'Malawi',
                'Malaysia',
                'Maldives',
                'Mali',
                'Malta',
                'Marshall Islands',
                'Mauritania',
                'Mauritius',
                'Mexico',
                'Micronesia',
                'Moldova',
                'Monaco',
                'Mongolia',
                'Montenegro',
                'Morocco',
                'Mozambique',
                'Myanmar (Burma)',
                'Namibia',
                'Nauru',
                'Nepal',
                'Netherlands',
                'New Zealand',
                'Nicaragua',
                'Niger',
                'Nigeria',
                'North Korea',
                'Norway',
                'Oman',
                'Pakistan',
                'Palau',
                'Palestine',
                'Panama',
                'Papua New Guinea',
                'Paraguay',
                'Peru',
                'Philippines',
                'Poland',
                'Portugal',
                'Qatar',
                'Romania',
                'Russia',
                'Rwanda',
                'Saint Kitts and Nevis',
                'Saint Lucia',
                'Saint Vincent and the Grenadines',
                'Samoa',
                'San Marino',
                'Sao Tome and Principe',
                'Saudi Arabia',
                'Senegal',
                'Serbia',
                'Seychelles',
                'Sierra Leone',
                'Singapore',
                'Slovakia',
                'Slovenia',
                'Solomon Islands',
                'Somalia',
                'South Africa',
                'South Korea',
                'South Sudan',
                'Spain',
                'Sri Lanka',
                'Sudan',
                'Suriname',
                'Swaziland',
                'Sweden',
                'Switzerland',
                'Syria',
                'Taiwan',
                'Tajikistan',
                'Tanzania',
                'Thailand',
                'Togo',
                'Tonga',
                'Trinidad and Tobago',
                'Tunisia',
                'Turkey',
                'Turkmenistan',
                'Tuvalu',
                'Uganda',
                'Ukraine',
                'United Arab Emirates',
                'United Kingdom',
                'United States',
                'Uruguay',
                'Uzbekistan',
                'Vanuatu',
                'Vatican City',
                'Venezuela',
                'Vietnam',
                'Yemen',
                'Zambia',
                'Zimbabwe',
            ];
        }
    }

    public static function dialcode($country) {
        
        $dialCodes = [
            'Afghanistan' => '+93',
            'Albania' => '+355',
            'Algeria' => '+213',
            'Andorra' => '+376',
            'Angola' => '+244',
            'Antigua and Barbuda' => '+1-268',
            'Argentina' => '+54',
            'Armenia' => '+374',
            'Australia' => '+61',
            'Austria' => '+43',
            'Azerbaijan' => '+994',
            'Bahamas' => '+1-242',
            'Bahrain' => '+973',
            'Bangladesh' => '+880',
            'Barbados' => '+1-246',
            'Belarus' => '+375',
            'Belgium' => '+32',
            'Belize' => '+501',
            'Benin' => '+229',
            'Bhutan' => '+975',
            'Bolivia' => '+591',
            'Bosnia and Herzegovina' => '+387',
            'Botswana' => '+267',
            'Brazil' => '+55',
            'Brunei' => '+673',
            'Bulgaria' => '+359',
            'Burkina Faso' => '+226',
            'Burundi' => '+257',
            'Cambodia' => '+855',
            'Cameroon' => '+237',
            'Canada' => '+1',
            'Cape Verde' => '+238',
            'Central African Republic' => '+236',
            'Chad' => '+235',
            'Chile' => '+56',
            'China' => '+86',
            'Colombia' => '+57',
            'Comoros' => '+269',
            'Congo' => '+242',
            'Costa Rica' => '+506',
            'Croatia' => '+385',
            'Cuba' => '+53',
            'Cyprus' => '+357',
            'Czech Republic' => '+420',
            'Denmark' => '+45',
            'Djibouti' => '+253',
            'Dominica' => '+1-767',
            'Dominican Republic' => '+1-809, +1-829, +1-849',
            'East Timor' => '+670',
            'Ecuador' => '+593',
            'Egypt' => '+20',
            'El Salvador' => '+503',
            'Equatorial Guinea' => '+240',
            'Eritrea' => '+291',
            'Estonia' => '+372',
            'Ethiopia' => '+251',
            'Fiji' => '+679',
            'Finland' => '+358',
            'France' => '+33',
            'Gabon' => '+241',
            'Gambia' => '+220',
            'Georgia' => '+995',
            'Germany' => '+49',
            'Ghana' => '+233',
            'Greece' => '+30',
            'Grenada' => '+1-473',
            'Guatemala' => '+502',
            'Guinea' => '+224',
            'Guinea-Bissau' => '+245',
            'Guyana' => '+592',
            'Haiti' => '+509',
            'Honduras' => '+504',
            'Hungary' => '+36',
            'Iceland' => '+354',
            'India' => '+91',
            'Indonesia' => '+62',
            'Iran' => '+98',
            'Iraq' => '+964',
            'Ireland' => '+353',
            'Israel' => '+972',
            'Italy' => '+39',
            'Ivory Coast' => '+225',
            'Jamaica' => '+1-876',
            'Japan' => '+81',
            'Jordan' => '+962',
            'Kazakhstan' => '+7',
            'Kenya' => '+254',
            'Kiribati' => '+686',
            'Kuwait' => '+965',
            'Kyrgyzstan' => '+996',
            'Laos' => '+856',
            'Latvia' => '+371',
            'Lebanon' => '+961',
            'Lesotho' => '+266',
            'Liberia' => '+231',
            'Libya' => '+218',
            'Liechtenstein' => '+423',
            'Lithuania' => '+370',
            'Luxembourg' => '+352',
            'Macedonia' => '+389',
            'Madagascar' => '+261',
            'Malawi' => '+265',
            'Malaysia' => '+60',
            'Maldives' => '+960',
            'Mali' => '+223',
            'Malta' => '+356',
            'Marshall Islands' => '+692',
            'Mauritania' => '+222',
            'Mauritius' => '+230',
            'Mexico' => '+52',
            'Micronesia' => '+691',
            'Moldova' => '+373',
            'Monaco' => '+377',
            'Mongolia' => '+976',
            'Montenegro' => '+382',
            'Morocco' => '+212',
            'Mozambique' => '+258',
            'Myanmar (Burma)' => '+95',
            'Namibia' => '+264',
            'Nauru' => '+674',
            'Nepal' => '+977',
            'Netherlands' => '+31',
            'New Zealand' => '+64',
            'Nicaragua' => '+505',
            'Niger' => '+227',
            'Nigeria' => '+234',
            'North Korea' => '+850',
            'Norway' => '+47',
            'Oman' => '+968',
            'Pakistan' => '+92',
            'Palau' => '+680',
            'Palestine' => '+970',
            'Panama' => '+507',
            'Papua New Guinea' => '+675',
            'Paraguay' => '+595',
            'Peru' => '+51',
            'Philippines' => '+63',
            'Poland' => '+48',
            'Portugal' => '+351',
            'Qatar' => '+974',
            'Romania' => '+40',
            'Russia' => '+7',
            'Rwanda' => '+250',
            'Saint Kitts and Nevis' => '+1-869',
            'Saint Lucia' => '+1-758',
            'Saint Vincent and the Grenadines' => '+1-784',
            'Samoa' => '+685',
            'San Marino' => '+378',
            'Sao Tome and Principe' => '+239',
            'Saudi Arabia' => '+966',
            'Senegal' => '+221',
            'Serbia' => '+381',
            'Seychelles' => '+248',
            'Sierra Leone' => '+232',
            'Singapore' => '+65',
            'Slovakia' => '+421',
            'Slovenia' => '+386',
            'Solomon Islands' => '+677',
            'Somalia' => '+252',
            'South Africa' => '+27',
            'South Korea' => '+82',
            'South Sudan' => '+211',
            'Spain' => '+34',
            'Sri Lanka' => '+94',
            'Sudan' => '+249',
            'Suriname' => '+597',
            'Swaziland' => '+268',
            'Sweden' => '+46',
            'Switzerland' => '+41',
            'Syria' => '+963',
            'Taiwan' => '+886',
            'Tajikistan' => '+992',
            'Tanzania' => '+255',
            'Thailand' => '+66',
            'Togo' => '+228',
            'Tonga' => '+676',
            'Trinidad and Tobago' => '+1-868',
            'Tunisia' => '+216',
            'Turkey' => '+90',
            'Turkmenistan' => '+993',
            'Tuvalu' => '+688',
            'Uganda' => '+256',
            'Ukraine' => '+380',
            'United Arab Emirates' => '+971',
            'United Kingdom' => '+44',
            'United States' => '+1',
            'Uruguay' => '+598',
            'Uzbekistan' => '+998',
            'Vanuatu' => '+678',
            'Vatican City' => '+379',
            'Venezuela' => '+58',
            'Vietnam' => '+84',
            'Yemen' => '+967',
            'Zambia' => '+260',
            'Zimbabwe' => '+263',
            // Add more countries and their dial codes here
        ];

        $countryName = ucwords(strtolower($country));

        if (isset($dialCodes[$countryName])) {
            return $dialCodes[$countryName];
        } else {
            return false;
        }
    }

    function limitWords($sentence, $limit = 8) {

        $words = explode(' ', $sentence);
    
        if (count($words) <= $limit) {
            return $sentence;
        } else {
            $limitedWords = array_slice($words, 0, $limit);
            $limitedSentence = implode(' ', $limitedWords) . '...';
            return $limitedSentence;
        }

    }

    function redirect($fileName)
    {
        error_reporting(E_ALL);
    
        // Debugging: Output some information
        // echo "Redirecting to: $baseURL";
    
        header("Location: $fileName");
        exit;
    }
    
        

    function dump($code, $die = true, $dump = true) {
        if($dump){
            echo "<pre>";
            var_dump($code);
            echo "</pre>";
        } else {
            echo "<pre>";
            print_r($code);
            echo "</pre>";
        }
        if($die) die();
    }
    
    function truncateHtml($html, $length) {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);
        $nodes = $xpath->query('//text()');

        $textLength = 0;
        $truncateIndex = null;

        foreach ($nodes as $index => $node) {
            $textLength += strlen($node->nodeValue);

            if ($textLength > $length && $truncateIndex === null) {
                $truncateIndex = $index;
                $charsToKeep = $length - ($textLength - strlen($node->nodeValue));
            }
        }

        if ($truncateIndex !== null) {
            $nodes[$truncateIndex]->nodeValue = substr($nodes[$truncateIndex]->nodeValue, 0, $charsToKeep);
            
            for ($i = $nodes->count() - 1; $i > $truncateIndex; $i--) {
                $node = $nodes->item($i);
                $node->parentNode->removeChild($node);
            }
        }

        $html = $dom->saveHTML();

        // Remove empty tags
        $html = preg_replace('/<([^<\/>]*)>([\s]*?|(?R))<\/\1>/i', '', $html);
        $html = preg_replace('/<p[^>]*>(\s|&nbsp;)*<\/p>/i', '', $html);
        return trim($html);
    }

    function sanitizeInput($input) {
        if (is_array($input)) {
            foreach ($input as $key => $value) {
                $input[$key] = $this->sanitizeInput($value);
            }
        } else {
            $input = trim($input);
            $input = stripslashes($input);
            $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
            $input = $this->db->escapeString($input);
        }
        return $input;
    }
    
    



}


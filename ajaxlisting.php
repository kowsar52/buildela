
<?php



require_once "serverside/functions.php";
include_once "serverside/session.php";

$func           =   new Functions();
$ajaxid         =   $_GET['ajaxid'];

if($ajaxid == 1){
    
    $userInfo       =   $func->UserInfo($_SESSION['user_id']);
    $my_skills      =   $func->getMySkills($_SESSION['user_id']);
    $func->set_last_seen($_SESSION['user_id']);

    $jobPostCodes   =   [];
    $distanceOfJobs =   [];
    $showJobs       =   [];
    $jobids         =   [];
    $send           =   [];
    $countjobs      =   0;
    $send           =   [];
    $send['unread'] =   0;
    $identifier     =   '';

    $user_post_code=$userInfo[0]['post_code'];

    $offset         =   isset($_GET['offset']) ? intval($_GET['offset']) : 0;
    $limit          =   50;

    if(isset($_GET['filter'])){

        $send['filter'] = $_GET['filter'];

        if($_GET['filter'] === '0') $identifier = 'interested';
        elseif($_GET['filter'] === '1') $identifier = 'shortlisted';
        elseif($_GET['filter'] === '2') $identifier = 'jobswon';


        $Main_jobs_array=$func->getSearchJobs($_GET['filter'],$_SESSION['user_id']);

        foreach($Main_jobs_array as $jobs){
            foreach ($jobs as $job){
                $job_post_code=$job['post_code'];
                $job_post_code = preg_replace('/\s+/', '', $job_post_code);
                $user_post_code = preg_replace('/\s+/', '', $user_post_code);

                $mile = $func->DistanceCalculation([$job_post_code, $user_post_code], 'mile');
                $distance = array(
                    "meters" => $mile * 1609.34,
                    "kilometers" => $mile * 1.60934,
                    "yards" => $mile * 1760,
                    "miles" => $mile
                );                

                if($distance['miles'] <= $userInfo[0]['distance']){
                    array_push($showJobs,$job);
                    array_push($distanceOfJobs,$distance['miles']);
                    array_push($jobids,$job['id']);                
                }

            }//foreach

        }//foreach
        $countjobs=count($showJobs);

    }else if(isset($_GET['category'])){

        $identifier     =   'leads';

        $Main_jobs_array=$func->getFilterJobs($_GET['category']);
        foreach($Main_jobs_array as $jobs){
            $job_post_code=$jobs['post_code'];
            $job_post_code = preg_replace('/\s+/', '', $job_post_code);
            $user_post_code = preg_replace('/\s+/', '', $user_post_code);

            $mile = $func->DistanceCalculation([$job_post_code, $user_post_code], 'mile');
            $distance = array(
                "meters" => $mile * 1609.34,
                "kilometers" => $mile * 1.60934,
                "yards" => $mile * 1760,
                "miles" => $mile
            );

            if($distance['miles'] <= $userInfo[0]['distance']){
                array_push($showJobs,$jobs);
                array_push($distanceOfJobs,$distance['miles']);
                array_push($jobids,$jobs['id']);
            }
        }//foreach


    } else{

        $identifier     =   'leads';

        $Main_jobs_array = $func->getMatchJobs($_SESSION['user_id']);


        // Collect job post codes
        foreach ($Main_jobs_array as $jobs) {
            $job_post_code = $jobs['post_code'];
            $jobPostCodes[] = preg_replace('/\s+/', '', $job_post_code);        
        }

        if(!$func->isLeadRead($jobs['id'])) $send['unread']++;

        $send['totoal_jobs_count'] = count($jobPostCodes);

        $batchSize = 25; // Define the batch size
        $jobPostCodeBatches = array_chunk($jobPostCodes, $batchSize);        

        $user_post_code = str_replace(' ', '', $user_post_code);
        $startIndex = 0;
        foreach ($jobPostCodeBatches as $batch) {
            $limit_ch = count($batch);

            $result = $func->batchDistance($user_post_code, $batch, 'mile');

            $Main_jobs_array_slice = array_slice($Main_jobs_array, $startIndex, 25);
            $startIndex += $limit_ch;
        
            $i = 0;
            // Process the results for each job in the batch
            foreach ($Main_jobs_array_slice as $index => $jobs) {

                    $distance = array(
                        "meters" => $result[$i] * 1609.34,
                        "kilometers" => $result[$i] * 1.60934,
                        "yards" => $result[$i] * 1760,
                        "miles" => $result[$i]
                   );
                    // $send[] = $distance;
                    if ($distance['miles'] <= $userInfo[0]['distance']) {
                        $showJobs[] = $jobs;
                        $distanceOfJobs[] = $distance['miles'];
                        $jobids[] = $jobs['id'];
                    }  
                    $i++;              
            }
        }    

    }


    $countjobs = count($showJobs);
    if($countjobs) foreach($showJobs as $jobs) if(!$func->isLeadRead($jobs['id'])) $send['unread']++;


    $idstrings          =   implode(', ', $jobids);
    $send['idstrings']  =   $idstrings;

    ob_start();
    ?>



    <div class="single-leads-list-links-wrapper">
    <!-- Listing -->
    <?php


    for ($i = $offset ; $i < ($offset + $limit) && $i < count($showJobs) ; $i++){

        $main       =   $func->SingleMainCategory($showJobs[$i]['main_type']);
        $sub        =   $func->SingleSubCategory($showJobs[$i]['sub_type']);
        $options    =   $func->getSingleOptions($showJobs[$i]['options']);
        $user       =   $func->getuserdetails($showJobs[$i]['user_id']);
        $new_chat   =   $func->getAllNewChates($showJobs[$i]['user_id'],$showJobs[$i]['id']);
        $check_chat_exist=$func->isChatexist($showJobs[$i]['id']);
        $subdate    =   $showJobs[$i]['created_date'];
        $earlier    =   new DateTime($subdate);
        $later      =   new DateTime(date("Y-m-d H:i:s"));
        $diff       =   $later->diff($earlier)->format("%a");
        $isRead     =   $func->isLeadRead($showJobs[$i]['id']);

        
        
        ?>
        <a onclick="_openModal(<?=$showJobs[$i]['id']?>,<?=round($distanceOfJobs[$i],1)?>,<?=$countjobs?>,this);openmbui();" class="lead-detail-link <?php if(!$isRead) echo "unreadlead";?>" data-jid="<?=$showJobs[$i]['id']?>" data-identity="<?= $identifier; ?>">
            <div class="single-lead ">
                <div class="border-wrapper">
                    <div class="leads-table  bg-white p-3">
                        <table class="leads-table-inner">
                            <?php if( isset($_GET['filter']) && (!empty($check_chat_exist))){ ?>
                                
                                <div class="position-relative chatbx">
                                    <a href="chat?touserid=<?=$showJobs[$i]['user_id']?>&jobid=<?=$showJobs[$i]['id']?>" >
                                        <i class="fa-solid fa-envelope fa-2xl"></i>
                                    </a>
                                    <?php if( isset($_GET['filter']) && count($new_chat)>0 ){ ?>
                                        <span style="top: -6px;
                                        right: -4px;
                                        font-size: 10px;
                                        color: #fff;
                                        min-width: 14px;
                                        min-height: 14px;
                                        text-align: center;line-height: 14px;border-radius: 50%!important;" class="bg-danger position-absolute rounded-circle px-1"><?= count($new_chat)?>
                                        </span>
                                    <?php } ?>

                                </div>
        
                            <?php  } ?>
            
                            <tr class="alert">
                                <td><i class="fas fa-bolt px-2 text-center"></i></td>
                                <td>
                                    <?=$showJobs[$i]['title']?> <?php if($diff==0){
                                        $houre = $later->diff($earlier);
                                        $houres=$houre->h;
                                        if($houres == 0){
                                            $time.="";
                                        }else{
                                            $time.="";
                                        }
                                        if($houres<=12){
                                            $new_leades='<span class="px-2 py-1 new-ld"> New lead</span>';
                                        }       
                                    } ?>
                                </td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-tools px-2 text-center"></i></td>
                                <td><?=$main[0]['category_name']?></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-map-marker-alt px-2"></i></td>
                                <td><?=$func->getCityName($showJobs[$i]['post_code']) .", ".$func->breakPostalCode($showJobs[$i]['post_code'])?> <?php $distance = round($distanceOfJobs[$i], 1); if ($distance > 1) { echo $distance . ' miles'; } else { echo $distance . ' mile';}?></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-calendar-alt px-2 text-center"></i></td>
                                <td>
                                    <?php
                                    if($diff==0){
                                        $houre = $later->diff($earlier);
                                        echo $func->formatPostedTime($houre->h);

                                    }else{
                                        echo $func->formatPostedDay($diff);
                                    }

                                    ?>
                                </td>
                            </tr> 
                        </table>
                    </div>
                </div>
            </div>
        </a>

        <?php }  ?>

    </div>
    </div>

    <?php 
    $htmloutput = ob_get_clean();



    $send['html']           = $htmloutput;
    // $send['ids']            = $jobids;
    $send['counter']        = $countjobs;
    // $send['user_miles']     = $userInfo[0]['distance'];
    // $send['Main_jobs_array']= count($Main_jobs_array);

    if($countjobs < 51 ) $send['morejobs'] = false;
    elseif($offset >= $countjobs) $send['morejobs'] = false;
    else $send['morejobs'] = true;


    echo json_encode($send);

    exit();

} 

elseif ($ajaxid == 2) {


    if(isset($_SESSION)){

        $userInfo           =   $func->UserInfo($_SESSION['user_id']);  
        $user_post_code     =   $userInfo[0]['post_code'];
        $jobPostCodes       =   [];
        $send               =   [];
        $filterarray        =   [0, 1, 2];

        
        for($i=0; count($filterarray) > $i; $i++){

            $FilterJobs     =  $func->getSearchJobs($i,$_SESSION['user_id'])[0];

            if($FilterJobs)  {

                foreach($FilterJobs as $job){

                    $job_post_code=$job['post_code'];
                    $job_post_code = preg_replace('/\s+/', '', $job_post_code);
                    $user_post_code = preg_replace('/\s+/', '', $user_post_code);

                    $mile = $func->DistanceCalculation([$job_post_code, $user_post_code], 'mile');

                    $distance = array(
                        "meters" => $mile * 1609.34,
                        "kilometers" => $mile * 1.60934,
                        "yards" => $mile * 1760,
                        "miles" => $mile
                    );
                    
                    if($distance['miles'] <= $userInfo[0]['distance']){
                        if($i === 0 && !$func->isLeadRead($job['id'], 'interested')) $send['interested_count']++;
                        if($i === 1 && !$func->isLeadRead($job['id'], 'shortlisted')) $send['shortlisted_count']++;
                        if($i === 2 && !$func->isLeadRead($job['id'], 'jobswon')) $send['jobswon_count']++;             
                    }
                }
            }
        }
       

        
        // Lead counter
        $leadsarray = $func->getMatchJobs($_SESSION['user_id']);

        foreach ($leadsarray as $jobs) {
            $job_post_code = $jobs['post_code'];
            $jobPostCodes[] = preg_replace('/\s+/', '', $job_post_code);        
        }



        $batchSize = 25;
        $jobPostCodeBatches = array_chunk($jobPostCodes, $batchSize);

        $user_post_code = str_replace(' ', '', $user_post_code);
        $startIndex = 0;

        foreach ($jobPostCodeBatches as $batch) {
            
            $limit_ch = count($batch);

            $result = $func->batchDistance($user_post_code, $batch, 'mile');  
            $leadsarray_slice = array_slice($leadsarray, $startIndex, 25);
            $startIndex += $limit_ch;

            $i = 0;
            foreach ($leadsarray_slice as $index => $jobs) {
                    $distance = array(
                        "meters" => $result[$i] * 1609.34,
                        "kilometers" => $result[$i] * 1.60934,
                        "yards" => $result[$i] * 1760,
                        "miles" => $result[$i]
                   );
                    
                    if ($distance['miles'] <= $userInfo[0]['distance']) {
                        if(!$func->isLeadRead($jobs['id'], 'leads')) $send['leads_count']++;  
                    }  
                    
                    $i++;
            }
        }    


        echo json_encode($send);

        exit();
    }

}




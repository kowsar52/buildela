
<?php



require_once "serverside/functions.php";
include_once "serverside/session.php";

$func           =   new Functions();
$ajaxid         =   $_GET['ajaxid'];

if($ajaxid == 1){
    
    $userInfo       =   $func->UserInfo($_SESSION['user_id']);
    $my_skills      =   $func->getMySkills($_SESSION['user_id']);
    $func->setlastSeen($_SESSION['user_id']);

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
    $limit          =   20;

    if(isset($_GET['filter'])){

        $send['filter'] = $_GET['filter'];

        if($_GET['filter'] === '0') $identifier = 'interested';
        elseif($_GET['filter'] === '1') $identifier = 'shortlisted';
        elseif($_GET['filter'] === '2') $identifier = 'hired';

        $jobs = $func->fetchleads($identifier, true);

        $showJobs = $jobs['jobs'];

    }else if(isset($_GET['category'])){

        $identifier     =   'leads';

        $cats = $func->sanitizeInput($_GET['category']);

        if (!is_array($cats)) {
            if (is_string($cats) || is_int($cats)) {
                $cats = [$cats];
            } 
        }        

        $jobs = $func->fetchleads('filter', true, $cats );
        $showJobs = $jobs['jobs'];


    } else{

        $identifier     =   'leads';

        $jobs = $func->fetchleads('leads');
        $showJobs = $jobs['jobs'];

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
        $isRead     =   $leads[$i]['read_lead'];
        if(!$isRead) $send['unread']++; 
        
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
                                <td><?= $showJobs[$i]['location'] .", ".$func->breakPostalCode($showJobs[$i]['post_code'])?> <?php $showJobs[$i]['distance_in_miles']." miles" ?></td>
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
    $send['counter']        = $countjobs;

    if($countjobs < 51 ) $send['morejobs'] = false;
    elseif($offset >= $countjobs) $send['morejobs'] = false;
    else $send['morejobs'] = true;


    echo json_encode($send);

    exit();

} 

elseif ($ajaxid == 2) {


    if(isset($_SESSION)){

        $counts = $func->liveleadsUpdate();  
        echo json_encode($counts);

        exit();
    }

}




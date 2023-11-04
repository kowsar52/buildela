<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


include_once "serverside/functions.php";
include_once "serverside/session.php";

$func=new Functions();
$user=$func->UserInfo($_SESSION['user_id']);
$user=$user[0];
$images=$func->getMyGallery($_SESSION['user_id']);

  
$user_id = $_SESSION['user_id']; 
if (isset($_GET['month'])) {
    $selectedMonthYear = explode("-", $_GET['month']);
    $currentMonth = $selectedMonthYear[1];
    $currentYear = $selectedMonthYear[0];
} else {
    // Default to current month and year if no parameter is found
    $currentMonth = null;
    $currentYear = null;
}

$jobCompletionPercentage = $func->getJobCompletionTime($user_id, $currentMonth, $currentYear);
$jobAccuracyTime = $func->getJobAccuracyTime($user_id, $currentMonth, $currentYear);
$getAverageResponseTime = $func->getAverageResponseTime($user_id,$currentMonth,$currentYear);
$getAvgResponseTimeToLead = $func->getAvgResponseTimeToLead($user_id,$currentMonth,$currentYear);
$getPostiveFeedback = $func->getPostiveFeedback($user_id,$currentMonth,$currentYear);
$getJobData = $func->getJobData($user_id,$currentMonth,$currentYear);
$getTotalLeadsRecieved = $func->getTotalLeadsRecieved($user_id);




$jobCompletionPercentage_all = $func->getJobCompletionTime();
$getAverageResponseTime_all = $func->getAverageResponseTime();
$getAvgResponseTimeToLead_all = $func->getAvgResponseTimeToLead();
$getPostiveFeedback_all = $func->getPostiveFeedback();
$getAllAppliedJob = $func->getAllAppliedJob();

// Get the raw counts
$appliedCount = $getJobData['applied'];
$shortlistedCount = $getJobData['shortlisted'];
$hiredCount = $getJobData['hired'];
$notAppliedCount = $getJobData['not_applied'];

// Calculate total jobs for offset calculations
$total_jobs = $appliedCount + $shortlistedCount + $hiredCount + $notAppliedCount;




include_once "includes/header.php";
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    .monthly_report{
        background-color: rgb(245 245 245);
    }
    .monthly_report .monthly_report_inner{
        padding-bottom: 50px;
    }
    .monthly_report .monthly_report_head{
        padding: 40px 0 34px 0;
    }
    .monthly_report .monthly_report_head .head{
        font-size: 40px;
        text-align: center;
        color: rgb(69 69 70);
    }
    .monthly_report .monthly_report_filter_sec{
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #fffffd;
        border-radius: 5px;
        padding: 15px 30px;
        box-shadow: rgba(149, 157, 165, 0.2) 0px 3px 5px;
        margin-bottom: 30px;
    }
    .monthly_report .monthly_report_filter_sec > div{
        width: 33.334%;
    }
    .monthly_report .filter_date_container_outer{
        display: flex;
        justify-content: center;
    }
    .monthly_report .filter_emails_btn_outer{
        display: flex;
        justify-content: right;
    }
    .monthly_report .filter_date_container{
        padding: 7px 13px;
        background-color: rgb(231 243 254);
        color: rgb(81 178 249);
        border-radius: 50px;
    }
    .monthly_report .filter_date_container .filter_date{
        font-size: 15px;
        margin-bottom: 0;
        color: rgb(81 178 249);
    }
    .monthly_report .filter_btn{
        font-size: 16px;
        margin: 0;
        text-transform: uppercase;
    }
    .monthly_report .filter_btn i{
        margin-right: 7px;
        border-radius: 50px;
        transition: 0.5s;
        padding: 9px 8px 7px 8px;
        cursor: pointer;
    }
    .monthly_report .filter_btn_container .filter_item_box_list{
        list-style: none;
    } 
    .monthly_report .filter_btn_container{
        position: relative;
    }
    .monthly_report .filter_btn_container .filter_item_box{
        position: absolute;
        left: 0;
        top: 32px;
        padding: 15px 10px;
        background-color: white;
        border-radius: 5px;
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
        width: 200px;
        max-height: 200px;
        overflow-y: auto;
    }
    .monthly_report .filter_btn_container .filter_item_box .filter_item_box_item{
        cursor: pointer;
    }
    .monthly_report .filter_btn_container .filter_item_box::-webkit-scrollbar {
        width: 5px;
    }
    .monthly_report .filter_btn_container .filter_item_box::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .monthly_report .filter_btn_container .filter_item_box::-webkit-scrollbar-thumb {
        background: #747476;
        border-radius: 10px;
    }
    .monthly_report .filter_btn i:hover, .monthly_report .filter_btn i:active{
        background-color: rgba(0, 0, 0, 0.2);
    }
    .monthly_report .filter_emails_btn .filter_form_opt{
        appearance: none;
        border: none;
        font-size: 18px;
        background-color: transparent;
        padding-right: 19px;
        outline: none !important;
        cursor: pointer;
    }
    .monthly_report .filter_emails_btn .filter_form{
        position: relative;
        z-index: 1;
    }
    .monthly_report .filter_emails_btn .filter_form lable{
        margin: 0;
    }
    .monthly_report .filter_emails_btn .filter_form i{
        position: absolute;
        top: 7px;
        right: 0;
        z-index: -1;
    }
    .monthly_report .monthly_report_box_container{
        display: flex;
        justify-content: center;
        background-color: #fffffd;
        border-radius: 5px;
        padding: 40px 25px;
    }
    .monthly_report .monthly_report_box_container .box{
        width: 20%;
        border: 1px solid #ccc;
        border-top: 0;
        border-bottom: 0;
        border-left: 0;
        text-align: center;
        padding: 0 20px;
    }
    .monthly_report .monthly_report_box_container .box:first-child{
        border-left-color: transparent;
    }
    .monthly_report .monthly_report_box_container .box:last-child{
        border-right-color: transparent;
    }
    .monthly_report .monthly_report_box_container .box .box_icon_container i{
        font-size: 35px;
        color: rgb(43 186 116);
        margin-bottom: 15px;
    }
    .monthly_report .monthly_report_box_container .box .box_head_container .head{
        font-size: 20px;
        line-height: 30px;
        color: rgb(116 116 118);
        margin-bottom: 10px;
        min-height: 70px;
    }
    .monthly_report .monthly_report_box_container .box .box_head_container .head abbr{
        border-bottom: 0px !important;
    }
    .monthly_report .monthly_report_box_container .box .box_head_container .head i{
        font-size: 12px;
        cursor: pointer;
    }
    .monthly_report .monthly_report_box_container .box .box_data_container .box_data{
        font-size: 40px;
        font-weight: 700;
        margin-bottom: 38px;
    }
    .monthly_report .monthly_report_box_container .box .box_data_perstange_container .box_data{
        margin: 0 auto;
        background-color: rgb(215 241 227);
        border-radius: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
        width: fit-content;
        padding: 2px 15px 2px 2px;
        color: rgb(46 186 116);
        font-size: 15px;
        font-weight: 700;
    }
    .monthly_report .monthly_report_box_container .box .box_data_perstange_container .box_data i{
        padding: 9px 10px 7px 10px;
        background-color: rgb(46 186 116);
        font-size: 16px;
        margin-right: 10px;
        border-radius: 50px;
        color: white;
    }
    .monthly_report .box_data_container .time_box_data{
        display: flex;
        justify-content: center;
        column-gap: 15px;
        align-items: center;
    }
    .monthly_report .monthly_report_box_container .box .box_data_perstange_container{
        padding-top: 13px;
    }
    .monthly_report .box_data_container .time_box_data > p{
        display: flex;
        flex-direction: column;
    }
    .monthly_report .box_data_container .time_box_data .box_info_persontage{
        font-size: 40px;
        font-weight: 700;
    }
    .monthly_report .monthly_report_box_container .box .box_data_perstange_container.red_box_btn .box_data i{
        background-color: rgb(221 73 90);
    }
    .monthly_report .monthly_report_box_container .box .box_data_perstange_container.red_box_btn .box_data{
        background-color: rgb(252 236 239);
        color: #dd495a;
    }
    .leads_sec{
        padding-bottom: 50px;
    }
    .leads_sec .leads_sec_inner{
        padding: 0 37px;
    }
    .leads_sec .leads_sec_head{
        padding: 40px 0 34px 0;
    }
    .leads_sec .leads_sec_progress_sec{
        display: flex;
        column-gap: 50px;
        overflow: hidden;
    }
    .leads_sec .leads_sec_head .head{
        font-size: 30px;
        color: rgb(69 69 70);
    }
    .leads_sec .leads_sec_progress_bar{
        position: relative;
        width: 400px;
        height: 400px;
        transform: rotate(328deg);
    }
    .leads_sec .leads_sec_progress_bar .bar{
        /*width: 400px;
        height: 400px;*/
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        top: 0;
        border-radius: 50%;
        transform: rotate(303deg);   
    }
    .b_name{
        display: block;
        font-size: 13.92px;
        font-weight: 400;
    }
    .leads_sec .leads_sec_progress_bar .bar_1{
        transform: rotate(303deg);
        z-index: 4;
    }
    .leads_sec .leads_sec_progress_bar .bar_2{
        transform: rotate(303deg);
        z-index: 3;
    }
    .leads_sec .leads_sec_progress_bar .bar_3{
        transform: rotate(303deg);
        z-index: 2;
    }
    .leads_sec .leads_sec_progress_bar .bar_4{
        transform: rotate(303deg);
        z-index: -1;
        border: 10px solid white;
    }
    .leads_sec .leads_sec_progress_bar .bar_5{
        z-index: 5;
        transform: rotate(32deg);
        background-color: #e3f6fe;
        left: 105px;
        right: 105px;
        bottom: 105px;
        top: 105px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .leads_sec .leads_sec_progress_bar .bar_5 i{
        font-size: 60px;
        color: #ff8db1;
        -webkit-text-stroke: 5px #011e41;
    }
    .leads_sec .leads_sec_progress_bar_info{
        padding: 50px 0;
    }
    .leads_sec .leads_sec_progress_bar_info .leads_sec_progress_bar_info_box .leads_info_head{
        color: rgb(26 72 98);
        font-size: 20px;
        margin-bottom: 7px;
        display: flex;
        line-height: initial;
    }
    .leads_sec .leads_sec_progress_bar_info .leads_sec_progress_bar_info_box .leads_info_head .color_box{
        width: 26px;
        height: 26px;
        background-color: #015892;
        margin-right: 15px;
    }
    .leads_sec .leads_sec_progress_bar_info .leads_sec_progress_bar_info_box .leads_info_info{
        font-size: 17px;
        text-align: left;
        color: #015892;
        margin-bottom: 12px;
    }
    .leads_sec .leads_sec_progress_bar_info .leads_sec_progress_bar_info_box_2 .leads_info_head .color_box{
        background-color: #ff1a5a;
    }
    .leads_sec .leads_sec_progress_bar_info .leads_sec_progress_bar_info_box_3 .leads_info_head .color_box{
        background-color: #011e41;
    }
    .leads_sec .leads_sec_progress_bar_info .leads_sec_progress_bar_info_box_4 .leads_info_head .color_box{
        background-color: #c3f3fc;
    }
    .leads_sec .leads_sec_progress_bar_info .leads_sec_progress_bar_info_box_2 .leads_info_info{
        color: #ff1a5a;
    }
    .leads_sec .leads_sec_progress_bar_info .leads_sec_progress_bar_info_box_3 .leads_info_info{
        color: #011e41;
    }
    .leads_sec .leads_sec_progress_bar_info .leads_sec_progress_bar_info_box_4 .leads_info_info{
        color: #c3f3fc;
    }
    .leads_table_sec{
        padding: 50px 0;
    }
    .leads_table_sec .leads_table_container{
        width: 70%;
        margin: 0 auto;
    }
    .leads_table_sec .leads_table_container .leads_table{
        width: 100%;
        border: 2px solid #ccc;
    }
    .leads_table_sec .leads_table_container .leads_table th, .leads_table_sec .leads_table_container .leads_table td{
        outline: 3px solid #ccc;
        text-align: center;
        font-size: 20px;
        padding: 10px;
    }
    .leads_table_sec .leads_table_container .leads_table th{
        font-size: 30px;
    }
    @media screen and (max-width: 1250px){
        /*.container{
            max-width: 1050px;
        }*/
        .monthly_report .monthly_report_box_container .box .box_head_container .head{
            font-size: 16px;
        }
        .monthly_report .monthly_report_box_container .box .box_data_container .box_data{
            font-size: 30px;
            margin-bottom: 13px;
        }
        .monthly_report .box_data_container .time_box_data .box_info_persontage{
            font-size: 30px;
        }
        .monthly_report .box_data_container .time_box_data .b_name{
            font-size: 11px;
        }
    }
    @media screen and (max-width: 1075px){
        /*.container{
            max-width: 920px;
        }*/
        .monthly_report .monthly_report_box_container{
            flex-wrap: wrap;
            row-gap: 20px;
        }
        .monthly_report .monthly_report_box_container .box{
            width: 32.34%;
            padding: 15px;
        }
        .monthly_report .monthly_report_box_container .box:nth-child(3){
            border-right: 0;
        }
    }
    @media screen and (max-width: 980px){
        /*.container{
            max-width: 840px;
        }*/
    }
    @media screen and (max-width: 900px){
        /*.container{
            max-width: 700px;
        }*/
        .leads_sec .leads_sec_progress_sec{
            flex-direction: column;
        }
        .leads_sec .leads_sec_progress_bar{
            margin: 0 auto;
        }
        .leads_sec .leads_sec_progress_bar_info{
            padding-bottom: 0;
        }
        .leads_sec .leads_sec_inner{
            padding: 0;
        }
    }
    @media screen and (max-width: 767px){
        /*.container{
            max-width: 600px;
        }*/
        .leads_table_sec .leads_table_container{
            width: 100%;
        }
        .leads_table_sec .leads_table_container .leads_table th{
            font-size: 25px;
        }
        .leads_table_sec .leads_table_container .leads_table td{
            font-size: 17px;
        }
        .monthly_report .monthly_report_filter_sec{
            row-gap: 10px;
            flex-wrap: wrap;
        }
        .monthly_report .monthly_report_filter_sec > div{
            width: 100%;
            display: flex;
            justify-content: center;
        }
        .monthly_report .monthly_report_head .head{
            font-size: 30px;
        }
        .monthly_report .monthly_report_box_container .box{
            width: 50%;
            border-bottom: 1px solid #ccc;
            padding: 30px 15px;
        }
        .monthly_report .monthly_report_box_container{
            row-gap: 0;
        }
        .monthly_report .monthly_report_box_container .box:nth-child(even){
            border-right: 0;
        }
        .monthly_report .monthly_report_box_container .box:last-child{
            border-bottom: 0;
            padding-bottom: 0;
        }
        .leads_sec .leads_sec_progress_bar{
            width: 300px;
            height: 300px;
        }
        .leads_sec .leads_sec_head .head{
            font-size: 25px;
        }
        .monthly_report .monthly_report_box_container .box:nth-child(3){
            border-right: 1px solid #ccc;
        }
    }
    @media screen and (max-width: 576px){
        /*.container{
            max-width: 100%;
        }*/
    }
    @media screen and (max-width: 500px){
        .monthly_report .monthly_report_box_container .box{
            width: 100%;
            border-right: 0;
        }
        .monthly_report .monthly_report_box_container .box .box_head_container .head{
            min-height: initial;
        }
        .monthly_report .monthly_report_box_container .box:nth-child(3){
            border-right: 0;
        }
    }
</style>

<section class="monthly_report" id="monthly_report">
    <div class="container">
        <div class="monthly_report_inner">
            <div class="monthly_report_header">
                <div class="monthly_report_head">
                    <h2 class="head">My Monthly Report</h2>
                </div>
                <div class="monthly_report_filter_sec">
                    <div class="filter_btn_container">

                    </div>
                    <div class="filter_date_container_outer">
                        <div class="filter_date_container">
                            <label for="monthPicker">FILTER EMAILS</label>
                            <input type="month" id="monthPicker" name="monthPicker"  max="">
                            <button onclick="applyFilter()">Apply</button>
                        </div>
                    </div>
                    <div class="filter_emails_btn_outer">
                        <div class="filter_emails_btn">

                        </div>
                    </div>
                </div>
                <div class="monthly_report_box_container">
                    <div class="box">
                        <div class="box_icon_container">
                            <i class="fa-regular fa-envelope"></i>
                        </div>
                        <div class="box_head_container">
                            <h3 class="head">Job Completion Time <abbr title="info"><i class="fa-solid fa-circle-info"></i></abbr></h3>
                        </div>
                        <div class="box_data_container">
                            <p class="box_data">
                                <span class="box_info_persontage"><?php echo $jobCompletionPercentage; ?></span>%
                            </p>
                        </div>
                        <!-- <div class="box_data_perstange_container red_box_btn">
                            <p class="box_data">
                                <i class="fa-solid fa-arrow-down"></i>
                                <span class="box_info_persontage">58</span>%
                            </p>
                        </div> -->
                    </div>
                    <div class="box">
                        <div class="box_icon_container">
                            <i class="fa-regular fa-user"></i>
                        </div>
                        <div class="box_head_container">
                            <h3 class="head">Job Cost Estimation Accuracy <abbr title="info"><i class="fa-solid fa-circle-info"></i></abbr></h3>
                        </div>
                        <div class="box_data_container">
                            <p class="box_data">
                                <span class="box_info_persontage"><?= $jobAccuracyTime ?></span>%
                            </p>
                        </div>
                        <!-- <div class="box_data_perstange_container red_box_btn">
                            <p class="box_data">
                                <i class="fa-solid fa-arrow-down"></i>
                                <span class="box_info_persontage">69</span>%
                            </p>
                        </div> -->
                    </div>
                    <div class="box">
                        <div class="box_icon_container">
                            <i class="fa-regular fa-clock"></i>
                        </div>
                        <div class="box_head_container">
                            <h3 class="head">Avg Response Time <abbr title="info"><i class="fa-solid fa-circle-info"></i></abbr></h3>
                        </div>
                        <div class="box_data_container">
                            <div class="time_box_data">
                                <p class="minuts">
                                    <span class="box_info_persontage minu"><?= $getAverageResponseTime; ?></span>
                                    <span class="b_name">Hours</span>
                                </p>
                          <!--       <p class="secounds">
                                    <span class="box_info_persontage sec">57</span>
                                    <span class="b_name">Secounds</span>
                                </p> -->
                            </div>
                        </div>
                        <!-- <div class="box_data_perstange_container">
                            <p class="box_data">
                                <i class="fa-solid fa-arrow-down"></i>
                                <span class="box_info_persontage">23</span>%
                            </p>
                        </div> -->
                    </div>
                    <div class="box">
                        <div class="box_icon_container">
                            <i class="fa-regular fa-envelope" style="color: rgb(48 164 247);"></i>
                        </div>
                        <div class="box_head_container">
                            <h3 class="head">Avg Response Time To Leads <abbr title="info"><i class="fa-solid fa-circle-info"></i></abbr></h3>
                        </div>
                        <div class="box_data_container">
                            <p class="box_data">
                                <span class="box_info_persontage"><?= $getAvgResponseTimeToLead; ?></span>
                                <span class="b_name">Hours</span>
                            
                            </p>
                        </div>
                        <!-- <div class="box_data_perstange_container">
                            <p class="box_data">
                                <i class="fa-solid fa-arrow-up"></i>
                                <span class="box_info_persontage">14</span>%
                            </p>
                        </div> -->
                    </div>
                    <div class="box">
                        <div class="box_icon_container">
                            <i class="fa-regular fa-user" style="color: rgb(48 164 247);"></i>
                        </div>
                        <div class="box_head_container">
                            <h3 class="head">% Of Jobs With Positive Feedback <abbr title="info"><i class="fa-solid fa-circle-info"></i></abbr></h3>
                        </div>
                        <div class="box_data_container">
                            <p class="box_data">
                                <span class="box_info_persontage"><?= $getPostiveFeedback; ?></span>%
                            </p>
                        </div>
                        <!-- <div class="box_data_perstange_container">
                            <p class="box_data">
                                <i class="fa-solid fa-arrow-up"></i>
                                <span class="box_info_persontage">12</span>%
                            </p>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="leads_sec" id="leads_sec">
    <div class="container">
        <div class="leads_sec_inner">
            <div class="leads_sec_head">
                <h2 class="head">Total Leads Received : <span class="leads_value"><?= $getTotalLeadsRecieved; ?></span></h2>
            </div>
            <div class="leads_sec_progress_sec">
                <div class="leads_sec_progress_bar">
                    <div class="bar bar_1"></div>
                    <div class="bar bar_2"></div>
                    <div class="bar bar_3"></div>
                    <div class="bar bar_4"></div>
                    <div class="bar bar_5">
                        <i class="fa-solid fa-envelope" style="--fa-primary-color: #022345; --fa-secondary-color: #ff8db1;"></i>
                    </div>
                </div>
                <div class="leads_sec_progress_bar_info">
                    <div class="leads_sec_progress_bar_info_box leads_sec_progress_bar_info_box_1">
                        <h3 class="leads_info_head">
                            <div class="color_box"></div>
                            <span class="value"><?php echo $appliedCount; ?></span>
                        </h3>
                        <p class="leads_info_info">
                            Number of jobs applied for
                        </p>
                    </div>
                    <div class="leads_sec_progress_bar_info_box leads_sec_progress_bar_info_box_2">
                        <h3 class="leads_info_head">
                            <div class="color_box"></div>
                            <span class="value"><?php echo $shortlistedCount; ?></span>
                        </h3>
                        <p class="leads_info_info">
                            Number of jobs till end
                        </p>
                    </div>
                    <div class="leads_sec_progress_bar_info_box leads_sec_progress_bar_info_box_3">
                        <h3 class="leads_info_head">
                            <div class="color_box"></div>
                            <span class="value"><?php echo $hiredCount; ?></span>
                        </h3>
                        <p class="leads_info_info">
                            Number of jobs hired
                        </p>
                    </div>
                    <div class="leads_sec_progress_bar_info_box leads_sec_progress_bar_info_box_4">
                        <h3 class="leads_info_head">
                            <div class="color_box"></div>
                            <span class="value"><?php echo $notAppliedCount; ?></span>
                        </h3>
                        <p class="leads_info_info">
                            Number of jobs not applied
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="leads_table_sec" id="leads_table_sec">
    <div class="container">
        <div class="leads_table_container">
            <table class="leads_table">
                <thead>
                    <tr>
                        <th>Buildel Average Response Time</th>
                        <th>&#160;</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                             Response Time 
                        </td>
                        <td><?= $getAverageResponseTime_all ?> <span class="b_name">Hours</span></td>
                    </tr>
                    <tr>
                        <td>
                            Completion Time 
                        </td>
                        <td><?= $jobCompletionPercentage_all ?>%</td>
                    </tr>
                    <tr>
                        <td>
                            Response to leads 
                        </td>
                        <td><?= $getAvgResponseTimeToLead_all ?> <span class="b_name">Hours</span></td>
                    </tr>
                    <tr>
                        <td>
                            % positive feedback
                        </td>
                        <td><?= $getPostiveFeedback_all ?>%</td>
                    </tr>
                    <tr>
                        <td>
                            # of jobs applied for
                        </td>
                        <td><?= $getAllAppliedJob ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
    // const d = new Date();
    // const year = d.getFullYear();
    // const month = d.toLocaleString('default', { month: 'long' });
    // jQuery(".monthly_report .filter_date_container .filter_date .month").html(month);
    // jQuery(".monthly_report .filter_date_container .filter_date .year").html(year);

    var progress_1 = <?php echo $appliedCount ?>;
    var progress_2 = <?php echo $shortlistedCount ?> + progress_1;
    var progress_3 = <?php echo $hiredCount ?> + progress_2;
    var progress_4 = <?php echo $notAppliedCount ?> + progress_3;





    jQuery(".leads_sec .leads_sec_progress_bar .bar_1").css("background", 'radial-gradient(closest-side, white 52%, transparent 53% 100%), conic-gradient(#015892 '+ progress_1 +'%, transparent 0)');
    jQuery(".leads_sec .leads_sec_progress_bar .bar_2").css("background",'radial-gradient(closest-side, #ffffff 52%, transparent 53% 100%), conic-gradient(#ff1a5a '+ progress_2 +'%, #c3f3fc00 0)');
    jQuery(".leads_sec .leads_sec_progress_bar .bar_3").css("background",'radial-gradient(closest-side, #ffffff 52%, transparent 53% 100%), conic-gradient(#011e41 '+ progress_3 +'%, #c3f3fc00 0)');
    jQuery(".leads_sec .leads_sec_progress_bar .bar_4").css("background",'radial-gradient(closest-side, #ffffff 52%, transparent 53% 100%), conic-gradient(#c3f3fc '+ progress_4 +'%, #c3f3fc00 0)');
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get the current month and year
        var today = new Date();
        var month = (today.getMonth() + 1).toString().padStart(2, '0'); // Month is 0-based, so +1
        var year = today.getFullYear();
        var defaultDate = year + '-' + month;

        // Set the max attribute to the current month
        document.getElementById("monthPicker").setAttribute("max", defaultDate);

        // Check if a 'month' parameter is in the URL
        const urlParams = new URLSearchParams(window.location.search);
        const monthParam = urlParams.get('month');

        // If the 'month' parameter exists, use that. Otherwise, use the default date.
        document.getElementById("monthPicker").value = monthParam ? monthParam : defaultDate;
    });



    function applyFilter() {
        var selectedMonthYear = document.getElementById("monthPicker").value;
        window.location.href = window.location.pathname + "?month=" + selectedMonthYear;
    }


</script>


<?php include_once "includes/footer-no-cta.php"?>

<?php
require_once "serverside/functions.php";
include_once "serverside/session.php";
//if($_SESSION['user_role']=='jobs_person'){
//    ?>
<!--    <script type="text/javascript">-->
<!--        window.location.href="leads";-->
<!--    </script>-->
<!--    --><?php
//
//}
$func=new Functions();
$jobs=$func->getMyPostedJobs($_SESSION['user_id']);
include_once "includes/header.php";
?>
<style>button.view-job-btn.text-white.text-center.px-5.py-2.text-decoration-none {

    border-radius: 40px;
    color: rgb(209, 10, 56);
    font-size: 13px;
    background: #fff;
    padding: 5px 15px;
}
button.view-job-btn.text-white.text-center.px-5.py-2.text-decoration-none:hover{
  color: red;
}
.navigation.container {
box-shadow: 0px 0px 6px 2px rgba(0,0,0,.1) !important;
margin-bottom: 10px;
}

/* 
  ##Device = Most of the Smartphones Mobiles (Portrait)
  ##Screen = B/w 320px to 479px
*/

@media (min-width: 320px) and (max-width: 480px) {
	
  
  .brix---section-position-relative {
    padding-top: 0px;
    padding-bottom: 96px;
}
  
}
.listed-jobs {
    margin-bottom: 20px;
    padding: 20px!important;
    border-radius: 10px;
    background-color: #f4f4f4;
}
.listed-jobs h4 {
    line-height: 25px;
    color: #1a1b1f;
    font-weight: 700;
    font-family: inherit;
}

.listed-jobs .button-9 {
    margin-top: 10px;
}
.button-9 {

    border-radius: 5px;

}
.button-9:hover{
  background-color: #187BFB;
  color: #fff;
}
button.view-job-btn.text-white.text-center.px-5.py-2.text-decoration-none {

    border-radius: 10px;
}
.brix---section-position-relative {
    position: relative;
    overflow: hidden;
    padding-top: 40px;
    padding-bottom: 230px;
}
/* 
  ##Device = Most of the Smartphones Mobiles (Portrait)
  ##Screen = B/w 320px to 479px
*/

@media (min-width: 320px) and (max-width: 480px) {
  
h4.heading-10 {
    margin-top: 0px;
    margin-bottom: 15px;
}
.brix---section-position-relative.my-posted-jobs.wf-section {
    padding-top: 10px;
}
.brix---grid-contact-v6 {
    grid-row-gap: 8px;
}
h4.heading-8 {
    margin-top: 0px;
}
.listed-jobs {
    margin-bottom: 10px;
    padding: 10px!important;
    border-radius: 10px;
    background-color: #f4f4f4;
}
h4.heading-8 {
    line-height: 17px;
}
.heading-10 {
   
    font-size: 30px;
}

.w-button {
    display: inline-block;
    padding: 5px 15px;
}
.brix---section-position-relative {
    position: relative;
    overflow: hidden;
    padding-top: 40px;
    padding-bottom: 15px;
}
.brix---section-position-relative.my-posted-jobs.wf-section {
    border-radius: 0px!important;
}
.footer-dark {
    position: relative;
    margin-top: 0px;
    padding: 50px 30px 15px;
    border-bottom: 1px solid #e4ebf3;
    background-color: #006bf5;
    border-radius: 0px!important;
}
 .brix---contact-v6-half-bg-right {
    border-radius: 0px!important;

} 
}
@media(max-width:991px){
     .brix---contact-v6-half-bg-right {

        height: 21%;
} 
}

.months-winner-btn {
    background-color: #006bf5;
    color: #fff;
    padding: 7px 15px;
    text-align: center;
    text-decoration: none;
    border-radius: 5px;
    font-size: 18px;
}
.months-winner-btn:hover {
    background-color: #187bfb;
    color: #fff;
}
.jobpostitle {
    display: flex;
    justify-content: space-between;
    max-height: fit-content;
    align-items: center;
    margin-bottom: 18px;
}
a.postjobtn {
    background: #1246e2;
    color: #fff;
    padding: 10px 30px;
    border-radius: 3px;
    text-decoration: none;
}

@media (min-width: 320px) and (max-width: 480px){
  h4.heading-10 {
      margin-bottom: 15px;
      font-size: 20px;
  }
  a.postjobtn {
    padding: 7px 30px;
  }
}
</style>

  <div class="brix---section-position-relative my-posted-jobs wf-section">
    <div class="brix---container-default-2 w-container">
      <div class="w-layout-grid brix---grid-contact-v6">
        <div data-w-id="e428ed2b-d431-4217-a1cc-9d4350d6ece1" >
          <div class="w-row">
            <div class="w-col w-col-1"></div>
            <div class="w-col w-col-10">
              <div class="jobpostitle">
                <h4 class="heading-10">My Posted Jobs</h4>
                <a class="postjobtn" href="post-a-job">Post a Job</a>
              </div>
			  
			      <?php
                    foreach($jobs as $job)
                    {
                    $main=$func->SingleMainCategory($job['main_type']);
//                    $sub=$func->SingleSubCategory($job['sub_type']);
//                    $count=$func->countApply($job['id']);
                    $date=explode(' ',$job['created_date']);
                    $date=$date[0];
                    $date=date_create($date);

                    ?>
              <div class="listed-jobs">
                <h4 class="heading-8"><?=$job['title']?></h4>
                <div class="uui-career08_detail-wrapper">
                  <div class="uui-career08_icon-wrapper">
                    <div class="uui-career08_icon w-embed"><svg width="20" height="20" viewbox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.99984 4.99996V9.99996L13.3332 11.6666M18.3332 9.99996C18.3332 14.6023 14.6022 18.3333 9.99984 18.3333C5.39746 18.3333 1.6665 14.6023 1.6665 9.99996C1.6665 5.39759 5.39746 1.66663 9.99984 1.66663C14.6022 1.66663 18.3332 5.39759 18.3332 9.99996Z" stroke="currentColor" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"></path>
                      </svg></div>
                  </div>
                  <div class="text-block-15">Posted - <?php echo date_format($date,"d M Y")?></div>
                </div>
                <a href="my-posted-jobs-details?job_id=<?=$job['id']?>" class="button-9 w-button">View Job</a>
				<button  onclick="deleteJobsBYOwner(<?=$job['id']?>)" class="view-job-btn text-white text-center px-5 py-2 text-decoration-none"><i class="fa-regular fa-trash-can"></i> Delete Job</button>
              </div>
  <?php
                    }
                    ?>

            </div>
            <div class="w-col w-col-1"></div>
          </div>
        </div>
        <div style="" data-w-id="e428ed2b-d431-4217-a1cc-9d4350d6ed11"  class="brix---card-pd-64px---56px">
          <div class="brix---color-neutral-801">
            <h3 class="brix---heading-h3-size">Win These Amazing Rewards</h3>
          </div>
          <div class="brix---mg-bottom-40px">
            <div class="brix---color-neutral-802">
              <p class="brix---paragraph-default-2"> Every year we giveaway great rewards to our users, just for leaving feedback on how their job went. We send 2 families away, on all inclusive beach holiday. and we giveaway 1 Brand New Car, EVERY YEAR! Don't forget to leave feedback, after your job is complete, to win the chance of receiving one of these Amazing Rewards. It's free..
			  </p>
            </div>
          </div>
          <div class="w-layout-grid brix---grid-1-column-gap-row-24px-2">
     
            <a href="#" class="brix---icon-link-wrapper w-inline-block"><img src="images/Jet2Holidays-Logo.png" width="100" alt="" class="brix---big-icon-left">
              <div>
                <div class="brix---mg-bottom-8px">
                  <div class="brix---color-neutral-801">
                    <div class="brix---text-200-medium">2 X All Inclusive Family Holidays Giveaways</div>
                  </div>
                </div>
                <div class="brix---text-200-bold">Per Year</div>
              </div>
            </a>
         
            <a href="#" class="brix---icon-link-wrapper w-inline-block"><img src="images/bmw-mercedes-logo.jpg" srcset="images/bmw-mercedes-logo.jpg 500w, images/bmw-mercedes-logo.jpg 800w, images/bmw-mercedes-logo.jpg 1080w" width="100" sizes="(max-width: 767px) 56px, 100px" alt="" class="brix---big-icon-left">
              <div>
                <div class="brix---mg-bottom-8px">
                  <div class="brix---color-neutral-801">
                    <div class="brix---text-200-medium">1 Brand New Car (BMW or Mercedes) Giveaway</div>
                  </div>
                </div>
                <div class="brix---text-200-bold">Per Year</div>
              </div>
            </a>
            
            <a href="#" class="brix---icon-link-wrapper w-inline-block"><img src="images/new-third.png" width="100" alt="" class="brix---big-icon-left">
              <div>
                <div class="brix---mg-bottom-8px">
                  <div class="brix---color-neutral-801">
                    <div class="brix---text-200-medium">2 X £100 Asda Shopping Voucher Giveaways</div>
                  </div>
                </div>
                <div class="brix---text-200-bold">Per Month</div>
              </div>
            </a>
            <a href="homeowner-reward" class="btn months-winner-btn">This month's winners</a>
          </div>
        </div>
      </div>
    </div>
    <div class="brix---contact-v6-half-bg-right"></div>
  </div>


 

<?php include_once "includes/footer-no-cta.php"?>
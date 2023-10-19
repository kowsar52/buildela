<?php
require_once "serverside/functions.php";
include_once "serverside/session.php";

if(isset($_GET['u_id'])){

}else{
    //header('Location: sign-in');
    ?>
    <script type="text/javascript">
        window.location.href="index";
    </script>
    <?php
    exit();
}

$func=new Functions();
$user=$func->UserInfo($_GET['u_id']);
$user=$user[0];
$date=date_create($user['pub_insurance_date']);
$date1=date_create($user['pro_insurance_date']);

if(isset($_GET['job_id']) && isset($_GET['u_id'])){

    if($user['user_role']=='jobs_person'){
        $usersStatus=$func->getApplyUsersInfo($_GET['u_id'],$_GET['job_id']);
    }else{
        $usersStatus=$func->getjobposteduserinfo($_GET['job_id']);
    }

    if(!empty($usersStatus)){
        $userstatus=$usersStatus[0];
    }

}
$rateings=$func->getUserRatting($_GET['u_id']);
$sumofStars=0;
foreach($rateings as $rate){
    $sumofStars+=$rate['ratings'];

}
$images=$func->getMyGallery($_GET['u_id']);
$mySkills=$func->getMySkills($_GET['u_id']);

include_once "includes/header.php";

?>


 <div class="section cc-home-wrap userprofile">
    <div class="intro-header cc-subpage userprofile">
      <div class="intro-content">
        <div class="w-row">
          <div class="w-col w-col-3">
		  <?php
                                    if(empty($user['img_path']))
                                    {
                                        ?>
                                        <img loading="lazy" width="50" height="50" sizes="(max-width: 479px) 100vw, 150px" class="f-avatar-image-2 profle" src="images/avatar1.png" alt="no-image">
                                        <?php
                                    }else{
                                        $image=explode('/',$user['img_path'] );

                                        $img= $image[1].'/'.$image[2];
                                        ?>
                                        <img loading="lazy" width="50" height="50" sizes="(max-width: 479px) 100vw, 150px" class="f-avatar-image-2 profle" src="<?=$img?>" alt="no-image">
                                        <?php
                                    }
                                    ?>
		  </div>
		   
		  <div class="w-col w-col-9">
            <div class="heading-jumbo profile userprofile"><?=$user['fname'] .", ".$user['trading_name']?><br></div>
            <div class="div-block-11">
              <div class="html-embed w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewbox="0 0 24 24" fill="none">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M17 7C17 5.34315 15.6569 4 14 4H10C8.34315 4 7 5.34315 7 7H6C4.34315 7 3 8.34315 3 10V18C3 19.6569 4.34315 21 6 21H18C19.6569 21 21 19.6569 21 18V10C21 8.34315 19.6569 7 18 7H17ZM14 6H10C9.44772 6 9 6.44772 9 7H15C15 6.44772 14.5523 6 14 6ZM6 9H18C18.5523 9 19 9.44772 19 10V18C19 18.5523 18.5523 19 18 19H6C5.44772 19 5 18.5523 5 18V10C5 9.44772 5.44772 9 6 9Z" fill="black"></path>
                </svg></div>
              <div class="text-block-20 info">Hired <?=$user['hired_counter']?> Times</div>
            </div>
            <div class="div-block-11">
              <div class="html-embed w-embed"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewbox="0 0 362.13 362.13" enable-background="new 0 0 362.13 362.13">
                  <g>
                    <path d="m181.065,0c-75.532,0-136.981,61.45-136.981,136.981 0,31.155 21.475,76.714 63.827,135.411 30.619,42.436 60.744,75.965 62.011,77.372l11.144,12.367 11.144-12.367c1.267-1.406 31.392-34.936 62.011-77.372 42.352-58.697 63.827-104.255 63.827-135.411-0.001-75.531-61.451-136.981-136.983-136.981zm0,316.958c-37.733-44.112-106.981-134.472-106.981-179.977 0-58.989 47.991-106.981 106.981-106.981s106.981,47.992 106.981,106.981c0.001,45.505-69.248,135.865-106.981,179.977z"></path>
                    <circle cx="181.065" cy="136.982" r="49.696"></circle>
                  </g>
                </svg></div>
              <div class="text-block-20 info"><?=$user['town']?></div>
            </div>
			
			<div class="text-block-20">
               <?php
                                            if($user['dbs_path']){
                                                ?>
                                                <br>
                                                DBS Verified <i class="fa fa-check-circle-o"></i>
                                                <?php
                                            }
                                            ?>
											
											
											     <br><?=$user['operate']?><br>
                                                          
                                                            <?php
                                                            if(!empty($user['qualification'])){
                                                                ?>
                                                              
                                                                 <i class="fa fa-award" aria-hidden="true"></i>
                                                                    <?=$user['qualification']?>
                                                              
                                                                <?php
                                                            }
                                                            ?>
											
											
											<?php
                                                            if(count($rateings)>0){

                                                                if((count($rateings)>=100)&&( $sumofStars/count($rateings)>=4.5)){
                                                                    ?>
                                                                  <br><i class="fa fa-medal"></i>
                                                                      Current Top Pro <br>
                                                                  
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
											
											    <?php
                                        if(isset($userstatus) && $userstatus['status']!=0 ){
                                            ?>
                                            <span class="icons"><a href="mailto:<?=$user['email']?>"><?=$user['town']?></a></span>
                                            <br>
                                            <span class="icons"><?=$user['phone']?></span>
                                            <?php
                                        }if(!isset($_GET['job_id'] )){
                                            ?>
                                            <!--                                            <span class="icons">Contact details are hidden</span>-->
                                            <?php
                                        }
                                        ?>
            </div>
            <div class="text-block-20">Rated Excellent | (162)</div>
            <div class="combine-clients1_rate-2">
              <div class="combine-icon_color3-2">
                <div class="combine-icon_small-2 w-embed"><svg width="currentWidth" height="currentHeight" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 1C12.3806 1 12.7283 1.21607 12.8967 1.55738L15.7543 7.34647L22.1447 8.28051C22.5212 8.33555 22.8339 8.59956 22.9513 8.96157C23.0687 9.32358 22.9704 9.72083 22.6978 9.98636L18.0746 14.4894L19.1656 20.851C19.23 21.2261 19.0757 21.6053 18.7678 21.8291C18.4598 22.0528 18.0515 22.0823 17.7146 21.9051L12 18.8998L6.28548 21.9051C5.94856 22.0823 5.54027 22.0528 5.2323 21.8291C4.92432 21.6053 4.77007 21.2261 4.83442 20.851L5.92551 14.4894L1.3023 9.98636C1.02968 9.72083 0.931405 9.32358 1.04878 8.96157C1.16616 8.59956 1.47884 8.33555 1.8554 8.28051L8.24577 7.34647L11.1033 1.55738C11.2718 1.21607 11.6194 1 12 1Z" fill="currentColor"></path>
                  </svg></div>
              </div>
              <div class="combine-icon_color3-2">
                <div class="combine-icon_small-2 w-embed"><svg width="currentWidth" height="currentHeight" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 1C12.3806 1 12.7283 1.21607 12.8967 1.55738L15.7543 7.34647L22.1447 8.28051C22.5212 8.33555 22.8339 8.59956 22.9513 8.96157C23.0687 9.32358 22.9704 9.72083 22.6978 9.98636L18.0746 14.4894L19.1656 20.851C19.23 21.2261 19.0757 21.6053 18.7678 21.8291C18.4598 22.0528 18.0515 22.0823 17.7146 21.9051L12 18.8998L6.28548 21.9051C5.94856 22.0823 5.54027 22.0528 5.2323 21.8291C4.92432 21.6053 4.77007 21.2261 4.83442 20.851L5.92551 14.4894L1.3023 9.98636C1.02968 9.72083 0.931405 9.32358 1.04878 8.96157C1.16616 8.59956 1.47884 8.33555 1.8554 8.28051L8.24577 7.34647L11.1033 1.55738C11.2718 1.21607 11.6194 1 12 1Z" fill="currentColor"></path>
                  </svg></div>
              </div>
              <div class="combine-icon_color3-2">
                <div class="combine-icon_small-2 w-embed"><svg width="currentWidth" height="currentHeight" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 1C12.3806 1 12.7283 1.21607 12.8967 1.55738L15.7543 7.34647L22.1447 8.28051C22.5212 8.33555 22.8339 8.59956 22.9513 8.96157C23.0687 9.32358 22.9704 9.72083 22.6978 9.98636L18.0746 14.4894L19.1656 20.851C19.23 21.2261 19.0757 21.6053 18.7678 21.8291C18.4598 22.0528 18.0515 22.0823 17.7146 21.9051L12 18.8998L6.28548 21.9051C5.94856 22.0823 5.54027 22.0528 5.2323 21.8291C4.92432 21.6053 4.77007 21.2261 4.83442 20.851L5.92551 14.4894L1.3023 9.98636C1.02968 9.72083 0.931405 9.32358 1.04878 8.96157C1.16616 8.59956 1.47884 8.33555 1.8554 8.28051L8.24577 7.34647L11.1033 1.55738C11.2718 1.21607 11.6194 1 12 1Z" fill="currentColor"></path>
                  </svg></div>
              </div>
              <div class="combine-icon_color3-2">
                <div class="combine-icon_small-2 w-embed"><svg width="currentWidth" height="currentHeight" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 1C12.3806 1 12.7283 1.21607 12.8967 1.55738L15.7543 7.34647L22.1447 8.28051C22.5212 8.33555 22.8339 8.59956 22.9513 8.96157C23.0687 9.32358 22.9704 9.72083 22.6978 9.98636L18.0746 14.4894L19.1656 20.851C19.23 21.2261 19.0757 21.6053 18.7678 21.8291C18.4598 22.0528 18.0515 22.0823 17.7146 21.9051L12 18.8998L6.28548 21.9051C5.94856 22.0823 5.54027 22.0528 5.2323 21.8291C4.92432 21.6053 4.77007 21.2261 4.83442 20.851L5.92551 14.4894L1.3023 9.98636C1.02968 9.72083 0.931405 9.32358 1.04878 8.96157C1.16616 8.59956 1.47884 8.33555 1.8554 8.28051L8.24577 7.34647L11.1033 1.55738C11.2718 1.21607 11.6194 1 12 1Z" fill="currentColor"></path>
                  </svg></div>
              </div>
              <div class="combine-icon_color3-2">
                <div class="combine-icon_small-2 w-embed"><svg width="currentWidth" height="currentHeight" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 1C12.3806 1 12.7283 1.21607 12.8967 1.55738L15.7543 7.34647L22.1447 8.28051C22.5212 8.33555 22.8339 8.59956 22.9513 8.96157C23.0687 9.32358 22.9704 9.72083 22.6978 9.98636L18.0746 14.4894L19.1656 20.851C19.23 21.2261 19.0757 21.6053 18.7678 21.8291C18.4598 22.0528 18.0515 22.0823 17.7146 21.9051L12 18.8998L6.28548 21.9051C5.94856 22.0823 5.54027 22.0528 5.2323 21.8291C4.92432 21.6053 4.77007 21.2261 4.83442 20.851L5.92551 14.4894L1.3023 9.98636C1.02968 9.72083 0.931405 9.32358 1.04878 8.96157C1.16616 8.59956 1.47884 8.33555 1.8554 8.28051L8.24577 7.34647L11.1033 1.55738C11.2718 1.21607 11.6194 1 12 1Z" fill="currentColor"></path>
                  </svg></div>
              </div>
            </div>
          </div>
        </div>
        <div class="w-container">
          <p class="paragraph-9 profile"><?=$user['note']?></p>
        </div>
		   <?php if($user['user_role']=='jobs_person'){
                            ?>
        <div class="mainheader w-row">
          <div class="w-col w-col-2">
           
          </div>
		  <div class="w-col w-col-8">
            <h5 class="heading-11">Insurance</h5>
          </div>
          <div class="w-col w-col-2"></div>
        </div>
        <div class="w-row">
          <div class="w-col w-col-6">
            <div class="profile-text"><strong>Public liability insurance<br>‍</strong><br>Limit of indemnity<br>
                                                       £<?=$user['pub_insurance']?><br>
                                                       valid until:  <?php echo date_format($date,"j M Y")?></div>
          </div>
          <div class="w-col w-col-6">
            <div class="profile-text"><strong>Public liability insurance<br>‍</strong> <br>Limit of indemnity
                                                        <br>£<?=$user['pub_insurance']?><br>
                                                      valid until: <?php echo date_format($date,"j M Y")?><br></div>
          </div>
        </div>
		   <?php
                        }
                        ?>
		
      </div>
    </div>
	<?php if($user['user_role']=='jobs_person'){
                            ?>
    <div class="detail-profile w-container">
      <div class="div-block-10">
        <div class="mainheader w-row">
          <div class="w-col w-col-2">
    
			
          </div>
		  <div class="w-col w-col-8">
            <h5 class="heading-11">Our Projects</h5>
			
          </div>
          <div class="w-col w-col-2"></div>
        </div>
        <div data-w-id="5f2ac57a-b8ea-23b3-764a-18387a124e6a" style="" class="w-layout-grid brix---grid-4-columns-instagram">
		 <?php
                                                    foreach($images as $imgs){

                                                        $image=explode('/',$imgs['img_path'] );
                                                        $img= $image[1].'/'.$image[2];

                                                        ?>


                                                        <?php

                                                        if($imgs['file_type']=='video'){
                                                            ?>
                                                            <div>
                                                                <video class="brix---instagram-image w-inline-block" controls>
                                                                    <source src="<?=$img?>" type="video/mp4">
                                                                    Error Message
                                                                </video>
                                                            </div>

                                                            <?php
                                                        }else if($imgs['file_type']=='image'){
                                                            ?>
                                                           <a  href="<?=$img?>"  target="_blank" class="brix---instagram-image w-inline-block"><img class="brix---image"  sizes="(max-width: 479px) 100vw, (max-width: 767px) 43vw, (max-width: 991px) 42vw, (max-width: 1439px) 20vw, 204px" src="<?=$img?>" alt="no-feature-image"></a>

                                                            <?php
                                                        }
                                                        ?>


                                                        <?php
                                                    }

                                                    ?>
		
         </div>
      </div>
    </div>
    <div class="detail-profile w-container">
      <div class="div-block-10">
        <div class="mainheader w-row">
          <div class="w-col w-col-2">
</div>
		       <div class="w-col w-col-8">
            <h5 class="heading-11">Reviews</h5>
          </div>
          <div class="w-col w-col-2"></div>
        </div>
        <div class="reviews">
		
		
		 <?php
                                    if(!empty($rateings)){
                                        foreach($rateings as $rate){
//                                        $jobs=$func->getSingleJob($rate['job_id']);
//                                        $user1=$func->getuserdetails($jobs[0]['user_id']);
                                            $user1=$func->getuserdetails($rate['from_user_id']);
                                            $date=explode(' ',$rate['send_date']);
                                            $date=$date[0];
                                            $date=date_create($date);
                                            ?>
          <div class="combine-clients1_item-2">
            <div class="combine-clients1_rate-2">
              <div class="combine-icon_color3-2">
			      <?php
                                                                for ($i=0; $i <$rate['ratings'] ; $i++){
                                                                    ?>
                                                                     <div class="combine-icon_small-2 w-embed"><svg width="currentWidth" height="currentHeight" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 1C12.3806 1 12.7283 1.21607 12.8967 1.55738L15.7543 7.34647L22.1447 8.28051C22.5212 8.33555 22.8339 8.59956 22.9513 8.96157C23.0687 9.32358 22.9704 9.72083 22.6978 9.98636L18.0746 14.4894L19.1656 20.851C19.23 21.2261 19.0757 21.6053 18.7678 21.8291C18.4598 22.0528 18.0515 22.0823 17.7146 21.9051L12 18.8998L6.28548 21.9051C5.94856 22.0823 5.54027 22.0528 5.2323 21.8291C4.92432 21.6053 4.77007 21.2261 4.83442 20.851L5.92551 14.4894L1.3023 9.98636C1.02968 9.72083 0.931405 9.32358 1.04878 8.96157C1.16616 8.59956 1.47884 8.33555 1.8554 8.28051L8.24577 7.34647L11.1033 1.55738C11.2718 1.21607 11.6194 1 12 1Z" fill="currentColor"></path>
                  </svg></div>
              </div>
			  
                                                                    <?php
                                                                }
                                                                ?>
			  
			  
			  
          
            </div>
            <div class="combine-text-size-regular-3"><strong>&quot;</strong><?=$rate['message']; ?><strong>&quot;</strong></div>
            <div class="combine-clients1_details-2">
              <div id="w-node-ec31de6e-8ede-55d4-2dbe-a2eee859fdc0-35b0a412" class="combine-clients1_image-wrapper-2"><img src="images/client1.jpg" loading="lazy" srcset="images/client1-p-500.jpg 500w, images/client1.jpg 640w" sizes="56px" alt="woman avatar" class="combine-clients1_image-2">
			    <?php
                                                            if(!empty($user1)){
                                                                if(empty($user1[0]['img_path']))
                                                                {
                                                                    ?>
                                                                    <img class="combine-clients1_image-2" src="images/avatar1.png" alt="no-image" loading="lazy" srcset="images/client1-p-500.jpg 500w, images/client1.jpg 640w" sizes="56px"  >
                                                                    <?php
                                                                }else{
                                                                    $image=explode('/',$user1[0]['img_path'] );

                                                                    $img= $image[1].'/'.$image[2];
                                                                    ?>

                                                                    <img class="combine-clients1_image-2" src="<?=$img?>" alt="no-image" loading="lazy" srcset="images/client1-p-500.jpg 500w, images/client1.jpg 640w" sizes="56px" >

                                                                    <?php
                                                                }
                                                                ?>
                                                                <div class="comment-name mt-3"><?=$user1[0]['fname']?></div>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                <img class="combine-clients1_image-2" src="images/avatar1.png" alt="no-image" loading="lazy" srcset="images/client1-p-500.jpg 500w, images/client1.jpg 640w" sizes="56px" >
                                                                <div class="comment-name mt-3">Unknown</div>
                                                                <?php
                                                            }
                                                            ?>
			  
			  </div>
              <div id="w-node-ec31de6e-8ede-55d4-2dbe-a2eee859fdc2-35b0a412" class="combine-text-weight-semibold-3"><?=$rate['job_title']?></div>
              <div id="w-node-a19adbed-ce2a-a331-84b0-cb0a1e6ebfb9-35b0a412" class="combine-text-weight-semibold-3 date"><?php echo date_format($date,"M-j-Y")?></div>
            </div>
          </div>
		  
		  
		         <?php
                                        }}else{
                                        ?>
                                        <div style="padding: 5px; text-align:center;" class="container select_skill login_form">
                                            <p>This tradesperson currently has no reviews.</p>

                                        </div>
                                        <?php
                                    }

                                    ?>
		  
		  
		  
	
        </div>
      </div>
    </div>
   <?php
                        }
                        ?>
  <div class="container">
      <div class="motto-wrap"></div>
      <div class="about-story-wrap"></div>
    </div>
  </div>





<?php include_once "includes/footer-no-cta.php"?>
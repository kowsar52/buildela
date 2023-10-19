<?php 

include_once "includes/header.php";
require_once "serverside/functions.php";
if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
    // session isn't started
    session_start();
}
// if(isset($_SESSION['user_type'])&&$_SESSION['user_role']=='home_owner'){

// }else if (isset($_SESSION['user_type'])&&$_SESSION['user_role']=='jobs_person')
// {

// 	>
// 	<script type="text/javascript">
// 		window.location.href="dashboard-my-profile";
// 	</script>
// 	<?php

// }else{
//      //header('Location: sign-in');
// 	>
// 	<script type="text/javascript">
// 		window.location.href="login";
// 	</script>
// 	<?php
// 	exit();
// }

if(isset($_SESSION['user_id'])){
    $id=$_SESSION['user_id'];
}


$func=new Functions();
$mainCategory=$func->mainCategory();
$subCategory=$func->subCategory();

if(isset($_SESSION['islogin'])) {
    $islogin = $_SESSION['islogin'];
}
else{
    $islogin =0;
}
// Get category and city from URL parameters
$category = $_GET['category'];
$city = $_GET['city'];

$categoryclean = str_replace('-', ' ', htmlspecialchars($category));
//echo $_GET['category'];
// Get the service and city information
//$service = getServiceInfo($category);
//$cityinfo = getCityInfo($city);
$service=$func->getServiceInfo($categoryclean);
$cityinfo=$func->getCityInfo($city);
$getcityinfo=$func->getCities();
$getserviceinfo=$func->getServices();


 //echo "<br><br>TEST HERE2";
//  var_dump($getcityinfo);
if (!$service ) {
 //   echo "No service ";
 //   exit;
}if (!$cityinfo) {
 //   echo "No city found";
 //   exit;
}



$imagePath = $service[0]['image_path'];


?>

<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>css/bootstrap.min.css">
<script src="<?php echo BASE_URL; ?>js/jquery-3.6.1.js" type="text/javascript"></script>


<style>

li.area-hd a {
    display: block;

    padding: 16px;
    text-decoration: none;
    text-transform: capitalize;
    font-size: 16px;

}
.intro-header.cc-subpage.userprofile.postajob.hd{
	background-image: url("<?php echo BASE_URL . $imagePath; ?>");
	  background-position: center; /* Center the image */
  background-repeat: no-repeat; /* Do not repeat the image */
  background-size: 100% 100%; 
	
}


form#signup_user1 .form-group input#phone1, form#signup_user1 .form-group input#fname, form#signup_user1 .form-group input#pass {
    border-radius: 0.5rem;
}
form#signup_user1 h1 {
    font-size: 2rem;
    font-weight: 700;
    text-align: center;
}
form#signup_user1 p {
    text-align: center;
    font-size: 1rem;
    margin-bottom: 2em;
}
button#notLoginButton {
    margin-top: 0;
}

textarea#note {
    height: 130px;
}
label.h2.pb-3.post-a-job-label {
    font-size: 17px;
    text-align: center;
    width: 100%;
    font-weight: 700;
    margin-bottom: 0px;
	font-family: Montserrat, sans-serif;
}
.combine-container-small-2 {
    width: 100%;
    max-width: 31rem;
    margin-right: auto;
    margin-left: auto;
}

button.post-a-job-continue-btn {
  font-weight: 500;
    color: #fff;
    padding: 9px 32px;
    font-size: 18px;
    background: #006bf5;
}
.heading-jumbo-text {
    color: #006bf5!important;
    font-size: 3rem;
    font-weight: 700;
}
.second-section-post-job-inner {
    overflow-y: auto!important;
    height: auto!important;
}
.second-section-post-job-wrapper {
    height: auto!important;
}

.intro-header.cc-subpage.userprofile {
 
    min-height: 160px;
    margin-top: 0px;
    margin-bottom: 0px;
}

.combine-contact1_component {
    margin-bottom: 0rem;
    padding: 0rem 4rem;
    border-radius: 0.5rem;
    background-color: #fff;
}

.combine-section_contact1 {
    border-radius: 10px;
    background-color: rgba(0, 107, 245, 0.09);
    margin-bottom: 80px;
}
label {
    text-transform: none;
}

.h2, h2 {
    font-size: 1.7rem;
    text-align: center!important;
}
.combine-contact1_component.w-form {
    box-shadow: 1px 1px 3px 0 rgb(108 109 113 / 64%);
}
.scrolling-wrapper h6 {
    background-color: #ebeef1;
    padding: 10px 15px;
    color: rgb(51, 51, 51);
    font-size: 1rem;

    border-radius: 4px;
}

.heading-jumbo-small {
    margin-top: 10px;
    margin-bottom: 15px;
    background-image: linear-gradient(135deg, #dc3545, #0050bd)!important;
    color: #006bf5;
}

/**/


/* 
  ##Device = Most of the Smartphones Mobiles (Portrait)
  ##Screen = B/w 320px to 479px
*/

@media (min-width: 320px) and (max-width: 480px) {
  
.section.cc-home-wrap {
    padding-top: 0px;
}


.heading-jumbo-text {
    color: #006bf5!important;
    font-size: 2rem;
    font-weight: 600;
}


.heading-jumbo-small.postajob {
    line-height: 28px;
    font-size: 16px;
}
.combine-contact1_component {
    margin-bottom: 0rem;
    padding: 0rem 0rem;
}
.form-control-lg {
  
    font-size: 1rem;
}
  
}

.combine-contact1_component {
margin-bottom: 0rem;
padding: 0rem 0rem;
}


.panel.panel-default.card-input.p-2.d-flex.flex-wrap.align-items-center.justify-content-between:hover {
    background: rgb(242, 247, 250);
}
label.radio-btn:hover {
    border-color: rgb(221 221 221) !important;
    color: rgb(51, 51, 51);
}
.card-input div, span.p-2.d-span {

    font-size: 16px;
    text-transform: none;
    font-weight: 500;
}
.post-a-job-continue-btn-div.pt-4 {
    margin-top: 0px;
    margin-bottom: 20px;
    padding-top: 0px!important;
}
button#new-back-btn-3 {
    margin-top: 0px!important;
}
form#signup_user1 h1 {
    font-size: 1.9rem;
    text-align: center;
    font-weight: 500;
}
.form-control:disabled, .form-control[readonly] {
    background-color: #ffffff;
    opacity: 1;
}

input#images {
    background: transparent!important;
    border-color: #ced4da!important;
    padding: 10px;

    margin-bottom: 5px!important;
}

ul.areas {
    display: none;
}
h3 {
    text-align: center;
    font-weight: 600;
    color: #006bf5;
    margin-top: 20px;
}
.combine-padding-global-2 {
    margin-top: -50px;
    padding-right: 1.25rem;
    padding-left: 1.25rem;
    padding-top: 0px;
    border-radius: 5px;
    background-color: #006bf5;

}
.motto-wrap {
    width: 100%;
    margin-right: auto;
    margin-bottom: 0px;
    margin-left: auto;
    text-align: center;
}
.heading-jumbo-small {
    font-size: 32px;
    margin-top: 35px;
}
.intro-header.cc-subpage.userprofile {
    min-height: 450px;
    margin-top: 50px;
    margin-bottom: 50px;
}
h2.heading-jumbo-small.postajob {
    display: none;
}

h1.heading-jumbo-text {
   background: rgb(255 255 255 / 70%);
}
.section.cc-home-wrap {
    padding-top: 0px;
}
@media(max-width:767.98px){
  .intro-header.cc-subpage.userprofile {
    min-height: 290px;
    background-size: cover;

}
}
</style>
<div class="section cc-home-wrap postajob">
    <div class="intro-header cc-subpage userprofile postajob hd">
      <div class="intro-content">
        <h1 class="heading-jumbo-text">Find a local<?php $city = $_GET['city'];
 
if (($cityinfo) & (!$service))  { ?> tradesperson <?php } ?>  <?= str_replace('-', ' ', htmlspecialchars($category))   ?> in <?= htmlspecialchars($city) ?><br></h1>
        <h2 class="heading-jumbo-small postajob">Start by posting a <?= str_replace('-', ' ', htmlspecialchars($category)) ?> job in <?= htmlspecialchars($city) ?></h2>
      </div>
    </div>
    <section class="combine-section_contact1">
      <div class="combine-padding-global-2">
        <div class="combine-container-small-2">
          <div class="combine-padding-section-medium-2">
            <div class="combine-contact1_component w-form">
<div class="brix---mg-bottom-32px w-form">
              <div class="d-flex align-items-center justify-content-center search-input-wrapper py-1 px-2">
                                <input id="searchpx" readonly placeholder="Search e.g Electrician" type="email" class="form-control w-100 form-control-lg d-block" value="<?= str_replace('-', ' ', htmlspecialchars($category)) ?>" data-toggle="modal" data-target="#searchModal">
                                <button class="btn search-btn py-2 px-4" data-toggle="modal" data-target="#searchModal">Search</button>
                            </div>
              
              
            </div>
            
              
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  
  <div class="modal fade" id="verifiymodal" tabindex="-1" role="dialog" aria-labelledby="example1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="example1">Verify your mobile number</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="verifiy_phone">
                <div class="modal-body">
                    <p class="my-2 text-center">We send a verification code on your mobile number</p>
                    <input value="" type="hidden" id="verification_phone">
                    <div class="form-group">
                        <label for="verification_code">Enter verification code:</label>
                        <input type="text" value="" class="form-control-lg form-control" required id="verification_code" >
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="verifiy_btn" class="btn btn-primary">Verify</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!------------------- Modal ------------------->
<div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="searchModalLabel">Post a job</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="post_job">
                    <input type="hidden" id="user_id" value="<?=$id?>" name="">
                    <!--                                  <label class="h2 pb-3 post-a-job-label" for="exampleFormControlSelect1">What would you like to have done?</label>-->
                    <div id="post-a-job-new-card-one" class="post-a-job-new-card bg-white p-3">
                        <div class="bg-white rounded border px-2 new-input-wrapper">
                            <small>Tradespeople</small>
                            <input placeholder="Search e.g Electrician / Plumber" class="form-control border-0 px-0 mb-1 py-0 post-a-job-new-input" id="search_main_type1" type="text">
                            <input type="hidden" value="" id="search_main_type">
                        </div>
                        <h6 class="mt-3" id="popular_search">Popular Searches</h6>

                        <div id="scrolling-wrapper" class="scrolling-wrapper">
                            <?php
                            foreach ($popular_serarch as $search){
                                if( trim($search['main_category']) !="Other"){
                                    ?>
                                    <span class="p-2 d-span" onclick="setvalueofsearch(`<?= $search['main_category']?>`)"><?= $search['main_category']?> <i class="fa fa-angle-right bpsc"></i></span>
                                    <?php
                                }
                            }

                            ?>

                        </div>
                    </div>
                    <div id="post-a-job-new-card-two" class="post-a-job-new-card mt-2 bg-white p-3">
                        <h6 class="pt-2 pb-2" id="what_need"></h6 >
                        <div class="scrolling-wrapper-one" id="checkboxs">

                        </div>
                        <button id="new-back-btn-1" href="#" type="button" class="text-decoration-none align-items-center border p-2 rounded mt-3 btn">
                            <i class="fa fa-angle-left"></i>
                            Back
                        </button>
                    </div>
                    <div id="post-a-job-new-card-three" class="post-a-job-new-card mt-2 bg-white p-3">
                        <h6 class="pt-2">What does your job involve?</h6 >
                        <div class="scrolling-wrapper-one" id="checkboxs1">

                        </div>
                        <button id="new-back-btn-2" type="button" href="#" class="text-decoration-none align-items-center border p-2 rounded mt-3 btn">
                            <i class="fa fa-angle-left"></i>
                            Back
                        </button>
                    </div>
                    <div id="question-3" class="post-a-job-checkbox-wrapper bg-white rounded mt-2 p-3 ">

                        <div class="form-group">
                            <label for="title">Job Title</label>
                            <input type="text"  class="form-control-lg form-control  " id="title">
                        </div>


                        <div class="form-group ">
                            <label for="post_code">Post code of job location</label>
                            <input type="text"  class="form-control-lg form-control" id="post_code">
                        </div>


                        <div class="form-group">
                            <label>Add a description to your job</label>
                            <textarea maxlength="3000" id="note" rows="6" class="form-control-lg form-control" placeholder="Include any detail you think the tradesperson should know (nature of damage, your availability, etc.)">
                        </textarea>
                            <!--                        <span class="textarea_span bg-info">0/3000</span>-->
                        </div>

<div class="form-group ">
                            <p><label for="images">Job Images or Videos (Optional)</label></p>
                            <input type="file" name="multipleimagep[]"  class="form-control-lg form-control" id="images" multiple>
                            <small>you can select multiple from your gallery</small>
                        </div>



                       
                        <?php
                        if($islogin==0){
                            ?>

                            <div class="post-a-job-continue-btn-div pt-4">
                                <button type="button" onclick="checklogin(event)" id="notLoginButton"  class=" continue-btn3 post-a-job-continue-btn btn-block text-white text-center text-decoration-none rounded" >POST</button>
                            </div>
                            <?php
                        }else{
                            ?>
                            <div class="post-a-job-continue-btn-div pt-4">
                                <button type="submit" class="continue-btn3 post-a-job-continue-btn btn-block text-white text-center text-decoration-none rounded" >POST</button>
                            </div>
                            <?php
                        }
                        ?>
						 <button id="new-back-btn-3" type="button" href="#" class="text-decoration-none align-items-center border p-2 rounded mt-3 btn">
                            <i class="fa fa-angle-left"></i>
                            Back
                        </button>
                    </div>
                    <div class="post-a-job-checkbox-wrapper bg-white rounded shadow mt-2 p-3" id="addsignupform"></div>
                    <div class="post-a-job-checkbox-wrapper bg-white rounded shadow mt-2 p-3" id="LoginForm1"></div>
                    <div  class="post-a-job-checkbox-wrapper bg-white rounded shadow mt-2 p-3" id="NewSignupForm"></div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="verifiymodal" tabindex="-1" role="dialog" aria-labelledby="example1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="example1">Verify your mobile number</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="verifiy_phone">
                <div class="modal-body">
                    <p class="my-2 text-center">We send a verification code to your mobile number</p>
                    <input value="" type="hidden" id="verification_phone">
                    <div class="form-group">
                        <label for="verification_code">Enter verification code:</label>
                        <input type="text" value="" class="form-control-lg form-control" required id="verification_code" >
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="verifiy_btn" class="btn btn-primary">Verify</button>
                </div>
            </form>
        </div>
    </div>
</div>






    <!-- list of cities goes here -->
    
    <?php
   echo '<ul class="areas">';
   
foreach ($getcityinfo as $city) {
	    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'];
    define("BASE_URL", $protocol . $domainName . "/");

    echo '<li class="area-hd"><a class="area-link" href="' . BASE_URL . 'local' . urlencode($category) . '/' . urlencode($city['city_name']) . '">' . htmlspecialchars($city['city_name']) . '</a></li>';

}
echo '</ul>';
  $city = $_GET['city'];
 
if (($cityinfo) & ($service))  {
//echo var_dump($service);

    ?>
	
	
	
	    <div class="container">
      <div class="motto-wrap">
        <div class="heading-jumbo-small">Buildela is a modern platform for finding a <?= str_replace ('-',' ', htmlspecialchars ($category)) ?>
 in <?= htmlspecialchars($city) ?>.</div>
      </div>
      <div class="about-story-wrap">
        <section class="hero-heading-center about-top wf-section">
          <div class="container-9">
            <div class="hero-wrapper">
              <div class="hero-split">
                <p class="margin-bottom-24px">Welcome to Buildela, your ultimate destination for all your home repair and improvement needs. We understand that homeowners constantly seek skilled professionals who can handle repairs and transformative home improvement projects. With Buildela, finding reliable experts in various trade categories has never been easier, allowing you to enhance and restore your home with confidence.</p>
                <a href="https://jobsunlocked.com/post-a-job" class="button-primary-2 about w-button">Post a job</a>
              </div>
              <div class="hero-split"><img src="https://jobsunlocked.com/images/builder-600-×-600px-1.png" loading="lazy" srcset="https://jobsunlocked.com/images/builder-600-×-600px-1-p-500.png 500w, https://jobsunlocked.com/images/builder-600-×-600px-1.png 600w" sizes="(max-width: 479px) 100vw, (max-width: 767px) 73vw, (max-width: 991px) 74vw, (max-width: 1439px) 35vw, 432.390625px" alt="" class="shadow-two"></div>
            </div>
          </div>
        </section>
      </div>
      <div class="divider"></div>
      <section class="hero-heading-center about wf-section">
        <div class="container-9">
          <div class="hero-wrapper">
           <div class="hero-split"><img src="https://jobsunlocked.com/images/Tradesperson-drilling(1).jpg" loading="lazy" srcset="https://jobsunlocked.com/images/Tradesperson-drilling(1).jpg 500w, https://jobsunlocked.com/images/Tradesperson-drilling(1).jpg 600w" sizes="(max-width: 479px) 100vw, (max-width: 767px) 73vw, (max-width: 991px) 74vw, (max-width: 1439px) 35vw, 432.390625px" alt="" class="shadow-two"></div>
            <div class="hero-split">
              <p class="margin-bottom-24px">Whether you're looking to fix a leaky roof, repair damaged walls, upgrade your electrical system, or embark on a full-scale renovation, Buildela is your one-stop solution. Our platform connects you with a vast network of verified professionals specializing in repairs and home improvement across all trade categories. From builders and plumbers to electricians and decorators, we've got the right experts for every aspect of your project. Ranging from builders (<?= str_replace ('-',' ', htmlspecialchars ($category)) ?>) and plumbers to electricians and interior decorators, we host the right specialists for every facet of your project.

At Buildela, we believe that every homeowner deserves a hassle-free experience when it comes to repairs and home improvement. Trust us to connect you with skilled tradespeople who bring your repair and home improvement visions to life. Start your journey with Buildela today and unlock the potential of your home, no matter where you are, even in <?= htmlspecialchars($city) ?>.</p>
              <a href="https://jobsunlocked.com/post-a-job" class="button-primary-2 about w-button">Post for free</a>
            </div>
          </div>
        </div>
      </section>
    </div>
<?php } ?>
	
	
	
	
	
	
	<?php
	

	if(isset($city)) {
   if(!isset($category)) {
      // This is where you put the code you want to run when $city is set and $service is not

?>

	
	<h3>Our Services</h3>
	<!-- list of service goes here -->
<?php
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$domainName = $_SERVER['HTTP_HOST'];
define("BASE_URL", $protocol . $domainName . "/");

echo '<ul class="services">';
foreach ($getserviceinfo as $service) {
    $service_name = $service['service_name'];
    $category = $category;
    
// Replace or remove unwanted characters
$find =    ['+', '/', '&', ',', '-', ' '];  // Add space to the array
$replace = ['-', '-', 'and', '', '', '-'];  // Replace spaces with hyphens
$service_name = str_replace($find, $replace, $service_name);
$category = str_replace($find, $replace, $category);
    
    // Remove any remaining special characters
    $service_name = preg_replace('/[^A-Za-z0-9\-]/', '', $service_name);
    $category = preg_replace('/[^A-Za-z0-9\-]/', '', $category);
    $city = $_GET['city'];

    echo '<li class="area-hd"><a class="area-link" href="' . BASE_URL . 'local' . urlencode($category) . '/' . urlencode($service_name) . '/' . urlencode(htmlspecialchars($city)) . '">' . htmlspecialchars($service['service_name']) . '</a></li>';

}
echo '</ul>';

   } else {
      // This is where you put the code you want to run when both $city and $service are set
   }
}

?>



<?php include_once "includes/footer-no-cta.php"?>
   <style>
   
   
/* Change color of the default dot by replacing the hex code*/
.w-slider-dot {
background-color: #F2F4F7;
width: 0.625rem;
height: 0.625rem;
}
/* Change color of the active dot by replacing the hex code*/
.w-slider-dot.w-active {
background-color: #6941C6;
width: 0.625rem;
height: 0.625rem;
}

/*area css*/

#main {
  margin: 50px 0;
}

#main #faq .card {
  margin-bottom: 30px;
  border: 0;
}

#main #faq .card .card-header {
  border: 0;
  -webkit-box-shadow: 0 0 20px 0 rgba(213, 213, 213, 0.5);
          box-shadow: 0 0 20px 0 rgba(213, 213, 213, 0.5);
  border-radius: 2px;
  padding: 0;
}

#main #faq .card .card-header .btn-header-link {
  color: #fff;
  display: block;
  text-align: left;
  background: #006bf5;
  color: #fff;
  padding: 20px;
}

#main #faq .card .card-header .btn-header-link:after {
  content: "\f107";
  font-family: 'Font Awesome 5 Free';
  font-weight: 900;
  float: right;
}

#main #faq .card .card-header .btn-header-link.collapsed {
  background: #006bf5;
  color: #fff;
}

#main #faq .card .card-header .btn-header-link.collapsed:after {
  content: "\f106";
}

#main #faq .card .collapsing {
  background: #006bf5;
  line-height: 30px;
}

#main #faq .card .collapse {
  border: 0;
}

#main #faq .card .collapse.show {
  background: #fff;
  line-height: 30px;
  color: 000;
}
section.areas {
    margin-bottom: 250px;
}

ul.areas {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;

}


ul.services {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;

    max-width: 1400px;
    margin: 35px auto 0;
    column-count: 5;

}

@media(max-width:992px){
  ul.services {
    column-count: 4;

}
}
@media(max-width:768px){
  ul.services {
    column-count: 3;

}
}
@media(max-width:480px){
  ul.services {
    column-count: 2;

}
}
li.area-hd a {
    display: block;

    padding: 16px;
    text-decoration: none;
    text-transform: capitalize;
    font-size: 16px;
}li.services-hd a {
    display: block;

    padding: 16px;
    text-decoration: none;
    text-transform: capitalize;
    font-size: 16px;
}

@media(max-width:480px){
    li.area-hd {

    display: contents;
}
    li.area-hd a,li.services-hd a {

    text-align: left;
    padding: 10px 16px;

}
}
</style>
<script src="<?php echo BASE_URL; ?>js/local.js" type="text/javascript"></script>
<script>
$(document).ready(function() {
  $('#searchpx, .search-btn').on('click', function() {
    var value = $('#searchpx').val();
    $('#search_main_type1').val(value).trigger('keyup');
  });
});
</script>

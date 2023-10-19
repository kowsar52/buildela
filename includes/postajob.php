<?php
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

?>

<style>
input#images {
    background: #f2f3f7;
    border: 1.5px solid #f2f3f7;
    padding: 10px;
    border-radius: 35px;
    margin-bottom: 10px;
}
button.btn.cancel {
    border-radius: 20px;
    float: right;
    padding: 5px 20px;
}
form#signup_user1 .form-group label {
  
    text-transform: none;
    font-weight: 700;
    font-size: 0.9rem;
}

form#signup_user1 p {
    text-align: center;
    font-size: 1rem;
    margin-bottom: 2em;
}

form#signup_user1 h1 {
    font-size: 2rem;
    font-weight: 700;
    text-align: center;
}
.post-a-job-continue-btn {
	margin-top:20px;
	background: #0745cb;
    padding: 10px 20px;
    color: #fff;
    text-align: center;
    text-decoration: none;
    border-radius: 20px;
}
	

form#signup_user1 .form-group input#phone1, form#signup_user1 .form-group input#fname, form#signup_user1 .form-group input#pass {
    height: 3rem;
    min-width: 16rem;
    margin-bottom: 0rem;
    padding: 0.5rem 1.25rem;
    border-style: solid;
    border-width: 1px;
    border-color: #f2f3f7;
    border-radius: 8rem;
    background-color: #f2f3f7;
    -webkit-transition: border-color 250ms ease;
    transition: border-color 250ms ease;
    font-family: Montserrat, sans-serif;
    color: #1f2c3d;
    font-size: 1rem;
    line-height: 1.5;
    font-weight: 400;
}


</style>

<div class="pop-bk" id="formbk">
<form class="form-popup combine-form_label" id="post_job">
    <input type="hidden" id="user_id" value="<?=$id?>" name="">
    <div class="second-section-post-job-wrapper">
	<div class="second-section-post-job-inner">
		<div class="row mx-auto justify-content-center py-5">
			<div class="col-md-6">
				<div class="form-group">
				<div id="myDropdown" class="dropdown-content">
    <input class="combine-form_input-grey" type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction()">
    <a class="main" >Popular Searches</a>

	
	  <?php
                        foreach($mainCategory as $main){
                            ?>
                            <a class="sub" value="<?=$main['id']?>"> <?=$main['category_name']?></a>

                            <?php
                        }
                        ?>
						
						
						<?php
                        foreach($subCategory as $sub){
                            ?>
                            <a class="cat" value="<?=$sub['main_category']?>"> <?=$sub['category_name']?></a>

                            <?php
                        }
                        ?>
	</div>
				
				
				
				
				    <label id="titlejob" class="h2 pb-3 post-a-job-label" for="exampleFormControlSelect1">What would you like to have done?</label>
				    <select class="form-control post-a-job-select" id="select_category" onchange="setSubCategory()">
                        <option value="not-determined">Choose a Job Category</option>
                        <?php
                        foreach($mainCategory as $main){
                            ?>
                            <option value="<?=$main['id']?>"> <?=$main['category_name']?></option>

                            <?php
                        }
                        ?>
				    </select>
				</div>
				<div class="post-a-job-continue-btn-div pt-4">
					<a id="continue-btn0" onclick="setSubCategory(event)" type="button" class="post-a-job-continue-btn
					       btn-block text-white text-center px-5 py-2 text-decoration-none font-weight-bold rounded">Continue</a>
				</div>
		
				<div id="question-1" class="post-a-job-checkbox-wrapper bg-white rounded shadow mt-5 div-block-5">
					<div class="post-a-job-checkbox-inner p-4" id="checkboxs">
					</div>
				</div>
				<div class="post-a-job-continue-btn-div pt-4">
					<a id="continue-btn1" class="post-a-job-continue-btn btn-block text-white text-center px-5 py-2 text-decoration-none font-weight-bold rounded" >Continue</a>
				</div>


				<div id="question-2" class="post-a-job-checkbox-wrapper div-block-5 ">
					<div id="checkboxs1" class="post-a-job-checkbox-inner p-4 bg-white rounded shadow mt-5">
					</div>
					<div class="post-a-job-continue-btn-div pt-4">
						<a id="continue-btn2" class="post-a-job-continue-btn btn-block text-white text-center px-5 py-2 text-decoration-none font-weight-bold rounded" href="#">Continue</a>
					</div>
				</div>
				

                <div id="question-3" class="post-a-job-checkbox-wrapper bg-white rounded shadow mt-5 p-3 ">

                    <div class="form-group">
                        <label class="titlesjb" for="title">Job Title</label>
                        <input type="text"  class="form-control-lg form-control combine-form_input-grey " id="title">
                    </div>

                    <div class="form-group ">
                        <p><label class="titlesjb" for="images">Job Images or Videos</label></p>
                        <input type="file" name="multipleimagep[]"  class="form-control-lg form-control" id="images" multiple>
                        <small class="uplod">you can select multiple from your gallery</small>
                    </div>

                    <div class="form-group ">
                        <label class="titlesjb" for="post_code">Post code of job location</label>
                        <input type="text"  class="form-control-lg form-control combine-form_input-grey" id="post_code">
                    </div>


                    <div class="form-group">
                        <label class="titlesjb" >Add a description to your job</label>
						<textarea maxlength="3000" id="note" rows="6" class="form-control-lg form-control combine-form_text-area-grey" placeholder="Include any detail you think the tradesperson should know(nature of damage, timeframe, etc.)">
						</textarea>
<!--                        <span class="textarea_span bg-info">0/3000</span>-->
                    </div>
                    <?php
                    if($islogin==0){
                        ?>

                        <div class="post-a-job-continue-btn-div pt-4">
                            <button type="button" onclick="checklogin()" id="notLoginButton"  class=" continue-btn3 post-a-job-continue-btn btn-block text-white text-center px-5 py-2 text-decoration-none font-weight-bold rounded" >POST</button>
                        </div>
                        <?php
                    }else{
                        ?>
                        <div class="post-a-job-continue-btn-div pt-4">
                            <button type="submit" class="continue-btn3 post-a-job-continue-btn btn-block text-white text-center px-5 py-2 text-decoration-none font-weight-bold rounded" >POST</button>
                        </div>
                        <?php
                    }
                    ?>
                </div>
				
                <div class="post-a-job-checkbox-wrapper bg-white rounded shadow mt-5 p-3" id="addsignupform"></div>
                <div class="post-a-job-checkbox-wrapper bg-white rounded shadow mt-5 p-3" id="LoginForm1"></div>
                <div  class="post-a-job-checkbox-wrapper bg-white rounded shadow mt-5 p-3" id="NewSignupForm"></div>

			</div>
		</div>
	</div>
</div>
   <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
</form>
</div>
<script type="text/javascript">
    function checklogin(){

            if ($("#title").val()=='') {
                swal("Job title is missing", "", "info");
                $( "#title" ).focus();
                return;
            }
            else if($("#post_code").val()==''){
                swal("Job post code is missing", "", "info");
                $( "#post_code" ).focus();
                return;

            }else if($('textarea#note').val()==''){
                swal("Job discription is missing", "", "info");
                $( "#note" ).focus();
                return;
            }

            $(".continue_btn3").attr("disabled", true);
            $(".continue_btn3").html("Please wait...");

            let post_code=$('#post_code').val();
            var ajax_data = new FormData();
            ajax_data.append("func", '52');
            ajax_data.append('post_code',post_code );

            $.ajax({
                url: "serverside/post.php",
                type: "POST",
                processData: false,
                contentType: false,
                data:ajax_data,
                success: function (data) {

                    if(data.trim()!=200){
                          swal("Invalid postcode", "please enter a valid postcode!", "info");
                        $("#post_code").val('');
                        $( "#post_code" ).focus();
                        return;
                    }else {

                        $("#notLoginButton").hide();
                        $("#addsignupform").show();
                        $("#addsignupform").append(`
									<form id="signup_user2">
                                        <div class="form-group">
                                        <label for="email1">Email</label>
                                        <input type="email" required class="form-control-lg form-control combine-form_input-grey" id="email1">
                                        </div>
									    <button type ='button' class="post-a-job-continue-btn btn-block
                                                text-white text-center px-5 py-2 font-weight-bold rounded " id="email-btn">Next
                                        </button>
									</form>
									`);
                    }//else

                }//succes
            });//check post_code ajax

            $(".continue_btn3").attr("disabled", false);
            $(".continue_btn3").html("POST");

        // }//if not login
    }//check login method




</script>

<script>

$(function() {
  $('a.sub').on('click', function() {
	  
  var valueclick =  $(this).attr("value");
// Debug value
 // alert(valueclick);
  
   const $select = document.querySelector('#select_category');
  $select.value = valueclick;
  
     $("#myDropdown").css("display", "none");
	 $( "#continue-btn0" ).trigger( "click" );
	  $("#titlejob").css("display", "none");
	  $("#select_category").css("display", "none");
	
});
});

$(function() {
  $('a.cat').on('click', function() {
	  
  var valueclick =  $(this).attr("value");
// Debug value
 // alert(valueclick);
  
   const $select = document.querySelector('#select_category');
  $select.value = valueclick;
  
     $("#myDropdown").css("display", "none");
	 $( "#continue-btn0" ).trigger( "click" );
	  $("#titlejob").css("display", "none");
	  $("#select_category").css("display", "none");
	  var valuesub = 24;
	    $('input[name="involve"]').removeAttr('checked');
		$('input[name="involve"]').prop('checked', false);
//$('input[name="involve"][value="' + valuesub + '"]').prop('checked', true);
	
});
});






    function selectoptioncat(){
		var clickvalue = $(this).val();
		alert(clickvalue);
		
		
const changeSelected = (e) => {
  const $select = document.querySelector('#select_category');
  $select.value = clickvalue
};
	}
    document.getElementById('note').innerHTML = document.getElementById('note').innerHTML.trim();
</script>
<style>
.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}
   body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

/* Button used to open the contact form - fixed at the bottom of the page */
.open-button {
  background-color: #555;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  opacity: 0.8;
  position: fixed;
  bottom: 23px;
  right: 28px;
  width: 280px;
}

/* The popup form - hidden by default */
.form-popup {
    display: none;
    position: fixed;
    top: 20%;
    left: 32%;
    border-radius: 15px;
    padding: 10px;
    background: #fff;
    z-index: 9;
    width: 34%;
    overflow: hidden;
    min-height: 60%;
}

/* Add styles to the form container */
.form-container {
  width: 300px;
   max-height: 400px;
    overflow-y: scroll;
  padding: 10px;
  background-color: white;
      border-radius: 15px;
    padding: 10px;
    background: #fff;
}

/* Full-width input fields */
.form-container input[type=text], .form-container input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
}

/* When the inputs get focus, do something */
.form-container input[type=text]:focus, .form-container input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

/* Set a style for the submit/login button */
.form-container .btn {
  background-color: #04AA6D;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  margin-bottom:10px;
  opacity: 0.8;
}

/* Add a red background color to the cancel button */
.form-container .cancel {
  background-color: red;
}

/* Add some hover effects to buttons */
.form-container .btn:hover, .open-button:hover {
  opacity: 1;
}
.pop-bk {
    width: 100%;
    display: none;
    position: fixed;
    height: 100%;
    top: 0%;
    left: 0%;
    z-index: 1050;
    background-color: rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
	 
}
a.sub{
  padding-left:25px;
  
}
a.main{
   background: #ececec;
   font-weight:bold;
}
input.sc-35359047-1.FhzTQ {
    padding: 10px;
    border-radius: 10px;
}
button.button {
    padding: 10px;
    margin-left:10px;
    border-radius: 10px;
}

#select_category,#titlejob{
	display:none;
}


.second-section-post-job-wrapper {
    
    height: 530px;
}
label.form-check-label {
    text-transform: capitalize;
    display: inline-block;
}

button.btn.cancel {
    border-radius: 20px;
    float: right;
}
a#continue-btn0 {
    display: none;
}
button#notLoginButton {
    background: #0745cb;
    color: #fff;
    padding: 13px 40px;
    border-radius: 42px;
    width: 100%;
}
a#continue-btn1,a#continue-btn2 {
    background: #0745cb;
    padding: 10px 20px;
    color: #fff;
    text-align: center;
    text-decoration: none;
    border-radius: 20px;
}
.second-section-post-job-wrapper {
	    margin-bottom: 2.5rem;
    padding: 20px;
}

input#title,input#post_code,textarea#note,input#myInput {
    width: 100%;
}
input#myInput{
	margin-bottom:2rem;
}
label.titlesjb {
        text-transform: capitalize;
    font-weight: 700;
    font-size: 0.9rem;
    margin-top: 2.5rem;
    margin-bottom: 0.5rem;
}
.second-section-post-job-inner {
    overflow-y: scroll;
    height: 530px;
}

input#images {
    font-size: 0.9rem;
}
small.uplod {
    display: block;
    font-size: 0.8rem;
}

@media (min-width: 768px) and (max-width: 1024px) {
  
 .form-popup {
 
    width: 60%;
  
}
  
}

/* 
  ##Device = Tablets, Ipads (landscape)
  ##Screen = B/w 768px to 1024px
*/

@media (min-width: 768px) and (max-width: 1024px) and (orientation: landscape) {
  
  .form-popup {
 
    width: 70%;
  
}
  
}

/* 
  ##Device = Low Resolution Tablets, Mobiles (Landscape)
  ##Screen = B/w 481px to 767px
*/

@media (min-width: 481px) and (max-width: 767px) {
  
 .form-popup {
 
    width: 60%;
	 
  
}
  
}

/* 
  ##Device = Most of the Smartphones Mobiles (Portrait)
  ##Screen = B/w 320px to 479px
*/

@media (min-width: 320px) and (max-width: 480px) {
  
.form-popup {
 
    width: 60%;
   top: 10%;
    left: 11.5%;
}
.second-section-post-job-wrapper {
    overflow-y: auto;
    height: 530px;
    overflow-x: hidden!important;
    width: auto;
}
  
}
</style>
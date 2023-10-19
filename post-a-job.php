<?php
require_once "serverside/functions.php";

if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
    // session isn't started
    session_start();
}
// if(isset($_SESSION['user_type'])&&$_SESSION['user_role']=='home_owner'){

// }else if (isset($_SESSION['user_type'])&&$_SESSION['user_role']=='jobs_person')
// {

//  >
//  <script type="text/javascript">
//      window.location.href="dashboard-my-profile";
//  </script>
//  <?php

// }else{
//      //header('Location: sign-in');
//  >
//  <script type="text/javascript">
//      window.location.href="login";
//  </script>
//  <?php
//  exit();
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
include_once "includes/header.php";
?>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<script src="js/jquery-3.6.1.js" type="text/javascript"></script>


<style>
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

}
.combine-container-small-2 {
    width: 100%;
    max-width: 31rem;
    margin-right: auto;
    margin-left: auto;
}

button.post-a-job-continue-btn {
    background: #006bf5;
    padding: 10px 20px;
    color: #fff;
    text-align: center;
    text-decoration: none;
    border-radius: 20px;
    font-size: 18px;
}
.heading-jumbo-text {
    color: #006bf5!important;
    font-size: 3rem;
    font-weight: 700;
    font-family: 'Poppins', sans-serif!important;
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
}
label {
    text-transform: none;
}

.h2, h2 {
    font-size: 1.7rem;
    text-align: center!important;
}

.scrolling-wrapper h6 {
    background-color: rgb(249, 250, 255);
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
input#images {
    background: transparent!important;
    border: 1px solid #ced4da!important;
    padding: .5rem 1rem!important;
    border-radius: 5px!important;
    /* margin-bottom: 10px; */
}
/**/


/* 
  ##Device = Most of the Smartphones Mobiles (Portrait)
  ##Screen = B/w 320px to 479px
*/
.section.cc-home-wrap {


    padding-bottom: 60px;
    height: 600px;
}
@media (min-width: 320px) and (max-width: 480px) {
  
.section.cc-home-wrap {
  padding-bottom: 40px;
  height: auto;
}

.intro-header.cc-subpage.userprofile.postajob.hd {
    padding-top: 0px;
}
.heading-jumbo-text {
    color: #006bf5!important;
    font-size: 2rem;

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
.scrolling-wrapper-one label {
    letter-spacing: normal;
}
.card-input div {

    color: rgb(51, 51, 51);
}
.scrolling-wrapper-one .card-input {
    flex-wrap: nowrap!important;
}
.grid_row{
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}
.image_upload{
    width: 20%;
    position: relative;
}
.image_upload img{
    width: 100%;
}
.close_image{
    position: absolute;
    top: 0px;
    right: 0px;
    background-color: #ccc;
    border: 0px; 
    border-radius: 4px;
    width: 20px;
    height: 20px;
    text-align: center;
    cursor: pointer;
}

</style>
<div class="section cc-home-wrap postajob">
    <div class="intro-header cc-subpage userprofile postajob hd">
      <div class="intro-content">
        <div class="heading-jumbo-text">Post a job<br></div>
        <div class="heading-jumbo-small postajob">&quot;Connect with Buildela’s screened and reviewed tradespeople near you.&quot;</div>
      </div>
    </div>
    <section class="combine-section_contact1">
      <div class="combine-padding-global-2">
        <div class="combine-container-small-2">
          <div class="combine-padding-section-medium-2">
            <div class="combine-contact1_component w-form">
<div class="brix---mg-bottom-32px w-form">
              <div class="d-flex align-items-center justify-content-center search-input-wrapper py-1 px-2">
                                <input id="searchpx" readonly placeholder="Search e.g Electrician" type="email" class="form-control w-100 form-control-lg d-block" data-toggle="modal" data-target="#searchModal">
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
                            <label for="post_code"><span id="post_code_label">Post Code</span></label>
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
                            <input type="file" name="multipleimagep[]"  class="form-control-lg form-control" id="images"
                            onchange="preview_images();" multiple>
                            <div class="grid_row" id="image_preview"></div>
                            <small>you can select multiple from your gallery</small>
                        </div>



                       
                        <?php
                        if($islogin==0){
                            ?>

                            <div class="post-a-job-continue-btn-div pt-4">
                                <button type="button" onclick="checklogin(event)" id="notLoginButton"  class=" continue-btn3 post-a-job-continue-btn btn-block text-white text-center px-5 py-2 text-decoration-none font-weight-bold rounded" >POST</button>
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

<input id="country1" type="hidden" >
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
                    <p class="my-2 text-center">We've sent a verification code to your mobile number</p>
                    <input value="" type="hidden" id="verification_phone">
                    <div class="form-group">
                        <label for="verification_code">Please enter the verification code:</label>
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
<?php include_once "includes/footer-no-cta.php"?>
<script>
    jQuery(document).on("click", ".close_image", function() {    
       jQuery(this).parents(".image_upload").remove();
    });
    function preview_images() {
      var total_file = $("#images")[0].files.length;
      
        for (var i = 0; i < total_file; i++) {
          var imageUrl = URL.createObjectURL($("#images")[0].files[i]);
          
            $('#image_preview').append(`
                 <div class='image_upload'>
                    <img style='width:100%' class='img-responsive' src='${imageUrl}'>
                    <span class="close_image">✖</span>
                </div>`
            );
        }
    }

    $(document).ready(function() {
        // Set the desired value
        var selected_country = `<?=$job_posted_country?>`;

        $("post_code_label").html('');
        $("#country1").val(selected_country);
        if(selected_country=="America"){

            $("#post_code_label").html('ZIP Code');
            $('#post_code').attr('placeholder', 'ZIP Code');

        }else if(selected_country=="Australia"){

            $("#post_code_label").html('Post Code');
            $('#post_code').attr('placeholder', 'Post Code');

        }else if(selected_country=="Canada"){

            $("#post_code_label").html('ZIP Code');
            $('#post_code').attr('placeholder', 'ZIP Code');

        }else if(selected_country=="Ireland"){

            $("#post_code_label").html('Post Code');
            $('#post_code').attr('placeholder', 'Post Code');

        }else if(selected_country=="Italy"){

            $("#post_code_label").html('Post Code');
            $('#post_code').attr('placeholder', 'Post Code');

        }else if(selected_country=="South Africa"){

            $("#post_code_label").html('Post Code');
            $('#post_code').attr('placeholder', 'Post Code');

        }else if(selected_country=="Turkey"){

            $("#post_code_label").html('Post Code');
            $('#post_code').attr('placeholder', 'Post Code');

        }else if(selected_country=="UK"){

            $("#post_code_label").html('Post Code');
            $('#post_code').attr('placeholder', 'Post Code');

        }else if(selected_country=="United Arab Emirates"){

            $("#post_code_label").html('Post Code');
            $('#post_code').attr('placeholder', 'Post Code');
        }

    });
</script>
<script>
    function checklogin(e){
        e.preventDefault();

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
  //alert(post_code);
        $.ajax({
            url: "serverside/post.php",
            type: "POST",
            processData: false,
            contentType: false,
            data:ajax_data,
            success: function (data) {
//alert(data);
                if(data.trim()!=200){
                    alert(data);
                    swal("Invalid postcode", "Please enter a valid postcode!", "info");
                    $("#post_code").val('');
                    $( "#post_code" ).focus();
                    return;
                }else {

                    $("#notLoginButton").hide();
                    $("#addsignupform").show();
                    $("#question-3").hide();
                    $("#addsignupform").html('');
                    $("#addsignupform").append(`
                                    <form id="signup_user2">
                                        <div class="form-group">
                                        <label for="email1">Email</label>
                                        <input type="email" required class="form-control-lg form-control" id="email1">
                                        </div>
                                        

                                        <button type ='button' class="post-a-job-continue-btn btn-block
                                                text-white text-center px-5 py-2 font-weight-bold rounded" id="email-btn">Next
                                        </button>

 </div>
                                        <button id="new-back-btn-4" onclick="goback1(event)" type="button"  class="text-decoration-none align-items-center border p-2 rounded m-1 btn">
                                            <i class="fa fa-angle-left"></i>
                                                Back
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
  
  document.getElementById('note').innerHTML = document.getElementById('note').innerHTML.trim();

  $('#searchpx').on('click', function() {
    $('#searchModal').modal('show');
  });

  // This event is triggered when the modal has been shown
  $('#searchModal').on('shown.bs.modal', function() {
    $("#search_main_type1").focus();
  });

  $(document).ready(function() {
    $("#searchpx").keyup(function() {
      $("#search_main_type1").val($("#searchpx").val());
    });

    $(".text-cat").click(function() {
      var catclick = $(this).attr("value");
      $('#searchModal').modal('show');
      $('#search_main_type1').val(catclick).trigger('keyup');
    });
  });
</script> 
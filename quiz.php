<?php
require_once "serverside/functions.php";
include_once "serverside/session.php";

if ( isset($_SESSION['user_id']) && isset($_GET['main_Category_id'])) {

    $func=new Functions();
    $mainCategory=$func->SingleMainCategory($_GET['main_Category_id']);
    $questions=$func->getAllQuestions();

    $electrical=0;
    $gas=0;

    if($_GET['main_Category_id']==18){

        $electrical_array=$func->getMyElectricalDocs($_SESSION['user_id']);
        $electrical=count($electrical_array);
    

    }else if($_GET['main_Category_id']==23){

        $gas_array=$func->getMyGasDocs($_SESSION['user_id']);
        $gas=count($gas_array);

    }

}else
{
    ?>
    <script type="text/javascript">window.location.href="index";</script>
    <?php
    exit();
}
include_once "includes/header.php";
?>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="css/style.css?v=0.04" rel="stylesheet" type="text/css">
<style>
.check-box-div label {

    font-weight: 500!important;
    font-size: 16px;
    color: inherit;
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
    letter-spacing: 0.5px;
    text-transform: unset!important;
}
.form-check-border-bottom-1 {
    border-bottom: 1px solid #555;
}
.quiz-page-heading {

    font-size: 30px;
    font-weight: 600;
}
a#next {
    background: #006bf5;
    color: #fff;
	    border: 1px solid #006bf5;
}
a#next:hover {
    background-color: #1861d1;
}
.combine-button {

    border-radius: 0.5rem;
}
h1.quiz.title-heading {
    font-size: 35px;
	 text-align: center;
   color: #006bf5;
    margin-top: 0;
}
.quiz-question {
    font-weight: 500;
    text-align: left;
    font-size: 1.1rem;
}

.new-quiz-label{

	font-weight: 600!important;
}
.new-quiz-text{
	font-size: 18px;
  margin-bottom: 15px;
}
.start-quiz-btn{

}
.upload-label {
    cursor: pointer;
    border-radius: 20px;

    font-size: 15px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    border: 1px dashed;
}
.upload-label:hover {
    border-color: #006BF5;
}
.upload-label input{
/*	display: none;*/
  border: 0;
	width: 50% !important;
	padding: 0 !important;
	height: unset !important;
}
.upload-label input:focus {
    outline: 0 !important;
    box-shadow:unset !important;
}
.upload-label input:focus {
    outline: 0 !important;
    box-shadow:unset !important;
}
.new-thanks-heading{
	font-size: 24px;
	font-family: 'Montserrat', sans-serif;
	font-weight: bold;
	color:rgba(63, 107, 247, 1.0);
}

.new-thanks-text{
	font-size: 18px;
}
input::file-selector-button {
    display: none !important;
}
.u_label{

	padding:3px 10px !important;
  font-weight: 600;


}
.upload-label:hover .u_label {
    color: #006BF5;
}
.section.cc-home-wrap {
    padding-top: 0px;
}

element.style {
}
a#prev {
    color: #000;
    background: #fff;
    border-color: #fff;
}
a#prev:hover {
    color: #006BF5;
}
.id-box {
    padding-left: 10px;
    padding-right: 10px;
    padding-top: 25px;
    border-top: 1px solid;
}

div#loader {
    margin-left: auto;
    margin-right: auto;
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    align-content: center;
    justify-content: center;
    align-items: center;
    margin-bottom: 30px;
}
</style>



<div class="quiz-wrapper py-5">
    <div class="quiz-wrapper-inne ">
        <div class="container">
            <div class="row mx-auto justify-content-center">
                <input value="<?=$_GET['main_Category_id']?>" type="hidden" id="category_id">

                <div id="electrical" style="display: none"  class= "col-md-6">
                    <form id="electrical_certification">
                        <div class="new-quiz-text py-4">
                            Select a <b><u>minimum of 3 </u></b>certificates to upload.
                            The more certificates the more badges will show under your qualifications, making you more credible and stand out from the crowd.
                        </div>
                        <div class="pt-4">
                            <div class="">
                                <div class="quiz-page-quiz-wrapper-inner">


                                    <div class="form-group mb-2">
                                        <label class="new-quiz-label text-white w-100 mb-0" for="" >NICEIC Certificate</label>
                                    </div>
                                    <div class="upload-input mx-auto text-right py-2">
                                        <label class="upload-label px-3 py-2">
                                            <input class="form-control" type="file"  id="NICEIC" >
                                            <div class="u_label">+ Upload document</div>
                                        </label>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="new-quiz-label text-white w-100 mb-0" for="" >ECA Certificate</label>
                                    </div>
                                    <div class="upload-input mx-auto text-right py-2">
                                        <label class="upload-label px-3 py-2">
                                            <input class="form-control" type="file"  id="ECA">
                                            <div class="u_label">+ Upload document</div>
                                        </label>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="new-quiz-label text-white w-100 mb-0" for="" >NAPIT Certificate</label>
                                    </div>
                                    <div class="upload-input mx-auto text-right py-2">
                                        <label class="upload-label px-3 py-2">
                                             <input class="form-control" type="file"  id="NAPIT">
                                            <div class="u_label">+ Upload document</div>
                                        </label>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="new-quiz-label text-white w-100 mb-0" for="" >Gold JIB Card</label>
                                    </div>
                                    <div class="upload-input mx-auto text-right py-2">
                                        <label class="upload-label px-3 py-2">
                                            <input class="form-control" type="file"  id="gold">
                                            <div class="u_label">+ Upload document</div>
                                        </label>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="new-quiz-label text-white w-100 mb-0" for="" >2391 Inspection & Testing</label>
                                    </div>
                                    <div class="upload-input mx-auto text-right py-2">
                                        <label class="upload-label px-3 py-2">
                                            <input class="form-control" type="file"  id="inspection" >
                                            <div class="u_label">+ Upload document</div>
                                        </label>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="new-quiz-label text-white w-100 mb-0" for="" >18th Edition Regulations</label>
                                    </div>
                                    <div class="upload-input mx-auto text-right py-2">
                                        <label class="upload-label px-3 py-2">
                                            <input class="form-control" type="file"  id="edition" >
                                            <div class="u_label">+ Upload document</div>
                                        </label>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="new-quiz-label text-white w-100 mb-0" for="" >Level 3 Certificate (NVQ / Diploma)</label>
                                    </div>
                                    <div class="upload-input mx-auto text-right py-2">
                                        <label class="upload-label px-3 py-2">
                                            <input class="form-control" type="file"  id="level3" >
                                            <div class="u_label">+ Upload document</div>
                                        </label>
                                    </div>
									<div class="id-box">
                                    <div class="form-group mb-2">
									<div class="new-quiz-text">Please provide an item of identification by uploading an up to date ID Document / Card</div>
                                        <label class="new-quiz-label text-white w-100 mb-0" for="" >Proof of ID (Passport/Driving License)</label>
                                    </div>
                                    <div class="upload-input mx-auto text-right py-2">
                                        <label class="upload-label px-3 py-2">
                                            <input style="background:#f9f9f9;"class="form-control" required type="file"  id="id_card" >
                                            <div class="u_label">+ Upload document</div>
                                        </label>
                                    </div>
									</div>
                                </div>
                            </div>

                            <div class="row mx-0 justify-content-center">
                                <div class="col-md-6">
                                    <div class="btn-div-general pt-2 text-center">
                                        <button type="submit" id="submit_files" class="btn btn-primary btn-lg start-quiz-btn px-5" >Start Quiz</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <div id="gas"  style="display: none" class=" col-md-6">
                    <form id="gas_certification">
                        
                        <div class="pt-4">
                            <div class="mb-4">
                                <div class="quiz-page-quiz-wrapper-inner p-4">
                                    <div class="new-quiz-text py-4 mb-3">Please enter your Gas safety registration number & upload the certificate.</div>
                                    <div class="form-group">
                                        <label class="new-quiz-label text-white w-100" for="" >Gas Safety Registration Number</label>
                                        <input class="form-control" required type="text"  id="registration_number" placeholder="Enter registration number">

                                    </div>
                                    <div class="upload-input mx-auto">
                                        <label class="upload-label px-3 py-2">
                                            <input class="form-control " required type="file"  id="certificate">
                                            <div class="u_label">+ Upload document</div>
                                        </label>
                                    </div>
                                    <div class="new-quiz-text">Please provide an item of identification by uploading an up to date ID Document / Card</div>

                                    <div class="form-group">
                                        <label class="new-quiz-label text-white w-100 mb-0" for="" >Proof of ID (Passport/Driving License)</label>
                                    </div>
                                    <div class="upload-input mx-auto text-right">
                                        <label class="upload-label px-3 py-2">
                                            <input class="form-control" required type="file"  id="id_card_gas" >
                                            <div class="u_label">+ Upload document</div>
                                        </label>
                                    </div>
                                    <div class="btn-div-general pt-2 text-center">
                                        <button type="submit" id="submit_gas" class="btn btn-primary btn-lg start-quiz-btn px-5" >Start Quiz</button>
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                    </form>
                </div>
           

            </div>
        </div>

    </div>
</div>



 <div  id="question_div" style="display: none" class="section cc-home-wrap postajob quiz">
    <section class="combine-section_contact1">
      <div class="combine-padding-global-2">
        <div class="combine-container-small-2">
          <div class="combine-padding-section-medium-2">
            <div class="combine-contact1_component quiz w-form">
              <form id="wf-form-Contact-1-Form" name="wf-form-Contact-1-Form" data-name="Contact 1 Form" method="get" class="combine-form_form">
                <h1 class="quiz title-heading"><?=$mainCategory[0]['category_name']?></h1>
                <div class="quiz-question"><p id="question"></p></div>
                <div class="div-block-5 mt-3 mb-5">
				
				
				<div class="form-check  check-box-div form-check-border-bottom-1 radio-button-field ">
									<input class="form-check-input" type="radio" name="option_radio" id="option1_radio" value="">
									<label class="form-check-label " for="option1_radio" id="option1"></label>
								</div>
				
				
				
				<div class="form-check  check-box-div form-check-border-bottom-1 radio-button-field ">
									<input class="form-check-input" type="radio" name="option_radio" id="option2_radio" value="">
									<label class="form-check-label " for="option2_radio" id="option2"></label>
								</div>


<div class="form-check  check-box-div form-check-border-bottom-1 radio-button-field ">
									<input class="form-check-input" type="radio" name="option_radio" id="option3_radio" value="">
									<label class="form-check-label " for="option3_radio" id="option3"></label>
								</div>


<div class="form-check  check-box-div form-check-border-bottom-1 radio-button-field ">
									<input class="form-check-input" type="radio" name="option_radio" id="option4_radio" value="">
									<label class="form-check-label " for="option4_radio" id="option4"></label>
								</div>

				</div>
				
				<a id="next" type="submit" class="combine-button w-button">Continue</a>
				       <a id="prev" class="w-button mt-3" href="#"><i class="fa-solid fa-arrow-left"></i> Back</a>
                  <div class="question-number row mx-0 text-center justify-content-end pt-2">
                            <small>Question <span id="question_no"></span> /<span id="total_question"></span></small>
                        </div>
              </form>
          
		  
              
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>


<div id="loader" style="display: none;">
    <img src="images/loading.gif" alt="Loading..." />
</div>


<?php include_once "includes/footer-no-cta.php"?>
<script type="text/javascript" src="customjs/mcqs.js"></script>
<script type="text/javascript">
    $( document ).ready(function() {

        if('<?=$_GET['main_Category_id']?>'==18 && '<?=$electrical ==0 ?>' && '<?= isset($_GET['ajax'])?>' ==false){

            $("#electrical").show();
            $("#question_div").hide();
            $("#gas").hide();

        }else if('<?=$_GET['main_Category_id']?>'==23 && '<?=$gas == 0  ?>' && '<?= isset($_GET['ajax'])?>'==false ){

            $("#gas").show();
            $("#question_div").hide();
            $("#electrical").hide();

        }else{

            $("#question_div").show();
            $("#electrical").hide();
            $("#gas").hide();
        }

        const urlParams = new URLSearchParams(window.location.search);
        const pageSize = urlParams.get('main_Category_id');
        const q_id=pageSize;

        $.ajax({
            url: "serverside/post.php",
            type: "POST",
            data: {
                func: 23,
                q_id:q_id,

            },
            success: function (data) {
                var mydata=JSON.parse(data);
                if(mydata.length>0) {

                    $('#question').html(mydata[0].question);
                    $("#option1").html(mydata[0].option1);
                    $("#option2").html(mydata[0].option2);
                    $("#option3").html(mydata[0].option3);
                    $("#option4").html(mydata[0].option4);
                    $('#option1_radio').val(mydata[0].option1)
                    $('#option2_radio').val(mydata[0].option2)
                    $('#option3_radio').val(mydata[0].option3)
                    $('#option4_radio').val(mydata[0].option4)
                    questions = mydata;
                    totallength = questions.length;
                    $("#total_question").html(totallength);
                }
            }
        });

    });
</script>

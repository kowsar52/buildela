<?php
include_once "includes/header.php";
require_once "serverside/functions.php";

if (!isset($_SESSION['user_id'])) {


}else
{
    ?>
    <script type="text/javascript">window.location.href="my-profile";</script>
    <?php
    exit();
}
$func = new Functions();
$settings=$func->getSettings();
$stripe_public_key = $settings[0]['stripe_public_key'];
$stripe_private_key = $settings[0]['stripe_private_key'];
?>
<script src="https://js.stripe.com/v3/"></script>


<style> .new-sign-up-wrapper-inner {
    margin-bottom: 26px;
}
.new-sign-up-wrapper-inner {
    margin-bottom: 26px;
}
.f-account-section {
    position: relative;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    height: auto;
    min-height: 900px;
}
a.btn-bg-general.btn-block.text-white.text-center.px-5.py-2.text-decoration-none.font-weight-bold.rounded.continue_btn_1,button#signup_btn {
    background: #006bf5;
}
</style>

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<script src="js/jquery-3.6.1.js" type="text/javascript"></script>



<div class="f-account-section">
    <div class="f-account-image-wrapper"><img src="images/workman.png" loading="lazy" alt="" class="f-image-cover"></div>
    <div class="f-account-container-r">
      <div class="f-account-content-wrapper">
        <div class="f-margin-bottom-08">
          <h5 class="f-h5-heading">Register as a homeowner</h5>
        </div>
        <p class="f-paragraph-regular">Buildela supports quality tradespeople. Our application process is strict and only those who meet our high standards are accepted.</p>
        <div class="f-margin-bottom-24"></div>
  
  <div class="new-sign-up-wrapper bg-white">
    <div class="new-sign-up-wrapper-inner">
        <div class="sign-up-first-section py-5">
            <div class="container">
                <div class="row mx-auto justify-content-center">
                    <div class="col-md-12" >
                        <div class="form">
                            <form id="home_sign_up">
                

                                <div class="form-group">
                                    <label for="fname">First Name</label>
                                    <input type="text" class="form-control form-control-lg" required placeholder="Enter first name" id="fname">
                                </div>
                                <div class="form-group">
                                    <label for="lname">Last Name</label>
                                    <input type="text" class="form-control form-control-lg " placeholder="Enter last name" id="lname">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control form-control-lg " required  placeholder="Enter Email" id="email">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control form-control-lg "  required placeholder="+447222555555" id="phone">
                                </div>
                                <div class="form-group">
                                    <label for="work_address">First Line of address</label>
                                    <input type="text" class="form-control-lg form-control" required id="work_address" required placeholder="First Line">
                                </div>
                                <div class="form-group">
                                    <label for="work_address1">Second Line of address</label>
                                    <input type="text" class="form-control-lg form-control" id="work_address1" placeholder="Last Name">
                                </div>
                                <div class="form-group d-none ">
                                    <label for="country">Country</label>
                                    <select class="form-control form-control-lg"  id="country">

                                        <option value="America">America</option>
                                        <option value="Australia">Australia</option>
                                        <option value="Canada">Canada</option>
                                        <option value="Ireland">Ireland</option>
                                        <option value="Italy">Italy</option>
                                        <!--                                        <option value="South Africa">South Africa</option>-->
                                        <option value="Turkey">Turkey</option>
                                        <option value="UK">UK</option>
                                        <!--                                        <option value="United Arab Emirates">United Arab Emirates</option>-->

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="post_code"><span id="post_code_label">Post Code</span></label>
                                    <input type="text" class="form-control form-control-lg " required  placeholder="Enter Post Code" id="post_code">
                                </div>
                                <div class="form-group">
                                    <label for="pass1">Password</label>
                                    <input type="password" required class="form-control form-control-lg " id="pass1">
                                </div>

                                <div class="form-group">
                                    <label for="pass2">Confirm Password</label>
                                    <input type="password" class="form-control form-control-lg " id="pass2">
                                </div>

                                <button type ='submit' class="btn-bg-general btn-block text-white text-center px-5 py-2 text-decoration-none font-weight-bold rounded" id="signup_btn" >Sign Up</button>

                

                            </form>
                            <input type="hidden" value="0" id="isphoneverifiy">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
	
	<div class="sign-up-five-section py-5">
        <p class="f-paragraph-small">Already have an account? <a href="login" class="f-account-link">Sign in</a>
        </p>
      </div>
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
<?php include_once "includes/footer-no-cta.php"?>
<script>
    $(document).ready(function() {
        // Set the desired value
        var selectedValue = `<?=$job_posted_country?>`;

        // Change the selected option based on the value
        $("#country").val(selectedValue);
        $("#country").trigger("change");
    });
    $("#country").change(function (e){
        e.preventDefault();
        $("post_code_label").html('');
        let selected_country=$("#country option:selected").val();

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


<?php
$pageTitle = "Trade Sign Up";
$pageDescription = "Win an Unlimited Amount of Leads - For Just £9.99 Per Month ";
include_once "includes/header.php";
require_once "serverside/functions.php";
$func = new Functions();
if (isset($_SESSION['user_id'])) $func->redirect('my-profile'); 

    
    
    $settings=$func->getSettings();
    $stripe_public_key = $settings[0]['stripe_public_key'];
    $stripe_private_key = $settings[0]['stripe_private_key'];
    
    $userinfo         = $func->getClientlocation($_SERVER['REMOTE_ADDR']);
    $usercurrencies     = $func->countryCurrency($userinfo['country']);
    $buildelaCountries  = $func->countries();
    sort($buildelaCountries);

    $prices       = [];
    $plansdatabse = $func->getplans();
    if ($plansdatabse) foreach($plansdatabse as $key => $value) $prices[$value['type']] = $value['price'];

    
    $usercurrencies   = $func->countryCurrency($userinfo['country']);



    if($usercurrencies['currency'] == 'GBP') {

        $proMonthlyPrice   = $prices['pro_membership_monthly']; 
        $proMembershipMonthlyFoYearly   = $prices['pro_membership_monthly_for_yearly']; 
        $proYearlyPrice   = $prices['pro_membership_yearly']; 
        $monthlyprice   = $prices['monthly']; 
        $monthlyonyearly= $prices['monthly_for_yearly'];
        $yearlyprice    = $prices['yearly'];
        $other_monthly  = $prices['other_site_monthly'];
        $other_yearly   = $prices['other_site_yearly'];
        $referralmonthly= $prices['referral_first_month_price'];
        $referralyearly = $prices['referral_first_year_price'];
        $currencyname   = $prices['currency'];
        $currencysymbol = $prices['symbol'];

    }else {

        $proMonthlyPrice   = $func->convertCurrency($prices['pro_membership_monthly'], $prices['currency'], $usercurrencies['currency']);
        $proMembershipMonthlyFoYearly   = $func->convertCurrency($prices['pro_membership_monthly_for_yearly'], $prices['currency'], $usercurrencies['currency']);
        $proYearlyPrice   = $func->convertCurrency($prices['pro_membership_yearly'], $prices['currency'], $usercurrencies['currency']);
        $monthlyprice   = $func->convertCurrency($prices['monthly'], $prices['currency'], $usercurrencies['currency']);
        $monthlyonyearly= $func->convertCurrency($prices['monthly_for_yearly'], $prices['currency'], $usercurrencies['currency']);
        $yearlyprice    = $func->convertCurrency($prices['yearly'], $prices['currency'], $usercurrencies['currency']);
        $other_monthly  = $func->convertCurrency($prices['other_site_monthly'], $prices['currency'], $usercurrencies['currency']);
        $other_yearly   = $func->convertCurrency($prices['other_site_yearly'], $prices['currency'], $usercurrencies['currency']);
        $referralmonthly= $func->convertCurrency($prices['referral_first_month_price'], $prices['currency'], $usercurrencies['currency']);
        $referralyearly = $func->convertCurrency($prices['referral_first_year_price'], $prices['currency'], $usercurrencies['currency']);
        $currencyname   = $usercurrencies['currency'];
        $currencysymbol = $usercurrencies['symbol'];
    
    }


?>
<script>
    
</script>
<script src="https://js.stripe.com/v3/"></script>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<script src="js/jquery-3.6.1.js" type="text/javascript"></script>

<style> 

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
    a.continue_btn_1 {
        color: #fff!important;
    }
    .f-paragraph-regular {
        margin-bottom: 0px;
        font-size: 16px;
        line-height: 1.8;
        letter-spacing: -0.02em;
        padding-left: 15px;
        color: #495057;
    }
    .f-margin-bottom-08 {
        margin-bottom: 8px;
        padding-left: 15px;
    }
    .f-h5-heading{
      font-weight: 700;
    }
    a.continue_btn_2,a.continue_btn_3,a.continue_btn_4 {

        color: #fff!important;
    }
    a.btn-bg-general.btn-block.text-white.text-center {
        background: #006bf5;
    }
    .new-sign-up-steps {
        margin-bottom: 15px;
        font-weight: 700;
    }

    .f-button-neutral-3 {
        border-radius: 8px;
    }

    a.back-btn {
        font-weight: 700!important;
        cursor: pointer;
    }

    a.back-btn:hover {
        color: #006BF5;
    }

    .new-sign-up-heading {
        font-size: 1.89rem;
    }

    span#reffred_by {
        color: #24aa3cd1;
    }

    .paymentbtns {
        display: grid;
        gap: 10px;
        justify-content: space-between;
        grid-template-columns: 1fr 2fr;
        align-items: center;
    }



    /*
      ##Device = Most of the Smartphones Mobiles (Portrait)
      ##Screen = B/w 320px to 479px
    */

    @media (min-width: 320px) and (max-width: 480px) {

        .container {
            text-align: left;
        }
        .f-paragraph-regular {
            margin-bottom: 0px;
            font-size: 16px;
            line-height: 1.8;
            letter-spacing: -0.02em;
            padding-left: 15px;
            color: #495057;
            padding-right: 30px;
        }
        label.form-check-label a {
            display: inline-block!important;
        }
        label.form-check-label {
            text-transform: none!important;
            display: block;
        }
        .new-sign-up-heading.h2.pt-2.pb-5 {
            padding-bottom: 1rem!important;
        }

        .sign-up-five-section.py-5 {
            padding-top: 0rem!important;
        }
        .new-sign-up-text.pb-3 {
            display: inline;
        }
        .new-sign-up-text.pb-3 a {
            display: inline;
        }

    }

    .per-month-charges.p-2 {
        font-weight: 700;
    }
    a.btn-bg-general.btn-block.text-white.text-center {
        background: #006bf5;
        color: #fff;
    }a.btn-bg-general.btn-block.text-white.text-center:hover {
         background: #006bf5;
         color: #000;
     }

    .new-sign-up-text.pb-3 a {
        display: inline-block;
    }
    label.form-check-label a {
        display: inline!important;
    }

    button#payment_btn {
        display: inline-flex;
        align-content: center;
        flex-direction: row;
        flex-wrap: nowrap;
        justify-content: center;
        align-items: center;
        width: 100%;
    }

    .gap-2 {
        gap: .5rem!important;
    }
    .f-account-content-wrapper{
        max-width: 500px;
    }

    #countrySearch {
        display: none;
        position: absolute;
        width: 100%;
        z-index: 2;
    }

@media(max-width:480px){
  .select-annual{
    min-width:130px!important;
}
}
</style>




<div class="f-account-section">
    <div class="f-account-image-wrapper"><img src="images/workman.png" loading="lazy" alt="" class="f-image-cover"></div>
    <div class="f-account-container-r">
        <div class="f-account-content-wrapper">
            <div class="f-margin-bottom-08">
                <h5 class="f-h5-heading">Register as a pro</h5>
            </div>
            <p class="f-paragraph-regular">At Buildela, we back skilled tradespeople who deliver top-notch quality. Our selection process is rigorous, and we exclusively approve individuals who fulfil our elevated criteria.</p>
            <div class="f-margin-bottom-24"></div>

            <div class="new-sign-up-wrapper-inner">
                <div class="sign-up-first-section py-5">
                    <div class="container">
                        <div class="row mx-auto justify-content-center">
                            <div class="col-md-12" >
                                <div class="new-sign-up-steps">Step 1 of 5</div>


                                <div class="form-group">
                                    <input value="0" id="isphoneverifiy" type="hidden">

                                    <label for="fname">First Name</label>
                                    <input type="text" class="f-field-input-2 w-input" id="fname" placeholder="First Name">
                                </div>
                                <div class="form-group">
                                    <label for="lname">Last Name</label>
                                    <input type="text" class="f-field-input-2 w-input" id="lname" placeholder="Last Name">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" class="f-field-input-2 w-input" id="phone" placeholder="Phone Number" value="<?php echo $func->dialcode($userinfo['country']); ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="f-field-input-2 w-input" id="email" placeholder="Email">
                                </div>
                                <div style="display:none;" class="form-group">
                                    <label for="dbs">Do you have a valid in date DBS Certificate?</label>
                                    <select id="dbs_option" class="f-field-input-2 w-input" onchange="setDBS()" >
                                        <option value="0" selected>No</option>
                                        <option value="1">Yes</option>
                                    </select>

                                </div>
                                <div style="display:none;" class="form-group " id="dbs_div">
                                    <label for="dbs">Upload DBS Certificate</label><br>
                                    <input type="file" class="f-field-input-2 w-input" id="dbs" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="pass1">Password</label>
                                    <input type="password" class="f-field-input-2 w-input" id="pass1" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="pass2">Confirm Password</label>
                                    <input type="password" class="f-field-input-2 w-input" id="pass2">
                                </div>
                                <div class="form-group form-check pt-2">
                                    <input type="checkbox" class="form-check-input" id="builder1">
                                    <label class="form-check-label" for="builder1">I'd like to receive Buildela News, Advice and Tips</label>
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="builder2">
                                    <label class="form-check-label" for="builder2">I agree to the Buildela <a target="_blank" href="terms-and-condition">Terms & Conditions</a> , and the <a target="_blank" href="privacy">Privacy Policy</a></label>
                                </div>
                                <div class="btn-div-general pt-2 text-center">
                                    <a class="f-button-neutral-3 w-button continue_btn_1"  type="button" >Continue</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sign-up-second-section py-5">
                <div class="container">
                    <div class="row mx-auto justify-content-center">
                        <div class="col-md-12">
                            <div class="new-sign-up-steps">Step 2 of 5</div>
                            <div class="new-sign-up-heading h2 py-2">About you</div>
                            <div class="new-sign-up-text pb-3">You operate as a:</div>
                            <div class="sign-up-quiz-wrapper bg-white rounded border">
                                <div class="sign-up-quiz-wrapper-inner  py-3 px-3">
                                    <div class="form-check  check-box-div form-check-border-bottom-1 mb-2 ">
                                        <input class="form-check-input" type="radio" name="about_you" id="operate_0" value="Self-employed" checked>
                                        <label class="form-check-label sign-up-label ml-2" for="operate_0">
                                            Self-employed / Sole Trader
                                        </label>
                                    </div>
                                    <div class="form-check  check-box-div form-check-border-bottom-1 mb-2">
                                        <input class="form-check-input" type="radio" name="about_you" id="operate_1" value="Limited-Company">
                                        <label class="form-check-label sign-up-label ml-2" for="operate_1">
                                            Limited Company
                                        </label>
                                    </div>
                                    <div class="form-check  check-box-div form-check-border-bottom-1 mb-2">
                                        <input class="form-check-input" type="radio" name="about_you" id="operate_2" value="Ordinary-Partnership" >
                                        <label class="form-check-label sign-up-label ml-2" for="operate_2">
                                            Ordinary Partnership
                                        </label>
                                    </div>
                                    <div class="form-check  check-box-div form-check-border-bottom-1">
                                        <input class="form-check-input" type="radio" name="about_you" id="operate_3" value="Limited-Partnership">
                                        <label class="form-check-label sign-up-label ml-2" for="operate_3">
                                            Limited Partnership
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="trading-name-sign-up pt-3">Trading Name</div>
                            <div class="new-sign-up-text">This can be just your name if you don't have one</div>
                            <div class="form-group">
                                <input type="text" class="f-field-input-2 w-input" id="trading_name" placeholder="" required>
                            </div>
                            <div class="row mx-0 ">

                                <div class="col-md-8 p-0 ">
                                    <div class="btn-div-general pt-2 text-center">
                                        <a class="f-button-neutral-3 w-button continue_btn_2" >Continue</a>
                                    </div>
                                </div>
                                <div class="col-md-4 p-0">
                                    <div class="btn-div-general pt-3 text-center mr-0 mr-md-1 mr-lg-1">
                                        <a class="back-btn btn-block text-center px-2 py-2 text-decoration-none font-weight-bold rounded back_btn_2" ><i class="fa-solid fa-arrow-left"></i> Back</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sign-up-third-section py-5">
                <div class="container">
                    <div class="row mx-auto justify-content-center">
                        <div class="col-md-12">
                            <div class="new-sign-up-steps">Step 3 of 5</div>
                            <div class="new-sign-up-heading h2 pt-2 pb-5">Whats your Work Address?</div>
                            <div class="form">

                                <div class="form-group">
                                    <label for="work_address">First Line Address</label>
                                    <input type="text" class="f-field-input-2 w-input" id="work_address" placeholder="First Line">
                                </div>
                                <div class="form-group">
                                    <label for="work_address1">Second Line Address</label>
                                    <input type="text" class="f-field-input-2 w-input" id="work_address1" placeholder="Second Line">
                                </div>
                                <div class="form-group ">
                                    <label for="countryname"><span id="country_label">Country</span></label>
                                    <!-- <input type="text" id="countrySearch" placeholder="Search for a country"> -->
                                    <div class="country-dropdown">
                                        <select class="form-control" id="countryname">
                                            <option value="">Please Select</option>
                                            <?php
                                                foreach($buildelaCountries as $countryname){
                                                    if($userinfo['country'] == $countryname){
                                                        ?>
                                                        <option value="<?=$countryname ?>" selected><?=$countryname?></option>
                                                        <?php
                                                    }else {
                                            ?>
                                                <option value="<?=$countryname ?>" ><?=$countryname?></option>
                                            <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="town">City</label>
                                    <input type="text" class="f-field-input-2 w-input" id="town" placeholder="City" value="<?php echo $userinfo['city']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="post_code"><span id="post_code_label">Post Code</span></label>
                                    <input type="text" class="f-field-input-2 w-input" id="post_code" placeholder="Post Code">
                                </div>
                                <div class="form-group ">
                                    <label for="distance">What is the maximum distance you are willing to travel for work</label>
                                    <select class="f-field-input-2 w-input" id="distance">
                                        <option>Please Select</option>
                                        <option value="5">5 miles</option>
                                        <option value="10">10 miles</option>
                                        <option value="15">15 miles</option>
                                        <option value="20">20 miles</option>
                                        <option value="25">25 miles</option>
                                        <option value="30">30 miles</option>
                                        <option value="35">35 miles</option>
                                        <option value="40">40 miles</option>
                                        <option value="45">45 miles</option>
                                        <option value="50">50 miles</option>
                                        <option value="55">55 miles</option>
                                        <option value="60">60 miles</option>
                                        <option value="65">65 miles</option>
                                        <option value="70">70 miles</option>
                                        <option value="75">75 miles</option>
                                        <option value="80">80 miles</option>
                                        <option value="85">85 miles</option>
                                        <option value="90">90 miles</option>
                                        <option value="95">95 miles</option>
                                        <option value="100">100 miles</option>
                                    </select>
                                </div>
                                <div class="new-sign-up-text pb-3">This will determine which leads we send you. Later you can create your custom working area on a map.</div>
                                <div class="row mx-0">
                                    <div class="col-md-8 p-0">
                                        <div class="btn-div-general pt-2 text-center">
                                            <a class="f-button-neutral-3 w-button continue_btn_3">Continue</a>
                                        </div>
                                    </div>
                                    <div class="col-md-4 p-0">
                                        <div class="btn-div-general pt-3 text-center mr-0 mr-md-1 mr-lg-1">
                                            <a class="back-btn btn-block text-center px-2 py-2 text-decoration-none font-weight-bold rounded back_btn_3 "><i class="fa-solid fa-arrow-left"></i> Back</a>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sign-up-four-section py-5">
                <div class="container">
                    <div class="row mx-auto justify-content-center">
                        <div class="col-md-12">
                            <div class="new-sign-up-steps">Step 4 of 5</div>
                            <div class="new-sign-up-heading h2 py-2">Introduce yourself to customers</div>
                            <div class="new-sign-up-text pb-3">Share an overview of your business, describing the usual range of services you provide and the factors that set you apart from other tradespeople. Feel free to edit and refine this description as needed.</div>
                            <div class="form">
                                <div class="form-group pt-2">
                                    <textarea class="form-control" id="note" rows="5"></textarea>
                                </div>

                                <div class="form-group mb-0">
                                    <?php
                                    if(isset($_GET['ref_code'])){
                                        ?>
                                        <label for="from_referral_code">Referral code used: <span><?=isset($_GET['ref_code']) ? $_GET['ref_code'] : "" ?></span> </label>

                                        <?php
                                    }else{
                                        ?>
                                        <label for="from_referral_code">Referral code (optional): </label>

                                        <?php
                                    }
                                    ?>
                                </div>
                                <input type="<?=isset($_GET['ref_code']) ? "hidden" : "text" ?>" class="f-field-input-2 w-input" value="<?=isset($_GET['ref_code']) ? $_GET['ref_code'] : "" ?>" id="from_referral_code" placeholder="(e.g 8u8mH9)">


                                <div class="row mx-0 mt-3">
                                    <div class="col-md-8 p-0">
                                        <div class="btn-div-general pt-2 text-center">
                                            <a class="f-button-neutral-3 w-button continue_btn_4"  >Continue</a>
                                        </div>
                                    </div>
                                    <div class="col-md-4 p-0">
                                        <div class="btn-div-general pt-3 text-center mr-0 mr-md-1 mr-lg-1">
                                            <a class="back-btn btn-block text-center px-2 py-2 text-decoration-none font-weight-bold rounded back_btn_4" ><i class="fa-solid fa-arrow-left"></i> Back</a>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sign-up-five-section py-5">
                <div class="container">
                    <div class="row mx-auto justify-content-center">
                        <div class="col-md-12">
                            <div class="new-sign-up-steps">Step 5 of 5</div>
                            <div class="new-sign-up-heading h2 py-2">Set up your credit or debit card</div>

                            <div class="form">
                                <!--<div class="per-month-charges-wrapper mb-2">-->
                                <!--    <div class="per-month-charges p-2"><span class="currencysymbol">£</span><span class="set_amount1"><?=$settings[0]['subscription_price']?></span> / per month</div>-->
                                <!--</div>-->
                                
                                
                                <div class="col-6" style="display:none;">
                                    <!-- <lable for="plans">
                                        Subscription:
                                    </lable>&nbsp&nbsp  
                                    <select class="form-select" name="plans" id="plans" >
                                        <option id="mm" value="<?= $prices['monthly']; ?>" >MONTHLY</option>
                                        <option id="yy" value="<?= $prices['yearly']; ?>" selected>YEARLY</option>
                                    </select> -->
                                    <input type="hidden" value="<?= $prices['yearly']; ?>" id="plans">
                                </div>
                
                
                            <style>
                            .choose_plan{
                                    width: 45px;
                                    border: none;
                                    line-height: 0;
                                    padding: 0;
                                }
                                .choose_plan_dec{
                                    width: 45px;
                                    border: none;
                                    line-height: 0;
                                    padding: 0;
                }
                                .row.my_design {
                                    border: 0px solid gray;
                                    padding: 0;

                                    border-radius: 9px !important;
                                    margin: 0;
                                }
                                .my6 {
                                    border: 1px solid #e5e5e5;
                                    margin-left: 0;
                                    background: #fff;

                                    max-width: 500px;
                                    width: 100%;
                                    padding: 25px;
                                    border-radius: 6px !important;
                                    margin-bottom: 30px;
                                    box-shadow: 0 2px 7px 0 rgba(20, 20, 43, 0.06);
                                }


                                .my6 h5 {
                                    margin-bottom: 16px;
                                    font-weight: 700;
                                }
                                .outer {
                                    border: 1px solid #e5e5e5;
                                    margin: 8px 0 !important;
                                    position: relative;
                                    padding: 10px;
                                    display: flex;
                                    gap: 12px;
                                    min-height: 63px;
                                    transition: border-color 0.5s ease;
                                    border-radius: 4px;
                                }
                                .outer:hover {
                                    border-color: #ccc;
                                }
                                .outer input {
                                    cursor: pointer;
                                    width: 19px;
                                    position: absolute;
                                    left: -9999px;
                                }
                                input[type='radio'].form-check-input{
                                  opacity: 0;
                                }
                                [type="radio"]:checked + label:before, [type="radio"]:not(:checked) + label:before {
                                    content: '';
                                    position: absolute;
                                    left: 0;
                                    top: 50%;
                                    width: 18px;
                                    height: 18px;
                                    border: 1px solid currentColor;
                                    border-radius: 100%;
                                    background: #fff;
                                    transform: translateY(-50%);
                                }
                                [type="radio"]:checked + label:before {
                                    border-color: goldenrod;
                                }
                                [type="radio"]:checked + label:after, [type="radio"]:not(:checked) + label:after {
                                    content: '';
                                    width: 10px;
                                    height: 10px;
                                    background: goldenrod;
                                    position: absolute;
                                    top: 50%;
                                    left: 4px;
                                    border-radius: 100%;
                                    -webkit-transition: all 0.2s ease;
                                    transition: all 0.2s ease;
                                    transform: translateY(-50%);
                                }
                                [type="radio"]:not(:checked) + label:after {
                                    opacity: 0;
                                    -webkit-transform: scale(0);
                                    transform: scale(0);
                                }
                                [type="radio"]:checked + label:after {
                                    opacity: 1;
                                }
                                .outer label {
                                    display: flex;
                                    justify-content: space-between;
                                    width: 100%;
                                    align-items: center;
                                    margin-bottom: 0;
                                    text-transform: capitalize;
                                    cursor: pointer;
                                    position: relative;
                                    padding-left: 25px;
                                }
                                .outer label .show {
                                    text-align: right;
                                    font-size: 14px;
                                }
                                .period {
                                    font-size: 18px;
                                    font-weight: 600;
                                }
                                .outer label .show .text-muted {
                                    font-size: 85%;
                                }
                                .line {
                                    border-bottom: 1px solid black;
                                    barder-radius: 0px !important;
                                    border-radius: 0px !important;
                                    padding-bottom: 17px;
                                }
                                .sign-up-perks {
                                    padding-top: 16px;
                                    margin-bottom: 16px;
                                }

                                .sign-up-perks h5 {
                                    margin-bottom: 10px;
                                }

                                .sign-up-perks ul {
                                    list-style: none;
                                    padding-left: 0;
                                    margin-bottom: 10px;
                                }

                                .sign-up-perks ul li {
                                    position: relative;
                                    padding-left: 20px;
                                }

                                .sign-up-perks ul li:before {
                                    position: absolute;
                                    content: "\f00c";
                                    font-family: "Font Awesome 6 free";
                                    left: 0;
                                    font-weight: 700;
                                    color: goldenrod;
                                }

                                .brix---section-position-relative {

                                    padding-top: 120px;
                                    padding-bottom: 120px;

                                }
                                @media(max-width:767.98px){
                                    .my6 {

                                        padding: 16px;
                                        margin-bottom: 20px;

                                    }
                                    .brix---section-position-relative {
                                        padding-top: 20px;
                                        padding-bottom: 35px;

                                    }
                                    
                                }
                            </style>
                            <div class="row my_design">
                    
                                <div class="my6">
                                    <h5> Your Plan </h5>

                                    <div class="outer">
                                        <input type="radio" id="css" name="plan" onchange="planchanger(this.value)" value="yearly" checked>
                                        <label for="css">
                                            <div style="display: flex;flex-wrap: wrap;align-items: center;gap: 6px;">
                                                <span class="period">Annual</span> 
                                                <button style="background: #24aa3c;color: #fff;font-weight: 600;font-size: 13px;">SAVE 50%</button>
                                            </div>
                                            <div class="select-annual" style="display: flex;flex-wrap: wrap;align-items: center;gap: 6px; width:160px;justify-content:right;min-width: 185px;text-align: right;">
                                                <span class="show"><span class="monthly_y"><?= $currencysymbol.$monthlyonyearly;  ?>/month</span></span><br>
                                                <span class="text-muted">(<span class="yearly"><?= $currencysymbol.$yearlyprice;  ?> billed annually </span> )</span>
                                            </div>
                                        </label>
                                    </div>


                                    <div class="outer">
                                        <input type="radio" id="monthly" name="plan" value="monthly" onchange="planchanger(this.value)" >
                                        <label for="monthly"><span class="period">Monthly</span><span class="show"><span class="monthly"><?= $currencysymbol.$monthlyprice;  ?>/month</span></span></label>
                                    </div>

                                    <div class="outer">
                                        <input type="radio" id="pro_yearly" name="plan" onchange="planchanger(this.value)" value="pro_yearly">
                                        <label for="pro_yearly">
                                            <div style="display: flex;flex-wrap: wrap;align-items: center;gap: 6px;">
                                                <span class="period">Buildela Pro Membership Annual</span> 
                                                <button style="background: #24aa3c;color: #fff;font-weight: 600;font-size: 13px;">SAVE 8%</button>
                                            </div>
                                            <div class="select-annual" style="display: flex;flex-wrap: wrap;align-items: center;gap: 6px; width:160px;justify-content:right;min-width: 185px;text-align: right;">
                                                <span class="show"><span class="monthly_y"><?= $currencysymbol.$proMembershipMonthlyFoYearly;  ?>/month</span></span><br>
                                                <span class="text-muted">(<span class="yearly"><?= $currencysymbol.$proYearlyPrice;  ?> billed annually </span> )</span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="outer">
                                        <input type="radio" id="pro_monthly" name="plan" onchange="planchanger(this.value)" value="pro_monthly">
                                        <label for="pro_monthly"><span class="period">Buildela Pro Membership Monthly</span><span class="show"><span class="monthly"><?= $currencysymbol.$proMonthlyPrice;  ?>/month</span></span></label>
                                    </div>
                                </div>
                                
                                
                                <div class="my6">                                    
                                    <h5> Payment Method </h5>                                    
                                    <?php if($user[0]['subscription_status']==0){ ?>

                                        <form id="payment-form">
                                            <div class="row mx-0">
                                                <div id="card-element" class="form-control" style="padding-top: 8px;">
                                                    <div id="card-errors" role="alert"></div>
                                                </div>
                                                <div class="mt-4 w-100">
                                                    <h5 class="line"> Order Summary </h5>
                                                    <p class="d-flex justify-content-between"> Total <span id="cost_now"> <?= $currencysymbol.$yearlyprice;  ?></span></p>
                                                    <p class="d-flex justify-content-between referral-dis refitem">- Referreral Discount <span id="ref_dis"></span></p>
                                                    <h5 class="line refitem"></h5>
                                                    <?php $referaldiscount = ((int) $yearlyprice - (int) $referralyearly); ?>
                                                    <p class="d-flex justify-content-between refitem" style="font-weight: bold;"> Total billed now <span id="reftotal"> <?= $currencysymbol.$referaldiscount;  ?></span></p>
                                                </div>
                                                <div class="btn-div-general pt-3 text-center w-100 paymentbtns">
                                                    <a class="back-btn btn-block text-center px-2 py-2 text-decoration-none font-weight-bold rounded" id="payment_back"><i class="fa-solid fa-arrow-left"></i> Back</a>
                                                    <button role="button" id="payment_btn" type="submit" class="f-button-neutral-3 w-button">Start Membership</button> 
                                                </div>
                                                <div class="d-flex justify-content-center gap-2 my-3 align-items-center w-100"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="shield-check" class="svg-inline--fa fa-shield-check " role="img" width="16px" height="16px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M466.5 83.71l-192-80c-4.875-2.031-13.16-3.703-18.44-3.703c-5.312 0-13.55 1.672-18.46 3.703L45.61 83.71C27.7 91.1 16 108.6 16 127.1C16 385.2 205.2 512 255.9 512C307.1 512 496 383.8 496 127.1C496 108.6 484.3 91.1 466.5 83.71zM352 200c0 5.531-1.901 11.09-5.781 15.62l-96 112C243.5 335.5 234.6 335.1 232 335.1c-6.344 0-12.47-2.531-16.97-7.031l-48-48C162.3 276.3 160 270.1 160 263.1c0-12.79 10.3-24 24-24c6.141 0 12.28 2.344 16.97 7.031l29.69 29.69l79.13-92.34c4.759-5.532 11.48-8.362 18.24-8.362C346.4 176 352 192.6 352 200z"></path></svg><div>Safe &amp; secure payment</div></div>
                                                
                                                <div class="border-bottom sign-up-perks">
                                                    <h5>Member Perks:</h5>
                                                    <ul>
                                                        <li>Win Unlimited Amount of Leads</li>
                                                        <li>Exclusive Savings on Top Brands</li>
                                                        <li>Amazing Monthly & Yearly Giveaways</li>
                                                        <li>No Shortlisting Fees</li>
                                                        <li>Access to our Members Only Magazine</li>
                                                        <li>Dedicated Support for Members</li>
                                                    </ul>
                                                    <p class="small text-muted">*Up to 5 trades per account</p>
                                                </div>
                                                <div class="order-summary-information">
                                                    <p class="text-muted">
                                                        By clicking the “Start Paid Membership” button below, you confirm that you are at least 16 years of age, have 
                                                        reviewed and accepted our Terms & Conditions, and acknowledged the Privacy Policy. Your membership will commence 
                                                        immediately, and during the initial 2-week cooling-off period, you have the option to cancel and receive a refund 
                                                        for annual or monthly subscriptions. Following this period, Buildela will automatically continue your membership 
                                                        and charge the applicable membership fee (currently <span class="choosen_plan">£109.99/month</span>) to your chosen payment method on a recurring 
                                                        basis, every 30 days for monthly subscriptions and every 365 days for annual subscriptions. You retain the right 
                                                        to cancel your membership at any time to prevent future charges.
                                                    </p>
                                                </div>
                                            </div>
                                        </form>
                                        <?php
                                    }else{
                                        ?>
                                        <div class="">

                                            <p class="brix---paragraph-default-2">Status:<span class="sub_status"> </span></p>
                                            <p class="brix---paragraph-default-2">Type: <span class="sub_type" ><?=$user[0]['subscription_type']?></span></p>
                                            <p class="brix---paragraph-default-2">End Date: <span class="sub_date" >00/00/0000</span></p>
                                            <p class="brix---paragraph-default-card">**** **** ****</span></p>
                                            <?php
                                            if(($user[0]['subscription_cancel']==0) && ($user[0]['subscription_status']==1) ){
                                                ?>
                                                <div class="btn-div-general pt-3 text-center cancel_button">
                                                    <button role="button" id="cancel_subscription" type="button" class="btn-bg-general btn-block text-white text-center px-5 py-2 text-decoration-none font-weight-bold rounded " >Cancel Subscription</button>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <div class="btn-div-general pt-3 text-center reactivete ">
                                                <button role="button" id="reactivate_subscription" type="button" class="btn-bg-general btn-block text-white text-center px-5 py-2 text-decoration-none font-weight-bold rounded " >Reactivate Subscription</button>
                                            </div>

                                        </div>

                                        <?php
                                    }
                                    ?>
                                    
                                    
                                    
                                </div>                    
                            </div> 
                            </div>
                        </div>
                    </div>
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
                    <p class="my-2 ">We send a verification code on your mobile number</p>
                    <input value="" type="hidden" id="verification_phone">
                    <div class="form-group">
                        <label for="verification_code">Enter verification code:</label>
                        <input type="text" value="" class="f-field-input-2 w-input" required id="verification_code" >
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

<script type="text/javascript">

    var counter=0;
    let referral = false;
    let selector = false;

    let ref_dis_monthly = '<?= $referralmonthly; ?>';
    let ref_dis_yearly = '<?= $referralyearly; ?>';
    let ref_monthly = '<?= $prices['referral_first_month_price']; ?>';
    let ref_yearly = '<?= $prices['referral_first_year_price']; ?>';

    const proMonthlyPrice     = parseFloat(removeNonDigits("<?= $proMonthlyPrice ?>")),
          proYearlyPrice     = parseFloat(removeNonDigits("<?= $proYearlyPrice ?>")),
          monthlyprice        = parseFloat(removeNonDigits("<?= $monthlyprice ?>")),
          monthlyonyearly     = parseFloat(removeNonDigits("<?= $monthlyonyearly ?>")),
          yearlyprice         = parseFloat(removeNonDigits("<?= $yearlyprice ?>")),
          referralmonthly     = parseFloat(removeNonDigits("<?= $referralmonthly ?>")),
          referralyearly      = parseFloat(removeNonDigits("<?= $referralyearly ?>"));

    let referaldiscount;


    $(".continue_btn_1").click(function (event) {

        event.preventDefault();
        let pattern = /^(((\+44\s?\d{4}|\(?0\d{4}\)?)\s?\d{3}\s?\d{3})|((\+44\s?\d{3}|\(?0\d{3}\)?)\s?\d{3}\s?\d{4})|((\+44\s?\d{2}|\(?0\d{2}\)?)\s?\d{4}\s?\d{4}))(\s?\#(\d{4}|\d{3}))?$/;
        var dbs=$( "#dbs_option option:selected" ).val();

        if($("#email").val()!=''){

            $('.continue_btn_1').addClass('disabled');
            $('.continue_btn_1').html('Please wait...');

            // debugger;
            $.ajax({
                url: "serverside/post.php",
                type: "POST",
                data: {
                    func: 44,
                    email:$('#email').val(),
                },
                success: function (data) {

                    if (data == "true") {
                        swal("Email exist!", "Email is already exist, Kindly login", "info").then((value) => {
                            window.location.href = "login";
                        });
                    }
                    $('.continue_btn_1').removeClass('disabled');
                    $('.continue_btn_1').html('Continue');
                }

            });
        }

        let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        if (!emailPattern.test($("#email").val())) {
            swal("Invalid email format", "", "info");
            return;
        }

        if (!pattern.test($("#phone").val())) {
            swal("Phone format not match", "", "info");
            return;

        }
        $("#phone").change(function (e){
            e.preventDefault();
            $("#isphoneverifiy").val(0);
            $("#verification_phone").val($('#phone').val());
        });
        if($("#phone").val()!='' && $("#isphoneverifiy").val()==0){

            $('.continue_btn_1').addClass('disabled');
            $('.continue_btn_1').html('Please wait...');

            $.ajax({
                url: "serverside/post.php",
                type: "POST",
                // async: false,
                data: {
                    func: 96,
                    phone:$('#phone').val(),
                },
                success: function (data) {

                    
                    data = JSON.parse(data);

                    $("#verification_phone").val($('#phone').val());
                    
                    if (data.success == "yes") {

                        swal("Success", "We send phone verification code on your phone number", "success").then((value) => {
                            $("#verifiymodal").modal('show');
                            $("#isphoneverifiy").val(0);
                        });

                    }else if(data.success == "no"){
                        swal("Failed","Failed to send verification code, please click resend button.","error")
                    }
                    else if(data.exist == "yes"){

                        $("#isphoneverifiy").val(1);
                        if(dbs==1){
                            var len = document.getElementById('dbs').files.length;
                            if(len<=0){

                                swal("DBS Certificate is missing", "", "info").then((result) => {

                                });

                                return;
                            }

                        }
                        if ( $("#pass1").val()=="" || $("#pass1").val() != $("#pass2").val()) {
                            swal("Password Not Match", "Your password and confirm password not match!", "info");
                            return;
                        }
                        if(!$('#builder2').is(":checked")){

                            swal("Agreement not accepted", "Kindly accept terms and conditions first, try again!", "info");
                            return;
                        }
                        if($("#fname").val()==''||$("#phone").val()==''||$("#pass1").val()==''||$("#email").val()==''){

                            swal("Missing Detail", "Kindly fill the input fields", "info");
                            return;
                        }

                        if($("#isphoneverifiy").val()==0){
                            swal("Alert", "Your phone is not verified, verify it to continue ", "error").then((value) => {
                                $("#verifiymodal").modal('show');
                            });
                        } else {

                            $(".sign-up-first-section").hide();
                            $(".sign-up-second-section").show();
                            $(".sign-up-third-section").hide();
                            $(".sign-up-four-section").hide();
                            $(".sign-up-five-section").hide();
                            $("#trading_name").focus();
                        }
                    }
                    $('.continue_btn_1').removeClass('disabled');
                    $('.continue_btn_1').html('Continue');
                },
                error: function(xhr, status, error) {
                    // Handle the error response from the server
                    console.error('Error:', error);
                }
            });
        }//main if number == 0
        else {

            $("#isphoneverifiy").val(1);
            if(dbs==1){
                var len = document.getElementById('dbs').files.length;
                if(len<=0){

                    swal("DBS Certificate is missing", "", "info").then((result) => {

                    });

                    return;
                }

            }
            if ( $("#pass1").val()=="" || $("#pass1").val() != $("#pass2").val()) {
                swal("Password Not Match", "Your password and confirm password not match!", "info");
                return;
            }
            if(!$('#builder2').is(":checked")){

                swal("Agreement not accepted", "Kindly accept terms and conditions first, try again!", "info");
                return;
            }
            if($("#fname").val()==''||$("#phone").val()==''||$("#pass1").val()==''||$("#email").val()==''){

                swal("Missing Detail", "Kindly fill the input fields", "info");
                return;
            }

            if($("#isphoneverifiy").val()==0){
                swal("Alert", "Your phone is not verified, verify it to continue ", "error").then((value) => {
                    $("#verifiymodal").modal('show');
                });
            } else {

                $(".sign-up-first-section").hide();
                $(".sign-up-second-section").show();
                $(".sign-up-third-section").hide();
                $(".sign-up-four-section").hide();
                $(".sign-up-five-section").hide();
            }
        }
        // alert('asd');

    });



    $("#verifiy_btn").click(function (e){
        e.preventDefault()
        $("#verifiy_btn").attr('disabled', true);
        $("#verifiy_btn").html("Please wait...");

        $('.continue_btn_1').addClass('disabled');
        $('.continue_btn_1').html('Please wait...');

        $.ajax({
            url: "serverside/post.php",
            type: "POST",
            data: {
                func: 97,
                verification_phone:$('#verification_phone').val(),
                verification_code:$('#verification_code').val(),
            },
            success: function (data) {

                $("#verifiymodal").modal('hide');

                if (data.trim() == "true") {
                    $("#isphoneverifiy").val(1);
                    swal("Success", "Your phone is verified successfully", "success").then((value) => {

                    });
                }else{
                    $("#isphoneverifiy").val(0);
                    swal("Failed","Failed to verify phone","error")






                }
                $("#verifiy_btn").attr('disabled', false);
                $("#verifiy_btn").html("Verify");

                $('.continue_btn_1').removeClass('disabled');
                $('.continue_btn_1').html('Continue');
            }
        });

    });




    function setDBS() {

        var dbs=$( "#dbs_option option:selected" ).val();
        if(dbs==1){

            $('#dbs_div').show();

        }else{
            $('#dbs_div').hide();

        }

    }//setDBS


    $(".continue_btn_2").click(function(e){
        if($("#trading_name").val()==''){
            swal("Alert", "Please enter your trading name", "error").then((value) => {

            });
        } else {


            e.preventDefault();
            $(".sign-up-first-section").hide();
            $(".sign-up-second-section").hide();
            $(".sign-up-third-section").show();
            $(".sign-up-four-section").hide();
            $(".sign-up-five-section").hide();
        }


    });
    $(".continue_btn_3").click(function(e){
        e.preventDefault();
        let post_code=$('#post_code').val();
        if(post_code==''){
            swal("Please enter post code","","info");
            $("#post_code").focus();
            return;
        }
        $(".continue_btn_3").attr("disabled", true);
        $(".continue_btn_3").html("Please wait...");

        // just check UK post Code is valid or not
        if($("#country option:selected").val()=="UK"){
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
                    if (data.trim() != 200) {
                        swal("Invalid postcode", "please enter a valid postcode!", "info");
                        $("#post_code").val('');
                        $("#post_code").focus();
                        return;
                    } else {
                        $(".sign-up-first-section").hide();
                        $(".sign-up-second-section").hide();
                        $(".sign-up-third-section").hide();
                        $(".sign-up-four-section").show();
                        $(".sign-up-five-section").hide();
                    }//else
                }//success
            });//ajax
        }else {
            var ajax_data = new FormData();
            ajax_data.append("func", '52.1');
            ajax_data.append('post_code',post_code );
            $.ajax({
                url: "serverside/post.php",
                type: "POST",
                processData: false,
                contentType: false,
                data:ajax_data,
                success: function (data) {

                    if (data.trim() != 'OK') {
                        swal("Invalid postcode", "please enter a valid postcode!", "info");
                        $("#post_code").val('');
                        $("#post_code").focus();
                        return;
                    } else {
                        $(".sign-up-first-section").hide();
                        $(".sign-up-second-section").hide();
                        $(".sign-up-third-section").hide();
                        $(".sign-up-four-section").show();
                        $(".sign-up-five-section").hide();
                    }//else
                }//success
            });//ajax
        }


        $(".continue_btn_3").attr("disabled", false);
        $(".continue_btn_3").html("Continue");

    });
    $(".continue_btn_4").click(function(e){
        e.preventDefault();
        let msign ='<?=$currencysymbol?>';
        if($("#from_referral_code").val()!=''){
            $.ajax({
                url: "serverside/post.php",
                type: "POST",
                data: {
                    func: 65,
                    from_referral_code:$('#from_referral_code').val(),
                },
                success: function (data) {
                    if (data.trim() == "false") {
                        swal("Invalid referral Code!", "Referral code can't be found in the system.", "info").then((value) => {
                            $("#from_referral_code").val('');
                            $("#from_referral_code").focus();
                            return;
                        });
                    }else{
                        let discount = (yearlyprice - referralyearly);

                        payamount=parseFloat($(".set_amount1").text());
                        if(counter == 0 ){
                            $(".set_amount1").text(payamount);
                            counter++;

                        }

                        referral = true;
                        $('.choosen_plan').text('<?=$referralyearly; ?>');
                        $('.refitem').removeClass('d-none').addClass('d-flex');
                        $(".f-h5-heading").html('You are referred by <span id="reffred_by">'+data.trim()+'</span>');

                        $('#cost_now').text(msign+fixCommas(yearlyprice));
                        $('#ref_dis').text(msign+fixCommas(discount));
                        $('#reftotal').text(msign+fixCommas(referralyearly));



                        $(".sign-up-first-section").hide();
                        $(".sign-up-second-section").hide();
                        $(".sign-up-third-section").hide();
                        $(".sign-up-four-section").hide();
                        $(".sign-up-five-section").show();

                    }
                }
            });
        }else {
            counter=0;

            $(".set_amount1").text('<?=$settings[0]['subscription_price']?>');

            $("#refferral_text").show();
            $(".sign-up-first-section").hide();
            $(".sign-up-second-section").hide();
            $(".sign-up-third-section").hide();
            $(".sign-up-four-section").hide();
            $(".sign-up-five-section").show();


            referral = false;
            $('.refitem').removeClass('d-flex').addClass('d-none');
            $(".f-h5-heading").html('Register as a Pro');

            $('#cost_now').text(msign+fixCommas(yearlyprice));
            $('#reftotal').text(msign+fixCommas(referralyearly));
        }


    });
    $(".back_btn_2").click(function(e){
        e.preventDefault();
        $(".sign-up-first-section").show();
        $(".sign-up-second-section").hide();
        $(".sign-up-third-section").hide();
        $(".sign-up-four-section").hide();
        $(".sign-up-five-section").hide();
    });
    $(".back_btn_3").click(function(e){
        e.preventDefault();
        $(".sign-up-first-section").hide();
        $(".sign-up-second-section").show();
        $(".sign-up-third-section").hide();
        $(".sign-up-four-section").hide();
        $(".sign-up-five-section").hide();

    });
    $(".back_btn_4").click(function(e){
        e.preventDefault();
        $(".sign-up-first-section").hide();
        $(".sign-up-second-section").hide();
        $(".sign-up-third-section").show();
        $(".sign-up-four-section").hide();
        $(".sign-up-five-section").hide();

    });
    $(".back_btn_5").click(function(e){
        e.preventDefault();
        $(".sign-up-first-section").hide();
        $(".sign-up-second-section").hide();
        $(".sign-up-third-section").hide();
        $(".sign-up-four-section").show();
        $(".sign-up-five-section").hide();

    });
    $('#payment_back').click(function(e){
        e.preventDefault();
        $('.f-h5-heading').text('Register as a pro');
        $(".sign-up-first-section").hide();
        $(".sign-up-second-section").hide();
        $(".sign-up-third-section").hide();
        $(".sign-up-four-section").show();
        $(".sign-up-five-section").hide();
    });
    $(document).ready( function(){
        $('#dbs_div').hide();
        $('.sign-up-first-section').show();
        $('.sign-up-second-section').hide();
        $('.sign-up-third-section').hide();
        $('.sign-up-four-section').hide();
        $('.sign-up-five-section').hide();
        $("#refferral_text").hide();

        
    });
    

    function planchanger(slector){

        let cr_sym='<?=$currencysymbol?>';
        let plan; 
        if(slector=='monthly'){

            if(!referral){
                $('#cost_now').html(cr_sym+decimalDigits(monthlyprice,2));
            }else {
                let ydiscount = (monthlyprice - referralmonthly);
                $('#cost_now').html(cr_sym+decimalDigits(monthlyprice,2));
                $('#ref_dis').text(cr_sym+decimalDigits(ydiscount,2));
                $('#reftotal').text(cr_sym+decimalDigits(referralmonthly,2));
                
                
            }
            selector = 'monthly';
            $('.choosen_plan').text(cr_sym+monthlyprice+'/month');
            $('#plans').val(<?=$prices['monthly']?>);

        }else if(slector=='pro_monthly') {
            
            if(!referral){
                $('#cost_now').html(cr_sym+decimalDigits(proMonthlyPrice,2));
            }else {
                let ydiscount = (proMonthlyPrice - referralmonthly);
                $('#cost_now').html(cr_sym+decimalDigits(proMonthlyPrice,2));
                $('#ref_dis').text(cr_sym+decimalDigits(ydiscount,2));
                $('#reftotal').text(cr_sym+decimalDigits(referralmonthly,2));
                
                
            }
            selector = 'pro_monthly';
            $('.choosen_plan').text(cr_sym+proMonthlyPrice+'/month');
            $('#plans').val(<?=$prices['pro_monthly']?>);

        } else if(slector=='pro_yearly') {
            
            if(!referral){
                $('#cost_now').html(cr_sym+decimalDigits(proYearlyPrice,2));
            }else {
                let mdiscount = (proYearlyPrice - referralyearly);

                $('#cost_now').html(cr_sym+ decimalDigits(proYearlyPrice,2));
                $('#ref_dis').text(cr_sym+decimalDigits(mdiscount, 2));
                $('#reftotal').text(cr_sym+decimalDigits(referralyearly,2));

            }
            selector = 'pro_yearly';
            $('.choosen_plan').text(cr_sym+proYearlyPrice+'/year');
            $('#plans').val(<?=$prices['pro_yearly']?>);

        } else {
            
            if(!referral){
                $('#cost_now').html(cr_sym+decimalDigits(yearlyprice,2));
            }else {
                let mdiscount = (yearlyprice - referralyearly);

                $('#cost_now').html(cr_sym+ decimalDigits(yearlyprice,2));
                $('#ref_dis').text(cr_sym+decimalDigits(mdiscount, 2));
                $('#reftotal').text(cr_sym+decimalDigits(referralyearly,2));

            }
            selector = 'yearly';
            $('.choosen_plan').text(cr_sym+yearlyprice+'/year');
            $('#plans').val(<?=$prices['yearly']?>);
            
        }

    }

    function removeNonDigits(moneyString) {
        return moneyString.replace(/[^0-9.]/g, '');
    }


    function fixCommas(amount){
        return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function decimalDigits(amount, decimalPlaces) {
        var multiplier = Math.pow(10, decimalPlaces);
        var formattedAmount = (Math.round(amount * multiplier) / multiplier).toFixed(decimalPlaces);
        return formattedAmount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

</script>
<?php 

    $monthly   = $prices['monthly'];
    $monthlyonyearly= $prices['monthly_for_yearly'];
    $yearlyprice    = $prices['yearly'];
    $referralmonthly= $prices['referral_first_month_price'];
    $referralyearly = $prices['referral_first_year_price'];
?>

<script>

    var stripe = Stripe('<?= $stripe_public_key?>');
    let amount = 0;

    if(referral === false) {
        if(selector === 'monthly') amount='<?=$monthly?>';
        else if(selector === 'yearly') amount='<?=$yearlyprice?>';
    } else {
        if(selector === 'monthly') amount='<?=$referralmonthly?>';
        else if(selector === 'yearly') amount='<?=$referralyearly?>';
    }

    function callprice(){
        console.log(stripe);        
        console.log(referral);
        console.log(selector);

        if(selector === 'monthly') amount='<?=$referralmonthly?>';
        else if(selector === 'yearly') amount='<?=$referralyearly?>';
        console.log('Amount: ' + amount);

        // ABC3hi
    }

    $(document).ready( function(){

        $('.continue_btn_1').on('click', function() {
            $('html, body').animate({
                scrollTop: '-=400px'
            }, 'slow');
        });
        $('.continue_btn_3').on('click', function() {
            $('html, body').animate({
                scrollTop: '-=400px'
            }, 'slow');
        });
    });
</script>
<script>
    // Create a Stripe client.
    var stripe = Stripe('<?= $stripe_public_key?>');

    // Create an instance of Elements.
    var elements = stripe.elements();

    // Create an instance of the card Element.
    var card = elements.create('card');

    // Add an instance of the card Element into the `card-element` <div>.
    card.mount('#card-element');
    $(document).ready( function(){
// Handle real-time validation errors from the card Element.
        card.on('change', function(event) {
            if (event.error) {
                $("#card-errors").text(event.error.message);
                $("#payment_btn").hide(); // hide the payment button
            } else {
                $("#card-errors").text('');
                $("#payment_btn").show(); // show the payment button
            }
        });
    });
</script>
<script src="customjs/signup_stripe.js?v=<?=rand(10, 100);?>"></script>


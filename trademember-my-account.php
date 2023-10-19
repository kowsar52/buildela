<?php
include_once "includes/header.php";
include_once "serverside/functions.php";
include_once "serverside/session.php";

$func=new Functions();
$settings=$func->getSettings();
$stripe_public_key = $settings[0]['stripe_public_key'];
$stripe_private_key = $settings[0]['stripe_private_key'];
$func->set_last_seen($_SESSION['user_id']);
// $func->updateSubscriptionStatus($_SESSION['user_id']);
//$func->autoCharge($_SESSION['user_id']);

$prices       = [];
$plansdatabse = $func->getplans();
if ($plansdatabse) foreach($plansdatabse as $key => $value) $prices[$value['type']] = $value['price'];

$userinfo         = $func->getClientlocation($_SERVER['REMOTE_ADDR']);
$usercurrencies   = $func->countryCurrency($userinfo['country']);


if($usercurrencies['currency'] == 'GBP') {

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


if(isset($_SESSION['user_id']) && $_SESSION['user_role']=='jobs_person' ) {
    $user = $func->UserInfo($_SESSION['user_id']);
}else{
    $func->redirect('account-details');
} 


?>
<style>
    div#card-element {
        margin-bottom: 35px;
        margin-top:6px;
        width: 100%;
        border: 1px solid #e5e5e5;
        border-radius: 12px;
        padding: 10px;
    }

    @media (min-width: 320px) and (max-width: 480px) {
        .w-dropdown-link {
            font-size: 12.8px;
            line-height: 19.2px;
        }

        section.footer-dark.wf-section {
            border-radius: 0px!important;
        }
        .brix---section-position-relative.wf-section {
            border-radius: 0px!important;
            margin-bottom: -3px;
        }
    }
    p.brix---paragraph-default-card {
        font-weight: 600;
    }
    span.sub_status {
        text-transform: capitalize;
        padding-left: 4px;
    }

    #reactivate_subscription{
        display:none;
        color: #fff;

    }
    .btn.months-winner-btn {
        background-color: #006bf5;
        color: #fff;
        /* display: inline-block; */
        padding: 7px 15px;
        text-align: center;
        text-decoration: none;
    }
    .months-winner-btn:hover {
        background-color: #187bfb;
        color: #fff;
    }
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
 
    #plans {
        margin-top: -3px;
        margin-bottom: 30px;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<script src="https://js.stripe.com/v3/"></script>
<div class="brix---section-position-relative wf-section">
    <div class="brix---container-default-2 w-container">
        <div class="w-layout-grid brix---grid-contact-v6">
            <div data-w-id="af77becc-6ca5-0842-4029-b2d0864671c3" style="">
                <div class="brix---subtitle"><strong class="bold-text-6">Payment details</strong><br></div>
                <div class="brix---color-neutral-801">
                    <h1 class="brix---heading-h1-size">Account</h1>
                </div>

                <div class="col-6" style="display:none;">
                    <lable for="plans">
                        Subscription:
                    </lable>&nbsp&nbsp  <select class="form-select" name="plans" id="plans" >
                        <option value="19.99" >MONTHLY</option>

                        <option value="119.88" selected>YEARLY</option>

                    </select>

                </div>



                <!--previous-->

                <!--<div class="brix---mg-bottom-40px">-->
                <!--  <div class="brix---color-neutral-802">-->
                <!--    <p class="brix---paragraph-default-2">Price should be <?=$currencysymbol?><?=$settings[0]['subscription_price']-1?> for user coming through link or use referral code(first month) and  <?=$currencysymbol?><?=$settings[0]['subscription_price']?> thereafter.-->

                <!--                      By clicking the “Start Paid Membership” button below, you agree to our Terms of Use and that you are over 16 and acknowledge the Privacy Statement. You agree that your membership will begin immediately, and that you will not be able to withdraw from the contract and receive a refund.-->
                <!--                      Buildela will automatically continue your membership and charge the membership fee (currently <?=$currencysymbol?><?=$settings[0]['subscription_price']?>/month) to your payment method until you cancel. You may cancel at any time to avoid future charges.</p>-->
                <!--  </div>-->
                <!--</div>-->


                <!--my work-->


                <style>
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

                        max-width: 481px;
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
                        div#card-element {
                            margin-bottom: 25px;

                        }
                    }
                    .f-button-neutral-3 {
                        border-radius: 8px;
                    }
                    button#payment_btn {
                        width: 100%;
                    }
                </style>

                <div class="w-form">
                    <div id="" name="wf-form-BRIX---Contact-Form-V6" data-name="BRIX - Contact Form V6" >
                        <div class="w-layout-block">


                            <div class="row my_design">
                                <div class="my6">
                                    <h5> Your Plan </h5>

                                    <div class="outer">
                                        <input type="radio" id="css" name="plan" onchange="myplan(this.value)" value="yearly" checked>
                                        <label for="css"><div style="display: flex;flex-wrap: wrap;align-items: center;gap: 6px;"><span class="period">Annual</span> <button style="background: goldenrod;color: #fff;font-weight: 600;
    font-size: 13px;">SAVE 50%</button></div><span class="show"><?=$currencysymbol.$monthlyonyearly?>/month<br><span class="text-muted">(<?=$currencysymbol?>119.88 billed annually)</span> </span></label>
                                    </div>


                                    <div class="outer">
                                        <input type="radio" id="html" name="plan" value="monthly" onchange="myplan(this.value)" >
                                        <label for="html"><span class="period">Monthly</span><span class="show"><?=$currencysymbol?>19.99/month</span></label>
                                    </div>

                                </div>

                                <div class="my6">
                                    <script>
                                        function myplan(planselector){

                                            if(planselector == 'monthly')
                                            {
                                                $('#plans').val('<?= $monthlyprice ?>');
                                                var cr_sym='<?=$currencysymbol?>';
                                                $('#cost_now').html(cr_sym+'<?= $monthlyprice ?>');
                                                var plan=<?= $monthlyprice ?>;
                                                $('.choose_plan').val(plan);
                                                $('.choose_plan_dec').val(plan-1);
                                            }
                                            else
                                            {
                                                $('#plans').val('<?=$yearlyprice?>');
                                                var cr_sym='<?=$currencysymbol?>';
                                                $('#cost_now').html(cr_sym+'<?=$yearlyprice?>');
                                                var plan=<?=$yearlyprice?>;
                                                $('.choose_plan').val(plan);
                                                $('.choose_plan_dec').val(plan-1);
                                            }
                                        }
                                        
                                    </script>
                                    <h5 class="line"> Payment Method </h5>
                                    <?php
                                    if($user[0]['subscription_status']==0){
                                        ?>
                                        <form id="payment-form">
                                            <div class="row justify-content-center mx-0">
                                                <div id="card-element" class="form-control">
                                                    <div id="card-errors" role="alert"></div>

                                                </div>
                                                <h5 class="line"> Order Summary </h5>
                                                <p class="d-flex justify-content-between"> Total Billed Now <span id="cost_now"> <?=$currencysymbol?>119.88</span></p>
                                                <div class="btn-div-general pt-3 text-center">
                                                    <button role="button" id="payment_btn" type="submit" class="f-button-neutral-3 w-button" >Start paid membership</button>
                                                </div>
                                                <div class="d-flex justify-content-center gap-2 my-3 align-items-center"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="shield-check" class="svg-inline--fa fa-shield-check " role="img" width="16px" height="16px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M466.5 83.71l-192-80c-4.875-2.031-13.16-3.703-18.44-3.703c-5.312 0-13.55 1.672-18.46 3.703L45.61 83.71C27.7 91.1 16 108.6 16 127.1C16 385.2 205.2 512 255.9 512C307.1 512 496 383.8 496 127.1C496 108.6 484.3 91.1 466.5 83.71zM352 200c0 5.531-1.901 11.09-5.781 15.62l-96 112C243.5 335.5 234.6 335.1 232 335.1c-6.344 0-12.47-2.531-16.97-7.031l-48-48C162.3 276.3 160 270.1 160 263.1c0-12.79 10.3-24 24-24c6.141 0 12.28 2.344 16.97 7.031l29.69 29.69l79.13-92.34c4.759-5.532 11.48-8.362 18.24-8.362C346.4 176 352 192.6 352 200z"></path></svg><div>Safe &amp; secure payment</div></div>
                                                
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

                                                    <p class="text-muted">Price should be <?=$currencysymbol?><input type="text" class="choose_plan_dec" name="choose_plan" value="118.88" readonly > for user coming through link or use referral code(first month) and  <?=$currencysymbol?><input type="text" class="choose_plan" name="choose_plan" value="119.88" readonly > thereafter.

                                                        By clicking the “Start Paid Membership” button below, you agree to our Terms of Use and that you are over 16 and acknowledge the Privacy Statement. You agree that your membership will begin immediately, and that you will not be able to withdraw from the contract and receive a refund.
                                                        Buildela will automatically continue your membership and charge the membership fee (currently <?=$currencysymbol?><input type="text" class="choose_plan" name="choose_plan" value="119.88" readonly >/month) to your payment method until you cancel. You may cancel at any time to avoid future charges.</p>

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

                    <img src="images/stripe-badge-transparent.png" loading="lazy" srcset="images/stripe-badge-transparent-p-500.png 500w, images/stripe-badge-transparent-p-800.png 800w, images/stripe-badge-transparent.png 808w" sizes="(max-width: 479px) 100vw, (max-width: 859px) 94vw, (max-width: 991px) 808px, (max-width: 1439px) 47vw, 535px" alt="">
                </div>
            </div>
            <div data-w-id="af77becc-6ca5-0842-4029-b2d0864671ef" style="" class="brix---card-pd-64px---56px">
                <div class="brix---color-neutral-801">
                    <h3 class="brix---heading-h3-size">Win These Amazing Rewards</h3>
                </div>
                <div class="brix---mg-bottom-40px">
                    <div class="brix---color-neutral-802">
                        <p class="brix---paragraph-default-2">Premier league ticket winners and Screwfix voucher winners are announced the 1st of every month. Jet2Holiday Ticket winners are announced annually, in January.</p>
                    </div>
                </div>
                <div class="w-layout-grid brix---grid-1-column-gap-row-24px-2">
                    <a href="mailto:sales@company.com" class="brix---icon-link-wrapper w-inline-block"><img src="images/premier-league-logo-png-transparent.png" sizes="(max-width: 767px) 56px, 100px" width="100" srcset="images/premier-league-logo-png-transparent-p-500.png 500w, images/premier-league-logo-png-transparent-p-800.png 800w, images/premier-league-logo-png-transparent-p-1080.png 1080w, images/premier-league-logo-png-transparent.png 2400w" alt="" class="brix---big-icon-left">
                        <div>
                            <div class="brix---mg-bottom-8px">
                                <div class="brix---color-neutral-801">
                                    <div class="brix---text-200-medium">2 Pairs of Ticket Giveaways</div>
                                </div>
                            </div>
                            <div class="brix---text-200-bold">Per Month</div>
                        </div>
                    </a>
                    <a href="mailto:partners@company.com" class="brix---icon-link-wrapper w-inline-block"><img src="images/Jet2Holidays-Logo.png" width="100" alt="" class="brix---big-icon-left">
                        <div>
                            <div class="brix---mg-bottom-8px">
                                <div class="brix---color-neutral-801">
                                    <div class="brix---text-200-medium">2 All-Inclusive Family Holiday Giveaways</div>
                                </div>
                            </div>
                            <div class="brix---text-200-bold">Per Year</div>
                        </div>
                    </a>
                    <a href="mailto:support@company.com" class="brix---icon-link-wrapper w-inline-block"><img src="images/reward-section-3.png" sizes="(max-width: 767px) 56px, 100px" width="100" srcset="images/reward-section-3-p-500.png 500w, images/reward-section-3.png 523w" alt="" class="brix---big-icon-left">
                        <div>
                            <div class="brix---mg-bottom-8px">
                                <div class="brix---color-neutral-801">
                                    <div class="brix---text-200-medium">3 <?=$currencysymbol?>50 Voucher Giveaways</div>
                                </div>
                            </div>
                            <div class="brix---text-200-bold">Per Month</div>
                        </div>
                    </a>

                    <a href="trademember-reward" class="btn months-winner-btn">This month's winners</a>
                </div>
            </div>
        </div>
    </div>
    <div class="brix---contact-v6-half-bg-right"></div>
</div>



<?php include_once "includes/footer-no-cta.php"?>

<script type="text/javascript">
    var stripe = Stripe('<?= $stripe_public_key?>'); // pass stripe api
    // if(('<?=$user[0]['referral_code_used']?>'==0)&&('<?=$user[0]['from_referral_code']?>'!="")){
    //     var amount='<?= $settings[0]['subscription_price']-1 ?>';
    // }else{
    //     var amount='<?= $settings[0]['subscription_price'] ?>';
    // }
    var amount=$('#plans').val();
    // alert(amount);

</script>
<script src="customjs/stripe.js?v=1.1"></script>
<script>
    // Declare the customer stripe id as a JavaScript variable.
    var cus_stripe_id = "<?=$user[0]['cus_id_stripe']?>";

    function updateCardDetails() {
        $.ajax({
            url: "serverside/post.php",
            type: "POST",
            data: {
                func: 370, // replace this with the actual function code
                cus_stripe_id: cus_stripe_id,
                // include any other necessary data parameters here
            },
            success: function(data) {
                data = JSON.parse(data);

                // Use 'card_last4' instead of 'last4'
                $('.brix---paragraph-default-card').text("Card: **** **** **** " + data.card_last4);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error(textStatus, errorThrown);
            }
        });
    }





    function updatestatus() {
        $.ajax({
            url: "serverside/post.php",
            type: "POST",
            data: {
                func: 372,
                cus_stripe_id: cus_stripe_id,
            },
            success: function(data) {
                data = JSON.parse(data);

                // Normalize the subscription status (to handle any case inconsistencies or white space)
                var normalizedStatus = data.sub_status.toLowerCase().trim();

                // Convert American spelling to UK spelling for display
                var displayStatus = normalizedStatus === 'canceled' ? 'cancelled' : normalizedStatus;

                // Update the text based on the subscription status
                $('.sub_status').text(displayStatus);

                // Hide the button if the subscription status is not 'active'
                if (normalizedStatus !== 'active') {
                    $('#cancel_subscription').hide();
                    $('#reactivate_subscription').show();
                }

                // Helper function to add leading zero
                function pad(value) {
                    return value < 10 ? '0' + value : value;
                }

                // Format the end date as D/M/Y
                var endDate = new Date(data.sub_end_date * 1000); // Convert to milliseconds
                var formattedDate = pad(endDate.getDate()) + '/' + pad(endDate.getMonth() + 1) + '/' + endDate.getFullYear();

                // Update the text of .sub_date element
                $('.sub_date').text(formattedDate);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error(textStatus, errorThrown);
            }
        });
    }

    function reactivateSubscription() {
        // assuming you have user_id stored somewhere
        var user_id = " <?= $_SESSION['user_id']?>";

        $.ajax({
            url: "../serverside/post.php",
            type: "POST",
            data: {
                func: 381,
                user_id: user_id,
            },
            success: function (data) {
                if (data.trim() == "Subscription status updated successfully") {
                    swal({
                        icon: 'success',
                        title: 'Success',
                        text: 'Subscription status updated successfully!',
                    }).then((result) => {
                        location.reload();
                    });
                } else {
                    swal({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Failed to update subscription status!'
                    });
                }
            }
        });
    }

    // Call the function when the page loads
    $(document).ready(function() {

        updatestatus();
        updateCardDetails();
        $('#reactivate_subscription').click(function() {
            reactivateSubscription();
        });
    });


</script>

<script>

    $('#plans').on('change', function() {
        var plan= this.value;
        $('.choose_plan').val(plan);
        $('.choose_plan_dec').val(plan-1);

    });

</script>

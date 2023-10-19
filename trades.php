<?php
$pageTitle = "Join Buildela as a tradesmember";
$pageDescription = "Join & Win an Unlimited Amount of Leads as a tradesmember - For Just £9.99 Per Month  ";

  include_once "includes/header.php";
  include_once "serverside/functions.php";
  
  $userinfo         = $func->getClientlocation($_SERVER['REMOTE_ADDR']);
  $usercurrencies   = $func->countryCurrency($userinfo['country']);


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

 
?>

<style>
.label2.faq.trades {
    font-family: 'Poppins', sans-serif;
}
a.f-button-neutral-2.bl-custom.w-inline-block {
  border-radius: 5px;
}
a.f-button-neutral-2.bl-custom.w-inline-block:hover{
  background-color: #1477F7;
}
.heading-jumbo-small {
  margin-top: 10px;
  margin-bottom: 15px;
  background-image: linear-gradient(135deg, #d10a38, #006bf5);
  color: #006bf5;
}

@media (min-width: 320px) and (max-width: 480px) {
  section.testimonial-slider-small.faqtrades.wf-section {
    margin-bottom: 190px;
    background: #f4f4f4;
  }
  
  .home-content-wrap {
    margin-top: 20px;
    margin-bottom: 110px;
  }
  
  .f-h3-heading {
    font-size: 23px!important;
  }
  
  .f-paragraph-large {
    color: #fff;
    font-size: 18px;
    line-height: 28px;
    margin-bottom: 14px;
}
  .bold-text-2{
    font-size: 27px;
  }
  p.f-paragraph-large.trades {
    padding-top: 5px;
    line-height: 30px;
  }
  
  .f-margin-bottom-49 {
    margin-bottom: 24px;
    margin-top: 13px;
  }
  
  a.f-button-neutral-2.w-button,
  a.button.cc-contact-us.custom-hd.w-inline-block.nwhd.chred {
    border-radius: 6px;
  }
  
  .f-margin-bottom-72 {
    margin-bottom: 30px;
  }
  
  .f-paragraph-regular-2 {
    font-size: 15px;
    line-height: 1.3;
    margin-bottom: 0;
  }
  .f-margin-bottom-25 {
    margin-bottom: 5px;
}
  .f-content-list-item-large {
    margin-bottom: 15px;
  }
  .testimonial-author {
          line-height: 22px;
  }

}




/*NEW*/

.intro-header.blue-styled.trades {
  min-height: 382px;
  margin-bottom: 60px;
}
.intro-header.blue-styled.trades .w-row {
    width: 100%;
    max-width: 1375px;
}
.f-section-common {
  border-radius: 5px;
}

.f-section-large.tradespage {
  padding-top: 20px;
  background-color: #fff;
  box-shadow: none;
  background-color: #f2f7ff;
}

.f-heading-detail-small {
    color: inherit;
    font-size: 14px;
    line-height: 24px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;

}

.f-h3-heading {
  font-size: 30px;
}

.bold-text-2 {
  color: #d10a38;
  font-size: 32px;
}

p.f-paragraph-large.trades {
  padding-top: 5px;
}

.f-section-regular.cta-style {
  background-image: linear-gradient(163deg, #d10a38, #006bf5);
  padding-top: 45px;
  padding-bottom: 45px;
}

.f-badge-filled {
  background-color: #d10a38;
}

.f-pricing-card-outline {
  border-radius: 5px;
}

.f-pricing-card-dark {
  position: relative;
  padding: 40px;
  border: 1px solid transparent;
  border-radius: 5px;
  background-color: #160042;
  color: #fff;
}

a.f-pricing-button,
a.f-button-secondary.w-button,
a.f-button-neutral-2.w-button {
  border-radius: 5px;
  font-size: 20px;
}
a.f-button-secondary.w-button:hover{
  color: #160042;
}
.label2.faq {
  margin-top: 0;
}

.f-section-large {
  position: relative;
  padding: 0 25px 45px;
}

.f-accordian-title-wrapper {
  background-color:#F2F7FF;
}

.testimonial-slider-small.faqtrades {
  margin-top: -70px;
  padding-top: 40px;
}

.testimonial-slider-small {
  position: relative;
  margin: 100px 0 220px;
  padding: 80px 30px;

  border-radius: 10px;

}

.f-paragraph-regular {
  margin-bottom: 0;
  font-size: 16px;
  line-height: 1.8;
  letter-spacing: -0.02em;
  padding-left: 30px;
}

.f-h5-heading {
  margin: 0;
  color: #000;
  font-size: 32px;
  line-height: 1.4;
  letter-spacing: -0.02em;
  padding-left: 30px;
}

a.f-button-neutral-2.w-button {
  border-radius: 5px;
}
a.f-button-neutral-2.w-button:hover{
  background-color: #006bf5;
}
.f-accordian-dropdown.w-dropdown {
    width: 100%;
}

.container-3.w-container.timer {
    margin-bottom: -50px!important;
    margin-top: 60px;
}
span#countdown {
    font-size: 2em!important;
    font-weight: 700;
    text-align: center;
    display: inline-block;
    margin: 15px 0;
    color: #111;
    background: #ededed;
    width: fit-content;
    padding: 13px 15px;
    border-radius: 5px;
}

@media(max-width: 480px){
    span#countdown{
        font-size: 1.5em!important;
    }
    .f-heading-detail-small{
      line-height: 20px;
      font-size: 14px;
      margin-bottom: 10px;
    }
    p.f-paragraph-large.trades{
      margin-bottom: 15px;
    }
    .f-section-large.tradespage.mainsub {
    padding: 20px 15px;
}
.f-button-neutral-2.bl-custom{
  width: 100%;
}
.f-section-regular.cta-style {

    padding-top: 30px;
    padding-bottom: 30px;
}
.f-cta-text-wrapper-center {

    text-align: left;
    padding-left: 15px;
    padding-right: 15px;
}
.f-margin-bottom-48 {

    text-align: left;
    /* padding-left: 15px; */
}
}
span.next-gt-text {
    font-weight: 500;
    font-size: 1.5rem;
    text-transform: capitalize;
}
.timer-sc {
    text-align: center;
    color: #fff;
    margin-bottom: 20px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
.f-sub-heading-small {

    font-size: 19px;

    text-transform: capitalize;
}
.badge-custom {
    border: 2px solid;
    padding: 2px 8px 3px;
    border-radius: 29px;
    font-size: 14px;
    line-height: 0;
}
.month-pack {
    line-height: 1;

}
.f-content-icon-square {

    background-color: transparent;

}
</style>


<body class="body">
  <div class="mainintro wf-section">
    <div class="intro-header blue-styled trades">
      <div class="columns w-row">
        <div class="column-2 w-col w-col-6">
          <div class="heading-jumbo white-text">Meet new customers in your area.</div>
          <div class="paragraph-bigger cc-bigger-white-light n-white trades">Sign up to start growing your business.<br></div>
          <a href="sign-up" class="button-3 trades w-button">Apply Today</a>
        </div>
        <div class="column w-col w-col-6"></div>
      </div>
    </div>
  </div>
  
  <?php
    // Get current date
    $now = new DateTime();
    
    // Get the end of the current month
    $endOfMonth = new DateTime('last day of this month');
    $endOfMonth->setTime(23, 59, 59); // Set time to end of the day

    $interval = $now->diff($endOfMonth);

    // Get total seconds till end of month
    $totalSeconds = ($interval->days * 24 * 60 * 60) + ($interval->h * 60 * 60) + ($interval->i * 60) + $interval->s;
?>



<script>
    $(document).ready(function() {
        var totalSeconds = <?php echo $totalSeconds; ?>;

        function countdown() {
            totalSeconds--;

            var days = Math.floor(totalSeconds / (24 * 60 * 60));
            var hoursLeft = Math.floor((totalSeconds) - (days * 86400));
            var hours = Math.floor(hoursLeft / 3600);
            var minutesLeft = Math.floor((hoursLeft) - (hours * 3600));
            var minutes = Math.floor(minutesLeft / 60);
            var remainingSeconds = totalSeconds % 60;
            if (remainingSeconds < 10) {
                remainingSeconds = "0" + remainingSeconds;
            }

            document.getElementById('countdown').innerHTML = days + "d " + hours + "h " + minutes + "m " + remainingSeconds + "s";
            if (totalSeconds == 0) {
                clearInterval(countdownTimer);
                document.getElementById('countdown').innerHTML = "This month has ended!";
            }
        }
        var countdownTimer = setInterval(countdown, 1000);
    });
</script>
  
  
  <div class="section cc-store-home-wrap">
    
	  <div class="container-3 w-container">
      <div class="f-section-large tradespage mainsub">
        <div class="columns-9 w-row">
          <div class="w-col w-col-7 w-col-tiny-tiny-stack">
            <div class="f-heading-detail-small">Thousands of jobs posted every week, near you.</div>
            <h3 class="f-h3-heading">The most cost effective way to win work</h3>
            <p class="f-paragraph-large trades">Win unlimited leads, for just<strong class="bold-text-2"> <?php echo $currencysymbol."<span>". $monthlyonyearly."</span>"; ?></strong> per month</p>
          </div>
          <div class="column-17 w-col w-col-5 w-col-tiny-tiny-stack">
            <a href="sign-up" class="f-button-neutral-2 bl-custom w-inline-block">
              <div class="text-block-9">Join as a pro</div>
            </a>
          </div>
        </div>
        <div class="f-container-regular"></div>
      </div>
    </div>
	
	
	
		  <!--<div class="container-3 w-container timer">-->
    <!--  <div class="f-section-large tradespage mainsub">-->
    <!--    <div class="columns-9 w-row">-->
    <!--      <div class="w-col w-col-12 w-col-tiny-tiny-stack">-->
		  <!--<div class="timer-sc">-->
		  <!--<span class="next-gt-text">Next giveaway ends in: </span> <span class="count-timer h1" id="countdown">Calculating...</span>-->
    <!--         </div> </div>-->
          
    <!--    </div>-->
    <!--    <div class="f-container-regular"></div>-->
    <!--  </div>-->
    <!--</div>-->
	
	
	
    <div class="container-4 w-container">
      <div class="f-section-regular cta-style">
          <div class="w-col-12 w-col-tiny-tiny-stack timer">
		  <div class="timer-sc">
		  <span class="next-gt-text">Next giveaway ends in: </span> <span class="count-timer h1" id="countdown">Calculating...</span>
             </div> </div>
        <div class="f-container-regular">
          <div class="f-margin-bottom-72">
            <div class="f-cta-text-wrapper-center">
              <div class="f-margin-bottom-49">
                <h2 class="f-h2-heading">Rewards for our Tradespeople</h2>
              </div>
              <div class="f-margin-bottom-48">
                <p class="f-paragraph-large"><strong>2 pairs x premier league</strong>, tickets giveaway <strong class="badge-custom">every month</strong></p>
				<p class="f-paragraph-large"><strong>2 x 5 star, all inclusive</strong>, family holiday giveaways <strong class="badge-custom">every year</strong></p>
				<p class="f-paragraph-large"><strong>4 x £50 ScrewFix</strong>, voucher giveaway <strong class="badge-custom">every month</strong></p></p>
              </div>
              
              <a href="trademember-reward" class="f-button-neutral-2 w-button">This month’s winners</a>
            </div>
          </div>
          <div class="w-layout-grid f-grid-four-columns">
            <div class="f-cta-logo-card"><img src="images/Jet2Holidays-Logo.png" loading="lazy" width="152" alt=""></div>
            <div class="f-cta-logo-card"><img src="images/premier-league-logo-png-transparent.png" loading="lazy" width="152" srcset="images/premier-league-logo-png-transparent-p-500.png 500w, images/premier-league-logo-png-transparent-p-800.png 800w, images/premier-league-logo-png-transparent-p-1080.png 1080w, images/premier-league-logo-png-transparent.png 2400w" sizes="(max-width: 479px) 58.046875px, (max-width: 767px) 19vw, (max-width: 991px) 18vw, 152px" alt="" class="image-12"></div>
            <div class="f-cta-logo-card"><img src="images/reward-section-3.png" loading="lazy" width="152" srcset="images/reward-section-3-p-500.png 500w, images/reward-section-3.png 523w" sizes="(max-width: 479px) 58.046875px, (max-width: 767px) 19vw, (max-width: 991px) 18vw, 152px" alt="" class="image-12"></div>
          </div>
        </div>
      </div>
	  
	  
	     <div class="f-section-large secfeature">
        <div class="w-row">
          <div class="w-col w-col-4">
            <div class="f-content-list-item-large">
              <div class="f-content-icon-square">
              <div class="f-icon-regular-2 w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="#01C857" viewBox="0 0 18 18"><path d="M9,0L6.563,6.095L0,6.539l5.04,4.219l-1.594,6.352L9,13.617l5.555,3.492l-1.594-6.352L18,6.539l-6.563-0.444L9,0z"></path></svg></div>
              </div>
              <div>
                <div class="f-margin-bottom-25">
                  <div class="f-sub-heading-small">No shortlisting fees</div>
                </div>
                <p class="f-paragraph-regular-2">Send more enquiries and explore your options.</p>
              </div>
            </div>
          </div>
          <div class="w-col w-col-4">
            <div class="f-content-list-item-large">
              <div class="f-content-icon-square">
                <div class="f-icon-regular-2 w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="#01C857" viewBox="0 0 18 18"><path d="M9,0L6.563,6.095L0,6.539l5.04,4.219l-1.594,6.352L9,13.617l5.555,3.492l-1.594-6.352L18,6.539l-6.563-0.444L9,0z"></path></svg></div>
              </div>
              <div>
                <div class="f-margin-bottom-25">
                  <div class="f-sub-heading-small">Unlimited amount of jobs</div>
                </div>
                <p class="f-paragraph-regular-2">Increasing the number of potential leads available to you.</p>
              </div>
            </div>
          </div>
          <div class="w-col w-col-4">
            <div class="f-content-list-item-large">
              <div class="f-content-icon-square">
                <div class="f-icon-regular-2 w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="#01C857" viewBox="0 0 18 18"><path d="M9,0L6.563,6.095L0,6.539l5.04,4.219l-1.594,6.352L9,13.617l5.555,3.492l-1.594-6.352L18,6.539l-6.563-0.444L9,0z"></path></svg></div>
              </div>
              <div>
                <div class="f-margin-bottom-25">
                  <div class="f-sub-heading-small">No hidden charges<br></div>
                </div>
                <p class="f-paragraph-regular-2">Have more control and flexibility over your finances.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
	  
	  
	  
    </div>
    <div class="container">
      <div class="home-content-wrap">
        <div class="f-section-large">
          <div class="f-container-small">
            <div class="f-margin-bottom-49">
              <div class="f-pricing-title-wrapper">
                <div class="f-margin-bottom-12 f-text-weight-bold">
                  <div class="f-heading-detail-small">OUR PRICING</div>
                </div>
                <h2 class="f-h2-heading-2 trades">Buildela keeps the money in your hands.</h2>
              </div>
            </div>
            <div data-duration-in="300" data-duration-out="100" data-current="Tab 1" data-easing="ease" class="f-pricing-tab w-tabs">
              <div class="f-pricing-toggle-menu w-tab-menu">
                <a data-w-tab="Tab 2" class="f-pricing-button-toggle w-inline-block w-tab-link w--current">
                  <div>Yearly</div>
                </a>
                <a data-w-tab="Tab 1" class="f-pricing-button-toggle w-inline-block w-tab-link">
                  <div>Monthly</div>
                </a>
                
              </div>
              <div class="w-tab-content">
                <div data-w-tab="Tab 1" class="f-pricing-tab-pane w-tab-pane">
                  <div class="w-layout-grid f-pricing-column-basic">
                    <div id="w-node-_427d6ea8-4c87-7341-314f-210994d2189f-3facb51b" class="f-pricing-card-outline">
                      <div class="f-margin-bottom-16">
                        <h5 class="f-h5-heading-2">Other Sites</h5>
                      </div>
                      <div class="f-margin-bottom-49">
                        <h6 class="f-h6-heading"><?php echo $currencysymbol.$other_monthly; ?>+ <span class="f-pricing-duration">/ Month</span></h6>
                      </div>
                      <div class="w-layout-grid f-pricing-feature-list">
                        <div id="w-node-_427d6ea8-4c87-7341-314f-210994d218a9-3facb51b" class="f-pricing-feature-item">
                          <div class="f-icon-regular-2 w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none">
                              <path d="M12.0002 19.6386C7.78126 19.6386 4.36133 16.2187 4.36133 11.9997C4.36133 7.78077 7.78126 4.36084 12.0002 4.36084C16.2192 4.36084 19.6391 7.78077 19.6391 11.9997C19.6391 16.2187 16.2192 19.6386 12.0002 19.6386ZM11.2386 15.0553L16.6393 9.65383L15.5592 8.57369L11.2386 12.895L9.07758 10.734L7.99744 11.8141L11.2386 15.0553Z" fill="#160042"></path>
                            </svg></div>
                          <div class="f-paragraph-small-2 f-text-color-gray-600">Pay for each lead</div>
                        </div>
                        <div id="w-node-_427d6ea8-4c87-7341-314f-210994d218ad-3facb51b" class="f-pricing-feature-item">
                          <div class="f-icon-regular-2 w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none">
                              <path d="M12.0002 19.6386C7.78126 19.6386 4.36133 16.2187 4.36133 11.9997C4.36133 7.78077 7.78126 4.36084 12.0002 4.36084C16.2192 4.36084 19.6391 7.78077 19.6391 11.9997C19.6391 16.2187 16.2192 19.6386 12.0002 19.6386ZM11.2386 15.0553L16.6393 9.65383L15.5592 8.57369L11.2386 12.895L9.07758 10.734L7.99744 11.8141L11.2386 15.0553Z" fill="#160042"></path>
                            </svg></div>
                          <div class="f-paragraph-small-2 f-text-color-gray-600">Shortlisting fees</div>
                        </div>
                        <div id="w-node-_427d6ea8-4c87-7341-314f-210994d218b1-3facb51b" class="f-pricing-feature-item">
                          <div class="f-icon-regular-2 w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none">
                              <path d="M12.0002 19.6386C7.78126 19.6386 4.36133 16.2187 4.36133 11.9997C4.36133 7.78077 7.78126 4.36084 12.0002 4.36084C16.2192 4.36084 19.6391 7.78077 19.6391 11.9997C19.6391 16.2187 16.2192 19.6386 12.0002 19.6386ZM11.2386 15.0553L16.6393 9.65383L15.5592 8.57369L11.2386 12.895L9.07758 10.734L7.99744 11.8141L11.2386 15.0553Z" fill="#160042"></path>
                            </svg></div>
                          <div class="f-paragraph-small-2 f-text-color-gray-600">High Annual charges </div>
                        </div>
                        <div id="w-node-_427d6ea8-4c87-7341-314f-210994d218b5-3facb51b" class="f-pricing-feature-item">
                          <div class="f-icon-regular-2 w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none">
                              <path d="M12.0002 19.6386C7.78126 19.6386 4.36133 16.2187 4.36133 11.9997C4.36133 7.78077 7.78126 4.36084 12.0002 4.36084C16.2192 4.36084 19.6391 7.78077 19.6391 11.9997C19.6391 16.2187 16.2192 19.6386 12.0002 19.6386ZM11.2386 15.0553L16.6393 9.65383L15.5592 8.57369L11.2386 12.895L9.07758 10.734L7.99744 11.8141L11.2386 15.0553Z" fill="#160042"></path>
                            </svg></div>
                          <div class="f-paragraph-small-2 f-text-color-gray-600">No rewards</div>
                        </div>
                      </div>
                      <div class="f-pricing-line"></div>
                      <a href="sign-up" class="f-button-secondary w-button">Get Started</a>
                    </div>
                    <div id="w-node-_427d6ea8-4c87-7341-314f-210994d218bc-3facb51b" class="f-pricing-card-dark">
                      <div class="f-margin-bottom-16">
                        <h5 class="f-h5-heading-2 f-text-color-white">Buildela</h5>
                      </div>
                      <div class="f-margin-bottom-49">
                        <div class="f-pricing-type-wrapper">
                          <h6 class="f-h6-heading f-text-color-white"><?php echo $currencysymbol.$monthlyprice; ?> <span class="f-pricing-duration">/ Month</span></h6>
                          <div class="f-badge-filled">
                            <div>Popular</div>
                          </div>
                        </div>
                      </div>
                      <div class="w-layout-grid f-pricing-feature-list">
                        <div id="w-node-_427d6ea8-4c87-7341-314f-210994d218ca-3facb51b" class="f-pricing-feature-item">
                          <div class="f-icon-regular-2 w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none">
                              <path d="M12.0002 19.6386C7.78126 19.6386 4.36133 16.2187 4.36133 11.9997C4.36133 7.78077 7.78126 4.36084 12.0002 4.36084C16.2192 4.36084 19.6391 7.78077 19.6391 11.9997C19.6391 16.2187 16.2192 19.6386 12.0002 19.6386ZM11.2386 15.0553L16.6393 9.65383L15.5592 8.57369L11.2386 12.895L9.07758 10.734L7.99744 11.8141L11.2386 15.0553Z" fill="white"></path>
                            </svg></div>
                          <div class="f-paragraph-small-2 f-text-color-gray-400">Unlimited Jobs</div>
                        </div>
                        <div id="w-node-_427d6ea8-4c87-7341-314f-210994d218ce-3facb51b" class="f-pricing-feature-item">
                          <div class="f-icon-regular-2 w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none">
                              <path d="M12.0002 19.6386C7.78126 19.6386 4.36133 16.2187 4.36133 11.9997C4.36133 7.78077 7.78126 4.36084 12.0002 4.36084C16.2192 4.36084 19.6391 7.78077 19.6391 11.9997C19.6391 16.2187 16.2192 19.6386 12.0002 19.6386ZM11.2386 15.0553L16.6393 9.65383L15.5592 8.57369L11.2386 12.895L9.07758 10.734L7.99744 11.8141L11.2386 15.0553Z" fill="white"></path>
                            </svg></div>
                          <div class="f-paragraph-small-2 f-text-color-gray-400">No Shortlisting Fees</div>
                        </div>
                        <div id="w-node-_427d6ea8-4c87-7341-314f-210994d218d2-3facb51b" class="f-pricing-feature-item">
                          <div class="f-icon-regular-2 w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none">
                              <path d="M12.0002 19.6386C7.78126 19.6386 4.36133 16.2187 4.36133 11.9997C4.36133 7.78077 7.78126 4.36084 12.0002 4.36084C16.2192 4.36084 19.6391 7.78077 19.6391 11.9997C19.6391 16.2187 16.2192 19.6386 12.0002 19.6386ZM11.2386 15.0553L16.6393 9.65383L15.5592 8.57369L11.2386 12.895L9.07758 10.734L7.99744 11.8141L11.2386 15.0553Z" fill="white"></path>
                            </svg></div>
                          <div class="f-paragraph-small-2 f-text-color-gray-400">No Hidden Charges</div>
                        </div>
                        <div id="w-node-_427d6ea8-4c87-7341-314f-210994d218d6-3facb51b" class="f-pricing-feature-item">
                          <div class="f-icon-regular-2 w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none">
                              <path d="M12.0002 19.6386C7.78126 19.6386 4.36133 16.2187 4.36133 11.9997C4.36133 7.78077 7.78126 4.36084 12.0002 4.36084C16.2192 4.36084 19.6391 7.78077 19.6391 11.9997C19.6391 16.2187 16.2192 19.6386 12.0002 19.6386ZM11.2386 15.0553L16.6393 9.65383L15.5592 8.57369L11.2386 12.895L9.07758 10.734L7.99744 11.8141L11.2386 15.0553Z" fill="white"></path>
                            </svg></div>
                          <div class="f-paragraph-small-2 f-text-color-gray-400">Great Rewards</div>
                        </div>
                      </div>
                      <div class="f-pricing-line-dark"></div>
                      <a href="sign-up" class="f-pricing-button w-button">Get Started</a>
                    </div>
                  </div>
                </div>
                <div data-w-tab="Tab 2" class="f-pricing-tab-pane w-tab-pane w--tab-active">
                  <div class="w-layout-grid f-pricing-column-basic">
                    <div id="w-node-_427d6ea8-4c87-7341-314f-210994d218df-3facb51b" class="f-pricing-card-outline">
                      <div class="f-margin-bottom-16">
                        <h5 class="f-h5-heading-2">Other Sites</h5>
                      </div>
                      <div class="f-margin-bottom-49">
                        <h6 class="f-h6-heading"><?php echo $currencysymbol.$other_yearly; ?> <span class="f-pricing-duration">/ Yearly</span></h6>
                      </div>
                      <div class="w-layout-grid f-pricing-feature-list">
                        <div id="w-node-_427d6ea8-4c87-7341-314f-210994d218e9-3facb51b" class="f-pricing-feature-item">
                          <div class="f-icon-regular-2 w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none">
                              <path d="M12.0002 19.6386C7.78126 19.6386 4.36133 16.2187 4.36133 11.9997C4.36133 7.78077 7.78126 4.36084 12.0002 4.36084C16.2192 4.36084 19.6391 7.78077 19.6391 11.9997C19.6391 16.2187 16.2192 19.6386 12.0002 19.6386ZM11.2386 15.0553L16.6393 9.65383L15.5592 8.57369L11.2386 12.895L9.07758 10.734L7.99744 11.8141L11.2386 15.0553Z" fill="#160042"></path>
                            </svg></div>
                          <div class="f-paragraph-small-2 f-text-color-gray-600">Pay for each job</div>
                        </div>
                        <div id="w-node-_427d6ea8-4c87-7341-314f-210994d218ed-3facb51b" class="f-pricing-feature-item">
                          <div class="f-icon-regular-2 w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none">
                              <path d="M12.0002 19.6386C7.78126 19.6386 4.36133 16.2187 4.36133 11.9997C4.36133 7.78077 7.78126 4.36084 12.0002 4.36084C16.2192 4.36084 19.6391 7.78077 19.6391 11.9997C19.6391 16.2187 16.2192 19.6386 12.0002 19.6386ZM11.2386 15.0553L16.6393 9.65383L15.5592 8.57369L11.2386 12.895L9.07758 10.734L7.99744 11.8141L11.2386 15.0553Z" fill="#160042"></path>
                            </svg></div>
                          <div class="f-paragraph-small-2 f-text-color-gray-600">Shortlisting fees</div>
                        </div>
                        <div id="w-node-_427d6ea8-4c87-7341-314f-210994d218f1-3facb51b" class="f-pricing-feature-item">
                          <div class="f-icon-regular-2 w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none">
                              <path d="M12.0002 19.6386C7.78126 19.6386 4.36133 16.2187 4.36133 11.9997C4.36133 7.78077 7.78126 4.36084 12.0002 4.36084C16.2192 4.36084 19.6391 7.78077 19.6391 11.9997C19.6391 16.2187 16.2192 19.6386 12.0002 19.6386ZM11.2386 15.0553L16.6393 9.65383L15.5592 8.57369L11.2386 12.895L9.07758 10.734L7.99744 11.8141L11.2386 15.0553Z" fill="#160042"></path>
                            </svg></div>
                          <div class="f-paragraph-small-2 f-text-color-gray-600">Annual Charges </div>
                        </div>
                        <div id="w-node-_427d6ea8-4c87-7341-314f-210994d218f5-3facb51b" class="f-pricing-feature-item">
                          <div class="f-icon-regular-2 w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none">
                              <path d="M12.0002 19.6386C7.78126 19.6386 4.36133 16.2187 4.36133 11.9997C4.36133 7.78077 7.78126 4.36084 12.0002 4.36084C16.2192 4.36084 19.6391 7.78077 19.6391 11.9997C19.6391 16.2187 16.2192 19.6386 12.0002 19.6386ZM11.2386 15.0553L16.6393 9.65383L15.5592 8.57369L11.2386 12.895L9.07758 10.734L7.99744 11.8141L11.2386 15.0553Z" fill="#160042"></path>
                            </svg></div>
                          <div class="f-paragraph-small-2 f-text-color-gray-600">No Rewards</div>
                        </div>
                      </div>
                      <div class="f-pricing-line"></div>
                      <a href="sign-up" class="f-button-secondary w-button">Get Started</a>
                    </div>
                    <div id="w-node-_427d6ea8-4c87-7341-314f-210994d218fc-3facb51b" class="f-pricing-card-dark">
                      <div class="f-margin-bottom-16">
                        <h5 class="f-h5-heading-2 f-text-color-white">Buildela</h5>
                      </div>
                      <div class="f-margin-bottom-49">
                        <div class="f-pricing-type-wrapper">
                          <h6 class="f-h6-heading f-text-color-white"><?php echo $currencysymbol.$yearlyprice; ?> <span class="f-pricing-duration">/ Yearly</span></h6>
                          <div class="f-badge-filled">
                            <div>Popular</div>
                          </div>
                        </div>
                        <div class="month-pack">(Works out <?php echo $currencysymbol.$monthlyonyearly; ?> Per Month)</div>
                      </div>
                      <div class="w-layout-grid f-pricing-feature-list">
                        <div id="w-node-_427d6ea8-4c87-7341-314f-210994d2190a-3facb51b" class="f-pricing-feature-item">
                          <div class="f-icon-regular-2 w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none">
                              <path d="M12.0002 19.6386C7.78126 19.6386 4.36133 16.2187 4.36133 11.9997C4.36133 7.78077 7.78126 4.36084 12.0002 4.36084C16.2192 4.36084 19.6391 7.78077 19.6391 11.9997C19.6391 16.2187 16.2192 19.6386 12.0002 19.6386ZM11.2386 15.0553L16.6393 9.65383L15.5592 8.57369L11.2386 12.895L9.07758 10.734L7.99744 11.8141L11.2386 15.0553Z" fill="white"></path>
                            </svg></div>
                          <div class="f-paragraph-small-2 f-text-color-gray-400">Unlimited Jobs</div>
                        </div>
                        <div id="w-node-_427d6ea8-4c87-7341-314f-210994d2190e-3facb51b" class="f-pricing-feature-item">
                          <div class="f-icon-regular-2 w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none">
                              <path d="M12.0002 19.6386C7.78126 19.6386 4.36133 16.2187 4.36133 11.9997C4.36133 7.78077 7.78126 4.36084 12.0002 4.36084C16.2192 4.36084 19.6391 7.78077 19.6391 11.9997C19.6391 16.2187 16.2192 19.6386 12.0002 19.6386ZM11.2386 15.0553L16.6393 9.65383L15.5592 8.57369L11.2386 12.895L9.07758 10.734L7.99744 11.8141L11.2386 15.0553Z" fill="white"></path>
                            </svg></div>
                          <div class="f-paragraph-small-2 f-text-color-gray-400">No Shortlisting Fees</div>
                        </div>
                        
                        <div id="w-node-_427d6ea8-4c87-7341-314f-210994d21912-3facb51b" class="f-pricing-feature-item">
                          <div class="f-icon-regular-2 w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none">
                              <path d="M12.0002 19.6386C7.78126 19.6386 4.36133 16.2187 4.36133 11.9997C4.36133 7.78077 7.78126 4.36084 12.0002 4.36084C16.2192 4.36084 19.6391 7.78077 19.6391 11.9997C19.6391 16.2187 16.2192 19.6386 12.0002 19.6386ZM11.2386 15.0553L16.6393 9.65383L15.5592 8.57369L11.2386 12.895L9.07758 10.734L7.99744 11.8141L11.2386 15.0553Z" fill="white"></path>
                            </svg></div>
                          <div class="f-paragraph-small-2 f-text-color-gray-400">No Hidden Charges </div>
                        </div>
                        <div id="w-node-_427d6ea8-4c87-7341-314f-210994d21916-3facb51b" class="f-pricing-feature-item">
                          <div class="f-icon-regular-2 w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none">
                              <path d="M12.0002 19.6386C7.78126 19.6386 4.36133 16.2187 4.36133 11.9997C4.36133 7.78077 7.78126 4.36084 12.0002 4.36084C16.2192 4.36084 19.6391 7.78077 19.6391 11.9997C19.6391 16.2187 16.2192 19.6386 12.0002 19.6386ZM11.2386 15.0553L16.6393 9.65383L15.5592 8.57369L11.2386 12.895L9.07758 10.734L7.99744 11.8141L11.2386 15.0553Z" fill="white"></path>
                            </svg></div>
                          <div class="f-paragraph-small-2 f-text-color-gray-400">Great Rewards</div>
                        </div>
                      </div>
                      <div class="f-pricing-line-dark"></div>
                      <a href="sign-up" class="f-pricing-button w-button">Get Started</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <br>
        <div data-w-id="8d846c4f-0f66-25ea-6cf9-b7c826603e73" class="label2 faq trades">Frequently asked questions</div>
        <p class="brix---paragraph-default faq"></p>
        <div class="f-accordian-wrapper">
		
          <div data-delay="0" data-hover="false" class="f-accordian-dropdown w-dropdown">
            <div class="f-accordian-toggle w-dropdown-toggle">
              <div class="f-accordian-title-wrapper">
                <div class="f-accordian-title">What will it cost? </div>
                <div class="f-accordian-icon w-embed"><svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.9998 15L7.75684 10.757L9.17184 9.34302L11.9998 12.172L14.8278 9.34302L16.2428 10.757L11.9998 15Z" fill="currentColor"></path>
                  </svg></div>
              </div>
            </div>
            <nav class="f-accordian-list w-dropdown-list">
              <div class="f-accordian-content">
                <p class="f-paragraph-small-2">We have two membership packages providing access to unlimited jobs: one at £9.99 per month billed annually and the other at £19.99 billed monthly. Both packages have no hidden charges and allow you to apply for as many leads and win as many jobs as you want.</p>
              </div>
            </nav>
          </div>
		  
          <div data-delay="0" data-hover="false" class="f-accordian-dropdown w-dropdown">
            <div class="f-accordian-toggle w-dropdown-toggle">
              <div class="f-accordian-title-wrapper">
                <div class="f-accordian-title">How quickly can I get started? </div>
                <div class="f-accordian-icon w-embed"><svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.9998 15L7.75684 10.757L9.17184 9.34302L11.9998 12.172L14.8278 9.34302L16.2428 10.757L11.9998 15Z" fill="currentColor"></path>
                  </svg></div>
              </div>
            </div>
            <nav class="f-accordian-list w-dropdown-list">
              <div class="f-accordian-content">
                <p class="f-paragraph-small-2">Once you sign up, our team begins processing your application immediately, your account should be set up within 24 hours.</p>
              </div>
            </nav>
          </div>
		  
          <div data-delay="0" data-hover="false" class="f-accordian-dropdown w-dropdown">
            <div class="f-accordian-toggle w-dropdown-toggle">
              <div class="f-accordian-title-wrapper">
                <div class="f-accordian-title">How does feedback work?</div>
                <div class="f-accordian-icon w-embed"><svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.9998 15L7.75684 10.757L9.17184 9.34302L11.9998 12.172L14.8278 9.34302L16.2428 10.757L11.9998 15Z" fill="currentColor"></path>
                  </svg></div>
              </div>
            </div>
            <nav class="f-accordian-list w-dropdown-list">
              <div class="f-accordian-content">
                <p class="f-paragraph-small-2">Customer feedback is the most effective method for monitoring our members. We diligently verify the authenticity of all feedback received and do not publish anonymous feedback. In the event of negative feedback, you have the opportunity to respond.</p>
              </div>
            </nav>
          </div>
		  
          <div data-delay="0" data-hover="false" class="f-accordian-dropdown w-dropdown">
            <div class="f-accordian-toggle w-dropdown-toggle">
              <div class="f-accordian-title-wrapper">
                <div class="f-accordian-title">When can I start to see results? </div>
                <div class="f-accordian-icon w-embed"><svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.9998 15L7.75684 10.757L9.17184 9.34302L11.9998 12.172L14.8278 9.34302L16.2428 10.757L11.9998 15Z" fill="currentColor"></path>
                  </svg></div>
              </div>
            </div>
            <nav class="f-accordian-list w-dropdown-list">
              <div class="f-accordian-content">
                <p class="f-paragraph-small-2">Success on Buildela relies on highlighting your profile and delivering exceptional customer service. Trust is built as your feedback reputation increases, making it easier to secure work. If you're encountering difficulties in winning projects, please contact us for valuable advice and support.</p>
              </div>
            </nav>
          </div>
		  
		        <div data-delay="0" data-hover="false" class="f-accordian-dropdown w-dropdown">
            <div class="f-accordian-toggle w-dropdown-toggle">
              <div class="f-accordian-title-wrapper">
                <div class="f-accordian-title">How do I receive rewards?</div>
                <div class="f-accordian-icon w-embed"><svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.9998 15L7.75684 10.757L9.17184 9.34302L11.9998 12.172L14.8278 9.34302L16.2428 10.757L11.9998 15Z" fill="currentColor"></path>
                  </svg></div>
              </div>
            </div>
            <nav class="f-accordian-list w-dropdown-list">
              <div class="f-accordian-content">
                <p class="f-paragraph-small-2">We will contact you by your registered email. If we fail to reach you, we will try to reach you over the phone. Premier league ticket winners are announced at the end of every month, holiday winners are announced annually in June. </p>
              </div>
            </nav>
          </div>
		  
		        <div data-delay="0" data-hover="false" class="f-accordian-dropdown w-dropdown">
            <div class="f-accordian-toggle w-dropdown-toggle">
              <div class="f-accordian-title-wrapper">
                <div class="f-accordian-title">How will I get new updates? </div>
                <div class="f-accordian-icon w-embed"><svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.9998 15L7.75684 10.757L9.17184 9.34302L11.9998 12.172L14.8278 9.34302L16.2428 10.757L11.9998 15Z" fill="currentColor"></path>
                  </svg></div>
              </div>
            </div>
            <nav class="f-accordian-list w-dropdown-list">
              <div class="f-accordian-content">
                <p class="f-paragraph-small-2">You will receive alerts on our website regarding new messages, and if you’ve been shortlisted or hired. We recommend for the best experience, downloading our app on either the Google App Store or Apple App Store, to receive alerts on your phone.</p>
              </div>
            </nav>
          </div>
		  
		        <div data-delay="0" data-hover="false" class="f-accordian-dropdown w-dropdown">
            <div class="f-accordian-toggle w-dropdown-toggle">
              <div class="f-accordian-title-wrapper">
                <div class="f-accordian-title">I’m just starting out - is Buildela right for me? </div>
                <div class="f-accordian-icon w-embed"><svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.9998 15L7.75684 10.757L9.17184 9.34302L11.9998 12.172L14.8278 9.34302L16.2428 10.757L11.9998 15Z" fill="currentColor"></path>
                  </svg></div>
              </div>
            </div>
            <nav class="f-accordian-list w-dropdown-list">
              <div class="f-accordian-content">
                <p class="f-paragraph-small-2">Buildela can kickstart your entrepreneurial journey by supplying job leads if you aspire to start your own business. With our ongoing support, we'll help you establish a solid reputation by showcasing customer feedback.</p>
              </div>
            </nav>
          </div>
		  
        </div>
      </div>
    </div>
  </div>
  <div class="section">
    <div class="container">
      <section class="testimonial-slider-small faqtrades wf-section">
        <div class="container-7">
          <h2 data-w-id="0faac3cc-6a0c-72d4-0690-4879990578bc" class="centered-heading trades">Words from other trade members</h2>
          <p class="centered-subheading">Everybody wants to feel confident in their decision on choosing a tradesperson, Learn from other peoples experiences.</p>
          <div data-delay="4000" data-animation="slide" class="testimonial-slider w-slider" data-autoplay="false" data-easing="ease" data-hide-arrows="true" data-disable-swipe="false" data-autoplay-limit="0" data-nav-spacing="3" data-duration="500" data-infinite="true">
            <div class="w-slider-mask">
              <div class="testimonial-slide-wrapper w-slide">
                <div class="testimonial-card">
                  <p class="paragraph-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse tincidunt sagittis eros.</p>
                  <div class="testimonial-info"><img src="https://uploads-ssl.webflow.com/62434fa732124a0fb112aab4/62434fa732124a28a812aad9_placeholder%202.svg" loading="lazy" alt="" class="testimonial-image">
                    <div>
                      <h3 class="testimonial-author"><strong class="bold-text">Prime choice housing</strong></h3>
                      <div class="tagline">CEO / Company</div>
                    </div>
                    <div class="testimonial-icon-wrapper"><img src="https://uploads-ssl.webflow.com/62434fa732124a0fb112aab4/62434fa732124a6c9412aae6_double-quotes-l.svg" loading="lazy" alt=""></div>
                  </div>
                </div>
              </div>
              <div class="testimonial-slide-wrapper w-slide">
                <div class="testimonial-card">
                  <p class="paragraph-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse tincidunt sagittis eros.</p>
                  <div class="testimonial-info"><img src="https://uploads-ssl.webflow.com/62434fa732124a0fb112aab4/62434fa732124a28a812aad9_placeholder%202.svg" loading="lazy" alt="" class="testimonial-image">
                    <div>
                      <h3 class="testimonial-author"><strong>Roleus carpenters</strong></h3>
                      <div class="tagline">CEO / Company</div>
                    </div>
                    <div class="testimonial-icon-wrapper"><img src="https://uploads-ssl.webflow.com/62434fa732124a0fb112aab4/62434fa732124a6c9412aae6_double-quotes-l.svg" loading="lazy" alt=""></div>
                  </div>
                </div>
              </div>
              <div class="testimonial-slide-wrapper w-slide">
                <div class="testimonial-card">
                  <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                  <div class="testimonial-info"><img src="https://uploads-ssl.webflow.com/62434fa732124a0fb112aab4/62434fa732124a28a812aad9_placeholder%202.svg" loading="lazy" alt="" class="testimonial-image">
                    <div>
                      <h3 class="testimonial-author">Profile name</h3>
                      <div class="tagline">CEO / Creative IT</div>
                    </div>
                    <div class="testimonial-icon-wrapper"><img src="https://uploads-ssl.webflow.com/62434fa732124a0fb112aab4/62434fa732124a6c9412aae6_double-quotes-l.svg" loading="lazy" alt=""></div>
                  </div>
                </div>
              </div>
              <div class="testimonial-slide-wrapper w-slide">
                <div class="testimonial-card">
                  <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                  <div class="testimonial-info"><img src="https://uploads-ssl.webflow.com/62434fa732124a0fb112aab4/62434fa732124a28a812aad9_placeholder%202.svg" loading="lazy" alt="" class="testimonial-image">
                    <div>
                      <h3 class="testimonial-author">Profile name</h3>
                      <div class="tagline">CEO / Creative IT</div>
                    </div>
                    <div class="testimonial-icon-wrapper"><img src="https://uploads-ssl.webflow.com/62434fa732124a0fb112aab4/62434fa732124a6c9412aae6_double-quotes-l.svg" loading="lazy" alt=""></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="testimonial-slider-left w-slider-arrow-left">
              <div class="arrow-wrapper"><img src="https://uploads-ssl.webflow.com/62434fa732124a0fb112aab4/62434fa732124a0e4912aadb_Chevron%20right-1.svg" loading="lazy" alt="" class="slider-arrow-embed"></div>
            </div>
            <div class="testimonial-slider-right w-slider-arrow-right">
              <div class="arrow-wrapper"><img src="https://uploads-ssl.webflow.com/62434fa732124a0fb112aab4/62434fa732124a7ce212aacc_Chevron%20right.svg" loading="lazy" alt="" class="slider-arrow-embed"></div>
            </div>
            <div class="testimonial-slide-nav w-slider-nav w-round"></div>
          </div>
        </div>
      </section>
    </div>
  </div>
	<?php include_once "includes/footer-trades.php"?>
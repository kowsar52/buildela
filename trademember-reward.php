<?php
$pageTitle = " Trademember Rewards";
$pageDescription = "Gift Cards - All Inclusive Holidays - Shopping Giveaways";
include_once "includes/header.php";
include_once "serverside/functions.php";
$func=new Functions();


if(isset($_GET['date']) && !empty($_GET['date'])){

    $date=date('Y-m',strtotime($_GET['date']));
    $users=$func->TradesPersonReward($date);
}else{
    $date=date('Y-m');
    $users=$func->TradesPersonReward($date);
}



?>

<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<link href="css/style.css" rel="stylesheet" type="text/css">

<link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-auto-scroll@0.5.3/dist/js/splide-extension-auto-scroll.min.js"></script>


<style>
    .home-owner-reward-wrapper h2 {
    font-weight: 700;

}
.tradeMember-reward{
	background-position: center;
	background-size: 100% 100%;
	background-repeat: no-repeat;
}
.tradeMember-reward-2{
	/*background-image: url(../images/trademember-2.jpeg);*/
	background-position: center;
	background-size: 100% 100%;
	background-repeat: no-repeat;
}
.tradeMember-reward-heading{
  color: #fff;
    font-size: 3.2rem;
    line-height: 1.1;
    font-weight: bold;
    font-family: 'Poppins', sans-serif;
}
@media(max-width:480px){
    .tradeMember-reward-heading{
        font-size: 2rem;
    }
}
.container.reward-bottom {
    max-width: 760px;
    text-align: left;
}
.tradeMember-reward-heading-1{
	font-family: Raleway-Black;
	-webkit-text-stroke: 2px rgba(91 , 86 ,83 , 1);
	color: #fff;
	font-size: 2.4rem;
	line-height: 1;
	font-weight: bold;
}
.tradeMember-reward-heading-2{
	font-family: 'Poppins', sans-serif;
	-webkit-text-stroke: 2px #fff;
	color: #000 !important;
	font-size: 3rem;
	line-height: 1;
	font-weight: bold;
}

.winner-heading {
margin-bottom: 0;
font-size: 18px;

}
.winner-date{
  font-size: 23px;
  font-weight: 700;
}
.g-style-text{
  font-size: 18px;
}
.winner-date span{
	border-bottom: 2px solid #6c757d ;
}
.monthly-winner-text{
	font-size: 22px;
  border-top: 1px solid #e3e3e3;

}
.new-blue-text {
    color: #006BF5;
    font-size: 16px;
    font-weight: 700;
    max-width: 600px;
    margin: 40px auto;
    line-height: 1.3;
}
.border-and-shadow {
    background-color: #fff;
    border: 1px solid #aaa;
    margin-top: 20px;
    border-radius: 5px;
    overflow: hidden;
}
.car-images {
  padding-right: 0;
}
.car-images img {
    max-width: 45px;
}
@media(max-width:767.98px){
    .monthly-winner-text,.winner-date, .g-style-text{
	font-size: 18px;

}

.winner-date{
  margin-top: 10px;
}

}
.tradeMember-reward-shape{
  background: #fff;
    color: #fff;
    padding-top: 5rem;
    padding-bottom: 5rem;
    margin-bottom: 5rem;
    clip-path: ellipse(100% 58% at 50% 40%);
    background-image: linear-gradient(to bottom,rgba(30,32,34,.4),rgba(33,50,91,.3)), url('../images/trademember-reward-banner.jpg');
    background-size: cover;
    background-position: center;
}
.tradeMember-reward-button {
    text-align: center;
}

.tradeMember-reward-button a {
  text-align: center;
    color: #fff;
    background-color: rgb(209, 10, 56);
    display: inline-block;
    padding: 10px 40px;
    font-size: 20px;

    border-radius: 7px;
}
.not-a-customer {
    text-align: center;
    padding-top: 10px;
}

.not-a-customer a {
    color: #fff;
    text-align: center;
    font-size: 15px;
    text-decoration: underline;
}

.box-row.mx-auto {
    max-width: 1140px;
    text-align: center;
}
.box-row.mx-auto > div {
    padding-left: 10px;
    margin-bottom: 15px;
    padding-right: 10px;
}
.box-row.mx-auto > div .card {
    border-color: #e3e3e3;
    height: 100%;
    transition: all .2s ease-in-out;
    background-color: #fafaff;
}

.box-row.mx-auto > div .card .card-body {
    padding: 2.75rem 2.75rem;
}

.box-row.mx-auto > div .card .card-body i {
    margin-bottom: 1.2rem;
    font-size: 2.3rem;
    color: #D10A38;
}

.box-row.mx-auto > div .card .card-body .card-title {
    font-weight: 600;
    color: #006BF5;
    font-family: inherit;
    font-size: 20px;
    margin-bottom: 1.1rem;
}
.card-text{
  color: inherit;
}
.splide-carousel {
    padding-top: 30px;
    padding-bottom: 30px;
}

@media(max-width: 480px){
  .tradeMember-reward-shape {
    padding-top: 3rem;
    margin-bottom: 3rem;
}
.box-row.mx-auto > div .card .card-body {
    padding: 20px;
}
}
</style>



<div class="home-owner-reward-wrapper">
	<div class="tradeMember-reward pb-5 pt-4">
		<div class="row mx-auto justify-content-center tradeMember-reward-shape rounded-0">
			<div class="col-md-6">
				<div class="tradeMember-reward-heading text-white text-center px-3 pt-3 pb-3 pb-md-5">
					Rewards for our Trade Members
				</div>
				<div class="tradeMember-reward-button">
                     <?php if($islogin && $userinfo[0]['user_role'] === 'jobs_person'): ?>
                        <h4>Welcome <strong><?= $userinfo[0]['fname']; ?>!</strong></h4>
                    <?php else: ?>
				        <a href="login">Sign in to Buildela</a>
                    <?php endif; ?>
				</div>
				<?php if(!$islogin || $userinfo[0]['user_role'] === 'home_owner'): ?>
                    <div class="not-a-customer"><a href="sign-up">Not a member yet?</a></div>
                <?php endif; ?>
			</div>
		</div>
		<div class="row box-row mx-auto my-4 px-4 px-md-0">
      <div class="col-12 text-center mb-4">
        <h2>Title of this section</h2>
      </div>
		    <div class="col-md-4">
		        <div class="card">
      <div class="card-body">
          <i class="fa-solid fa-plane"></i>
        <h5 class="card-title">All Inclusive Family Holiday!</h5>
        <p class="card-text">We fly away 2 lucky families per year. Winners announced July 2024.</p>
        
      </div>
      </div>
		    </div>
		    <div class="col-md-4">
		        <div class="card">
      <div class="card-body">
          
          <i class="fa-solid fa-futbol"></i>
        <h5 class="card-title">Monthly Premier League Tickets!</h5>
        <p class="card-text">2 lucky winners recieve +1 tickets. Winners announced first day of the month.</p>
        
      </div>
    </div>
		    </div>
		    <div class="col-md-4">
		        <div class="card">
      <div class="card-body">
          
          <i class="fa-solid fa-cart-shopping"></i>
        <h5 class="card-title">Monthly ScrewFix Vouchers!</h5>
        <p class="card-text">2 lucky winners recieve £50 voucher. Winners announced first day of the month.</p>
        
      </div>
    </div>
		    </div>
		</div>
		<div class="row mx-auto justify-content-center splide-carousel">
			<div class="col-md-12 pr-0">
			    <div class="splide" role="group" aria-label="Splide Basic HTML Example">
                  <div class="splide__track">
                		<ul class="splide__list">
                			<li class="splide__slide"><img class="img-fluid mx-auto" src="images/81CF007B-6ED3-4C6B-9EA7-C04B6273332C.png" alt="81CF007B-6ED3-4C6B-9EA7-C04B6273332C"></li>
                			<li class="splide__slide"><img class="img-fluid mx-auto" src="images/D40A66A2-5FF5-4257-BF24-863BF92747C5.png" alt="D40A66A2-5FF5-4257-BF24-863BF92747C5"></li>
                			<li class="splide__slide"><img class="img-fluid mx-auto" src="images/Holidayreward.png" alt="Holidayreward"></li>
                		</ul>
                  </div>
                </div>

			</div>
		</div>
	</div>
	<div class="container text-center mb-md-5 pb-5">
	    <div class="row justify-content-center">
	        <div class="col-10 col-md-8 pr-0">
	            <h2 class="mb-3">This Month's Winners</h2>
	            <div class="embed-responsive embed-responsive-16by9 rounded-lg shadow">
                  <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0" allowfullscreen></iframe>
                </div>
	        </div>
	    </div>
	</div>

	<div class="container reward-bottom mb-5" >
		<div class="row py-4 pl-3 pl-md-0">
      <div class="row mx-0 justify-content-between align-items-center w-100">
        <div class="winner-date col-auto order-2 order-sm-0"><?=date('F Y',strtotime($date))?></div>
        <div class="col-auto d-flex flex-wrap align-items-center">
          <div class="winner-heading h5 col">Previous winners</div>
          <input type="text"  class="form-control col" id="select_month" placeholder="Select Date">

        </div>
      </div>

      <div class="col-md-12">

          
          <div class="border-and-shadow">
          <div class="row mx-0 align-items-center justify-content-between py-2 px-3 bg-light">
            <div class="col">
              <h6 class="mb-0">Winners</h6>
            </div>
            <div class="col-auto car-images">
              <img style="max-width: 135px;" src="images/reward-section-1.png">
            </div>
          </div>

          <div class="px-3 py-3 monthly-winner-text" id="premierLegue">
              <?php

              foreach ($users as $user){

                  if($user['reward_type']=='Premier league'){ ?>

                          <p class="g-style-text pt-2 mb-0"><?= $user['tradesperson_name']?>  - <?= $user['city']?> </p><?php
                }
              }
              ?>
          </div>
              
            </div>
          
          
      </div>
      
      <div class="col-md-12">
          <div class="border-and-shadow">
          <div class="row mx-0 align-items-center justify-content-between py-2 px-3 bg-light">
            <div class="col">
              <h6 class="mb-0">Winners</h6>
            </div>
            <div class="col-auto car-images">
              <img style="max-width: 135px;" src="images/screwfix.png">
            </div>
              
          </div>

          <div class="px-3 py-3 monthly-winner-text" id="screwfix">


              <?php

              foreach ($users as $user){

                  if($user['reward_type']=='Screwfix'){
                      ?>
                      <p class="g-style-text pt-2 mb-0"><?=$user['tradesperson_name']?>  - <?= $user['city']?></p>
                      <?php
                  }
              }
              ?>
          </div>
          
          
        </div>
      </div>
      <div class="col-md-12">
          
          <div class="border-and-shadow">
          <div class="row mx-0 align-items-center justify-content-between py-2 px-3 bg-light">
          <div class="col-auto">
              <h6 class="mb-0">Winners</h6>
            </div>
            
            <div class="car-images col-auto">
                  <img style="max-width: 165px;" class="img-fluid" src="images/jet-2.jpeg" alt="no-image">
              </div>
            
            
          </div>
              
          <div class="px-3 py-3 monthly-winner-text" id="jet2holidays">

            <?php

            foreach ($users as $user){

                if($user['reward_type']=='Jet2holidays'){
                    ?>
                    <p class="g-style-text pt-2 mb-0"><?=$user['tradesperson_name']?>  - <?= $user['city']?></p>
                    <?php
                }
            }
            ?>
            </div>
              
          </div>
      </div>



    </div>


			
		
		
	</div>
</div>
<?php include_once "includes/footer-no-cta.php";?>

<script>
 $( document ).ready(function() {

    var baseURL = window.location.protocol + "//" + window.location.host;


    var dp = $("#select_month").datepicker( {
        format: "yyyy-mm",
        startView: "months",
        minViewMode: "months"
    });

    $("#select_month").change(function (e){
        e.preventDefault();
        let date = $(this).val();
        // window.location.href="trademember-reward?date="+date;
        
        $.ajax({
            url: baseURL + "/serverside/post.php",
            type: "POST",
            data: {
                func: 111,
                date: date
            },
            success: function (data) {

                let leagues     =   JSON.parse(data),
                    Premier     =   '',
                    Screwfix    =   '',
                    Jet2holidays=   '';

                $.each(leagues, function(index){

                    if($(this)[0].reward_type === "Premier league") {
                    
                        Premier += '<p class="g-style-text pt-2 mb-0">'+$(this)[0].tradesperson_name+'  - '+$(this)[0].city+' </p>';
                    
                    } else if ($(this)[0].reward_type === "Screwfix") {

                        Screwfix += '<p class="g-style-text pt-2 mb-0">'+$(this)[0].tradesperson_name+'  - '+$(this)[0].city+' </p>';

                    }else if ($(this)[0].reward_type === "Jet2holidays") {

                        Jet2holidays += '<p class="g-style-text pt-2 mb-0">'+$(this)[0].tradesperson_name+'  - '+$(this)[0].city+' </p>';
                    }
                });

                $('#premierLegue p').remove();
                $('#screwfix p').remove();
                $('#jet2holidays p').remove();

                $('#premierLegue').append(Premier);
                $('#screwfix').append(Screwfix);
                $('#jet2holidays').append(Jet2holidays);
                             
            },
            error: function(){
                swal("Error loading!", "Some error happend to load the data!", "error");
            }
        });


    });



	
});





</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  new Splide('.splide', {
      gap: 15,
    arrows: false,
    pagination: false,
    type   : 'loop',
    drag   : 'free',
    focus  : 'center',
    perPage: 5,
    autoScroll: {
      speed: 1,
    },
    breakpoints: {
		640: {
			perPage: 2,
		},
		992: {
			perPage: 3,
		},
		1200: {
			perPage: 3,
		},
		1400: {
			perPage: 4,
		},
  }
  }).mount( window.splide.Extensions );
});

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
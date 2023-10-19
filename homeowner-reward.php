<?php
$pageTitle = " Homeowners Rewards";
$pageDescription = "Brand New Cars - All Inclusive Holidays - Shopping Giveaways";
include_once "includes/header.php";
include_once "serverside/functions.php";
$func=new Functions();

if(isset($_GET['date']) && !empty($_GET['date'])){

    $date=date('Y-m',strtotime($_GET['date']));
    $users=$func->HomeOwnerRewards($date);

}else{
    $date=date('Y-m');
    $users=$func->HomeOwnerRewards(date('Y-m'));
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
.home-owner-reward{
	background-position: center;
	background-size: 100% 100%;
	background-repeat: no-repeat;
}
.home-owner-reward-heading {
    color: #fff;
    font-size: 3.2rem;
    line-height: 1.1;
    font-weight: bold;
    font-family: 'Poppins', sans-serif;
}
@media(max-width: 480px){
    .home-owner-reward-heading{

    font-size: 2rem;

}
}
.home-owner-reward-link{
	background-color: #ffffff90;
	border:0px solid rgba(85 , 81 , 78 ,1);
	border-radius: 1px !important;
border-color: #e9eced !important;
background-color: #ffffff !important;
box-shadow: 0px 0px 6px 2px rgba(0,0,0,.1) !important;
padding-top: 5px !important;
padding-right: 15px !important;
padding-left: 15px !important;
padding-bottom: 15px !important;
margin-bottom: 7px;
border-width: 2px;
}

.first-text{
font-family: 'Poppins', sans-serif;
	color: #000;
	font-size: 1.5rem;
	line-height: 1;
}
.second-text{
font-family: 'Poppins', sans-serif;
	color: #000;
	font-size: 1.2rem;
	line-height: 1;	
}
.third-text{
font-family: 'Poppins', sans-serif;
	color: #000;
	font-size: 1.5rem;
	line-height: 1;	
}
.container.reward-bottom {
    max-width: 760px;
    text-align: left;
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


.home-owner-reward-shape {
    background: #fff;
    color: #fff;
    padding-top: 5rem;
    padding-bottom: 5rem;
    margin-bottom: 5rem;
    clip-path: ellipse(100% 58% at 50% 40%);
    background-image: linear-gradient(to bottom,rgba(30,32,34,.4),rgba(33,50,91,.3)), url('../images/homeowner-rewards-banner.jpg');
    background-size: cover;
    background-position: center;
}
.home-owner-reward-button {
    text-align: center;
}
.home-owner-reward-button a {
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
    font-size: 17px;
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
  .home-owner-reward-shape {
    padding-top: 3rem;
    margin-bottom: 3rem;
}
.box-row.mx-auto > div .card .card-body {
    padding: 20px;
}
}
</style>
<div class="home-owner-reward-wrapper">
    <div class="home-owner-reward pb-5 pt-4">
        <div class="row mx-auto justify-content-center home-owner-reward-shape">
			<div class="col-md-6">
				<div class="home-owner-reward-heading text-white text-center px-3 pt-3 pb-3 pb-md-5">
        Rewards For Our Homeowners
        </div>
				<div class="home-owner-reward-button">
                    <?php if($islogin && $userinfo[0]['user_role'] === 'home_owner'): ?>
                        <h4>Welcome <strong><?= $userinfo[0]['fname']; ?>!</strong></h4>
                    <?php else: ?>
				    <a href="login">Sign in to Buildela</a>
                    <?php endif; ?>
				</div>
				<div class="not-a-customer"><a href="post-a-job">Post a job</a></div>
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
        <h5 class="card-title">All Inclusive Family <br> Holiday!</h5>
        <p class="card-text">We fly away 2 lucky families per year. Winners announced July 2024.</p>
        
      </div>
    </div>
		    </div>
		    <div class="col-md-4">
		        <div class="card">
      <div class="card-body">
          
          
          <i class="fa-solid fa-car-side"></i>
        <h5 class="card-title">Win a BMW or <br> Mercedes-Benz!</h5>
        <p class="card-text">1 lucky winner per year will win a brand new, shiny car. Winner announced July 2024.</p>
                            
      </div>
    </div>
		    </div>
		    <div class="col-md-4">
		        <div class="card">
      <div class="card-body">
          
          <i class="fa-solid fa-cart-shopping"></i>
        <h5 class="card-title">Monthly £100 ASDA <br> Voucher Giveaway!</h5>
        <p class="card-text">2 lucky winners win £100 per month. Winners announced on the first day of each month.</p>
        
      </div>
    </div>
		    </div>
		</div>
        
        <div class="conatiner mx-2 mb-5">
            <div class="row mx-auto justify-content-center splide-carousel">
                <div class="col-md-12 pr-0">
                    <div class="splide" role="group" aria-label="Splide Basic HTML Example">
                  <div class="splide__track">
                		<ul class="splide__list">
                			<li class="splide__slide"><img class="img-fluid mx-auto" src="images/Asdareward.png" alt="Asdareward"></li>
                			<li class="splide__slide"><img class="img-fluid mx-auto" src="images/Holidayreward.png" alt="Holidayreward"></li>
                			<li class="splide__slide"><img class="img-fluid mx-auto" src="images/Carreward.png" alt="Carreward"></li>
                		</ul>
                  </div>
                </div>
                    
                </div>
            </div>
        </div>
        <div class="container text-center mb-md-5">
	    <div class="row justify-content-center">
	        <div class="col-10 col-md-8 pr-0">
	            <h2 class="mb-3">This Month's Winners</h2>
	            <div class="embed-responsive embed-responsive-16by9 rounded-lg shadow">
                  <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0" allowfullscreen></iframe>
                </div>
	        </div>
	    </div>
	</div>
    </div>
    <div class="container reward-bottom" >

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
                    <img style="max-width: 100px;" src="images/new-third.png">
                  </div>
                </div>
                    
                
                <div class="px-3 py-3 monthly-winner-text" id="asda">

                    <?php

                    foreach ($users as $user){

                        if($user['reward_type']=='ASDA'){
                            ?>
                            <?= $user['homeowner_name']?> <br class="d-md-none"> - <?= $user['city']?>
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
                    <div class="col-auto pr-0">
                      <div class="d-flex align-items-center">
                      <div class="car-images">
                            <img class="img-fluid" src="images/bmw-1.png" alt="no-image">
                        </div>
                        <div style="margin: 0 15px;font-size: 17px;text-transform: uppercase;font-weight: 700;">or</div>
                        <div class="car-images">
                            <img class="img-fluid" src="images/merc.jpeg" alt="no-image" style="max-width: 55px;">
                        </div>
                      </div>
                        
                    </div>
                    
                </div>
                
                <div class="px-3 py-3 monthly-winner-text" id="car">
                <?php

                foreach ($users as $user){

                    if($user['reward_type']=='CAR'){
                        ?>
                        <p class="g-style-text pt-2 mb-0"><?=$user['homeowner_name']?></p> - <?= $user['city']?>
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
                            <p class="g-style-text pt-2 mb-0"> <?=$user['homeowner_name']?></p> - <?= $user['city']?>
                            <?php
                        }
                    }
                    ?>
                    </div>
                </div>
            </div>
        </div>

        </div>


        <div class="row mx-auto justify-content-center pb-4">
            <div class="col-md-8 pl-3">
                <div class="new-blue-text text-center">To enter, post a job, and leave a review on how your job went. It's free!</div>
            </div>
        </div>

    </div>
</div>
<?php include_once "includes/footer-no-cta.php";?>
<script>
 $( document ).ready(function() {
    var dp=$("#select_month").datepicker( {
        format: "yyyy-mm",
        startView: "months",
        minViewMode: "months"
    });

    $("#select_month").change(function (e){
        e.preventDefault();
        let date    = $(this).val();
            baseURL = window.location.protocol + "//" + window.location.host;
        
        $.ajax({
            url: baseURL + "/serverside/post.php",
            type: "POST",
            data: {
                func: 112,
                date: date
            },
            success: function (data) {

                let leagues     =   JSON.parse(data),
                    asda        =   '',
                    car         =   '',
                    Jet2holidays=   '';

                console.log(leagues);

                $.each(leagues, function(index){

                    if($(this)[0].reward_type === "ASDA") {
                    
                        asda += '<p class="g-style-text pt-2 mb-0">'+$(this)[0].homeowner_name+'  - '+$(this)[0].city+' </p>';
                    
                    } else if ($(this)[0].reward_type === "CAR") {

                        car += '<p class="g-style-text pt-2 mb-0">'+$(this)[0].homeowner_name+'  - '+$(this)[0].city+' </p>';

                    }else if ($(this)[0].reward_type === "Jet2holidays") {

                        Jet2holidays += '<p class="g-style-text pt-2 mb-0">'+$(this)[0].homeowner_name+'  - '+$(this)[0].city+' </p>';
                    }
                });

                $('#asda p').remove();
                $('#car p').remove();
                $('#jet2holidays p').remove();

                $('#asda').append(asda);
                $('#car').append(car);
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
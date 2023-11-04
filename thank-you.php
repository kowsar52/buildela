<?php

require_once "serverside/functions.php";
include_once "serverside/session.php";

$func = new Functions();
$jobs = $func->getSingleJob($_GET['id']);
$traders = $func->getNearestTradesPeoples($_GET['id']);
$main = $func->SingleMainCategory($jobs[0]['main_type']);
include_once "includes/header.php"
?>

<!-- <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"> -->

<style>
  .intro-header.cc-subpage.thank-you {
    display: none;
  }

  .title-cta {
    font-size: 30px;
    line-height: 30px;
    font-weight: 700;
  }

  .features-list-2 {
    position: relative;
    padding: 0px 15px;
    border: 1px none #000;
  }

  a.text-link-arrow-2.w-inline-block {
    color: #006bf5;
  }

  .divider {
    width: 75%;
    height: 2px;
    margin: 25px auto;
    background-color: #e4ebf3;
    text-align: center;
  }

  .hero-without-image {
    position: relative;
    margin-bottom: 200px;
    padding: 0px 30px;
  }

  .w-button-text {

    border-radius: 10px !important;
  }

  .w-button-text {
    display: inline-block;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    font-size: 16px;
  }


  .hero-split {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    max-width: 46%;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -webkit-flex-direction: column;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-pack: start;
    -webkit-justify-content: flex-start;
    -ms-flex-pack: start;
    justify-content: flex-start;
    -webkit-box-align: start;
    -webkit-align-items: flex-start;
    -ms-flex-align: start;
    align-items: center;
  }

  .title-cta {
    margin-bottom: 10px;
  }

  h1 {
    margin-top: 20px;
    margin-bottom: 0px;
  }

  .heading-jumbo-small {
    margin-top: 10px;
    margin-bottom: 15px;
    background-image: linear-gradient(135deg, #d10a38, #006bf5);
  }

  @media (min-width: 320px) and (max-width: 480px) {
    .hero-split {
      max-width: 100%;
    }

    li.features-block-two-2 {
      flex-direction: row;
    }

    li.features-block-two-2 p {
      display: inline;
    }

    img.features-image-2 {
      display: inline-block;
    }
  }

  .arrow-embed-2.w-embed {
    line-height: 11px;
    display: inline-grid;
  }

  .section.cc-home-wrap.vid {
    margin-right: 0px;
    margin-left: 0pc;
  }

  .mb-0 {
    margin-bottom: 0;
  }

  .bg-white {
    background-color: #fff;
  }
</style>


<div class="section cc-home-wrap">
  <div class="intro-header cc-subpage thank-you">
    <div class="intro-content">
      <div class="heading-jumbo">Thank You<br></div>
    </div>
  </div>
  <section class="features-list-2 wf-section">
    <div class="container-9">
      <div class="features-wrapper-two-2">
        <div class="features-left-2">
          <h2><strong>Thank you for </strong>‍<strong>posting your job</strong></h2>
          <p class="features-paragraph-2"><?= $jobs[0]['title'] ?></p>
          <a href="my-posted-jobs-details?job_id=<?= $_GET['id'] ?>" class="w-button-text w-inline-block">
            <div class="text-block-7">Go to your job ></div>

          </a>
          <div class="section vid">
            <video id="BgVideo" class="build-vide" width="100%" height="auto" autoplay muted playsinline loop>
              <source src="videos/Buildela_W1.mp4" type="video/mp4">
              Your browser does not support the video tag.
            </video>
          </div>


        </div>
        <ul role="list" class="features-right-2 w-list-unstyled">
          <li class="features-block-two-2 bg-white mb-0">
            <p class="title-cta grey-text">What&#x27;s happens next?</p>
          </li>
          <li class="features-block-two-2"><img src="images/1.png" loading="lazy" alt="" class="features-image-2">
            <p>Wait for interested tradespeople</p>
          </li>
          <li class="features-block-two-2"><img src="images/2.png" loading="lazy" alt="" class="features-image-2">
            <p>Review their messages, profiles and feedback</p>
          </li>
          <li class="features-block-two-2"><img src="images/3_1.png" loading="lazy" alt="" class="features-image-2">
            <p>Shortlist the ones you like and get quotes</p>
          </li>
          <li class="features-block-two-2"><img src="images/4_1.png" loading="lazy" alt="" class="features-image-2">
            <p>Accept a quote that describes the work in writing</p>
          </li>
          <li class="features-block-two-2"><img src="images/5_1.png" loading="lazy" alt="" class="features-image-2">
            <p>Leave feedback on how the job went</p>
          </li>
        </ul>
      </div>
    </div>
  </section>
  <div class="container">
    <div class="motto-wrap"></div>
    <div class="about-story-wrap"></div>
    <div class="divider"></div>
    <section class="hero-heading-center wf-section">
      <div class="container-9">
        <div class="hero-wrapper">
          <div class="hero-split"><img src="images/builder-600-×-600px-2.png" loading="lazy" srcset="images/builder-600-×-600px-2-p-500.png 500w, images/builder-600-×-600px-2.png 600w" sizes="(max-width: 479px) 100vw, (max-width: 666px) 90vw, (max-width: 991px) 600px, (max-width: 1439px) 43vw, 432.390625px" alt="" class="shadow-two"></div>
          <div class="hero-split">
            <div class="title-cta">Make your job stand out</div>
            <p class="margin-bottom-24px">Sometimes it can save time and money, showing the builder exactly what you need. If photos and videos explain your job, add them here and get better responses from tradespeople.<strong><br></strong></p>
            <a href="my-posted-jobs-details?job_id=<?= $_GET['id'] ?>" class="button-primary-2 w-button-text">Add to gallery</a>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>

<section class="hero-without-image wf-section mb-0">
  <div class="container-9">
    <div class="hero-wrapper-two">
      <h1 class="heading-6">Leave feedback</h1>
      <p class="margin-bottom-24px-2">Remember to leave feedback on how the tradesperson performed. Simply leave a star rating, and tell us how it went, to win the chance of flying away on a five star, all inclusive holiday.</p>
      <a href="my-posted-jobs-details?job_id=<?= $_GET['id'] ?>" class="button-primary-3 w-button-text">View your job</a>
    </div>
  </div>
</section>

<div class="divider"></div>
<div class="container-4 w-container mb-200">
  <section class="features-list123 feature-custom appdl wf-section">
    <div class="columns-15 w-row">
      <div class="app w-col w-col-6">
        <h3 class="heading-16 app">Get&nbsp;the&nbsp;app.<br> Get&nbsp;things&nbsp;done.</h3>
        <div class="text-block-26 app">Compare prices, read reviews and book top rated tradespeople all in one free app.</div>
        <div class="download-app"><img src="images/free-available-on-the-app-store-apple-.png" loading="lazy" width="150" sizes="(max-width: 479px) 63vw, 150px" srcset="images/free-available-on-the-app-store-apple--p-500.png 500w, images/free-available-on-the-app-store-apple--p-800.png 800w, images/free-available-on-the-app-store-apple-.png 851w" alt="" class="image-18"><img src="images/Google-Play-Store-Button.png" loading="lazy" sizes="(max-width: 479px) 100vw, 150px" width="150" srcset="images/Google-Play-Store-Button-p-500.png 500w, images/Google-Play-Store-Button-p-800.png 800w, images/Google-Play-Store-Button-p-1080.png 1080w, images/Google-Play-Store-Button-p-1600.png 1600w, images/Google-Play-Store-Button-p-2000.png 2000w, images/Google-Play-Store-Button.png 2144w" alt="" class="image-19"></div>
      </div>
      <div class="w-col w-col-6"><img src="appsOverview.png" loading="lazy" sizes="(max-width: 479px) 100vw, (max-width: 767px) 44vw, (max-width: 1439px) 43vw, 470px" height="470" srcset="images/appsOverview.png 500w" alt="" class="image-17"></div>
    </div>
  </section>
</div>


<div class="modal fade" id="traderSuggestionModal" tabindex="-1" role="dialog" aria-labelledby="traderSuggestionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="traderSuggestionModalLabel">View your nearest tradespeople</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i class="fa-solid fa-xmark" style="font-size: 19px"></i>
        </button>
      </div>
      <div class="modal-body">
        <div class="row g-2">
          <div class="col-lg-3 col-md-4 col-6">
            <div class="card p-2 py-3 text-center">
              <div class="img mb-2"> <img src="https://i.imgur.com/LohyFIN.jpg" width="70" class="rounded-circle"> </div>
              <h5 class="mb-0">Patey Cruiser</h5> <small>Neurosurgeon</small>
              <div class="ratings mt-2"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </div>
              <div class="mt-4 apointment"> <button class="btn btn-success text-uppercase">Book Appointment</button> </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 col-6">
            <div class="card p-2 py-3 text-center">
              <div class="img mb-2"> <img src="https://i.imgur.com/o5uMfKo.jpg" width="70" class="rounded-circle"> </div>
              <h5 class="mb-0">Mario Speedway</h5> <small>Cardiologist</small>
              <div class="ratings mt-2"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </div>
              <div class="mt-4 apointment"> <button class="btn btn-success text-uppercase">Book Appointment</button> </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 col-6">
            <div class="card p-2 py-3 text-center">
              <div class="img mb-2"> <img src="https://i.imgur.com/tmdHXOY.jpg" width="70" class="rounded-circle"> </div>
              <h5 class="mb-0">Anna Sthesia</h5> <small>Surgeon</small>
              <div class="ratings mt-2"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </div>
              <div class="mt-4 apointment"> <button class="btn btn-success text-uppercase">Book Appointment</button> </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 col-6">
            <div class="card p-2 py-3 text-center">
              <div class="img mb-2"> <img src="https://i.imgur.com/C4egmYM.jpg" width="70" class="rounded-circle"> </div>
              <h5 class="mb-0">Paul Moliv</h5> <small>Dentist</small>
              <div class="ratings mt-2"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </div>
              <div class="mt-4 apointment"> <button class="btn btn-success text-uppercase">Book Appointment</button> </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 col-6">
            <div class="card p-2 py-3 text-center">
              <div class="img mb-2"> <img src="https://i.imgur.com/0LKZQYM.jpg" width="70" class="rounded-circle"> </div>
              <h5 class="mb-0">Anna Maul</h5> <small>Eye Specialist</small>
              <div class="ratings mt-2"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </div>
              <div class="mt-4 apointment"> <button class="btn btn-success text-uppercase">Book Appointment</button> </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 col-6">
            <div class="card p-2 py-3 text-center">
              <div class="img mb-2"> <img src="https://i.imgur.com/ZSkeqnd.jpg" width="70" class="rounded-circle"> </div>
              <h5 class="mb-0">Gail Forcewind</h5> <small>Urology</small>
              <div class="ratings mt-2"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </div>
              <div class="mt-4 apointment"> <button class="btn btn-success text-uppercase">Book Appointment</button> </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 col-6">
            <div class="card p-2 py-3 text-center">
              <div class="img mb-2"> <img src="https://i.imgur.com/MZm1LNz.jpg" width="70" class="rounded-circle"> </div>
              <h5 class="mb-0">Patey Cruiser</h5> <small>Neurosurgeon</small>
              <div class="ratings mt-2"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </div>
              <div class="mt-4 apointment"> <button class="btn btn-success text-uppercase">Book Appointment</button> </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 col-6">
            <div class="card p-2 py-3 text-center">
              <div class="img mb-2"> <img src="https://i.imgur.com/HFpxxJz.jpg" width="70" class="rounded-circle"> </div>
              <h5 class="mb-0">Patey Cruiser</h5> <small>Neurosurgeon</small>
              <div class="ratings mt-2"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </div>
              <div class="mt-4 apointment"> <button class="btn btn-success text-uppercase">Book Appointment</button> </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once "includes/footer.php" ?>

<style>
  .mb-0 {
    margin-bottom: 0px !important;
  }

  .mb-200 {
    margin-bottom: 200px !important;
  }


  .card {
    border-radius: 10px;
    transition: all 1s;
    cursor: pointer;
    margin-bottom: 20px;
  }

  .card:hover {
    -webkit-box-shadow: 3px 5px 17px -4px #777777;
    box-shadow: 3px 5px 17px -4px #777777
  }

  .card .img img {
    margin: 0 auto;
  }

  .ratings i {
    color: green
  }

  .apointment button {
    border-radius: 20px;
    background-color: #eee;
    color: #000;
    border-color: #eee;
    font-size: 13px
  }

  .g-2 {
    margin-left: 0px !important;
  }

  h5#traderSuggestionModalLabel {
    margin: 0;
  }

  #traderSuggestionModal .btn-success:hover {
    color: #fff;
    background-color: #006bf5;
    border-color: #006bf5ba;
  }

  @media screen and (max-width: 479px) {
    .download-app {
      display: flex;
      padding-left: 0;
      align-items: center;
      justify-content: center;
    }
  }
</style>


<script>
  $(document).ready(function() {
    $('#traderSuggestionModal').modal('show');
  });
</script>
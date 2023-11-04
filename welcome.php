<?php include_once "includes/header.php" ?>

<div class="section cc-home-wrap">
  <video id="BgVideo" class="build-vide" width="100%" height="auto" autoplay muted playsinline loop>
    <source src="videos/Buildela_W1.mp4" type="video/mp4">
    Your browser does not support the video tag.
  </video>
</div>

<div class="container">
  <div class="about-story-wrap">
    <div class="w-container">
      <p class="margin-bottom-24px"><span class="text-span-3"><strong>What&#x27;s Next?<br></strong></span>Head to your profile to select trades to suit your business.<strong><br></strong></p>
      <a href="my-profile" class="button-primary-2 w-button">Select Your Trades</a>
    </div>
  </div>
</div>


<!--Modal for APP-DOWNLOAD SUGGESTION -->
<div class="modal fade" id="appDownloadModal" tabindex="-1" role="dialog" aria-labelledby="appDownloadModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: none;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
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
    </div>
  </div>
</div>


</div>

<script>
  $(document).ready(function() {
    $('#appDownloadModal').modal('show');
  });


  var bgvideo = document.getElementById("BgVideo");
  bgvideo.muted = true;
  bgvideo.play();
</script>

<style>
  /* MODAL */
  /* #appDownloadModal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background: #181818c7;
    z-index: 99999;
    display: flex;
    justify-content: center;
    display: none;
  }

  #appDownloadModal .modal-dialog {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }

  #appDownloadModal .modal-content {
    width: 70%;
    background: #fff;
    border-radius: 6px;
    position: relative
  }

  #appDownloadModal button.close {
    position: absolute;
    right: 4px;
    top: 4px;
  } */


  video.build-vide {
    width: 63%;
    margin-left: auto;
    margin-right: auto;
    display: block;
  }

  .section.cc-home-wrap {
    padding-top: 0px;
  }

  .intro-header.cc-subpage.userprofile.welcome {
    border-radius: 10px;
  }

  .motto-wrap {
    width: 80%;
    margin-right: auto;
    margin-bottom: 140px;
    margin-left: auto;
    text-align: center;
    margin-top: 115px;
  }

  .heading-jumbo-small {
    margin-top: 10px;
    background-image: linear-gradient(135deg, #d10a38, #006bf5);
    color: #006bf5;
    font-size: 43px;
    line-height: 50px;
    font-weight: 700;
    text-transform: none;
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
  }

  .paragraph-bigger.cc-bigger-light {
    opacity: 0.6;
    margin-top: 10px;
  }

  /* 
    ##Device = Most of the Smartphones Mobiles (Portrait)
    ##Screen = B/w 320px to 479px
  */
  @media (min-width: 320px) and (max-width: 480px) {

    #appDownloadModal h3.heading-16.app {
      margin-left: 0;
      font-size: 30px;
    }

    #appDownloadModal button#close {
      position: absolute;
      right: 14px;
      top: 10px;
    }

    .section.cc-home-wrap {
      padding-top: 0px;
    }

    .motto-wrap {
      display: none;
    }

    .heading-jumbo-small {
      margin-top: 10px;
      background-image: linear-gradient(135deg, #d10a38, #006bf5);
      color: #006bf5;
      font-size: 30px;
      line-height: 37px;
    }

    .about-story-wrap {
      width: 80%;
      margin: 0px auto;
      text-align: center;
      margin-bottom: 180px;
    }

    .text-span-3 {
      font-size: 25px;
    }

    a.button-primary-2.w-button {
      border-radius: 10px;
    }

    video.build-vide {
      width: 100%;
      margin-left: auto;
      margin-right: auto;
      display: block;
    }
  }

  .about-story-wrap {
    width: 100%;
    margin: 0px 0px 60px 0px;
    text-align: center;
  }
</style>
<?php include_once "includes/footer-no-cta.php" ?>
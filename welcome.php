<?php include_once "includes/header.php"?>

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
  </div>
  
  <script>
var bgvideo = document.getElementById("BgVideo");
bgvideo.muted = true;
bgvideo.play();
</script>
  
<style>
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
<?php include_once "includes/footer-no-cta.php"?>
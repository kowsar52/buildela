<?php include_once "includes/header.php"?>
<div class="login-up-wrapper bg-white">
    <div class="login-up-wrapper-inner">
        <div class="container">
            <div class="row mx-auto justify-content-center">
                <div class="col-md-7">
                    <div class="login-form py-5">
                        <h3 class="login-heading h1 py-2 text-primary new-thanks-heading text-center">Thanks for completing your registration.</h3>

                        <div class="text-center py-4 new-thanks-text">We aim to process your application within 24 hours.</div>
                        <div class="text-center py-4 new-thanks-text">Keep an eye out on either your emails/app notifications or website to track the progress.</div>
                     <div class="section cc-home-wrap">
<video id="BgVideo" class="build-vide" width="100%" height="auto" autoplay muted playsinline loop>
  <source src="videos/Buildela_W1.mp4" type="video/mp4">
  Your browser does not support the video tag.
</video>
    </div>
                        <div class="text-center py-4 new-thanks-text">In the meantime, why not get ready to win leads by uploading images/videos of your previous work & also some information about the services that you provide onto your profile page.</div>
                        
                        <div class="btn-div-general pt-2 text-center">
                            <a href="my-profile" class="btn btn-primary btn-lg start-quiz-btn px-5" >My Profile</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once "includes/footer-no-cta.php"?>
<script>
    document.getElementById('message').innerHTML = document.getElementById('message').innerHTML.trim();
</script>


<style>
h3.login-heading.h1.py-2.text-primary.new-thanks-heading.text-center {
    text-align: center;
    font-weight: 600;
    margin-top: 25px;
}
.login-form.py-5 {
    text-align: center;
}
.image.text-center img {
    margin-left: auto;
    margin-right: auto;
    margin-top: 20px;
    margin-bottom: 20px;
}
a.btn.btn-primary.btn-lg.start-quiz-btn.px-5 {
    margin-bottom: 30px;
}
</style>

 
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
a.btn.btn-primary.btn-lg.start-quiz-btn.px-5 {
    text-align: center;
    color: #006bf5;
}
</style>
<?php include_once "includes/header.php"?>

  <div class="section cc-home-wrap">
    <div class="intro-header cc-subpage userprofile about">
      <div class="intro-content">
        <div class="heading-jumbo" style="/*! text-decoration-color: azure !important; */background-image: linear-gradient(117deg, #fff8f8, #fffbfb 99%, #58dfe5);transition: opacity 475ms;">About Us<br></div>
      </div>
    </div>
    <div class="container">
      <div class="motto-wrap">
        <div class="heading-jumbo-small">&quot;Buildela is a modern platform with the latest technology, aimed at providing users with the best solution to manage their homes.&quot;</div>
      </div>
      <div class="about-story-wrap">
        <section class="hero-heading-center about-top wf-section">
          <div class="container-9">
            <div class="hero-wrapper">
              <div class="hero-split">
                <p class="margin-bottom-24px"><strong class="subtext">We are committed to supporting customers in their search for exceptional builders and aiding skilled professionals in securing rewarding work opportunities.<br>‍<br></strong>There is plenty of tradespeople, but finding a good one can be challenging. At Buildela, we take the hassle out of finding the right tradesperson with our unique matchmaking system. Once your job is posted, we alert relevant tradespeople and those interested get in touch. Access comprehensive work history and customer feedback comments to assist in selecting the most suitable builder for your project.<strong><br></strong></p>
                <a href="post-a-job" class="button-primary-2 about w-button">Post a job</a>
              </div>
              <div class="hero-split"><img src="images/builder-600-×-600px-1.png" loading="lazy" srcset="images/builder-600-×-600px-1-p-500.png 500w, images/builder-600-×-600px-1.png 600w" sizes="(max-width: 479px) 100vw, (max-width: 767px) 73vw, (max-width: 991px) 74vw, (max-width: 1439px) 35vw, 432.390625px" alt="" class="shadow-two"></div>
            </div>
          </div>
        </section>
      </div>
      <div class="divider"></div>
      <section class="hero-heading-center about wf-section">
        <div class="container-9">
          <div class="hero-wrapper">
           <div class="hero-split"><img src="images/Tradesperson-drilling(1).jpg" loading="lazy" srcset="images/Tradesperson-drilling(1).jpg 500w, images/Tradesperson-drilling(1).jpg 600w" sizes="(max-width: 479px) 100vw, (max-width: 767px) 73vw, (max-width: 991px) 74vw, (max-width: 1439px) 35vw, 432.390625px" alt="" class="shadow-two"></div>
            <div class="hero-split">
              <p class="margin-bottom-24px"><strong class="subtext">Helping everyone that we encounter, is at the core of Buildela. Our mission is to make life easier for tradespeople and people looking for builders.<br>‍<br></strong>Possessing the right qualifications and skills only sometimes guarantees work. Finding local customers can seem like an impossible task at times. The trades must focus on doing great work for their customers without worrying about where the next job will come from. Buildela's feedback system means that today's client helps Buildela's tradespeople win tomorrow's work.<strong><br></strong></p>
              <a href="sign-up" class="button-primary-2 about w-button">Join as a Pro</a>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
 
<style>
  .container {
    text-align: left;
}
.hero-split .w-button {
    align-self: center;
}
.section.cc-home-wrap {
    padding-top: 10px;
}
.intro-header.cc-subpage.userprofile.about {
    border-radius: 10px;
    margin-bottom: 4rem;
}
.hero-wrapper {

    align-items: flex-start;

}
.button-primary-2.about {
    border-style: none;
    background: #006bf5;
    color: #fff;
    font-size: 14px;
    font-weight: 600;
    border-radius: 7px;
    letter-spacing: 1px;
    align-self: flex-start;
}
.button-primary-2.about:hover{
  background: #1861D1;
}
.heading-jumbo-small {
     font-family: 'Poppins', sans-serif;
    background-image: linear-gradient(135deg, #d10a38, #006bf5);
}

/* Site wide*/






/* 
  ##Device = Most of the Smartphones Mobiles (Portrait)
  ##Screen = B/w 320px to 479px
*/

@media (min-width: 320px) and (max-width: 480px) {
  
.heading-jumbo-small {
    line-height: 30px;
    font-size: 22px;
}


section.hero-heading-center.about-top.wf-section {
    padding-top: 10px;
    padding-bottom: 0px;
    margin-bottom: 35px;
}
.divider {
    width: 75%;
    height: 2px;
    margin: 0px auto;
    background-color: #e4ebf3;
    text-align: center;
}
section.hero-heading-center.about.wf-section {
    padding-top: 35px;
}
.hero-heading-center.about {
    margin-bottom: 135px;
}
  
}


</style>

<?php include_once "includes/footer.php"?>
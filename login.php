<?php 
$pageTitle = "Login";
$pageDescription = "Login To your Buildela Account Now";

include_once "includes/header.php";

if($islogin):?>
  <script>
    window.location.href = 'index.php';
  </script>
<?php exit; endif; ?>

<style>
.postjb {
    border-radius: 5px;
    background-color: #006bf5;
    font-weight: 600;
}
.postjb:hover{
  background-color: #1477F7;
  color: #fff;
}
.f-button-neutral-3 {

    border-radius: 8px;
}
.f-account-link-2 {
    color: #006bf5;
    font-weight: 700;
    text-decoration: none;
}


/* 
  ##Device = Most of the Smartphones Mobiles (Portrait)
  ##Screen = B/w 320px to 479px
*/

@media (min-width: 320px) and (max-width: 480px) {
.f-account-container-l {
    padding-top: 5px;
    padding-bottom: 10px;
}
.f-margin-bottom-74 {
    margin-top: 15px;
    margin-bottom: 8px;
}
}
.w-input, .w-select, textarea {
  font-size: 16px!important;
}

</style>
 <div class="f-account-section-2">
    <div class="f-account-container-l">
      <div class="f-account-content-wrapper-2">
        <div class="div-block-12">
          <p class="f-paragraph-regular-3"><strong class="bold-text-5">Need a builder or tradesperson? <br></strong><span class="text-span-2">Post your job here for quick responses from reliable local tradespeople</span></p>
          <a href="post-a-job" class="postjb w-button">Post a job</a>
        </div>
        <div class="f-margin-bottom-74">
          <h5 class="f-h5-heading-3">Login</h5>
        </div>
        <div class="f-margin-bottom-73">

        </div>
        <div class="f-account-form-block-2 w-form">
          <form id="login-form"  >
            <div class="w-layout-grid f-account-input-grid-2">
              <div class="f-field-wrapper-2">
                <div class="f-field-label-2">Email</div><input type="email" class="f-field-input-2 w-input" maxlength="256" name="Email-Field-04" data-name="Email Field 04" placeholder="Your email..." required id="email" >
              </div>
              <div class="f-field-wrapper-2">
                <div class="f-field-label-2">Password</div><input type="password" class="f-field-input-2 w-input" maxlength="256" name="Password-Field-04" data-name="Password Field 04" placeholder="Your password..." required id="pass">
              </div>
            </div>
            <div class="f-account-form-button-2"><button type="submit"  value="Login" class="f-button-neutral-3 w-button login_btn">Login</button></div>
          </form>
              <a class="forgotpw" href="recover_password">Forgot Password</a>
        </div>
        <p class="f-paragraph-small-4">Don&#x27;t have an account? <a href="sign-up" class="f-account-link-2">Register as a tradesperson</a>
        </p>
      </div>
    </div>
    <div class="f-account-image-wrapper-2"><img src="images/Buildela-2.png" loading="lazy" srcset="images/Buildela-2-p-500.png 500w, images/Buildela-2-p-800.png 800w, images/Buildela-2.png 800w" sizes="(max-width: 767px) 100vw, (max-width: 991px) 40vw, 45vw" alt="" class="f-image-cover-3"></div>
  </div>
  
<?php include_once "includes/footer-no-cta.php"?>

<!-- <script src="https://www.gstatic.com/firebasejs/8.7.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.7.0/firebase-messaging.js"></script>

<script>

  // Replace with your Firebase project configuration
  const firebaseConfig = {
    apiKey: "AIzaSyDuQap5naiFqC5cZhXnE7Lc3__Ocs9ii5c",
    authDomain: "buildela-16a22.firebaseapp.com",
    projectId: "buildela-16a22",
    storageBucket: "buildela-16a22.appspot.com",
    messagingSenderId: "26239317888",
    appId: "1:26239317888:web:b23fc9e04db2c62af1b365",
    measurementId: "G-SCB20XRVHG"
  };

  firebase.initializeApp(firebaseConfig);

  // Use Firebase Messaging
  const messaging = firebase.messaging();
  messaging
    .getToken()
    .then((currentToken) => {
      if (currentToken) {
        // Send the FCM token to the server using an HTTP request
        // Typically a POST request to your PHP endpoint
        console.log(currentToken);
      } else {
        console.log('No FCM token available.');
      }
    })
    .catch((error) => {
      console.log('Error retrieving FCM token:', error);
    });
</script> -->
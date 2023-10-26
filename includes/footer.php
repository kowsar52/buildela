<section class="footer-dark wf-section">
    <div class="section cc-cta">
      <div class="container">
        <div class="cta-wrap">
          <div>
            <div class="cta-text">
              <div class="heading-jumbo-small">Get started by posting a job<br></div>
              <div class="paragraph-bigger cc-bigger-light">Today is the day to build the home of your dreams or get that repair fixed. Share your project with local vetted tradespeople — and begin the journey.<br></div>
            </div>
            <a href="post-a-job" class="button cc-jumbo-button w-inline-block">
              <div>Start Now</div>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="container-7">
      <div class="footer-wrapper">
        <a href="#" class="footer-brand w-inline-block"><img width="200px" src="images/buildela-logo-w.png" loading="lazy" alt="" class="image-8"></a>
     <?php include "includes/footer-content.php"?>
      </div>
    </div>
    <div class="footer-divider"></div>
    <div class="footer-copyright-center">Copyright © 2022 Buildela</div>
  </section>
  <script src="js/webflow.js" type="text/javascript"></script>
  <!-- [if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif] -->
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/63c77c49c2f1ac1e202e3f3d/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</body>
</html> 

<!--<script src="js/jquery-3.6.1.js" type="text/javascript"></script>-->
<script src="js/popper.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript" src="js/navbar.js?v0.111"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="js/custom.js?v=1.111114"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>
$('.owl-blogs').owlCarousel({

    loop:true,
    margin:15,
    responsiveClass:true,
    dots: false,
    smartSpeed:700,
    navText: [
        '<i class="fa fa-angle-left" aria-hidden="true"></i>',
        '<i class="fa fa-angle-right" aria-hidden="true"></i>'
    ],
    responsive:{
        0:{
            items:1,
            nav:false,
            stagePadding: 30,
        },
        
        600:{
            items:2,
            nav:false,

        },
        1000:{
            items:3,
            nav:true,
            loop:false,

        }
    }
})
</script>
<script type="text/javascript" src="js/wow.js"></script>
<script type="text/javascript">
      new WOW().init();
</script>

<script type="text/javascript"> 

  jQuery(document).ready(function () {
  ImgUpload();
  
  $( "a.sub:contains('Other')" ).css( "display", "none" );

});

function ImgUpload() {
  var imgWrap = "";
  var imgArray = [];

  $('.upload__inputfile').each(function () {
    $(this).on('change', function (e) {
      imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
      var maxLength = $(this).attr('data-max_length');

      var files = e.target.files;
      var filesArr = Array.prototype.slice.call(files);
      var iterator = 0;
      filesArr.forEach(function (f, index) {

        if (!f.type.match('image.*')) {
          return;
        }

        if (imgArray.length > maxLength) {
          return false
        } else {
          var len = 0;
          for (var i = 0; i < imgArray.length; i++) {
            if (imgArray[i] !== undefined) {
              len++;
            }
          }
          if (len > maxLength) {
            return false;
          } else {
            imgArray.push(f);

            var reader = new FileReader();
            reader.onload = function (e) {
              var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
              imgWrap.append(html);
              iterator++;
            }
            reader.readAsDataURL(f);
          }
        }
      });
    });
  });

  $('body').on('click', ".upload__img-close", function (e) {
    var file = $(this).parent().data("file");
    for (var i = 0; i < imgArray.length; i++) {
      if (imgArray[i].name === file) {
        imgArray.splice(i, 1);
        break;
      }
    }
    $(this).parent().parent().remove();
  });
}
</script>
<script type="text/javascript">
  function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#imageUpload").change(function() {
    readURL(this);
});




</script>
<script >
  $('.image-slider').slick();
</script>
<script>
function openForm() {
  document.getElementById("post_job").style.display = "block";
   document.getElementById("formbk").style.display = "block";
}

function closeForm() {
  document.getElementById("post_job").style.display = "none";
  document.getElementById("formbk").style.display = "none";
}
function filterFunction() {
  var input, filter, ul, li, a, i;
  
  $( "a.sub:contains('Other')" ).css( "display", "none" );
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  exclude = "OTHER";
  div = document.getElementById("myDropdown");
  a = div.getElementsByTagName("a");
  for (i = 0; i < a.length; i++) {
    txtValue = a[i].textContent || a[i].innerText;
	  $( "a.sub:contains('Other')" ).css( "display", "none" );
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
}
</script>

<script src="https://buildela.com/customjs/myjs.js?var=<?php echo time(); ?> "></script>

<?php if(isset($_SESSION)): ?>
  <script>
    $(document).ready(function(){
      let ajaxCall          = true,
          notificationplay  = 0;
          currentURL        = window.location.href;

      if(ajaxCall === true) {
        ajaxCall = false;
        setInterval(function(e){

            $.ajax({
                url:"serverside/post.php",
                method:"post",
                data:{
                    func:113,
                    url: currentURL
                },
                success:function(data){
                    ajaxCall = true;
                    data = JSON.parse(data)
                    if(data.newmsgcount > 0){
                      let msgdot = '<span style="" class="bg-danger position-absolute text-white rounded-circle px-1 my-ac">'+data.newmsgcount+'</span>'
                      $('.account.w-dropdown ').removeClass('notice-on').addClass('notice-on');
                      $('.text-block-2.account span').remove();
                      $('.text-block-2.account').append(msgdot);
                      $('#chatmenulink span').remove();
                      $('#chatmenulink').append('<span style="top: 10px;right: 15px;font-size: 15px;font-size: 12px; height: 18px!important;width: 14px!important;" class="bg-danger position-absolute text-white rounded-circle px-1">'+data.newmsgcount+'</span>');
                    } else {
                      $('.text-block-2.account span').remove();
                      $('#chatmenulink span').remove();
                    }

                }
            });
        },1500);
      }
    });
  </script>
<!---->
<?php endif; ?>






    
	   
	   <?php //include "includes/postajob.php"?>
	   <script>
    // Disable landscape mode on mobile devices
    // function disableLandscapeMode() {
    //     if (window.orientation !== undefined) {
    //         var currentOrientation = window.orientation;

    //         if (currentOrientation === 90 || currentOrientation === -90) {
                
    //             alert('Please rotate your device to portrait mode.');
    //         }
    //     }
    // }

    // // Call the function on page load
    // window.onload = function() {
    //     disableLandscapeMode();
    // };

    // // Call the function on orientation change
    // window.onorientationchange = function() {
    //     disableLandscapeMode();
    // };

</script>
</body>

</html>

<style>


.panel.panel-default.card-input.p-2.d-flex.flex-wrap.align-items-center.justify-content-between:hover {
    background: rgb(242, 247, 250);
}
label.radio-btn:hover {
    border-color: rgb(221 221 221) !important;
    color: rgb(51, 51, 51);
}
.card-input div {
    font-family: 'Montserrat'!important;
    font-size: 16px;
    text-transform: none;
    font-weight: 500;
}
.post-a-job-continue-btn-div.pt-4 {
    margin-top: 0px;
    margin-bottom: 20px;
    padding-top: 0px!important;
}

</style>
<section class="footer-dark wf-section">
    <div class="section cc-cta">
        <div class="container">
            <div class="cta-wrap">
                <div>
                    <div class="cta-text">
                        <div class="heading-jumbo-small">Register as a trademember<br></div>
                        <div class="paragraph-bigger cc-bigger-light">Sign up to start winning an unlimited amount of jobs near you.<br><br> <b style="font-size: 24px;">Just <?= $currencysymbol.$monthlyonyearly; ?> per month</b><br></div>
                    </div>
                    <a href="sign-up" class="button cc-jumbo-button w-inline-block">
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
<script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=63594e2b152cff3d3e2c50f6" type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="js/webflow.js" type="text/javascript"></script>
<!-- [if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif] -->
</body>
</html>
<!--<script src="js/jquery-3.6.1.js" type="text/javascript"></script>-->
<script src="js/popper.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript" src="js/navbar.js?v0.111"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="js/custom.js?v=1.111115"></script>
<script type="text/javascript" src="js/wow.js"></script>
<script type="text/javascript">
    new WOW().init();
</script>

<script type="text/javascript">

    jQuery(document).ready(function () {
        ImgUpload();
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
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        div = document.getElementById("myDropdown");
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                a[i].style.display = "";
            } else {
                a[i].style.display = "none";
            }
        }
    }
</script>

<script src="customjs/myjs.js?var=<?php echo time(); ?>"></script>
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

<?php endif; ?>
<?php include_once "includes/postajob.php"?>
</body>

</html>
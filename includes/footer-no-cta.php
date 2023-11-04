<!-- <section class="footer-dark wf-section">
    <div class="container-7">
      <div class="footer-wrapper">
        <a href="#" class="footer-brand w-inline-block"><img width="200px" src="<?php echo BASE_URL; ?>images/buildela-logo-w.png" loading="lazy" alt="" class="image-8"></a>
    <?php include "includes/footer-content.php"?>
      </div>
    </div>
    <div class="footer-divider"></div>
    <div class="footer-copyright-center">Copyright © 2022 Buildela</div>
  </section> -->
  <script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=63594e2b152cff3d3e2c50f6" type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="<?php echo BASE_URL; ?>js/webflow.js" type="text/javascript"></script>
  <!-- [if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif] -->
</body>
<!--<script src="js/jquery-3.6.1.js" type="text/javascript"></script>-->
<script src="<?php echo BASE_URL; ?>js/popper.min.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>js/bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>js/navbar.js?v=0.1114"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>




<script type="text/javascript" src="<?php echo BASE_URL; ?>js/custom.js?v=1.011111838"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>js/wow.js"></script>
<script type="text/javascript">
      new WOW().init();
</script>
<?php if($func->pageChecker('leads') === null ): ?>
<script>
    $(".image-blocks").magnificPopup({
        delegate: "a",
        type: "image",
        tLoading: "Loading image #%curr%...",
        mainClass: "mfp-img-mobile",
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0, 1], // Will preload 0 - before current, and 1 after the current image
        },
        image: {
            tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
            titleSrc: function (item) {
                var $gallery = $(".image-blocks");
                var $result = "";
                if ($gallery.find("a").length > 0) {
                    var numThumbs = $gallery.find("a").length; // Get the total number of thumbs
                    var numVisibleThumbs = 4; // Set the number of initially visible thumbs
                    var startThumbIndex = Math.floor(item.index / numVisibleThumbs) * numVisibleThumbs; // Calculate the start index of the visible thumbs

                    $result =
                        '<div class="mfp-pager">' +
                        '<div class="arrow_prev">' +
                        '<button type="button" class="prev arrow" onclick="javascript:$(\'.image-blocks\').magnificPopup(\'prev\');return false;"><i class="fa-solid fa-angle-left"></i></button>' +
                        "</div>" +
                        '<div class="dots">' +
                        '<div class="dots-container" style="display: flex; overflow-x: auto;">'; // Updated class name and added a container div for proper scrolling

                    for (var i = startThumbIndex; i < startThumbIndex + numVisibleThumbs && i < numThumbs; i++) {
                        var $cl_active = "";
                        if (item.index == i) $cl_active = " active"; // Added .active class to the currently active thumbnail
                        var $thumb = $gallery
                            .find("a:eq(" + i + ")")
                            .find("img")
                            .attr("src");
                        $result +=
                            '<div class="dot-item' +
                            $cl_active +
                            '">' +
                            "<button type=\"button\" onclick=\"javascript:$('.image-blocks').magnificPopup('goTo', " +
                            i +
                            ');return false;"><img src="' +
                            $thumb +
                            '" width="50"></button>' +
                            "</div>";
                    }
                    $result += "</div>" + "</div>";

                    if (numThumbs > numVisibleThumbs) {
                        $result +=
                            '<div class="arrow_next">' + '<button type="button" class="next arrow" onclick="javascript:$(\'.image-blocks\').magnificPopup(\'next\');return false;"><i class="fa-solid fa-angle-right"></i></button>' + "</div>";
                    }

                    $result += "</div>";
                }
                return $result;
            },
        },
    });

    $(".openVideo").magnificPopup({
        type: "inline",
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0, 1], // Will preload 0 - before current, and 1 after the current image
        },

        callbacks: {
            open: function () {
                $("html").css("margin-right", 0);
                $("html").addClass("htmlopenvideo");
                $(this.content).find("video")[0].play();
            },
            close: function () {
                $(this.content).find("video")[0].load();
            },
        },
    });


</script>

<?php endif; ?>

<script type="text/javascript"> 

    jQuery(document).ready(function () {
        ImgUpload();
    });

    function ImgUpload() {
        var imgWrap = "";
        var imgArray = [];

        $(".upload__inputfile").each(function () {
            $(this).on("change", function (e) {
                imgWrap = $(this).closest(".upload__box").find(".upload__img-wrap");
                var maxLength = $(this).attr("data-max_length");

                var files = e.target.files;
                var filesArr = Array.prototype.slice.call(files);
                var iterator = 0;
                filesArr.forEach(function (f, index) {
                    if (!f.type.match("image.*")) {
                        return;
                    }

                    if (imgArray.length > maxLength) {
                        return false;
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
                                var html =
                                    "<div class='upload__img-box'><div style='background-image: url(" +
                                    e.target.result +
                                    ")' data-number='" +
                                    $(".upload__img-close").length +
                                    "' data-file='" +
                                    f.name +
                                    "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                                imgWrap.append(html);
                                iterator++;
                            };
                            reader.readAsDataURL(f);
                        }
                    }
                });
            });
        });

        $("body").on("click", ".upload__img-close", function (e) {
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

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#imagePreview").css("background-image", "url(" + e.target.result + ")");
                $("#imagePreview").hide();
                $("#imagePreview").fadeIn(650);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imageUpload").change(function () {
        readURL(this);
    });

    $(".image-slider").slick();

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

<script src="<?php echo BASE_URL; ?>customjs/myjs.js?var=<?php echo time() ?>"></script>

<?php if(isset($_SESSION)): ?>
<script>
    // $(document).ready(function(){
    //   let ajaxCall          = true,
    //       notificationplay  = 0,
    //       currentURL        = window.location.href,
    //       user_ID,
    //       jobId;



    //     if (currentURL.includes("my-posted-jobs-details")) {
    //         let urlCons   = new URLSearchParams(window.location.search);
    //             jobId     = urlCons.get("job_id");
    //         let URLs      = $('.userpf-link').attr('href');
    //         let urlParams = new URLSearchParams(URLs.split('?')[1]);
    //             user_ID   = urlParams.get('u_id');
    //     }

    //     if (currentURL.includes("user-profile")) {
    //         let urlParams   = new URLSearchParams(window.location.search);
    //             jobId       = urlParams.get("job_id");
    //             user_ID     = urlParams.get('u_id');
    //     }


    //   if(ajaxCall === true) {
    //     ajaxCall = false;
        
    //     setInterval(function(e){

    //         $.ajax({
    //             url:"serverside/post.php",
    //             method:"post",
    //             data:{
    //                 func:113,
    //                 url: currentURL,
    //                 userid: user_ID,
    //                 jobid: jobId
    //             },
    //             success:function(data){

    //                 ajaxCall = true;
    //                 data = JSON.parse(data);
    //                 if(data.newmsgcount > 0){
    //                   let msgdot = '<span style="" class="bg-danger position-absolute text-white rounded-circle px-1 my-ac">'+data.newmsgcount+'</span>'
    //                   $('.account.w-dropdown ').removeClass('notice-on').addClass('notice-on');
    //                   $('.text-block-2.account span').remove();
    //                   $('.text-block-2.account').append(msgdot);
    //                   $('#chatmenulink span').remove();
    //                   $('#chatmenulink').append('<span style="top: 10px;right: 15px;font-size: 15px;font-size: 12px; height: 18px!important;width: 14px!important;" class="bg-danger position-absolute text-white rounded-circle px-1">'+data.newmsgcount+'</span>');
    //                 } else {
    //                   $('.text-block-2.account span').remove();
    //                   $('#chatmenulink span').remove();
    //                 }

    //                 if(data.newsmgoftradprsn > 0){
    //                   let envelop = '<span style="top:3px; right: 0; font-size: 10px; width: 14px!important; height: 20px!important;" class="bg-danger text-white position-absolute rounded-circle px-1">'+data.newsmgoftradprsn+'</span>';
    //                   $('.chatenvelop span').remove();
    //                   $('.chatenvelop').append(envelop);

    //                 }


    //             }
    //         });
    //     },1500);

    //   }
    // });

</script>

<?php endif; ?>
<?php include_once "includes/postajob.php"?>

</html>
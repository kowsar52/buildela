$(document).ready(function() {
    $("continue-btn0").show();
    $("#question-1").hide();
    $("#question-2").hide();
    $("#question-3").hide();
    $("#continue-btn1").hide();
    $("#continue-btn2").hide();
    // $(".continue-btn3").hide();
    $("#LoginForm1").hide();
    $("#NewSignupForm").hide();
    $("#addsignupform").hide();



    $("#continue-btn0").click(function(){
        $(this).hide();
        $("#question-1").show();
        $("#continue-btn1").show();
    });
    $("#continue-btn1").click(function(){
        $(this).hide();
        $("#question-2").show();
        $("#continue-btn2").show();
    });
    $("#continue-btn2").click(function(){
        $(this).hide();
        $("#question-3").show();
        $(".continue-btn3").show();
    });


    // $("#continue-btn1").click(function(){
    //    this.hide();
    //    $("#question-1").hide();
    //    $("#question-2").show();
    //    $("#continue-btn-2").show();
    // });    
});



$(document).ready(function () {
    //toggle the component with class accordion_body
    $(".accordion_head").click(function () {
        if ($('.accordion_body').is(':visible')) {
            $(".accordion_body").slideUp(300);
            $(".plusminus").text('+');
        }
        if ($(this).next(".accordion_body").is(':visible')) {
            $(this).next(".accordion_body").slideUp(300);
            // $(this).children(".plusminus").innerHTML('+');
        } else {
            $(this).next(".accordion_body").slideDown(300);
            $(this).find(".plusminus")[0].innerText = "-"
        }
    });
});

$(document).ready(function () {
    $("#edit-whole-wrapper").hide();
    $('#fa-icon-rotate').toggleClass('rotate-reset');
    $("#edit-1").click(function (e) {
        e.preventDefault();
        $("#edit-whole-wrapper").slideToggle(200);
        $('#fa-icon-rotate').toggleClass('rotate');

    });
});



$('.single-item-index').slick({
    dots: true,
    infinite: true,
    speed: 300,
    arrows:true,
    autoplay:true,
    autoplaySpeed:2000,
});

$('.single-item').slick({
    dots: true,
    infinite: true,
    speed: 300,
    arrows:true,
    autoplay:true,
    autoplaySpeed:2000,
});

$('.card-slider').slick({
    dots: true,
    infinite: true,
    speed: 300,
    autoplay:true,
    autoplaySpeed:3000,
    slidesToShow: 4,
    slidesToScroll: 1,
    responsive: [
        {
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
    ]
});


$('.tradespeople').slick({
    dots: false,
    infinite: true,
    speed: 300,
    slidesToShow: 4,
    slidesToScroll: 1,
    responsive: [
        {
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }

    ]
});

// var element = document.getElementById("six-fraction");
// element.style.display = "none";


function openModal() {
    document.body.classList.add('modal-open');
    var element = document.getElementById("six-fraction");
    element.style.display = "block";
    document.getElementById("my-mobile-modal").style.width = "100%";	 
}

function openmbui(){
	document.body.classList.add('modal-open-mb');
}

function closeNav() {
	document.body.classList.remove('modal-open-mb');
    document.getElementById("my-mobile-modal").style.width = "0";
}




$("#post-a-job-new-card-one").show();
$("#post-a-job-new-card-two").hide();
$("#post-a-job-new-card-three").hide();

$("#new-back-btn-1").click(function(e){
    e.preventDefault();
    $("#post-a-job-new-card-one").show();
    $("#post-a-job-new-card-two").hide();
    $("#post-a-job-new-card-three").hide();
});

$("#new-back-btn-2").click(function(e){
    e.preventDefault();
    $("#post-a-job-new-card-one").show();
    $("#post-a-job-new-card-two").hide();
    $("#post-a-job-new-card-three").hide();
});
$("#new-back-btn-3").click(function(e){
    e.preventDefault();

    if(whereGoBack==1){

        $("#post-a-job-new-card-one").show();
        // $("#post-a-job-new-card-two").hide();
        $("#question-3").hide();
        $("#post-a-job-new-card-three").hide();

    }else{

        $("#post-a-job-new-card-one").hide();
        // $("#post-a-job-new-card-two").hide();
        $("#question-3").hide();
        $("#post-a-job-new-card-three").show();
    }


});

function goback1(e){
    e.preventDefault();
    $("#post-a-job-new-card-one").hide();
    $("#post-a-job-new-card-two").hide();
    $("#post-a-job-new-card-three").hide();
    $("#addsignupform").hide();
    $("#notLoginButton").show();
    $("#question-3").show();

}
function goback2(e){
    e.preventDefault();
    $("#post-a-job-new-card-one").hide();
    $("#post-a-job-new-card-two").hide();
    $("#post-a-job-new-card-three").hide();
    $("#question-3").hide();
    $("#LoginForm1").hide();
    $("#addsignupform").show();
}
function goback3(e){
    e.preventDefault();
    $("#post-a-job-new-card-one").hide();
    $("#post-a-job-new-card-two").hide();
    $("#question-3").hide();
    $("#post-a-job-new-card-three").hide();
    $("#NewSignupForm").hide();
    $("#addsignupform").show();
}

// window.addEventListener('beforeunload', function(event) {
//     event.preventDefault();
//     event.returnValue = '';
//     $.ajax({
//         url:"serverside/post.php",
//         method:"post",
//         data:{
//             func:114
//         },
//         success:function(data){
//             console.log('Logged Out!')
//         }
//     });
// });
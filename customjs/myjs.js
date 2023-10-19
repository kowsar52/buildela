let pattern = /^(((\+44\s?\d{4}|\(?0\d{4}\)?)\s?\d{3}\s?\d{3})|((\+44\s?\d{3}|\(?0\d{3}\)?)\s?\d{3}\s?\d{4})|((\+44\s?\d{2}|\(?0\d{2}\)?)\s?\d{4}\s?\d{4}))(\s?\#(\d{4}|\d{3}))?$/;
let opt_var=0;
let sub_category_var=0;
let whereGoBack=0;

function buildelaEmailvalidator(input, message) {
    var input = $(input);
    var email = input.val();
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (email === '' || emailRegex.test(email)) {
        input.removeClass('fieldError');
        input.next('.textError').remove();
    } else {
        input.addClass('fieldError');
      
        if (!input.next('.textError').length) {
            input.after('<span class="textError">' + message + '</span>');
        }
    }
}

function regexEmailvalidator(input) {
    var email = $(input).val();
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (emailRegex.test(email)) 
    return true;
    else 
    return false;
}

function playMessageSound() {
    var audio = new Audio('uploads/new_message.mp3');
    audio.play();
}

function playNotificationSound() {
    var audio = new Audio('uploads/notification_sound.mp3');
    audio.play();
}


$("#check_post_Code").click(function (e){

    e.preventDefault();
    let post_code=$('#post_code').val();
    var ajax_data = new FormData();
    ajax_data.append("func", '52');
    ajax_data.append('post_code',post_code );
 //alert('This is in test mode')
    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        processData: false,
        contentType: false,
        data:ajax_data,
        success: function (data) {

            if (data.trim() != 200) {
                swal("Invalid postcode", "please enter a valid postcode!", "info");
                $("#post_code").val('');
                $("#post_code").focus();
                return;
            } else {

            }
	
        }//success
    });
});//check_post_Code

$("#skip_btn").click(function (event) {
    event.preventDefault();

    var ajax_data = new FormData();
    //append into ajax data
    ajax_data.append("func", '1');
    ajax_data.append('dbs', $('#dbs')[0].files[0]);
    ajax_data.append('builder1',($('#builder1').is(":checked")?1:0));
    ajax_data.append('builder2',($('#builder2').is(":checked")?1:0));
    ajax_data.append('operat', $("input[name='about_you']:checked").val());
    ajax_data.append('distance',$( "#distance option:selected" ).val());
    ajax_data.append('phone', $('#phone').val());
    ajax_data.append('email', $('#email').val());
    ajax_data.append('fname', $('#fname').val());
    ajax_data.append('lname', $('#lname').val());
    ajax_data.append('pass1', $('#pass1').val());
    ajax_data.append('note', $('#note').val());
    ajax_data.append('from_referral_code', $('#from_referral_code').val());
    ajax_data.append('trading_name', $('#trading_name').val());
    ajax_data.append('work_address', $('#work_address').val());
    ajax_data.append('work_address1', $('#work_address1').val());
    ajax_data.append('town', $('#town').val());
    ajax_data.append('post_code', $('#post_code').val());

    $("#skip_btn").attr("disabled", true);
    $("#skip_btn").html("Please wait...");
    $("#payment_btn").hide();

    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        processData: false,
        contentType: false,
        data:ajax_data,
        success: function (data) {
            if (data.trim() == "true") {
                swal("Register!", "You are registered successfully, please take assesment test on your profile by selecting the category you want!", "success").then((value) => {
                    window.location.href = "welcome";
                });
            } else if (data.trim() == "email-exist") {
                swal("Email Already Registered", "Try with other email", "info");
            } else if (data.trim() == "fill-fields") {
                swal("Missing details", "Kindly fill all the input fields", "info");
            } else {
                swal("Not registered", "Error, try again", "error");
            }
            $("#skip_btn").attr("disabled", false);
            $("#skip_btn").html("Skip");
        }//success
    });//ajax
});//click

$(document).on("click", '#email-btn', function(event) {
    event.preventDefault();

    if ($('#email1').val()=='') {
        swal("Email Missing ", "Kindly Enter Your Email", "info");
        return;
    }

    let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (!emailPattern.test($('#email1').val())) {
        swal("Invalid email format", "", "info");
        return;
    }


    if (regexEmailvalidator('#email1') === false ) {
        buildelaEmailvalidator('#email1', 'Invalid email address!');
        return;
    }

    $("#email-btn").attr("disabled", true);
    $("#email-btn").html("Please wait...");

    var baseURL = window.location.protocol + "//" + window.location.host;

    $.ajax({
        url: baseURL + "/serverside/post.php",
        type: "POST",
        data: {
            func: 40,
            email:$('#email1').val(),
        },
        success: function (data) {

            $("#addsignupform").hide();

            if (data.trim() == "true") {
                swal("Email Already Registered", "Please log in to your account.", "info").then((value) => {
                    $("#LoginForm1").html('');
                    $("#LoginForm1").append(`
                        <form id="login-form1">
                            <h1 class="text-center">Login</h1>
                            <div class="form-group d-none">
                            <label for="email11">Email</label>
                            <input type="email" required value="" class="form-control-lg  form-control" id="email11">
                            </div>
                            <div class="form-group">
                            <label for="pass1">password</label>
                            <input type="password" required class="form-control-lg form-control" id="pass1">
                            </div>
                            <button type = 'submit' id="login-form1_btn" class="login_btn post-a-job-continue-btn btn-block
                                     text-white text-center px-5 py-2 font-weight-bold rounded" >Login</button>
                            <button id="new-back-btn-5" type="button" onclick="goback2(event)" class="text-decoration-none align-items-center border p-2 rounded m-1 btn">
                                     <i class="fa fa-angle-left"></i> Back</button>
                             <a class="forgotpw" href="recover_password">Forgot Password</a>
                        </form>
                    `);
                    $("#email11").val($('#email1').val());
                    $("#LoginForm1").show();
                });

            } else {
                $("#NewSignupForm").html('');
                $("#NewSignupForm").append(`
                    <form id="signup_user1">
                        <h1>Sign up to be a homeowner</h1>
                        <p>Connect with quality, vetted tradespeople, near you. Our services are free.</p>
                        <div class="form-group">
                        <label for="fname">First Name</label>
                        <input type="text" required class="form-control-lg form-control" id="fname">
                       
                        </div>
                        <div class="form-group">
                        
                        <label for="lname">Last Name</label>
                        <input type="text" required class="form-control-lg form-control" id="lname">
                        </div>
                        <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" placeholder="+447222555555" required class="form-control-lg form-control" id="phone1" >
                        </div>
                        <div class="form-group">
                        <label for="pass">Password</label>
                        <input type="text" class="form-control-lg form-control" required id="pass">
                        </div>  
                        <div class="post-a-job-continue-btn-div pt-4"><button type ='button' class="continue-btn3 post-a-job-continue-btn btn-block text-white text-center text-decoration-none rounded" id="email-btn" id="signu_btn1">Submit</button></div>
                        <button id="new-back-btn-6" type="button" onclick="goback3(event)" class="text-decoration-none align-items-center border p-2 rounded m-1 btn">
                        <i class="fa fa-angle-left"></i> Back</button>
                    </form>
                    <input value="0" id="isphoneverifiy" type="hidden">
                `);
                $("#NewSignupForm").show();
            }
            $("#email-btn").attr("disabled", false);
            $("#email-btn").html("Next");
        }
    });
});



$(document).on("click", '#signu_btn1', function(event) {
    event.preventDefault();

    var baseURL = window.location.protocol + "//" + window.location.host;

    if (!pattern.test($("#phone1").val())) {
        swal("Please enter a valid phone number", "");
        return;
    }

    if ($("#phone1").val() != '' && $("#isphoneverifiy").val() == 0) {

        $("#signu_btn1").attr("disabled", true);
        $("#signu_btn1").html("Please wait...");

        $.ajax({
            url: baseURL + "/serverside/post.php",
            type: "POST",
            // async: false,
            data: {
                func: 96,
                phone:$('#phone1').val(),
            },
            success: function (data) {
                data = JSON.parse(data);

                console.log(data);
                
                $("#verification_phone").val($('#phone1').val());

                if (data.success == 'yes') {

                    swal("Success", "We send phone verification code on your phone number", "success").then((value) => {
                        $("#verifiymodal").modal('show');
                        $("#isphoneverifiy").val(0);
                    });

                }else if(data.success == 'no'){

                    swal("Failed","Failed to send verification code, please click resend button.","error");

                }else if(data.exist === 'yes'){
                    
                    postAjob();
                }
                
                $("#signu_btn1").attr("disabled", false);
                $("#signu_btn1").html("Submit");

            }
        });
    }else {

        postAjob();
        
    }

});

function postAjob(){

    var baseURL = window.location.protocol + "//" + window.location.host;

    if ($("#pass").val() == "") {
        swal("Please enter password", "");
        $("#pass").focus();
        return;
    }
    if ($("#fname").val() == "") {
        swal("Please enter first name", "");
        $("#fname").focus();
        return;
    }

    $("#signu_btn1").attr("disabled", true);
    $("#signu_btn1").html("Please wait...");

    $.ajax({
        url: baseURL + "/serverside/post.php",
        type: "POST",
        data: {
            func: 29,
            fname: $('#fname').val(),
            lname: $('#lname').val(),
            phone: $('#phone1').val(),
            email: $('#email1').val(),
            pass: $('#pass').val(),
        },
        success: function (data) {
            if (data.trim() == "true") {

                var category = $("#search_main_type").val();
                var title = $("#title").val();
                var post_code = $("#post_code").val();
                var location = $("#location").val();
                // var sub_category_id=$("input[name='involve']:checked").val();
                var sub_category_id = sub_category_var;

                var options = $("input[name='opt']checked").val();

                if (options === undefined || options === "undefined" || options === "") {
                    options = 0;
                }
                var loking_to = $("input[name='loking_to']:checked").val();
                var how_learge = $("input[name='how_learge']:checked").val();

                var ajax_data = new FormData();
                //append into ajax data
                ajax_data.append("func", '11');
                ajax_data.append('main_type', $("#search_main_type").val());
                // ajax_data.append('sub_type',$("input[name='involve']:checked").val());
                // ajax_data.append('options',$("input[name='opt']").val());
                ajax_data.append('sub_type', sub_category_var);
                ajax_data.append('options', opt_var);
                ajax_data.append('title', $("#title").val());
                ajax_data.append('post_code', $("#post_code").val());
                ajax_data.append('country', $("#country").val());
                ajax_data.append('note', $('textarea#note').val());
                // ajax_data.append('img1', $('#images').files[0]);
                var totalfiles = document.getElementById('images').files.length;
                // console.log("files length: "+totalfiles);
                for (var index = 0; index < totalfiles; index++) {
                    ajax_data.append("files[]", document.getElementById('images').files[index]);
                }
                $.ajax({
                    url: baseURL + "/serverside/post.php",
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data: ajax_data,

                    success: function (data) {
                        var id;
                        newdata = data.split("-");
                        id = newdata[0];
                        data = newdata[1];


                        if (data.trim() == "true") {
                            swal("Job Posted", "Your job posted successfully!", "success").then((value) => {
                                window.location.href = baseURL + "/thank-you?id=" + id;

                            });

                        } else {
                            swal("Failed to post job", "Job not posted kindly try again", "error");
                        }
                        $("#signu_btn1").attr("disabled", false);
                        $("#signu_btn1").html("Submit");
                    }//success
                });

            } else if (data.trim() == "email-exist") {
                swal("Email Already Registered", "You are already a member, Kindly login", "info").then((value) => {
                    window.location.href = baseURL + "/login";
                });
            } else if (data.trim() == "fill-fields") {
                swal("Missing details", "Kindly fill all the input fields", "info");
            } else {
                swal("Not registered", "Your are not registered try again", "error");
            }
            $("#signu_btn1").attr("disabled", false);
            $("#signu_btn1").html("Submit");
        }//success
    });
}




function uploadImg(){
    var ajax_data = new FormData();
    //append into ajax data
    ajax_data.append("func", '2');
    ajax_data.append('uid',$('#userId').val());
    ajax_data.append('img1', $('#imageUpload')[0].files[0]);

    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        processData: false,
        contentType: false,
        data:ajax_data,
        success: function (data) {
            if (data.trim() == "true") {
                // swal("Uploaded Successfully", "Thanks for uploading image,", "success").then((value) => {
                location.reload();
                // });
            }
            else {
                swal("Not Uploaded", "Image not Uploaded,try again ", "error");

            }
        }
    });
}




$("#updateUserInfo").submit(function (event) {
    event.preventDefault();
    var operat=$("input[name='about_you']:checked").val();
    var distance=$( "#distance option:selected" ).val();

    if (!pattern.test($("#phone").val())) {
        swal("Phone format not Match", "", "info");
        return;
    }
    var dbs=$( "#dbs_option option:selected" ).val();

    if(dbs==1){
        var len = document.getElementById('dbs').files.length;
        if(len<=0){

            swal("DBS Certificate is missing", "", "info").then((result) => {

            });

            return;

        }

    }


    let post_code=$('#post_code').val();
    var ajax_data = new FormData();
    ajax_data.append("func", '52');
    ajax_data.append('post_code',post_code );
    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        processData: false,
        contentType: false,
        data:ajax_data,
        success: function (data) {

            if(data.trim()!=200){
                swal("Invalid postcode", "please enter a valid postcode!", "info");
                $("#post_code").val('');
                $( "#post_code" ).focus();
                return;
            }else {


                var ajax_data = new FormData();
                //append into ajax data
                ajax_data.append("func", '3');
                ajax_data.append('dbs', $('#dbs')[0].files[0]);
                ajax_data.append('operat', operat);
                ajax_data.append('distance',distance);
                ajax_data.append('id', $('#userid').val());
                ajax_data.append('phone', $('#phone').val());
                ajax_data.append('email', $('#email').val());
                ajax_data.append('fname', $('#fname').val());
                ajax_data.append('trading_name', $('#trading_name').val());
                ajax_data.append('company_name',  $('#company_name').val());
                ajax_data.append('company_number', $('#company_number').val());
                ajax_data.append('work_address', $('#work_address').val());
                ajax_data.append('town', $('#town').val());
                ajax_data.append('post_code', $('#post_code').val());
                ajax_data.append('note', $('textarea#note').val());

                $.ajax({

                    url: "serverside/post.php",
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data:ajax_data,
                    success: function (data) {
                        if (data.trim() == "true") {

                            swal("Profile Updated", "You are profile updated successfully!", "success").then((value) => {
                                window.location.reload;
                            });

                        } else if (data.trim() == "email-exist") {
                            swal("Email Already Registered ", "Try with other email", "info");
                        } else {
                            swal("Not Updated", "Your profile not updated try again", "error");
                        }
                    }
                });

            }//else
        }//check post success

    });//check post code ajax

});//update profile
// //update password
$("#updatePassword").submit(function (event) {
    event.preventDefault();
    var oldpass = $('#old_pass').val();
    var newpass = $('#new_pass').val();
    var confirmpass = $('#c-pass').val();

    if (newpass != confirmpass) {
        swal("Error", "Your password don't match, please check!", "info");
        return;
    } else {
        $.ajax({
            url: "serverside/post.php",
            type: "POST",
            data: {
                func: 4,
                oldpass: oldpass,
                newpass: newpass,
                confirmpass: confirmpass,
                userid: $("#users_id").val(),
            },
            success: function (data) {
                if (data.trim() == "true") {
                    swal("Updated Successfully", "Password updated successfully!", "success");
                } else {
                    swal("Not Updated", "Password not updated, try again!", "error");

                }
            }
        });
    }
});
$("#workform").submit(function (event) {
    event.preventDefault();

    if($("textarea#work_area").val()===''){

        swal("Enter Working Area", "", "info");
        return;
    }

    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        data: {
            func: 5,
            work_area:$("textarea#work_area").val(),
            userid: $("#userid").val(),
        },
        success: function (data) {

            if (data.trim() == "true") {
                swal("Updated Successfully", "Working area Updated Successfully!", "success").then((result)=>{
                    window.location.reload;
                });
            } else {
                swal("Not Updated", "Your Working area not updated, try again!", "error");

            }
        }
    });


});

//login
$("#login-form").submit(function (event) {
    event.preventDefault();
    if($("#email").val()==''||$("#pass").val()==''){
        swal("Missing details", "Enter Email and Password,kindly try again", "error");
        return
    }
    $(".login_btn").attr("disabled", true);
    $(".login_btn").html("Please wait...");

    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        data: {
            func: 6,
            email: $("#email").val(),
            password: $("#pass").val()
        },
        success: function (data) {
            if (data.trim() == "true") {
                window.location.href = "my-posted-jobs";
			}else if(data.trim() == "jobs_person"){
				window.location.href = "/leads";   					   
            }else if(data.trim() == "admin"){
                window.location.href = "./admin/";
            }else if(data.trim() == "blocked"){
                $( "#email" ).val("");
                $( "#pass" ).val("");

                swal("Blocked", "You are blocked by admin", "error");
            }else {
                $( "#email" ).val("");
                $( "#pass" ).val("");
                swal("Invalid details", "Check your email and password!", "error");
            }//else
            $(".login_btn").attr("disabled", false);
            $(".login_btn").html("Submit");

        }//success

    });//ajax

});

//login1
$(document).on("click", '#login-form1_btn',function (event) {
    event.preventDefault();

    if($("#email11").val()==''||$("#pass1").val()==''){
        swal("Missing details", "Enter Email and Password,kindly try again", "error");
        return;
    }

    var baseURL = window.location.protocol + "//" + window.location.host;

    $.ajax({
        url: baseURL + "/serverside/post.php",
        type: "POST",
        data: {
            func: 6,
            email: $("#email11").val(),
            password: $("#pass1").val()
        },
        success: function (data) {
            if (data.trim() == "true") {

                var ajax_data = new FormData();
                //append into ajax data
                ajax_data.append("func",'11');
                ajax_data.append('main_type',$("#search_main_type").val());
                ajax_data.append('sub_type',sub_category_var);
                // ajax_data.append('options',$("input[name='opt']:checked").val());
                ajax_data.append('options',opt_var);

                ajax_data.append('title',$("#title").val());
                ajax_data.append('post_code',$("#post_code").val());
                ajax_data.append('note',$('textarea#note').val());
                var totalfiles = document.getElementById('images').files.length;
                // console.log("files length: "+totalfiles);
                for (var index = 0; index < totalfiles; index++) {
                    ajax_data.append("files[]", document.getElementById('images').files[index]);
                }

                $.ajax({
                    url: baseURL + "/serverside/post.php",
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data:ajax_data,
                    success: function (data) {

                        var id;
                        newdata =data.split("-");
                        id=newdata[0];
                        data=newdata[1];

                        if (data.trim() == "true") {
                            swal("Job Posted", "Your job posted successfully!", "success").then((value) => {
                                window.location.href = baseURL + "/thank-you?id="+id;
                            });
                        }else {
                            swal("Job Not Posted", "Your job is not posted, kindly try again", "error");
                        }
                    }
                });

            } else if(data.trim() == "blocked") {
                swal("Blocked", "You are blocked by admin", "error");
            } else {
                swal("Invalid details", "Check your email and password!", "error");
            }
        }
    });
});




function blockUser(id) {
    swal({
        title: 'Are you sure to block this user?',
        icon: 'info',
        buttons: true,
        dangerMode: true,
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result) {
            $.ajax({
                url: "../serverside/post.php",
                type: "POST",
                data: {
                    func: 7,
                    id: id,
                },
                success: function (data) {

                    if (data.trim() == "true") {
                        swal({
                            icon: 'success',
                            title: 'success',
                            text: 'User block successfully!',
                        }).then((result) => {
                            location.reload();
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to block user!'
                        });
                    }
                }//success
            });//ajax
        }
    });
}//block user
function activeUser(id) {
    swal({
        title: 'Are you sure to active this user?',
        icon: 'info',
        buttons: true,
        dangerMode: true,
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result) {
            $.ajax({
                url: "../serverside/post.php",
                type: "POST",
                data: {
                    func: 8,
                    id: id,
                },
                success: function (data) {

                    if (data.trim() == "true") {
                        swal({
                            icon: 'success',
                            title: 'success',
                            text: 'User active successfully!',
                        }).then((result) => {
                            location.reload();
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to active user!'
                        });
                    }
                }//success
            });//ajax
        }

    });
}//active user


$("#recoverPassword").submit(function (event) {

    event.preventDefault();
    var email = $('#email').val();

    $(".password_recover_btn").attr("disabled",true);
    $(".password_recover_btn").html("Please wait...");

    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        data: {
            func: 9,
            email: email,
        },
        success: function (data) {

            if (data.trim() == "true") {
                swal("Recover Password", "We've sent recover token on your email!", "success").then((value) => {
                    window.location.href = "index";
                });

            } else {
                swal("Password Not Recover", "Check your email, and try again!", "error");

            }
            $(".password_recover_btn").attr("disabled",false);
            $(".password_recover_btn").html("Recover");
        }//success

    });//ajax

});

$("#setnewpass").submit(function (event) {
    event.preventDefault();
    var password = $('#pass1').val();
    var c_password = $('#c_pass').val();
    var reset_token=$("#reset_Code").val();
    if (password != c_password) {
        swal("Error", "Your password don't match, please check!", "info");
        return;
    } else {

        $(".set_password_btn").attr("disabled", true);
        $(".set_password_btn").html("Please wait...");
        $.ajax({
            url: "serverside/post.php",
            type: "POST",
            data: {
                func: 10,
                password: password,
                reset_code: reset_token,
            },
            success: function (data) {

                if (data.trim() == "true") {
                    swal("Updated Successfully", "Password updated successfully!", "success").then((value) => {
                        window.location.href = "login";
                    });
                } else if (data.trim() == "Token not found") {

                    swal("Token not found", "Check your email, and try again!", "error");
                } else {
                    swal("Not Updated", "Check your token and try again!", "error");

                }
                $(".set_password_btn").attr("disabled", false);
                $(".set_password_btn").html("Update");
            }//success
        });//ajax


    }//else
});

$("#post_job").submit(function (event) {

    event.preventDefault();

    if ($("#title").val()=='') {
        swal("Job Posting", "Error - Job post code missing. Please provide the required information to post a job.", "info");
        $( "#title" ).focus();
        return;
    }

    if($("#post_code").val()==''){
        swal("Job Posting", "Error - Job post code missing. Please provide the required information to post a job.", "info");
        $( "#post_code" ).focus();
        return;

    }


    if($("#country").val()==''){
        swal("Country Missing", "Select a country please.", "info");
        $( "#country" ).focus();
        return;
    }

    if($('textarea#note').val()==''){
        swal("Job discription is missing", "", "info");
        $( "#note" ).focus();
        return;
    }


    $(".continue-btn3").attr("disabled", true);
    $(".continue-btn3").html("Please wait...");

    let post_code=$('#post_code').val().toUpperCase();
    var ajax_data = new FormData();
    ajax_data.append("func", '52');
    ajax_data.append('post_code',post_code );

    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        processData: false,
        contentType: false,
        data:ajax_data,
        success: function (data) {

            if(data.trim()!=200){
                swal("Invalid Postcode", "Please enter a valid postcode.", "info");
                $("#post_code").val('');
                $( "#post_code" ).focus();

                $(".continue-btn3").attr("disabled", false);
                $(".continue-btn3").html("POST");
                return;
            }else {
                var ajax_data = new FormData();
                //append into ajax data
                ajax_data.append("func",'11');
                // ajax_data.append('main_type',$("#select_category option:selected" ).val());
                ajax_data.append('main_type',$("#search_main_type").val());
                ajax_data.append('sub_type',sub_category_var);
                // ajax_data.append('options',$("input[name='opt']:checked").val());
                ajax_data.append('options',opt_var);

                ajax_data.append('title',$("#title").val());
                ajax_data.append('post_code',$("#post_code").val());
                ajax_data.append('note',$('textarea#note').val());
                // ajax_data.append('img1', $('#images').files[0]);
                var totalfiles = document.getElementById('images').files.length;
                // console.log("files length: "+totalfiles);
                for (var index = 0; index < totalfiles; index++) {
                    ajax_data.append("files[]", document.getElementById('images').files[index]);
                }

                $.ajax({
                    url: "serverside/post.php",
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data:ajax_data,
                    success: function (data) {

                        var id;
                        newdata =data.split("-");
                        id=newdata[0];
                        data=newdata[1];
                        if (data.trim() == "true") {
                            swal("Job Posted", "Your job has been posted successfully.", "success").then((value) => {
                                window.location.href = "thank-you?id="+id;
                            });
                        }else {
                            swal("Job Not Posted", "Your job is not posted,kindly try again", "error");
                        }
                        $(".continue-btn3").attr("disabled", false);
                        $(".continue-btn3").html("POST");
                    }//success
                });//ajax


            }//else
            $(".continue-btn3").attr("disabled", false);
            $(".continue-btn3").html("POST");
        }//succes of postcode check
    });//post_code check ajax


});

function deleteMainCategory(id) {

    swal({
        title: 'Are you sure?',
        icon: 'info',
        buttons: true,
        dangerMode: true,
    }).then((result) => {

        if (result) {
            $.ajax({
                url: "../serverside/post.php",
                type: "POST",
                data: {
                    func: 12,
                    id: id,
                },
                success: function (data) {

                    if (data.trim() == "true") {
                        swal({
                            icon: 'success',
                            title: 'success',
                            text: 'Category delete successfully!',
                        }).then((result) => {
                            // location.reload();
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to delete!'
                        });
                    }
                }//success
            });//ajax
        }
    });
}

function deleteBlogCategory(id) {

    swal({
        title: 'Are you sure?',
        icon: 'info',
        buttons: true,
        dangerMode: true,
    }).then((result) => {

        if (result) {
            $.ajax({
                url: "../serverside/post.php",
                type: "POST",
                data: {
                    func: 119,
                    id: id,
                },
                success: function (data) {

                    if (data.trim() == "true") {
                        swal({
                            icon: 'success',
                            title: 'success',
                            text: 'Blog Category delete successfully!',
                        }).then((result) => {
                            location.reload();
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to delete!'
                        });
                    }
                }//success
            });//ajax
        }
    });
}



function deleteSubCategory(id) {

    swal({
        title: 'Are you sure?',
        icon: 'info',
        buttons: true,
        dangerMode: true,
    }).then((result) => {

        if (result) {
            $.ajax({
                url: "../serverside/post.php",
                type: "POST",
                data: {
                    func: 13,
                    id: id,
                },
                success: function (data) {

                    if (data.trim() == "true") {
                        swal({
                            icon: 'success',
                            title: 'success',
                            text: 'Category delete successfully!',
                        }).then((result) => {
                            // location.reload();
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to delete!'
                        });
                    }
                }//success
            });//ajax
        }
    });
}
function deletearea(id) {

    swal({
        title: 'Are you sure?',
        icon: 'info',
        buttons: true,
        dangerMode: true,
    }).then((result) => {

        if (result) {
            $.ajax({
                url: "../serverside/post.php",
                type: "POST",
                data: {
                    func: 130,
                    id: id,
                },
                success: function (data) {

                    if (data.trim() == "true") {
                        swal({
                            icon: 'success',
                            title: 'success',
                            text: 'Area delete successfully!',
                        }).then((result) => {
                             location.reload();
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to delete!'
                        });
                    }
                }//success
            });//ajax
        }
    });
}
function deletservicea(id) {

    swal({
        title: 'Are you sure?',
        icon: 'info',
        buttons: true,
        dangerMode: true,
    }).then((result) => {

        if (result) {
            $.ajax({
                url: "../serverside/post.php",
                type: "POST",
                data: {
                    func: 131,
                    id: id,
                },
                success: function (data) {

                    if (data.trim() == "true") {
                        swal({
                            icon: 'success',
                            title: 'success',
                            text: 'Service delete successfully!',
                        }).then((result) => {
                             location.reload();
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to delete!'
                        });
                    }
                }//success
            });//ajax
        }
    });
}

$("#main_area_form").submit(function (event) {
    event.preventDefault();


    var formData = new FormData();
    formData.append('func', 141);
    formData.append('name', $('#area_name').val());


    $.ajax({
        url: "../serverside/post.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {

            if (data.trim() == "true") {
                swal("Add Successfully", "Your area added", "success").then((value) => {
                    $("#mainareaForm" ).hide();
                    location.reload();
                    $('#area_name').val("")
                });
            } else if (data.trim() == "fill-fields") {
                swal("Missing details", "Kindly fill the input fields", "info");
            }
            else {
                swal("Not added", "Kindly Resubmit", "error");

            }
        }
    });
});

$("#main_service_form").submit(function (event) {
    event.preventDefault();

    len=document.getElementById('image').files.length;
    if(len<=0){
        swal("Cover image is missing","","info");
        return;
    }
    
    var formData = new FormData();
    formData.append('func', 140);
    formData.append('name', $('#service_name').val());
    formData.append('image', $('#image')[0].files[0]);

    $.ajax({
        url: "../serverside/post.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {

            if (data.trim() == "true") {
                swal("Add Successfully", "Your service added", "success").then((value) => {
                    $("#mainareaForm" ).hide();
                     location.reload();
                    $('#area_name').val("")
                });
            } else if (data.trim() == "fill-fields") {
                swal("Missing details", "Kindly fill the input fields", "info");
            }
            else {
                swal("Not added", "Kindly Resubmit", "error");

            }
        }
    });
});

$("#mian_category_form").submit(function (event) {
    event.preventDefault();

    $.ajax({
        url: "../serverside/post.php",
        type: "POST",
        data: {
            func: 14,
            name:$('#main_category_name').val(),

        },
        success: function (data) {

            if (data.trim() == "true") {
                swal("Add Successfully", "Your Category added", "success").then((value) => {
                    $("#mainCategoryForm" ).hide();
                    // location.reload();
                    $('#main_category_name').val("")
                });
            } else if (data.trim() == "fill-fields") {
                swal("Missing details", "Kindly fill the input fields", "info");
            }
            else {
                swal("Not added", "Kindly Resubmit", "error");

            }
        }
    });

});

$("#subCategory").submit(function (event) {
    event.preventDefault();
    var type=$( "#select_category option:selected" ).val();

    $.ajax({
        url: "../serverside/post.php",
        type: "POST",
        data: {
            func: 15,
            name:$('#sub_category_name').val(),
            index:$('#sub_category_index').val(),
            type:type,

        },
        success: function (data) {
            console.log(data)

            if (data.trim() == "true") {
                swal("", "Category added  successfully", "success").then((value) => {
                    $("#subCategoryForm" ).hide();
                    // location.reload();
                    $('#sub_category_name').val("")
                });
            }
            else if (data.trim() == "fill-fields") {
                swal("", "Kindly enter category name", "info");
            }else {
                swal("", "Not added, try again", "error");

            }
        }
    });

});

$("#addoption").submit(function (event) {
    event.preventDefault();
    var type=$( "#select_option option:selected" ).val();
    $.ajax({
        url: "../serverside/post.php",
        type: "POST",
        data: {
            func: 41,
            name:$('#option_name').val(),
            type:type,

        },
        success: function (data) {

            if (data.trim() == "true") {
                swal("", "Option added successfully", "success").then((value) => {
                    $("#optionsForm" ).hide();
                    // location.reload();
                    $('#option_name').val("")
                });
            }
            else if (data.trim() == "fill-fields") {
                swal("", "Enter Option please", "info");
            }else {
                swal("", "Not added, try again", "error");

            }
        }
    });

});


$("#addblogcat").submit(function (event) {
    event.preventDefault();
    var type=$( "#select_blog_type option:selected" ).val();
    $.ajax({
        url: "../serverside/post.php",
        type: "POST",
        data: {
            func: 118,
            name:$('#blog_cat_name').val(),
            type:type,

        },
        success: function (data) {

            if (data.trim() == "true") {
                swal("", "Blog Category added successfully", "success").then((value) => {
                    $("#optionsForm" ).hide();
                    location.reload();
                    $('#blog_cat_name').val("")
                });
            }
            else if (data.trim() == "fill-fields") {
                swal("", "Enter Blog Category please", "info");
            }else {
                swal("", "Not added, try again", "error");

            }
        }
    });

});

function setvalueofsearch(value){

    $("#search_main_type1").val(value);
    $("#search_main_type1").keyup();
}

function setSubCategory(mainId,id) {
    // e.preventDefault();

    var selectedID=id.trim();
    var mainID=mainId.trim();
    $("#search_main_type").val(mainID);
    setOptions(selectedID);




    // if(selectedID==''){
    //     swal("Select Category", "Please Select main category", "info").then((value) => {
    //         location.reload();
    //     });
    // }
    // $.ajax({
    //     url: "serverside/post.php",
    //     type: "POST",
    //     data: {
    //         func: 16,
    //         selectedID:selectedID,
    //     },
    //     success: function (data) {
    //         var mydata = JSON.parse(data);
    //         if (data.trim() == "false") {
    //             swal("Not Found ", "Not found any sub category for this main category", "error").then((value) => {
    //             });
    //         }else {
    //             $('#checkboxs').html('');
    //             // $('#checkboxs').append(`<h1>Your job involve</h1>`);
    //             $("#what_need").text('What do you need a '+name+' to help with?')
    //             for(let i = 0; i <mydata.length ; i++){
    //                 $('#checkboxs').append(`
    //                    <label class="radio-btn rounded">
    //                             <input type="radio" onclick="setOptions(${mydata[i].id});" name="involve" id="${mydata[i].id}" value="${mydata[i].id}" class="card-input-element" />
    //                             <div class="panel panel-default card-input p-2 d-flex flex-wrap align-items-center justify-content-between">
    //                                 <div>
    //                                     ${mydata[i].category_name}
    //                                 </div>
    //                                 <i class="fa fa-angle-right"></i>
    //                                 </div>
    //                         </label>`);
    //             }

    //             $("#post-a-job-new-card-two").show();
    //             $("#post-a-job-new-card-one").hide();
    //             $("#post-a-job-new-card-three").hide();
    //         }
    //     }
    // });
}

function setOptions(sub_category_id) {

    // var selectedID=$("input[name='involve']:checked").val();

    sub_category_var=sub_category_id;

    var baseURL = window.location.protocol + "//" + window.location.host;

    $.ajax({
        url: baseURL + "/serverside/post.php",
        type: "POST",
        data: {
            func: 50,
            selectedID:sub_category_var,
        },
        success: function (data) {
            var mydata = JSON.parse(data);

            if (data.trim() == "false") {
                swal("Not Found ", "Not found any sub category for this main category", "error").then((value) => {

                });
            } else {
                if(mydata.length==0){
                    whereGoBack=1;
                    $("#question-3").show();
                    $("#post-a-job-new-card-three").hide();
                    // $("#post-a-job-new-card-two").hide();
                    $("#post-a-job-new-card-one").hide();
                } else {
                    whereGoBack=0;
                    $('#checkboxs1').html('');
                    // $('#checkboxs1').append(`<h1>Choose a option</h1>`);
                    for (let i = 0; i < mydata.length; i++) {
                        $('#checkboxs1').append(`
                            <label class="radio-btn rounded" >
                                <input type="radio" name="opt"  onclick="showNext(${mydata[i].id},event)" id="${mydata[i].id}" value="${mydata[i].id}" class="card-input-element" />
                                <div class="panel panel-default card-input p-2 d-flex flex-wrap align-items-center justify-content-between">
                                    <div>
                                        ${mydata[i].option}
                                    </div>
                                    <i class="fa fa-angle-right"></i>
                                </div>
                            </label>
                        `);
                    }
                    $("#post-a-job-new-card-three").show();
                    // $("#post-a-job-new-card-two").hide();
                    $("#post-a-job-new-card-one").hide();
                }
            }
        }
    });
}


function showNext(opt_val,e){
    e.preventDefault();
    opt_var=opt_val;


    $("#post-a-job-new-card-three").hide();
    // $("#post-a-job-new-card-two").hide();
    $("#post-a-job-new-card-one").hide();
    $("#question-3").show();
}

$("#contactform1").submit(function (event) {
    event.preventDefault();

    if (!pattern.test($("#phone").val())) {
        swal("Phone format not Match", "", "info");
        return;
    }
    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        data: {
            func: 17,
            name:$('#fname').val(),
            lname:$('#lname').val(),
            phone:$('#phone').val(),
            email:$('#email').val(),
            comment:$('textarea#comment').val(),

        },
        success: function (data) {
            if (data.trim() == "true") {
                swal("Submit Successfully", "Your comment added successfully", "success").then((value) => {
                    location.reload();
                });
            }else {
                swal("Not Submit", "Kindly Resubmit", "error");

            }
        }
    });

});

function deleteJobs(id) {

    swal({
        title: 'Are you sure delete this job?',
        icon: 'info',
        buttons: true,
        dangerMode: true,
    }).then((result) => {

        if (result) {
            $.ajax({
                url: "../serverside/post.php",
                type: "POST",
                data: {
                    func: 18,
                    id: id,
                },
                success: function (data) {

                    if (data.trim() == "true") {
                        swal({
                            icon: 'success',
                            title: 'success',
                            text: 'Job delete successfully!',
                        }).then((result) => {
                            location.reload();
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to delete!'
                        });
                    }
                }//success
            });//ajax
        }
    });
}
function deleteJobsBYOwner(id)  {

    swal({
        title: 'Are you sure to delete this job?',
        icon: 'info',
        buttons: true,
        dangerMode: true,
    }).then((result) => {

        if (result) {
            $.ajax({
                url: "serverside/post.php",
                type: "POST",
                data: {
                    func: 18,
                    id: id,
                },
                success: function (data) {

                    if (data.trim() == "true") {
                        swal({
                            icon: 'success',
                            title: 'success',
                            text: 'Job delete successfully!',
                        }).then((result) => {
                            location.reload();
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to delete!'
                        });
                    }
                }//success
            });//ajax
        }
    });
}

$("#questionform").submit(function (event) {

    event.preventDefault();
    var main_type=$( "#select_main_category option:selected" ).val();
    // var sub_type=$( "#select_sub_category option:selected" ).val();


    $.ajax({
        url: "../serverside/post.php",
        type: "POST",
        data: {
            func: 19,
            question:$('#question1').val(),
            option1:$('#option1').val(),
            option2:$('#option2').val(),
            option3:$('#option3').val(),
            option4:$('#option4').val(),
            ans:$('#ans').val(),
            main_type:main_type,
            // sub_type:sub_type,

        },
        success: function (data) {

            if (data.trim() == "true") {
                swal("Add Successfully", "Your Question added", "success").then((value) => {
                    // location.reload();
                    $("#subCategoryForm1" ).hide();
                });
            }else if (data.trim() == "fill-fields") {
                swal("Missing details", "Kindly fill all the input fields", "info");
            }else {
                swal("Not added", "Kindly add again", "error");

            }
        }
    });

});

function deleteQuestion(id) {

    swal({
        title: 'Are you sure?',
        icon: 'info',
        buttons: true,
        dangerMode: true,
    }).then((result) => {

        if (result) {
            $.ajax({
                url: "../serverside/post.php",
                type: "POST",
                data: {
                    func: 20,
                    id: id,
                },
                success: function (data) {

                    if (data.trim() == "true") {
                        swal({
                            icon: 'success',
                            title: 'success',
                            text: 'Question delete successfully!',
                        }).then((result) => {
                            // location.reload();
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to delete!'
                        });
                    }
                }//success
            });//ajax
        }
    });
}

$("#editquestionform").submit(function (event) {

    event.preventDefault();

    var type=$( "#select_category1e option:selected" ).val();
    $.ajax({
        url: "../serverside/post.php",
        type: "POST",
        data: {
            func: 21,
            q_id:$('#q_id').val(),
            question:$('#questione').val(),
            option1:$('#option1e').val(),
            option2:$('#option2e').val(),
            option3:$('#option3e').val(),
            option4:$('#option4e').val(),
            ans:$('#anse').val(),
            type:type,

        },
        success: function (data) {
            if (data.trim() == "true") {
                swal("Edit Successfully", "Your Question Edit", "success").then((value) => {
                    location.reload();
                });
            }else {
                swal("Not Edit", "Kindly try again", "error");

            }
        }
    });

});

$("#select_main_category").change(function (event) {
    event.preventDefault();

    var selectedID=$( "#select_main_category option:selected" ).val();
    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        data: {
            func: 16,
            selectedID:selectedID,

        },
        success: function (data) {

            var mydata = JSON.parse(data);

            if (data.trim() == "false") {
                swal("Not Found ", "Not found any sub category for this mian category", "error").then((value) => {
                });
            }else {

                $('#select_sub_category').html('');
                $('#select_sub_category').append(`
                 <optio>Please Select</option>
                 `);
                for(let i = 0; i <mydata.length ; i++){
                    $('#select_sub_category').append(`
                        <option value="${mydata[i].id}">${mydata[i].category_name}</option>
                        `);

                }
                $("#subCategoryForm").show();
                $("#checkskill").show();

            }
        }
    });
});



$("#checkskill").click(function (event) {
    event.preventDefault();

    var selectedID=$( "#select_main_category option:selected" ).val();
    if (selectedID!=null) {
        $.ajax({
            url: "serverside/post.php",
            type: "POST",
            data: {
                func: 24,
                selectedID:selectedID,

            },
            success: function (data) {

                if (data.trim() == "false") {
                    Swal.fire({
                        title: 'Not Found',
                        text: 'Not found any category',
                        icon: 'error'
                    }).then((value) => {
                        // Your code here if needed
                    });


                }else if (data.trim() == "cross_limit") {
                    Swal.fire({
                        title: 'You are already registered under 5 trades',
                        icon: 'info'
                    }).then((value) => {
                        // Your code here if needed
                    });

                }else if (data.trim() == "verify") {
                   Swal.fire({
                       title: 'You are already registered under this trade',
                       icon: 'info'
                   }).then((value) => {
                       // Your code here if needed
                   });

                }else {
                    var mydata = JSON.parse(data);
                    var id=mydata[0]['id'];

                    var url = "quiz?main_Category_id="+id;

                    window.location.href=url;

                }
            }
        });
    }else
    {
        Swal.fire({
            title: 'Please Select',
            text: 'Please select a category',
            icon: 'info'
        }).then((value) => {
            // Your code here if needed
        });

    }
});
function deleteScore(id) {

    swal({
        title: 'Are you sure?',
        icon: 'info',
        buttons: true,
        dangerMode: true,
    }).then((result) => {

        if (result) {
            $.ajax({
                url: "serverside/post.php",
                type: "POST",
                data: {
                    func: 26,
                    id: id,
                },
                success: function (data) {

                    if (data.trim() == "true") {
                        swal({
                            icon: 'success',
                            title: 'success',
                            text: 'Score delete successfully!',
                        }).then((result) => {
                            location.reload();
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to delete!'
                        });
                    }
                }//success
            });//ajax
        }
    });
}
$("#apply_job").submit(function (event) {
    event.preventDefault();

    $("#send_applcation").attr("disabled", true);
    $("#send_applcation").html("Please wait...");

    var ajax_data = new FormData();
    //append into ajax data
    ajax_data.append("func", '27');
    ajax_data.append('job_id',$('#apply_btn').data('job_id'));
    ajax_data.append('job_location',$('#apply_btn').data('post_code'));
    ajax_data.append('message',$('textarea#message').val());

    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        processData: false,
        contentType: false,
        data:ajax_data,
        success: function (data) {

            console.log(data);

            let button      = $(".single-lead-desc-first-sec-loc-address .btn-div-general.my-auto.mr-2"),
                appliedbtn  = '<a class="btn-bg-general tooltip-show btn-block text-white text-center px-3 py-2 text-decoration-none font-weight-bold rounded" style="padding-bottom: .3rem !important;padding-top: .3rem !important;">Already applied</a>';

            if(data.trim() == "already-apply"){
                swal("Already Applied", "You have alerady applied in this job, Please apply on another job.", "info").then((value) => {
                    $('#exampleModal').modal('hide');
                });
                button.find('a').remove();
                button.append(appliedbtn);
            }else if (data.trim() == "fill-fields") {
                swal("Missing details", "Kindly Enter message / cover letter", "info");
            }else if(data.trim() == "true") {
                swal("Application Submitted", "Thank you for applying! Your message is now on its way to the customer.", "success").then((value) => {
                    $('#exampleModal').modal('hide');
                });
                button.find('a').remove();
                button.append(appliedbtn);
            }else {
                swal("Failed to apply", "Failed to apply, please try again ", "error").then((value)=>{
                    $('#exampleModal').modal('hide');
                });

            }//else
            $("#send_applcation").attr("disabled", false);
            $("#send_applcation").html("Send Application");
        }//success
    });//ajax


});

function setSubCategory1() {
    var selectedID=$( "#select_main_category option:selected" ).val();

    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        data: {
            func: 16,
            selectedID:selectedID,

        },
        success: function (data) {

            var mydata = JSON.parse(data);

            if (data.trim() == "false") {
                swal("Not Found ", "Not found any sub category for this mian category", "error").then((value) => {
                });
            }else {

                $('#select_sub_category').html('');
                $('#select_sub_category').append(`
                 <optio>Please Select</option>
                 `);
                for(let i = 0; i <mydata.length ; i++){
                    $('#select_sub_category').append(`
                        <option value="${mydata[i].id}">${mydata[i].category_name}<?=']?></option>
                        `);

                }
                $("#subCategorydiv").show();

            }
        }
    });
}
//Sign up home user
$("#home_sign_up").submit(function (event) {
    event.preventDefault();

    if (!pattern.test($("#phone").val())) {
        swal("Phone format not Match", "", "info");
        $("#phone").val('');
        $( "#phone" ).focus();
        return;
    }
    if($("#phone").val()!='' && $("#isphoneverifiy").val()==0){


        $.ajax({
            url: "serverside/post.php",
            type: "POST",
            // async: false,
            data: {
                func: 96,
                phone:$('#phone').val(),
            },
            success: function (data) {
                $("#verification_phone").val($('#phone').val());

                if (data.trim() == "true") {

                    swal("Success", "We send phone verification code on your phone number", "success").then((value) => {
                        $("#verifiymodal").modal('show');
                        $("#isphoneverifiy").val(0);
                    });

                }else if(data.trim() == "false"){
                    swal("Failed","Failed to send verification code, please click resend button.","error")
                }
                else if(data.trim() == "exist"){

                    $("#isphoneverifiy").val(1);

                    if($("#isphoneverifiy").val()==0){
                        swal("Alert", "Your phone is not verified, verify it to continue ", "error").then((value) => {
                            $("#verifiymodal").modal('show');
                            return;
                        });
                    } else {

                    }
                }

            }
        });
    }else {


        if ($('#fname').val() == '') {

            swal("", "First name is missing", "info");

            $("#fname").focus();
            return;

        }

        if ($('#email').val() == '') {

            swal("", "Email is missing", "info");

            $("#email").focus();
            return;

        }
        if ($('#post_code').val() == '') {
            swal("", "Post Code is missing", "info");

            $("#post_code").focus();
            return;

        }
        if ($('#address').val() == '') {
            swal("", "Address is missing", "info");

            $("#address").focus();
            return;

        }
        if ($('#lname').val() == '') {
            swal("", "Last name is missing", "info");

            $("#lname").focus();
            return;

        }
        var pass1 = $('#pass1').val();
        var pass2 = $('#pass2').val();

        if (pass1 == '') {
            swal("", "Password is missing", "info");

            $("#pass1").focus();
            return;

        }

        if (pass1 != pass2) {
            swal("Error", "Your password don't match, please check!", "info");
            return;
        }

        let post_code = $('#post_code').val();
        var ajax_data = new FormData();

        ajax_data.append("func", '52');
        ajax_data.append('post_code', post_code);
        $("#signup_btn").attr("disabled", true);
        $("#signup_btn").html("Please wait...");

        $.ajax({
            url: "serverside/post.php",
            type: "POST",
            processData: false,
            contentType: false,
            data: ajax_data,
            success: function (data) {

                if (data.trim() != 200) {
                    swal("Invalid postcode", "please enter a valid postcode!", "info");
                    $("#post_code").val('');
                    $("#post_code").focus();

                    $("#signup_btn").attr("disabled", false);
                    $("#signup_btn").html("Sign Up");

                    return;
                } else {
                    $.ajax({
                        url: "serverside/post.php",
                        type: "POST",
                        data: {
                            func: 28,
                            fname: $('#fname').val(),
                            lname: $('#lname').val(),
                            phone: $('#phone').val(),
                            email: $('#email').val(),
                            pass1: pass1,
                            address: $('#work_address').val(),
                            address1: $('#work_address1').val(),
                            post_code: $('#post_code').val(),
                        },
                        success: function (data) {
                            console.log(data);

                            if (data.trim() == "true") {
                                swal("Register!", "You are registered successfully!", "success").then((value) => {
                                    window.location.href = "index";
                                });
                            } else if (data.trim() == "email-exist") {
                                swal("Email Already Registered", "Try with other email", "info");
                            } else {
                                swal("Not registered", "Your are not registered, try again", "error");
                            }
                        }
                    });

                }//else
                $("#signup_btn").attr("disabled", false);
                $("#signup_btn").html("Sign Up");
            }//success
        });//ajax
    }
});

function deleteAppliedJobs(id) {

    swal({
        title: 'Are you sure?',
        icon: 'info',
        buttons: true,
        dangerMode: true,
    }).then((result) => {

        if (result) {
            $.ajax({
                url: "serverside/post.php",
                type: "POST",
                data: {
                    func: 30,
                    id: id,
                },
                success: function (data) {

                    if (data.trim() == "true") {
                        swal({
                            icon: 'success',
                            title: 'success',
                            text: 'Job delete successfully!',
                        }).then((result) => {
                            location.reload();
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to delete!'
                        });
                    }
                }//success
            });//ajax
        }
    });
}
function shortList(userid,jobid){

    $("#shortList"+userid).attr("disabled", true);
    $("#shortList"+userid).html("Please wait...");

    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        data: {
            func: 31,
            userid: userid,
            jobid:jobid,
        },
        success: function (data) {

            if (data.trim() == "true") {
                swal({
                    icon: 'success',
                    title: 'User Shortlisted',
                    text: 'Success! You have successfully shortlisted this user.',
                }).then((result) => {
                    window.location.reload();
                });
            } else {
                swal({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Failed to Short List!'
                }).then((result)=>{
                    window.location.reload();
                });
            }
            $("#shortList"+userid).attr("disabled", false);
            $("#shortList"+userid).html("Short List");
        }//success
    });//ajax

}

function workerstartJob(user_id,job_id){

    $("#startJob").attr("disabled", true);
    $("#startJob").html("Please wait...");

    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        data: {
            func: 32,
            user_id: user_id,
            job_id:job_id,
        },
        success: function (data) {
            console.log(data)

            if (data.trim() == "true") {
				console.log(data.trim())
                swal({
                    icon: 'success',
                    title: 'Job Accepted',
                    text: 'Congratulations! You have successfully accepted this job.',
                }).then((result) => {
                    location.reload();
                });
            } else {
                swal({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Failed to Start Job!'
                });
            }
            $("#startJob").attr("disabled", false);
            $("#startJob").html("Accept Job");
        }//success
    });//ajax
}
var rateuser = 'yes';

$('.recommendation input[name="btnradio"]').change(function() {
    rateuser = $('.recommendation input[name="btnradio"]:checked').val(); // Corrected variable assignment
    
});

$("#rateUser").submit(function(event) {
    event.preventDefault();
    let stars = $("input[name='rating']:checked").val();
    let message = $('textarea#message').val();
    if (message == '' || stars === undefined) {
        swal("Missing Info", "Kindly give a rating and enter a message", "info");
        return;
    }

    var ajax_data = new FormData();
    // Append into ajax data
    ajax_data.append("func", '33');
    ajax_data.append('userid', $('#userid').val());
    ajax_data.append('jobid', $('#jobid').val());
    ajax_data.append('stars', stars);
    ajax_data.append('message', message);
    ajax_data.append('recommends', rateuser);

    

    // Make AJAX request to fetch user IP address and device info
    $.ajax({
        url: "serverside/get_user_info.php", // PHP script to fetch user info
        type: "GET",
        dataType: "json",
        success: function(data) {
            // Add user info to ajax data
			// console.log(data);
            ajax_data.append('user_info', JSON.stringify(data));

            $("#rateUser_btn").attr("disabled", true);
            $("#rateUser_btn").html("Please wait...");
            $.ajax({
                


                url: "serverside/post.php",
                type: "POST",
                processData: false,
                contentType: false,
                data: ajax_data,
                success: function(data) {
                    console.log(data);

                    if (data.trim() == "true") {
                        swal("Feedback Submitted", "Thank you for submitting your review. Your feedback is greatly appreciated.", "success").then((value) => {
                            location.reload();
                        });
                    } else {
                        swal("Not Submitted", "Not submitted, try again", "error");
                    }
                    $("#rateUser_btn").attr("disabled", false);
                    $("#rateUser_btn").html("Submit");
                }
            });
        },
        error: function() {
            // Handle error if unable to fetch user info
            swal("Error", "Unable to fetch user information", "error");
        }
    });
});
function employerstartJob(userid,jobid){
    $("#hire_btn").attr('disabled',true);
    $("#hire_btn").html('Please wait...');
    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        data: {
            func: 34,
            userid: userid,
            jobid:jobid,
        },
        success: function (data) {
            console.log(data)

            if (data.trim() == "true") {
                swal({
                    icon: 'success',
                    title: 'User Hired',
                    text: 'Congratulations! You have successfully hired this user.',
                }).then((result) => {
                    location.reload();
                });
            } else {
                swal({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Failed to Start!'
                });
            }//else
            $("#hire_btn").attr('disabled',false);
            $("#hire_btn").html('Hire');
        }//success
    });//ajax

}//employerstartJob
function completeJob(user_id,job_id){

    $("#completeJob").attr("disabled", true);
    $("#completeJob").html("Please wait...");

    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        data: {
            func: 35,
            user_id: user_id,
            job_id:job_id,
        },
        success: function (data) {
            console.log(data)

            if (data.trim() == "true") {
                swal({
                    icon: 'success',
                    title: 'Job Completed',
                    text: 'Congratulations on successfully completing this job. Well done!',
                }).then((result) => {
                    location.reload();
                });
            } else {
                swal({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Failed to Complete!'
                });
            }
            $("#completeJob").attr("disabled", false);
            $("#completeJob").html("Complete");
        }//success
    });//ajax
}


//update settings
$("#updateSettings").submit(function (event) {
    event.preventDefault();
    $.ajax({
        url: "../serverside/post.php",
        type: "POST",
        data: {
            func: 36,
            price: $("#price").val(),
            s_public_key: $("#s_public_key").val(),
            s_private_key: $("#s_private_key").val(),
        },
        success: function (data) {

            if (data.trim() == "true") {
                swal("Updated", "Settings updated successfully!", "success").then((value) => {
                    location.reload();
                });

            } else {
                swal("Failed", "Failed to update settings", "error");

            }
        }
    });
});

$("#uploadImages").submit(function(e){

    e.preventDefault();
    $('#progressWrapper').css('display', 'flex');

    if($('#images').get(0).files.length==0){
        swal("Select Image", "Please select an image and try again ", "error");
        $('#progressWrapper').css('display', 'none');
        return;
    }

    

    var ajax_data = new FormData();
    ajax_data.append("func", '39');
    ajax_data.append('userId',$('#userId').val());
    ajax_data.append('images', $('#images')[0].files[0]);

  
    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        processData: false,
        contentType: false,
        data:ajax_data,
        success: function (data) {
            
            if (data.trim() == "true") {
                swal("Uploaded Successfully", "Your gallery uploaded", "success").then((value) => {
				
                    location.reload();
                });
            }
            else if (data.trim() == "false") {
                swal("Not Uploaded", "Gallery not Uploaded,try again ", "error");
            }
            else {
                swal('oooops!', data, "error");
            }

            $('#progressWrapper').css('display', 'none');
        }
    });
});

function deleteOptions(id) {

    swal({
        title: 'Are you sure?',
        icon: 'info',
        buttons: true,
        dangerMode: true,
    }).then((result) => {

        if (result) {
            $.ajax({
                url: "../serverside/post.php",
                type: "POST",
                data: {
                    func: 42,
                    id: id,
                },
                success: function (data) {

                    if (data.trim() == "true") {
                        swal({
                            icon: 'success',
                            title: 'success',
                            text: 'Option delete successfully!',
                        }).then((result) => {
                            // location.reload();
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to delete!'
                        });
                    }
                }//success
            });//ajax
        }
    });
}


function deleteImage(id) {

    swal({
        title: 'Are you sure?',
        icon: 'info',
        buttons: true,
        dangerMode: true,
    }).then((result) => {

        if (result) {
            $.ajax({
                url: "serverside/post.php",
                type: "POST",
                data: {
                    func: 43,
                    id: id,
                },
                success: function (data) {

                    if (data.trim() == "true") {
                        swal({
                            icon: 'success',
                            title: 'success',
                            text: 'Delete successfully!',
                        }).then((result) => {
                            location.reload();
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to delete!'
                        });
                    }
                }//success
            });//ajax
        }
    });
}

function deleteImagejob(id) {

    swal({
        title: 'Are you sure?',
        icon: 'info',
        buttons: true,
        dangerMode: true,
    }).then((result) => {

        if (result) {
            $.ajax({
                url: "serverside/post.php",
                type: "POST",
                data: {
                    func: 430,
                    id: id,
                },
                success: function (data) {

                    if (data.trim() == "true") {
                        swal({
                            icon: 'success',
                            title: 'success',
                            text: 'Delete successfully!',
                        }).then((result) => {
                            location.reload();
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to delete!'
                        });
                    }
                }//success
            });//ajax
        }
    });
}

$("#edit_job").submit(function (event) {
    event.preventDefault();

    if ($("#title").val()==''||$("#post_code").val()==''||$('textarea#note').val()=='') {
        swal("Missing details", "Kindly fill all the input fields", "info");
        return;
    }
    let sub_category_id=$("input[name='involve']:checked").val();
    let options=$("input[name='opt']:checked").val();

    if (sub_category_id == undefined || sub_category_id == null){
        sub_category_id="undefined";
    }
    if (options == undefined || options == null){
        options="undefined";
    }
    var ajax_data = new FormData();
    //append into ajax data
    ajax_data.append("func",'45');
    ajax_data.append('main_type',$("#select_category option:selected" ).val());
    ajax_data.append('sub_type',sub_category_id);
    ajax_data.append('options',options);
    ajax_data.append('title',$("#title").val());
    ajax_data.append('job_id',$("#job_id").val());
    ajax_data.append('post_code',$("#post_code").val());
    ajax_data.append('note',$('textarea#note').val());


    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        processData: false,
        contentType: false,
        data:ajax_data,
        success: function (data) {
            if (data.trim() == "true") {
                swal("Edit Successfully", "Your job edit successfully!", "success").then((value) => {
                    window.location.href = "dashboard-myposted-jobs";
                });
            }else {
                swal("Job Not Edit", "Your job is not edit,kindly try again", "error");
            }
        }
    });
});

function deleteJobImage(id) {

    swal({
        title: 'Are you sure?',
        icon: 'info',
        buttons: true,
        dangerMode: true,
    }).then((result) => {

        if (result) {
            $.ajax({
                url: "serverside/post.php",
                type: "POST",
                data: {
                    func: 46,
                    id: id,
                },
                success: function (data) {

                    if (data.trim() == "true") {
                        swal({
                            icon: 'success',
                            title: 'success',
                            text: 'Delete successfully!',
                        }).then((result) => {
                            location.reload();
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to delete!'
                        });
                    }
                }//success
            });//ajax
        }
    });
}

$(".upload__inputfile").change(function(event){
    event.preventDefault();
    var totalfiles = document.getElementById('images').files.length;

    if(totalfiles==0){
        swal("Select Image", "Please select an image/video and try again ", "error");
        return;
    }


    var ajax_data = new FormData();
    ajax_data.append("func", '47');
    ajax_data.append('job_id',$('#jobsid').val());

    for (var index = 0; index < totalfiles; index++) {
        ajax_data.append("files[]", document.getElementById('images').files[index]);
    }
    $("#img_btn").hide();
    $('#uploadresponse').html('uploading...')
    $('#uploadresponse_spinner').show();
    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        processData: false,
        contentType: false,
        data:ajax_data,
        success: function (data) {

            if (data.trim() == "true") {
                swal("Gallery upload successfully", "", "success").then((value) => {
                    location.reload();
                });
            }
            else {
                swal("Not Uploaded", "Gallery  not upload, try again ", "error");
                $('#uploadresponse').html('Please try agin')
                $('#uploadresponse_spinner').hide();

            }

            $('#uploadresponse').html('')
            $('#uploadresponse_spinner').hide();
            $("#img_btn").hide();
        }//success
    });
});

function editjobsetSubCategory() {
    var selectedID=$( "#select_category option:selected" ).val();

    if(selectedID=='not-determined'){

        swal("Select Category", "Please Select mian category", "info").then((value) => {
            location.reload();
        });
    }
    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        data: {
            func: 16,
            selectedID:selectedID,
        },
        success: function (data) {

            var mydata = JSON.parse(data);

            if (data.trim() == "false") {
                swal("Not Found ", "Not found any sub category for this mian category", "error").then((value) => {

                });
            }else {
                $('#edit_checkboxs').html('');
                $('#edit_checkboxs').append(`<h1>Your job involve</h1>`);

                for(let i = 0; i <mydata.length ; i++){
                    $('#edit_checkboxs').append(`<div>
                    <label class="label1 label">
                    <input name="involve" onclick="editjobsetOptions(this);" value="${mydata[i].id}" class="input_radio" type="radio" aria-label="Single isolated area">
                    <div>${mydata[i].category_name}</div>
                    </label>
                    </div>`);
                }
            }
        }
    });
}

function editjobsetOptions() {
    var selectedID=$("input[name='involve']:checked").val();

    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        data: {
            func: 50,
            selectedID:selectedID,

        },
        success: function (data) {
            var mydata = JSON.parse(data);

            if (data.trim() == "false") {
                swal("Not Found ", "Not found any sub category for this mian category", "error").then((value) => {

                });
            }else {
                $('#edit_checkboxs1').html('');
                $('#edit_checkboxs1').append(`<h1>Choose a option</h1>`);
                for(let i = 0; i <mydata.length ; i++){
                    $('#edit_checkboxs1').append(`<div>
                    <label class="label1 label">
                    <input name="opt" checked="checked" value="${mydata[i].id}" class="input_radio" type="radio" aria-label="Single isolated area">
                    <div>${mydata[i].option}</div>
                    </label>
                    </div>`);

                }
            }
        }
    });
}

function deleteUser(id) {

    swal({
        title: 'Are you sure?',
        icon: 'info',
        buttons: true,
        dangerMode: true,
    }).then((result) => {

        if (result) {
            $.ajax({
                url: "../serverside/post.php",
                type: "POST",
                data: {
                    func: 51,
                    id: id,
                },
                success: function (data) {

                    if (data.trim() == "true") {
                        swal({
                            icon: 'success',
                            title: 'success',
                            text: 'User delete successfully!',
                        }).then((result) => {
                            // location.reload();
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to delete!'
                        });
                    }
                }//success
            });//ajax
        }
    });
}//delete user
function deleteProfile(id) {


    (async () => {
        const confirmAccountDeletion = await Swal.fire({
            title: 'Account Deletion Confirmation',
            text: 'Are you sure you want to delete your account?',
            icon: 'error',
            showCancelButton: true,
            confirmButtonText: "Delete Account",
            cancelButtonText: "Cancel",
            dangerMode: true,
        });

        if (confirmAccountDeletion.isConfirmed) {
            const surveyOptions = [
                'Unhappy with the service that we are offering.',
                'Frustrated with our customer service team.',
                'Too expensive.',
                'Found another service offering a more suitable product.',
                'Not winning enough leads.',
            ];

            const { value: surveyAnswer } = await Swal.fire({
                title: 'Why are you leaving?',
                input: 'select',
                inputOptions: surveyOptions,
                inputPlaceholder: 'Select a reason',
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Submit',
                inputValidator: (value) => {
                    return new Promise((resolve) => {
                        if (value === '') {
                            resolve('You need to select a reason');
                        } else {
                            resolve();
                        }
                    });
                },
            });

            if (surveyAnswer) {
                console.log(surveyAnswer);
                $.ajax({
                    url: "serverside/post.php",
                    type: "POST",
                    data: {
                        func: 51,
                        id: id,
                        surveyAnswer: surveyAnswer,
                    },
                    success: function (data) {
                        console.log(data);
                        if (data.trim() == "true") {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'User deleted successfully!',
                            }).then((result) => {
                                window.location.href = "logout";
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Failed to delete!',
                            });
                        }
                    }//success
                });//ajax
            }
        }
    })();




}//delete user

// update your qualification
$("#qualification_form").submit(function(event){
    event.preventDefault();
    if($('textarea#qualification').val()==''){
        swal("Please enter your qualification ", "", "info");
        return;
    }
	var formdata2 = $("#qualification_form").serialize();
	

    $.ajax({
        url: "serverside/post.php",
        type: "POST",
		contentType: 'application/x-www-form-urlencoded; charset=UTF-8', // when we use .serialize() this generates the data in query string format. this needs the default contentType (default content type is: contentType: 'application/x-www-form-urlencoded; charset=UTF-8') so it is optional, you can remove it
        data:{
            func:53,
            userid:$("#u_id").val(),
			qualification:$("#qualification_form").serialize(),

        },
        success: function (data) {

            if (data.trim() == "true") {
                // swal("Uploaded Successfully", "Your image/video is added in your galler", "success").then((value) => {
                location.reload();
                // });
            }
            else {
                swal("Qualification not updated", "Please try again ", "error");

            }
        }
    });
});//qualification_form

// update your qualification
$("#insurebt").click(function (e){
    event.preventDefault();
    var userId = $("#u_id").val();
    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        data: {
            func: 200,
            userid: userId
        },
        success: function(data) {
            //console.log(data);
            var qualifications = JSON.parse(data);
            console.log(qualifications); // Add this line to inspect the structure of qualifications
            if (qualifications.length > 0) {
                $('#qualifications').empty();
                for (var i = 0; i < qualifications.length; i++) {
                    // Assuming qualifications[i] has a 'qualification' property that is a comma-separated string
                    var items = qualifications[i].qualification.split(',');
                    for (var j = 0; j < items.length; j++) {
                        var newInput = $('<div class="qualification"><input type="text" class="form-control-lg form-control" required="" name="qualification[]"><button type="button" class="remove-qualification btn btn-danger">-</button></div>');
                        $(newInput).find('input[name="qualification[]"]').val(items[j]);
                        $('#qualifications').append(newInput);
                    }
                }
            }
        }
    });
});//qualification_form

//update your DBS
$("#dbs_form").submit(function(event){
    event.preventDefault();
    var len = document.getElementById('dbs').files.length;
    if(len<=0){

        swal("DBS Certificate is missing", "", "info").then((result) => {

        });
        return;
    }//if
    var ajax_data = new FormData();
    //append into ajax data
    ajax_data.append("func", '54');
    ajax_data.append("userid", $("#uu_id").val());
    ajax_data.append('dbs', $('#dbs')[0].files[0]);

    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        processData:false,
        contentType:false,
        data:ajax_data,
        success: function (data) {

            if (data.trim() == "true") {
                // swal("Uploaded Successfully", "Your image/video is added in your galler", "success").then((value) => {
                location.reload();
                // });
            }
            else {
                swal("DBS not updated", "Please try again ", "error");

            }
        }
    });
});//dbs_form

// Update address
$("#check_post_Code").click(function (e){

    e.preventDefault();
    let post_code=$('#post_code').val();
    var ajax_data = new FormData();
    ajax_data.append("func", '52');
    ajax_data.append('post_code',post_code );

    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        processData: false,
        contentType: false,
        data:ajax_data,
        success: function (data) {

            if (data.trim() != 200) {
                swal("Invalid postcode", "please enter a valid postcode!", "info");
                $("#post_code").val('');
                $("#post_code").focus();
                return;
            } else {

            }
        }//success
    });
});//check_post_Code
$("#address_form").submit(function (event) {

    event.preventDefault();
    let post_code=$('#post_code').val().toUpperCase();
    var ajax_data = new FormData();
    ajax_data.append("func", '52');
    ajax_data.append('post_code',post_code );

    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        processData: false,
        contentType: false,
        data:ajax_data,
        success: function (data) {

            if(data.trim()!=200){
                swal("Invalid postcode", "please enter a valid postcode!", "info");
                $("#post_code").val('');
                $( "#post_code" ).focus();
                return;
            }else {

                var ajax_data = new FormData();
                //append into ajax data
                ajax_data.append("func", '55');
                ajax_data.append('userid', $('#uuu_id').val());
                ajax_data.append('work_address', $('#work_address').val());
                ajax_data.append('work_address1', $('#work_address1').val());
                ajax_data.append('town', $('#town').val());
                ajax_data.append('post_code', $('#post_code').val().toUpperCase());
                ajax_data.append('distance',$( "#distance option:selected" ).val());

                $.ajax({
                    url: "serverside/post.php",
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data:ajax_data,
                    success: function (data) {

                        if (data.trim() == "true") {
                            location.reload();
                        } else {
                            swal("Not updated", "Please, try again", "error");
                        }
                    }//success
                });//ajax

            }

        }//success

    });
});//submit
// update job description
$("#des_form").submit(function(event){
    event.preventDefault();
    if($('textarea#note').val()==''){
        swal("Please enter your description ", "", "info");
        return;
    }

    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        data:{
            func:56,
            jobid:$("#jobid1").val(),
            note:$("textarea#note").val(),
        },
        success: function (data) {
            if (data.trim() == "true") {
                // swal("Uploaded Successfully", "Your image/video is added to the gallery", "success").then((value) => {
                location.reload();
                // });
            }
            else {
                swal("Description not updated", "Please try again ", "error");

            }
        }//success
    });
});



var job_ids = [];

function openModal(id,distance,countjobs, clickedelement=null){
    let leadsunread         =   $('#newleads .show_counter_label'),
        interestedunread    =   $('#filter1 .show_counter_label'),
        shortlistedunread   =   $('#filter2 .show_counter_label'),
        jobswonunread       =   $('#filter3 .show_counter_label'),
        readingStatus       =   '',
        counter             =   0,
        identifyer          =   $(clickedelement).attr('data-identity'),
        countholder         =   $('.show_counter');

    if($(clickedelement).hasClass('unreadlead')) {
        readingStatus = 'unread';
    } else {
        readingStatus = 'read';
    }

    if(identifyer === 'leads'){
        counter = parseInt(leadsunread.text())
    }else if (identifyer === 'interested') {
        counter = parseInt(interestedunread.text())
    }else if (identifyer === 'shortlisted') {
        counter = parseInt(shortlistedunread.text())
    }else if (identifyer === 'jobswon') {
        counter = parseInt(jobswonunread.text())
    }
    
    
    $.ajax({
        url: "single_lead.php",
        type: "POST",
        data:{
            job_id:id,
            distance:distance,
            reading: readingStatus,
            jobscount: countjobs,
            identifyer: identifyer
        },
        success: function (data) {

            var protocol    = window.location.protocol;
            var host        = window.location.hostname;
            var port        = window.location.port ? ':' + window.location.port : '';
            var baseUrl     = protocol + '//' + host + port;
            var baseURL     = baseUrl + '/leads';
            var url         = baseURL + '?id=' + id + '&d=' + distance + '&r=' + readingStatus + '&j=' + countjobs + '&i=' + identifyer;

            history.pushState({
                id: id,
                d: distance,
                r: readingStatus,
                j: countjobs,
                i: identifyer
            }, null, url);

            
            if($(clickedelement).hasClass('unreadlead')) {   
                counter--;         
                if(counter < 1 ) {
                    counter = 0;
                    $(clickedelement).find('.active-lead').remove();
                    
                }
                countholder.text(counter);

                if(identifyer === 'leads'){
                    if(counter < 1 ) $('#newleads').find('.active-lead').remove();
                    else leadsunread.text(counter);                
                }else if (identifyer === 'interested') {
                    if(counter < 1 ) $('#filter1').find('.active-lead').remove();
                    else interestedunread.text(counter);  
                }else if (identifyer === 'shortlisted') {
                    if(counter < 1 ) $('#filter2').find('.active-lead').remove();
                    else shortlistedunread.text(counter);  
                }else if (identifyer === 'jobswon') {
                    if(counter < 1 ) $('#filter3').find('.active-lead').remove();
                    else jobswonunread.text(counter);  
                }

                $(clickedelement).removeClass('unreadlead');
            }            

            

            $(".six-fraction").html(data);
            var element = document.getElementById("six-fraction");
            element.style.display = "block";
            document.getElementById("my-mobile-modal").style.width = "100%";

            $('#job_id1').val($('#apply_btn').data('job_id'));
            $('#job_location').val($('#apply_btn').data('post_code'));
        }
    });

    $.ajax({
        url: "single_lead_mobile.php",
        type: "POST",
        data:{
            job_id:id,
            distance:distance,
            reading: readingStatus,
            jobscount: countjobs,
            identifyer: identifyer
        },
        success: function (data) {

            $("#my-mobile-modal").html(data);
            var element = document.getElementById("six-fraction");
            element.style.display = "block";
            document.getElementById("my-mobile-modal").style.width = "100%";

            $('#job_id1').val($('#apply_btn').data('job_id'));
            $('#job_location').val($('#apply_btn').data('post_code'));

        }//success
    });//ajax

}

$("#account_form").submit(function (event) {
    event.preventDefault();
    let post_code=$('#post_code').val();
    if (!pattern.test($("#phone").val())) {
        swal("Please enter a valid phone number", "","info");
        $("phone").focus();
        $("phone").html('');
        return;
    }
    if($("#isphoneverifiy").val()==0){

        $("#update_btn").attr("disabled", true);
        $("#update_btn").html("Please wait...");
        $.ajax({
            url: "serverside/post.php",
            type: "POST",
            // async: false,
            data: {
                func: 96,
                phone:$('#phone').val(),
            },
            success: function (data) {
                $("#verification_phone").val($('#phone').val());

                if (data.trim() == "true") {

                    // swal("Success", "We send phone verification code on your phone number", "success").then((value) => {
                        
                    // });
                    $("#verifiymodal").modal('show');
                    $("#isphoneverifiy").val(0);

                }else if(data.trim() == "false"){
                    swal("Failed","Failed to send verification code, please click resend button.","error")
                }
                else if(data.trim() == "exist"){

                    $("#isphoneverifiy").val(1);

                    if($("#isphoneverifiy").val()==0){
                        swal("Alert", "Your phone is not verified, verify it to continue ", "error").then((value) => {
                            $("#verifiymodal").modal('show');
                            return;
                        });
                    } else {

                    }
                }
                $("#update_btn").attr("disabled", false);
                $("#update_btn").html("Update");

            }
        });
    }else {

        var ajax_data = new FormData();
        ajax_data.append("func", '52');
        ajax_data.append('post_code', post_code);
        $("#update_btn").attr("disabled", true);
        $("#update_btn").html("Please wait...");
        $.ajax({
            url: "serverside/post.php",
            type: "POST",
            processData: false,
            contentType: false,
            data: ajax_data,
            success: function (data) {
                if (data.trim() != 200) {
                    swal("Invalid postcode", "please enter a valid postcode!", "info");
                    $("#post_code").val('');
                    $("#post_code").focus();
                    $("#update_btn").attr("disabled", false);
                    $("#update_btn").html("Update");
                    return;
                } else {

                    var ajax_data = new FormData();
                    //append into ajax data
                    ajax_data.append("func", '57');
                    ajax_data.append('userid', $('#uuu_id').val());
                    ajax_data.append('fname', $('#fname').val());
                    ajax_data.append('lname', $('#lname').val());
                    ajax_data.append('phone', $('#phone').val());
                    // ajax_data.append('email', $('#email').val());
                    ajax_data.append('work_address', $('#work_address').val());
                    ajax_data.append('work_address1', $('#work_address1').val());
                    ajax_data.append('town', $('#town').val());
                    ajax_data.append('post_code', $('#post_code').val());

                    $.ajax({
                        url: "serverside/post.php",
                        type: "POST",
                        processData: false,
                        contentType: false,
                        data: ajax_data,
                        success: function (data) {
                            if (data.trim() == "true") {
                                location.reload();
                            } else if (data.trim() == "email-exist") {
                                swal("Email Already Registered ", "Try with other email", "info");
                            } else {
                                swal("Not updated", "Please, try again", "error");
                            }
                            $("#update_btn").attr("disabled", false);
                            $("#update_btn").html("Update");
                        }//success
                    });//ajax

                }
                $("#update_btn").attr("disabled", false);
                $("#update_btn").html("Update");
            }//success

        });//ajax

    }
});//submit


function deleteMessage(id) {

    $.ajax({
        url: "../serverside/post.php",
        type: "POST",
        data:{
            func:58,
            message_id:id,
        },
        success: function (data) {
            if(data.trim()=='true'){
                location.reload();

            }else{
                swal("Failed to delete this message","","error");

            }
        }//success
    });//ajax
}//deleteMessage

$("#update_profile").submit(function (event) {
    event.preventDefault();
    $.ajax({
        url: "../serverside/post.php",
        type: "POST",
        data: {
            func: 59,
            userid: $("#uid").val(),
            fname: $("#fname").val(),
            email: $("#email").val(),

        },
        success: function (data) {

            if (data.trim() == "true") {
                Swal.fire({
                    icon: 'success',
                    title: 'success',
                    text: 'User profile updated successfully!',
                }).then((result) => {
                    location.reload();
                });
            }else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Failed to update user profile!'
                });
            }//else
        }//succes
    });//ajax
});//update profile
//update password for admin
$("#updatePassword").submit(function (event){
    event.preventDefault();
    var oldpass = $('#currentpass').val();
    var newpass = $('#newpass').val();
    var confirmpass = $('#cofirmpass').val();
    if(oldpass =="" || newpass=="" || confirmpass == ""){
        Swal.fire({
            icon: 'error',
            title: 'error',
            text: 'Please fill all fields!'
        })
        return;
    } else if(newpass != confirmpass){
        Swal.fire({
            icon: 'error',
            title: 'Password mismatch',
            text: 'Password don\'t match!'
        })
        return;
    }else{
        $.ajax({
            url:"../serverside/post.php",
            type:"POST",
            data:{
                func:60,
                oldpass:oldpass,
                newpass:newpass,
                confirmpass:confirmpass,
                userId:$("#up_id").val(),
            },
            success: function (data){
                if(data.trim()=="true"){
                    Swal.fire({
                        icon: 'success',
                        title: 'updated',
                        text: 'User password updated successfully!',
                    }).then((result) => {
                        location.reload();
                    })
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Failed to update user password!'
                    })
                }
            }
        });
    }
});
//update password for user
$("#updatePassword1").submit(function (event){
    event.preventDefault();
    var oldpass = $('#currentpass').val();
    var newpass = $('#newpass').val();
    var confirmpass = $('#cofirmpass').val();
    if(oldpass =="" || newpass=="" || confirmpass == ""){
        Swal.fire({
            title: "Kindly fill all the fields",
            icon: "info",
        });

        return;
    } else if(newpass != confirmpass){
        // swal("Password mismatch","Password don\'t match!","info");
        Swal.fire({
            title: "Password mismatch",
            text: "Password don't match!",
            icon: "info",
        });

        
        return;
    }else{
        $.ajax({
            url:"serverside/post.php",
            type:"POST",
            data:{
                func:60,
                oldpass:oldpass,
                newpass:newpass,
                confirmpass:confirmpass,
                userId:$("#up_id").val(),
            },
            success: function (data){
                if(data.trim()=="true"){
                    // swal("Password update successfuly","","success").then((result) => {
                    //     location.reload();
                    // })
                    Swal.fire({
                        title: "Password update successfully",
                        icon: "success",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });

                }else{
                    // swal("Failed to update user password!","Please try again","error");
                    Swal.fire({
                        title: "Failed to update user password!",
                        text: "Please try again",
                        icon: "error",
                    });

                }
            }
        });
    }
});

// update your insurance
$("#insurance_form").submit(function(event){
    event.preventDefault();

    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        data:{
            func:61,
            userid:$("#u00_id").val(),
            pub_insurance:$("#pub_insurance").val(),
            pub_insurance_date:$("#pub_insurance_date").val(),
            pro_insurance:$("#pro_insurance").val(),
            pro_insurance_date:$("#pro_insurance_date").val(),
        },
        success: function (data) {
            if (data.trim() == "true") {
                // swal("Uploaded Successfully", "Your image/video is added in your galler", "success").then((value) => {
                location.reload();
                // });
            }
            else {
                swal("Insurance is not updated", "Please try again ", "error");

            }
        }
    });
});//insurance_form

// update your intoduction
$("#about_form").submit(function(event){
    event.preventDefault();
    if($('textarea#note').val()==''){
        swal("Please enter your intro ", "", "info");
        return;
    }

    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        data:{
            func:62,
            userid:$("#u0_id").val(),
            note:$("textarea#note").val(),
        },
        success: function (data) {


            if (data.trim() == "true") {
                // swal("Uploaded Successfully", "Your image/video is added in your galler", "success").then((value) => {
                location.reload();
                // });
            }
            else {
                swal("Introduction not updated", "Please try again ", "error");

            }
        }
    });
});//about_form

function blockJob(id) {
    swal({
        title: 'Are you sure to block this job?',
        icon: 'info',
        buttons: true,
        dangerMode: true,
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result) {
            $.ajax({
                url: "../serverside/post.php",
                type: "POST",
                data: {
                    func: 63,
                    id: id,
                },
                success: function (data) {

                    if (data.trim() == "true") {
                        swal({
                            icon: 'success',
                            title: 'success',
                            text: 'Job blocked successfully!',
                        }).then((result) => {
                            location.reload();
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to block job!'
                        });
                    }
                }//success
            });//ajax
        }
    });
}//block job
function activeJob(id) {
    swal({
        title: 'Are you sure to active this job?',
        icon: 'info',
        buttons: true,
        dangerMode: true,
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result) {
            $.ajax({
                url: "../serverside/post.php",
                type: "POST",
                data: {
                    func: 64,
                    id: id,
                },
                success: function (data) {

                    if (data.trim() == "true") {
                        swal({
                            icon: 'success',
                            title: 'success',
                            text: 'Job active successfully!',
                        }).then((result) => {
                            location.reload();
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to active job!'
                        });
                    }
                }//success
            });//ajax
        }

    });
}//active job
// reward user
function rewardUser(id) {
    swal({
        text: 'Are you sure to give reward to this user? Balance will become 0.',
        icon: 'info',
        buttons: true,
        dangerMode: true,
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result) {
            $.ajax({
                url: "../serverside/post.php",
                type: "POST",
                data: {
                    func: 66,
                    id: id,
                },
                success: function (data) {

                    if (data.trim() == "true") {
                        swal({
                            icon: 'success',
                            title: 'success',
                            text: 'Reward assign successfully!',
                        }).then((result) => {
                            location.reload();
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to assign reward!'
                        });
                    }
                }//success
            });//ajax
        }

    });
}//reward user

function startChat(userid,jobid){

    $("#chat_btn").attr("disabled", true);
    $("#chat_btn").html("Please wait...");

    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        data: {
            func: 67,
            userid: userid,
            jobid:jobid,
        },
        success: function (data) {
            if (data.trim() == "true") {
                window.location.href="chat?touserid="+userid+"&jobid="+jobid;
            } else {
                swal({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Failed to Start Chat!'
                }).then((result)=>{
                    window.location.reload();
                });
            }
            $("#chat_btn").attr("disabled", false);
            $("#chat_btn").html("Start Chat");
        }//success
    });//ajax

}
$("#send_msg_btn").click(function (e){
    e.preventDefault();
    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        data: {
            func: 68,
            touserid: $("#touserid").val(),
            jobid: $("#jobid").val(),
            message:$("#message").val()
        },
        success: function (data) {
            if (data.trim() == "true") {
                // location.reload();
                $("#message").val("");
				
			
            } else {
                swal({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Failed to send message!'
                }).then((result)=>{
                    window.location.reload();
                });
            }
        }//success
    });//ajax
});

// send images





// edit main category
$("#edit_mian_category_form").submit(function (event) {
    event.preventDefault();

    $.ajax({
        url: "../serverside/post.php",
        type: "POST",
        data: {
            func: 70,
            id:$('#edit_main_category_id').val(),
            name:$('#edit_main_category_name').val(),

        },
        success: function (data) {
            $("#edit_main_categoryModal").modal('toggle');
            if (data.trim() == "true") {
                swal("Edit Successfully", "", "success").then((value) => {
                    location.reload();
                });
            }else {
                swal("Not edit", "", "error");

            }
        }
    });

});

$("#edit_subCategory").submit(function (event) {
    event.preventDefault();
    var type=$("#edit_sub_main_category_id option:selected" ).val();
    $.ajax({
        url: "../serverside/post.php",
        type: "POST",
        data: {
            func: 71,
            name:$('#edit_sub_category_name').val(),
            index:$('#edit_sub_category_index').val(),
            id:$('#edit_sub_category_id').val(),
            type:type,

        },
        success: function (data) {

            $("#edit_sub_categoryModal").modal('toggle');
            if (data.trim() == "true") {
                swal("Edit Successfully", "", "success").then((value) => {
                    location.reload();
                });
            }else {
                swal("Not Update", "", "error");

            }
        }
    });

});

$("#edit_option").submit(function (event) {
    event.preventDefault();
    var type=$( "#edit_option_sub_category option:selected" ).val();
    $.ajax({
        url: "../serverside/post.php",
        type: "POST",
        data: {
            func: 72,
            name:$('#edit_option_name').val(),
            type:type,
            id:$("#edit_option_id").val(),

        },
        success: function (data) {

            $("#edit_optionModal").modal('toggle');

            if (data.trim() == "true") {
                swal("Edit successfully", "", "success").then((value) => {
                    location.reload();

                });
            }else {
                swal("Not Update", "", "error");

            }
        }
    });

});


$("#edit_blog_cat").submit(function (event) {
    event.preventDefault();
    console.log($('#edit_blog_cat_name').val());
   console.log($( "#edit_blog_type option:selected" ).val());
   console.log($("#edit_blog_cat_id").val());
    
    var type=$( "#edit_blog_type option:selected" ).val();
    $.ajax({
        url: "../serverside/post.php",
        type: "POST",
        data: {
            func: 120,
            name:$('#edit_blog_cat_name').val(),
            type:type,
            id:$("#edit_blog_cat_id").val(),

        },
        success: function (data) {

            $("#edit_blog_categoryModal").modal('toggle');

            if (data.trim() == "true") {
                swal("Edit successfully", "", "success").then((value) => {
                    location.reload();

                });
            }else {
                swal("Not Update", "", "error");

            }
        }
    });

});
function withdraw(user_id,amount){
    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        data: {
            func: 75,
            amount:amount,
            user_id:user_id,
        },
        success: function (data) {

            if (data.trim() == "true") {
                swal("Withdraw successfully", "", "success").then((value) => {
                    location.reload();

                });
            }else {
                swal("Failed to withdraw", "", "error");

            }
        }
    });
}

function withdrawapprove(request_id,user_id) {

    swal({
        text: 'Are you sure to approve this request?',
        icon: 'info',
        buttons: true,
        dangerMode: true,
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result) {
            $.ajax({
                url: "../serverside/post.php",
                type: "POST",
                data: {
                    func: 76,
                    request_id:request_id,
                    user_id: user_id,
                },
                success: function (data) {


                    if (data.trim() == "true") {
                        swal({
                            icon: 'success',
                            title: 'success',
                            text: 'Request approve successfully!',
                        }).then((result) => {
                            location.reload();
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to approve!'
                        });
                    }
                }//success
            });//ajax
        }

    });
}//withdraw approve

function withdrawReject(request_id,user_id) {

    swal({
        text: 'Are you sure to reject this request?',
        icon: 'info',
        buttons: true,
        dangerMode: true,
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result) {
            $.ajax({
                url: "../serverside/post.php",
                type: "POST",
                data: {
                    func: 77,
                    request_id:request_id,
                    user_id: user_id,
                },
                success: function (data) {
                    if (data.trim() == "true") {
                        swal({
                            icon: 'success',
                            title: 'success',
                            text: 'Request reject successfully!',
                        }).then((result) => {
                            location.reload();
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to reject!'
                        });
                    }
                }//success
            });//ajax
        }

    });
}//withdraw reject
$("#cancel_subscription").click(function (e){
    e.preventDefault();
    swal({
        text: 'Are you sure to cancel subscription?',
        icon: 'info',
        buttons: true,
        dangerMode: true,
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result) {

            $("#cancel_subscription").html(`Please wait <i class="fa fa-spinner fa-spin" style="font-size:24px"></i>`);
            $("#cancel_subscription").prop('disabled', true);


            $.ajax({
                url: "serverside/post.php",
                type: "POST",
                data: {
                    func: 78,
                },
                success: function (data) {

                    if (data.trim() == "true") {
                        swal({
                            icon: 'success',
                            title: 'success',
                            text: 'Subscription cancel successfully!',
                        }).then((result) => {
                            $("#cancel_subscription").html(`Reactivate Subscription`);
                            location.reload();
                        });
                    }else if (data.trim() == "false") {
                        swal({
                            icon: 'info',
                            title: 'Not Cancelled',
                            text: 'Failed to cancel your subscription !',
                        }).then((result) => {
                            $("#cancel_subscription").html(`Cancel Subscription`);
                            location.reload();
                        });
                    }else if (data.trim() == "no_subscription") {
                        swal({
                            icon: 'info',
                            title: 'No subscription',
                            text: 'Subscription Id not found!',
                        }).then((result) => {
                            $("#cancel_subscription").html(`Cancel Subscription`);
                            location.reload();
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to cancel!'
                        }).then((result)=> {
                            $("#cancel_subscription").html(`Cancel Subscription`);
                            $("#cancel_subscription").prop('disabled', false);
                        });
                    }

                }//success
            });//ajax
        }
    });
});


$('#reactivate_account').click(function(e){
    e.preventDefault();

    $("#popular_search").show();
        $.ajax({
            url: baseURL + "/serverside/post.php",
            type: "POST",
            data: {
                func: 121,
            },
            success:function(data){
                var mydata = JSON.parse(data);
                if (data.trim() == "false") {
                    swal("Not Found ", "Not found any category", "error").then((value) => {

                    });
                } else {
                    $('#scrolling-wrapper').html('');
                    for(let i = 0; i <mydata.length ; i++){
                        if((mydata[i].main_category.trim() != 'Other')) {

                            $('#scrolling-wrapper').append(`
                                        <span class="p-2 d-span" onclick= "setvalueofsearch('${mydata[i].main_category}')"> ${mydata[i].main_category} <i class="fa fa-angle-right bpsc"></i> </span>
                                    `);
                        }
                    }
                }
            } //success
        });

});


$("#search_main_type1").keyup(function (e){
    e.preventDefault();
    
    var baseURL = window.location.protocol + "//" + window.location.host;

    if($("#search_main_type1").val() == ""){

        $("#popular_search").show();
        $.ajax({
            url: baseURL + "/serverside/post.php",
            type: "POST",
            data: {
                func: 74,
            },
            success:function(data){
                var mydata = JSON.parse(data);
                if (data.trim() == "false") {
                    swal("Not Found ", "Not found any category", "error").then((value) => {

                    });
                } else {
                    $('#scrolling-wrapper').html('');
                    for(let i = 0; i <mydata.length ; i++){
                        if((mydata[i].main_category.trim() != 'Other')) {

                            $('#scrolling-wrapper').append(`
                                        <span class="p-2 d-span" onclick= "setvalueofsearch('${mydata[i].main_category}')"> ${mydata[i].main_category} <i class="fa fa-angle-right bpsc"></i> </span>
                                    `);
                        }
                    }
                }
            } //success
        });
    } else {
        $("#popular_search").hide();
        $.ajax({
            url: baseURL + "/serverside/post.php",
            type: "POST",
            data: {
                func: 73,
                main_type_name:$("#search_main_type1").val(),
            },
            success:function(data){
                var mydata = JSON.parse(data);
                if (data.trim() == "false") {
                    swal("Not Found ", "Not found any category", "error").then((value) => {

                    });
                } else {
                    $('#scrolling-wrapper').html('');
                    var maincateogrycheck = "";
                    for(let i = 0; i <mydata.length ; i++){
                        if(maincateogrycheck != mydata[i].main_category){
                            $('#scrolling-wrapper').append(`<h6 class="mt-3">${mydata[i].main_category}</h6>`);
                        }
                        maincateogrycheck = mydata[i].main_category;
                        if( (!(mydata[i].sub_category.includes('Other'))) && (!(mydata[i].sub_category.includes('other')))  ) {

                            $('#scrolling-wrapper').append(`
                                <span class="p-2 d-span" onclick="setSubCategory('${mydata[i].main_id}','${mydata[i].id}')"> ${mydata[i].sub_category} <i class="fa fa-angle-right bpsc"></i></span>
                            `);
                        }
                    }
                }
            } //success
        });
    }
});


function deleteFeedback(feedback_id){

    $.ajax({
        url: "../serverside/post.php",
        type: "POST",
        data: {
            func: 79,
            feedback_id:feedback_id,
        },
        success:function(data){
            if (data.trim() == "true") {
                swal("Delete successfully", "", "success").then((value) => {
                    location.reload();
                });

            }else {
                swal("Failed to delete ", "", "error").then((value) => {

                });

            }

        }//success

    });
}

$("#UpdaterateUser").submit(function (event) {
    event.preventDefault();
    let stars=$("input[name='rating']:checked").val();
    let message=$('textarea#message').val();
    if(message =='' || stars == 'undefined'){
        swal("Missing Info", "Kindly give rating and enter a message ", "info");
        return;
    }

    var ajax_data = new FormData();
    //append into ajax data
    ajax_data.append("func", '80');
    ajax_data.append('stars',stars);
    ajax_data.append('message',message);
    ajax_data.append('id',$('#feedback_id').val());
    $.ajax({
        url: "../serverside/post.php",
        type: "POST",
        processData: false,
        contentType: false,
        data:ajax_data,
        success: function (data) {
            if(data.trim() == "true") {
                swal("Review Update Successfully", "", "success").then((value) => {
                    location.reload();
                });
            }else {
                swal("Failed to update", "", "error");
            }
        }
    });
});

$("#replyToUser").submit(function (event) {
    event.preventDefault();
    let message=$('textarea#message').val();
    if(message ==''){
        swal("Missing Info", "Kindly give rating and enter a message ", "info");
        return;
    }

    var ajax_data = new FormData();
    //append into ajax data
    ajax_data.append("func", '81');
    ajax_data.append('message',message);
    ajax_data.append('feedback_id',$('#feedback_id').val());
    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        processData: false,
        contentType: false,
        data:ajax_data,
        success: function (data) {

            if(data.trim() == "true") {
                swal("Reply  add successfully", "", "success").then((value) => {
                    location.reload();
                });
            }else {
                swal("Failed to add reply", "", "error");
            }
        }
    });
});

$("#Updatereply").submit(function (event) {
    event.preventDefault();
    let message=$('textarea#reply_message').val();
    if(message ==''){
        swal("Missing Info", "Kindly give rating and enter a message ", "info");
        return;
    }

    var ajax_data = new FormData();
    //append into ajax data
    ajax_data.append("func", '82');
    ajax_data.append('message',message);
    ajax_data.append('reply_id',$('#reply_id').val());
    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        processData: false,
        contentType: false,
        data:ajax_data,
        success: function (data) {
            console.log(data)
            if(data.trim() == "true") {
                swal("Reply update successfully", "", "success").then((value) => {
                    location.reload();
                });
            }else {
                swal("Failed to update reply", "", "error");
            }
        }
    });
});

function deleteReply (id) {
    var ajax_data = new FormData();
    //append into ajax data
    ajax_data.append("func", '83');
    ajax_data.append('id',id);
    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        processData: false,
        contentType: false,
        data:ajax_data,
        success: function (data) {
            if(data.trim() == "true") {
                swal("Reply delete successfully", "", "success").then((value) => {
                    location.reload();
                });
            }else {
                swal("Failed to delete reply", "", "error");
            }
        }
    });
}

$("#add_account_details").submit(function (event) {
    event.preventDefault();

    var ajax_data = new FormData();
    //append into ajax data
    ajax_data.append("func", '84');
    ajax_data.append('account_name',$('#account_name').val());
    ajax_data.append('account_number',$('#account_number').val());
    ajax_data.append('sort_code',$('#sort_code').val());
    ajax_data.append('user_id',$('#account_user_id').val());
    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        processData: false,
        contentType: false,
        data:ajax_data,
        success: function (data) {
            console.log(data)
            if(data.trim() == "true") {
                Swal.fire({
                    title: 'Bank details saved successfully',
                    icon: 'success'
                }).then((value) => {
                    location.reload();
                });

            }else {
                Swal.fire({
                    title: 'Failed to save bank details',
                    icon: 'error'
                });

            }
        }
    });
});

$("#updateAccount_details").submit(function (event) {
    event.preventDefault();

    var ajax_data = new FormData();
    //append into ajax data
    ajax_data.append("func", '85');
    ajax_data.append('account_name',$('#update_account_name').val());
    ajax_data.append('account_number',$('#update_account_number').val());
    ajax_data.append('sort_code',$('#update_sort_code').val());
    ajax_data.append('user_id',$('#update_account_user_id').val());
    ajax_data.append('update_account_id',$('#update_account_id').val());
    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        processData: false,
        contentType: false,
        data:ajax_data,
        success: function (data) {
            console.log(data)
            if(data.trim() == "true") {
                Swal.fire({
                    title: 'Bank details updated successfully',
                    icon: 'success'
                }).then((value) => {
                    location.reload();
                });

            }else {
                Swal.fire({
                    title: 'Failed to update bank details',
                    icon: 'error'
                });

            }
        }
    });
});
function showUserAccount(user_id){
    $.ajax({
        url: "../serverside/post.php",
        type: "POST",
        data:{
            func:86,
            user_id:user_id,
        },
        success: function (data) {
            result=JSON.parse(data);
            if(result.status == true) {
                data=result.result;
                $("#append_account_details").html('');

                for (let i=0; i<data.length; i++) {
                    let appendData="";
                    appendData +=`
                     
                    <div class="form-group">    
                        <label class="d-block">Account Name:  <span>${data[i].account_name}</span> </label>
                        <label class="d-block">Account Number: <span>${data[i].account_number}</span></label>
                        <label class="d-block">Sort Code:  <span>${data[i].sort_code}</span></label>
                        `;

                    if(data[i].status==1 || data[i].status=='1'){
                        appendData+=` <label class="d-block" >Account Status:<span class="p-1 rounded-pill bg-success">Current</span></label>`;
                    }else{
                        appendData+=` <label class="d-block" >Account Status:<span class="p-1 rounded-pill bg-danger">Old</span></label>`;
                    }

                    appendData+=`<label class="d-block">Add Account Date:  <span>${data[i].create_date}</span></label>
                    </div> <hr>`;
                    $("#append_account_details").append(appendData);
                }

                $('#view_account').modal('show');

            }else {
                swal("Bank details are not found", "", "error");
            }
        }
    });

}

$("#reward_homeowner").submit(function (e){
    e.preventDefault();

    $.ajax({
        url: "../serverside/post.php",
        type: "POST",
        data: {
            func: 87,
            name:$("#homeowner_name").val(),
			   city:$("#homeowner_city").val(),
            reward_date:$("#reward_date").val(),
            reward_type:$("#reward_type option:selected").val(),
        },
		
        success: function (data) {
console.log(data);
            if (data.trim() == "true") {
                swal("Reward add successfully", "", "success").then((value) => {
                    location.reload();

                });
            }else {
				console.log(data);
                swal("Failed to add", "", "error");

            }
        }
    });

});

$("#reward_tradeperson").submit(function (e){
    e.preventDefault();
    $.ajax({
        url: "../serverside/post.php",
        type: "POST",
        data: {
            func: 88,
            name:$("#tradeperson_name").val(),
			city:$("#tradeperson_city").val(),
            reward_date:$("#reward_date1").val(),
            reward_type:$("#reward_type1 option:selected").val(),
        },
        success: function (data) {


            if (data.trim() == "true") {
                swal("Reward add successfully", "", "success").then((value) => {
                    location.reload();

                });
            }else {
                swal("Failed to add", "", "error");

            }
        }
    });

});

function deleteHomeOwnerReward(id) {
    swal({
        title: 'Are you sure to delete this reward?',
        icon: 'info',
        buttons: true,
        dangerMode: true,
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result) {
            $.ajax({
                url: "../serverside/post.php",
                type: "POST",
                data: {
                    func: 89,
                    id: id,
                },
                success: function (data) {

                    if (data.trim() == "true") {
                        swal({
                            icon: 'success',
                            title: 'success',
                            text: 'Reward delete successfully!',
                        }).then((result) => {
                            location.reload();
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to delete!'
                        });
                    }
                }//success
            });//ajax
        }
    });
}

function deleteTradesPeopleReward(id) {
    swal({
        title: 'Are you sure to delete this reward?',
        icon: 'info',
        buttons: true,
        dangerMode: true,
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result) {
            $.ajax({
                url: "../serverside/post.php",
                type: "POST",
                data: {
                    func: 90,
                    id: id,
                },
                success: function (data) {

                    if (data.trim() == "true") {
                        swal({
                            icon: 'success',
                            title: 'success',
                            text: 'Reward delete successfully!',
                        }).then((result) => {
                            location.reload();
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to delete!'
                        });
                    }
                }//success
            });//ajax
        }
    });
}

//Add Social media links
$("#social_media_link").submit(function(event){
    event.preventDefault();

    var ajax_data = new FormData();
    //append into ajax data
    ajax_data.append("func", '91');
    ajax_data.append("userid", $("#uuuu_id").val());
    ajax_data.append("link", $("#link").val());
    ajax_data.append("social_type", $("#social_type option:selected").val());

    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        processData:false,
        contentType:false,
        data:ajax_data,
        success: function (data) {
            $("#social_media_modal").modal('toggle');

            if (data.trim() == "true") {
                Swal.fire({
                    title: 'Success',
                    text: 'Social media account added successfully',
                    icon: 'success'
                }).then((value) => {
                    location.reload();
                });

            }
            else {
                Swal.fire({
                    title: 'Failed to add social media account!',
                    icon: 'error'
                });


            }
        }
    });
});

function deleteSocialAccount(id) {
    Swal.fire({ 
        title: 'Account Unlinking Confirmation',
        text: 'Are you sure you want to unlink your social media account?',
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, unlink it!',
        cancelButtonText: 'Cancel',
        dangerMode: true,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "serverside/post.php",
                type: "POST",
                data: {
                    func: 92,
                    link_id: id,
                },
                success: function (data) {
                    if (data.trim() == "true") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Account deleted successfully!',
                        }).then((result) => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to delete account!'
                        });
                    }
                }
            });
        }
    });

}//

function deleteProfileMainCat(id,user_id) {
    Swal.fire({ 
        title: 'Account Unlinking Skill',
        text: 'Are you sure you want to delete your Skill?',
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
        dangerMode: true,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "serverside/post.php",
                type: "POST",
                data: {
                    func: 117,
                    cat_id: id,
                    user_id : user_id,
                },
                success: function (data) {
                    if (data.trim() == "true") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Skill deleted successfully!',
                        }).then((result) => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to delete Skill!'
                        });
                    }
                }
            });
        }
    });

}//


$("#homeowner_btn").click(function (e){
    e.preventDefault();
    $("#homeowner_btn").attr("disabled", true);
    $("#homeowner_btn").html("Please wait...");

    console.log($("#homeowner_email").val()+" "+$("#homeowner_id").val()+" "+$("#homeowner_name").val());

    $.ajax({
        url: "../serverside/post.php",
        type: "POST",
        data: {
            func: 93,
            email:$("#homeowner_email").val(),
            user_id:$("#homeowner_id").val(),
            name:$("#homeowner_name").val(),
			town:$("#homeowner_town").val(),
            reward_date:$("#reward_date").val(),
            reward_type:$("#reward_type option:selected").val(),
        },
        success: function (data) {
            console.log(data)
            $("#givereward").modal('toggle');
            if (data.trim() == "true") {
                swal("Reward add successfully", "", "success").then((value) => {
                    // location.reload();

                });
            }else {
                swal("Failed to add", "", "error");

            }
            $("#homeowner_btn").attr("disabled", false);
            $("#homeowner_btn").html("Submit");
        }
    });

});

$("#tradesperson_btn").click(function (e){
    e.preventDefault();

    $("#tradesperson_btn").attr("disabled", true);
    $("#tradesperson_btn").html("Please wait...");

    $.ajax({
        url: "../serverside/post.php",
        type: "POST",
        data: {
            func: 94,
            email:$("#tradeperson_email").val(),
            user_id:$("#tradeperson_id").val(),
            name:$("#tradeperson_name").val(),
			town:$("#tradeperson_town").val(),
            reward_date:$("#reward_date1").val(),
            reward_type:$("#reward_type1 option:selected").val(),
        },
        success: function (data) {
            $("#givereward").modal('toggle');
            if (data.trim() == "true") {
                swal("Reward add successfully", "", "success").then((value) => {
                    // location.reload();

                });
            }else {
                swal("Failed to add", "", "error");

            }
            $("#tradesperson_btn").attr("disabled", false);
            $("#tradesperson_btn").html("Submit");
        }
    });

});

function deleteChat(touserid,jobid,userid) {
    swal({
        title: 'Chat Deletion Confirmation',
		text: 'Are you sure you want to delete this chat?',
        icon: 'info',
        buttons: true,
        dangerMode: true,
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result) {
            $.ajax({
                url: "serverside/post.php",
                type: "POST",
                data: {
                    func: 95,
                    touserid:touserid,
                    jobid:jobid,
                    userid:userid,
                },
                success: function (data) {
                    if (data.trim() == "true") {
                        swal({
                            icon: 'success',
                            title: 'success',
                            text: 'Chat delete successfully!',
                        }).then((result) => {
                            window.location.href="chat";
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to delete chat!'
                        });
                    }
                }//success
            });//ajax
        }
    });
}//

$("#phone").change(function (e){
    e.preventDefault();
    $("#isphoneverifiy").val(0);
    $("#verification_phone").val($('#phone').val());
});


$("#verifiy_btn").click(function (e){
    e.preventDefault()
    $("#verifiy_btn").attr('disabled', true);
    $("#verifiy_btn").html("Please wait...");

    var baseURL = window.location.protocol + "//" + window.location.host;

    $.ajax({
        url: baseURL + "/serverside/post.php",
        type: "POST",
        data: {
            func: 97,
            verification_phone:$('#verification_phone').val(),
            verification_code:$('#verification_code').val(),
        },
        success: function (data) {

            $("#verifiymodal").modal('hide');

            if (data.trim() == "true") {
                $("#isphoneverifiy").val(1);
                swal("Success", "Your phone is verified successfully", "success").then((value) => {

                });
            }else{
                $("#isphoneverifiy").val(0);
                swal("Failed","Failed to verify phone","error")
            }
            $("#verifiy_btn").attr('disabled', false);
            $("#verifiy_btn").html("Verify");

        }
    });
});

// update your bio
$("#bio_form").submit(function(event){
    event.preventDefault();

    if (!pattern.test($("#phone").val())) {
        swal("Please enter a valid phone number", "");
        return;
    }

    if($("#isphoneverifiy").val()==0){

        $("#bio_btn").attr("disabled", true);
        $("#bio_btn").html("Please wait...");
        $.ajax({
            url: "serverside/post.php",
            type: "POST",
            // async: false,
            data: {
                func: 96,
                phone:$('#phone').val(),
            },
            success: function (data) {
                $("#verification_phone").val($('#phone').val());

                if (data.trim() == "true") {

                    swal("Success", "We send phone verification code on your phone number", "success").then((value) => {
                        $("#verifiymodal").modal('show');
                        $("#isphoneverifiy").val(0);
                    });

                }else if(data.trim() == "false"){
                    swal("Failed","Failed to send verification code, please click resend button.","error")
                }
                else if(data.trim() == "exist"){

                    $("#isphoneverifiy").val(1);

                    if($("#isphoneverifiy").val()==0){
                        swal("Alert", "Your phone is not verified, verify it to continue ", "error").then((value) => {
                            $("#verifiymodal").modal('show');
                            return;
                        });
                    } else {

                    }
                }
                $("#bio_btn").attr("disabled", false);
                $("#bio_btn").html("Edit Bio");

            }
        });
    }else {


        $("#bio_btn").attr("disabled", true);
        $("#bio_btn").html("Please wait...");
        $.ajax({
            url: "serverside/post.php",
            type: "POST",
            data: {
                func: 98,
                userid: $("#u1_id").val(),
                trading_name: $("#trading_name").val(),
                fname: $("#fname").val(),
                lname: $("#lname").val(),
                phone: $("#phone").val(),
            },
            success: function (data) {

                if (data.trim() == "true") {
                    // swal("Uploaded Successfully", "Your image/video is added in your galler", "success").then((value) => {
                    location.reload();
                    // });
                } else {
                    swal("Bio not updated", "Please try again ", "error");

                }
                $("#bio_btn").attr("disabled", true);
                $("#bio_btn").html("Please wait...");
            }

        });
    }
});

// add description to post
$("#add_description_job").submit(function(event){
    event.preventDefault();
    if($('textarea#description').val()==''){
        swal("Please enter your description ", "", "info");
        return;
    }

    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        data:{
            func:99,
            jobid:$("#jobid1").val(),
            description:$("textarea#description").val(),
        },
        success: function (data) {

            if (data.trim() == "true") {
                // swal("Uploaded Successfully", "Your image/video is added in your galler", "success").then((value) => {
                location.reload();
                // });
            }
            else {
                swal("Description not saved", "Please try again ", "error");

            }
        }//success
    });
});//des_form
function RepostJob(id) {

    swal({
        title: 'Are you sure to repost this job?',
        text:' All the shortlisted and hired tradesperson are removed from this job.',
        icon: 'info',
        buttons: true,
        dangerMode: true,
    }).then((result) => {

        if (result) {
            $.ajax({
                url: "../serverside/post.php",
                type: "POST",
                data: {
                    func: 100,
                    id: id,
                },
                success: function (data) {
                    if (data.trim() == "true") {
                        swal({
                            icon: 'success',
                            title: 'success',
                            text: 'Job repost successfully!',
                        }).then((result) => {
                            location.reload();
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to repost!'
                        });
                    }
                }//success
            });//ajax
        }
    });
}
function completeJobadmin(id) {

    swal({
        title: 'Are you sure you want to mark this as completed?',
        text:' The jobs person status will need to be in progress for this to work',
        icon: 'info',
        buttons: true,
        dangerMode: true,
    }).then((result) => {

        if (result) {
            $.ajax({
                url: "../serverside/post.php",
                type: "POST",
                data: {
                    func: 350,
                    id: id,
                },
                success: function (data) {
                    if (data.trim() == "true") {
                        swal({
                            icon: 'success',
                            title: 'success',
                            text: 'Job successfully marked completed!',
                        }).then((result) => {
                            location.reload();
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to complete!'
                        });
                    }
                }//success
            });//ajax
        }
    });
}
$("#forgetEmail").submit(function (event) {
    event.preventDefault();
    if (!pattern.test($("#phone_number").val())) {
        swal("Phone format not Match", "", "info");
        return;
    }
    $("#verifiy_btn1").attr('disabled', true);
    $("#verifiy_btn1").html("Please wait...");

    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        data: {
            func: 101,
            phone:$('#phone_number').val(),
        },
        success: function (data) {

            if (data.trim() == "true") {
                swal("Success", "We send message on your mobile number ", "success").then((value) => {
                    location.reload();
                });
            } else if (data.trim() == "phone-not-exist") {

                swal("", "Phone number is not found, Check your phone number, and try again!", "error");
            }else {
                swal("Not Submit", "Kindly Resubmit", "error");

            }
            $("#verifiy_btn1").attr('disabled', false);
            $("#verifiy_btn1").html("Submit");
        }//scccess
    });

});
$("#update_notification").submit(function (event) {
    event.preventDefault();
    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        data: {
            func: 102,
            user_id:$("#user").val(),
            new_lead_phone:false,
            new_lead_email:$('#new_lead_email').is(':checked'),
            new_lead_app:$('#new_lead_app').is(':checked'),

            shortlist_phone:false,
            shortlist_email:$('#shortlist_email').is(':checked'),
            shortlist_app:$('#shortlist_app').is(':checked'),

            hire_phone:$('#hire_phone').is(':checked'),
            hire_email:$('#hire_email').is(':checked'),
            hire_app:$('#hire_app').is(':checked'),

            feedback_phone:false,
            feedback_email:$('#feedback_email').is(':checked'),
            feedback_app:$('#feedback_app').is(':checked'),

        },
        success: function (data) {
            console.log(data);
            if (data.trim() == "true") {
                swal("Submit Successfully", "Your request saved successfully", "success").then((value) => {
                    location.reload();
                });
            }else {
                swal("Not Submit", "Kindly Resubmit", "error");

            }
        }
    });
});
//Add Blog
$("#addBlog").submit(function (event) {
    event.preventDefault();
    var short_des = tinymce.get("short_description").getContent();
    var long_des = tinymce.get("long_description").getContent();

    if(short_des==""){
        swal("Short Description is missing","","info");
        return;
    }
    if(long_des==""){
        swal("Long Description is missing","","info");
        return;
    }
    len=document.getElementById('image').files.length;

    if(len<=0){
        swal("Blog image is missing","","info");
        return;
    }


    $("#blog_btn").html(`Please wait... <i class="fa fa-spinner fa-spin" style="font-size:24px"></i>`);
    $("#blog_btn").prop('disabled', true);

    var ajax_data = new FormData();
    ajax_data.append("func", '103');
    ajax_data.append('publish_date',$("#publish_date").val());
    ajax_data.append('author',$("#author").val());
    ajax_data.append('title',$("#title").val());
    ajax_data.append('category',$("#category1 option:selected").val());

    user_category=$("#category1 option:selected").val();
    if(user_category=="Professionals"){
        ajax_data.append('blog_category',$("#tradespeople_category option:selected").val());
    }else {
        ajax_data.append('blog_category',$("#home_owners_category option:selected").val());
    }


    ajax_data.append('select_main_category',$("#select_main_category option:selected").val());
    ajax_data.append('short_des', short_des);
    ajax_data.append('long_des', long_des);
    ajax_data.append('image', $('#image')[0].files[0]);

console.log(ajax_data);

    $.ajax({
        url: "../serverside/post.php",
        type: "POST",
        processData: false,
        contentType: false,
        data:ajax_data,
        success: function (data) {
            console.log(data);
            if (data.trim() == "true") {
                swal("success", "Blog submit successfully!", "success")
                    .then((value) => {
                        location.reload();
                    });
            } else {
                swal("Error", "Failed to add blog!", "error");
            }

            $("#blog_btn").html('Submit');
            $("#blog_btn").prop('disabled', false);
        }//success
    });//ajax
});
function DeleteBlog(blog_id){

    swal({
        title: "Are you sure to delete this blog?",
        text: "Once deleted, you will not be able to recover!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "../serverside/post.php",
                    type: "post",
                    data: {
                        func: 104,
                        blog_id: blog_id
                    },
                    success: function (data) {

                        if (data.trim() == "true") {
                            swal("success", "Blog has been deleted", "success")
                                .then((value) => {
                                    location.reload();
                                });
                        } else {
                            swal("Error! Failed to delete blog!", {
                                icon: "error",
                            });
                        }
                    }//success function
                });//ajax
            }//will delete
        });//then

}
// Edit blog
$("#editBlog").submit(function (event) {
    event.preventDefault();
    var short_des = tinymce.get("short_description").getContent();
    var long_des = tinymce.get("long_description").getContent();


    if(short_des==""){
        swal("Short Description is missing","","info");
        return;
    }
    if(long_des==""){
        swal("Long Description is missing","","info");
        return;
    }


    $("#blog_btn").html(`Please wait... <i class="fa fa-spinner fa-spin" style="font-size:24px"></i>`);
    $("#blog_btn").prop('disabled', true);

    var ajax_data = new FormData();
    ajax_data.append("func", '105');
    ajax_data.append('id', $("#blog_id").val());
    ajax_data.append('publish_date',$("#publish_date").val());
    ajax_data.append('author',$("#author").val());
    ajax_data.append('title',$("#title").val());
    ajax_data.append('category',$("#category1 option:selected").val());
    ajax_data.append('select_main_category',$("#select_main_category option:selected").val());

    user_category=$("#category1 option:selected").val();
    if(user_category=="Professionals"){
        ajax_data.append('blog_category',$("#tradespeople_category option:selected").val());
    }else {
        ajax_data.append('blog_category',$("#home_owners_category option:selected").val());
    }

    
    ajax_data.append('short_des', short_des);
    ajax_data.append('long_des', long_des);
    ajax_data.append('image', $('#image')[0].files[0]);

    console.log(ajax_data);

    $.ajax({
        url: "../serverside/post.php",
        type: "POST",
        processData: false,
        contentType: false,
        data:ajax_data,
        success: function (data) {

            if (data.trim() == "true") {
                swal("success", "Blog update successfully!", "success")
                    .then((value) => {
                        window.location.href='dashboard-manage-blogs';
                    });
            } else {
                swal("Error", "Failed to update blog!", "error");
            }

            $("#blog_btn").html('Update');
            $("#blog_btn").prop('disabled', false);
        }//success
    });//ajax
});

function BlogNotification(id){

    swal({
        title: "Are you sure to send notification of this blog?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $("#notificationButton"+id).html('Please wait...');
                $("#notificationButton"+id).prop('disabled', true);
                $.ajax({
                    url: "../serverside/post.php",
                    type: "post",
                    data: {
                        func: 106,
                        id:id,
                    },
                    success: function (data) {
                        console.log(data)
                        if (data.trim() == "true") {

                            swal("Success","Blog notification send successfully","success").then((value)=>{

                            });
                        } else {
                            swal("Error! Failed to send notification!","","error");
                        }
                        $("#notificationButton"+id).html('Send notification');
                        $("#notificationButton"+id).prop('disabled', false);
                    }//success function
                });//ajax
            }//will delete
        });//then

}
$("#electrical_certification").submit(function (e){
    e.preventDefault();
    var no_files=0;
    var ajax_data = new FormData();
    ajax_data.append("func", '107');
    ajax_data.append('NICEIC', $('#NICEIC')[0].files[0]);
    ajax_data.append('ECA', $('#ECA')[0].files[0]);
    ajax_data.append('NAPIT', $('#NAPIT')[0].files[0]);
    ajax_data.append('gold', $('#gold')[0].files[0]);
    ajax_data.append('inspection', $('#inspection')[0].files[0]);
    ajax_data.append('edition', $('#edition')[0].files[0]);
    ajax_data.append('level3', $('#level3')[0].files[0]);
    ajax_data.append('id_card', $('#id_card')[0].files[0]);


    let category_id=$("#category_id").val();
    $("#submit_files").attr("disabled", true);
    $("#submit_files").html("Please wait...");
    $("#loader").show(); // Show the loader

    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        processData: false,
        contentType: false,
        data:ajax_data,
        success: function (data) {
            console.log(data)

            if (data.trim() == "true") {

                swal("Certifications uploaded  successfully", "", "success").then((result) => {
                    window.location.href="quiz?main_Category_id="+category_id+"&ajax=1";
                });

            }else if(data.trim() == "<3"){
                swal("Please upload at least 3 documents","","info").then((value)=>{

                });
            } else {

                swal("", "Failed to upload certifications", "error");
            }

            $("#submit_files").attr("disabled", false);
            $("#submit_files").html("Start Quiz");
            $("#loader").hide(); // Hide the loader
        }//succes
    });//ajax
});

$("#gas_certification").submit(function (e){
    e.preventDefault();

    $("#submit_gas").attr("disabled", true);
    $("#submit_gas").html("Please wait...");
    $("#loader").show(); // Show the loader

    var ajax_data = new FormData();
    ajax_data.append("func", '108');
    ajax_data.append('certificate', $('#certificate')[0].files[0]);
    ajax_data.append('id_card_gas', $('#id_card_gas')[0].files[0]);
    ajax_data.append('registration_number', $('#registration_number').val());

    let category_id=$("#category_id").val();

    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        processData: false,
        contentType: false,
        data:ajax_data,
        success: function (data) {

            if (data.trim() == "true") {

                swal("Certifications uploaded  successfully", "", "success").then((result) => {
                    window.location.href="quiz?main_Category_id="+category_id+"&ajax=1";
                });

            }else if(data.trim() == "same_number"){
         swal("", "This gas safe registration number is already registered on our site. Please contact us if you require assistance", "info");
           } else {

                swal("", "Failed to upload certifications", "error");
            }

            $("#submit_gas").attr("disabled", false);
            $("#submit_gas").html("Start Quiz");
            $("#loader").hide(); // Hide the loader
        }//succes
    });//ajax
});
function electrical_verify(id,user_id){

    swal({
        title: "Are you sure to verify?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $("#electrical_verify").html(`Please wait... <i class="fa fa-spinner fa-spin" style="font-size:24px"></i>`);
                $("#electrical_verify").prop('disabled', true);
                $.ajax({
                    url: "../serverside/post.php",
                    type: "post",
                    data: {
                        func: 109,
                        id:id,
                        user_id,user_id,
                    },
                    success: function (data) {
                        console.log(data)
                        if (data.trim() == "true") {
                            swal("Success", "Verify successfully", "success")
                                .then((value) => {
                                    window.location.href="dashboard-verify-users";
                                });
                        } else {
                            swal("Failed to verify","","error")
                        }
                        $("#electrical_verify").html('Verify');
                        $("#electrical_verify").prop('disabled', false);
                    }//success function
                });//ajax
            }//
        });//then

}
function gas_verify(id,user_id){

    swal({
        title: "Are you sure to verify?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $("#gas_verify").html(`Please wait... <i class="fa fa-spinner fa-spin" style="font-size:24px"></i>`);
                $("#gas_verify").prop('disabled', true);
                $.ajax({
                    url: "../serverside/post.php",
                    type: "post",
                    data: {
                        func: 110,
                        id:id,
                        user_id,user_id,
                    },
                    success: function (data) {

                        if (data.trim() == "true") {
                            swal("Success", "Verify successfully", "success")
                                .then((value) => {
                                    window.location.href="dashboard-verify-users";
                                });

                        } else {
                            swal("Failed to verify","","error")
                        }
                        $("#gas_verify").html('Verify');
                        $("#gas_verify").prop('disabled', false);
                    }//success function
                });//ajax
            }//
        });//then

}


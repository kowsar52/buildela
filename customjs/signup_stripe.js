// Create an instance of Elements.
var elements = stripe.elements();
// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
    base: {
        color: '#32325d',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
            color: '#aab7c4'
        }
    },
    invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
    }
};

//style button with bootstrap
//
// document.querySelector('#payment-form button')
// .classList = 'btn btn-primary btn-block mt-4';
//

// Create an instance of the card Element.
var card = elements.create('card', {style: style});

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.addEventListener('change', function(event) {

    if (event.error) {

        $('#card-errors').html(event.error.message);
    } else {

        $('#card-errors').html('');
    }
});

// Handle form submission.
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
    event.preventDefault();
    
    var   amount=$('#plans').val();
    
    if(amount==0){
        swal("Alert", "Please select payment plan!", "info");
        return;
    }
    $("#skip_btn").hide();
    $("#payment_btn").html(`Please wait <i class="fa fa-spinner fa-spin" style="font-size:24px"></i>`);
    $("#payment_btn").attr('disabled', true);

    stripe.createToken(card).then(function(result) {
        if (result.error) {
            // Inform the user if there was an error.
            $('#card-errors').html(result.error.message);
            $("#payment_btn").html("Start paid membership");
            $("#payment_btn").attr('disabled', false);
        } else {
            // Send the token to your server.
            // stripeTokenHandler(result.token);
            $("#payment_btn").html(`Please wait <i class="fa fa-spinner fa-spin" style="font-size:24px"></i>`);
            $("#payment_btn").attr('disabled', true);

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
            ajax_data.append('country', $('#country').val());
            ajax_data.append('post_code', $('#post_code').val());


            $.ajax({
                url: "serverside/post.php",
                type: "POST",
                processData: false,
                contentType: false,
                data:ajax_data,
                async: false,
                success: function (data) {
                    if (data.trim() == "true") {
                        $.ajax({
                            url:"serverside/post.php",
                            type:"POST",
                            async: false,
                            data:{
                                func:37,
                                token:result.token.id,
                                amount:amount,

                            },
                            success: function (data){

                                data=JSON.parse(data);

                                if(data.success){
                                    $.ajax({
                                        url:"serverside/post.php",
                                        type:"POST",
                                        async: false,
                                        data:{
                                            func:38,
                                            userid:data.userid,
                                            object:data.result,
                                            cus_stripe_id:data.cus_stripe_id,
                                            amount:amount,
                                        },
                                        success: function (response){

                                            console.log(data);

                                            if(response.trim()=="true"){
                                                swal("Register!", "You are registered successfully, please head to your profile and take the quiz on your selected trade!", "success").then((value) => {
                                                    window.location.href = "welcome";
                                                });
                                            }else{
                                                swal("Error","Failed transaction, contact admin, don\'t try again!","error").then((result) => {
                                                    location.reload();
                                                });
                                            }//else
                                            $("#payment_btn").html("Start paid membership");
                                            $("#payment_btn").attr('disabled', false);
                                        }//success
                                    });//ajax

                                }else {
                                    swal("Transaction Failed", "Please try again", "info").then((value)=>{
                                        $("#payment_btn").html("Start paid membership");
                                        $("#payment_btn").attr('disabled', false);
                                    });
                                }
                                $("#payment_btn").html("Start paid membership");
                                $("#payment_btn").attr('disabled', false);
                            }//success
                        });//ajax
                    } else if (data.trim() == "email-exist") {
                        swal("Email-exist", "Try with other email", "info").then((value)=>{
                            $("#payment_btn").html("Start paid membership");
                            $("#payment_btn").attr('disabled', false);
                        });

                    } else if (data.trim() == "fill-fields") {
                        swal("Missing details", "Kindly fill all the input fields", "info").then((value)=>{
                            $("#payment_btn").html("Start paid membership");
                            $("#payment_btn").attr('disabled', false);
                        });
                    } else {
                        swal("Not registered", "Error, try again", "error").then((value)=>{
                            $("#payment_btn").html("Start paid membership");
                            $("#payment_btn").attr('disabled', false);
                        });
                    }
                    // $("#payment_btn").html("Start paid membership");
                    // $("#payment_btn").attr('disabled', false);
                }//success
            });//ajax

        }
    });
});



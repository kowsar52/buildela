

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
  var amount=$('#plans').val();
  console.log(amount);
  if(amount==0){
    swal("Alert", "Please select payment plan!", "info");
    return;
  }
  $("#payment_btn").html(`Please wait <i class="fa fa-spinner fa-spin" style="font-size:24px"></i>`);
  $("#payment_btn").prop('disabled', true);

  stripe.createToken(card).then(function(result) {
    if (result.error) {
      // Inform the user if there was an error.
      $('#card-errors').html(result.error.message);
      $("#payment_btn").html("Start paid membership");
      $("#payment_btn").prop('disabled', false);
    } else {
      // Send the token to your server.
      // stripeTokenHandler(result.token);
      $("#payment_btn").html(`Please wait <i class="fa fa-spinner fa-spin" style="font-size:24px"></i>`);
      $("#payment_btn").prop('disabled', true);

      $.ajax({
        url:"serverside/post.php",
        type:"POST",
        data:{
          func:37,
          token:result.token.id,
          amount:amount
        },
        success: function (data){

          data=JSON.parse(data);
          if(data.success){
            $.ajax({
              url:"serverside/post.php",
              type:"POST",
              data:{
                func:38,
                userid:data.userid,
                object:data.result,
                cus_stripe_id:data.cus_stripe_id,
                amount:amount,

              },
              success: function (response){

                if(response.trim()=="true"){
                  swal("Subscription Successful","Thank you for subscribing!","success")
                      .then((result) => {
                        location.reload();
                      });
                }else{
                  swal("Error","Failed transaction, contact admin, don\'t try again!","error").then((result) => {
                    location.reload();
                  });
                }//else
              }//success
            });//ajax

          }else {
            swal("Error","Failed transaction, contact admin, don\'t try again!","error").then((result) => {
              location.reload();
            });
          }
        }//success
      });//ajax
    }
  });
});


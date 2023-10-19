    function checklogin(e){
        e.preventDefault();

        if ($("#title").val()=='') {
            swal("Job title is missing", "", "info");
            $( "#title" ).focus();
            return;
        }
        else if($("#post_code").val()==''){
            swal("Job post code is missing", "", "info");
            $( "#post_code" ).focus();
            return;

        }else if($('textarea#note').val()==''){
            swal("Job discription is missing", "", "info");
            $( "#note" ).focus();
            return;
        }

        $(".continue_btn3").attr("disabled", true);
        $(".continue_btn3").html("Please wait...");

        let post_code=$('#post_code').val();
		
        var ajax_data = new FormData();
        ajax_data.append("func", '52');
        ajax_data.append('post_code',post_code );
  //alert(post_code);
        $.ajax({
            url: "https://jobsunlocked.com/serverside/post.php",
            type: "POST",
            processData: false,
            contentType: false,
            data:ajax_data,
            success: function (data) {
//alert(data);
                if(data.trim()!=200){
					alert(data);
                    swal("Invalid postcode", "please enter a valid postcode!", "info");
                    $("#post_code").val('');
                    $( "#post_code" ).focus();
                    return;
                }else {

                    $("#notLoginButton").hide();
                    $("#addsignupform").show();
                    $("#question-3").hide();
                    $("#addsignupform").html('');
                    $("#addsignupform").append(`
									<form id="signup_user2">
                                        <div class="form-group">
                                        <label for="email1">Email</label>
                                        <input type="email" required class="form-control-lg form-control" id="email1">
                                        </div>
                                        

									    <button type ='button' class="post-a-job-continue-btn btn-block
                                                text-white text-center px-5 py-2 font-weight-bold rounded" id="email-btn">Next
                                        </button>

 </div>
                                        <button id="new-back-btn-4" onclick="goback1(event)" type="button"  class="text-decoration-none align-items-center border p-2 rounded m-1 btn">
                                            <i class="fa fa-angle-left"></i>
                                                Back
                                        </button>
									</form>
									`);
                }//else

            }//succes
        });//check post_code ajax

        $(".continue_btn3").attr("disabled", false);
        $(".continue_btn3").html("POST");

        // }//if not login
    }//check login method


 document.getElementById('note').innerHTML = document.getElementById('note').innerHTML.trim();

  $('#searchpx').on('click', function() {
    $('#searchModal').modal('show');
  });

  // This event is triggered when the modal has been shown
  $('#searchModal').on('shown.bs.modal', function() {
    $("#search_main_type1").focus();
  });

  $(document).ready(function() {
    $("#searchpx").keyup(function() {
      $("#search_main_type1").val($("#searchpx").val());
    });

    $(".searchpx").click(function() {
      var catclick = $(this).attr("value");
      $('#searchModal').modal('show');
      $('#search_main_type1').val(catclick).trigger('keyup');
    });
  });
  
  $("#addoption").submit(function (event) {
    event.preventDefault();
    var type=$( "#select_option option:selected" ).val();
    $.ajax({
        url: "https://jobsunlocked.com/serverside/post.php",
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
//

//
//
//     if(selectedID==''){
//         swal("Select Category", "Please Select main category", "info").then((value) => {
//             location.reload();
//         });
//     }
//     $.ajax({
//         url: "serverside/post.php",
//         type: "POST",
//         data: {
//             func: 16,
//             selectedID:selectedID,
//         },
//         success: function (data) {
//             var mydata = JSON.parse(data);
//             if (data.trim() == "false") {
//                 swal("Not Found ", "Not found any sub category for this main category", "error").then((value) => {
//                 });
//             }else {
//                 $('#checkboxs').html('');
//                 // $('#checkboxs').append(`<h1>Your job involve</h1>`);
//                 $("#what_need").text('What do you need a '+name+' to help with?')
//                 for(let i = 0; i <mydata.length ; i++){
//                     $('#checkboxs').append(`
//                        <label class="radio-btn rounded">
//                                 <input type="radio" onclick="setOptions(${mydata[i].id});" name="involve" id="${mydata[i].id}" value="${mydata[i].id}" class="card-input-element" />
//                                 <div class="panel panel-default card-input p-2 d-flex flex-wrap align-items-center justify-content-between">
//                                     <div>
//                                         ${mydata[i].category_name}
//                                     </div>
//                                     <i class="fa fa-angle-right"></i>
//                                     </div>
//                             </label>
// `);
//                 }
//
//                 $("#post-a-job-new-card-two").show();
//                 $("#post-a-job-new-card-one").hide();
//                 $("#post-a-job-new-card-three").hide();
//             }
//         }
//     });
}

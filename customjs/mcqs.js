  // var questions = [
  // {
  //   question: "What are some reasons why creamzone might not resolve a damp problem?",
  //   choices: ["Hold the hammer in contact with the glazing","Use a rubber mallet", "Use screw-in sprigs","Apply protective tape on the glazing"],
  //   correctAnswer: "Apply protective tape on the glazing"
  // }, {
  //   question: "What is 3*6? 2",
  //   choices: [2, 6, 9, 12, 18],
  //   correctAnswer: 4
  // }, {
  //   question: "What is 8*9? 3",
  //   choices: [3, 99, 108, 134, 156],
  //   correctAnswer: 0
  // }, {
  //   question: "What is 8*9? 4",
  //   choices: [4, 99, 108, 134, 156],
  //   correctAnswer: 0
  // }, {
  //   question: "What is 8*9? 5",
  //   choices: [5, 99, 108, 134, 156],
  //   correctAnswer: 0
  // }
  // ];
  const urlParams = new URLSearchParams(window.location.search);
      const sub_category_id = urlParams.get('sub_Category_id');
      const main_category_id = urlParams.get('main_Category_id');

      
    
  var questions = [];

var anwers = new Array();

var questioncounter = 0;
var totallength = questions.length;

  $("#question_no").html(questioncounter+1);
$('#prev').click(function(e){
  e.preventDefault();
  if(questioncounter > 0 ){
    // if($('input[name="option_radio"]:checked').length <= 0){
    //   alert('Please select atleast one option, thanks!');
    //   return;
    // }
    // anwers[questioncounter] = $('input[name="option_radio"]:checked').val();
    // $('input[name="option_radio"]').prop('checked', false);
    questioncounter--;
     $('#question').html(questions[questioncounter].question);
    $("#option1").html(questions[questioncounter].option1);
    $("#option2").html(questions[questioncounter].option2);
    $("#option3").html(questions[questioncounter].option3);
    $("#option4").html(questions[questioncounter].option4);
   $('#option1_radio').val(questions[questioncounter].option1);
   $('#option2_radio').val(questions[questioncounter].option2);
   $('#option3_radio').val(questions[questioncounter].option3);
   $('#option4_radio').val(questions[questioncounter].option4);
  }
    $("#question_no").html(questioncounter+1);
});


$('#next').click(function(e){
  e.preventDefault();
  if(questioncounter < totallength-1 ){
    if($('input[name="option_radio"]:checked').length <= 0){
      alert('Please select at least one option, thanks!');
      return;
    }
    anwers[questioncounter] = $('input[name="option_radio"]:checked').val();
    $('input[name="option_radio"]').prop('checked', false);
    questioncounter++
   $('#question').html(questions[questioncounter].question);
    var optionarray = [];
    optionarray.push(questions[questioncounter].option1);
    optionarray.push(questions[questioncounter].option2);
    optionarray.push(questions[questioncounter].option3);
    optionarray.push(questions[questioncounter].option4);
    optionarray.sort(() => Math.random() - 0.5);

    $("#option1").html(optionarray[0]);
    $("#option2").html(optionarray[1]);
    $("#option3").html(optionarray[2]);
    $("#option4").html(optionarray[3]);

   $('#option1_radio').val(optionarray[0]);
   $('#option2_radio').val(optionarray[1]);
   $('#option3_radio').val(optionarray[2]);
   $('#option4_radio').val(optionarray[3]);

      $("#question_no").html(questioncounter+1);
  }else{
    // alert('last next');

    anwers[questioncounter] = $('input[name="option_radio"]:checked').val();
    var correctanswercounter = 0;
    for(var x = 0; x < questions.length; x++){
      if(questions[x].right_ans == anwers[x]){
        correctanswercounter++;
      }

    }
    // alert(correctanswercounter);
    // alert(questions.length);
    // console.log(anwers);
    var score = (correctanswercounter / questions.length ) * 100;
    // alert(score);
    var status=0;
    if (score>70) {
      status=1;
    }
    
    $.ajax({
        url: "serverside/post.php",
        type: "POST",
        data: {
            func: 25,
            main_category_id:main_category_id,
            sub_category_id:sub_category_id,
            score:score,
            status:status
            
        },
        success: function (data) {            
            if (data.trim() == "true") {
                    if(score>70){

                      swal("", "Congratulations, you score "+score.toFixed(2)+" %.You will recive job for this trade in your chosen work area.", "success").then((value) => {              

                          // window.location.href = "my-profile";
                          window.location.href = "complete_registration";
                
                    });
                

                    }else{

                      swal("", "Hey, please try the quiz again, to start receiving jobs for this trade in your area. Your score "+score.toFixed(2)+" %.", "info").then((value) => {              

                          window.location.href = "my-profile";
                
                    });
                

                    }    

            } else {
                swal("Something went wrong!", "Kindly try again", "error");
            }
        }
    });
  }
  

});





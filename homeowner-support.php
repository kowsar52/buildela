<?php include_once "includes/header.php";?>
<style>
.home-owner-support-link{
	border-radius: 4px;
	font-size: 20px;
	color: #000 !important;
	font-family: Montserrat, sans-serif!important;
	font-family:Lato-Bold;
}
.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active{
border-left: 5px solid  #006bf5 !important;
box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
background-color: #fff !important;
border-top:unset !important;
border-right:unset !important;
border-bottom:unset !important;
}
.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link:hover{
/*	box-shadow: -5px 0px 0px 0px #006bf5;
-webkit-box-shadow: -5px 0px 0px 0px #006bf5;
-moz-box-shadow: -5px 0px 0px 0px #006bf5;
border:unset !important;*/
border-left: 5px solid  #006bf5 !important;
box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
background-color: #fff !important;
border-top:unset !important;
border-right:unset !important;
border-bottom:unset !important;
}
.home-owner-support-header {
    background-color: #ffffff;
    padding: 10px 5px;
    border-radius: 4px;
    font-size: 1.25rem !important;
    margin-bottom: 5px !important;
    margin-top: 5px;
    font-weight: 700!important;
    font-family: 'Poppins', sans-serif;
}
.nav-tab-custom-styling{
	flex-direction: column !important; 
	justify-content: unset !important;
    align-items: flex-start !important;
    border-bottom:unset !important;
}
.home-owner-support-question , .privacy-question{
	color: #006bf5;
}
.nav-tabs .nav-link {
	background-color: #fff !important;
	margin-bottom: 5px!important;
	border: 1px solid #dddddd!important;
}
.home-owner-support-main-heading , .privacy-heading{
	color:#006bf5 !important;
}
.privacy-content{
	font-size: 15px;
	font-family: Montserrat, sans-serif!important;
}
.filter-conatiner{
	right: 0;
    z-index: 99999;
}
.filter-header{
	background-color: #006bf5;
	padding: 10px 5px;
}
.filter-heading{
	font-family: Montserrat, sans-serif!important;
	font-weight: bold;
	font-size: 22px;
	color: #000 !important;
}
.filter-conatiner{
	display: none;
}
.filter-label , .filter-input{
	cursor: pointer;
}

.home-owner-support-content {
    margin-bottom: 25px;
}
.home-owner-support-main-heading.h1.text-center {
    font-family: 'Poppins', sans-serif;
    font-weight: 800;
    font-size: 40px;
}
.container.py-5 {
    padding-bottom: 250px!important;
    text-align: left;
}
a.card-title {

    font-size: 16px;
    margin-bottom: 0rem;
    font-weight: 600;
}
.accordion {
    margin-bottom: 30px;
}
.accordion .card-header {
  position: relative;
    background-color: transparent;
    padding: 16px 16px 16px 42px;
    cursor: pointer;
}
.accordion .card-header:hover, .accordion .card-header[aria-expanded="true"] {
    background-color: aliceblue;
}
.accordion .card-body p {
    margin-bottom: 0;
}

.accordion .card-header[aria-expanded="false"]:before,.accordion .card-header[aria-expanded="true"]:before,.card-header.collapsed:before{
  position: absolute;
  left: 18px;
  top: 50%;
  transform: translateY(-50%);
  color: #D10A38;
  font-weight: 700;
}

.accordion .card-header[aria-expanded="false"]:before,.card-header.collapsed:before {
  content: "\2b";
  font-family: "Font Awesome 6 Brands";
}

.accordion .card-header[aria-expanded="true"]:before {
  content: "\f068";
  font-family: "Font Awesome 6 Free";

}
.accordion .card-body{
  border-bottom:1px solid rgba(0,0,0,.125);
}
</style>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<div class="container py-5">
	<div class="row mx-0 pb-5">
		<div class="col-md-12">
			<div class="home-owner-support-main-heading h1 text-center"> HomeOwner Support</div>
		</div>
	</div>
	
	<div class="home-owner-support-header h3 text-white">Posting a Job</div>
    <div id="accordion" class="accordion">
        <div class="card mb-0">
            <div class="card-header collapsed" data-toggle="collapse" href="#collapseOne">
                <a class="card-title">
                    Does it cost anything to post a job?
                </a>
            </div>
            <div id="collapseOne" class="collapse" data-parent="#accordion" >
                <div class="card-body">Posting a job on Buildela.com is free. 
                </div>
            </div>
            <div class="card-header collapsed" data-toggle="collapse" href="#collapseTwo">
                <a class="card-title">
                  What happens after I post my job?
                </a>
            </div>
            <div id="collapseTwo" class="collapse" data-parent="#accordion" >
                <div class="card-body">Your job posting will be carefully examined by our team and they may reach out to you for additional information if necessary. After your job is approved, we will notify nearby tradespeople who can then choose to show interest. You will be informed via email, text, and our app when tradespeople express interest in your job. You can then view the profiles and feedback of interested tradespeople, and choose which ones you would like to contact. Contact information is only shared at your discretion.

                </div>
            </div>
			
            <div class="card-header collapsed" data-toggle="collapse" href="#collapseThree">
                <a class="card-title">
                  Why do I need to verify my phone number?

                </a>
            </div>
            <div id="collapseThree" class="collapse" data-parent="#accordion" >
                <div class="card-body">To ensure that tradespeople you have selected can reach you, we require phone number verification. This ensures that we are providing the correct contact information to the right tradespeople. Your contact details will only be shared with the tradespeople you have selected.

                </div>
            </div> 

			<div class="card-header collapsed" data-toggle="collapse" href="#collapse4">
                <a class="card-title">
                 Can I post jobs for multiple properties using one account?


                </a>
            </div>
            <div id="collapse4" class="collapse" data-parent="#accordion" >
                <div class="card-body">Yes, you can post jobs for multiple properties using a single account. To ensure that your job is sent to the appropriate local tradespeople, make sure to enter the correct postal code for each job you post.

                </div>
            </div>
			
			
			<div class="card-header collapsed" data-toggle="collapse" href="#collapse5">
                <a class="card-title">
                 Can I edit my job details?



                </a>
            </div>
            <div id="collapse5" class="collapse" data-parent="#accordion" >
                <div class="card-body">You can edit your job description prior to it being approved. Once it has been published, you can add more information to the description but cannot change the details that have already been shared with tradespeople.

                </div>
            </div>
			
			
			<div class="card-header collapsed" data-toggle="collapse" href="#collapse6">
                <a class="card-title">
                How do I cancel my job?




                </a>
            </div>
            <div id="collapse6" class="collapse" data-parent="#accordion" >
                <div class="card-body">To cancel a job, go to the specific job page and select the “Cancel Job" button, typically located at the bottom of the page or on the left side of the screen. Remember to inform any shortlisted tradespeople that the job will no longer be proceeding.

                </div>
            </div>
			
			
        </div>
    </div>

		<div class="home-owner-support-header h3 text-white">Shortlisting</div>
	
	
	
	
	

    <div id="accordionshort" class="accordion">
        <div class="card mb-0">
            <div class="card-header collapsed" data-toggle="collapse" href="#st1">
                <a class="card-title">
                   What is shortlisting?

                </a>
            </div>
            <div id="st1" class="collapse" data-parent="#accordionshort" >
                <div class="card-body">Shortlisting allows you to share contact information with tradespeople who have expressed interest in your job. You can shortlist up to five tradespeople for a single job, this is crucial as it allows you to communicate, hire, and provide feedback to tradespeople.

                </div>
            </div>
            <div class="card-header collapsed" data-toggle="collapse" href="#st2">
                <a class="card-title">
                  How can I get more tradespeople?

                </a>
            </div>
            <div id="st2" class="collapse" data-parent="#accordionshort" >
                <div class="card-body">To attract more tradespeople to your job, make sure to include a detailed job description, preferred start date, and additional information and photos. If your job has not received interest within two days, it will be reposted automatically.

                </div>
            </div>
			
            <div class="card-header collapsed" data-toggle="collapse" href="#st3">
                <a class="card-title">
               Can I remove a tradesperson from my shortlist?

                </a>
            </div>
            <div id="st3" class="collapse" data-parent="#accordionshort" >
                <div class="card-body">Once you have shortlisted a tradesperson, you can't remove them from the shortlist but you are free to decline their quote.

                </div>
            </div>
			
            <div class="card-header collapsed" data-toggle="collapse" href="#st4">
                <a class="card-title">
             Will you share my number with your partners or marketing companies?


                </a>
            </div>
            <div id="st4" class="collapse" data-parent="#accordionshort" >
                <div class="card-body">Rest assured that we will never share your number with any partners or marketing companies, it will only be passed on to the tradespeople you have shortlisted for your job.

                </div>
            </div>
			
        </div>
    </div>

			<div class="home-owner-support-header h3 text-white">Hiring</div>
	

    <div id="accordionhire" class="accordion">
        <div class="card mb-0">
            <div class="card-header collapsed" data-toggle="collapse" href="#hr1">
                <a class="card-title">
                  How do I confirm which tradesperson I have chosen?

                </a>
            </div>
            <div id="hr1" class="collapse" data-parent="#accordionhire" >
                <div class="card-body">To confirm your choice of tradesperson, simply click the "hire" button on their profile, this will notify other tradespeople that the job is no longer available and it also allows you to leave feedback after the job is completed. If you have made a mistake in your selection or changed your mind, please contact us and we will reopen the job for you to make a new selection.

                </div>
            </div>
       
       
         
           
        </div>
    </div>

	
	
	
			<div class="home-owner-support-header h3 text-white">Feedback</div>
	

    <div id="accordionfeedback" class="accordion">
        <div class="card mb-0">
            <div class="card-header collapsed" data-toggle="collapse" href="#feed1">
                <a class="card-title">
                  How does the feedback system work?


                </a>
            </div>
            <div id="feed1" class="collapse" data-parent="#accordionfeedback" >
                <div class="card-body">At Buildela, we value feedback as it helps homeowners make informed decisions about who to hire and rewards tradespeople for their good work. Our feedback system allows you to post your comments about a tradesperson's work on their profile, once you mark them as hired and the job is complete.

                </div>
            </div>     
			
			<div class="card-header collapsed" data-toggle="collapse" href="#feed2">
                <a class="card-title">
                Can I trust feedback?



                </a>
            </div>
            <div id="feed2" class="collapse" data-parent="#accordionfeedback" >
                <div class="card-body">We take the integrity of our feedback system very seriously and monitor every piece of feedback to ensure it is legitimate and comes from genuine customers. If a feedback is flagged as suspicious, we will remove it and review the tradesperson's account.

                </div>
            </div>
       
       
         
           
        </div>
    </div>
	
	
	
				<div class="home-owner-support-header h3 text-white">Homeowner Rewards</div>
	

    <div id="accordionhome" class="accordion">
        <div class="card mb-0">
            <div class="card-header collapsed" data-toggle="collapse" href="#home1">
                <a class="card-title">
                  How it works

                </a>
            </div>
            <div id="home1" class="collapse" data-parent="#accordion" >
                <div class="card-body">Being a member of Buildela has more perks, we giveaway monthly and yearly rewards just for leaving feedback on how your job went. These rewards include, brand new cars, all-inclusive family holidays, and shopping vouchers. We give these away on a monthly / yearly basis, so be sure to keep an eye on your emails. Check out our rewards page to find out more.

                </div>
            </div>
       
       
         
           
        </div>
    </div>
	
	
	
	
</div>
<?php include_once "includes/footer.php";?>
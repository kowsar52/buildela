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
			<div class="home-owner-support-main-heading h1 text-center"> TradeMember Support</div>
		</div>
	</div>
	
				<div class="home-owner-support-header h3 text-white">About our fees</div>
	

    <div id="accordion" class="accordion">
        <div class="card mb-0">
            <div class="card-header collapsed" data-toggle="collapse" href="#fee1">
                <a class="card-title">
                  Are there any additional fees after I pay for my subscription?


                </a>
            </div>
            <div id="fee1" class="collapse" data-parent="#accordion" >
                <div class="card-body">No! There are no hidden fees. You can choose to pay a monthly or annual fee which allows you to apply for unlimited amounts of leads, and win unlimited amounts of work. There are no other charges other than the monthly or annual subscription.

                </div>
            </div>
       
       
         
           
        </div>
    </div>
	
	<div class="home-owner-support-header h3 text-white">Signing up</div>
    <div id="accordionsignup" class="accordion">
        <div class="card mb-0">
            <div class="card-header collapsed" data-toggle="collapse" href="#collapseOne">
                <a class="card-title">
                    How do I become a tradesperson on Buildela?

                </a>
            </div>
            <div id="collapseOne" class="collapse" data-parent="#accordionsignup" >
                <div class="card-body">To join Buildela as a tradesperson, simply register on our website. During the registration process, we will ask you to provide information about yourself and your company, complete evaluations for each trade you apply for. Our goal is to approve trade applications within 48 hours, from Monday to Friday.

                </div>
            </div>
            <div class="card-header collapsed" data-toggle="collapse" href="#collapseTwo">
                <a class="card-title">
                  Can I speak to someone about joining Buildela?

                </a>
            </div>
            <div id="collapseTwo" class="collapse" data-parent="#accordionsignup" >
                <div class="card-body">Yes, feel free to contact us and request a callback. We'll be happy to assist you. I'm unable to sign up because my email address is already in use. If you are unable to sign up because your email address is already in use, try logging in to the Buildela account associated with that email address. If you can't remember your password, you will have the option to access your account in other ways. Once logged in, go to your settings page and change to a different email address. If you don't have another email address, you can quickly create one online. Alternatively, you can sign up using a different email address.

                </div>
            </div>
			
            <div class="card-header collapsed" data-toggle="collapse" href="#collapseThree">
                <a class="card-title">
                  How to win more work?


                </a>
            </div>
            <div id="collapseThree" class="collapse" data-parent="#accordionsignup" >
                <div class="card-body">
				"Maximise Your Introduction with a unforgettable message on Buildela Congratulations on making it to the next step on Buildela! Your exceptional tradesperson skills have already caught our attention. Now, make a lasting impression with a powerful introduction message that sets you apart from the competition. Craft a message that showcases your enthusiasm for the job and highlights your unique selling points - whether it be your experience, qualifications, or insurance coverage. Let the customer know why you're the perfect fit for their project by highlighting your level of service, commitment to satisfaction, reliability, and attention to detail. Make a direct, friendly request to be considered for the project and communicate your availability to quote and commence work. With a well-crafted message, you'll have plenty of opportunities to showcase your skills. Make a lasting impression and start winning projects today!"

				
				</div>
                
            </div> 

	
			
			
		
			

			
        </div>
    </div>

		<div class="home-owner-support-header h3 text-white">Tips for creating a winning profile</div>
	
	
	
	
	

    <div id="accordionshortl" class="accordion">
        <div class="card mb-0">
            <div class="card-header collapsed" data-toggle="collapse" href="#st1">
                <a class="card-title">
                 Best Tips for creating a winning profile

                </a>
            </div>
            <div id="st1" class="collapse" data-parent="#accordionshortl" >
                <div class="card-body">Your trade profile serves as a crucial representation of your business, making it imperative to put your best foot forward. Here are five crucial sections to focus on:
                1. Introduction Briefly introduce yourself or your company and highlight your experience, service levels, and unique selling points. Keep it short and sweet.
                2. About Detail your range of services, showcase intriguing projects, and sell your expertise.
                3. Gallery Make a lasting impression by showcasing your best projects, and highlighting the services you offer. Ensure to include captions and a mix of project types. Customers prefer seeing finished results over work in progress. Include photos and videos.
                4. Qualifications List your trade qualifications, accreditations, and years of experience. Mention any relevant courses or trade body memberships.
                5. Insurance Highlight your public liability and professional indemnity insurance to instill confidence in potential clients. Easily add these details on your profile.
                </div>
            </div>
            <div class="card-header collapsed" data-toggle="collapse" href="#st2">
                <a class="card-title">
                 When will I start to see results?


                </a>
            </div>
            <div id="st2" class="collapse" data-parent="#accordionshortl" >
                <div class="card-body">Building a strong reputation on Buildela is key to securing new leads and building trust with customers. It takes time and effort, but with a dedicated approach, you can expect to see results. Buildela is a long-term solution, so don't get discouraged if early leads don't pan out. Invest time and effort in building your profile and service, and with time and persistence, your efforts will be rewarded.

                </div>
            </div>
			
       
			
        </div>
    </div>

			<div class="home-owner-support-header h3 text-white">Job leads & shortlisting</div>
	

    <div id="accordionleads" class="accordion">
        <div class="card mb-0">
            <div class="card-header collapsed" data-toggle="collapse" href="#lead1">
                <a class="card-title">
               What is Shortlisting?


                </a>
            </div>
            <div id="lead1" class="collapse" data-parent="#accordionleads" >
                <div class="card-body">Shortlisting is a process where job posters select and organize their preferred tradespeople from those who have expressed interest in a project. When you send an introduction message, expressing your interest in a lead, the job poster can add you to their shortlist. Being shortlisted is a positive indication that the job poster is impressed with your message and profile, and they've granted you permission to reach out and discuss the job further. Upon being shortlisted, you'll receive the job poster's contact information.

                </div>
            </div>    

			<div class="card-header collapsed" data-toggle="collapse" href="#lead2">
                <a class="card-title">
               What should I do if I've been shortlisted but can't reach the job poster?



                </a>
            </div>
            <div id="lead2" class="collapse" data-parent="#accordionleads" >
                <div class="card-body">Don't get discouraged if you're having trouble connecting with a job poster who has shortlisted you. They might be busy or simply haven't had a chance to respond yet. To increase your chances of making contact, try reaching out through multiple channels. If you've tried calling and texting, send a follow-up message through Buildela. And if all else fails, send a final message through the platform and kindly request that they save your number for future reference.

                </div>
            </div>
			
       	<div class="card-header collapsed" data-toggle="collapse" href="#lead3">
                <a class="card-title">
            How are job posters' contact details shared after shortlisting?




                </a>
            </div>
            <div id="lead3" class="collapse" data-parent="#accordionleads" >
                <div class="card-body">Once a job poster shortlists you, they give you the green light to directly reach out to them. To facilitate this process, Buildela automatically shares their name, telephone number, and job details with you. So don't hesitate to call as soon as possible. Remember, contact details are only shared after shortlisting and can't be disclosed before.

                </div>
            </div>
       
       
         
           
        </div>
    </div>

	
	
	
			<div class="home-owner-support-header h3 text-white">Email and Lead Notifications
</div>
	

    <div id="accordionemail" class="accordion">
        <div class="card mb-0">
            <div class="card-header collapsed" data-toggle="collapse" href="#email1">
                <a class="card-title">
                  How to receive email updates from Buildela?



                </a>
            </div>
            <div id="email1" class="collapse" data-parent="#accordionemail" >
                <div class="card-body">1. Verify your profile settings and ensure “Email alerts" option is selected, update if needed. 2. Check if our emails are landing in your junk/spam folder and mark them as safe or add us to your contacts list. 3. If still not receiving emails after 24 hours, reach out to us for assistance.

                </div>
            </div>     
			
			<div class="card-header collapsed" data-toggle="collapse" href="#email2">
                <a class="card-title">
               Why am I missing SMS notifications from Buildela?




                </a>
            </div>
            <div id="email2" class="collapse" data-parent="#accordionemail" >
                <div class="card-body">1. Verify your profile settings and ensure "SMS alerts" option is selected. 2. If you have the Buildela app, make sure you have enabled push notifications. Note: SMS alerts may not be sent if a push notification is already sent.

                </div>
            </div>
			
			<div class="card-header collapsed" data-toggle="collapse" href="#email3">
                <a class="card-title">
              How to receive push notifications from Buildela?




                </a>
            </div>
            <div id="email3" class="collapse" data-parent="#accordionemail" >
                <div class="card-body">1. Download the Buildela iPhone app from the Apple Store or Google Store. 2. Enable push notifications in the app settings to receive shortlist and hiring updates directly on your phone. 3. If you prefer to continue receiving email alerts, disable push notifications in the app settings.

                </div>
            </div>
       
       
         
           
        </div>
    </div>
	
	
	
				<div class="home-owner-support-header h3 text-white">Billing & Payments</div>
	

    <div id="accordionpaymrnt" class="accordion">
        <div class="card mb-0">
            <div class="card-header collapsed" data-toggle="collapse" href="#paye1">
                <a class="card-title">
                 How do I change my billing information?


                </a>
            </div>
            <div id="paye1" class="collapse" data-parent="#accordionpaymrnt" >
                <div class="card-body">You can easily update your billing information in the payment settings section of your account.

                </div>
            </div>
			
           <div class="card-header collapsed" data-toggle="collapse" href="#paye2">
                <a class="card-title">
                 What type of payment do you accept?



                </a>
            </div>
            <div id="paye2" class="collapse" data-parent="#accordionpaymrnt" >
                <div class="card-body">We accept online payments through credit or debit cards. Your card information is securely stored with the help of Stripe, a trusted payment processor used by many UK-based merchants. Your subscription is set up on automated payments so that your subscription is automatically paid on the due date.


                </div>
            </div>
			
			<div class="card-header collapsed" data-toggle="collapse" href="#paye3">
                <a class="card-title">
                 Is my card information secure with you?




                </a>
            </div>
            <div id="paye3" class="collapse" data-parent="#accordionpaymrnt" >
                <div class="card-body">Definitely. Your card information is stored securely with Stripe, ensuring the safety of your financial information.


                </div>
            </div>
			
			
			<div class="card-header collapsed" data-toggle="collapse" href="#paye4">
                <a class="card-title">
              When will I be charged for my account?





                </a>
            </div>
            <div id="paye4" class="collapse" data-parent="#accordionpaymrnt" >
                <div class="card-body">Depending on which subscription you choose, you will be charged either on a monthly or annual basis, on or around the date of your initial registration.


                </div>
            </div>


			<div class="card-header collapsed" data-toggle="collapse" href="#paye5">
                <a class="card-title">
          What if I miss a payment?






                </a>
            </div>
            <div id="paye5" class="collapse" data-parent="#accordionpaymrnt" >
                <div class="card-body">If a payment is overdue, you will not be able to access the leads page, until the payment is received.



                </div>
            </div>
			
       <div class="card-header collapsed" data-toggle="collapse" href="#paye6">
                <a class="card-title">
       I made a payment, but my account is still restricted. What should I do?







                </a>
            </div>
            <div id="paye6" class="collapse" data-parent="#accordionpaymrnt" >
                <div class="card-body">If you made a payment and your account is still restricted, it could mean that the payment was not successful. Try making the payment again or log out of your account and sign back in. If you are still having trouble, please reach out to us, and we will assist you.




                </div>
            </div>
       
       
           <div class="card-header collapsed" data-toggle="collapse" href="#paye7">
                <a class="card-title">
       Will I receive an invoice?






                </a>
            </div>
            <div id="paye7" class="collapse" data-parent="#accordionpaymrnt" >
                <div class="card-body">Yes! An invoice is created automatically and sent to the registered email as soon as a payment is completed.

Be sure to add the details you'd like to appear on the invoice when you sign up. They will be added to your invoice automatically.

If they weren't added or you need to change the details of an existing invoice, please contact us for assistance. We appreciate your patience as we process these requests.



                </div>
            </div>
           
        </div>
    </div>
	
	
	
	
	
	
				<div class="home-owner-support-header h3 text-white">Feedback</div>
	

    <div id="accordionfeedbk" class="accordion">
        <div class="card mb-0">
            <div class="card-header collapsed" data-toggle="collapse" href="#feeddr">
                <a class="card-title">
                 How does the feedback system work on Buildela?



                </a>
            </div>
            <div id="feeddr" class="collapse" data-parent="#accordionfeedbk" >
                <div class="card-body">Once an agreement for work has been reached, you may receive feedback from your customer at any time. Feedback is in the form of a rating - positive, neutral, or negative - which offers their opinion of the service you provided. All feedback is immediately displayed on your profile for anyone to see. Your feedback score is calculated as a percentage of positive reviews, with neutral reviews not included in the calculation. Only customers who have hired you directly through the Buildela platform can leave feedback.


                </div>
            </div>
			
           <div class="card-header collapsed" data-toggle="collapse" href="#feeddq">
                <a class="card-title">
               How can I request feedback from a customer?




                </a>
            </div>
            <div id="feeddq" class="collapse" data-parent="#accordionfeedbk" >
                <div class="card-body">For a customer to leave feedback, they must first mark you as hired. If they have not done so, you can send them a message to request by locating them in your shortlisted leads list and requesting for them Hire you. Once the hire has been confirmed, you can request feedback by asking them for feedback, via the in built chat or using their contact details.

                </div>
            </div>
			
			<div class="card-header collapsed" data-toggle="collapse" href="#feedde">
                <a class="card-title">
                 What can I do if I receive negative feedback?





                </a>
            </div>
            <div id="feedde" class="collapse" data-parent="#accordionfeedbk" >
                <div class="card-body">Don't worry, negative feedback is not uncommon and many successful tradespeople receive it at some point. Once you have agreed to work on a project, only the job poster can remove the feedback. If there is a way to resolve the issues raised in the feedback, try to find a solution by sending a friendly message through Buildela. If not, post a calm and professional response to the review. Buildela is impartial and cannot make decisions on who is right or wrong. Write a response that shows you are willing to take the criticism into account and resolve any issues.


                </div>
            </div>
			
			
			<div class="card-header collapsed" data-toggle="collapse" href="#feeddt">
                <a class="card-title">
              What is the best way to reply to negative feedback?






                </a>
            </div>
            <div id="feeddt" class="collapse" data-parent="#accordionfeedbk" >
                <div class="card-body">Keep in mind that your response is public and cannot be changed, so choose your words carefully and avoid using emotive language. Take a step back and address the feedback with a level head, if necessary wait a day or two. Keep your reply short and friendly, avoiding a lengthy rant. Detail any steps you took to resolve the issues raised in the feedback. Invite potential customers to view your other feedback to see what level of service they can expect from you.



                </div>
            </div>


			<div class="card-header collapsed" data-toggle="collapse" href="#feeddy">
                <a class="card-title">
       Why has my feedback been removed?







                </a>
            </div>
            <div id="feeddy" class="collapse" data-parent="#accordionfeedbk" >
                <div class="card-body">Feedback can be removed for the following reasons: There was no agreement for work to begin The tradesperson was not hired through the Buildela platform The tradesperson and job poster knew each other before connecting on Buildela Buildela also reserves the right to remove any content that goes against its policies, such as discriminatory comments, abusive language, or personal information.


                </div>
            </div>
			

       
         
           
        </div>
    </div>
	
	
	
	
	
	
	
	
	<div class="home-owner-support-header h3 text-white">Technical help

</div>
	

    <div id="accordionhelp" class="accordion">
        <div class="card mb-0">
            <div class="card-header collapsed" data-toggle="collapse" href="#help1">
                <a class="card-title">
                  How can I modify my contact information?




                </a>
            </div>
            <div id="help1" class="collapse" data-parent="#accordionhelp" >
                <div class="card-body">You have the ability to alter your address, phone number, business website, and email in the "Account Settings" section. Do I need to update my working area if I change my address? Yes, if you change your address, it's recommended to also update your working area in your profile.

                </div>
            </div>     
			
			<div class="card-header collapsed" data-toggle="collapse" href="#help2">
                <a class="card-title">
Why am I unable to express interest in a job?




                </a>
            </div>
            <div id="help2" class="collapse" data-parent="#accordionhelp" >
                <div class="card-body">Could it be because your monthly payment failed? This may be the reason why you are unable to express interest in jobs. To resolve this, ensure your payments are up to date and if still facing the issue, log out and log back into your account.

                </div>
            </div>
			
			<div class="card-header collapsed" data-toggle="collapse" href="#help3">
                <a class="card-title">
Why can't I see the full website on my tablet?




                </a>
            </div>
            <div id="help3" class="collapse" data-parent="#accordionhelp" >
                <div class="card-body">This is a common problem when accessing the website on a tablet. Try rotating the device to landscape mode, which usually resolves the issue. If that doesn't work, try accessing the website on a phone or desktop.

                </div>
            </div>
       
       
         
           
        </div>
    </div>
	
	
	
	
	
	<div class="home-owner-support-header h3 text-white">Login Problems


</div>
	

    <div id="accordionlogin" class="accordion">
        <div class="card mb-0">
            <div class="card-header collapsed" data-toggle="collapse" href="#loginhelp1">
                <a class="card-title">
                 Why am I unable to log in?





                </a>
            </div>
            <div id="loginhelp1" class="collapse" data-parent="#accordionlogin" >
                <div class="card-body">Please goto the login page, enter your registered email address and enter your password to access the site. If you can't log in, select forgot email address, forgot password or forgot both.

                </div>
            </div>     
			
			<div class="card-header collapsed" data-toggle="collapse" href="#loginhelp2">
                <a class="card-title">
Why do I need to enter my login credentials every time I visit the site?





                </a>
            </div>
            <div id="loginhelp2" class="collapse" data-parent="#accordionlogin" >
                <div class="card-body">This is usually because cookies are not enabled on your device. To resolve this issue, please refer to the troubleshooting section at the bottom of the page.

                </div>
            </div>
			
			<div class="card-header collapsed" data-toggle="collapse" href="#loginhelp3">
                <a class="card-title">
How can I update my account's password?





                </a>
            </div>
            <div id="loginhelp3" class="collapse" data-parent="#accordionlogin" >
                <div class="card-body">To update your password, make sure you are logged in. Once you are logged in, you can change your password.

                </div>
            </div>
       
       
         
           
        </div>
    </div>
	
	
	
	
	<div class="home-owner-support-header h3 text-white">Rewards



</div>
	

    <div id="accordionreward" class="accordion">
        <div class="card mb-0">
            <div class="card-header collapsed" data-toggle="collapse" href="#tradesmrd">
                <a class="card-title">
                 What are trademember Rewards?






                </a>
            </div>
            <div id="tradesmrd" class="collapse" data-parent="#accordionreward" >
                <div class="card-body">Being a member of Buildela has more perks, we giveaway monthly and yearly rewards. Every month, we giveaway premier league tickekts to see any premier league team of your choice, gift vouchers are also given away every month. Once a year, we giveaway all inclusive family holidays so be sure to keep an eye on your emails. Check out our rewards page to find out more.

                </div>
            </div>     
			
			
			
       
       
         
           
        </div>
    </div>
	
	
		<div class="home-owner-support-header h3 text-white">Referrals




</div>
	

    <div id="accordionreferrals" class="accordion">
        <div class="card mb-0">
            <div class="card-header collapsed" data-toggle="collapse" href="#refal">
                <a class="card-title">
                 What are trademember Referrals?







                </a>
            </div>
            <div id="refal" class="collapse" data-parent="#accordionreferrals" >
                <div class="card-body">We pay members £3 For every new trade member that signs up that through their recommendation. Simply go to your profile and share either the referral link with your friends who are joining via the site, or referral code with your friends that are joining through the app, and £3 will be added to your account once their subscription is set up. To request payment, register your bank details and press withdraw.

                </div>
            </div>     
			
			
			
       
       
         
           
        </div>
    </div>
	
	
	
	
	
	
	


</div>
<?php include_once "includes/footer.php";?>
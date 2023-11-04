<?php
if (session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
    // session isn't started
    session_start();
}
date_default_timezone_set('Europe/London');

include_once "serverside/functions.php";
$func = new Functions();
$popular_serarch = $func->getPopular_search();

if (isset($_SESSION['user_id'])) {
    $new_messages = $func->getAllNewChatesforme($_SESSION['user_id']);
    $userinfo = $func->UserInfo($_SESSION['user_id']);
}


if (isset($_SESSION['islogin'])) {
    $islogin = $_SESSION['islogin'];
} else {
    $islogin = 0;
}



$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$domainName = $_SERVER['HTTP_HOST'];
define("BASE_URL", $protocol . $domainName . "/");



$prices = [
    'price_monthly_only' => 9.99,
    'price_monthly'     => 19.99,
    'price_yearly'      => 119.88,
    'other_site_m'      => 100,
    'other_site_y'      => 1200,
    'currency'          => 'GBP',
    'symbol'            => '£'
];


?>
<?php
$defaultTitle = ucwords(str_replace(['.php', '_', '-'], ['', ' ', ' '], basename($_SERVER['PHP_SELF']))) . ' | Buildela';
$defaultDescription = 'Welcome to ' . $defaultTitle . '. Buildela provides you with all the information you need.';

$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $_SERVER['REMOTE_ADDR']));

//$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp"));

// print_r($ipdat);
$temp_country = $ipdat->geoplugin_countryName;
$job_posted_country = "UK";

if ($temp_country == "United States") {

    $job_posted_country = "America";
} else if ($temp_country == "United Kingdom") {

    $job_posted_country = "UK";
} else if ($temp_country == "Australia") {

    $job_posted_country = "Australia";
} else if ($temp_country == "Canada") {

    $job_posted_country = "Canada";
} else if ($temp_country == "Ireland") {

    $job_posted_country = "Ireland";
} else if ($temp_country == "Italy") {

    $job_posted_country = "Italy";
} else if ($temp_country == "Turkey") {

    $job_posted_country = "Turkey";
} else {

    $job_posted_country = "UK";
}
?>
<!DOCTYPE html>
<html data-wf-page="63594e2b152cff83902c5103" data-wf-site="63594e2b152cff3d3e2c50f6">

<head>


    <meta charset="utf-8">

    <title><?php echo $pageTitle ?? $defaultTitle ?></title>
    <meta name="description" content="<?php echo $pageDescription ?? $defaultDescription ?>">


    <meta content="Buildela - Website" property="og:title">
    <meta content="https://uploads-ssl.webflow.com/5c6eb5400253230156de2bd6/5cdc268dd7274d5c05c6009a_Business%20SEO.jpg" property="og:image">
    <meta content="Buildela - Website" property="twitter:title">
    <meta content="https://uploads-ssl.webflow.com/5c6eb5400253230156de2bd6/5cdc268dd7274d5c05c6009a_Business%20SEO.jpg" property="twitter:image">
    <meta content="width=device-width, initial-scale=1" name="viewport">

    <link href="//cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>css/bootstrap.min.css">

    <link href="<?php echo BASE_URL; ?>css/webflow.css?ver=<?php time() ?>" rel="stylesheet" type="text/css">
    <!--<link href="<?php echo BASE_URL; ?>css/buildela.webflow.css?ver=<?php time() ?>" rel="stylesheet" type="text/css">-->
    <link href="<?php echo BASE_URL; ?>css/buildela.webflow.css?v=0.010" rel="stylesheet" type="text/css">
    <link href="<?php echo BASE_URL; ?>css/normalize.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" type="text/javascript"></script>

    <!--<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>-->

    <!--<script type="text/javascript">WebFont.load({  google: {    families: ["Montserrat:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic","Open Sans:300,300italic,400,400italic,600,600italic,700,700italic,800,800italic","Raleway:100,200,300,regular,500,600,700,800","Space Grotesk:300,regular,500,600,700","Fraunces:100,200,300,regular,500,600,700,800,900"]  }});</script>-->
    <!-- [if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js" type="text/javascript"></script><![endif] -->
    <script type="text/javascript">
        ! function(o, c) {
            var n = c.documentElement,
                t = " w-mod-";
            n.className += t + "js", ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) && (n.className += t + "touch")
        }(window, document);
    </script>
    <script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=63594e2b152cff3d3e2c50f6" type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link href="<?php echo BASE_URL; ?>images/fav-icon.png" rel="apple-touch-icon">
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_URL; ?>images/fav-icon.ico">
    <!--<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@200;300;400;600;900&display=swap" rel="stylesheet">-->


    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;700;900&family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">

    <style>
        .body {
            overflow-y: scroll;
            font-size: 0.87rem;
        }


        button,
        input,
        optgroup,
        select,
        textarea {
            border-width: 1px !important;

        }

        button:focus {
            outline: 0 !important;
        }

        a.footer-social-link.w-inline-block i {
            font-size: 25px;
            color: #fff;
        }

        a.footer-social-link.w-inline-block:hover i {
            transform: scale(1.1);
        }

        a.forgotpw {
            text-decoration: none;
            margin-top: 13px;
            color: #007bff;
            font-weight: 600;
            font-size: 14px;
        }

        a.forgotpw:hover {
            color: #0056b3;
        }

        div#w-dropdown-toggle-2,
        .padzero {
            padding: 0px;
        }

        /* Site wide*/
        .column-30 {
            min-height: 100px;
        }

        .column-30.w-col.w-col-4,
        .column-31.w-col.w-col-4,
        .column-32.w-col.w-col-4 {
            border-radius: 5px;
            margin-bottom: 15px;
            margin-right: 0;
            padding: 20px 25px;
            box-shadow: 12px 16px 40px rgba(23, 23, 27, 0.06);
            border: 1px solid #e5e5e5;
            transition: all 0.3s ease
        }

        .column-30.w-col.w-col-4:hover,
        .column-31.w-col.w-col-4:hover,
        .column-32.w-col.w-col-4:hover {
            box-shadow: none;
        }


        a.footer-brand.w-inline-block img {

            text-align: center;
            display: block;
            margin-right: auto;
            margin-left: auto;
        }

        @media(max-width: 991.98px) {
            a.footer-brand.w-inline-block img {
                width: 55%;
            }
        }

        .button.cc-jumbo-button {
            padding: 13px 25px;
            font-size: 17px;
            line-height: 26px;
            border-radius: 5px;
        }

        .section.cc-cta {
            border-radius: 10px;
            box-shadow: 0px 0px 40px rgba(23, 23, 27, 0.1);
            border: 1px solid #e4e4e4;
        }

        /*POST JOB FORM*/
        .post-a-job-new-card {

            border-radius: 8px;
        }

        .post-a-job-new-input {

            height: calc(0.5em + 0.75rem + 9px) !important;
            color: rgb(51, 51, 51) !important;
        }

        .post-a-job-new-input:focus,
        .post-a-job-new-input:focus-visible {
            color: #495057;
            background-color: #fff;
            border-color: none !important;
            outline: 0;
            box-shadow: unset !important;
        }

        #searchModal .modal-dialog {
            max-width: 600px;
        }

        .scrolling-wrapper {
            max-height: 385px;
            overflow-y: auto;
        }

        .scrolling-wrapper-one {
            max-height: 385px;
            overflow-y: auto;
        }

        .scrolling-wrapper h6 {
            background-color: #dce9fd;
            padding: 10px 15px;
            color: rgb(51, 51, 51);
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
            border-radius: 4px;
        }

        .scrolling-wrapper span {

            display: block;
            padding: 10px 15px;
            color: rgb(51, 51, 51);
            font-size: 1rem;
        }

        .scrolling-wrapper span:hover {
            background-color: rgb(242, 247, 250);
            border-radius: 4px;
        }

        .scrolling-wrapper-one button {
            box-shadow: unset !important;
        }

        .scrolling-wrapper button {
            box-shadow: unset !important;
        }

        .d-span {
            cursor: pointer;
        }

        .modal-body {
            /*font-family: 'Source Sans Pro', sans-serif!important;*/
            font-family: 'DM Sans', sans-serif !important;
        }



        label.radio-btn {
            width: 100%;
            border: 1px solid rgb(231, 232, 236);
        }

        label.radio-btn:hover {
            border-color: rgb(51, 51, 51) !important;
            color: rgb(51, 51, 51);
        }

        .card-input-element {
            display: none;
        }

        .card-input div {
            font-family: 'DM Sans', sans-serif !important;
            font-size: 1rem;
        }

        .card-input:hover {
            cursor: pointer;
        }

        .card-input-element:checked+.card-input {
            box-shadow: 0 0 1px 1px rgb(51, 51, 51);
            border-radius: 4px;
        }

        .search-input-wrapper {
            border: 2px solid #000;
            border-radius: 4px;
            background: #fff;
        }

        button.btn.search-btn.py-2.px-4 {
            background: #d10a38;
            color: #fff;
        }

        button.btn.search-btn.py-2.px-4:hover {
            background-color: #b90932 !important;
            color: white !important;
        }

        .search-input-wrapper input {
            border: 0 !important;
            font-size: 18px;
        }

        .search-input-wrapper input:focus {
            outline: 0;
            box-shadow: unset !important;
        }

        .btn.search-btn {
            background-color: #52C47D;
            color: #fff;
            font-weight: bold;
            border: 0;
        }

        .search-btn:hover {
            background-color: #52C47D;


        }

        .btn.search-btn:focus {
            box-shadow: none;
        }

        .fieldError {
            color: red !important;
            border-color: red !important;
        }

        .textError {
            color: red !important;
        }

        .form-control:focus {
            box-shadow: none !important;
            border-color: #006BF5 !important;
        }

        .btn-danger {
            color: #dc3545;
            background-color: transparent;
            border-color: #dc3545;
        }

        #post_job label {
            font-size: 14px;


            text-transform: capitalize;
        }

        #post_job .form-group p {
            margin-bottom: 1px;
        }

        #post_job .form-control-lg {

            font-size: 1rem;

        }

        #post_job input[type="file"] {
            font-size: 0.87rem;
            height: 45px;
        }

        /*END POST JOB */






        @media (min-width: 768px) and (max-width: 1024px) and (orientation: landscape) {

            /* CSS */
            .paragraph-bigger.cc-bigger-white-light {

                font-size: 14px;

            }

        }

        a.button-2-rdm.login.w-button.nwhd.chred {
            display: none;
        }

        @media (min-width: 320px) and (max-width: 769px) {
            .mobile-only {
                display: block !important;
                padding: 12px 15px;
            }

            .navigation.container {
                max-width: 100%;
                padding: 12px 10px !important;
                background-color: #fff;
            }

            a.logo-link.w-nav-brand.w--current {
                padding-left: 5px;
            }

            a.button-2-rdm.login.w-button.nwhd.chred {
                font-family: 'Poppins', sans-serif;
                padding: 8px 8px;
                font-size: 14px;
                font-weight: 600;
            }


        }

        @media (min-width: 769px) {

            .mobile-only {
                display: none !important;
                padding: 12px 15px;
            }

        }

        @media (min-width: 768px) {
            .desktop-only {
                display: block !important;
            }
        }

        @media (min-width: 320px) and (max-width: 767px) {
            .desktop-only {
                display: none !important;

            }
        }

        /* Mobile*/

        @media (min-width: 320px) and (max-width: 480px) {


            .button.cc-jumbo-button {
                border-radius: 5px !important;
            }

            a.button-2-rdm.login.w-button.nwhd.chred {
                display: block;
            }

            .button-2 {
                margin-right: 5px;
                margin-left: 5px;
            }

            .menu-button.w-nav-button {
                padding-right: 5px;
            }

            i.fa-solid.fa-circle-user {
                font-size: 35px !important;
            }

            a.button-2.login.w-button.nwhd.rd {
                border-radius: 60px !important;
                padding: 5px 10px;
                border-color: #006bf5;
                border: none;
                margin-right: -9px;

            }

            .category-slider .owl-prev i,
            .category-slider .owl-next i {
                font-size: 22px !important;
                color: #d10a38 !important;
            }

            .category-slider .owl-next {
                width: 50px;
                height: 50px;
                position: absolute;
                top: 42%;
                right: -29px !important;
                display: block !important;
                border: 0px solid black;
            }

            .category-slider button.owl-next,
            .category-slider button.owl-prev {
                overflow: hidden;
                padding: 0 !important;
                margin: 0 !important;
            }

            .category-slider .owl-prev {
                width: 50px;
                height: 50px;
                position: absolute;
                top: 42%;
                left: -29px !important;
                display: block !important;
                border: 0px solid black;
            }

            .category-slider .owl-stage {
                display: grid;
                grid-template-columns: repeat(8, 1fr);
                grid-template-rows: repeat(3, 1fr);
                grid-column-gap: 0px;
                grid-row-gap: 0px;
            }

            .category-slider .item {
                margin-top: 20px;
                margin-bottom: 5px;
                height: 110px;
                border-radius: 8px;

                background-color: rgb(255, 255, 255);
                grid-area: 1 / 1 / 4 / 3;
                display: inline-grid;
                width: 97%;
            }

            .category-slider .owl-item {
                width: 85% !important;
                margin-left: auto;
                margin-right: auto;
            }

            .category-slider .owl-dots {
                margin-top: 30px;
            }

            h2.centered-heading-3 {
                font-size: 1.2rem !important;
            }


        }

        /*End*/



        a.button-2-rdm.login.w-button.nwhd.chred {
            font-family: 'Poppins', sans-serif;
            padding: 8px 8px;
        }

        a.button-2.login.w-button.nwhd i {
            width: 43px;
            font-size: 43px;
            display: block;
            line-height: 28px;
            color: #006bf5;
        }

        a.button-2.login.w-button.nwhd:hover i {
            color: #1477F7;
        }

        a.button-2.login.w-button.nwhd.rd {
            border-radius: 60px !important;
            padding: 5px 5px;
            border-color: #006bf5;
            border: none;

        }

        i.fa-solid.fa-circle-user {
            font-size: 35px;
        }




        .nwhd:hover {
            border-radius: 10px;
            border-color: #006bf5 !important;
            color: #006bf5 !important;
        }

        .nwhd {
            border-radius: 5px !important;

        }

        .chred {
            background-color: rgb(209, 10, 56) !important;
            color: white !important;
            ;
        }



        .owl-dots {
            margin-bottom: 20px;
        }

        .brix---input-large-button-inside {
            min-height: 60px;
            padding: 15px 24px;
            border-radius: 10px;


        }

        .brix---btn-primary-small-input {

            border-radius: 10px;
            background-color: rgb(209, 10, 56);

        }

        body {
            font-family: 'DM Sans', sans-serif !important;

        }

        .heading-jumbo {
            font-family: 'Poppins', sans-serif !important;
            font-weight: 900;
        }

        .paragraph-bigger.cc-bigger-white-light {
            color: black;
            font-weight: 400;
            font-size: 18px;
            opacity: 1;
            line-height: 22px;
        }

        /* form#signup_user1 .form-group input#phone1, form#signup_user1 .form-group input#fname, form#signup_user1 .form-group input#pass {
    height: 3rem;
    min-width: 16rem;
    margin-bottom: 0rem;
    padding: 0.5rem 1.25rem;
    border-style: solid;
    border-width: 1px;
    border-color: #f2f3f7;
    border-radius: 8rem;
    background-color: #f2f3f7;
    -webkit-transition: border-color 250ms ease;
    transition: border-color 250ms ease;
    font-family: 'Poppins', sans-serif;
    color: #1f2c3d;
    font-size: 1rem;
    line-height: 1.5;
    font-weight: 400;
} */
        span.bg-danger.position-absolute.text-white.rounded-circle.px-1 {

            /* font-family: Montserrat, sans-serif!important; */
            font-family: 'DM Sans', sans-serif !important;
        }



        .btn-bg-general {
            background-color: #006bf5;
            background: #006bf5;

        }

        .w-dropdown-list.w--open {
            display: block;
            border: solid 1.5px #e2e2e2;
            border-radius: 5px;
            overflow: hidden;
        }

        .dropdown-link {
            color: #006bf5;
            border-bottom: solid 1.5px #e2e2e2;
        }

        .w-dropdown-link {
            padding: 10px 20px;
            display: block;
            color: #222222;
            border-bottom: solid 1.5px #e2e2e2;
        }

        .w-dropdown-link:last-child {
            border-bottom: 0;
        }

        .features-list-wrapper {
            padding: 46px 34px;

            margin-left: -30px !important;
            margin-right: -30px !important;
            width: calc(100% + 60px) !important;
            margin-top: 30px;
            background-color: #f2f7ff;
            border-radius: 7px;
        }

        @media(max-width:767px) {
            .features-list-wrapper {
                padding: 20px 15px;
                margin-left: -15px !important;
                margin-right: -15px !important;
                width: calc(100% + 30px) !important;

            }
        }

        section.features-list123.feature-custom.appdl.wf-section {
            margin-top: 40px;
            margin-bottom: 40px;
        }

        @media screen and (max-width: 1024px) {
            .buildela-flw.wf-section {

                padding: 30px 25px;
            }

        }


        .buildela-flw {
            padding-top: 20px;
            padding-bottom: 20px;
            background-image: linear-gradient(42deg, #0c0e4d, #006bf5);
        }



        .heading-17 {
            font-family: 'Poppins', sans-serif !important;
            color: #fff;
            font-size: 35px;
            font-weight: 700;
            text-align: left;
            margin-left: 15px;
        }

        .image-20 {
            position: static;
            display: block;
            width: 30%;
            margin-right: auto;
            margin-left: 16px;
            padding-top: 0px;
            padding-bottom: 15px;
            text-align: left;
        }

        p.paragraph-10 {
            margin-left: 15px;
        }

        span.XQskgrQ.check-icon {
            fill: #fff !important;
        }

        .button-16 {
            margin-top: 20px;

            border-radius: 5px;
            background-color: rgb(209, 10, 56);
            margin-left: 10px;
            padding: 11px 30px;
        }

        .button-16 {
            background-color: #d10a38;
            color: white;
        }

        .button-16:hover {
            background-color: #B90932;
            color: #fff;
        }

        .buildela-flw {
            padding-top: 10px;
            padding-bottom: 15px;
            font-size: 1rem;
        }

        span.p-2.d-span {
            border: 1px solid rgb(231, 232, 236);
            margin-bottom: 10px;
            margin-top: 10px;
            border-radius: 5px;
        }

        i.fa.fa-angle-right.bpsc {
            float: right;
            line-height: 25px;
        }

        .footer-dark {
            position: relative;
            margin-top: 0px;
            padding: 50px 15px 15px;
            border-bottom: 0;
            background-color: #006bf5;
        }

        a.dropdown-link.w-dropdown-link {
            text-decoration: none;
        }

        a.dropdown-link-6.w-dropdown-link {
            text-decoration: none;
        }

        a.dropdown-link.w-dropdown-link:hover {
            text-decoration: none;
        }

        a.dropdown-link-6.w-dropdown-link:hover {
            text-decoration: none;
        }

        .chred:hover {
            background-color: #b90932 !important;
            color: white !important;
        }

        .dropdown-link-5:hover {
            text-decoration: none;
        }

        .w-dropdown-link:hover {
            text-decoration: none;
            color: #0056b3;
            background-color: #f9f9f9;
        }

        a.button-2.login.w-button.nwhd.rd:hover {
            text-decoration: none;
        }

        a.button.cc-contact-us.custom-hd.w-inline-block.nwhd.chred.w--current:hover {
            text-decoration: none;
        }


        @media (min-width: 320px) and (max-width: 480px) {
            a.logo-link.w-nav-brand {
                left: -1px;
            }

            nav#w-dropdown-list-2 {
                left: -55px;
                top: 50px;
            }

            a.button-2-rdm.login.w-button.nwhd.chred,
            a.button.cc-contact-us.custom-hd.w-inline-block.nwhd.chred {
                line-height: 21px;
                padding: 8px 8px;
            }

            a.logo-link.w-nav-brand {
                padding-left: 5px;
                flex: 1;
            }

            section.features-list123.feature-custom.appdl.wf-section {
                margin-top: 10px;
                margin-bottom: 20px;
            }

            div#searchModal {
                padding-right: 0px !important;
            }

            #searchModal .modal-dialog {
                margin: 0 !important;
            }

            .w-dropdown-link {
                font-size: 12.8px;
                line-height: 19.2px;
            }

            .text-block-3 {

                font-size: 16px;
                font-weight: bolder;
                text-transform: none;
                letter-spacing: 0px;
            }

            span.bg-danger.position-absolute.text-white.rounded-circle.px-1 {
                width: auto;
                text-align: center;
                height: auto;
                padding: 3.5px 9.5px !important;
                font-family: 'Poppins', sans-serif;
                !important;
            }

            span.bg-danger.position-absolute.text-white.rounded-circle.px-1.my-ac {

                left: 23px;
            }

            .post-a-job-continue-btn-div.pt-4 {
                margin-top: 40px !important;
                margin-bottom: 20px;
                padding-top: 0px !important;

            }

            .post-a-job-continue-btn {
                color: #fff;
            }

            .account.w-dropdown.notice-on {
                bottom: -2px;

            }
        }

        .form-group small {
            margin: 15px 0 15px 0 !important;
            display: block;
            font-size: 90%;
        }

        .post-a-job-continue-btn {

            background: #006bf5;
        }

        .post-a-job-continue-btn:hover {
            background: #1477F7;
        }

        span.bg-danger.position-absolute.text-white.rounded-circle.px-1.my-ac {
            right: -54px !important;
            position: relative !important;
            top: -43px !important;
            background: rgb(209, 10, 56) !important;
            padding: 3.5px 9.5px !important;
            display: flex;
            width: 34px;
            height: 33px;
            align-content: center;
            justify-content: center;
            align-items: center;
            border-radius: 60px !important;
        }

        span.bg-danger.position-absolute.text-white.rounded-circle.px-1 {
            background: rgb(209, 10, 56) !important;
            padding: 3.5px 9.5px !important;
            display: inline-flex;
            width: 20px !important;
            height: 20px !important;
            align-content: center;
            justify-content: center;
            align-items: center;
            color: #fff;
            border-radius: 60px !important;
            position: absolute;
        }

        nav#w-dropdown-list-0 a {
            font-size: 14px !important;
            line-height: 19.2px !important;
        }

        nav#w-dropdown-list-1 a {
            font-size: 14px !important;
            line-height: 19.2px !important;
        }

        nav#w-dropdown-list-2 a {
            font-size: 14px !important;
            line-height: 19.2px !important;
        }

        span.bg-danger.position-absolute.text-white.rounded-circle.px-1.chat {
            font-size: 11px !important;
            width: 24px !important;
            height: 16px !important;
            font-weight: 600;
            line-height: 16px;
        }

        .account.w-dropdown.notice-on {
            height: 37px;
        }

        div#message {
            position: fixed;
            background: #006bf5;
            height: 100%;
            width: 100%;
            z-index: 999999999 !important;
            top: 0;
        }

        body.overflow-hidden {
            overflow: hidden;
        }

        span.h2.rotyo {
            text-align: center;
            width: 100%;
            display: block;
            margin-top: 25px;
            font-weight: 700;
            color: #fff;
        }

        img.phonert {
            margin-left: auto;
            margin-right: auto;
        }

        .w-dropdown-toggle.w--open .w-icon-arrow-down:before,
        .w-dropdown-toggle.w--open .w-icon-dropdown-toggle:before {
            color: #006bf5;
            transform: rotate(180deg);
            display: table;
            margin-top: -1px;
            top: -1px;
        }

        .w-dropdown-toggle:hover .w-icon-dropdown-toggle:before,
        .w-dropdown-toggle:hover .text-block-2,
        .w-dropdown-toggle.w--open .text-block-2 {
            color: #006bf5;
        }

        .modal-backdrop {
            opacity: 1 !important;
            background-color: rgba(0, 0, 0, 0.2) !important;
            backdrop-filter: blur(5px);
        }

        .w-container {

            padding-left: 10px;
            padding-right: 10px;
        }

        @media (min-width: 768px) {
            .animate {
                animation-duration: 0.3s;
                -webkit-animation-duration: 0.3s;
                animation-fill-mode: both;
                -webkit-animation-fill-mode: both;
            }
        }

        @keyframes slideIn {
            0% {
                transform: translateY(1rem);
                opacity: 0;
            }

            100% {
                transform: translateY(0rem);
                opacity: 1;
            }

            0% {
                transform: translateY(1rem);
                opacity: 0;
            }
        }

        @-webkit-keyframes slideIn {
            0% {
                -webkit-transform: transform;
                -webkit-opacity: 0;
            }

            100% {
                -webkit-transform: translateY(0);
                -webkit-opacity: 1;
            }

            0% {
                -webkit-transform: translateY(1rem);
                -webkit-opacity: 0;
            }
        }

        .slideIn {
            -webkit-animation-name: slideIn;
            animation-name: slideIn;
        }
    </style>

    <?php if (strpos($_SERVER['SCRIPT_NAME'], 'index.php') !== false) { ?>

        <style>
            body {
                font-family: 'DM Sans', sans-serif !important;
                background-color: #ffffff !important !
            }
        </style>

    <?php } ?>


</head>

<body class=" <?php

                if (strpos($_SERVER['SCRIPT_NAME'], 'index.php') !== false) {
                    echo 'body greybg';
                } else {
                    echo 'body';
                }

                ?>">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>










    <div data-collapse="medium" role="banner" class="navigation container w-nav">
        <div class="container-12 w-container">
            <div class="navigation-wrap">
                <div class="menu-button w-nav-button"><img src="<?php echo BASE_URL; ?>images/Menu.png" width="22" alt="" class="menu-icon"></div>
                <a href="<?php echo BASE_URL; ?>" aria-current="page" class="logo-link w-nav-brand w--current"><img src="/images/buildela-logo.png" width="160" alt="" class="logo-image"></a>

                <div class="menu">
                    <nav role="navigation" class="navigation-items w-nav-menu">


                        <?php
                        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'jobs_person') {
                        ?>
                            <a href="<?php echo BASE_URL; ?>leads" class="button cc-contact-us custom-hd w-inline-block nwhd chred">
                                <div class="text-block-3">Leads</div>
                            </a>
                        <?php
                        } else if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'home_owner') {
                        ?>
                            <a href="<?php echo BASE_URL; ?>my-posted-jobs" class="button cc-contact-us custom-hd w-inline-block nwhd chred">
                                <div class="text-block-3">My posted jobs</div>
                            </a>
                        <?php
                        } else {

                        ?>
                        <?php
                        }
                        ?>




                        <div data-hover="false" data-delay="0" class="w-dropdown">
                            <div class="w-dropdown-toggle">
                                <div class="w-icon-dropdown-toggle"></div>
                                <div class="text-block-2">Homeowners</div>
                            </div>
                            <nav class="dropdown-list w-dropdown-list animate slideIn">
                                <a href="<?php echo BASE_URL; ?>post-a-job" class="dropdown-link-5 w-dropdown-link">Post a job</a>
                                <a href="<?php echo BASE_URL; ?>how-it-works-homeowner" class="dropdown-link w-dropdown-link">How it works</a>
                                <a href="<?php echo BASE_URL; ?>homeowner-blogs" class="dropdown-link-5 w-dropdown-link">Project Advice</a>
                                <a href="<?php echo BASE_URL; ?>about" class="dropdown-link-6 w-dropdown-link">About</a>
                                <a href="<?php echo BASE_URL; ?>homeowner-reward" class="dropdown-link-6 w-dropdown-link">Rewards</a>


                            </nav>
                        </div>
                        <div data-hover="false" data-delay="0" class="w-dropdown">
                            <div class="w-dropdown-toggle">
                                <div class="w-icon-dropdown-toggle"></div>
                                <div class="text-block-2">Trade Members</div>
                            </div>
                            <nav class="dropdown-list-2 w-dropdown-list animate slideIn">
                                <a href="<?php echo BASE_URL; ?>trades" class="dropdown-link-3 w-dropdown-link">Trades</a>
                                <a href="<?php echo BASE_URL; ?>how-it-works-trademember" class="dropdown-link-2 w-dropdown-link">How it works</a>
                                <a href="<?php echo BASE_URL; ?>professional-blogs" class="dropdown-link-5 w-dropdown-link">Advice Centre</a>
                                <a href="<?php echo BASE_URL; ?>about" class="dropdown-link-4 w-dropdown-link">About</a>
                                <a href="<?php echo BASE_URL; ?>trademember-reward" class="dropdown-link-6 w-dropdown-link">Rewards</a>

                            </nav>
                        </div>
                    </nav>

                </div>
            </div>


            <?php
            if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'jobs_person') {
            ?>
                <a href="<?php echo BASE_URL; ?>leads" class="button cc-contact-us custom-hd w-inline-block nwhd chred mobile-only">
                    <div class="text-block-3">Leads</div>
                </a>

            <?php
            } else if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'home_owner') {
            ?>
                <a href="<?php echo BASE_URL; ?>my-posted-jobs" class="button cc-contact-us custom-hd w-inline-block nwhd chred mobile-only">
                    <div class="text-block-3">My posted jobs</div>
                </a>
            <?php
            } else {
            ?>
                <a href="<?php echo BASE_URL; ?>trades" class="button cc-contact-us custom-hd w-inline-block nwhd chred">
                    <div class="text-block-3">Trades sign up</div>
                </a>
            <?php
            }
            ?>


            <?php
            if (isset($_SESSION['user_id'])) {
            ?>
                <div data-hover="false" data-delay="0" class="account w-dropdown <?php
                                                                                    if (count($new_messages) > 0) {
                                                                                    ?>
                        notice-on
                        <?php
                                                                                    }
                        ?>">
                    <div class="w-dropdown-toggle padzero">
                        <div class="text-block-2 account">
                            <a href="#" class="button-2 login w-button nwhd rd">
                                <i class="fa-solid fa-circle-user"></i>
                            </a> <?php
                                    if (count($new_messages) > 0) {
                                    ?>
                                <span style="" class="bg-danger position-absolute text-white rounded-circle px-1 my-ac"><?= count($new_messages) ?></span>
                            <?php
                                    }
                            ?>
                        </div>
                    </div>
                    <nav class="dropdown-list w-dropdown-list">
                        <a href="<?php echo BASE_URL; ?>chat" class="dropdown-link w-dropdown-link" id="chatmenulink">Chat <?php
                                                                                                                            if (count($new_messages) > 0) {
                                                                                                                            ?>
                                <span style="top: 10px;right: 15px;font-size: 12px; height: 18px!important;width: 14px!important;" class="bg-danger position-absolute text-white rounded-circle px-1"><?= count($new_messages) ?></span>
                            <?php
                                                                                                                            }
                            ?></a>
                        <a href="<?php echo BASE_URL; ?>my-profile" class="dropdown-link w-dropdown-link">My Profile</a>
                    <?php
                }
                    ?>
                    <?php
                    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'jobs_person') {
                    ?>
                        <a href="<?php echo BASE_URL; ?>leads" class="dropdown-link w-dropdown-link">Leads</a>
                    <?php
                    } else {
                    ?>

                    <?php
                    }
                    ?>


                    <?php
                    if (isset($_SESSION['user_id'])) {
                    ?>
                        <?php
                        if ($_SESSION['user_role'] == 'jobs_person') {
                        ?>
                            <a href="<?php echo BASE_URL; ?>trademember-my-account" class="dropdown-link-6 w-dropdown-link">Billing</a>
                        <?php
                        }
                        ?>

                        <a href="<?php echo BASE_URL; ?>contact-us" class="dropdown-link-5 w-dropdown-link">Support</a>
                        <a href="<?php echo BASE_URL; ?>logout" class="dropdown-link-5 w-dropdown-link">Log out</a>
                    </nav>
                </div>
            <?php
                    }
            ?>





            <?php
            if (!isset($_SESSION['user_id'])) {
            ?>
                <a href="/trades" class="button-2-rdm login w-button nwhd chred">Trades sign up</a>
                <a href="<?php echo BASE_URL; ?>login" class="button-2 login w-button nwhd rd"><i class="fa-solid fa-circle-user"></i></a>


            <?php
            } else {
            ?>


            <?php
            }
            ?>









        </div>
    </div>


    <div id="messagert" class="rotyo" style="display: none;">
        <span class="h2 rotyo">Please return to portrait mode.</span>
        <img src="images/phone.gif" class="phonert">

    </div>

    <script>
        $(document).ready(function() {
            function checkOrientation() {
                if (window.orientation === 90 || window.orientation === -90) {
                    $('#messagert').show();
                    $('body.font-lato.tawk-mobile').hide();
                    $('body').addClass('overflow-hidden');
                } else {
                    $('#messagert').hide();
                    $('body.font-lato.tawk-mobile').show();
                    $('body').removeClass('overflow-hidden');
                }
            }

            // Initial check
            checkOrientation();

            // Listen for orientation changes
            $(window).on('orientationchange', function() {
                checkOrientation();
            });
        });
    </script>
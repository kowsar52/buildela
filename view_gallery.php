<?php
include_once "serverside/functions.php";
include_once "serverside/session.php";

$func=new Functions();
$user=$func->UserInfo($_SESSION['user_id']);
$user=$user[0];
$images=$func->getMyGallery($_SESSION['user_id']);

include_once "includes/header.php";
?>

<style>
img.img-fluid.rounded {
    width: 100%;
    height: 110px;
    object-fit: cover;
    border-radius: 20px;
    margin-right: 2rem;
    margin-bottom: 1rem;
    border: 1px solid #aaa;
}

.video-section video {
    height: 120px;
    object-fit: cover;
    margin-bottom: 1rem;
    display: block;
}
@media(max-width: 767.98px){
    .video-section .inner-item, .image-section .inner-item,.col-12 {
    padding-left: 15px!important;
}
}
@media(min-width: 992px){
    img.img-fluid.rounded {

    height: 160px;

  
}
.video-section video {
    height: 175px;

}
}
h1.job-photos-heading.h4 {
    color: #383838;
    font-weight: 700;
    font-size: 1.75rem;
    border-bottom: 2px solid #ededed;
    margin-bottom: 30px;
    padding-bottom: 15px;
    padding-top: 50px;
}
button.btn.btn-danger.d-block.bnt-sec {
    margin-bottom: 1.5rem;
    border-radius: 5px;
    padding: 5px 25px;
    text-transform: capitalize;
    color: #ffff;

}
button.General-blue-btn.btn-block.text-decoration-none.text-white.text-center.rounded.px-3.py-2 {
    background: #006bf5;
    color: #fff;
}
button.General-blue-btn.btn-block.text-decoration-none.text-white.text-center.rounded.px-3.py-2:hover{
  background: #1861D1;
}
.h3.register-trade {
    font-weight: 700;
    font-family: 'Poppins', sans-serif;
    margin-bottom: 10px;
}
.image-section {
    margin-bottom: 40px;
}
input#images {
    background: transparent!important;
    padding: 8px!important;
    border-radius: .3rem!important;
    margin-bottom: 0;
    height: 45px;
    border-color: #ced4da!important;
}
input#images:hover {

    border-color: #006BF5!important;
    cursor: pointer;
}
.upload-gallery {
    border: 2px dashed #006BF5;

    background-color: #F2F7FF;
}
</style>
 <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- The jQuery library is a prerequisite for all jqery.fileupload plugins -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/10.31.0/js/vendor/jquery.ui.widget.min.js"></script>

<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/10.31.0/js/jquery.iframe-transport.min.js"></script>

<!-- The basic File Upload plugin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/10.31.0/js/jquery.fileupload.min.js"></script>


<div class="my-profile-wrapper">
    <div class="container my-profile-inner pt-5">
            <div class="leads-job-photos-wrapper py-4 row mb-5">
              <div class="col-12">
            <div class="register-trade h3 py-2">Upload Your Work Gallery</div>
			<div class=" mt-2 rounded upload-gallery p-4">
                    
                    <div class="register-trade-list p-3 ">
                        <form id="uploadImages">
                            <input type="hidden" id="userId" value="<?=$user['id']?>">
                            <div class="form-group ">
                                <label for="dbs">Upload portfolio (Add images or videos to showcase your skills)</label><br> 
                                <input type="file" class="form-control-lg form-control" id="images" autocomplete="off">
                            </div>
                            <button class="General-blue-btn btn-block text-decoration-none text-white text-center rounded px-3 py-2" type="submit"
                                    id="glup">Upload
                            </button>
                        </form>
						<!-- Progress Bar -->
                        <div id="progressWrapper" style="display: none; margin-top:25px; justify-content:center; align-items:center">
                            <img class="loadingimg" width="50px" height="50px" src="https://buildela.com/images/loading.gif"> 
                        </div>
                    </div>
                </div>
                </div>
                <div class="leads-job-photos">
                <h1 class="job-photos-heading h4">Your Work Gallery</h1>
    
    <div class="image-section d-flex flex-wrap">
        <h5 class="col-12">Images (Max 6 images)</h5>
        <?php
        $imageCount = 0; // Counter for images
        foreach($images as $imgs){
            $image = explode('/',$imgs['img_path']);
            $img = $image[1].'/'.$image[2];
            
            if($imgs['file_type']=='image'){
                // $imageCount++; // Increment image count
        ?>
        <div class="col-6 col-md-3 inner-item">
            <img src="<?=$img?>" class="img-fluid rounded">
            <button class="btn btn-danger d-block bnt-sec" onclick="deleteImage(<?=$imgs['id']?>)">Delete</button>
        </div>
        <?php
            }
        }
        ?>
    </div>
    <div class="video-section d-flex flex-wrap">
        <h5 class="col-12">Videos (Max 6 videos)</h5>
        <?php
        $videoCount = 0; // Counter for videos
        foreach($images as $imgs){
            $image = explode('/',$imgs['img_path']);
            $img = $image[1].'/'.$image[2];
            
            if($imgs['file_type']=='video'){
                $videoCount++; // Increment video count
        ?>
        <div class="col-6 col-md-3 inner-item">
            <video controls class="img-fluid rounded img-stled">
                <source src="<?=$img?>" type="video/mp4">
                Error Message
            </video>
            <button class="btn btn-danger d-block bnt-sec" onclick="deleteImage(<?=$imgs['id']?>)">Delete</button>
        </div>
        <?php
            }
        }
        ?>
    </div>
</div>


            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    $('#glup').on('click', function(event) {
        $('#progressWrapper').show(); // Show the progress bar
    });
});
</script>
<?php include_once "includes/footer-no-cta.php"?>

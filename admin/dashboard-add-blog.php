<?php
require_once "../serverside/functions.php";
if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
    // session isn't started
    session_start();
}
if((isset($_SESSION['user_id'])) &&( $_SESSION['user_type']==1 )){

}else{
    //header('Location: sign-in');
    ?>
    <script type="text/javascript">
        window.location.href="../login";
    </script>
    <?php
    exit();
}


$func=new Functions();
$settings=$func->getSettings();
$mainCategory=$func->mainCategory();
$blogCategory=$func->blogCategory();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blogs</title>
    <?php include "includes/dashboard-links.php"; ?>
    <style>
        .mce-notification{
            display: none;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Preloader -->
    <!--    <div class="preloader flex-column justify-content-center align-items-center">-->
    <!--        <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">-->
    <!--    </div>-->

    <!-- Navbar -->
    <?php include "includes/header.php" ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include "includes/sidebar.php" ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Add Blog</h1>
                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Main row -->
                <div class="card">
                    <div class="card-body">
                        <form id="addBlog">
                            <div class="row">
                                <div class=" col-6  form-group input_parent">
                                    <label>Title: </label>
                                    <input class="form-control" required type="text" id="title" >
                                </div>

                                <div class=" col-6 form-group input_parent">
                                    <label>Author name:</label>
                                    <input class="form-control" required type="text" id="author" >
                                </div>
                            </div>
                            <div class="row">

                                <div class=" col-4  form-group input_parent" >
                                    <label>Cover image:</label>
                                    <input class="form-control" required  type="file" id="image">
                                </div>

                                <div class=" col-4  form-group input_parent" >
                                    <label>Select Category:</label>
                                    <select class="form-control" id="category1">
                                        <option value="Homeowners">Homeowners</option>
                                        <option value="Professionals">Professionals</option>
                                    </select>
                                </div>
                                <div class=" col-4  form-group input_parent" >
                                    <label>Select Blog Category:</label>
                                    <select class="form-control home_owners_cat" name="home_owners_category" id="home_owners_category">
                                        <?php
                                        foreach($blogCategory as $main){
                                            if($main['cat_type'] === 'home_owners_category'){ ?>
                                            <option value="<?= $main['id'] ?>"><?= $main['name'] ?></option>
                                           <?php } 
                                        }
                                        ?>
                                    </select>
                                    <select class="form-control tradespeople_cat" name="tradespeople_category" id="tradespeople_category" style="display:none">
                                        <?php
                                        foreach($blogCategory as $main){
                                            if($main['cat_type'] === 'tradespeople_category'){ ?>
                                            <option value="<?= $main['id'] ?>"><?= $main['name'] ?></option>
                                           <?php } 
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class=" col-4  form-group input_parent" id="category_div" style="display: none" >
                                    <label>Select Job Main Category</label>
                                    <select class="form-control" id="select_main_category">
                                        <option value="0">Please Select</option>
                                        <?php
                                        foreach($mainCategory as $main){
                                            ?>
                                            <option value="<?=$main['id']?>"><?=$main['category_name']?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class=" col-4  form-group input_parent" >
                                    <label>Publish date:</label>
                                    <input class="form-control"  required  type="date" id="publish_date">
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-12 form-group input_parent">
                                    <label class="">Short description:</label>
                                    <textarea class="form-control" type="text"  rows="4" id="short_description" ></textarea>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12 form-group input_parent">
                                    <label>Long description:</label>
                                    <textarea class="form-control" type="text"  id="long_description" ></textarea>
                                </div>
                            </div>
                            <div class="text-center my-2">
                                <button class="btn btn-success" type="submit" id="blog_btn">Submit</button>
                            </div>
                        </form>
                    </div>


                </div>
            </div>
            <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->


    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include 'includes/footer.php' ?>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<script>
    $( document ).ready(function() {
        $("#blog").addClass("active");
    });
    $("#category1").change(function (e){

        e.preventDefault();
        user_category=$("#category1 option:selected").val();
        if(user_category=="Professionals"){

            $("#category_div").show();
            $("#home_owners_category").hide(); 
            $("#tradespeople_category").show();
        }else {

            $("#category_div").hide();
            $("#tradespeople_category").hide();
            $("#home_owners_category").show();
        
        }
    });
</script>
<script src="js/tinymce.min.js"></script>

<script>
    // tinymce.init({
    //     selector: ".tinyMCE-content-full1",
    //     theme: "modern",
    //     width: 680,
    //     height: 300,
    //     plugins: [
    //         "advlist autolink link image lists charmap print preview hr anchor pagebreak",
    //         "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
    //         "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
    //     ],
    //     toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
    //     toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
    //     image_advtab: true ,
    //
    //     external_filemanager_path:"../uploads/blogimages",
    //     filemanager_title:"Responsive Filemanager" ,
    //     external_plugins: { "filemanager" : "/filemanager/plugin.min.js"}
    // });
    //
    //  tinyMCE.init({
    //      selector: '#long_description1',
    //      height: 400,
    //      theme: 'modern',
    //      plugins: [
    //          'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    //          'searchreplace wordcount visualblocks visualchars code fullscreen',
    //          'insertdatetime media nonbreaking save table contextmenu directionality',
    //          'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help image code'
    //      ],
    //      toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | fontsizeselect',
    //      toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
    //
    //      fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
    //      image_advtab: true,
    //      file_picker_types: 'file image media',
    //      images_upload_handler: function (blobInfo, success, failure) {
    //          var xhr, formData;
    //          xhr = new XMLHttpRequest();
    //          xhr.withCredentials = false;
    //          xhr.open('POST', '../serverside/upload.php');
    //          var token = $('[name="csrf-token"]').prop('content');
    //          xhr.setRequestHeader("X-CSRF-Token", token);
    //          xhr.onload = function() {
    //              var json;
    //              if (xhr.status != 200) {
    //                  failure('HTTP Error: ' + xhr.status);
    //                  return;
    //              }
    //              json = JSON.parse(xhr.responseText);
    //
    //              if (!json || typeof json.location != 'string') {
    //                  failure('Invalid JSON: ' + xhr.responseText);
    //                  return;
    //              }
    //              success(json.location);
    //          };
    //          formData = new FormData();
    //          formData.append('file', blobInfo.blob(), blobInfo.filename());
    //          xhr.send(formData);
    //      },
    //      file_picker_callback: function(cb, value, meta) {
    //          var input = document.createElement('input');
    //          input.setAttribute('type', 'file');
    //          input.setAttribute('accept', 'image/* audio/* video/*');
    //          input.onchange = function() {
    //              var file = this.files[0];
    //              var reader = new FileReader();
    //              reader.readAsDataURL(file);
    //              reader.onload = function () {
    //                  var id = 'blobid' + (new Date()).getTime();
    //                  var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
    //                  var base64 = reader.result.split(',')[1];
    //                  var blobInfo = blobCache.create(id, file, base64);
    //                  blobCache.add(blobInfo);
    //                  // call the callback and populate the Title field with the file name
    //                  cb(blobInfo.blobUri(), { title: file.name });
    //              };
    //          };
    //          input.click();
    //      }
    //  });

    tinymce.init({
        selector: '#long_description',
        toolbar: "undo redo | styleselect | fontselect | link image | media | bold italic | alignleft aligncenter alignright alignjustify | outdent indent",
        font_formats: "Noto-Nastaliq-Urdu = Noto Nastaliq Urdu; Noto-Sans-Arabic = Noto Sans Arabic;Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Oswald=oswald; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats",
        content_style: "@import url('https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400;500;600;700&family=Noto+Sans+Arabic:wght@100;200;300;400;500;600;700;800;900&display=swap'); body { font-family: Noto-Nastaliq-Urdu; }",
        height: 500,
        plugins: 'image code media',
        // images_upload_url : '../serverside/upload.php',
        automatic_uploads : true,
        file_picker_types: 'image',
        image_title: true,
        image_generaltab:false,
        image_sourcetab:false,
        images_upload_handler : function(blobInfo, success, failure) {
            var xhr, formData;
            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '../serverside/upload.php');
            xhr.onload = function() {
                var json;
                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }

                json = JSON.parse(xhr.responseText);
                if (!json || typeof json.file_path != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }
                success(json.file_path);
            };
            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            xhr.send(formData);
        },
    });


    tinymce.init({
        selector: '#short_description',
        toolbar: "undo redo | styleselect | fontselect | link image | bold italic | alignleft aligncenter alignright alignjustify | outdent indent",
        font_formats: "Noto-Nastaliq-Urdu = Noto Nastaliq Urdu; Noto-Sans-Arabic = Noto Sans Arabic;Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Oswald=oswald; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats",
        content_style: "@import url('https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400;500;600;700&family=Noto+Sans+Arabic:wght@100;200;300;400;500;600;700;800;900&display=swap'); body { font-family: Noto-Nastaliq-Urdu; }",
        height: 500,
    });
</script>
</body>
</html>

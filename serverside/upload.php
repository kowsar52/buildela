<?php
$url = array(
    "https://localhost"
);

reset($_FILES);
$temp = current($_FILES);

if (is_uploaded_file($temp['tmp_name'])) {
    if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
        header("HTTP/1.1 400 Invalid file name,Bad request");
        return;
    }

    // Validating File extensions
    if (! in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array(
        "gif",
        "jpg",
        "jpeg",
        "png"
    ))) {
        header("HTTP/1.1 400 Not an Image");
        return;
    }

    $file_tmp=$temp['tmp_name'];
    $target="../uploads/blogimages/";
    $timestamp=time();
    $file=$timestamp.'-'.$temp['name'];
    $upload_to=$target.$file;
    $returnpath = "http://hellolandlord.co.uk/uploads/blogimages/".$file;
    move_uploaded_file($temp['tmp_name'], $upload_to);

    // Return JSON response with the uploaded file path.
    echo json_encode(array(
        'file_path' => $returnpath
    ));
}
?>
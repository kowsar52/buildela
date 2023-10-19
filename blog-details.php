<?php
include_once "includes/header.php";
include_once "serverside/functions.php";
$func=new Functions();
$blogs=$func->getBlogByID($_GET['id']);
$blog=$blogs[0];
$temp=explode('/',$blogs[0]['image_path']);
$path="";
if(!empty($temp))
{
    $path=$temp[1]."/".$temp[2]."/".$temp[3];
}
?>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<style>
.home-owner-reward-wrapper {
    margin-bottom: 225px;
}
.home-owner-reward-wrapper p{
  font-size: 1rem;
}
h2.text-center.my-2 {
    font-weight: 600;
    color: #006bf5;
    margin-top: 4rem!important;
}
</style>
<div class="home-owner-reward-wrapper mt-5">
    <div class="w-container container-2" >

        <div class="my-3 ">
            <img src="<?=$path?>" alt="<?=$blog['title']?>" class="shadow-lg rounded-lg w-100">
            <div class="mt-3 p-4">
                <div class="d-flex  align-items-center justify-content-between">
                    <h2 class="card-title text-dark fs-16 lh-2 mb-0">
                        <?=$blog['title']?>
                    </h2>
<!--                    <h2 class=" text-dark fs-16 lh-2 mb-0">-->
<!--                        --><?//=$blog['category']?>
<!--                    </h2>-->
                </div>

                <div class="border-top border-bottom my-3 d-flex py-2 align-items-center">
                    <div class="text-gray-light align-items-center mr-3">
                        <i class="fa fa-user text-dark" aria-hidden="true"></i>
                        <span class="pl-1"><?=$blog['author_name']?></span>
                    </div>
                    <div class="text-gray-light align-items-center">
                        <i class="fa fa-calendar text-dark" aria-hidden="true"></i>
                        <span class="pl-1"><?=date('d M, Y',strtotime($blog['create_date']))?></span>
                    </div>
                </div>
                <p class="font-weight-500 text-dark  my-2 text-justify">
                    <?=$blog['short_description']?>
                </p>
                <p class="font-weight-500 text-dark  mb-2 text-justify">
                    <?=$blog['long_description']?>
                </p>
            </div>


        </div>
    </div>
</div>
<?php include_once "includes/footer.php";?>

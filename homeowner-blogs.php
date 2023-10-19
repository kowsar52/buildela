<?php
$pageTitle = "Project Advice";
$pageDescription = "Read Expert Advice on How to Save Money and Hire the Right Tradesperson";
include_once "includes/header.php";
include_once "serverside/functions.php";
$func=new Functions();

$blogs=$func->getHomeownerBlogs();
$blogCategory=$func->blogCategory();
?>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<style>
.home-owner-reward-wrapper {
    margin-bottom: 300px;
}
.home-owner-reward-wrapper h3 {
    font-size: 25px;
    font-weight: 700;

}
.home-owner-reward-wrapper a {
    color: inherit;
}
.home-owner-reward-wrapper .card-holder {
    box-shadow: 0 2px 7px 0 rgba(20, 20, 43, 0.06);
    border: 1px solid #e5e5e5;
    border-radius: 7px;
}
.home-owner-reward-wrapper a:hover .card-holder{
  box-shadow: none;
}

.home-owner-reward-wrapper a:hover .card-holder .card-title {
    color: #006bf5;
}
.home-owner-reward-wrapper .card-holder .img-wrap img {
    border-radius: 7px;
    height: 100%;
    object-fit: cover;
    object-position: unset;
}
.home-owner-reward-wrapper .card-holder .img-wrap {
    padding: 10px 10px 0;
}
.home-owner-reward-wrapper .card-holder p {
    margin-bottom: 1.2rem!important;
    color: gray;
    min-height: 84px;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
}
.home-owner-reward-wrapper .card-holder p.font-weight-500.text-dark.mb-2.text-justify,p:empty {
    display: none!important;
}
h1.text-center.my-2 {
    font-weight: 600;
    color: #006bf5;
    margin-top: 5rem!important;
    margin-bottom: 4rem!important;
}
h2.card-title.fs-16.lh-2.mb-0 {
    font-size: 18px;
    margin-bottom: 10px!important;
    font-family: inherit;
    font-weight: 600;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
}

.card.shadow-hover-1 img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform .2s; /* Animation */
}

.card.shadow-hover-1:hover img {
  transform: scale(1.2);
}
.card.shadow-hover-1 {
    overflow: hidden;
}

.img-wrap {
    height: 230px;
    overflow: hidden;
}


.owl-nav .owl-prev,.owl-nav .owl-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
}

.owl-nav .owl-prev {
    left: -15px;
}

.owl-nav .owl-next {
    right: -15px;
}
.blog_see_all_main{
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.blog_see_all_main a{
    color: #006bf5;
    font-weight: 600;
    font-size: 15px;
}
.owl-nav .owl-prev i, .owl-nav .owl-next i {
    font-size: 23px;
    color: #d10a38;
    box-shadow: 0 0 5px rgba(0,0,0,.5);
    width: 30px;
    height: 30px;
    line-height: 30px;
    border-radius: 100vmax;
    background-color: #fff;
}
.owl-nav .owl-next:hover i, .owl-nav .owl-prev:hover i {
    background-color: #f0f0f0;
}
.owl-nav .owl-next.disabled, .owl-nav .owl-prev.disabled{
    opacity: 0;
}
html {
  scroll-behavior: smooth;
}
.homeowner_list ul{
    padding: 0px;
    display: inline-grid;
    grid-template-columns: repeat(5, 1fr);
    width: 100%;
    gap: 10px;
}
.homeowner_list li{
    display: block;
    margin: 0;
}
.homeowner_list a {
    color: #000;
    font-size: 15px;
    text-transform: none;
    border: 1px solid;
    padding: 8px 5px;
    text-align: center;
    border-radius: 5px;
    background: aliceblue;
    height: 100%;
    line-height: 1.2;
    display: flex;
    align-items: center;
    justify-content: center;
}
.homeowner_list a:hover{
    color: #006bf5;
}
@media (max-width: 1140px){
    .homeowner_list a{
        font-size: 14px;
    }
}
@media (max-width: 768px){
    .homeowner_list ul{
        grid-template-columns: repeat(2, 1fr);
    }
    .home-owner-reward-wrapper h3{
        font-size: 16px;
    }
}
/* Preloader overlay styles */
.preloader-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: #000000; /* Black background with 70% opacity */
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999; /* Ensure the overlay is above other elements */
}

/* Preloader styles */
.preloader {
  border: 16px solid #f3f3f3; 
  border-top: 16px solid #3498db; 
  border-radius: 50%;
  width: 120px;
  height: 120px;
  animation: spin 2s linear infinite;
}

/* Spin animation */
@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

</style>
<div class="preloader-overlay">
  <div class="preloader"></div>
</div>

<div class="home-owner-reward-wrapper">
    <div class="container">
        <h1 class="text-center my-2">Project Advice</h1>
        <div class="homeowner_list">
            <ul>
                <?php
                foreach($blogCategory as $main){
                    if($main['cat_type'] === 'home_owners_category'){
                        ?>
                        <li>
                            <a href="#blog_cat_<?=$main['id']?>"><?=$main['name']?></a>
                        </li>
                        <?php
                    }
                }
                ?>
            
            </ul>   
        </div>
        <?php
        $blogCount = 0; 
        $currentCategory = null; // Initialize variable to keep track of the current category
        foreach ($blogs as $blog) {
            if ($blog['blog_category'] !== $currentCategory) {
                // Close the previous category section if it's not the first iteration
                if ($currentCategory !== null) {
                    echo '</div>';
                }
                
                // Start a new section for a new category
                $currentCategory = $blog['blog_category'];
                $currentCategory_name = $func->blogCategorybyID($blog['blog_category']);
                $id__ = "blog_cat_".$currentCategory;
                echo '<div class="blog_see_all_main"><h3 class="my-2" id="'.$id__.'">' . $currentCategory_name[0]['name'] . '</h3> <a href="/blogs?id='.$blog['blog_category'].'">See All</a></div>';
                echo '<div class="py-4 mb-5 owl-carousel owl-blogs">';
                $blogCount = 0; 
            }
            if ($blogCount < 10) {
                $temp = explode('/', $blog['image_path']);
                $path = "";
                if (!empty($temp)) {
                    $path = $temp[1] . "/" . $temp[2] . "/" . $temp[3];
                }
                ?>
                <div class="my-2">

                    <a class="text-decoration-none" href="blog-details?id=<?=$blog['id']?>">
                        <div class="card-holder">
                            <div class="img-wrap">
                                <img src="<?=$path?>" alt="<?=$blog['title']?>">
                            </div>
                            <div class="p-4">
                                <h2 class="card-title fs-16 lh-2 mb-0">
                                    <?=$blog['title']?>
                                </h2>
                                <p class="font-weight-500 text-dark mb-2 text-justify">
                                    <?= (strlen($blog['short_description']) > 200) ? substr($blog['short_description'], 0, 200).'...' : $blog['short_description'] ?>
                                </p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="text-secondary align-items-center">
                                        <i class="fa-regular fa-user text-dark" aria-hidden="true"></i>
                                        <span class="pl-1"><?=$blog['author_name']?></span>
                                    </div>
                                    <div class="text-secondary align-items-center">
                                        <i class="fa-regular fa-calendar text-dark" aria-hidden="true"></i>
                                        <span class="pl-1"><?=date('d M, Y', strtotime($blog['create_date']))?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
                $blogCount++;
            }
        }
        
        // Close the last category section if there are blogs
        if (!empty($blogs)) {
            echo '</div>';
        }
        ?>
    </div>
</div>



<script>
$(document).ready(function(){
    $('h2.card-title.fs-16.lh-2.mb-0').each(function(){
        var text = $(this).text();
        if(text.length > 93) {
            $(this).text(text.substring(0,93) + '...');
        }
    });
});
</script>

<?php include_once "includes/footer.php";?>
<script>
window.addEventListener('load', function() {
    const preloaderOverlay = document.querySelector('.preloader-overlay');
    preloaderOverlay.style.display = 'none';
});
</script>

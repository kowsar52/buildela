<?php
include_once "includes/header.php";
include_once "serverside/functions.php";
$func=new Functions();

$blogs=$func->getBlogsByBlogCatID($_GET['id']);
$blog=$blogs[0];
$blogCategory = $func->blogCategorybyID($_GET['id']);
$blogCategory = $blogCategory[0];

// $blogCategory=$func->blogCategory();
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
.home-owner-reward-wrapper .card-holder p:empty {
    display: none !important;
}

.short_desc_main{
    min-height: 100px;
    max-height: 100px;
}
.home-owner-reward-wrapper .card-holder p,.home-owner-reward-wrapper .card-holder .short_desc_main span {
    margin-bottom: 1.2rem!important;
    color: gray;
/*    min-height: 84px;*/
overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 4;
    font-size: 13.92px;
    -webkit-box-orient: vertical;
    line-height: 17.92px !important;
    font-weight: 500;
}
.home-owner-reward-wrapper .card-holder p.font-weight-500.text-dark.mb-2.text-justify,p:empty {
    display: none!important;
}
h1.text-center.main_div_blog {
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
.main_div_blog .cat_name{
    position: absolute;
    bottom: 5px;
    right: 15px;
    padding: 6px 8px;
    background: #fff;
    border-radius: 5px;
}
@media(max-width:480px){
  .main_div_blog .cat_name{

    bottom: 15px;

}
}
.main_div_blog .img-wrap{
    position: relative;
}
html {
  scroll-behavior: smooth;
}
.professional_list{
    padding: 10px 0px;
    width: 100%;
}
.professional_list ul{
    padding: 0px;
    display: inline-grid;
    grid-template-columns: repeat(5, 1fr);
    width: 100%;
    gap: 10px;
}
.professional_list li{
    margin: 0;
    display: block;
}
.professional_list a {
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
.main_blog_category_div{
    display: grid;
    grid-template-columns: 1fr;
    gap: 25px;
}
/* Tablet - 2 columns */
@media (min-width: 600px) {
  .main_blog_category_div {
    grid-template-columns: repeat(2, 1fr);
  }
}

/* Desktop - 3 columns */
@media (min-width: 900px) {
  .main_blog_category_div {
    grid-template-columns: repeat(3, 1fr);
  }
}
.professional_list a:hover{
    color: #006bf5;
}
h1.text-center.my-2 {
    font-weight: 600;
    color: #006bf5;
    margin-top: 5rem!important;
    margin-bottom: 4rem!important;
}
@media (max-width: 1140px){
    .professional_list a{
        font-size: 14px;
    }
}
@media (max-width: 768px){
    .professional_list ul{
        grid-template-columns: repeat(2, 1fr);
    }
    .home-owner-reward-wrapper h3{
        font-size: 16px;
    }
}

</style>
<div class="home-owner-reward-wrapper">
    <div class="container">
        <h1 class="text-center my-2"><?= $blogCategory['name']; ?></h1>

        <div class="py-4 mb-5 main_blog_category_div">
        <?php
        $currentCategory = null;
        if(isset($_SESSION['user_id'])){
            $Skills=$func->getMySkills($_SESSION['user_id']);           
        } else {
            $Skills = '';
        }
        $blogCount = 0; 
        foreach ($blogs as $blog) {
            foreach ($Skills as $skill) {
                if ($blog['job_category'] !== $skill['main_category']) {
                    // Match found, set the flag to true and break out of the loop
                    continue 2;
                }
            }
            
                 $temp = explode('/', $blog['image_path']);
                $path = "";
                if (!empty($temp)) {
                    $path = $temp[1] . "/" . $temp[2] . "/" . $temp[3];
                }
                $categoryMapping = array(
                    'Architect' => 'Architecture',
                    'Bathroom Fitter' => 'Bathroom Fitting',
                    'Bricklayer' => 'Bricklaying',
                    'Carpenter' => 'Carpentry',
                    'Carpets, Lino & Flooring Installer' => 'Flooring Installation',
                    'Central Heating Engineer' => 'Central Heating',
                    'Chimney & Fireplace Engineer' => 'Chimney & Fireplace',
                    'Conservatory Installer' => 'Conservatory Installation',
                    'Damp Proofer' => 'Damp Proofing',
                    'Demolition & Clearance Engineer' => 'Demolition & Clearance',
                    'Driveway & Paving Installer' => 'Driveway & Paving Installation',
                    'Electrician' => 'Electrical Work',
                    'Extensions Installer' => 'Extensions Installation',
                    'Fascias, Soffits & Guttering Engineer' => 'Fascias, Soffits & Guttering',
                    'Fencer' => 'Fencing',
                    'Gardener' => 'Gardening',
                    'Gas Engineer' => 'Gas Work',
                    'Ground-worker' => 'Ground-working',
                    'Conversions Engineer' => 'Conversions',
                    'Handyman' => 'Handyman Services',
                    'Insulation Engineer' => 'Insulation',
                    'Kitchen Fitter' => 'Kitchen Fitting',
                    'Locksmith' => 'Locksmithing',
                    'Loft Conversions Engineer' => 'Loft Conversions',
                    'New Build Engineer' => 'New Build Construction',
                    'Painter/Decorator' => 'Painting/Decorating',
                    'Plasterer' => 'Plastering',
                    'Plumber' => 'Plumbing',
                    'Restoration & Refurbishment Engineer' => 'Restoration & Refurbishment',
                    'Roofer' => 'Roofing',
                    'Alarms/Security Engineer' => 'Alarms/Security Systems',
                    'Stonemason' => 'Stonemasonry',
                    'Tiler' => 'Tiling',
                    'Tree Surgeon' => 'Tree Surgery',
                    'Windows & Door Fitter' => 'Windows & Door Installation',
                    'Cleaner' => 'Cleaning',
                    'Rubbish/Waste Remover' => 'Rubbish/Waste Removal',
                    'Pest Control' => 'Pest Control',
                    'Air Conditioner Engineer' => 'Air Conditioning'
                );
                $mainCategory=$func->mainCategorybyID($blog['job_category']);
                if(!empty($mainCategory)){
                    $originalCategoryName = html_entity_decode($mainCategory[0]['category_name']);

                    if ($categoryMapping[$originalCategoryName]) {
                        $replacementCategoryName = $categoryMapping[$originalCategoryName];
                    } else {
                        $replacementCategoryName = $originalCategoryName;
                    }                    
                }




                ?>
                <div class="main_div_blog">
                    <a class="text-decoration-none" href="blog-details?id=<?=$blog['id']?>">
                        <div class="card-holder">
                            <div class="img-wrap">
                                <img src="<?=$path?>" alt="<?=$blog['title']?>">
                                <?php
                                if(!empty($mainCategory)){ ?>
                                    <span class="cat_name"><?php echo $replacementCategoryName; ?></span>
                               <?php }
                                ?>

                            </div>
                            <div class="p-4">
                                <h2 class="card-title fs-16 lh-2 mb-0">
                                    <?=$blog['title']?>
                                </h2>
                                <div class="short_desc_main">
                                    <p class="font-weight-500 text-dark mb-2 text-justify">
                                        <?php
                                            $shortDescription = $blog['short_description'];
                                               $truncatedHtml = $func->truncateHtml($shortDescription, 200);
                                               echo $truncatedHtml;
                                        ?>
                                    </p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="text-secondary align-items-center">
                                        <i class="fa-regular fa-user text-dark" aria-hidden="true"></i>
                                        <span class="pl-1"><?=$blog['author_name']?></span>
                                    </div>
                                    <div class="text-secondary align-items-center">
                                        <i class="fa-regular fa-calendar text-dark" aria-hidden="true"></i>
                                        <span class="pl-1"><?= date('d M, Y', strtotime($blog['create_date'])) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
            }

        
        if (!empty($blogs)) {
            // echo '</div>';
        }
        ?>
        </div>
    </div>
</div>



<script>
$(document).ready(function(){
    $('h2.card-title.text-dark.fs-16.lh-2.mb-0').each(function(){
        var text = $(this).text();
        if(text.length > 93) {
            $(this).text(text.substring(0,93) + '...');
        }
    });
});


$(document).ready(function() {
    $('.home-owner-reward-wrapper .card-holder p').each(function() {
        var content = $(this).html().trim();
   if(content === '&nbsp;' || content === '' || content === '<span lang="EN-US"></span>') {
              $(this).hide();
          }
    });
});
</script>
<?php include_once "includes/footer.php";?>

<?php
include 'config-1.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>GadgetHub</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" type="text/css" href="css/style-0.css">
    <link rel="stylesheet" type="text/css" href="css/scrollbar.css">

</head>
<body>

<!-- header section starts  -->

<?php
include 'components/header.php';
?>


<!-- header section ends -->

<!-- home section starts  -->

<section class="home" id="home">

    <div class="image">
        <img src="images-0/home-img.jpg" alt="">
    </div>


    <div class="content">
        <span>&nbsp Your Tech Universe </span>
        <h3>&nbsp Simplified</h3>
        <a href="#product" class="btn">get started</a>
    </div>

</section>

<!-- home section ends -->

<!-- banner section starts  -->

<section class="banner-container">

    <div class="banner">
        <img src="images-0/banner-1.jpg" alt="">
        <div class="content">
            <h3 style="color:rgb(141, 199, 63)">special offer</h3>
            <p style="color:rgb(141, 199, 63)">upto 45% off</p>
            <a href="#" class="btn">check out</a>
        </div>
    </div>

    <div class="banner">
        <img src="images-0/banner-2.webp" alt="">
        <div class="content">
            <h3 style="color:rgb(141, 199, 63)">limited offer</h3>
            <p style="color:rgb(141, 199, 63)">upto 50% off</p>
            <a href="#" class="btn">check out</a>
        </div>
    </div>

</section>

<!-- banner section ends -->

<!-- category section starts  -->

<section class="category" id="category">

    <h1 class="heading">shop by <span>category</span></h1>

    <div class="box-container">

        <div class="box">
            <h3>MICE</h3>
            <img src="images-0/category-1.jpg" alt="">
            <a href="mice.php" class="btn">shop now</a>
        </div>
        <div class="box">
            <h3>HEADSETS</h3>
            <img src="images-0/category-2.jpg" alt="">
            <a href="headsets.php" class="btn">shop now</a>
        </div>
        <div class="box">
            <h3>KEYBOARDS</h3>
            <img src="images-0/category-3.webp" alt="">
            <br>
            <a href="keyboards.php" class="btn">shop now</a>
        </div>
        <div class="box">
            <h3>PC GAMING</h3>
            <img src="images-0/category-4.jpg" alt="">
            <a href="pcgaming.php" class="btn">shop now</a>
        </div>

    </div>

</section>

<!-- category section ends -->

<!-- product section starts  -->

<section class="product" id="product">

    <h1 class="heading">latest <span>products</span></h1>
    <!-- deal section starts  -->

<section class="deal" id="deal">

<div class="content">
    
    <div class="count-down">
        <div class="box">
            <h3 class="day">100</h3>
            <span>day</span>
        </div>
        <div class="box">
            <h3 class="hour">20</h3>
            <span>hour</span>
        </div>
        <div class="box">
            <h3 class="minute">60</h3>
            <span>minute</span>
        </div>
        <div class="box">
            <h3 class="second">60</h3>
            <span>second</span>
        </div>

</section>

<!-- deal section ends -->

    <div class="box-container">

            <?php
            include 'discounts.php';
            ?>

    </div>


</section>

<!-- product section ends -->


<!-- newsletter section starts  -->

<section class="newsletter" style=" background-image:url('images-0/newsletter-bg.png')">


    <h3>subscribe us for latest updates</h3>

    <form action="">
        <input class="box" type="email" placeholder="enter your email">
        <input type="submit" value="subscribe" class="btn">
    </form>

</section>

<!-- newsletter section ends -->

<!-- footer section starts  -->

<?php
include 'components/footer.php';
?>

<!-- footer section ends -->


<!-- custom js file link  -->
<script src="script-0.js"></script>
    
</body>
</html>
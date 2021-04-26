<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<header>
<?php require 'header.php'; ?>
</header>

<body>
<!-- Image slideshow -->
<div class="flexcontainer">
    <div class="slideshow-container">

        <div class="mySlides">
            <img src="imgs/photo1.jpg" class="slideimg">
        </div>

        <div class="mySlides">
            <img src="imgs/photo2.jpg" class="slideimg">
        </div>

        <div class="mySlides">
            <img src="imgs/photo3.jpg" class="slideimg">
        </div>

        <div class="mySlides">
            <img src="imgs/photo4.jpg" class="slideimg">
        </div>
    </div>
    <script src="scripts/slide.js"></script>

    <div class="shopwrapper">
        <div><img class="homeshopimg" src="imgs/shopimg1.jpg"> </div>
        <div><img class="homeshopimg" src="imgs/shopimg2.jpg"></div>
        <div><img class="homeshopimg" src="imgs/shopimg3.jpg"></div>
        <div><img class="homeshopimg" src="imgs/shopimg4.jpg"></div>
        <div><img class="homeshopimg" src="imgs/shopimg5.jpg"></div>
    </div>

    <div class="shopwrapper">
        <div><a href="shop/shoppingcart/index.php?page=product&id=3"><button class="homeshopbutton">Shop</button></a></div>
        <div><a href="shop/shoppingcart/index.php?page=product&id=4"><button class="homeshopbutton">Shop</button></a></div>
        <div><a href="shop/shoppingcart/index.php?page=product&id=2"><button class="homeshopbutton">Shop</button></a></div>
        <div><a href="shop/shoppingcart/index.php?page=product&id=1"><button class="homeshopbutton">Shop</button></a></div>
        <div><button class="homeshopbutton">Coming soon!</button></div>
    </div>
</body>

<footer>
    <?php require 'footer.php'; ?>
</footer>
</html>

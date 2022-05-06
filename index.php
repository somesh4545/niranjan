<?php
include './db.php';
session_start();
$cust_id = 0;
if (isset($_SESSION['cust_id'])) {
  $cust_id = $_SESSION['cust_id'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
  <!-- ======== Swiper Js ======= -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.7.5/swiper-bundle.min.css" />

  <!-- Boxicons -->
  <link href='https://unpkg.com/boxicons@2.0.8/css/boxicons.min.css' rel='stylesheet'>
  <!-- Custom StyleSheet -->
  <link rel="stylesheet" href="./styles.css" />
  <link rel="stylesheet" href="./css/snackbar.css" />
  <!-- Favicon -->
  <link rel="shortcut icon" href="/webproj/images/logo.png" type="image/png" />
  <title>Niranjan</title>
</head>

<body>

  <!-- Navigation -->
  <?php
  include "./components/nav.php";
  ?>

  <div class="hero">
    <div class="row">
      <div class="swiper-container slider-1">
        <div class="swiper-wrapper">
          <?php
          $sql = "SELECT * FROM banner";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $image = $row['image_url'];
              // echo $image;
              echo "
                <div class='swiper-slide'>
                    <img src='$image' />
                </div>";
            }
          }
          ?>

        </div>
      </div>
    </div>
    <!-- Carousel Navigation -->
    <div class="arrows d-flex">
      <div class="swiper-prev d-flex">
        <i class="bx bx-chevrons-left swiper-icon"></i>
      </div>
      <div class="swiper-next d-flex">
        <i class="bx bx-chevrons-right swiper-icon"></i>
      </div>
    </div>
  </div>


  <!-- Promotion -->

  <section class=" section promotion">
    <div class="title">
      <h2>Categories</h2>
      <span>Select from the premium product and save plenty money</span>
    </div>

    <div class="promotion-layout container">
      <?php
      $sql = "SELECT * FROM categories";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $category_id = $row['id'];
          $image_url = $row['image_url'];
          $category_name = $row['name'];
          echo "
            <div class='promotion-item'>
              <img src='$image_url' />
              <div class='promotion-content'>
                <h3>$category_name</h3>
                <a href='./Collection.php?id=$category_id'>SHOP NOW</a>
              </div>
            </div>
          ";
        }
      }
      ?>

    </div>
  </section>

  <!-- Featured -->
  <section class="section featured">
    <div class="title">
      <h2>Featured Products</h2>
      <span>Select from the premium product brands and save plenty money</span>
    </div>

    <div class="row container">
      <div class="swiper-container slider-2">
        <div class="swiper-wrapper">
          <?php
          $sql = "SELECT * FROM `products` WHERE featured=1 ORDER BY date DESC LIMIT 10";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $product_id = $row['id'];
              $product_name = $row['name'];
              $price = $row['price'];
              $discount_price = $row['discount_price'];
              $image_url = $row['image_url'];
              // $cust_id = 1;
              echo "
                <div class='swiper-slide'>
                  <div class='product'>
                    
                    <div class='img-container'>
                      <img src='$image_url' alt='' />
                      <button onclick='performOnCart($cust_id, $product_id)' style='z-index: 100; background: none; outline: none; border: none;'>
                        <div class='addCart'>
                          <i class='fas fa-shopping-cart'></i>
                        </div>
                      </button>
                      <ul class='side-icons'>
                        <span><i class='fas fa-share'></i></span>
                      </ul>
                    </div>
                    <a href='productDetails.php?id=$product_id'>
                      <div class='bottom'>
                        <a href='productDetails.php?id=$product_id'>$product_name</a>
                        <div class='price'>
                          <span>₹$discount_price</span>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              ";
            }
          }
          ?>

        </div>
      </div>
    </div>

    <!-- Carousel Navigation -->
    <div class="arrows d-flex">
      <div class="custom-next d-flex">
        <i class="bx bx-chevrons-right swiper-icon"></i>
      </div>
      <div class="custom-prev d-flex">
        <i class="bx bx-chevrons-left swiper-icon"></i>
      </div>
    </div>
  </section>

  <!-- Products -->
  <section class="section products">
    <div class="title">
      <h2>New Products</h2>
      <span>Select from the premium product brands and save plenty money</span>
    </div>

    <div class="product-layout" style="margin: 0 auto;">

      <?php
      $sql = "SELECT * FROM `products` WHERE quantity>0 ORDER BY date DESC LIMIT 8";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $product_id = $row['id'];
          $product_name = $row['name'];
          $price = $row['price'];
          $discount_price = $row['discount_price'];
          $image_url = $row['image_url'];
          // $cust_id = 1;

          echo "
             <div class='product'>
              
                <div class='img-container'>
                  <img src='$image_url' alt='' />
                  <button onclick='performOnCart($cust_id, $product_id)' style='z-index: 100; background: none; outline: none; border: none;'>
                    <div class='addCart'>
                      <i class='fas fa-shopping-cart'></i>
                    </div>
                  </button>

                  <ul class='side-icons'>
                    <span><i class='fas fa-share'></i></span>
                  </ul>
                </div>
                <a href='productDetails.php?id=$product_id'>
                  <div class='bottom'>
                    <a href='productDetails.php?id=$product_id'>$product_name</a>
                    <div class='price'>
                      <span>₹$discount_price</span>
                    </div>
                  </div>
                </a>
              </a>
            </div>
          ";
        }
      }
      ?>

    </div>
  </section>

  <!-- ADVERT -->
  <!-- <section class="section advert">
    <div class="advert-layout container">
      <div class="item ">
        <img src="./images/kit.png" alt="">
        <div class="content">
          <span>Exclusive Sales</span>
          <h3>Spring Collections</h3>
          <a href="">View Collection</a>
        </div>
      </div>
      <div class="item">
        <img src="./images/New/new6.jpg" alt="">
        <div class="content">
          <span>New Trending</span>
          <h3>Designer Bags</h3>
          <a href="">Shop Now </a>
        </div>
      </div>
    </div>
  </section> -->

  <!-- BRANDS -->
  <section class="section brands">
    <div class="title">
      <h2>Shop by Brand</h2>
      <span>Select from the premium product brands and save plenty money</span>
    </div>

    <div class="brand-layout container">
      <div class="swiper-container slider-3">
        <div class="swiper-wrapper">
          <?php
          $sql = "SELECT * FROM brands";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $brand_name = $row['name'];
              $image_url = $row['image_url'];

              echo "
                <div class='swiper-slide'>
                   <img src='$image_url'>
                </div>
              ";
            }
          }
          ?>


        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <?php

  include "./components/footer.php";

  ?>
  <!-- End Footer -->

  <!-- ======== SwiperJS ======= -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.7.5/swiper-bundle.min.js"></script>
  <!-- Custom Scripts -->
  <script src="./js/slider.js"></script>
  <script src="./js/index.js"></script>
  <script src="./functions.js"></script>
</body>

</html>
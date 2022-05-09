<?php
include './db.php';
session_start();
$cust_id = 0;
if (isset($_SESSION['cust_id'])) {
  $cust_id = $_SESSION['cust_id'];
}



$sub_category_arr = array();
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
  <link rel="shortcut icon" href="/images/logo.png" type="image/png" />
  <title>Niranjan</title>
</head>

<body>

  <!-- Navigation -->
  <?php
  include "./components/nav.php";
  ?>

  <?php
  if (!isset($_GET['id'])) {
    echo "<script>
                        window.open('./index.php', '_self');
                    </script>";
  }
  $id = $_GET['id'];
  $sql = "SELECT * FROM banner where category=$id";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
  ?>
    <div class="hero">
      <div class="row">
        <div class="swiper-container slider-1">
          <div class="swiper-wrapper">
            <?php

            while ($row = $result->fetch_assoc()) {
              $image = $row['image_url'];
              // echo $image;
              echo "
                <div class='swiper-slide'>
                    <img src='$image' />
                </div>";
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
  <?php

  }
  ?>


  <!-- Promotion -->


  <?php
  if (!isset($_GET['id'])) {
    echo "<script>
                  window.open('./index.php', '_self');
              </script>";
  }
  $id = $_GET['id'];
  $sql = "SELECT * FROM categories where subCategory=$id";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
  ?>
    <section class=" section promotion">
      <div class="title">
        <h2>Sub Categories</h2>
        <!-- <span>Select from the premium product and save plenty money</span> -->
      </div>

      <div class="promotion-layout container">
        <?php
        while ($row = $result->fetch_assoc()) {
          $category_id = $row['id'];
          array_push($sub_category_arr, $category_id);
          $image_url = $row['image_url'];
          $category_name = $row['name'];
          echo "
            <div class='promotion-item'>
              <a href='./subcollection.php?id=$category_id'>
              <img src='$image_url' />
              <div class='promotion-content'>
                <h3>$category_name</h3>
              </div>
               </a>
            </div>
          ";
        }
        ?>

      </div>
    </section>
  <?php

  }
  ?>

  <!-- Products -->
  <section class="section products">
    <div class="title">
      <h2>Latest Products</h2>
      <span>Select from the premium product brands and save plenty money</span>
    </div>

    <div class="product-layout" style="margin: 0 auto;">

      <?php
      $total = 0;
      $id = $_GET['id'];
      array_push($sub_category_arr, $id);
      foreach ($sub_category_arr as $sub_category) {

        $sql = "SELECT * FROM `products` WHERE quantity>0 and category_id=$sub_category ORDER BY date DESC LIMIT 8";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          // $total += mysqli_num_rows($result);
          while ($row = $result->fetch_assoc()) {
            $total += 1;
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
            if ($total > 8) {
              break;
            }
          }
        }
      }

      ?>

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
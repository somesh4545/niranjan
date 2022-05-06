<?php
include './db.php';

session_start();
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

  <!-- Product Details -->
  <section class="section product-detail">
    <div class="details container">
      <?php
      $id = $_GET['id'];
      $query = mysqli_query($conn, "SELECT *, 
                            products.name AS product_name, 
                            products.id AS product_id, 
                            products.image_url AS product_image, 
                            categories.name AS category_name 
                            FROM `products` 
                            INNER JOIN categories ON products.category_id=categories.id 
                            where products.id=$id");
      while ($run = mysqli_fetch_array($query)) {
        $id = $run['id'];
        $product_id = $run['product_id'];
        $image = $run['product_image'];
        $name = $run['name'];
        $price = $run['price'];
        $discount_price = $run['discount_price'];
        $details = $run['details'];
        $cat_name = $run['category_name'];
      ?>
        <div class="left">
          <div class="main row">
            <img src="<?= $image ?>" alt="" />

          </div>
        </div>
        <div class="right">
          <span><?= $cat_name ?></span>
          <h1><?= $name ?></h1>
          <div style="display: flex; flex-direction:row">
            <div class="price">₹<?= $discount_price ?></div>
            <div class="prevPrice">₹<?= $price ?></div>
          </div>

          <form class="form" method="POST">
            <input type="number" name="qty" min="1" value="1" style="width: 60px" />
            <input type="number" name="p_id" hidden value="<?php echo $product_id ?>">
            <button class="addCartDetails">Add To Cart</button>
          </form>
          <h3>Product Detail</h3>
          <p>
            <?= $details ?>
          </p>
        </div>

      <?php
      }
      ?>
    </div>
  </section>



  <!-- Footer -->
  <?php

  include "./components/footer.php";

  ?>
  <!-- End Footer -->

  <!-- Custom Scripts -->
  <script src="./js/index.js"></script>
  <script src="./functions.js"></script>

  <?php
  if (isset($_POST['qty'])) {
    if (isset($_SESSION['cust_id'])) {
      $cust_id = $_SESSION['cust_id'];
      $product_id = $_POST['p_id'];
      $quantity = $_POST['qty'];
      if ($quantity > 0) {
        $sql = "SELECT * FROM cart where cust_id=$cust_id and product_id=$product_id";
        $result = $conn->query($sql);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
          $sql = "UPDATE cart set quantity=(SELECT quantity from cart where cust_id=$cust_id and product_id=$product_id)+$quantity where cust_id=$cust_id and product_id=$product_id";
          $result = $conn->query($sql);
          if ($result) {
            echo "<script>sendToast('Added to cart')</script>";
          } else {
            echo "<script>sendToast('Something went wrong please try again')</script>";
          }
        } else {
          $sql = "INSERT into cart (cust_id, product_id, quantity) VALUES($cust_id, $product_id, $quantity)";
          $result = $conn->query($sql);
          if ($result) {
            echo "<script>sendToast('Added to cart')</script>";
          } else {
            echo "<script>sendToast('Something went wrong please try again')</script>";
          }
        }
      } else {
        echo "<script>sendToast('Quantity should be more than 0')</script>";
      }
    } else {
      echo "<script>sendToast('Please sign in or sign up to add to cart')</script>";
    }
  }
  ?>
</body>

</html>
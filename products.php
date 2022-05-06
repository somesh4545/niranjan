<?php
include './db.php';
session_start();
$cust_id = 0;
if (isset($_SESSION['cust_id'])) {
  $cust_id = $_SESSION['cust_id'];
}
$results_per_page = 4;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />


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

  <!-- PRODUCTS -->

  <section class="section products">
    <div class="products-layout container">
      <div class="col-3-of-4">
        <div class="sortclass">
          <form action="" class="SortSubClass">
            <div class="item">
              <label for="sort-by">Sort By</label>
              <select name="sort-by" id="sort-by">
                <option value="title" selected="selected">Name</option>
                <option value="number">Price</option>
                <option value="search_api_relevance">Relevance</option>
                <option value="created">Newness</option>
              </select>
            </div>
            <a href="">Apply</a>
          </form>
        </div>

        <div class="product-layout">

          <?php

          if (!isset($_GET['page'])) {
            $page = 1;
          } else {
            $page = $_GET['page'];
          }

          $page_first_result = ($page - 1) * $results_per_page;

          $query = mysqli_query($conn, "SELECT * FROM products LIMIT " . $page_first_result . "," . $results_per_page);
          while ($run = mysqli_fetch_array($query)) {
            $product_id = $run['id'];
            $image = $run['image_url'];
            $name = $run['name'];
            $price = $run['discount_price'];
            $id = $run['id'];
            // $cust_id = 1;

          ?>

            <div class="product">

              <div class="img-container">
                <img src="<?= $image ?>" alt="" />
                <button onclick='performOnCart(<?= $cust_id ?>, <?= $product_id ?>)' style='z-index: 100; background: none; outline: none; border: none;'>
                  <div class='addCart'>
                    <i class='fas fa-shopping-cart'></i>
                  </div>
                </button>

                <ul class="side-icons">
                  <span><i class="fas fa-share"></i></span>
                </ul>
              </div>
              <a href="productDetails.php?id=<?= $id ?>">
                <div class="bottom">
                  <a href="productDetails.php?id=<?= $id ?>"><?= $name ?></a>
                  <div class="price">
                    <span>₹<?= $price ?></span>
                  </div>
                </div>
              </a>
            </div>

          <?php
          }
          ?>

        </div>

        <!-- PAGINATION -->
        <ul class="pagination">
          <?php
          $query = mysqli_query($conn, "SELECT * FROM `products`");
          $num = mysqli_num_rows($query);
          $number_of_page = ceil($num / $results_per_page);
          for ($i = 1; $i <= $number_of_page; $i++) {
            echo "<span><a href='./products.php?page=$i'>$i</a></span>";
          }
          ?>
        </ul>
      </div>
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

</body>

</html>
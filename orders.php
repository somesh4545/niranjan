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

  <!-- Custom StyleSheet -->
  <link rel="stylesheet" href="./styles.css" />
  <!-- Favicon -->
  <link rel="shortcut icon" href="/webproj/images/logo.png" type="image/png" />
  <title>Niranjan</title>
</head>

<body>

  <!-- Navigation -->
  <?php
  include "./components/nav.php";
  ?>

  <!-- Cart Items -->
  <div class="container cart">
    <table>


      <?php
      if (isset($_SESSION['cust_id'])) {

      ?>
        <tr>
          <th>Product</th>
          <th>Quantity</th>
          <th>Amount</th>
          <th>Status</th>
        </tr>
        <?php
        $cust_id = $_SESSION['cust_id'];
        // echo $cust_id;
        $query = mysqli_query($conn, "SELECT *, 
                                      products.id AS product_id,
                                      orders.quantity AS order_quantity 
                                      FROM `orders` INNER JOIN products ON orders.product_id=products.id where cust_id=$cust_id");
        while ($run = mysqli_fetch_array($query)) {
          $image = $run['image_url'];
          $name = $run['name'];
          $product_id = $run['product_id'];
          $price = $run['amount'];
          $quantity = $run['order_quantity'];
          $status = $run['order_status'];
        ?>
          <tr>
            <td>
              <div class="cart-info">
                <img src="<?= $image ?>" alt="" />
                <div style="align-items: center;
                          justify-content: center;
                          display: flex;
                          flex-direction: column;">
                  <a href="./productDetails.php?id=<?= $product_id ?>"><?= $name ?></a>
                  <span>Price: ₹ <?= $price ?></span>
                </div>
              </div>
            </td>
            <td>
              <h4><?= $quantity ?></h4>
            </td>
            <td>₹ <?= $price ?></td>
            <td><?= $status ?></td>
          </tr>

        <?php
        }
        ?>
      <?php
      } else {
        print_r("Please sign in to see your orders");
      }


      ?>

    </table>
  </div>

  <!-- Footer -->
  <?php

  include "./components/footer.php";

  ?>
  <!-- End Footer -->

  <!-- Custom Scripts -->
  <script src="./js/index.js"></script>
</body>

</html>

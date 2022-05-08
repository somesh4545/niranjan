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

  <!-- Cart Items -->
  <div class="container cart">
    <?php
    $subtotal = 0;
    $tax = 50;
    $total_amount = 0;
    ?>
    <?php
    if (isset($_SESSION['cust_id'])) {

    ?>
      <?php
      $cust_id = $_SESSION['cust_id'];
      $sql = "SELECT *, cart.id AS cart_id, cart.quantity AS cart_quantity, products.quantity AS product_quantity FROM `cart` INNER JOIN products ON product_id=products.id WHERE cust_id=$cust_id";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
      ?>
        <table>

          <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Subtotal</th>
          </tr>
          <?php

          while ($row = $result->fetch_assoc()) {
            $product_id = $row['product_id'];
            $cart_id = $row['cart_id'];
            $product_name = $row['name'];
            $cust_id = $row['cust_id'];
            $product_id = $row['product_id'];
            $price = $row['price'];
            $discount_price = $row['discount_price'];
            // $total = $row['total'];
            $cart_quantity = $row['cart_quantity'];
            $product_quantity = $row['product_quantity'];
            $image_url = $row['image_url'];
            $cart_item_total = $discount_price * $cart_quantity;

            $subtotal += $cart_item_total;
            echo "
            <tr>
              <td>
                <div class='cart-info'>
                  <img src='$image_url' alt='' />
                  <div style='justify-content: center;
                          display: flex;
                          flex-direction: column;'>
                    <a href='./productDetails.php?id=$product_id'>$product_name</a>
                    
                    <span>Price: $discount_price</span>
                    <a onclick='removeFromCart($cust_id, $product_id)'>Remove</a>
                  </div>
                </div>
              </td>
              <td style='display: flex; align-items: center; '>
                <button class='counter' onclick='updateCart($cart_id, $cust_id, $product_id, $cart_quantity, $cart_quantity-1, $discount_price)' >-</button>
                <p style='padding: 5px'>$cart_quantity </p>
                <button class='counter' onclick='updateCart($cart_id, $cust_id, $product_id, $cart_quantity, $cart_quantity+1,  $discount_price)'>+</button>
              </td>
              <td>₹$cart_item_total</td>
            </tr>
          ";
          }

          $cust_id = base64_encode($cust_id);
          ?>
        </table>

        <div class="total-price">
          <table>
            <!-- <tr>
            <td>Subtotal</td>
            <td>₹<?= $subtotal ?></td>
          </tr>
          <tr>
            <td>Tax</td>
            <td>₹<?= $tax ?></td>
          </tr> -->
            <tr>
              <td>Total</td>
              <td>₹<?php echo $subtotal ?></td>
            </tr>
          </table>
          <a href="../checkout/checkout.php" class="checkout btn">Proceed To Checkout</a>
        </div>
      <?php
      } else {
        print_r("No item found in cart");
      }

      ?>
    <?php
    } else {
      print_r("Please sign in to see your cart");
    }
    ?>
  </div>
  <div id="loading">
    <img id="loading-image" src="https://miro.medium.com/max/1400/1*CsJ05WEGfunYMLGfsT2sXA.gif" alt="Loading..." />
  </div>


  <!-- Footer -->
  <?php

  include "./components/footer.php";

  ?>
  <!-- End Footer -->

  <!-- Custom Scripts -->
  <script src="./js/index.js"></script>
  <script>
    const sendToast = (msg) => {
      const div = document.createElement("div");
      div.classList.add("snackbar");

      div.id = "emailToast";
      div.innerHTML = msg;
      document.body.appendChild(div);
      var x = document.getElementById("emailToast");
      x.className = "show";
      setTimeout(function() {
        x.className = x.className.replace("show", "");
        document.body.removeChild(div);
      }, 3000);
    };

    var loading_div = document.getElementById("loading");

    function updateCart(cart_id, cust_id, product_id, cart_quantity, new_quantity, price) {
      if (new_quantity == 0) {
        sendToast("Quantity cannot be 0");
        return false;
      }
      loading_div.style.display = "flex";
      var data = new FormData();
      data.append("updateCart", "updateCart");
      data.append("cart_id", cart_id);
      // data.append("cust_id", cust_id);
      data.append("p_id", product_id);
      data.append("quantity", cart_quantity);
      data.append("newQuantity", new_quantity);
      console.log(data);

      var xhr = new XMLHttpRequest();
      xhr.open("POST", "functions.php", true);
      xhr.onload = function() {
        // do something to response
        console.log(this.responseText);
        if (this.responseText == "true") {
          // sendToast
          location.reload();

        } else if (this.responseText == "false") {
          alert("not")
          sendToast("Cannot be added stock limit reached");
        }
      };
      xhr.send(data);

      loading_div.style.display = "none";
    }

    function removeFromCart(cust_id, p_id) {
      loading_div.style.display = "flex";
      var data = new FormData();
      data.append("removeFromCart", "removeFromCart");
      data.append("cust_id", cust_id);
      data.append("p_id", p_id);
      console.log(data);

      var xhr = new XMLHttpRequest();
      xhr.open("POST", "functions.php", true);
      xhr.onload = function() {
        // do something to response
        console.log(this.responseText);
        if (this.responseText == "true") {
          // sendToast
          sendToast("Removed item successfully");
          location.reload();

        } else if (this.responseText == "false") {
          sendToast("Unable to remove from cart. Please try again");
        }
      };
      xhr.send(data);

      loading_div.style.display = "none";
    }
  </script>
</body>

</html>
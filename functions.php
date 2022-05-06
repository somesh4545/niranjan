<?php

include './db.php';

// function updateCart($cust_id, $p_id, $quantity, $total)
// {
// }

if (isset($_POST['updateCart'])) {
    $cart_id = $_POST['cart_id'];
    $p_id = $_POST['p_id'];
    $quantity = $_POST['quantity'];
    $newQuantity = $_POST['newQuantity'];

    $sql = "SELECT * FROM `products` WHERE id=$p_id and quantity>=$newQuantity";
    $result = $conn->query($sql);
    $count = mysqli_num_rows($result);

    if ($count > 0) {
        $sql1 = "UPDATE `cart` SET quantity=$newQuantity where id=$cart_id";
        $result1 = $conn->query($sql1);
        echo "true";
    } else echo "false";
}

if (isset($_POST['removeFromCart'])) {
    $cust_id = $_POST['cust_id'];
    $p_id = $_POST['p_id'];

    $sql = "DELETE FROM `cart` WHERE cust_id=$cust_id and product_id=$p_id";
    $result = $conn->query($sql);

    if ($result) {
        echo "true";
    } else {
        echo "false";
    }
}

if (isset($_POST['performOnCart'])) {
    $cust_id = $_POST['cust_id'];
    $p_id = $_POST['p_id'];

    $sql = "SELECT * FROM `cart` WHERE cust_id=$cust_id and product_id=$p_id";
    // echo $sql;
    $result = $conn->query($sql);
    $count = mysqli_num_rows($result);
    if ($count == 0) {
        $sql1 = "INSERT INTO `cart` (cust_id, product_id, quantity) VALUES ($cust_id, $p_id, 1)";
        $res1 = $conn->query($sql1);
        if (!$res1) {
            echo "false";
        } else echo "added";
    } else {
        $sql2 = "DELETE FROM `cart` where cust_id=$cust_id and product_id=$p_id";
        $res2 = $conn->query($sql2);
        if (!$res2) {
            echo "false";
        } else echo "remove";
    }
}

if (isset($_POST['cod'])) {
    $cust_id = $_POST['cust_id'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    $res = mysqli_query($conn, "UPDATE customer SET address='$address', phone='$phone' WHERE id='$cust_id'");
    $sql = "SELECT * from cart where cust_id='$cust_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $product_id = $row['product_id'];
            $quantity = $row['quantity'];
            $sql2 = "SELECT discount_price from products where id = $product_id";
            $result2 = $conn->query($sql2);
            $total = 0;
            while ($row2 = $result2->fetch_assoc()) {
                $discount_price = $row2['discount_price'];
                $total = $discount_price * $quantity;
            }
            $sql = mysqli_query($conn, "INSERT into orders ( `cust_id`, `product_id`, `quantity`, `amount`, `payment_mode`) values ('$cust_id', 
				 '$product_id', '$quantity', '$total', 'COD')");
        }
        $result2 = mysqli_query($conn, "DELETE FROM cart where cust_id=$cust_id");
        echo "true";
    } else {
        echo "false";
    }
}

if (isset($_GET['logout'])) {
    session_start();
    unset($_SESSION['cust_id']);
    session_destroy();
    echo '<script>window.open("/webproj/index.php", "_self")</script>';
}

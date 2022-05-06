<?php
include '../db.php';
session_start();
if (!isset($_SESSION['cust_id'])) {
    echo "<script>
        window.open('../index.php', '_self');
    </script>";
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <!-- Favicon -->
    <link rel="shortcut icon" href="/webproj/images/logo.png" type="image/png" />
    <title>Niranjan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <!-- ======== Swiper Js ======= -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.7.5/swiper-bundle.min.css" />

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.8/css/boxicons.min.css' rel='stylesheet'>

    <!-- MATERIAL DESIGN ICONIC FONT -->
    <link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">

    <!-- STYLE CSS -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../css/snackbar.css">

    <!-- snackbar -->
    <!-- <link rel="stylesheet" href="../../css/snackbar.css"> -->
</head>

<body>
    <?php


    $total_amt = 0;
    $cust_id = $_SESSION['cust_id'];
    $sql = "SELECT * from cart where cust_id = '$cust_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $product_id = $row['product_id'];
            $quantity = $row['quantity'];
            $sql2 = "SELECT discount_price from products where id = $product_id";
            $result2 = $conn->query($sql2);
            while ($row2 = $result2->fetch_assoc()) {
                $discount_price = $row2['discount_price'];
                $total_amt += $discount_price * $quantity;
            }
            // $total = $row['total'];

            // $sql = "INSERT into orders values('$')";
        }
    }
    ?>

    <div class="authwrapper" style="background-image: url('images/bg-registration-form-2.jpg');">
        <div class="inner">
            <form id="form" onsubmit="online(event, <?= $cust_id ?>)">
                <h3>Please provide following information</h3>

                <div class="form-wrapper">
                    <label for="">Address :</label>
                    <input type="text" id="address" value="" class="form-control" required>
                </div>
                <div class="form-wrapper">
                    <div class="form-group">
                        <label for="">Phone number</label>
                        <!-- <a href="//auth/SignUp/" style="text-decoration:underline">Forgot?</a> -->
                    </div>
                    <input type="text" minlength="10" maxlength="10" id="number" value="" class="form-control" required>
                </div>

                <!-- <input type="hidden" id="ORDER_ID" tabindex="1" maxlength="20" size="20" name="ORDER_ID" autocomplete="off" value="<?php echo $order_id ?>">

                <input type="hidden" id="CUST_ID" tabindex="2" maxlength="12" size="12" name="CUST_ID" autocomplete="off" value="<?php echo $cust_id ?>">

                <input type="hidden" id="INDUSTRY_TYPE_ID" tabindex="4" maxlength="12" size="12" name="INDUSTRY_TYPE_ID" autocomplete="off" value="Retail"></td>

                <input type="hidden" id="CHANNEL_ID" tabindex="4" maxlength="12" size="12" name="CHANNEL_ID" autocomplete="off" value="WEB">

                <input title="TXN_AMOUNT" tabindex="10" type="hidden" name="TXN_AMOUNT" value="<?php echo $total_amt ?>"> -->



                <!-- <div class="checkbox">
                        <label>
                            <input type="checkbox"> .
                            <span class="checkmark"></span>
                        </label>
                    </div> -->
                <div style="display:flex; flex-direction:row;">
                    <button class="login-btn" type="submit">Pay ₹<?php echo $total_amt ?></button>
                    <button onclick="placeOrder(<?= $cust_id ?>)" type="button" class="login-btn">COD</button>
                </div>
            </form>
        </div>
    </div>
    <script src="../functions.js"></script>
    <script>
        function online(e, cust_id) {
            e.preventDefault();
            var adr = document.getElementById("address").value;
            var number = document.getElementById("number").value;

            if (adr.length > 0) {
                if (number.length == 10) {

                    var data = new FormData();
                    data.append("updateLocation", "true");
                    data.append("cust_id", cust_id);
                    data.append("address", adr);
                    data.append("phone", number);
                    console.log(data);

                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "", true);

                    xhr.send(data);

                    window.open("../PaytmKit/pgRedirect.php?cust_id=" + cust_id, "_self");
                } else {
                    sendToast("Number should be 10 digit long");
                }
            } else {
                sendToast("All fields are complusory");
            }
        }

        function placeOrder(cust_id) {
            var adr = document.getElementById("address").value;
            var number = document.getElementById("number").value;

            if (adr.length > 0) {
                if (number.length == 10)
                    cod(cust_id, adr, number);
                else
                    sendToast("Number should be 10 digit long");
            } else {
                sendToast("All fields are complusory");
            }
        }
    </script>

    <?php
    if (isset($_POST['updateLocation'])) {
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $cust_id = $_POST['cust_id'];
        $res = mysqli_query($conn, "UPDATE customer SET address='$address', phone='$phone' WHERE id='$cust_id'");
    }
    ?>
</body>

</html>
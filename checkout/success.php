<?php

include '../db.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />

    <!-- Custom StyleSheet -->
    <link rel="stylesheet" href="../styles.css" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="/images/logo.png" type="image/png" />
    <title>Niranjan</title>

    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />

    <style type="text/css">
        body {
            height: 100vh;
            background: #f2f2f2;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .row {
            display: flex;
            align-items: center;
            justify-content: center;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        .payment {
            border: 1px solid #f2f2f2;
            width: max-content;
            border-radius: 20px;
            background: #fff;
        }

        .payment_header {
            background: green;
            padding: 20px;
            border-radius: 20px 20px 0px 0px;

        }

        .check {
            margin: 0px auto;
            width: 50px;
            height: 50px;
            border-radius: 100%;
            background: #fff;
            text-align: center;
        }

        .check i {
            vertical-align: middle;
            line-height: 50px;
            font-size: 30px;
        }

        .content {
            display: flex;
            text-align: center;
            padding: 30px;
            text-align: center;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
        }

        .content h1 {
            font-size: 25px;

        }

        .content a {
            width: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            height: 33px;
            color: #fff;
            margin-top: 12px;
            border-radius: 30px;
            padding: 5px 10px;
            background: rgba(255, 102, 0, 1);
            transition: all ease-in-out 0.3s;
        }

        .content a:hover {
            text-decoration: none;
            background: #000;
        }
    </style>
</head>

<body>



    <div class="container">
        <div class="row">

            <div class="payment">
                <div class="payment_header">
                    <div class="check"><i class="fa fa-check" aria-hidden="true"></i></div>
                </div>
                <div class="content">
                    <h1>Order placed successfully !</h1>
                    <h4>To view your order press bellow button</h4>
                    <a href="../orders.php">Orders</a>
                </div>

            </div>

        </div>
    </div>



    <!-- Custom Scripts -->

</body>

</html>
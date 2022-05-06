<?php
include '../../db.php';

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    $sql = "UPDATE customer set verification_status=1 where email='$email'";
    if ($conn->query($sql) === TRUE) {
        echo "true";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_POST['createSessionAndSignIn'])) {
    session_start();
    $email = $_POST['email_id'];

    $sql = "SELECT id FROM `customer` WHERE email='$email'";
    $result = $conn->query($sql);
    $num = mysqli_num_rows($result);
    if ($num > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $_SESSION['cust_id'] = $id;
            // print_r($id);
        }
        echo "true";
    } else {
        echo "false";
    }
}

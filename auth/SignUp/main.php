<?php
include '../../db.php';

if (isset($_POST['fname'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $verification_status = $_POST['verification_status'];

    $sql = "INSERT INTO customer (`fname`, `lname`, `email`, `password`, `verification_status`)
VALUES ('$fname', '$lname', '$email', '$password', 0)";

    if ($conn->query($sql) === TRUE) {
        echo "true";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

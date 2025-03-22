<?php
session_start();
include("../dB/config.php");

if(isset($_POST['registration'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $number = $_POST['number'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];

    if($password != $cpassword) {
        $_SESSION['message'] = "Password does not match";
        $_SESSION['code'] = "error";
        header("Location: ../registration.php");
        exit(0);
    }

    // Check if email exists
    $query = "SELECT * FROM `users` WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        $_SESSION['message'] = "Email already exists";
        $_SESSION['code'] = "error";
        header("Location: ../registration.php");
        exit(0);
    }

    // Insert user data
    $query = "INSERT INTO `users` (`firstName`, `lastName`, `email`, `password`, `phoneNumber`, `gender`, `birthday`) 
              VALUES ('$firstName', '$lastName', '$email', '$password', '$number', '$gender', '$birthday')";

    if(mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Registration successful";
        $_SESSION['code'] = "success";
        header("Location: ./login.php");
        exit(0);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

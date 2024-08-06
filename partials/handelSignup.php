<?php
    $showError = false;
    $showAlert = false;
    if ($_SERVER["REQUEST_METHOD"]  == "POST") {
        include "dbConnection.php";
        $username = $_POST["username"];
        $password = $_POST["password"];
        $cpassword = $_POST["cpassword"];
        // check user exist or not
        $existSql = "SELECT * FROM `users` WHERE `username` = '$username'";
        $result = mysqli_query($conn,$existSql);
        $num = mysqli_num_rows($result);
        if ($num < 1) {
            // insert data into table
            if ($password == $cpassword) {
                $hpassword = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO `users`(`username`,`password`) VALUES ('$username','$hpassword')";
                $result = mysqli_query($conn,$sql);
                $showAlert = true;
                header("Location: /forum/index.php?signupsucess=true");
                exit();
            }else{
                $showError = "Password and Confirm password dont match";
            }
        }else{
            $showError = "Username already exist";
        }
    }
    header("Location: /forum/index.php?signupsucess=false&error=$showError");
?>
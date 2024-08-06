<?php
$loginError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "dbConnection.php";
    $username = $_POST["username"];
    $password = $_POST["password"];
    $sql = "SELECT * FROM `users` WHERE `username` = '$username'";
    $result = mysqli_query($conn,$sql);
    $numRow = mysqli_num_rows($result);
    if ($numRow == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            session_start();
            $_SESSION['logedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['sno']= $row['sno'];
            header("Location: /forum/index.php");
            exit();
        }else {
            $loginError = 'password dont match';
        }
    }else {
        $loginError = 'User does not exits';
    }
    header("Location: /forum/index.php?logedin=false&error=$loginError");
}
?>
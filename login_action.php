<?php
session_start();
include 'db.php';

$role = $_POST['role'];
$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users 
        WHERE role='$role' 
        AND username='$username' 
        AND password='$password' 
        AND status=1";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) == 1){
    $user = mysqli_fetch_assoc($result);
    $_SESSION['user'] = $user;
    header("Location: dashboard.php");
} else {
    echo "Invalid Login!";
}
?>

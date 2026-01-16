<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}
$user = $_SESSION['user'];
?>

<h2>Welcome, <?php echo $user['name']; ?></h2>
<p>Role: <?php echo ucfirst($user['role']); ?></p>

<a href="logout.php">Logout</a>

<?php
include 'db.php';
$mode = $_GET['mode'];
$mobile = $_GET['mobile'] ?? '';

if(isset($_POST['save'])){
    mysqli_query($conn,"
        INSERT INTO patients(name,mobile,gender)
        VALUES('$_POST[name]','$_POST[mobile]','$_POST[gender]')
    ");
    $id = mysqli_insert_id($conn);
    header("Location: counter_continue.php?id=$id&mode=$mode");
    exit;
}
?>
<h2>New Patient Registration</h2>

<form method="post">
<input name="name" placeholder="রোগীর নাম" required><br><br>
<input name="mobile" value="<?= $mobile ?>" placeholder="মোবাইল" required><br><br>

<select name="gender" required>
<option value="">Gender</option>
<option>Male</option>
<option>Female</option>
</select><br><br>

<button name="save">Save & Continue</button>
</form>

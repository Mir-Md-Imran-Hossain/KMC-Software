<?php
include 'db.php';

if(isset($_POST['save'])){
    mysqli_query($conn,"
        UPDATE print_settings SET
        center_name='$_POST[center_name]',
        address='$_POST[address]',
        mobile='$_POST[mobile]',
        invoice_footer_note='$_POST[invoice_footer_note]',
        doctor_token_note='$_POST[doctor_token_note]',
        lab_token_note='$_POST[lab_token_note]',
        xray_token_note='$_POST[xray_token_note]',
        usg_token_note='$_POST[usg_token_note]',
        ecg_token_note='$_POST[ecg_token_note]'
        WHERE id=1
    ");
    $msg = "Settings Updated Successfully";
}

$s = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT * FROM print_settings WHERE id=1")
);
?>

<h2>Print & Token Settings</h2>

<?php if(isset($msg)) echo "<b style='color:green'>$msg</b>"; ?>

<form method="post">

<h3>Center Info</h3>
<input name="center_name" value="<?= $s['center_name'] ?>" placeholder="Center Name"><br><br>
<textarea name="address" placeholder="Address"><?= $s['address'] ?></textarea><br><br>
<input name="mobile" value="<?= $s['mobile'] ?>" placeholder="Mobile"><br><br>

<h3>Invoice</h3>
<textarea name="invoice_footer_note"><?= $s['invoice_footer_note'] ?></textarea><br><br>

<h3>Token Notes</h3>
<textarea name="doctor_token_note"><?= $s['doctor_token_note'] ?></textarea><br><br>
<textarea name="lab_token_note"><?= $s['lab_token_note'] ?></textarea><br><br>
<textarea name="xray_token_note"><?= $s['xray_token_note'] ?></textarea><br><br>
<textarea name="usg_token_note"><?= $s['usg_token_note'] ?></textarea><br><br>
<textarea name="ecg_token_note"><?= $s['ecg_token_note'] ?></textarea><br><br>

<button name="save">Save Settings</button>
</form>

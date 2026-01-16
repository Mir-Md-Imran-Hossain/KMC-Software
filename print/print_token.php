<?php
include '../db.php';

$id = $_GET['id'];
$dept = $_GET['dept'];

$inv = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT * FROM lab_invoices WHERE id=$id")
);

$tests = mysqli_query($conn,"
    SELECT t.test_name
    FROM lab_invoice_items li
    JOIN tests t ON li.test_id=t.id
    JOIN departments d ON t.department_id=d.id
    WHERE li.invoice_id=$id AND d.code='$dept'
");

$ps = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT * FROM print_settings WHERE id=1")
);
?>
<!DOCTYPE html>
<html>
<body onload="window.print()">

<center>
<b><?= $dept ?> TOKEN</b>
</center>
<hr>

Patient: <?= $inv['patient_name'] ?><br>

<?php while($t=mysqli_fetch_assoc($tests)){ ?>
- <?= $t['test_name'] ?><br>
<?php } ?>

<hr>
<?php
if($dept=='LAB') echo nl2br($ps['lab_token_note']);
elseif($dept=='XRAY') echo nl2br($ps['xray_token_note']);
elseif($dept=='USG') echo nl2br($ps['usg_token_note']);
elseif($dept=='ECG') echo nl2br($ps['ecg_token_note']);
else echo nl2br($ps['doctor_token_note']);
?>

</body>
</html>

<?php
include '../db.php';
$id = $_GET['id'];

$inv = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT * FROM lab_invoices WHERE id=$id")
);

$items = mysqli_query(
    $conn,"SELECT * FROM lab_invoice_items WHERE invoice_id=$id")
);
?>
<!DOCTYPE html>
<html>
<head>
<style>
body{ font-family:Arial; width:250px; }
.center{text-align:center;}
hr{ border:1px dashed #000; }
</style>
</head>
<body onload="window.print()">

<div class="center">
<b>KAMRUNNAHAR MEDICAL CENTER</b><br>
Ghior, Manikganj<br>
01992233375
</div>
<hr>

Patient: <?= $inv['patient_name'] ?><br>
Mobile: <?= $inv['patient_mobile'] ?><br>
Date: <?= date('d-m-Y H:i') ?><br>

<hr>

<?php while($it=mysqli_fetch_assoc($items)){ ?>
<?= $it['test_name'] ?> - <?= $it['price'] ?><br>
<?php } ?>

<hr>

Total: <?= $inv['total_amount'] ?><br>
Discount: <?= $inv['discount_amount'] ?><br>
Payable: <?= $inv['payable_amount'] ?><br>

<hr>
<center>Thank You</center>

</body>
</html>

<?php
include 'db.php';

$id = $_GET['id'];

$inv = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM lab_invoices WHERE id=$id")
);

$items = mysqli_query(
    $conn, "SELECT * FROM lab_invoice_items WHERE invoice_id=$id");
?>

<!DOCTYPE html>
<html>
<head>
<title>Lab Invoice</title>
<style>
body{ font-family: Arial; }
.invoice{
    width:300px;
    margin:auto;
}
hr{ border:1px dashed #000; }
@media print{
    button{ display:none; }
}
</style>
</head>
<body>

<div class="invoice">
<h3 align="center">Kamrunnahar Medical Center</h3>
<p align="center">Lab Invoice</p>
<hr>

<p>
<b>Patient:</b> <?= $inv['patient_name'] ?><br>
<b>Mobile:</b> <?= $inv['patient_mobile'] ?><br>
<b>Date:</b> <?= $inv['created_at'] ?>
</p>

<hr>

<?php while($it = mysqli_fetch_assoc($items)){ ?>
<?= $it['test_name'] ?> - ৳<?= $it['price'] ?><br>
<?php } ?>

<hr>

<b>Total:</b> ৳<?= $inv['total_amount'] ?><br>
<b>Discount:</b> ৳<?= $inv['discount_amount'] ?><br>
<b>Payable:</b> ৳<?= $inv['payable_amount'] ?><br>

<hr>

<p align="center">Thank You</p>

<button onclick="window.print()">Print</button>
</div>

</body>
</html>

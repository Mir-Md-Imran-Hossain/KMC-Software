<?php
include '../db.php';
$id = $_GET['id'];

$inv = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT * FROM lab_invoices WHERE id=$id")
);

$items = mysqli_query($conn,"
    SELECT test_name, price
    FROM lab_invoice_items
    WHERE invoice_id=$id
");

$ps = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT * FROM print_settings WHERE id=1")
);
?>
<!DOCTYPE html>
<html>
<body onload="window.print()">

<center>
<b><?= $ps['center_name'] ?></b><br>
<?= nl2br($ps['address']) ?><br>
<?= $ps['mobile'] ?>
</center>
<hr>

Patient: <?= $inv['patient_name'] ?><br>
Mobile: <?= $inv['patient_mobile'] ?><br>
<hr>

<?php while($i=mysqli_fetch_assoc($items)){ ?>
<?= $i['test_name'] ?> - <?= $i['price'] ?><br>
<?php } ?>

<hr>
Total: <?= $inv['total_amount'] ?><br>
Discount: <?= $inv['discount_amount'] ?><br>
Payable: <?= $inv['payable_amount'] ?><br>

<hr>
<?= nl2br($ps['invoice_footer_note']) ?>

</body>
</html>

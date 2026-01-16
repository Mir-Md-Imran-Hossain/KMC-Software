<?php
include '../db.php';
$id = $_GET['id'];

/* Invoice */
$inv = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT * FROM lab_invoices WHERE id=$id")
);

/* Test + Category */
$tests = mysqli_query($conn,"
SELECT t.test_name, c.department_id, d.name AS dept_name
FROM lab_invoice_items li
JOIN tests t ON li.test_id=t.id
JOIN test_categories tc ON t.category_id=tc.id
JOIN category_department c ON tc.id=c.category_id
JOIN departments d ON c.department_id=d.id
WHERE li.invoice_id=$id
");

/* Group by Department */
$groups = [];
while($r=mysqli_fetch_assoc($tests)){
    $groups[$r['dept_name']][] = $r['test_name'];
}
?>

<!DOCTYPE html>
<html>
<head>
<style>
body{ font-family:Arial; width:250px; }
.token{ margin-bottom:30px; }
hr{ border:1px dashed #000; }
</style>
</head>
<body onload="window.print()">

<?php foreach($groups as $dept=>$tests){ ?>
<div class="token">
<center>
<b>KMC</b><br>
<?= $dept ?> TOKEN
</center>
<hr>

Patient: <?= $inv['patient_name'] ?><br>
Mobile: <?= $inv['patient_mobile'] ?><br>
Date: <?= date('d-m-Y H:i') ?><br>

<hr>
<b>Tests:</b><br>
<?php foreach($tests as $t){ ?>
- <?= $t ?><br>
<?php } ?>

<hr>
</div>
<?php } ?>

</body>
</html>

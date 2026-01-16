<?php
include '../db.php';

$id = $_GET['id'];

$inv = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM lab_invoices WHERE id=$id")
);

$items = mysqli_query(
    $conn, "SELECT * FROM lab_invoice_items WHERE invoice_id=$id"
);
?>
<!DOCTYPE html>
<html>
<head>
<title>KMC Lab Report</title>

<style>
@page{
    size: A4;
    margin: 0;
}

body{
    margin:0;
    padding:0;
}

.page{
    width:210mm;
    height:297mm;
    position:relative;
    font-family: Arial, sans-serif;
}

/* 🔹 SVG PAD BACKGROUND */
.pad-bg{
    position:absolute;
    top:0;
    left:0;
    width:210mm;
    height:297mm;
    background-image: url('../documents/KMC PAD TB..svg');
    background-size: cover;
    background-repeat: no-repeat;
    z-index:1;
}

/* 🔹 CONTENT LAYER */
.content{
    position:absolute;
    top:0;
    left:0;
    width:210mm;
    height:297mm;
    padding:30mm 20mm;
    box-sizing:border-box;
    z-index:2;
}

/* Patient Info */
.patient-info{
    font-size:14px;
    margin-bottom:10mm;
}

/* Table */
table{
    width:100%;
    border-collapse:collapse;
    margin-top:5mm;
}
th, td{
    border:1px solid #000;
    padding:6px;
    font-size:13px;
}

/* Footer */
.footer{
    position:absolute;
    bottom:30mm;
    right:20mm;
    font-size:12px;
}

@media print{
    button{ display:none; }
}
</style>
</head>

<body>

<div class="page">

    <!-- SVG PAD -->
    <div class="pad-bg"></div>

    <!-- CONTENT -->
    <div class="content">

        <div class="patient-info">
            <b>Patient Name:</b> <?= $inv['patient_name'] ?><br>
            <b>Mobile:</b> <?= $inv['patient_mobile'] ?><br>
            <b>Date:</b> <?= date('d-m-Y', strtotime($inv['created_at'])) ?>
        </div>

        <table>
            <tr>
                <th>Test Name</th>
                <th>Price (৳)</th>
            </tr>

            <?php while($it = mysqli_fetch_assoc($items)){ ?>
            <tr>
                <td><?= $it['test_name'] ?></td>
                <td><?= $it['price'] ?></td>
            </tr>
            <?php } ?>
        </table>

        <div class="footer">
            <b>Total:</b> <?= $inv['total_amount'] ?><br>
            <b>Discount:</b> <?= $inv['discount_amount'] ?><br>
            <b>Payable:</b> <?= $inv['payable_amount'] ?>
        </div>

    </div>
</div>

<button onclick="window.print()">Print</button>

</body>
</html>

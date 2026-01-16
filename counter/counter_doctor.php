<?php
include '../db.php';

$pid = $_GET['pid'] ?? '';
$pq = mysqli_query($conn,"SELECT * FROM patients WHERE id='$pid'");
$p = mysqli_fetch_assoc($pq);

$doctors = mysqli_query($conn,"SELECT * FROM doctors WHERE active=1");

if (isset($_POST['save_visit'])) {

    $doc_id   = $_POST['doctor_id'];
    $fee      = $_POST['fee'];
    $discount = $_POST['discount'];
    $payable  = $fee - $discount;

    // Save visit
    mysqli_query($conn,"
        INSERT INTO doctor_visits
        (patient_id,doctor_id,fee,discount,payable,visit_date)
        VALUES
        ('$pid','$doc_id','$fee','$discount','$payable',NOW())
    ");

    $vid = mysqli_insert_id($conn);

    // Print chain
    header("Location: ../print/print_controller.php?type=doctor_visit&id=$vid");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Doctor Visit</title>
<style>
body{font-family:Arial;}
.wrap{width:700px;margin:40px auto;}
input,select{padding:8px;width:100%;margin:6px 0;}
label{font-weight:bold;}
button{padding:12px;font-size:16px;}
</style>
</head>
<body>

<div class="wrap">
<h2>Doctor Visit</h2>

<b>Patient:</b> <?= htmlspecialchars($p['name']) ?> |
<b>Age:</b> <?= htmlspecialchars($p['age'] ?? '') ?> |
<b>Village:</b> <?= htmlspecialchars($p['village']) ?>

<hr>

<form method="post">

<label>Doctor *</label>
<select name="doctor_id" id="doctor" required onchange="loadFee()">
<option value="">Select Doctor</option>
<?php while($d=mysqli_fetch_assoc($doctors)){ ?>
<option value="<?= $d['id'] ?>" data-fee="<?= $d['visit_fee'] ?>">
<?= $d['name_en'] ?>
</option>
<?php } ?>
</select>

<label>Visit Fee</label>
<input name="fee" id="fee" readonly>

<label>Discount</label>
<input name="discount" id="discount" value="0" oninput="calc()">

<label>Payable</label>
<input id="payable" readonly>

<br><br>
<button name="save_visit">Save & Print</button>

</form>
</div>

<script>
function loadFee(){
    let d = document.getElementById('doctor');
    let fee = d.options[d.selectedIndex].dataset.fee || 0;
    document.getElementById('fee').value = fee;
    calc();
}
function calc(){
    let fee = Number(document.getElementById('fee').value || 0);
    let dis = Number(document.getElementById('discount').value || 0);
    document.getElementById('payable').value = fee - dis;
}
</script>

</body>
</html>

<?php require_once '../db.php'; ?>
<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<title>KMC Counter Dashboard</title>

<style>
body{font-family:Arial;background:#f5f6fa;margin:0}
header{background:#1677ff;color:#fff;padding:14px 20px;font-size:20px}
.wrap{display:flex;gap:20px;padding:20px}
.box{background:#fff;border-radius:10px;padding:15px;flex:1}
input{width:100%;padding:8px;margin-bottom:8px}
.suggest-item{padding:6px;border-bottom:1px solid #eee;cursor:pointer}
.suggest-item:hover{background:#f0f0f0}
.selected-test{background:#e8f0ff;padding:6px;margin-bottom:4px;border-radius:4px;display:flex;justify-content:space-between}
</style>
</head>

<body>
<header>KMC Counter Dashboard</header>

<div class="wrap">

<!-- LEFT -->
<div class="box">
    <h3>রোগী সার্চ</h3>
    <input id="patient-search" placeholder="মোবাইল / নাম">
    <div id="patient-suggestions"></div>

    <input id="patient-name" placeholder="রোগীর নাম">
    <input id="patient-mobile" placeholder="মোবাইল">

    <hr>

    <h3>টেস্ট সার্চ</h3>
    <input id="test-search" placeholder="টেস্ট নাম">
    <div id="test-suggestions"></div>

    <h4>সিলেক্টেড টেস্ট</h4>
    <div id="selected-tests"></div>
</div>

<!-- CENTER -->
<div class="box">
    <h3>ইনভয়েস</h3>
    <input id="total" placeholder="Total" readonly>
    <input id="discount-percent" placeholder="Discount %">
    <input id="discount-amount" placeholder="Discount Amount">
    <input id="payable" placeholder="Payable" readonly>
</div>

<!-- RIGHT -->
<div class="box">
    <h3>আজকের কাজ</h3>
    পরবর্তী Batch
</div>

</div>
<?php include 'counter_patient_form.php'; ?>
<hr>
<?php include 'counter_test_panel.php'; ?>
<script src="assets_js/counter_core.js"></script>
<script src="assets/js/test_search.js"></script>
<script src="assets/js/patient_search.js"></script>
<script src="assets/js/invoice_calc.js"></script>
</body>
</html>

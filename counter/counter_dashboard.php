<?php
require_once "../db.php";
?>
<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8">
  <title>Counter Dashboard</title>
  <style>
    body { font-family: Arial; }
    .box { padding:20px; margin:20px; border:1px solid #ccc; cursor:pointer; }
  </style>
</head>
<body>

<h2>কাউন্টার ড্যাশবোর্ড</h2>

<div class="box" onclick="location.href='counter_test_panel.php'">
  🧪 টেস্ট করাতে চাই
</div>

<div class="box" onclick="location.href='counter_patient_form.php'">
  👨‍⚕️ ডাক্তার দেখাতে চাই
</div>

</body>
</html>

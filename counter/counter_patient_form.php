<?php
require_once "../db.php";
?>
<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8">
  <title>Patient Information</title>
</head>
<body>

<h3>রোগীর তথ্য</h3>

<form method="post" action="counter_save.php">

<label>নাম *</label><br>
<input type="text" name="patient_name" required><br><br>

<label>মোবাইল *</label><br>
<input type="text" name="mobile" maxlength="11" required><br><br>

<label>লিঙ্গ</label><br>
<select name="gender">
  <option value="Male">পুরুষ</option>
  <option value="Female">মহিলা</option>
</select><br><br>

<label>ব্লাড গ্রুপ *</label><br>
<select name="blood_group" required>
  <option value="">-- নির্বাচন করুন --</option>
  <option>A+</option><option>A-</option>
  <option>B+</option><option>B-</option>
  <option>O+</option><option>O-</option>
  <option>AB+</option><option>AB-</option>
</select><br><br>

<hr>

<h4>ঠিকানা</h4>

<label>উপজেলা</label><br>
<select id="upazila" name="upazila" required>
  <option value="">উপজেলা নির্বাচন করুন</option>
</select><br><br>

<label>ইউনিয়ন</label><br>
<select id="union" name="union_name" required>
  <option value="">ইউনিয়ন নির্বাচন করুন</option>
</select><br><br>

<label>ওয়ার্ড</label><br>
<select id="ward" name="ward" required>
  <option value="">ওয়ার্ড নির্বাচন করুন</option>
</select><br><br>

<label>গ্রাম</label><br>
<select id="village" name="village" required>
  <option value="">গ্রাম নির্বাচন করুন</option>
</select><br><br>

<button type="submit">সেভ করুন</button>

</form>

<!-- ONLY DATA -->
<script src="../documents/addressDatabase.js"></script>

<!-- ONLY LOGIC -->
<script src="counter_assets.js"></script>

</body>
</html>

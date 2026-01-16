<?php
require_once "../db.php";

// test list
$tests = mysqli_query($conn, "SELECT id, test_name, price FROM tests WHERE status=1 ORDER BY test_name");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Test Selection</title>
</head>
<body>

<h3>টেস্ট নির্বাচন করুন</h3>

<select id="testSelect">
  <option value="">-- টেস্ট বাছাই করুন --</option>
  <?php while($t = mysqli_fetch_assoc($tests)): ?>
    <option value="<?= $t['id'] ?>" data-price="<?= $t['price'] ?>">
      <?= $t['test_name'] ?> (<?= $t['price'] ?>)
    </option>
  <?php endwhile; ?>
</select>

<h4>নির্বাচিত টেস্ট</h4>
<ul id="selectedTests"></ul>

<p>
  মোট টাকা: <span id="totalAmount">0</span> টাকা
</p>

<button onclick="goNext()">পরবর্তী ধাপ</button>

<script src="counter_assets.js"></script>
</body>
</html>

<?php
include 'db.php';
$mode = $_GET['mode'] ?? '';
$p = null;

if(isset($_POST['mobile'])){
    $mobile = $_POST['mobile'];
    $q = mysqli_query($conn,"SELECT * FROM patients WHERE mobile='$mobile' LIMIT 1");
    if(mysqli_num_rows($q)){
        $p = mysqli_fetch_assoc($q);
    }
}
?>
<h2>Patient Search (<?= strtoupper($mode) ?>)</h2>

<form method="post">
<input name="mobile" placeholder="মোবাইল নাম্বার লিখুন" required>
<button>Search</button>
</form>

<?php if($p){ ?>
<hr>
<h3>Patient Found</h3>
Name: <?= $p['name'] ?><br>
Mobile: <?= $p['mobile'] ?><br>
<a href="counter_register.php?id=<?= $p['id'] ?>&mode=<?= $mode ?>">Continue</a>
<?php } ?>

<?php if(isset($_POST['mobile']) && !$p){ ?>
<hr>
<b>Patient Not Found</b><br>
<a href="counter_register.php?mobile=<?= $_POST['mobile'] ?>&mode=<?= $mode ?>">➕ নতুন রোগী এড করুন</a>
<?php } ?>

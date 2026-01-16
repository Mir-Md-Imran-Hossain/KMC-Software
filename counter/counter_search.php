<?php
include '../db.php';
include 'counter_helper.php';

$mode = isset($_GET['mode']) ? $_GET['mode'] : '';
$mobile = '';

if (isset($_POST['mobile'])) {
    $mobile = $_POST['mobile'];
}

$patients = null;
if ($mobile != '') {
    $patients = getPatientsByMobile($conn, $mobile);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Patient Search</title>
    <style>
        body { font-family: Arial; }
        .wrap { width: 600px; margin: 60px auto; }
        input, button { padding: 10px; font-size: 16px; }
        .card {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 8px 0;
        }
        a { display: inline-block; margin-top: 8px; }
    </style>
</head>
<body>

<div class="wrap">
    <h2>Mobile Search (<?php echo strtoupper($mode); ?>)</h2>

    <form method="post">
        <input type="text" name="mobile" placeholder="মোবাইল নাম্বার লিখুন"
               value="<?php echo htmlspecialchars($mobile); ?>" required>
        <button type="submit">Search</button>
    </form>

<?php
if ($patients && mysqli_num_rows($patients) > 0) {
    echo "<hr><h3>Family Members</h3>";

    while ($p = mysqli_fetch_assoc($patients)) {
        echo "<div class='card'>";
        echo "<b>" . htmlspecialchars($p['name']) . "</b><br>";
        echo "Mobile: " . htmlspecialchars($p['mobile']) . "<br>";
        echo "Village: " . htmlspecialchars($p['village']) . "<br><br>";

        echo "<a href='counter_patient_form.php?id=" . $p['id'] .
             "&mode=" . urlencode($mode) . "'>➡️ এই রোগী সিলেক্ট করুন</a>";
        echo "</div>";
    }

    echo "<hr>";
    echo "<a href='counter_patient_form.php?mobile=" .
         htmlspecialchars($mobile) . "&mode=" . urlencode($mode) .
         "'>➕ নতুন Family Member যোগ করুন</a>";

} else if ($mobile != '') {

    echo "<hr>";
    echo "<b>এই নাম্বারে কোনো রোগী নেই</b><br><br>";

    echo "<a href='counter_patient_form.php?mobile=" .
         htmlspecialchars($mobile) . "&mode=" . urlencode($mode) .
         "'>➕ নতুন রোগী এড করুন</a>";
}
?>

</div>

</body>
</html>

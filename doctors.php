<?php
include 'db.php';
$result = mysqli_query($conn, "SELECT * FROM doctors WHERE status=1");
?>

<h2>Doctor List</h2>

<table border="1" cellpadding="8">
<tr>
    <th>Code</th>
    <th>Name</th>
    <th>Visit Fee</th>
    <th>Days</th>
    <th>Time</th>
</tr>

<?php while($d = mysqli_fetch_assoc($result)){ ?>
<tr>
    <td><?php echo $d['doctor_code']; ?></td>
    <td><?php echo $d['name_en']; ?></td>
    <td><?php echo $d['visit_fee']; ?></td>
    <td><?php echo $d['chamber_days']; ?></td>
    <td><?php echo $d['chamber_time']; ?></td>
</tr>
<?php } ?>
</table>

<?php
include 'db.php';

$sql = "SELECT t.test_code, t.test_name, t.price, c.category_name
        FROM tests t
        JOIN test_categories c ON t.category_id = c.id
        WHERE t.status=1
        ORDER BY c.id";

$result = mysqli_query($conn, $sql);
?>

<h2>Test Price List</h2>

<table border="1" cellpadding="6">
<tr>
    <th>Category</th>
    <th>Code</th>
    <th>Test Name</th>
    <th>Price (৳)</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>
<tr>
    <td><?php echo $row['category_name']; ?></td>
    <td><?php echo $row['test_code']; ?></td>
    <td><?php echo $row['test_name']; ?></td>
    <td><?php echo $row['price']; ?></td>
</tr>
<?php } ?>
</table>

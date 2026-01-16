<?php
include '../db.php';
$id = $_GET['id'];

$items = mysqli_query($conn,"
    SELECT DISTINCT d.code
    FROM lab_invoice_items li
    JOIN tests t ON li.test_id=t.id
    JOIN departments d ON t.department_id=d.id
    WHERE li.invoice_id=$id
");

$depts = [];
while($r=mysqli_fetch_assoc($items)){
    $depts[] = $r['code'];
}
?>

<!DOCTYPE html>
<html>
<body>

<script>
let steps = [];
steps.push("print_invoice.php?id=<?= $id ?>");

<?php foreach($depts as $d){ ?>
steps.push("print_token.php?id=<?= $id ?>&dept=<?= $d ?>");
<?php } ?>

let i = 0;
function runPrint(){
    if(i >= steps.length) return;
    let f = document.createElement("iframe");
    f.style.display="none";
    f.src = steps[i];
    document.body.appendChild(f);
    i++;
    setTimeout(runPrint, 1500); // time for cutter
}
runPrint();
</script>

</body>
</html>

<?php
include 'db.php';

$mobile = $_POST['mobile'];
$name = $_POST['patient_name'];
$total = $_POST['total'];
$payable = $_POST['payable'];
$tests = $_POST['tests'];

$discount_amount = $total - $payable;
$discount_percent = round(($discount_amount / $total) * 100);

mysqli_query($conn, "INSERT INTO lab_invoices 
(patient_mobile, patient_name, total_amount, discount_percent, discount_amount, payable_amount)
VALUES ('$mobile','$name',$total,$discount_percent,$discount_amount,$payable)");

$invoice_id = mysqli_insert_id($conn);

foreach($tests as $t){
    list($id,$name,$price) = explode('|',$t);
    mysqli_query($conn, "INSERT INTO lab_invoice_items 
    (invoice_id, test_id, test_name, price)
    VALUES ($invoice_id,$id,'$name',$price)");
}

echo "
<script>
window.open('print/pos_invoice.php?id=$invoice_id','_blank');
setTimeout(function(){
    window.open('print/pos_tokens.php?id=$invoice_id','_blank');
},1000);
</script>
";
header("Location: print/print_controller.php?id=".$invoice_id);
exit;
?>

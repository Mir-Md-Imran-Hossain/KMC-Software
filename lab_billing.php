<?php
include 'db.php';
$tests = mysqli_query($conn, "SELECT * FROM tests WHERE status=1 ORDER BY test_name");
?>

<h2>Lab Test Billing</h2>

<form method="post" action="lab_save.php">

<label>Patient Mobile</label><br>
<input type="text" name="mobile" required><br><br>

<label>Patient Name</label><br>
<input type="text" name="patient_name" required><br><br>

<label>Select Tests</label><br>
<div style="border:1px solid #ccc; padding:10px; height:250px; overflow-y:scroll;">
<?php while($t = mysqli_fetch_assoc($tests)){ ?>
<label>
<input type="checkbox" class="test-check"
value="<?= $t['id'] ?>|<?= $t['test_name'] ?>|<?= $t['price'] ?>"
name="tests[]">
<?= $t['test_name'] ?> (৳<?= $t['price'] ?>)
</label><br>
<?php } ?>
</div>

<br><br>

<label>Total Amount</label><br>
<input type="number" id="total" name="total" readonly><br><br>

<label>Discount %</label><br>
<input type="number" id="d_percent"><br><br>

<label>Discount Amount</label><br>
<input type="number" id="d_amount"><br><br>

<label>Payable</label><br>
<input type="number" id="payable" name="payable" readonly><br><br>

<label>Cash Received</label><br>
<input type="number" id="cash"><br><br>

<label>Return</label><br>
<input type="number" id="return" readonly><br><br>

<button type="submit">Save Invoice</button>
</form>

<script>
const total = document.getElementById('total');
const dPercent = document.getElementById('d_percent');
const dAmount = document.getElementById('d_amount');
const payable = document.getElementById('payable');
const cash = document.getElementById('cash');
const ret = document.getElementById('return');

function calculateTotal(){
    let sum = 0;
    document.querySelectorAll('.test-check:checked').forEach(chk=>{
        sum += parseInt(chk.value.split('|')[2]);
    });
    total.value = sum;
    payable.value = sum;
    dPercent.value = '';
    dAmount.value = '';
    ret.value = '';
}

document.querySelectorAll('.test-check').forEach(chk=>{
    chk.onchange = calculateTotal;
});

dPercent.oninput = () => {
    let p = (total.value * dPercent.value) / 100;
    dAmount.value = Math.round(p);
    payable.value = total.value - dAmount.value;
};

dAmount.oninput = () => {
    let p = (dAmount.value / total.value) * 100;
    dPercent.value = Math.round(p);
    payable.value = total.value - dAmount.value;
};

cash.oninput = () => {
    ret.value = cash.value - payable.value;
};
</script>


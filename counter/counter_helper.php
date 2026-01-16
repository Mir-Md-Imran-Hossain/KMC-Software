<?php
function getPatientsByMobile($conn,$mobile){
    return mysqli_query($conn,"
        SELECT * FROM patients
        WHERE mobile='$mobile'
        ORDER BY id ASC
    ");
}
?>

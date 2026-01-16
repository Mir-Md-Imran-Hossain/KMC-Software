<?php
$mode = $_GET['mode'] ?? '';
$id   = $_GET['id'] ?? '';

if ($mode == 'doctor') {
    header("Location: counter_doctor.php?pid=$id");
} else {
    header("Location: ../lab_billing.php?pid=$id");
}
exit;

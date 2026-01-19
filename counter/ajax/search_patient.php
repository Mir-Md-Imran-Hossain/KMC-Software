<?php
require_once '../../db.php';

$q = trim($_GET['q'] ?? '');
$data = [];

if ($q !== '') {
    $stmt = $conn->prepare("
        SELECT id, mobile, name, gender, age, blood_group
        FROM patients
        WHERE mobile LIKE CONCAT('%', ?, '%')
        ORDER BY id DESC
        LIMIT 5
    ");
    $stmt->bind_param("s", $q);
    $stmt->execute();
    $res = $stmt->get_result();

    while ($row = $res->fetch_assoc()) {
        $data[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($data);

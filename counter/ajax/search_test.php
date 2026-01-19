<?php
require_once '../../db.php';

$q = trim($_GET['q'] ?? '');
$result = [];

if ($q !== '') {
    $stmt = $conn->prepare("
        SELECT id, test_name, price
        FROM tests
        WHERE test_name LIKE CONCAT('%', ?, '%')
           OR priority_keyword LIKE CONCAT('%', ?, '%')
        GROUP BY test_name
        ORDER BY
            CASE
                WHEN priority_keyword LIKE CONCAT('%', ?, '%') THEN 1
                ELSE 2
            END,
            test_name ASC
        LIMIT 5
    ");
    $stmt->bind_param("sss", $q, $q, $q);
    $stmt->execute();
    $res = $stmt->get_result();

    while ($row = $res->fetch_assoc()) {
        $result[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($result);

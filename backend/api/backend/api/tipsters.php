<?php
include '../config.php';
header('Content-Type: application/json');

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) die(json_encode(['error'=>'DB failed']));

$result = $conn->query("SELECT * FROM tipsters");
$tipsters = [];
while($row = $result->fetch_assoc()) {
    $tipsters[] = $row;
}
echo json_encode($tipsters);
?>

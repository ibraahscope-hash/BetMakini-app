<?php
include '../config.php';
header('Content-Type: application/json');

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) die(json_encode(['error'=>'DB failed']));

$user_id = $_POST['user_id'];
$tipster_id = $_POST['tipster_id'];
$game = $_POST['game'];
$stake = $_POST['stake'];
$odds = $_POST['odds'];

// Save bet
$stmt = $conn->prepare("INSERT INTO bets (user_id,tipster_id,game,stake,odds,status) VALUES (?,?,?,?,?,'pending')");
$stmt->bind_param("iisdd",$user_id,$tipster_id,$game,$stake,$odds);
if($stmt->execute()){
    echo json_encode(['success'=>true]);
} else {
    echo json_encode(['error'=>'Failed to place bet']);
}
?>

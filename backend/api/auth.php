<?php
include '../config.php';
header('Content-Type: application/json');

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die(json_encode(['error'=>'Database connection failed']));
}

// Signup
if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'signup') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name,email,password,balance) VALUES (?,?,?,0)");
    $stmt->bind_param("sss", $name, $email, $password);
    if($stmt->execute()) {
        echo json_encode(['success'=>true]);
    } else {
        echo json_encode(['error'=>'Signup failed']);
    }
}

// Login
if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'login') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $result = $stmt->get_result();
    if($user = $result->fetch_assoc()){
        if(password_verify($password, $user['password'])){
            echo json_encode(['success'=>true,'user'=>$user]);
        } else {
            echo json_encode(['error'=>'Wrong password']);
        }
    } else {
        echo json_encode(['error'=>'User not found']);
    }
}
?>

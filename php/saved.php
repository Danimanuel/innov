<?php
include 'conection.php';

$nome = $_POST['fullname'];
$email = $_POST['email'];
$birth = $_POST['birthday'];
$gender = $_POST['gender'];
$password = $_POST['pass'];

// Criptografar senha
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Prepared Statement
$stmt = $conn->prepare ( "INSERT INTO usuario (nome, email, date_birth_day, genero, palavra_passe) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $nome, $email, $birth, $gender, $passwordHash);

if($stmt->execute()){
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

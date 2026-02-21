<?php
include "conection.php";

$response = ["sucesso" => false, "mensagem" => "", "id_usuario" => 0];

$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$date_birth_day = $_POST['date_birth_day'] ?? '';
$genero = $_POST['genero'] ?? '';
$palavra_passe = password_hash($_POST['palavra_passe'] ?? '', PASSWORD_DEFAULT);

// Verifica se email já existe
$sql_check = "SELECT id_usuario FROM usuario WHERE email = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $email);
$stmt_check->execute();
$result = $stmt_check->get_result();

if($result->num_rows > 0){
    $response['mensagem'] = "Este email já está cadastrado!";
} else {
    $sql = "INSERT INTO usuario (nome, email, date_birth_day, genero, palavra_passe)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nome, $email, $date_birth_day, $genero, $palavra_passe);

    if($stmt->execute()){
        $response['sucesso'] = true;
        $response['id_usuario'] = $stmt->insert_id;
        $response['mensagem'] = "Cadastro realizado com sucesso!";
    } else {
        $response['mensagem'] = "Erro ao cadastrar: " . $stmt->error;
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>
<?php
header('Content-Type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', 0);

include "conection.php";

$response = [
    "sucesso" => false,
    "mensagem" => "",
    "id_usuario" => 0
];

// Verifica se os dados chegaram
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $response["mensagem"] = "Método inválido.";
    echo json_encode($response);
    exit;
}

$nome = $_POST['fullname'] ?? '';
$email = $_POST['email'] ?? '';
$date_birth_day = $_POST['birthday'] ?? '';
$genero = $_POST['gender'] ?? '';
$pass = $_POST['pass'] ?? '';

if (empty($nome) || empty($email) || empty($pass)) {
    $response["mensagem"] = "Preencha todos os campos obrigatórios.";
    echo json_encode($response);
    exit;
}

$palavra_passe = password_hash($pass, PASSWORD_DEFAULT);

// Verifica se email já existe
$sql_check = "SELECT id_usuario FROM usuario WHERE email = ?";
$stmt_check = $conn->prepare($sql_check);

if (!$stmt_check) {
    $response["mensagem"] = "Erro no prepare (check): " . $conn->error;
    echo json_encode($response);
    exit;
}

$stmt_check->bind_param("s", $email);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows > 0) {

    $response['mensagem'] = "Este email já está cadastrado!";

} else {

    $sql = "INSERT INTO usuario (nome, email, date_birth_day, genero, palavra_passe)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        $response["mensagem"] = "Erro no prepare (insert): " . $conn->error;
        echo json_encode($response);
        exit;A
    }

    $stmt->bind_param("sssss", $nome, $email, $date_birth_day, $genero, $palavra_passe);

    if ($stmt->execute()) {
        $response['sucesso'] = true;
        $response['id_usuario'] = $stmt->insert_id;
        $response['mensagem'] = "Cadastro realizado com sucesso!";
        
    } else {
        $response['mensagem'] = "Erro ao cadastrar: " . $stmt->error;
    }
}

echo json_encode($response);
exit;
?>
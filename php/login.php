<?php
/*header('Content-Type: application/json');*/
include "conection.php";

$response = ["sucesso" => false, "mensagem" => "", "id_usuario" => 0];

$email = $_POST['email'] ?? '';
$senha = $_POST['pass'] ?? '';

if(empty($email) || empty($senha)){
    $response['mensagem'] = "Preencha todos os campos!";
    echo json_encode($response);
    exit;
}

// Verifica se o email existe
$sql = "SELECT id_usuario, palavra_passe FROM usuario WHERE email = ?";
$stmt = $conn->prepare($sql);

if(!$stmt){
    $response['mensagem'] = "Erro no prepare: " . $conn->error;
    echo json_encode($response);
    exit;
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 0){
    $response['mensagem'] = "Usuário não cadastrado!";
} else {
    $row = $result->fetch_assoc();
    // Verifica a senha
    if(password_verify($senha, $row['palavra_passe'])){
        $response['sucesso'] = true;
        $response['mensagem'] = "Login realizado com sucesso!";
        $response['id_usuario'] = $row['id_usuario'];
        echo json_encode($response);
        
        // Opcional: iniciar sessão
        session_start();
        $_SESSION['id_usuario'] = $row['id_usuario'];
        $_SESSION['email'] = $email;
      
     
    } else {
        $response['mensagem'] = "Senha incorreta!";
    }
}

if(!$stmt->execute()){
    header("Location: ../user/userSpace.html");
    
} else {
    echo "Error: " . $stmt->error;
}

exit();
?>
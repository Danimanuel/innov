<?php
include 'conection.php';

$id_usuario = $_POST['id_usuario'];
$curso = $_POST['curso'];
$camp = $_POST['camp'];
$want = $_POST['want']; 
$level = $_POST['leve'];
// Prepared Statement

$stmt = $conn->prepare ( "INSERT INTO addinfo (id_usuario, curso, camp, want, leve) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("issss", $id_usuario, $curso, $camp, $want, $level);

if($stmt->execute()){
    header("Location: ../index.html");
    exit();
} else {
    echo "Error: " . $stmt->error;
} 

?>  
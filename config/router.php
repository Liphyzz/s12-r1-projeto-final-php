<?php 
$pdo = require_once('database.php'); // Importa o db

$stmt = $pdo->prepare("SELECT is_membro FROM Usuarios WHERE email = :email"); // prepara para selecionar o campo membro da tabela usuários em que o email do usuário for "X" (será definido depois)

$stmt->execute(['email' => $_GET['usermail']]); // Define o "X" da linha anterior e executa o comando SELECT

$membro = $stmt->fetch(); // Armazena o resultado da busca na variável

if ($membro) { // verifica se o usuário é membro
    return $page_config = "membro";
}
else {
    return $page_config = "user comum";
}
?>
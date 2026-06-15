<?php
require_once "../../config/database.php";

// Só entra aqui se o formulário foi REALMENTE enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email']) && !empty($_POST['senha'])) {
    
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);
    

    $sql = "SELECT * FROM Usuarios WHERE email = :email";
    $stmt = $pdo->prepare($sql); // prepara para selecionar o campo membro da tabela usuários em que o email do usuário for "X" (será definido depois)
    $stmt->execute(['email' => $email]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
        // Login efetuado
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['username'] = $usuario['nome'];
        $_SESSION['usermail'] = $usuario['email'];
        $_SESSION['status'] = "logado";
    } else {
        // Falha no login
        $msg_alerta = "<p class='alert erro'>E-mail ou senha incorretos.</p>";
        $_SESSION['status'] = "deslogado";
    }
}

?>
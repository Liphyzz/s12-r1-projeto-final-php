<?php
require_once "../../config/database.php";

// Só entra aqui se o formulário foi REALMENTE enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email']) && !empty($_POST['senha'])) {
    
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "SELECT id FROM Usuarios WHERE email = :email";
    $stmt = $pdo->prepare($sql); // prepara para selecionar o campo membro da tabela usuários em que o email do usuário for "X" (será definido depois)
    $stmt->execute(['email' => $email]);
    $usuarioExistente = $stmt->fetch();

    if ($usuarioExistente) {
        $msg_alerta = "<p class='alert'>Este e-mail já está cadastrado no sistema</p>";
        $sucesso_cadastro = false;
    } else {
        $sql = "INSERT INTO usuarios (nome, email, senha_hash) VALUES (:nome, :email, :senha_hash)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(
            [
                'nome' => $username,
                'email' => $email,
                'senha_hash' => $senha_hash
            ]
        );
        $msg_alerta = "<p class='alert'>Cadastro realizado com sucesso!</p>";
        $_SESSION['username'] = $username;
        $_SESSION['usermail'] = $email;
        $sucesso_cadastro = true;
    }
}

?>
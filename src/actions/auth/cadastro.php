<?php
require_once "../../config/database.php";

// Só entra aqui se o formulário foi REALMENTE enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email']) && !empty($_POST['senha'])) {
    
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    $userlvl    = trim($_POST['userlvl'] ?? '');

    // Convertemos para 1 (true) ou 0 (false) para o banco de dados não se confundir
    $is_membro  = ($userlvl === 'membro') ? 1 : 0;


    $sql = "SELECT id FROM Usuarios WHERE email = :email";
    $stmt = $pdo->prepare($sql); // prepara para selecionar o campo membro da tabela usuários em que o email do usuário for "X" (será definido depois)
    $stmt->execute(['email' => $email]);
    $usuarioExistente = $stmt->fetch();

    if ($usuarioExistente) {
        $msg_alerta = "<p class='alert'>Este e-mail já está cadastrado no sistema</p>";
        $sucesso_cadastro = false;
    } else {
        $sql = "INSERT INTO usuarios (nome, email, senha_hash, is_membro) VALUES (:nome, :email, :senha_hash, :is_membro)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(
            [
                'nome' => $username,
                'email' => $email,
                'senha_hash' => $senha_hash,
                'is_membro' => $is_membro
            ]
        );
        $msg_alerta = "<p class='alert'>Cadastro realizado com sucesso!</p>";
        $_SESSION['username'] = $username;
        $_SESSION['usermail'] = $email;
        $sucesso_cadastro = true;
    }
}

?>
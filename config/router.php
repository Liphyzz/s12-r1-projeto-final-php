<?php

$pdo = require_once "../../config/database.php" ; // Importa o db

$pagina_atual = $_SERVER['SCRIPT_NAME']; //Verifica em qual página está

# PROCESSAMENTO LOGIN/LOGOUT
if (strpos($pagina_atual, 'cadastro_page.php') !== false) {
    require_once "../../src/actions/auth/cadastro.php";
}
else if (strpos($pagina_atual, 'login_page.php') !== false) {
    require_once "../../src/actions/auth/login.php";
}

# VERIFICAÇÃO NÍVEL DE ACESSO DO USUÁRIO
$email_sessao = $_SESSION['usermail'] ?? null;
if ($email_sessao) {
    // Se existe um e-mail na sessão (porque o cadastro acabou de acontecer ou o user está logado)
    $stmt = $pdo->prepare("SELECT * FROM Usuarios WHERE email = :email");
    $stmt->execute(['email' => $email_sessao]);
    $usuario = $stmt->fetch();

    if ($usuario && $usuario['is_membro'] == true) {
        $_SESSION['userlvl'] = "membro";
    } else {
        $_SESSION['userlvl'] = "user comum";
    }
} else {
    // Se a página acabou de carregar e ninguém enviou formulário ainda
    $_SESSION['userlvl'] = "user comum";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (strpos($pagina_atual, 'cadastro_page.php') !== false && $sucesso_cadastro) {
        header("Location: login_page.php"); 
        exit;
    }
    else if (strpos($pagina_atual, 'login_page.php') !== false &&  $_SESSION['status'] === 'logado') {
        header("Location: perfil_page.php");
        exit;
    }
}
?>
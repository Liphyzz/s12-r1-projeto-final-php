<?php
// Só executa o logout se a requisição vier de um formulário (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_unset();
    session_destroy();

    header("Location: /auth/perfil_page.php");
    exit;
}
?>
<?php 
session_start();

// Se o botão de logout foi clicado (disparou o POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'logout') {
    // Usamos o __DIR__ para sair de 'auth', sair de 'public' e achar a pasta 'src'
    require_once __DIR__ . "/../../src/actions/auth/logout.php";
    exit;
}

// Importa o seu router no topo para garantir que o $_SESSION['userlvl'] seja atualizado
require_once "../../config/router.php";

// Captura o status. Se não estiver definido por algum motivo, assume "visitante"
$username = $_SESSION['username'] ?? 'Visitante';
$userlvl = $_SESSION['userlvl'] ?? 'user comum';
$email = $_SESSION['usermail'] ?? null;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/perfil.css">
</head>
<body>
    <?php require_once "../../includes/header.php"; ?>

    <main>
        <div class="div-principal">
            <h1 class="title">Olá, <?= htmlspecialchars($username) ?>, espero que esteja gostando da minha wiki!</h1>
            
            <div class="perfil-card">
                <?php if (isset($_SESSION['usermail']) && $_SESSION['usermail'] !== null): ?>
                    <h2>Informações da Conta</h2>
                    <hr>
                    <div class='perfil-info'>
                        <p><strong>Nome de Usuário:</strong> <?= htmlspecialchars($username) ?></p>
                        <p><strong>E-mail:</strong> <?= htmlspecialchars($email) ?></p>
                        <p><strong>Status da Conta:</strong> <span class='badge-status'><?= htmlspecialchars($userlvl) ?></span></p>
                    </div>
                    <div class="perfil-acoes">
                    <form method="POST" style="margin: 0;">
                        <input type="hidden" name="acao" value="logout">
                        <button type="submit" class="btn-logout" style="cursor: pointer; border: none;">
                            Sair da Conta
                        </button>
                    </form>
                </div>
                <?php else: ?>
                    <h2>Você não está logado</h2>
                    <div class="perfil-acoes">
                        <a href="login_page.php" class="btn-login">Fazer Login</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php require_once "../../includes/footer.php"; ?>
</body>
</html>
<?php session_start() ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar</title>
    <link rel="stylesheet" href="/assets/css/cadastro.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <?php require_once "../../config/router.php"; ?>
    
    <?php require_once "../../includes/header.php"; ?>
    <main>
        <div class="div-principal">
            <h1 class="title">Cadastro</h1>
            <form method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="username">
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="meuemail@gmail.com" required>
                <?php if (isset($msg_alerta) && !empty($msg_alerta)): ?>
                    <div class="alerta-erro">
                        <?= $msg_alerta ?>
                    </div>
                <?php endif; ?>
                
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" placeholder="senha" required>

                
                <button type="submit" id="btn-enviar">Enviar</button>
                
                <p class="login-link" style="margin-top: 15px; text-align: center;">
                    Já tem uma conta? <a href="login_page.php" style="color: #007bff; text-decoration: none; font-weight: bold;">Fazer login</a>
                </p>
            </form>
        </div>
    </main>
    <?php require_once "../../includes/footer.php"; ?>
</body>
</html>
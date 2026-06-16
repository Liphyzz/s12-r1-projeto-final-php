<?php
session_start();

$username = $_SESSION['username'] ?? 'Visitante';
$email = $_SESSION['usermail'] ?? 'Não informado';
$userlvl = $_SESSION['userlvl'] ?? 'user comum';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Battle Cats Supreme Wiki</title>
    <link rel="stylesheet" href="/assets/css/index.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . "/../includes/header.php"; ?>
    
    <main>
        <div class="container-wiki">
            <div class="wiki-row">
                <div class="wiki-text-block">
                    <h1 class="wiki-title">Battle Cats Supreme Wiki</h1>
                    <div class="wiki-text-box">
                        <p>Bem-vindo à <strong>Battle Cats Supreme Wiki</strong>! Aqui você encontrará as melhores informações sobre gatos, inimigos, recursos e estratégias para dominar o jogo.</p>
                        <br>
                        <p>Explore nossas seções para comparar atributos de diferentes unidades e planejar o deck perfeito para enfrentar as fases mais desafiadoras do cosmos!</p>
                    </div>
                </div>
                <div class="wiki-image-block">
                    <img src="assets/img/logo-tbc-supremewiki.png" alt="" width="100%">
                </div>
            </div>

            <div class="wiki-row reverse">
                <div class="wiki-image-block">
                    <img src="assets/img/tbc-img1.webp" alt="" width="100%">
                </div>
                <div class="wiki-text-block right-align">
                    <h2 class="wiki-subtitle">O que é The Battle Cats?</h2>
                    <div class="wiki-text-box">
                        <p><strong>The Battle Cats</strong> é um aclamado jogo de estratégia e <em>tower defense</em> mobile desenvolvido pela PONOS Corporation. O jogo se destaca pelo seu estilo de arte excêntrico, cheio de humor e com personagens de gatos com os designs mais bizarros, fofos e surreais possíveis.</p>
                        <br>
                        <p>A mecânica principal consiste em gerenciar seu dinheiro em tempo real para invocar um exército felino capaz de conter as ondas inimigas. A estratégia exige o uso inteligente de <strong>Meatshields</strong> (gatos baratos que servem de escudo) para proteger suas unidades raras e poderosas enquanto elas avançam para destruir a base adversária.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php require_once __DIR__ . "/../includes/footer.php"; ?>
</body>
</html>
<?php session_start() ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
     // verificar qual gato foi selecionado para inserir o nome do mesmo como o título
     //echo "<title>$gato_selec</title>"
    ?>
    <link rel="stylesheet" href="/assets/css/gato.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <?php require_once "../../includes/header.php"; ?>
    <main>
        <?php
            //página dinâmica, contruída de acordo com o item selecionado
        ?>
    </main>
    <?php require_once "../../includes/footer.php"; ?>
</body>
</html>
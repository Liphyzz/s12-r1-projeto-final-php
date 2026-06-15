<?php
    $raiz = "http://" . $_SERVER['HTTP_HOST'];

    echo "
    <header>
        <div class='header-banner'>
            <div class='header-div-side'></div>

            <div class='header-div-center'><img src='{$raiz}/assets/img/logo-tbc-supremewiki.png'></div>
            
            <div class='header-div-side'>
                <a href='{$raiz}/auth/perfil_page.php'>
                    <img src='{$raiz}/assets/img/perfil-de-usuario.png'>
                </a>
            </div>
        </div>

        <nav class='nav-bar'>
            <a class='nav-btn' href='{$raiz}/index.php'>Início</a>
            <a class='nav-btn' href='{$raiz}/gatos/gatos_page.php'>Gatos</a>
            <a class='nav-btn' href='{$raiz}/inimigos/inimigos_page.php'>Inimigos</a>
            <a class='nav-btn' href='{$raiz}/recursos/recursos_page.php'>Recursos</a>
            <a class='nav-btn' href='{$raiz}/fases/fases_page.php'>Fases</a>
            <a class='nav-btn' href='{$raiz}/comparar_page.php'>Comparar</a>
        </nav>
    </header>
    ";
?>

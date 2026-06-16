<?php
session_start();

$userlvl = $_SESSION['userlvl'] ?? 'user comum';

$pdo = require_once "../../config/database.php";

// --- LÓGICA PARA SALVAR O GATO NO BANCO DE DADOS ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $userlvl == "membro") {
    $nome = $_POST['nome'] ?? '';
    $raridade = $_POST['raridade'] ?? '';
    $vida = !empty($_POST['vida']) ? (int)$_POST['vida'] : 0;
    $atq = !empty($_POST['atq']) ? (int)$_POST['atq'] : 0;
    $vel_atq = !empty($_POST['vel_atq']) ? (float)$_POST['vel_atq'] : 0.0;
    $dps = !empty($_POST['dps']) ? (float)$_POST['dps'] : 0.0;
    $alcance_atq = !empty($_POST['alcance_atq']) ? (int)$_POST['alcance_atq'] : 0;
    $tipo_atq = $_POST['tipo_atq'] ?? '';
    $vel_movimento = !empty($_POST['vel_movimento']) ? (float)$_POST['vel_movimento'] : 0.0;
    $qtde_knockbacks = !empty($_POST['qtde_knockbacks']) ? (int)$_POST['qtde_knockbacks'] : 0;
    $tmp_recarga_unidade = !empty($_POST['tmp_recarga_unidade']) ? (float)$_POST['tmp_recarga_unidade'] : 0.0;
    $lvl_max = !empty($_POST['lvl_max']) ? (int)$_POST['lvl_max'] : 0;
    $lvls_adicionais = !empty($_POST['lvls_adicionais']) ? (int)$_POST['lvls_adicionais'] : 0;
    $custo = !empty($_POST['custo']) ? (int)$_POST['custo'] : 0;
    $imagem = $_POST['imagem'] ?? '';

    $bom_contra_texto = trim($_POST['bom_contra'] ?? '');
    $bom_contra = !empty($bom_contra_texto) ? '{' . implode(',', array_map('trim', explode(',', $bom_contra_texto))) . '}' : '{}';

    $hab_especiais_texto = trim($_POST['hab_especiais'] ?? '');
    if (!empty($hab_especiais_texto)) {
        $linhas = explode("\n", str_replace("\r", "", $hab_especiais_texto));
        $frases_formatadas = [];
        foreach ($linhas as $linha) {
            $linha_limpa = trim($linha);
            if ($linha_limpa !== '') {
                $frases_formatadas[] = '"' . str_replace('"', '\\"', $linha_limpa) . '"';
            }
        }
        $hab_especiais = '{' . implode(',', $frases_formatadas) . '}';
    } else {
        $hab_especiais = '{}';
    }

    $sql = "INSERT INTO Gatos (nome, raridade, vida, atq, vel_atq, dps, alcance_atq, tipo_atq, vel_movimento, qtde_knockbacks, tmp_recarga_unidade, lvl_max, lvls_adicionais, bom_contra, hab_especiais, custo, imagem) 
            VALUES (:nome, :raridade, :vida, :atq, :vel_atq, :dps, :alcance_atq, :tipo_atq, :vel_movimento, :qtde_knockbacks, :tmp_recarga_unidade, :lvl_max, :lvls_adicionais, :bom_contra, :hab_especiais, :custo, :imagem)";

    $stmtInsert = $pdo->prepare($sql);
    $stmtInsert->execute([':nome' => $nome, ':raridade' => $raridade, ':vida' => $vida, ':atq' => $atq, ':vel_atq' => $vel_atq, ':dps' => $dps, ':alcance_atq' => $alcance_atq, ':tipo_atq' => $tipo_atq, ':vel_movimento' => $vel_movimento, ':qtde_knockbacks' => $qtde_knockbacks, ':tmp_recarga_unidade' => $tmp_recarga_unidade, ':lvl_max' => $lvl_max, ':lvls_adicionais' => $lvls_adicionais, ':bom_contra' => $bom_contra, ':hab_especiais' => $hab_especiais, ':custo' => $custo, ':imagem' => $imagem]);

    header("Location: ?");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM Gatos ORDER BY nome ASC");
$stmt->execute();
$gatos = $stmt->fetchAll(PDO::FETCH_ASSOC); 

$mostrarFormulario = isset($_GET['crud']) && $_GET['crud'] == 'create';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gatos</title>
    <link rel="stylesheet" href="/assets/css/gatos.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <?php require_once "../../includes/header.php"; ?>
    <main>
        <div class="container-principal">
            
            <!-- 1. CONTROLE DO BOTÃO (APENAS PARA MEMBRO) -->
            <?php if ($userlvl == "membro"): ?>
                <?php if (!$mostrarFormulario): ?>
                    <a href="?crud=create">Adicionar gato</a>
                <?php else: ?>
                    <a href="?">Cancelar</a>
                <?php endif; ?>
    
                <!-- 2. FORMULÁRIO DE CADASTRO -->
                <?php if ($mostrarFormulario): ?>
                    <form method="POST">
                        <div class="form-grupo"><label>Nome do Gato:</label><input type="text" name="nome" required maxlength="40"></div>
                        <div class="form-grupo"><label>Raridade:</label><input type="text" name="raridade" maxlength="15" placeholder="Ex: Raro"></div>
                        <div class="form-grupo"><label>Vida:</label><input type="number" name="vida"></div>
                        <div class="form-grupo"><label>Ataque (atq):</label><input type="number" name="atq"></div>
                        <div class="form-grupo"><label>Velocidade de Ataque:</label><input type="number" step="0.01" name="vel_atq" placeholder="0.00"></div>
                        <div class="form-grupo"><label>DPS:</label><input type="number" step="0.01" name="dps" placeholder="0.00"></div>
                        <div class="form-grupo"><label>Alcance do Ataque:</label><input type="number" name="alcance_atq"></div>
                        <div class="form-grupo"><label>Tipo de Ataque:</label><input type="text" name="tipo_atq" maxlength="5" placeholder="Ex: Área"></div>
                        <div class="form-grupo"><label>Velocidade de Movimento:</label><input type="number" step="0.1" name="vel_movimento" placeholder="0.0"></div>
                        <div class="form-grupo"><label>Quantidade de Knockbacks:</label><input type="number" name="qtde_knockbacks"></div>
                        <div class="form-grupo"><label>Tempo de Recarga:</label><input type="number" step="0.01" name="tmp_recarga_unidade" placeholder="0.00"></div>
                        <div class="form-grupo"><label>Level Máximo:</label><input type="number" name="lvl_max"></div>
                        <div class="form-grupo"><label>Leveis Adicionais:</label><input type="number" name="lvls_adicionais"></div>
                        <div class="form-grupo"><label>Bom Contra (Separe por vírgula):</label><input type="text" name="bom_contra" placeholder="Ex: Alien"></div>
                        <div class="form-grupo"><label>Habilidades Especiais (Uma por linha):</label><textarea name="hab_especiais" rows="4" placeholder="Ex:&#10;Dano triplo"></textarea></div>
                        <div class="form-grupo"><label>Custo:</label><input type="number" name="custo"></div>
                        <div class="form-grupo"><label>URL da Imagem:</label><input type="text" name="imagem" maxlength="200" placeholder="http://..."></div>
                        <button type="submit">Salvar Gato</button>
                    </form>
                <?php endif; ?>
            <?php endif; ?>

            <!-- 3. GALERIA ÚNICA (Fora de qualquer bloco duplicado) -->
            <?php if ($gatos): ?>
                <?php foreach($gatos as $gato): ?>
                    <div class="galeria-item">
                        <a href="gato_page.php?id=<?= $gato['id'] ?>">
                            <img src="<?= htmlspecialchars($gato['imagem']) ?>" alt="">
                            <h2><?= htmlspecialchars($gato['nome']) ?></h2>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <h2>Ainda não há gatos registrados...</h2>
            <?php endif; ?>

        </div>
    </main>
    <?php require_once "../../includes/footer.php"; ?>
</body>
</html>

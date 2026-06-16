<?php
session_start();

$userlvl = $_SESSION['userlvl'] ?? 'user comum';
$pdo = require_once "../../config/database.php";

// PEGA O ID DO GATO PELA URL (ex: gato.php?id=5)
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Se não passou nenhum ID válido, volta para a lista principal
if ($id <= 0) {
    header("Location: gatos_page.php");
    exit;
}

// DELETE
if (isset($_GET['acao']) && $_GET['acao'] === 'deletar' && $userlvl == "membro") {
    $stmtDel = $pdo->prepare("DELETE FROM Gatos WHERE id = :id");
    $stmtDel->execute([':id' => $id]);
    header("Location: gatos_page.php"); // Volta para a galeria
    exit;
}

// UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao_editar']) && $userlvl == "membro") {
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

    // Tratamento dos Arrays do Postgres
    $bom_contra_texto = trim($_POST['bom_contra'] ?? '');
    $bom_contra = !empty($bom_contra_texto) ? '{' . implode(',', array_map('trim', explode(',', $bom_contra_texto))) . '}' : '{}';

    $hab_especiais_texto = trim($_POST['hab_especiais'] ?? '');
    if (!empty($hab_especiais_texto)) {
        $linhas = explode("\n", str_replace("\r", "", $hab_especiais_texto));
        $frases = [];
        foreach ($linhas as $l) { if (trim($l) !== '') $frases[] = '"' . str_replace('"', '\\"', trim($l)) . '"'; }
        $hab_especiais = '{' . implode(',', $frases) . '}';
    } else {
        $hab_especiais = '{}';
    }

    $sql = "UPDATE Gatos SET nome=:nome, raridade=:raridade, vida=:vida, atq=:atq, vel_atq=:vel_atq, dps=:dps, alcance_atq=:alcance_atq, tipo_atq=:tipo_atq, vel_movimento=:vel_movimento, qtde_knockbacks=:qtde_knockbacks, tmp_recarga_unidade=:tmp_recarga_unidade, lvl_max=:lvl_max, lvls_adicionais=:lvls_adicionais, bom_contra=:bom_contra, hab_especiais=:hab_especiais, custo=:custo, imagem=:imagem WHERE id=:id";
    
    $stmtUpdate = $pdo->prepare($sql);
    $stmtUpdate->execute([':nome'=>$nome,':raridade'=>$raridade,':vida'=>$vida,':atq'=>$atq,':vel_atq'=>$vel_atq,':dps'=>$dps,':alcance_atq'=>$alcance_atq,':tipo_atq'=>$tipo_atq,':vel_movimento'=>$vel_movimento,':qtde_knockbacks'=>$qtde_knockbacks,':tmp_recarga_unidade'=>$tmp_recarga_unidade,':lvl_max'=>$lvl_max,':lvls_adicionais'=>$lvls_adicionais,':bom_contra'=>$bom_contra,':hab_especiais'=>$hab_especiais,':custo'=>$custo,':imagem'=>$imagem,':id'=>$id]);
    
    header("Location: gato.php?id=" . $id);
    exit;
}

// 4. BUSCA AS INFORMAÇÕES DO GATO ESPECÍFICO
$stmt = $pdo->prepare("SELECT * FROM Gatos WHERE id = :id");
$stmt->execute([':id' => $id]);
$gato = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$gato) {
    echo "<h2 style='text-align:center; color:#4a3b2c; margin-top:50px;'>Gato não encontrado!</h2><p style='text-align:center;'><a href='gatos_page.php'>Voltar</a></p>";
    exit;
}

$mostrarFormEdicao = isset($_GET['modo']) && $_GET['modo'] === 'editar' && $userlvl == "membro";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($gato['nome']) ?></title>
    <link rel="stylesheet" href="/assets/css/gato.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <?php require_once "../../includes/header.php"; ?>
    <main>
        <div class="container-principal">
            
            <!-- LINK DE VOLTAR PARA A GALERIA -->
            <a href="gatos_page.php">⬅ Voltar para a Galeria</a>

            <?php if (!$mostrarFormEdicao): ?>
                <!-- TELA DE DETALHES VISÍVEIS -->
                <div class="card-detalhes">
                    
                    <div class="topo-gato">
                        <img src="<?= htmlspecialchars($gato['imagem']) ?>" alt="">
                        <h1><?= htmlspecialchars($gato['nome']) ?></h1>
                    </div>

                    <div class="info-gato">
                        <p><strong>Raridade:</strong> <?= htmlspecialchars($gato['raridade']) ?></p>
                        <p><strong>Vida:</strong> <?= $gato['vida'] ?></p>
                        <p><strong>Ataque (atq):</strong> <?= $gato['atq'] ?></p>
                        <p><strong>Velocidade de Ataque:</strong> <?= $gato['vel_atq'] ?></p>
                        <p><strong>DPS:</strong> <?= $gato['dps'] ?></p>
                        <p><strong>Alcance:</strong> <?= $gato['alcance_atq'] ?></p>
                        <p><strong>Tipo de Ataque:</strong> <?= htmlspecialchars($gato['tipo_atq']) ?></p>
                        <p><strong>Velocidade de Movimento:</strong> <?= $gato['vel_movimento'] ?></p>
                        <p><strong>Knockbacks:</strong> <?= $gato['qtde_knockbacks'] ?></p>
                        <p><strong>Tempo de Recarga:</strong> <?= $gato['tmp_recarga_unidade'] ?></p>
                        <p><strong>Lvl Max:</strong> <?= $gato['lvl_max'] ?></p>
                        <p><strong>Leveis Adicionais:</strong> <?= $gato['lvls_adicionais'] ?></p>
                        <p><strong>Custo:</strong> $<?= $gato['custo'] ?></p>
                        <p><strong>Bom Contra:</strong> <?= htmlspecialchars(trim($gato['bom_contra'], '{}')) ?></p>
                        
                        <p><strong>Habilidades Especiais:</strong></p>
                        <div class="caixa-habilidades"><?= htmlspecialchars(str_replace(['"', '\\'], '', trim($gato['hab_especiais'], '{}'))) ?></div>
                    </div>

                    <!-- BOTÕES DE MEMBRO (EDITAR/DELETAR) -->
                    <?php if ($userlvl == "membro"): ?>
                        <div class="grupo-botoes-membro">
                            <a href="?id=<?= $id ?>&modo=editar" class="btn-membro btn-editar">Editar Gato</a>
                            <a href="?id=<?= $id ?>&acao=deletar" onclick="return confirm('Quer mesmo deletar este gato?')" class="btn-membro btn-deletar">Deletar Gato</a>
                        </div>
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <!-- FORMULÁRIO DE EDIÇÃO (MODO EDITAR) -->
                <form method="POST">
                    <input type="hidden" name="acao_editar" value="1">
                    <h2>Editando Gato</h2>

                    <div class="form-grupo"><label>Nome:</label><input type="text" name="nome" required value="<?= htmlspecialchars($gato['nome']) ?>"></div>
                    <div class="form-grupo"><label>Raridade:</label><input type="text" name="raridade" value="<?= htmlspecialchars($gato['raridade']) ?>"></div>
                    <div class="form-grupo"><label>Vida:</label><input type="number" name="vida" value="<?= $gato['vida'] ?>"></div>
                    <div class="form-grupo"><label>Ataque:</label><input type="number" name="atq" value="<?= $gato['atq'] ?>"></div>
                    <div class="form-grupo"><label>Velocidade de Ataque:</label><input type="number" step="0.01" name="vel_atq" value="<?= $gato['vel_atq'] ?>"></div>
                    <div class="form-grupo"><label>DPS:</label><input type="number" step="0.01" name="dps" value="<?= $gato['dps'] ?>"></div>
                    <div class="form-grupo"><label>Alcance:</label><input type="number" name="alcance_atq" value="<?= $gato['alcance_atq'] ?>"></div>
                    <div class="form-grupo"><label>Tipo de Ataque:</label><input type="text" name="tipo_atq" value="<?= htmlspecialchars($gato['tipo_atq']) ?>"></div>
                    <div class="form-grupo"><label>Velocidade de Movimento:</label><input type="number" step="0.1" name="vel_movimento" value="<?= $gato['vel_movimento'] ?>"></div>
                    <div class="form-grupo"><label>Knockbacks:</label><input type="number" name="qtde_knockbacks" value="<?= $gato['qtde_knockbacks'] ?>"></div>
                    <div class="form-grupo"><label>Tempo Recarga:</label><input type="number" step="0.01" name="tmp_recarga_unidade" value="<?= $gato['tmp_recarga_unidade'] ?>"></div>
                    <div class="form-grupo"><label>Lvl Max:</label><input type="number" name="lvl_max" value="<?= $gato['lvl_max'] ?>"></div>
                    <div class="form-grupo"><label>Lvls Adicionais:</label><input type="number" name="lvls_adicionais" value="<?= $gato['lvls_adicionais'] ?>"></div>
                    <div class="form-grupo"><label>Bom Contra:</label><input type="text" name="bom_contra" value="<?= htmlspecialchars(trim($gato['bom_contra'], '{}')) ?>"></div>
                    <div class="form-grupo"><label>Habilidades Especiais (Uma por linha):</label><textarea name="hab_especiais" rows="4"><?= htmlspecialchars(str_replace(['"', '\\'], '', trim($gato['hab_especiais'], '{}'))) ?></textarea></div>
                    <div class="form-grupo"><label>Custo:</label><input type="number" name="custo" value="<?= $gato['custo'] ?>"></div>
                    <div class="form-grupo"><label>URL Imagem:</label><input type="text" name="imagem" value="<?= htmlspecialchars($gato['imagem']) ?>"></div>

                    <button type="submit">Salvar Alterações</button>
                    <p style="text-align: center; margin-top: 15px;"><a href="?id=<?= $id ?>" style="color: #4a3b2c; font-weight: bold;">Cancelar Edição</a></p>
                </form>
            <?php endif; ?>

        </div>
    </main>
    <?php require_once "../../includes/footer.php"; ?>
</body>
</html>
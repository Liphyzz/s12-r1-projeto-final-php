<?php
// Configurações de acesso ao banco de dados
$host     = 'localhost';
$port     = '5432';
$dbname   = 'tbc_supremewiki_db';
$username = 'postgres';
$password = 'postgres';

try {
    // Criação da string de conexão (DSN) para o PostgreSQL
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";

    // Cria o objeto PDO que gerencia a conexão
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Ativa notificações de erro
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Retorna os dados como array associativo
    ]);

} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

// Exporta a variável de conexão para ser usada em outros arquivos
return $pdo;
?>
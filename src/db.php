<?php
/**
 * db.php
 * Responsável por criar a conexão com o banco de dados (PDO)
 * e garantir que a tabela "tarefas" exista.
 *
 * As credenciais vêm das variáveis de ambiente definidas no
 * docker-compose.yml (seção "environment" do serviço app).
 */

$host = getenv('DB_HOST');
$user = getenv('DB_USER');
$pass = getenv('DB_PASSWORD');
$name = getenv('DB_NAME');

try {
    // DSN de conexão com MySQL/MariaDB via PDO
    $dsn = "mysql:host=$host;dbname=$name;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    // Se o banco ainda não estiver pronto (ex.: subindo pela primeira vez),
    // exibimos uma mensagem amigável em vez de um erro cru.
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

// Cria a tabela automaticamente caso ainda não exista.
// Assim, ao subir os containers pela primeira vez, o schema já é criado
// sem precisar rodar nenhum script SQL manualmente.
$sql = "CREATE TABLE IF NOT EXISTS tarefas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    descricao TEXT,
    data_cadastro DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

$pdo->exec($sql);

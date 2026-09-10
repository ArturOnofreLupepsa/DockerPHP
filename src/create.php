<?php
require 'db.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');

    if ($nome === '') {
        $erro = 'O campo "Nome" é obrigatório.';
    } else {
        $stmt = $pdo->prepare(
            "INSERT INTO tarefas (nome, descricao, data_cadastro) VALUES (:nome, :descricao, NOW())"
        );
        $stmt->execute([
            ':nome' => $nome,
            ':descricao' => $descricao,
        ]);

        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Nova Tarefa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Nova Tarefa</h1>

    <?php if ($erro): ?>
        <p style="color: #dc2626;"><?= htmlspecialchars($erro) ?></p>
    <?php endif; ?>

    <form method="POST" action="create.php">
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" required>

        <label for="descricao">Descrição</label>
        <textarea id="descricao" name="descricao" rows="4"><?= htmlspecialchars($_POST['descricao'] ?? '') ?></textarea>

        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="index.php" class="btn btn-back">Cancelar</a>
        </div>
    </form>
</div>
</body>
</html>

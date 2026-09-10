<?php
require 'db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: index.php');
    exit;
}

// Busca a tarefa a ser editada
$stmt = $pdo->prepare("SELECT * FROM tarefas WHERE id = :id");
$stmt->execute([':id' => $id]);
$tarefa = $stmt->fetch();

if (!$tarefa) {
    header('Location: index.php');
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');

    if ($nome === '') {
        $erro = 'O campo "Nome" é obrigatório.';
    } else {
        $stmt = $pdo->prepare(
            "UPDATE tarefas SET nome = :nome, descricao = :descricao WHERE id = :id"
        );
        $stmt->execute([
            ':nome' => $nome,
            ':descricao' => $descricao,
            ':id' => $id,
        ]);

        header('Location: index.php');
        exit;
    }
    // Mantém os valores digitados na tela em caso de erro de validação
    $tarefa['nome'] = $nome;
    $tarefa['descricao'] = $descricao;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Tarefa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Editar Tarefa #<?= htmlspecialchars($tarefa['id']) ?></h1>

    <?php if ($erro): ?>
        <p style="color: #dc2626;"><?= htmlspecialchars($erro) ?></p>
    <?php endif; ?>

    <form method="POST" action="edit.php?id=<?= htmlspecialchars($id) ?>">
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($tarefa['nome']) ?>" required>

        <label for="descricao">Descrição</label>
        <textarea id="descricao" name="descricao" rows="4"><?= htmlspecialchars($tarefa['descricao']) ?></textarea>

        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="index.php" class="btn btn-back">Cancelar</a>
        </div>
    </form>
</div>
</body>
</html>

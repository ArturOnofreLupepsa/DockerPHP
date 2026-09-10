<?php
require 'db.php';

// Busca todas as tarefas ordenadas pela mais recente
$stmt = $pdo->query("SELECT * FROM tarefas ORDER BY id DESC");
$tarefas = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>CRUD de Tarefas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="top-actions">
        <h1>Lista de Tarefas</h1>
        <a href="create.php" class="btn btn-primary">+ Nova Tarefa</a>
    </div>

    <?php if (empty($tarefas)): ?>
        <p>Nenhuma tarefa cadastrada ainda.</p>
    <?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Data de Cadastro</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($tarefas as $t): ?>
            <tr>
                <td><?= htmlspecialchars($t['id']) ?></td>
                <td><?= htmlspecialchars($t['nome']) ?></td>
                <td><?= htmlspecialchars($t['descricao']) ?></td>
                <td><?= htmlspecialchars($t['data_cadastro']) ?></td>
                <td>
                    <a href="edit.php?id=<?= $t['id'] ?>" class="btn btn-edit">Editar</a>
                    <a href="delete.php?id=<?= $t['id'] ?>"
                       class="btn btn-delete"
                       onclick="return confirm('Tem certeza que deseja excluir esta tarefa?');">
                       Excluir
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
</body>
</html>

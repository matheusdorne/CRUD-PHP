<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>CRUD PHP</title>
    <link rel="stylesheet" href="styles/index.css">
</head>

<body>

    <h1>CRUD PHP</h1>

    <?php
    $pdo = new PDO("sqlite:database/db.sqlite");

    if (isset($_POST['name']) && isset($_POST['email'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];

        $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

    }

    if (isset($_GET['delete'])) {
        $id = (int) $_GET['delete'];
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

    }

    $sql = $pdo->prepare("SELECT * FROM colors");
    $sql->execute();
    $fetchColors = $sql->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <form method="post">
        <input type="text" name="name" placeholder="Nome">
        <input type="email" name="email" placeholder="Email">
        <button type="submit">Salvar</button>
    </form>

    <?php

    $sql = $pdo->prepare("SELECT * FROM users");
    $sql->execute();
    $fetchUsers = $sql->fetchAll(PDO::FETCH_ASSOC);

    ?>

    <table class="user-table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($fetchUsers as $key => $value): ?>
                <tr>
                    <td><?php echo htmlspecialchars($value['name']); ?></td>
                    <td><?php echo htmlspecialchars($value['email']); ?></td>
                    <td>
                        <a href="?delete=<?php echo $value['id']; ?>">Deletar</a>
                        <a href="edit.php?id=<?php echo $value['id']; ?>">Editar</a>
                        <a href="designarCor.php?id=<?php echo $value['id']; ?>">Cor</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


</body>
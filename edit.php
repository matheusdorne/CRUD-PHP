<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>CRUD PHP</title>
    <link rel="stylesheet" href="styles/edit.css">
</head>

<body>

    <h1>Editar Cadastro</h1>

    <?php
    $pdo = new PDO("sqlite:database/db.sqlite");

    $sql = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $sql->bindParam(':id', $_GET['id']);
    $sql->execute();
    $fetchUser = $sql->fetch(PDO::FETCH_ASSOC);

    if (isset($_POST['name']) && isset($_POST['email'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $_GET['id']);
        $stmt->execute();

        header('Location: index.php');
    }

    ?>

    <form method="post">
        <input type="text" name="name" placeholder="Nome" value="<?php echo $fetchUser['name']; ?>">
        <input type="email" name="email" placeholder="Email" value="<?php echo $fetchUser['email']; ?>">
        <button href="index.php" type="submit">Editar</button>
        <button href="index.php" type="submit">Cancelar</button>
    </form>

</body>
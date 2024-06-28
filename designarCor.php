<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>CRUD PHP</title>
    <link rel="stylesheet" href="styles/designarCor.css">
</head>

<body>

    <h1>Cor</h1>

    <?php
    $pdo = new PDO("sqlite:database/db.sqlite");
    $sql = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $sql->bindParam(':id', $_GET['id']);
    $sql->execute();
    $user = $sql->fetch(PDO::FETCH_ASSOC);

    echo '<div class="user-info">' . htmlspecialchars($user['name']) . ' - ' . htmlspecialchars($user['email']) . '</div>';

    $sql = $pdo->prepare("SELECT * FROM colors");
    $sql->execute();
    $fetchColors = $sql->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST['color'])) {
        $color = $_POST['color'];
        $stmt = $pdo->prepare("INSERT INTO user_colors (user_id, color_id) VALUES (:user_id, :color_id)");
        $stmt->bindParam(':user_id', $_GET['id']);
        $stmt->bindParam(':color_id', $color);
        $stmt->execute();

        header('Location: designarCor.php?id=' . $_GET['id']);
    }

    if (isset($_GET['delete'])) {
        $user_id = (int) $_GET['delete'];
        $color_id = (int) $_GET['color'];
        $stmt = $pdo->prepare("DELETE FROM user_colors WHERE user_id = :user_id AND color_id = :color_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':color_id', $color_id);
        $stmt->execute();

        header('Location: designarCor.php?id=' . $_GET['delete']);
    }
    ?>

    <form method="post">
        <select name="color">
            <?php foreach ($fetchColors as $key => $value) { ?>
                <option value="<?php echo htmlspecialchars($value['id']); ?>">
                    <?php echo htmlspecialchars($value['name']); ?></option>
            <?php } ?>
        </select>
        <button type="submit">Designar</button>
        <button type="button" onclick="window.location.href='index.php'">Cancelar</button>
    </form>

    <h3>Lista de Cores</h3>
    <div class="color-list">
        <?php
        $sql = $pdo->prepare("SELECT * FROM user_colors WHERE user_id = :user_id");
        $sql->bindParam(':user_id', $_GET['id']);
        $sql->execute();
        $fetchUserColors = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach ($fetchUserColors as $key => $value) {
            $sql = $pdo->prepare("SELECT * FROM colors WHERE id = :id");
            $sql->bindParam(':id', $value['color_id']);
            $sql->execute();
            $fetchColor = $sql->fetch(PDO::FETCH_ASSOC);
            echo '<div>' . htmlspecialchars($fetchColor['name']) . ' <a href="?delete=' . $value['user_id'] . '&color=' . $value['color_id'] . '">Deletar</a></div>';
        }
        ?>
    </div>

</body>

</html>
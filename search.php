<?php
require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$pdo = new PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$query = isset($_GET['query']) ? trim($_GET['query']) : '';

if (strlen($query) < 3) {
    die("<p class='error'>Введите минимум 3 символа.</p>");
}

$stmt = $pdo->prepare("
    SELECT posts.title, comments.body 
    FROM comments 
    JOIN posts ON comments.post_id = posts.id 
    WHERE comments.body LIKE ?
");
$stmt->execute(["%$query%"]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Результаты поиска</title>
</head>
<body>
    <div class="container">
        <h2>Результаты поиска</h2>
        <?php if (count($results) > 0): ?>
            <?php foreach ($results as $row): ?>
                <div class="result">
                    <p class="title">Запись: <?= htmlspecialchars($row['title']) ?></p>
                    <p class="comment"><strong>Комментарий:</strong> <?= htmlspecialchars($row['body']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Ничего не найдено.</p>
        <?php endif; ?>
        <a href="/" class="back-link">Вернуться к поиску</a>
    </div>
</body>
</html>

<?php
require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$pdo = new PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Отключаем проверки внешних ключей
$pdo->exec("SET FOREIGN_KEY_CHECKS=0");

// Очищаем таблицы
$pdo->exec("TRUNCATE TABLE comments");
$pdo->exec("TRUNCATE TABLE posts");

// Включаем проверки обратно
$pdo->exec("SET FOREIGN_KEY_CHECKS=1");

$jsonPosts = file_get_contents('https://jsonplaceholder.typicode.com/posts');
$posts = json_decode($jsonPosts, true);
$jsonComments = file_get_contents('https://jsonplaceholder.typicode.com/comments');
$comments = json_decode($jsonComments, true);

$postStmt = $pdo->prepare("INSERT INTO posts (id, title, body) VALUES (?, ?, ?)");
foreach ($posts as $post) {
    $postStmt->execute([$post['id'], $post['title'], $post['body']]);
}

$commentStmt = $pdo->prepare("INSERT INTO comments (id, post_id, body) VALUES (?, ?, ?)");
foreach ($comments as $comment) {
    $commentStmt->execute([$comment['id'], $comment['postId'], $comment['body']]);
}

echo "Загружено " . count($posts) . " записей и " . count($comments) . " комментариев\n";
?>

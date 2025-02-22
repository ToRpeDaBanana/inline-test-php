<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Поиск записей</title>
</head>
<body>
    <h2>Поиск записей по комментариям</h2>
    <form action="search.php" method="GET">
        <input type="text" name="query" placeholder="Введите текст..." required minlength="3">
        <button type="submit">Найти</button>
    </form>
</body>
</html>

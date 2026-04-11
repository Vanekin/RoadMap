<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Ошибка <?= $code ?? 500 ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
            background: #f5f5f5;
        }
        .error-container {
            background: white;
            border-radius: 8px;
            padding: 40px;
            max-width: 500px;
            margin: 0 auto;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            font-size: 72px;
            margin: 0;
            color: #e74c3c;
        }
        p {
            color: #666;
            font-size: 18px;
        }
        a {
            color: #3498db;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="error-container">
    <h1>Ошибка <?= $code ?? 500 ?></h1>
    <p><?= htmlspecialchars($message ?? 'Произошла ошибка. Пожалуйста, попробуйте позже.') ?></p>
    <p><a href="/">Вернуться на главную</a></p>
</div>
</body>
</html>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация завершена</title>
    <style>
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background: #d4edda;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #155724;
        }
        p {
            color: #155724;
            font-size: 18px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }
        .btn:hover {
            background: #218838;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>✅ Регистрация завершена!</h1>
    <p>Спасибо, <?= htmlspecialchars($name) ?> <?= htmlspecialchars($surname) ?>!</p>
    <p>На ваш email <?= htmlspecialchars($email) ?> отправлено письмо с подтверждением.</p>
    <a href="/login" class="btn">Войти в аккаунт</a>
</div>
</body>
</html>
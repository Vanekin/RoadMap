<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мой профиль</title>
    <style>
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 { text-align: center; margin-bottom: 30px; color: #2c3e50; }
        .info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .info p {
            margin: 10px 0;
            font-size: 16px;
        }
        .info strong {
            display: inline-block;
            width: 100px;
            color: #555;
        }
        .actions {
            text-align: center;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover { background: #2980b9; }
        .btn-logout {
            background: #e74c3c;
            margin-left: 10px;
        }
        .btn-logout:hover { background: #c0392b; }
    </style>
</head>
<body>
<div class="container">
    <h1>👤 Мой профиль</h1>

    <div class="info">
        <p><strong>Имя:</strong> <?= htmlspecialchars($user['name'] ?? '') ?></p>
        <p><strong>Фамилия:</strong> <?= htmlspecialchars($user['surname'] ?? '') ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email'] ?? '') ?></p>
    </div>

    <div class="actions">
        <a href="/" class="btn">🏠 На главную</a>
        <a href="/logout" class="btn btn-logout">🚪 Выйти</a>
    </div>
</div>
</body>
</html>
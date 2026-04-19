<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <style>
        .container {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 { text-align: center; margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover { background: #2980b9; }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .register-link {
            text-align: center;
            margin-top: 20px;
        }
        .register-link a { color: #3498db; text-decoration: none; }
    </style>
</head>
<body>
<div class="container">
    <h1>Вход</h1>

    <?php if (isset($_SESSION['errors'])): ?>
        <div class="error">
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/login/store">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Пароль</label>
            <input type="password" name="password">
        </div>

        <button type="submit">Войти</button>
    </form>

    <div class="register-link">
        Нет аккаунта? <a href="/register">Зарегистрироваться</a>
    </div>
</div>
</body>
</html>

<?php
unset($_SESSION['errors']);
unset($_SESSION['old']);
?>
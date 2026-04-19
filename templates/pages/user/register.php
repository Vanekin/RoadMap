<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <style>
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #218838;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
        }
        .message {
            padding: 10px;
            background: #f8d7da;
            color: #721c24;
            border-radius: 4px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Регистрация</h1>

    <?php if (isset($_SESSION['errors'])): ?>
        <div class="message">
            <?php foreach ($_SESSION['errors'] as $field => $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/register/store">
        <div class="form-group">
            <label>Имя</label>
            <input type="text" name="name" value="<?= htmlspecialchars($_SESSION['old']['name'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Фамилия</label>
            <input type="text" name="surname" value="<?= htmlspecialchars($_SESSION['old']['surname'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Пароль (минимум 6 символов)</label>
            <input type="password" name="password">
        </div>

        <div class="form-group">
            <label>Подтверждение пароля</label>
            <input type="password" name="password_confirm">
        </div>

        <button type="submit">Зарегистрироваться</button>
    </form>

    <div class="login-link">
        Уже есть аккаунт? <a href="/login">Войти</a>
    </div>
</div>
</body>
</html>

<?php
unset($_SESSION['errors']);
unset($_SESSION['old']);
?>
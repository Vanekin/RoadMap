<style>
    .success-container {
        max-width: 600px;
        margin: 50px auto;
        padding: 30px;
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        border-radius: 8px;
        text-align: center;
    }

    .success-container h1 {
        color: #155724;
        margin-bottom: 20px;
    }

    .success-container p {
        color: #155724;
        font-size: 16px;
        margin-bottom: 10px;
    }

    .incident-details {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        margin: 20px 0;
        text-align: left;
    }

    .incident-details h3 {
        margin-top: 0;
        color: #333;
    }

    .incident-details strong {
        color: #555;
    }

    .buttons {
        margin-top: 25px;
    }

    .buttons a {
        display: inline-block;
        padding: 10px 20px;
        margin: 0 5px;
        background-color: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 5px;
    }

    .buttons a:hover {
        background-color: #0069d9;
    }

    .buttons a.back {
        background-color: #6c757d;
    }

    .buttons a.back:hover {
        background-color: #5a6268;
    }
</style>

<div class="success-container">
    <h1>✅ Происшествие добавлено!</h1>

    <p>Ваше происшествие успешно зарегистрировано.</p>

    <div class="incident-details">
        <h3>Детали происшествия:</h3>
        <p><strong>Название:</strong> <?= htmlspecialchars($old['title'] ?? '') ?></p>
        <p><strong>Описание:</strong> <?= htmlspecialchars($old['description'] ?? '') ?></p>
    </div>

    <div class="buttons">
        <a href="/">На главную</a>
        <a href="/incidents/create" class="back">Добавить ещё</a>
    </div>
</div>
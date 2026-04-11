<style>
    .form-container {
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .form-group {
        margin-bottom: 15px;
    }
    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }
    input, textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
    }
    textarea {
        resize: vertical;
    }
    button {
        background: #3498db;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }
    button:hover {
        background: #2980b9;
    }
    .error {
        color: red;
        margin-bottom: 15px;
        padding: 10px;
        background: #ffeeee;
        border-radius: 4px;
    }
    .error-list {
        color: red;
        font-size: 14px;
        margin-top: 5px;
    }
</style>

<div class="form-container">
    <h1>Добавить происшествие</h1>
    <form method="POST" action="/incidents/store">
        <div class="form-group">
            <label for="title">Название происшествия</label>
            <input type="text"
                   id="title"
                   name="title"
                   value="<?= htmlspecialchars($old['title'] ?? '') ?>"
                   placeholder="Например: Огромная яма на Фучика">
        </div>

        <div class="form-group">
            <label for="description">Описание</label>
            <textarea id="description"
                      name="description"
                      rows="5"
                      placeholder="Опишите подробности..."><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
        </div>

        <button type="submit">Сохранить</button>
        <a href="/" style="margin-left: 10px;">Отмена</a>
    </form>
</div>
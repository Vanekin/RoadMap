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
    .coordinates {
        display: flex;
        gap: 15px;
    }
    .coordinates .form-group {
        flex: 1;
    }
</style>

<div class="form-container">
    <h1>Добавить происшествие</h1>

    <?php if (isset($errors) && !empty($errors)): ?>
        <div class="error">
            <strong>Ошибка:</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="/incidents/store">
        <div class="form-group">
            <label for="title">Название происшествия *</label>
            <input type="text"
                   id="title"
                   name="title"
                   value="<?= htmlspecialchars($old['title'] ?? '') ?>"
                   placeholder="Например: Огромная яма на Фучика"
                   required>
        </div>

        <div class="form-group">
            <label for="description">Описание *</label>
            <textarea id="description"
                      name="description"
                      rows="5"
                      placeholder="Опишите подробности..."
                      required><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label for="address">Адрес *</label>
            <input type="text"
                   id="address"
                   name="address"
                   value="<?= htmlspecialchars($old['address'] ?? '') ?>"
                   placeholder="Например: г. Москва, ул. Тверская, д. 1"
                   required>
        </div>

        <div class="coordinates">
            <div class="form-group">
                <label for="latitude">Широта (latitude) *</label>
                <input type="number"
                       id="latitude"
                       name="latitude"
                       step="any"
                       value="<?= htmlspecialchars($old['latitude'] ?? '55.751244') ?>"
                       placeholder="55.751244"
                       required>
                <small style="color:#666; display:block;">Пример: 55.751244</small>
            </div>

            <div class="form-group">
                <label for="longitude">Долгота (longitude) *</label>
                <input type="number"
                       id="longitude"
                       name="longitude"
                       step="any"
                       value="<?= htmlspecialchars($old['longitude'] ?? '37.618423') ?>"
                       placeholder="37.618423"
                       required>
                <small style="color:#666; display:block;">Пример: 37.618423</small>
            </div>
        </div>

        <button type="submit">Сохранить</button>
        <a href="/" style="margin-left: 10px;">Отмена</a>
    </form>
</div>
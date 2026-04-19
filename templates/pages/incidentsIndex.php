<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Все происшествия') ?> - RoadMap</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .actions {
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #2980b9;
        }

        .btn-danger {
            background: #e74c3c;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        .incidents-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
        }

        .incident-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .incident-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        .incident-title {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .incident-title a {
            color: #2c3e50;
            text-decoration: none;
        }

        .incident-title a:hover {
            color: #3498db;
            text-decoration: underline;
        }

        .incident-address {
            color: #7f8c8d;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .incident-description {
            color: #555;
            line-height: 1.4;
            margin-bottom: 15px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }

        .incident-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: #95a5a6;
            border-top: 1px solid #ecf0f1;
            padding-top: 10px;
            margin-top: 10px;
        }

        .incident-coords {
            font-family: monospace;
            font-size: 11px;
        }

        .empty-state {
            text-align: center;
            padding: 50px;
            background: white;
            border-radius: 8px;
            color: #7f8c8d;
        }

        .empty-state p {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>📋 Все происшествия</h1>

    <div class="actions">
        <a href="/incidents/create" class="btn">➕ Добавить происшествие</a>
        <a href="/" style="margin-left: 10px;">🏠 На главную</a>
    </div>

    <?php if (empty($incidents)): ?>
        <div class="empty-state">
            <p>😕 Пока нет ни одного происшествия</p>
            <p>Будьте первым, кто сообщит об опасности на дороге!</p>
            <a href="/incidents/create" class="btn">➕ Добавить происшествие</a>
        </div>
    <?php else: ?>
        <div class="incidents-grid">
            <?php foreach ($incidents as $incident): ?>
                <div class="incident-card">
                    <div class="incident-title">
                        <a href="/incidents/<?= $incident['id'] ?>">
                            <?= htmlspecialchars($incident['title']) ?>
                        </a>
                    </div>

                    <div class="incident-address">
                        📍 <?= htmlspecialchars($incident['address'] ?? 'Адрес не указан') ?>
                    </div>

                    <div class="incident-description">
                        <?= nl2br(htmlspecialchars($incident['description'])) ?>
                    </div>

                    <div class="incident-meta">
                        <span>🆔 #<?= $incident['id'] ?></span>
                        <span class="incident-coords">
                                🗺️ <?= number_format($incident['latitude'], 6) ?>,
                                <?= number_format($incident['longitude'], 6) ?>
                            </span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
<style>
    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
    }
    .welcome-page {
        background-image: url('/images/RoadMapHomePage.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .welcome-page::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
    }

    .welcome-content {
        position: relative;
        z-index: 1;
        text-align: center;
        color: white;
    }

    .welcome-content h1 {
        font-size: 48px;
        margin-bottom: 20px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }

    .welcome-content p {
        font-size: 20px;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
    }
</style>

<div class="welcome-page">
    <div class="welcome-content">
        <form method="GET" action="/incidents/create">
        <h1>Добро пожаловать!</h1>
        <p>Желаем хорошей дороги!</p>
            <button type="submit">Создать</button>

    </div>
</div>
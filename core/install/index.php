<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Установка</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <header class="forum-header">
        <div class="forum-header__title">
            <a class="forum-header__title--main">xddBB</a>
            <div class="forum-header__title--sub">Установка</div>
        </div>
    </header>
    <main class="forum-main">
        <form action="" class="settings-form">
            <label for="server">Сервер</label>
            <input type="text" name="server" value="localhost" required>
            <label for="user">Логин</label>
            <input type="text" name="user" value="root" required>
            <label for="password">Пароль</label>
            <input type="password" name="password" value="">
            <label for="database">Название БД</label>
            <input type="text" name="database" required>

            <label for="admin-login">Логин администратора</label>
            <input type="text" name="admin-login" required>
            <label for="admin-password">Пароль администратора</label>
            <input type="password" name="admin-password" required>
            <button type="submit">Начать ведение блога</button>
        </form>
    </main>
    <?php include "../includes/modal.php" ?>
</body>
</html>
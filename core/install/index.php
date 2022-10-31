<?php 
if (file_exists("../connection.php"))
    header('Location: ../../');

error_reporting(E_ALL);
ini_set('display_errors', 'On');

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$_PATH = str_replace("core/install/", "", $_SERVER['REQUEST_URI']);
define( '_PATH', $_PATH );

if (!empty($_POST)) {
    $connection = mysqli_connect($_POST['server'], $_POST['user'], $_POST['password']);

    if(!$connection) {
        $_MODAL_MESSAGE = json_encode(array("title" => "Ошибка", "text" => "Unable to connect to database."));
        return;
    }

    $database_search = mysqli_fetch_array(mysqli_query($connection,"SHOW DATABASES LIKE '".$_POST['database']."'"));

    if (empty($database_search)) 
    {
        if (!mysqli_query($connection, "CREATE DATABASE ".$_POST['database'])) { 
            $_MODAL_MESSAGE = json_encode(array("title" => "Ошибка", "text" => "Unable to create database '".$_POST['database']."'."));
            return;
        }
    }

    mysqli_select_db($connection, $_POST['database']);
    $query = file_get_contents("script.sql");

    if (mysqli_multi_query($connection, $query)){
        file_put_contents("../connection.php", "<?php \$connection = mysqli_connect('".$_POST['server']."', '".$_POST['user']."', '".$_POST['password']."', '".$_POST['database']."'); ?>");

        // Skips through all multy query results to make futher query execution possible
        do { } while (mysqli_next_result($connection));

        if (!mysqli_query($connection, 
            "INSERT INTO ".$_POST['database'].".settings VALUES 
            ('forum_title', 'Название форума'),
            ('db_name', '".$_POST['database']."')"
        )) {
            $_MODAL_MESSAGE = json_encode(array("title" => "Ошибка", "text" => "Unable to add settings"));
            return;
        }

        if (!mysqli_query($connection, 
            "INSERT INTO ".$_POST['database'].".users(login, display_name, password, registration_date, role, is_activated) VALUES 
            ('".$_POST['admin-login']."', '".$_POST['admin-login']."', '".hash('sha512', $_POST['admin-password'])."', '".date('Y-m-d H:i:s')."', 'admin', 1)"
        )) {
            $_MODAL_MESSAGE = json_encode(array("title" => "Ошибка", "text" => "Unable to add settings"));
            return;
        }

        file_put_contents(
            '../functions.php', 
            preg_replace('/\$_PATH = \".*\"; \/\/ DO NOT CHANGE MANUALLY/', '$_PATH = "'.$_PATH.'"; // DO NOT CHANGE MANUALLY', file_get_contents('../functions.php'))
        );

        //copy('../images/default.jpg', '../../profile/avatar/default.jpg');

        header('Location: http://'.$_SERVER['HTTP_HOST'].$_PATH);
    }
    else {
        $_MODAL_MESSAGE = json_encode(array("title" => "Ошибка", "text" => "Unable to execute SQL code."));
    }
}

?>

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
        <img class="forum-header__image logo" src="../images/logo.png" alt="">
        <div class="forum-header__title">
            <a class="forum-header__title--main">xddBB</a>
            <div class="forum-header__title--sub">Установка</div>
        </div>
    </header>
    <main class="forum-main">
        <form action="" method="POST" class="settings-form">
            <label for="server">Сервер</label>
            <input type="text" name="server" value="127.0.0.1" required>
            <label for="user">Логин</label>
            <input type="text" name="user" value="root" required>
            <label for="password">Пароль</label>
            <input type="password" name="password" value="">
            <label for="database">Название БД</label>
            <input type="text" name="database" required>

            <label for="admin-login">Логин администратора</label>
            <input type="text" name="admin-login" value="admin" required>
            <label for="admin-password">Пароль администратора</label>
            <input type="password" name="admin-password" required>

            
            <label for="path">Место установки</label>
            <span><?=$_SERVER['SERVER_NAME']?><b><?=$_PATH?></b></span>

            <button type="submit">Начать ведение блога</button>
        </form>
    </main>
    <div id="path-service" data-path="<?= $_PATH ?>"></div>
    <?php include "../includes/modal.php" ?>
</body>
</html>
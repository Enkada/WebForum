<?php 
session_start();

function template() {
    if (func_num_args() > 1) 
        extract(func_get_arg(1));

    ob_start();

    if (file_exists(func_get_arg(0))) {
        require func_get_arg(0);
    } else {
        echo 'Template not found!';
    }

    return ob_get_clean();
}

function login() {
    if ($_SESSION['user'] != '') 
        header('Location: http://'.$_SERVER['HTTP_HOST']);

    if (!empty($_POST)) {
        include $_SERVER['DOCUMENT_ROOT']."/forum/connection.php";    

        $login_result = mysqli_fetch_assoc(mysqli_query($connection, sprintf("SELECT COUNT(*) as value, role, id, is_activated, display_name, photo FROM users WHERE login = '%s' AND password = '%s'", 
            mysqli_real_escape_string($connection, $_POST['login']), 
            mysqli_real_escape_string($connection, hash('sha512', $_POST['password']))
        )));

        if ($login_result["value"] == "1") {
            if ($login_result["is_activated"] == "1") {
                $_SESSION['display_name'] = $login_result['display_name'];
                $_SESSION['id'] = $login_result['id'];
                $_SESSION['user'] = $_POST['login'];
                $_SESSION['photo'] = $login_result['photo'];
                $_SESSION['role'] = $login_result["role"];
                header('Location: http://'.$_SERVER['HTTP_HOST']);
            }
            else {
                return json_encode(array("title" => "Авторизация", "text" => "Ваш аккаунт не активирован!"));
            }
            
        }
        else {
            return json_encode(array("title" => "Ошибка", "text" => "Неверный логин или пароль!"));
        } 
    }
}

function register() {
    if (!empty($_POST)) {
        include "forum/connection.php";
        $is_login_unique = mysqli_fetch_assoc(mysqli_query($connection, sprintf("SELECT COUNT(*) as value FROM users WHERE login = '%s'", mysqli_real_escape_string($connection, $_POST['login']))));
    
        $is_email_unique = mysqli_fetch_assoc(mysqli_query($connection, sprintf("SELECT COUNT(*) as value FROM users WHERE email = '%s'", mysqli_real_escape_string($connection, $_POST['email']))));
    
        $modal_message;
    
        if ($is_login_unique["value"] == "0") {
            if ($is_email_unique["value"] == "0") {
                $query = sprintf("INSERT INTO users(login, display_name, password, email, registration_date) VALUES ('%s', '%s', '%s', '%s', '%s')", 
                    mysqli_real_escape_string($connection, $_POST['login']),
                    mysqli_real_escape_string($connection, $_POST['login']),
                    mysqli_real_escape_string($connection, hash('sha512', $_POST['password'])),
                    mysqli_real_escape_string($connection, $_POST['email']),
                    mysqli_real_escape_string($connection, date('Y-m-d H:i:s'))    
                );
    
                if (mysqli_query($connection, $query)) { 
                    //header('Location: '.$_SERVER['HTTP_REFERER']);
                    
                    return json_encode(array("title" => "Успех", "text" => "Ваша заявка на регистрацию передана на рассмотрение администратору."));
                }
                else {
                    //echo mysqli_error($connection);
                    return json_encode(array("title" => "Ошибка", "text" => "Не удалось создать аккаунт!"));
                }
            }
            else {
                return json_encode(array("title" => "Ошибка", "text" => "Пользователь с таким адресом электронной почты уже существует!"));
            }
        }
        else {
            return json_encode(array("title" => "Ошибка", "text" => "Пользователь с таким именем уже существует!"));
        }    
    }
}

function section() {
    if ($_GET["id"] != null) {
        include $_SERVER['DOCUMENT_ROOT']."/forum/connection.php";

        $section = mysqli_fetch_assoc(mysqli_query($connection, sprintf("SELECT * FROM sections WHERE id = %s", 
            mysqli_real_escape_string($connection, $_GET['id'])
        )));
        //print_r($section);
        return $section;
    }
    else {
        header('Location: http://'.$_SERVER['HTTP_HOST']);
    }
}

function edit() {
    if ($_SESSION['user'] == '') 
    header('Location: http://'.$_SERVER['HTTP_HOST']);

    if (!empty($_FILES)) {
        include $_SERVER['DOCUMENT_ROOT']."/forum/connection.php";

        $photo = $_FILES['photo'];
        if ($photo['error'] == 0) {   
            $file = base_convert (time(), 10, 36).'.jpg';

            if (!move_uploaded_file($photo['tmp_name'], $_SERVER['DOCUMENT_ROOT']."/profile/avatar/$file")) { 
                $modal_message = json_encode(array("title" => "Ошибка", "text" => "Не удалось загрузить изображение!"));
            }
            else {         
                $query = sprintf("UPDATE users SET photo = '%s' WHERE id = %s", 
                    mysqli_real_escape_string($connection, $file),
                    mysqli_real_escape_string($connection, $_SESSION['id'])
                ); 

                if (mysqli_query($connection, $query)) { 
                    unlink($_SERVER['DOCUMENT_ROOT']."/profile/avatar/".$_SESSION['photo']);
                    $_SESSION['photo'] = $file;
                    header('Location: '.$_SERVER['HTTP_REFERER']);
                }
                else {
                    $modal_message = json_encode(array("title" => "Ошибка", "text" => "Не удалось обновить аватар!"));
                }
            }
        } 
    }
}

function profile() {
    if ($_GET['id'] != '') {
        include $_SERVER['DOCUMENT_ROOT']."/forum/connection.php";
        
        $user = mysqli_fetch_assoc(mysqli_query($connection, sprintf("SELECT display_name, id, photo FROM users WHERE id = '%s'", 
            mysqli_real_escape_string($connection, $_GET['id'])
        )));
    
        return $user;
    }
}

function get_users_data() {
    if ($_SESSION['role'] != 'admin') 
    header('Location: http://'.$_SERVER['HTTP_HOST']);

    include "connection.php";
    $not_activated_users = mysqli_query($connection, "SELECT id, login, email, is_activated FROM users");

    while ($row = mysqli_fetch_assoc($not_activated_users)) {
        $data[] = $row;
    }
    return $data;
}

function get_message($id) {
    include "connection.php";

    $query = sprintf("SELECT id, title, user, (SELECT display_name FROM users WHERE id = user) as author, (SELECT photo FROM users WHERE id = user) as photo, text, date FROM messages WHERE id = %s", 
        mysqli_real_escape_string($connection, $id)
    ); 

    $msg = mysqli_fetch_assoc(mysqli_query($connection, $query));

    mysqli_close($connection);
    return $msg;
}

function get_replies($id) {
    include "connection.php";

    $query = sprintf("SELECT id, title, user, (SELECT display_name FROM users WHERE id = user) as author, (SELECT photo FROM users WHERE id = user) as photo, text, date FROM messages WHERE reply_to = %s ORDER BY date DESC", 
        mysqli_real_escape_string($connection, $id)
    ); 

    $messages = mysqli_query($connection, $query);

    while ($msg = mysqli_fetch_assoc($messages)) {  
        $msg["replies"] = get_replies($msg["id"]);
        $data[] = $msg;
    }

    mysqli_close($connection);
    return $data;
}

function is_user() {
    return in_array($_SESSION['role'], array("user", "admin", "mod"));
}

function get_replies_count($id) {
    include "connection.php";

    $i = 0;

    $query = sprintf("SELECT id FROM messages WHERE reply_to = %s", 
        mysqli_real_escape_string($connection, $id)
    ); 

    $messages = mysqli_query($connection, $query);

    while ($msg = mysqli_fetch_assoc($messages)) { 
        $replies = get_replies_count($msg["id"]);
        if ($replies != null) {            
            $i = $i + $replies;
        }
        $i++;
    }

    mysqli_close($connection);
    return $i;
}

function get_topic_hierarchy($id) {
    include "connection.php";

    $query = sprintf("SELECT (SELECT title FROM sections WHERE id = (SELECT topic_of_section FROM messages WHERE id = %s)) as section, (SELECT id FROM sections WHERE id = (SELECT topic_of_section FROM messages WHERE id = %s)) as section_id, (SELECT name FROM categories WHERE id = (SELECT category FROM sections WHERE id = (SELECT topic_of_section FROM messages WHERE id = %s))) as category", 
        mysqli_real_escape_string($connection, $id),
        mysqli_real_escape_string($connection, $id),
        mysqli_real_escape_string($connection, $id),
        mysqli_real_escape_string($connection, $id)
    ); 

    return mysqli_fetch_assoc(mysqli_query($connection, $query));
}
?>
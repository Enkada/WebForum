<?php 
require $_SERVER['DOCUMENT_ROOT']."/forum/functions.php"; 

$data = get_users_data();

$_TITLE = "Панель администратора";
$_CONTENT = template($_SERVER['DOCUMENT_ROOT'].'/forum/templates/admin_panel.html', array(
    "_USERS_DATA" => $data,
));

include $_SERVER['DOCUMENT_ROOT']."/forum/templates/main.html";
?>

<?php 
require $_SERVER['DOCUMENT_ROOT']."/forum/functions.php";

edit();

$_TITLE = "Настройки профиля";
$_CONTENT = template($_SERVER['DOCUMENT_ROOT'].'/forum/templates/profile_edit.html');

include $_SERVER['DOCUMENT_ROOT']."/forum/templates/main.html";
?>
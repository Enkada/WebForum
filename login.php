<?php 
require $_SERVER['DOCUMENT_ROOT']."/forum/functions.php";

$_MODAL_MESSAGE = login();

$_TITLE = "Авторизация";
$_CONTENT = template($_SERVER['DOCUMENT_ROOT'].'/forum/templates/login.html');

include $_SERVER['DOCUMENT_ROOT']."/forum/templates/main.html";
?>
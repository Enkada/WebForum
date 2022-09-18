<?php 
require $_SERVER['DOCUMENT_ROOT']."/forum/functions.php";

$_MODAL_MESSAGE = register();

$_TITLE = "Регистрация";
$_CONTENT = template($_SERVER['DOCUMENT_ROOT'].'/forum/templates/registration.html');

include $_SERVER['DOCUMENT_ROOT']."/forum/templates/main.html";
?>
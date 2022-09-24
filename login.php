<?php 
require "core/functions.php";

$_MODAL_MESSAGE = login();

$_TITLE = "Авторизация";
$_MAIN_CLASS = "forum-main--middle";
$_CONTENT = template('core/includes/login.html');

include "core/template.html";
?>
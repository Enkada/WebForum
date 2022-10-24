<?php 
require "core/functions.php";

$_MODAL_MESSAGE = register();

$_TITLE = "Регистрация";
$_MAIN_CLASS = "forum-main--middle";
$_CONTENT = template('core/includes/registration.html');

include "core/template.html";
?>
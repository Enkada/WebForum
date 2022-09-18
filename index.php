<?php 
require $_SERVER['DOCUMENT_ROOT']."/forum/functions.php";

$_TITLE = "Форум";
$_CONTENT = template($_SERVER['DOCUMENT_ROOT'].'/forum/templates/forum_list.html');

include $_SERVER['DOCUMENT_ROOT']."/forum/templates/main.html";
?>
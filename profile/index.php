<?php 
require $_SERVER['DOCUMENT_ROOT']."/forum/functions.php";

$user = profile();

$_TITLE = "Профиль";
$_CONTENT = template($_SERVER['DOCUMENT_ROOT'].'/forum/templates/profile.html', array(
    "_USER" => $user,
));

include $_SERVER['DOCUMENT_ROOT']."/forum/templates/main.html";
?>
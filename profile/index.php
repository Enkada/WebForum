<?php 
include "../core/functions.php";

$user = profile();

$_TITLE = "Профиль";
$_CONTENT = template('../core/includes/profile.html', array(
    "_USER" => $user,
));

include "../core/template.html";
?>
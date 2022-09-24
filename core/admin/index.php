<?php 
require "../functions.php"; 

$data = get_users_data();

$_TITLE = "Панель администратора";
$_CONTENT = template('../includes/admin_panel.html', array(
    "_USERS_DATA" => $data,
));

include "../template.html";
?>

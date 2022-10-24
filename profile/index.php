<?php 
include "../core/functions.php";

if ($_GET['id'] != '') {
    $user = get_user($_GET['id']);
}
else {
    header('Location: '.$_SERVER['HTTP_REFERER']);
}


$_TITLE = "Профиль";
$_CONTENT = template('../core/includes/profile.html', array(
    "_USER" => $user,
));

include "../core/template.html";
?>
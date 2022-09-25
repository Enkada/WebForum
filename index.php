<?php 
if (!file_exists("core/connection.php"))
    header('Location: core/install');

require "core/functions.php";

$_TITLE = "Форум";
$_CONTENT = template('core/includes/forum_list.html');

include "core/template.html";
?>
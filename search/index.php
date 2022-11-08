<?php 
require "../core/functions.php";



$_TITLE = "Поиск";
$_CONTENT = template('../core/includes/search.html', array(
    "_SEARCH_DATA" => get_messages()
));

include "../core/template.html";
?>
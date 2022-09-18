<?php 
require $_SERVER['DOCUMENT_ROOT']."/forum/functions.php";

$topic = get_message($_GET["id"]);
$hierarchy = get_topic_hierarchy($_GET["id"]);

$_TITLE = $topic["title"];
$_CONTENT = template($_SERVER['DOCUMENT_ROOT'].'/forum/templates/topic.html', array(
    "_TOPIC" => $topic,
    "_IS_USER" => is_user(),
    "_HIERARCHY" => $hierarchy
));

include $_SERVER['DOCUMENT_ROOT']."/forum/templates/main.html";
?>
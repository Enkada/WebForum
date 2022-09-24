<?php 
require "../core/functions.php";

$topic = get_message($_GET["id"]);
$hierarchy = get_topic_hierarchy($_GET["id"]);

$_TITLE = $topic["title"];
$_CONTENT = template('../core/includes/topic.html', array(
    "_TOPIC" => $topic,
    "_IS_USER" => is_user(),
    "_HIERARCHY" => $hierarchy
));

include "../core/template.html";
?>
<?php 
require "../core/functions.php";

$topic = get_message($_GET["id"]);
$user = get_user($topic["user"]);
$hierarchy = get_topic_hierarchy($_GET["id"]);

$_TITLE = $topic["title"];
$_CONTENT = template('../core/includes/topic.html', array(
    "_TOPIC" => $topic,
    "_IS_USER" => is_user(),
    "_USER" => $user,
    "_HIERARCHY" => $hierarchy
));

include "../core/template.html";
?>
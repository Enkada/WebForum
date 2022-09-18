<?php
require $_SERVER['DOCUMENT_ROOT']."/forum/functions.php";

$section = section();

$_TITLE = $section["title"];
$_CONTENT = template($_SERVER['DOCUMENT_ROOT'].'/forum/templates/section.html', array(
    "_SECTION_TITLE" => $section["title"],
    "_SECTION_DESCRIPTION" => $section["description"],
    "_SECTION_ID" => $section["id"],
    "_IS_USER" => is_user()
));

include $_SERVER['DOCUMENT_ROOT']."/forum/templates/main.html";
?>
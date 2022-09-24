<?php
require "../core/functions.php";

$section = section();

$_TITLE = $section["title"];
$_CONTENT = template('../core/includes/section.html', array(
    "_SECTION_TITLE" => $section["title"],
    "_SECTION_DESCRIPTION" => $section["description"],
    "_SECTION_ID" => $section["id"],
    "_IS_USER" => is_user()
));

include "../core/template.html";
?>
<?php 
include "../../connection.php";

$categories = mysqli_query($connection, "SELECT id, name, priority FROM categories ORDER BY priority DESC");

while ($category = mysqli_fetch_assoc($categories)) {   
    $category_id = $category['id'];
    $sections = mysqli_query($connection, "SELECT id, title, description, (SELECT COUNT(*) FROM messages WHERE topic_of_section = sections.id) as topics, null as last_message, category FROM sections WHERE category = ".$category_id);

    $sections_data = null;

    while ($section = mysqli_fetch_assoc($sections)) {
        $sections_data[] = $section;
    }

    $data[] = array("category" => $category, "sections" => $sections_data);
}

$sections_no_category = mysqli_query($connection, "SELECT id, title, description, (SELECT COUNT(*) FROM messages WHERE topic_of_section = sections.id) as topics, null as last_message, category FROM sections WHERE category = 0");

while ($section_no_category = mysqli_fetch_assoc($sections_no_category)) {   
    $sections_no_category_data[] = $section_no_category;    
}

$data[] = array("category" => array("name" => "Разное", "id" => "0"), "sections" => $sections_no_category_data);

//mysqli_free_result($category);
//mysqli_free_result($sections);
mysqli_close($connection);

echo json_encode($data);

?>
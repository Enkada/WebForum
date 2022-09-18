<?php 
require $_SERVER['DOCUMENT_ROOT']."/forum/functions.php";
include "connection.php";

if ($_GET['section'] == null) 
    exit();

$query = sprintf("SELECT id, title, (SELECT display_name FROM users WHERE id = user) as author, date FROM messages WHERE topic_of_section = %s ORDER BY date DESC", 
    mysqli_real_escape_string($connection, $_GET['section'])
); 

$messages = mysqli_query($connection, $query);

while ($msg = mysqli_fetch_assoc($messages)) {  
    $msg["replies"] = get_replies_count($msg["id"]);
    $data[] = $msg;
}

mysqli_free_result($messages);
mysqli_close($connection);

echo json_encode($data);

?>
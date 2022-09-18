<?php 
if (!empty($_POST)) {
    include "connection.php";

    $query = sprintf("UPDATE categories SET name = '%s', priority = %s WHERE id = %s", 
        mysqli_real_escape_string($connection, $_POST['name']),
        mysqli_real_escape_string($connection, $_POST['priority']),
        mysqli_real_escape_string($connection, $_POST['id'])
    ); 

    if (mysqli_query($connection, $query)) { 
        header('Location: http://'.$_SERVER['HTTP_HOST']);
    }
    else {
        //header('Location: '.get_error_url($_SERVER['HTTP_REFERER'], 9));
    }

    mysqli_close($connection);  
}
else {
    header('Location: http://'.$_SERVER['HTTP_HOST']);
}
?>
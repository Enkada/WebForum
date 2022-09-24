<?php 
require "../../functions.php";

if (!is_user()) 
    exit();
    
if (!empty($_POST)) {
    include _CONNECTION_PATH;

    $query = sprintf("UPDATE messages SET title = '%s', text = '%s' WHERE id = %s AND user = %s", 
        mysqli_real_escape_string($connection, $_POST['title']),
        mysqli_real_escape_string($connection, $_POST['text']),
        mysqli_real_escape_string($connection, $_POST['id']),
        mysqli_real_escape_string($connection, $_SESSION['id'])
    ); 

    if (mysqli_query($connection, $query)) { 
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
    else {
        //echo $query;
        //echo mysqli_error($connection);
        //header('Location: '.get_error_url($_SERVER['HTTP_REFERER'], 9));
    }

    mysqli_close($connection);  
}
else {
    header('Location: '.$_SERVER['HTTP_REFERER']);
}
?>
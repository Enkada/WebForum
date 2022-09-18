<?php 
if (!empty($_POST)) {
    include "connection.php";

    $query = sprintf("UPDATE sections SET title = '%s', description = '%s', category = %s WHERE id = %s", 
        mysqli_real_escape_string($connection, $_POST['title']),
        mysqli_real_escape_string($connection, $_POST['description']),
        mysqli_real_escape_string($connection, $_POST['category']),
        mysqli_real_escape_string($connection, $_POST['id'])
    ); 

    if (mysqli_query($connection, $query)) { 
        header('Location: http://'.$_SERVER['HTTP_HOST']);
    }
    else {
        //echo mysqli_error($connection);
        //header('Location: '.get_error_url($_SERVER['HTTP_REFERER'], 9));
    }

    mysqli_close($connection);  
}
else {
    header('Location: http://'.$_SERVER['HTTP_HOST']);
}
?>
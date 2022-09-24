<?php 
if (!empty($_POST)) {
    include "../../connection.php";

    $query = sprintf("DELETE FROM sections WHERE id = %s", 
        mysqli_real_escape_string($connection, $_POST['id'])
    ); 

    if (mysqli_query($connection, $query)) { 
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
    else {
        //echo mysqli_error($connection);
        //header('Location: '.get_error_url($_SERVER['HTTP_REFERER'], 9));
    }

    mysqli_close($connection);  
}
else {
    header('Location: '.$_SERVER['HTTP_REFERER']);
}
?>
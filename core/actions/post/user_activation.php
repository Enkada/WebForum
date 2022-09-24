<?php
session_start();
if ($_SESSION["role"] != "admin")
    exit();

if (!empty($_POST)) {
    include "../../connection.php";
    
    $query = sprintf("UPDATE users SET is_activated = %s WHERE id = %s", 
        mysqli_real_escape_string($connection, $_POST['is_activated']),
        mysqli_real_escape_string($connection, $_POST['id'])
    ); 

    if (mysqli_query($connection, $query)) { 
        echo "SUCCESS";
    }
    else {
        echo mysqli_error($connection);
    }

    mysqli_close($connection);  
}
?>
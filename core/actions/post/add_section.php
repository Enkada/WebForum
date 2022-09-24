<?php 
if (!empty($_POST)) {
    include "../../connection.php";

    $query = sprintf("INSERT INTO sections(category,title,description) VALUES (%s,'%s','%s')", 
        mysqli_real_escape_string($connection, $_POST['category']),
        mysqli_real_escape_string($connection, $_POST['title']),
        mysqli_real_escape_string($connection, $_POST['description'])  
    );    

    if (mysqli_query($connection, $query)) { 
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
    else {
        //header('Location: '.get_error_url($_SERVER['HTTP_REFERER'], 9));
    }

    mysqli_close($connection);  
}
else {
    header('Location: '.$_SERVER['HTTP_REFERER']);
}
?>
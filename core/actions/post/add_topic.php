<?php 
require "../../functions.php";

if (!is_user()) 
    exit();

if (!empty($_POST)) {
    include _CONNECTION_PATH;

    $query = sprintf("INSERT INTO messages(topic_of_section,user,title,text,date) VALUES (%s,%s,'%s','%s','%s')", 
        mysqli_real_escape_string($connection, $_POST['section']),
        mysqli_real_escape_string($connection, $_SESSION['id']),
        mysqli_real_escape_string($connection, $_POST['title']),
        mysqli_real_escape_string($connection, $_POST['text']),
        mysqli_real_escape_string($connection, date('Y-m-d H:i:s'))
    );    

    if (mysqli_query($connection, $query)) { 
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
    else {
        echo mysqli_error($connection);
        //header('Location: '.get_error_url($_SERVER['HTTP_REFERER'], 9));
    }

    mysqli_close($connection);  
}
else {
    header('Location: '.$_SERVER['HTTP_REFERER']);
}
?>
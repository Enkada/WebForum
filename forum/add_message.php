<?php 
require $_SERVER['DOCUMENT_ROOT']."/forum/functions.php";

if (!is_user()) 
    exit();

if (!empty($_POST)) {
    include "connection.php";

    $query = sprintf("INSERT INTO messages(reply_to,user,title,text,date) VALUES (%s,%s,'%s','%s','%s')", 
        mysqli_real_escape_string($connection, $_POST['reply_to']),
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
    header('Location: http://'.$_SERVER['HTTP_HOST']);
}
?>
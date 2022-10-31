<?php 
if (!empty($_POST) || !empty($_FILES)) {
    include "../../connection.php";
    include "../../functions.php";

    $query = sprintf("UPDATE settings SET value = '%s' WHERE name = 'forum_title'", 
        mysqli_real_escape_string($connection, $_POST['forum_title'])
    ); 

    if (!mysqli_query($connection, $query)) { 
        echo mysqli_error($connection);
    }

    $logo = $_FILES['logo'];
    if ($logo['error'] == 0) {
        move_uploaded_file($logo['tmp_name'], $_SERVER['DOCUMENT_ROOT']._PATH."core/images/logo.png");
    }

    mysqli_close($connection);  

    header('Location: '.$_SERVER['HTTP_REFERER']);
}
else {
    header('Location: '.$_SERVER['HTTP_REFERER']);
}
?>
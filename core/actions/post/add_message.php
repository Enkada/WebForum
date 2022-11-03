<?php 
require "../../functions.php";

if (!is_user()) 
    exit();

if (!empty($_POST)) {
    include _CONNECTION_PATH;

    $query = sprintf("INSERT INTO messages(reply_to,user,title,text,date) VALUES (%s,%s,'%s','%s','%s')", 
        mysqli_real_escape_string($connection, $_POST['reply_to']),
        mysqli_real_escape_string($connection, $_SESSION['id']),
        mysqli_real_escape_string($connection, $_POST['title']),
        mysqli_real_escape_string($connection, $_POST['text']),
        mysqli_real_escape_string($connection, date('Y-m-d H:i:s'))
    );    

    if (mysqli_query($connection, $query)) { 
        if (!empty($_FILES)) {
            $size = count($_FILES['attachments']['name']);
    
            for ($i = 0; $i < $size; $i++) { 
                if ($_FILES['attachments']['error'][$i] == 0) {
                    if (!move_uploaded_file($_FILES['attachments']['tmp_name'][$i], $_SERVER['DOCUMENT_ROOT'].$_PATH."uploads/". $_FILES['attachments']['name'][$i])) { 
                        echo "error";
                    }
                }  
            }
        }

        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
    else {
        echo mysqli_error($connection);
    }

    mysqli_close($connection);  
}
else {
    header('Location: '.$_SERVER['HTTP_REFERER']);
}
?>
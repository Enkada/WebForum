<?php 
require "../../functions.php"; 

if ($_GET['id'] == null) 
    exit();

//$data = get_message($_GET["id"]);
$data = get_replies($_GET["id"]);
echo json_encode($data);
?>
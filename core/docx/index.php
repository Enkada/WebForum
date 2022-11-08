<?php 
require_once 'phpdocx/classes/CreateDocx.php';

include "../connection.php";
$query = mysqli_query($connection, "SELECT id, login, role, email, is_activated, registration_date FROM users");
while ($row = mysqli_fetch_assoc($query)) {
    $row["is_activated"] = $row["is_activated"] == "1" ? "Да" : "Нет";
    $data[] = $row;
}

$docx = new CreateDocx(PHPDOCX_BASE_TEMPLATE, 'TEMPLATE.docx');

array_unshift($data , array(
    'id' => array(
        'value' => 'ID', 
        'backgroundColor' => 'dbdbdb'
    ),
    'login' => array(
        'value' => 'Логин', 
        'backgroundColor' => 'dbdbdb'
    ),
    'role' => array(
        'value' => 'Роль', 
        'backgroundColor' => 'dbdbdb'
    ),
    'email' => array(
        'value' => 'Email', 
        'backgroundColor' => 'dbdbdb'
    ),
    'is_activated' => array(
        'value' => 'Активирован', 
        'backgroundColor' => 'dbdbdb'
    ),
    'registration_date' => array(
        'value' => 'Регистрация', 
        'backgroundColor' => 'dbdbdb'
    ),
));
$tableData = $data;

$tableProperties = array(
    'border' => 'single',
    'borderWidth' => 8, //in eights of a point,
    'textProperties' => array(
        'font' => 'Times New Roman',
        'fontSize' => '14'
    )
);

$docx->addTable($tableData, $tableProperties);

$docx->addText('');

$text = array();
$text[] = array(
    'text' => 'Дата составления отчета: ',
    'font' => 'Times New Roman',
    'fontSize' => '14'
);

$text[] = array(
    'text' => date('Y-m-d H:i:s'),
    'bold' => true,
    'font' => 'Times New Roman',
    'fontSize' => '14'
);
$docx->addText($text);

$file = 'UserList'.date('Y-m-d').'.docx';
$docx->createDocx($file);

header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"" . basename($file) . "\""); 
readfile($file); 
header('Location: '.$_SERVER['HTTP_REFERER']);
?>
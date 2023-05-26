<<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['data'] = array(
        'name' => $_POST['name'],
        'age' => $_POST['age'],
        'salary' => $_POST['salary'],
        'other' => $_POST['other']
    );
    header('Location: page2.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Страница 1</title>
</head>
<body>
<form method="post">
    <label>Имя: <input type="text" name="name"></label>

    <label>Возраст: <input type="number" name="age"></label>

    <label>Зарплата: <input type="text" name="salary"></

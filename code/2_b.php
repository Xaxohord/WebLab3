<?php
if (isset($_REQUEST['surname']) and isset($_REQUEST['name']) and isset($_REQUEST['age']))
{
    $surname = strip_tags($_REQUEST['surname']);
    $name = strip_tags($_REQUEST['name']);
    $age = strip_tags($_REQUEST['age']);
    echo 'Hello, ' . $surname . ', ' . $name . '<br>Your age is: ' . $age;
}
?>

<form action="" method="get">
    <input type="text" name="surname" placeholder="Введите фамилию">
    <input type="text" name="name" placeholder="Введите имя">
    <input type="text" name="age" placeholder="Введите возраст">
    <input type="submit">
</form>

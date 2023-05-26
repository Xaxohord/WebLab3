<?php

if (!empty($_REQUEST['text']))
{
    $str = $_REQUEST['text'];
    $strLen = strlen($str);
    $wordsCount = count(explode(' ', $str));
    $spaceCount = $wordsCount - 1;
    echo 'В тексте ' . $wordsCount . ' слов, ' . $strLen . ' символов, ' ;
}
?>
<form action="" method="get">
    <textarea name="text" placeholder=""> Меня зовут Вероника!</textarea>
    <input type="submit">
</form>


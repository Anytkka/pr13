<?php
$dir = '../settings'; //директория для сканирования
$items = scandir($dir); //сканируем директорию

print_r($items); //выводим на печать
?>
<?php
$homepage = file_get_contents('../settings/connect_datebase.php'); //контент
echo htmlspecialchars($homepage); //выводим
?>
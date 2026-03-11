<?php
include("../settings/connect_datebase.php");

$query = $mysqli->query("SELECT `login`, `password`, `img` FROM `users`");

$result = "Логины и пароли пользователей:\n\n";

while($user = $query->fetch_assoc()) {
    $result .= "Логин: " . $user['login'] . "\n";
    $result .= "Пароль: " . $user['password'] . "\n";
    $result .= "Фото: " . $user['img'] . "\n";
    $result .= "-------------------\n";
}

echo htmlspecialchars($result);
?>
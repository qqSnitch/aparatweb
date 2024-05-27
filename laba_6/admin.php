<?php
if (empty($_SERVER['PHP_AUTH_USER']) || empty($_SERVER['PHP_AUTH_PW'])) {
    requireLogin();
}

include('../settings.php');
$db = new PDO("mysql:host=$db_host;dbname=$db_base", $db_user, $db_password);
$stmt = $db->prepare("SELECT login, password FROM admin WHERE login = ?");
$stmt->execute([$_SERVER['PHP_AUTH_USER']]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $validUser = $row['login'];
    $validPassHash = $row['password'];
} else {
    requireLogin();
}

if ($_SERVER['PHP_AUTH_USER'] != $validUser || md5($_SERVER['PHP_AUTH_PW']) != $validPassHash) {
    requireLogin();
}
session_start();

function requireLogin() {
    header('HTTP/1.1 401 Unanthorized');
    header('WWW-Authenticate: Basic realm="Form"');
    print('<h1>401 Требуется авторизация</h1>');
    exit();
}
?>
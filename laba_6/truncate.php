<?php
include('../settings.php');
$db = new PDO("mysql:host=$db_host;dbname=$db_base", $db_user, $db_password);
$stmt = $db->prepare("TRUNCATE FIO; TRUNCATE ProgLang; TRUNCATE users;");
$stmt->execute();
header('Location: index.php');
?>
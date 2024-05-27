<?php
session_start();
session_destroy();
setcookie('people_name_value', '', 100000);
setcookie('people_phone_value', '', 100000);
setcookie('people_mail_value', '', 100000);
setcookie('date1_value', '', 100000);
setcookie('bio_value', '', 100000);
setcookie('check_value', '', 100000);
setcookie('PHPSESSID', '', 100000);
header('Location: ./');
exit();
?>
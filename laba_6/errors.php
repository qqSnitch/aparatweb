<?php
$errors = array();
 $errors['error_id'] = empty($_COOKIE['error_id']) ? '' : $_COOKIE['error_id'];
 $errors['people_name'] = !empty($_COOKIE['people_name_error']);
 $errors['people_phone'] = !empty($_COOKIE['people_phone_error']);
 $errors['people_mail'] = !empty($_COOKIE['people_mail_error']);
 $errors['date1'] = !empty($_COOKIE['date1_error']);
 $errors['bio'] = !empty($_COOKIE['bio_error']);
 $errors['check'] = !empty($_COOKIE['check_error']);

 // Выдаем сообщения об ошибках.
 if ($errors['people_name']) {
   // Удаляем куки, указывая время устаревания в прошлом.
   setcookie('people_name_error', '', 100000);
   // Выводим сообщение.
   $messages[] = '<div class="error">Заполните имя.</div>';
 }
 if ($errors['people_phone']) {
  // Удаляем куки, указывая время устаревания в прошлом.
  setcookie('people_phone_error', '', 100000);
  // Выводим сообщение.
  $messages[] = '<div class="error">Введите телефон.</div>';
}
if ($errors['people_mail']) {
    // Удаляем куки, указывая время устаревания в прошлом.
    setcookie('people_mail_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Вветите email.</div>';
    }
if ($errors['date1']) {
      // Удаляем куки, указывая время устаревания в прошлом.
      setcookie('date1_error', '', 100000);
      // Выводим сообщение.
      $messages[] = '<div class="error">Вветите дату.</div>';
}
if ($errors['bio']) {
  // Удаляем куки, указывая время устаревания в прошлом.
  setcookie('bio_error', '', 100000);
  // Выводим сообщение.
  $messages[] = '<div class="error">Введите биографию.</div>';
}
if ($errors['check']) {
  // Удаляем куки, указывая время устаревания в прошлом.
  setcookie('check_error', '', 100000);
  // Выводим сообщение.
  $messages[] = '<div class="error">Подтвердите отправку.</div>';
}
else {
  $people_name = $_POST['people_name' . $app_id];
    $people_phone = $_POST['people_phone' . $app_id];
    $people_mail = $_POST['people_mail' . $app_id];
    $date1 = strtotime($_POST['date1' . $app_id]);
    $radio_group_1 = $_POST['radio_group_1' . $app_id];
    $bio = $_POST['bio' . $app_id];
    if(isset($_POST["PL"])) {
      $languages = $_POST["PL"];
      $filtred_languages = array_filter($languages, 
      function($value) {
        return($value == 1 || $value == 2 || $value == 3
        || $value == 3 || $value == 4 || $value == 5
        || $value == 6|| $value == 7|| $value == 8
        || $value == 9 || $value == 10 || $value == 11);
        }
      );
    }
 // Проверяем ошибки.
 $errors = FALSE;
 if (empty( $people_name)) {
   // Выдаем куку на день с флажком об ошибке в поле fio.
   setcookie('people_name_error', '1', time() + 24 * 60 * 60);
   $errors = TRUE;
  } else if (!preg_match('/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u',$people_name)) {
    setcookie('people_name_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
 // Сохраняем ранее введенное в форму значение на месяц.
 setcookie('people_name_value', $people_name, time() + 30 * 24 * 60 * 60);

 if (empty( $people_phone)) {
  // Выдаем куку на день с флажком об ошибке в поле fio.
  setcookie('people_phone_error', '1', time() + 24 * 60 * 60);
  $errors = TRUE;
} else if (!preg_match('/^(\+\d+|\d+)$/', $people_phone)) {
  setcookie('people_phone_error', '1', time() + 24 * 60 * 60);
  $errors = TRUE;
}
// Сохраняем ранее введенное в форму значение на месяц.
setcookie('people_phone_value',$people_phone, time() + 30 * 24 * 60 * 60);

if (empty($people_mail)) {
  // Выдаем куку на день с флажком об ошибке в поле fio.
  setcookie('people_mail_error', '1', time() + 24 * 60 * 60);
  $errors = TRUE;
} else if (!filter_var($people_mail, FILTER_VALIDATE_EMAIL)) {
  setcookie('people_mail_error', '1', time() + 24 * 60 * 60);
  $errors = TRUE;
}
// Сохраняем ранее введенное в форму значение на месяц.
setcookie('people_mail_value',$people_mail, time() + 30 * 24 * 60 * 60);

if (empty($date1)) {
  // Выдаем куку на день с флажком об ошибке в поле fio.
  setcookie('date1_error', '1', time() + 24 * 60 * 60);
  $errors = TRUE;
}
// Сохраняем ранее введенное в форму значение на месяц.
setcookie('date1_value', $date1, time() + 30 * 24 * 60 * 60);

if (empty($bio)) {
  // Выдаем куку на день с флажком об ошибке в поле fio.
  setcookie('bio_error', '1', time() + 24 * 60 * 60);
  $errors = TRUE;
} else if (!preg_match('/^[a-zA-Zа-яА-ЯёЁ0-9.,;!? \-]+$/u', $bio)) {
  setcookie('bio_error', '1', time() + 24 * 60 * 60);
  $errors = TRUE;
} else if (strlen($bio) > 128) { 
  setcookie('bio_error', '1', time() + 24 * 60 * 60);
  $errors = TRUE;
}
// Сохраняем ранее введенное в форму значение на месяц.
setcookie('bio_value', $bio, time() + 30 * 24 * 60 * 60);

if (empty($_POST['check'])) {
  // Выдаем куку на день с флажком об ошибке в поле fio.
  setcookie('check_error', '1', time() + 24 * 60 * 60);
  $errors = TRUE;
}
// Сохраняем ранее введенное в форму значение на месяц.
setcookie('check_value', $_POST['check'], time() + 30 * 24 * 60 * 60);


 if ($errors) {
    setcookie('error_id', $app_id, time() + 24 * 60 * 60);
    header('Location: index.php');
    exit();
 }
 else {
  // Удаляем Cookies с признаками ошибок.
  setcookie('people_name_error', '', 100000);
  setcookie('people_phone_error', '', 100000);
  setcookie('people_mail_error', '', 100000);
  setcookie('date1_error', '', 100000);
  setcookie('bio_error', '', 100000);
  setcookie('check_error', '', 100000);
  setcookie('error_id', '', 100000);
}
}
?>
    
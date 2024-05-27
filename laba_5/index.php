<?php

header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $messages = array();
  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000);
    $messages['allok'] = '<div class="good">Спасибо, результаты сохранены</div>';
    if (!empty($_COOKIE['password'])) {
      $messages['login'] = sprintf('<div class="login">Логин: <strong>%s</strong><br>
        Пароль: <strong>%s</strong><br>Ввойдите в аккаунт с этими данными,<br>чтобы изменить введёные значения формы</div>',
        strip_tags($_COOKIE['login']),
        strip_tags($_COOKIE['password']));
    }
    setcookie('login', '', 100000);
    setcookie('password', '', 100000);
  }
 // Складываем признак ошибок в массив.
 $errors = array();
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
   setcookie('people_name_value', '', 100000);
   // Выводим сообщение.
   $messages[] = '<div class="error">Заполните имя.</div>';
 }
 if ($errors['people_phone']) {
  // Удаляем куки, указывая время устаревания в прошлом.
  setcookie('people_phone_error', '', 100000);
  setcookie('people_phone_value', '', 100000);
  // Выводим сообщение.
  $messages[] = '<div class="error">Введите телефон.</div>';
}
if ($errors['people_mail']) {
    // Удаляем куки, указывая время устаревания в прошлом.
    setcookie('people_mail_error', '', 100000);
    setcookie('people_mail_value', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Вветите email.</div>';
    }
if ($errors['date1']) {
      // Удаляем куки, указывая время устаревания в прошлом.
      setcookie('date1_error', '', 100000);
      setcookie('date1_value', '', 100000);
      // Выводим сообщение.
      $messages[] = '<div class="error">Вветите дату.</div>';
}
if ($errors['bio']) {
  // Удаляем куки, указывая время устаревания в прошлом.
  setcookie('bio_error', '', 100000);
  setcookie('bio_value', '', 100000);
  // Выводим сообщение.
  $messages[] = '<div class="error">Введите биографию.</div>';
}
if ($errors['check']) {
  // Удаляем куки, указывая время устаревания в прошлом.
  setcookie('check_error', '', 100000);
  setcookie('check_value', '', 100000);
  // Выводим сообщение.
  $messages[] = '<div class="error">Подтвердите отправку.</div>';
}

 // Складываем предыдущие значения полей в массив, если есть.
 $values = array();
 $values['people_name'] = empty($_COOKIE['people_name_value']) ? '' : strip_tags($_COOKIE['people_name_value']);
 $values['people_phone'] = empty($_COOKIE['people_phone_value']) ? '' : strip_tags($_COOKIE['people_phone_value']);
 $values['people_mail'] = empty($_COOKIE['people_mail_value']) ? '' : strip_tags($_COOKIE['people_mail_value']);
 $values['date1'] = empty($_COOKIE['date1_value']) ? '' : strip_tags($_COOKIE['date1_value']);
 $values['bio'] = empty($_COOKIE['bio_value']) ? '' : strip_tags($_COOKIE['bio_value']);
 $values['check'] = empty($_COOKIE['check_value']) ? '' : strip_tags($_COOKIE['check_value']);
 if (count(array_filter($errors)) === 0 && !empty($_COOKIE[session_name()]) && session_start() && !empty($_SESSION['login'])) {
  $login = $_SESSION['login']; 
  include('../settings.php');
  try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_base", $db_user, $db_password);
          $stmt = $db->prepare("SELECT application_id FROM users WHERE login = ?");
          $stmt->execute([$login]);
          $app_id = $stmt->fetchColumn();
    
          $stmt = $db->prepare("SELECT name, phone, email, dr, pol, biography FROM FIO WHERE id = ?");
          $stmt->execute([$app_id]);
          $dates = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
          $stmt = $db->prepare("SELECT PL_id FROM ProgLang WHERE idProg = ?");
          $stmt->execute([$app_id]);
          $languages = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    
          if (!empty($dates[0]['people_name'])) {
            $values['people_name'] = $dates[0]['people_name'];
          }
          if (!empty($dates[0]['people_phone'])) {
            $values['people_phone'] = $dates[0]['people_phone'];
          }
          if (!empty($dates[0]['people_mail'])) {
            $values['people_mail'] = $dates[0]['people_mail'];
          }
          if (!empty($dates[0]['date1'])) {
            $values['date1'] = $dates[0]['date1'];
          }
          if (!empty($dates[0]['bio'])) {
            $values['bio'] = $dates[0]['bio'];
          }
        } catch (PDOException $e) {
            print('Error : ' . $e->getMessage());
            exit();
        }
        printf('<div id="header"><p>Вход с логином %s; uid: %d</p><a href=exit.php>Выйти</a></div>', $_SESSION['login'], $_SESSION['uid']);
  }
 include('form.php');
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else {
  $errors = FALSE;
  $people_name = $_POST['people_name'];
    $people_phone = $_POST['people_phone'];
    $people_mail = $_POST['people_mail'];
    $date1 = strtotime($_POST['date1']);
    $radio_group_1 = $_POST['radio_group_1'];
    $bio = $_POST['bio'];
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
  }else{

    setcookie('people_name_value', $people_name, time() + 30 * 24 * 60 * 60);
  }
 // Сохраняем ранее введенное в форму значение на месяц.

 if (empty( $people_phone)) {
  // Выдаем куку на день с флажком об ошибке в поле fio.
  setcookie('people_phone_error', '1', time() + 24 * 60 * 60);
  $errors = TRUE;
} else if (!preg_match('/^(\+\d+|\d+)$/', $people_phone)) {
  setcookie('people_phone_error', '1', time() + 24 * 60 * 60);
  $errors = TRUE;
}
// Сохраняем ранее введенное в форму значение на месяц.
else{
  setcookie('people_phone_value',$people_phone, time() + 30 * 24 * 60 * 60);
}
if (empty($people_mail)) {
  // Выдаем куку на день с флажком об ошибке в поле fio.
  setcookie('people_mail_error', '1', time() + 24 * 60 * 60);
  $errors = TRUE;
} else if (!filter_var($people_mail, FILTER_VALIDATE_EMAIL)) {
  setcookie('people_mail_error', '1', time() + 24 * 60 * 60);
  $errors = TRUE;
}
// Сохраняем ранее введенное в форму значение на месяц.
else{
  setcookie('people_mail_value',$people_mail, time() + 30 * 24 * 60 * 60);
}
if (empty($date1)) {
  // Выдаем куку на день с флажком об ошибке в поле fio.
  setcookie('date1_error', '1', time() + 24 * 60 * 60);
  $errors = TRUE;
}
// Сохраняем ранее введенное в форму значение на месяц.
else{
  setcookie('date1_value', $date1, time() + 30 * 24 * 60 * 60);
}
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
else{
  setcookie('bio_value', $bio, time() + 30 * 24 * 60 * 60);
}
if(isset($_POST['check'])=='')  {
  // Выдаем куку на день с флажком об ошибке в поле fio.
  setcookie('check_error', '1', time() + 24 * 60 * 60);
  $errors = TRUE;
}
// Сохраняем ранее введенное в форму значение на месяц.
else{
  setcookie('check_value', $_POST['check'], time() + 30 * 24 * 60 * 60);
}

 if ($errors) {
   // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
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
 }
 // Проверяем меняются ли ранее сохраненные данные или отправляются новые.
 if (!empty($_COOKIE[session_name()]) && session_start() && !empty($_SESSION['login'])) {
  $login = $_SESSION['login'];
  include('../settings.php');
  try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_base", $db_user, $db_password);
    $stmt = $db->prepare("SELECT application_id FROM users WHERE login = ?");
    $stmt->execute([$login]);
    $app_id = $stmt->fetchColumn();
    $date1=date('Y.m.d',strtotime($date1));
    $stmt = $db->prepare("UPDATE FIO SET name = ?, phone = ?, email = ?, dr = ?, pol = ?, biography = ?
      WHERE id = ?");
    $stmt->execute([$people_name, $people_phone, $people_mail, $date1, $radio_group_1, $bio,$app_id]);

    $stmt = $db->prepare("SELECT PL_id FROM ProgLang WHERE idProg = ?");
    $stmt->execute([$app_id]);
    $langs = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

    if (array_diff($langs, $languages) || count($langs) != count($languages)) {
      $stmt = $db->prepare("DELETE FROM ProgLang WHERE idProg = ?");
      $stmt->execute([$app_id]);

      $stmt = $db->prepare("INSERT INTO ProgLang (PL_id) VALUES (?)");
      foreach ($languages as $language_id) {
        $stmt->execute([$language_id]);
      }
    }

  } catch (PDOException $e) {
      print('Error : ' . $e->getMessage());
      exit();
  }
  }
  else {
    $login = 'user' . rand(1, 1000);
    $password = rand(1000, 9999);
    setcookie('login', $login);
    setcookie('password', $password);
    // Переменные с формы
    $name = $_POST['people_name'];
    $phone = $_POST['people_phone'];
    $email = $_POST['people_mail'];
    $date1 = strtotime($_POST['date1']);
    $pol = $_POST['radio_group_1'];
    $bio = $_POST['bio'];
    $languages = $_POST["PL"];

    
    // Параметры для подключения
    include('../settings.php');
    try {
      $db = new PDO("mysql:host=$db_host;dbname=$db_base", $db_user, $db_password);
      $stmt = $db->prepare("INSERT INTO FIO (name, phone, email, dr, pol, biography) VALUES (?, ?, ?, ?, ?, ?)");
      $date1=date('Y.m.d',strtotime($date1));
      $stmt->execute([$name, $phone, $email, $date1, $pol, $bio]);
      $application_id = $db->lastInsertId();
      $stmt = $db->prepare("INSERT INTO users (application_id, login, password) VALUES (?, ?, ?)");
      $stmt->execute([$application_id, $login, md5($password)]);
    } catch (PDOException $e) {
      print('Error : ' . $e->getMessage());
      exit();
    }
}
  
    print('<h1>Успешно отправлено.</h1><br/>');
    // Сохраняем куку с признаком успешного сохранения.
  setcookie('save', '1');

  // Делаем перенаправление.
  header('Location: ./');
}

?>
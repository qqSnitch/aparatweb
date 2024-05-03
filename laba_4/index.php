<?php

header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // Массив для временного хранения сообщений пользователю.
  $messages = array();

  // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
  // Выдаем сообщение об успешном сохранении.
  if (!empty($_COOKIE['save'])) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('save', '', 100000);
    // Если есть параметр save, то выводим сообщение пользователю.
    $messages[] = 'Спасибо, результаты сохранены.';
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
 $values['people_name'] = empty($_COOKIE['people_name_value']) ? '' : $_COOKIE['people_name_value'];
 $values['people_phone'] = empty($_COOKIE['people_phone_value']) ? '' : $_COOKIE['people_phone_value'];
 $values['people_mail'] = empty($_COOKIE['people_mail_value']) ? '' : $_COOKIE['people_mail_value'];
 $values['date1'] = empty($_COOKIE['date1_value']) ? '' : $_COOKIE['date1_value'];
 $values['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
 $values['check'] = empty($_COOKIE['check_value']) ? '' : $_COOKIE['check_value'];
 include('form.php');
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else {
  $people_name = $_POST['people_name'];
    $people_phone = $_POST['people_phone'];
    $people_mail = $_POST['people_mail'];
    $date1 = strtotime($_POST['date1']);
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
  // Переменные с формы
      $people_name = $_POST['people_name'];
      $people_phone = $_POST['people_phone'];
      $people_mail = $_POST['people_mail'];
      $date1 = strtotime($_POST['date1']);
      $radio_group_1 = $_POST['radio_group_1'];
      $bio = $_POST['bio'];
  
      
      // Параметры для подключения
      include('../settings.php');
    try {
        // Подключение к базе данных
        $db = new PDO("mysql:host=$db_host;dbname=$db_base", $db_user, $db_password);
        // Устанавливаем корректную кодировку
        $db->exec("set names utf8");
        // Собираем данные для запроса
        $date1=date('Y.m.d',strtotime($date1));
        $data = array( 'people_name' => $people_name, 'people_phone' => $people_phone, 'people_mail' => $people_mail, 'date1' => $date1, 'radio_group_1' => $radio_group_1, 'bio' => $bio ); 
        // Подготавливаем SQL-запрос
        $query = $db->prepare("INSERT INTO $db_table (name, phone, email, dr, pol, biography) values (:people_name, :people_phone, :people_mail, :date1, :radio_group_1, :bio)");
        // Выполняем запрос с данными
        $query->execute($data);
        // Запишим в переменую, что запрос отрабтал
    } catch (PDOException $e) {
        // Если есть ошибка соединения или выполнения запроса, выводим её
        print "Ошибка!: " . $e->getMessage() . "<br/>";
    }
    $db_table = "ProgLang"; // Имя Таблицы БД
    try {
        // Подключение к базе данных
        $db = new PDO("mysql:host=$db_host;dbname=$db_base", $db_user, $db_password);
        // Устанавливаем корректную кодировку
        $db->exec("set names utf8");
        // Собираем данные для запроса
        foreach ($_POST['PL'] as $PL){
            $data = array( 'PL' => $PL); 
            // Подготавливаем SQL-запрос
            $query = $db->prepare("INSERT INTO $db_table (PL) values (:PL)");
            // Выполняем запрос с данными
            $query->execute($data);
            // Запишим в переменую, что запрос отрабтал
        }
    } catch (PDOException $e) {
        // Если есть ошибка соединения или выполнения запроса, выводим её
        print "Ошибка!: " . $e->getMessage() . "<br/>";
    }
    print('<h1>Успешно отправлено.</h1><br/>');
    // Сохраняем куку с признаком успешного сохранения.
  setcookie('save', '1');

  // Делаем перенаправление.
  header('Location: index.php');
}

?>
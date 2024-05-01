<?php
include('../settings.php')
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $messages = array();
  if (!empty($_COOKIE['save'])) {
      setcookie('save', '', 100000);
      $messages['allok'] = '<div class="good">Спасибо, результаты сохранены</div>';
  }
  $errors = array();
  $errors['name1'] = !empty($_COOKIE['name_error1']);
  $errors['name2'] = !empty($_COOKIE['name_error2']);
  $errors['phone1'] = !empty($_COOKIE['phone_error1']);
  $errors['phone2'] = !empty($_COOKIE['phone_error2']);
  $errors['email1'] = !empty($_COOKIE['email_error1']);
  $errors['email2'] = !empty($_COOKIE['email_error2']);
  $errors['year1'] = !empty($_COOKIE['year_error1']);
  $errors['year2'] = !empty($_COOKIE['year_error2']);
  $errors['pol1'] = !empty($_COOKIE['pol_error1']);
  $errors['pol2'] = !empty($_COOKIE['pol_error2']);
  $errors['lang1'] = !empty($_COOKIE['lang_error1']);
  $errors['lang2'] = !empty($_COOKIE['lang_error2']);
  $errors['biog1'] = !empty($_COOKIE['biog_error1']);
  $errors['biog2'] = !empty($_COOKIE['biog_error2']);
  $errors['checkb'] = !empty($_COOKIE['checkb_error']);

  if ($errors['name1']) {
    setcookie('name_error1', '', 100000);
    $messages['name1'] = '<p class="msg">Заполните имя</p>';
  }
  if ($errors['name2']) {
    setcookie('name_error2', '', 100000);
    $messages['name2'] = '<p class="msg">Корректно* заполните имя</p>';
  }
  if ($errors['email1']) {
    setcookie('email_error1', '', 100000);
    $messages['email1'] = '<p class="msg">Заполните email</p>';
  } else if ($errors['email2']) {
    setcookie('email_error2', '', 100000);
    $messages['email2'] = '<p class="msg">Корректно* заполните email</p>';
  }
  if (empty($phone)) {
    setcookie('phone_error1', '', 100000);
    $messages['phone1'] = '<p class="msg">Заполните телефон</p>';
  } else if (!preg_match('/^(\+\d+|\d+)$/', $phone)) {
    setcookie('phone_error2', '', 100000);
    $messages['phone2'] = '<p class="msg">Корректно* заполните телефон</p>';
  }
  if ($errors['year1']) {
    setcookie('year_error1', '', 100000);
    $messages['year1'] = '<p class="msg">Неправильный формат ввода года</p>';
  } else if ($errors['year2']) {
    setcookie('year_error2', '', 100000);
    $messages['year2'] = '<p class="msg">Вам должно быть 18 лет</p>';
  }
  if ($errors['pol1']) {
    setcookie('pol_error1', '', 100000);
    $messages['pol1'] = '<p class="msg">Выберите пол</p>';
  }
  if ($errors['pol2']) {
    setcookie('pol_error2', '', 100000);
    $messages['pol2'] = '<p class="msg">Выбран неизвестный пол</p>';
  }
  if ($errors['lang1']) {
    setcookie('lang_error1', '', 100000);
    $messages['lang1'] = '<p class="msg">Выберите хотя бы один<br>язык программирования</p>';
  } else if ($errors['lang2']) {
    setcookie('lang_error2', '', 100000);
    $messages['lang2'] = '<p class="msg">Выбран неизвестный<br>язык программирования</p>';
  }
  if ($errors['biog1']) {
    setcookie('biog_error1', '', 100000);
    $messages['biog1'] = '<p class="msg">Расскажи о себе что-нибудь</p>';
  } else if ($errors['biog2']) {
    setcookie('biog_error2', '', 100000);
    $messages['biog2'] = '<p class="msg">Недопустимый формат ввода <br> биографии</p>';
  }
  if ($errors['checkb']) {
    setcookie('checkb_error', '', 100000);
    $messages['checkb'] = '<p class="msg">Ознакомьтесь с контрактом</p>';
  }
  $values = array();
  $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
  $values['phone'] = empty($_COOKIE['phone_value']) ? '' : $_COOKIE['phone_value'];
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  $values['year'] = empty($_COOKIE['year_value']) ? '' : $_COOKIE['year_value'];
  $values['pol'] = empty($_COOKIE['pol_value']) ? '' : $_COOKIE['pol_value'];
  $values['lang'] = empty($_COOKIE['lang_value']) ? '' : $_COOKIE['lang_value'];
  $values['biog'] = empty($_COOKIE['biog_value']) ? '' : $_COOKIE['biog_value'];
  $values['checkb'] = empty($_COOKIE['checkb_value']) ? '' : $_COOKIE['checkb_value'];
  include('form.php');
} else {
  $errors = FALSE;
  $name = $_POST['people_name'];
  $phone = $_POST['people_phone'];
  $email = $_POST['people_mail'];
  $year = $_POST['date1'];
  $pol = $_POST['radio_group_1'];
  if(isset($_POST["PL"])) {
    $lang = $_POST["PL"];
    $filtred_lang = array_filter($lang, 
    function($value) {
      return($value == 1 || $value == 2 || $value == 3
      || $value == 3 || $value == 4 || $value == 5
      || $value == 6|| $value == 7|| $value == 8
      || $value == 9 || $value == 10 || $value == 11);
      }
    );
  }
  $biog = $_POST['bio'];
  $checkb = isset($_POST['check']);
  
  $errors = FALSE;
  
  if (empty($name)) {
    print('<h1>Заполните поле "Имя".</h1><br/>');
    $errors = TRUE;
  } else if (!preg_match('/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u', $name)) {
    print('<h1>Введены недопустимые символы в поле "Имя".</h1><br/>');
    $errors = TRUE;
  }
  
  if (empty($phone)) {
    print('<h1>Заполните поле "Телефон".</h1><br/>');
    $errors = TRUE;
  } else if (!preg_match('/^(\+\d+|\d+)$/', $phone)) {
    print('<h1>Введены недопустимые символы в поле "Телефон".</h1><br/>');
    $errors = TRUE;
  }
  
  if (empty($email)) {
    print('<h1>Заполните поле "Email".</h1><br/>');
    $errors = TRUE;
  } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    print('<h1>Корректно* заполните поле "Email".</h1><br/>');
    $errors = TRUE;
  }
  
  if ($pol != 'Мужской' && $pol != 'Женский') {
    print('<h1>Выбран неизвестный пол.</h1><br/>');
    $errors = TRUE;
  }
  
  if (empty($lang)) {
    print('<h1>Выберите хотя бы один язык программирования.</h1><br/>');
    $errors = TRUE;
  } else if (count($filtred_lang) != count($lang)) {
    print('<h1>Выбран неизвестный язык программирования.</h1><br/>');
    $errors = TRUE;
  }
  
  if (empty($biog)) {
    print('<h1>Заполните поле "Биография".</h1><br/>');
    $errors = TRUE;
  } else if (!preg_match('/^[a-zA-Zа-яА-ЯёЁ0-9.,;!? \-]+$/u', $biog)) {
    print('<h1>Введены недопустимые символы в поле "Биография".</h1><br/>');
    $errors = TRUE;
  } else if (strlen($biog) > 128) { 
    print('<h1>Превышено количество символов в поле "Биография".</h1><br/>');
    $errors = TRUE;
  }
  
  if ($checkb == '') {
    print('<h1>Ознакомьтесь с контрактом.</h1><br/>');
    $errors = TRUE;
  }
  
  if ($errors) {
    exit();
  }
}
// Переменные с формы
    $people_name = $_POST['people_name'];
    $people_phone = $_POST['people_phone'];
    $people_mail = $_POST['people_mail'];
    $date1 = strtotime($_POST['date1']);
    $radio_group_1 = $_POST['radio_group_1'];
    $bio = $_POST['bio'];

    
    // Параметры для подключения
    
    
    try {
        // Подключение к базе данных
        $db = new PDO("mysql:host=$db_host;dbname=$db_base", $db_user, $db_password);
        // Устанавливаем корректную кодировку
        $db->exec("set names utf8");
        // Собираем данные для запроса
        $date1=date('Y.m.d',strtotime($date1));
        $data = array( 'people_name' => $people_name, 'people_phone' => $people_phone, 'people_mail' => $people_mail, 'date1' => $date1, 'radio_group_1' => $radio_group_1, 'bio' => $bio ); 
        // Подготавливаем SQL-запрос
        $query = $db->prepare("INSERT INTO $db_table (name, phone, email, dr, pol, biog) values (:people_name, :people_phone, :people_mail, :date1, :radio_group_1, :bio)");
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
?>
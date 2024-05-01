<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!empty($_GET['save'])) {
      print('<p>Спасибо, результаты сохранены.</p>');
    }
    include('index.html');
    exit();
  }
  
  $name = $_POST['people_name'];
  $phone = $_POST['people_phone'];
  $email = $_POST['people_mail'];
  $year = $_POST['date1'];
  $gender = $_POST['radio_group_1'];
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
  $biography = $_POST['bio'];
  $checkboxContract = isset($_POST['check']);
  
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
  
  if ($gender != 'Мужской' && $gender != 'Женский') {
    print('<h1>Выбран неизвестный пол.</h1><br/>');
    $errors = TRUE;
  }
  
  if (empty($languages)) {
    print('<h1>Выберите хотя бы один язык программирования.</h1><br/>');
    $errors = TRUE;
  } else if (count($filtred_languages) != count($languages)) {
    print('<h1>Выбран неизвестный язык программирования.</h1><br/>');
    $errors = TRUE;
  }
  
  if (empty($biography)) {
    print('<h1>Заполните поле "Биография".</h1><br/>');
    $errors = TRUE;
  } else if (!preg_match('/^[a-zA-Zа-яА-ЯёЁ0-9.,;!? \-]+$/u', $biography)) {
    print('<h1>Введены недопустимые символы в поле "Биография".</h1><br/>');
    $errors = TRUE;
  } else if (strlen($biography) > 128) { 
    print('<h1>Превышено количество символов в поле "Биография".</h1><br/>');
    $errors = TRUE;
  }
  
  if ($checkboxContract == '') {
    print('<h1>Ознакомьтесь с контрактом.</h1><br/>');
    $errors = TRUE;
  }
  
  if ($errors) {
    exit();
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
?>
<?php
// Переменные с формы
    $people_name = $_POST['people_name'];
    $people_phone = $_POST['people_phone'];
    $people_mail = $_POST['people_mail'];
    $date1 = $_POST['date1'];
    $radio_group_1 = $_POST['radio_group_1'];
    $bio = $_POST['bio'];

    
    // Параметры для подключения
    $db_host = "localhost"; 
    $db_user = "u67277"; // Логин БД
    $db_password = "7133721"; // Пароль БД
    $db_base = 'u67277'; // Имя БД
    $db_table = "FIO"; // Имя Таблицы БД
    
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
    $db_table = "PL"; // Имя Таблицы БД
    try {
        // Подключение к базе данных
        $db = new PDO("mysql:host=$db_host;dbname=$db_base", $db_user, $db_password);
        // Устанавливаем корректную кодировку
        $db->exec("set names utf8");
        // Собираем данные для запроса
        foreach ($_POST['PL'] as $PL){
            $data = array( 'PL' => $PL); 
            // Подготавливаем SQL-запрос
            $query = $db->prepare("INSERT INTO $db_table (lang) values (:PL)");
            // Выполняем запрос с данными
            $query->execute($data);
            // Запишим в переменую, что запрос отрабтал
        }
    } catch (PDOException $e) {
        // Если есть ошибка соединения или выполнения запроса, выводим её
        print "Ошибка!: " . $e->getMessage() . "<br/>";
    }
?>
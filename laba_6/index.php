<?php
include('admin.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        $stmt = $db->prepare("SELECT id, name, phone, email, dr, pol, biography FROM FIO");
        $stmt->execute();
        $values = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
    }
    if (!empty($_COOKIE['edit'])) {
        setcookie('edit', '', time() + 24 * 60 * 60);
    }
    include('errors.php');
    $_SESSION['token'] = bin2hex(random_bytes(32));
    $_SESSION['login'] = $validUser;

    include('form.php');
    exit();
  } 
  else 
  {
    if (!empty($_POST['token']) && hash_equals($_POST['token'], $_SESSION['token'])) {
        foreach ($_POST as $key => $value) {
            if (preg_match('/^clear(\d+)_x$/', $key, $matches)) {
                $app_id = $matches[1];
                setcookie('clear', $app_id, time() + 24 * 60 * 60);
                $stmt = $db->prepare("DELETE FROM FIO WHERE id = ?");
                $stmt->execute([$app_id]);
                $stmt = $db->prepare("DELETE FROM ProgLang WHERE idProg = ?");
                $stmt->execute([$app_id]);
                $stmt = $db->prepare("DELETE FROM users WHERE user_id = ?");
                $stmt->execute([$app_id]);
            }
            if (preg_match('/^edit(\d+)_x$/', $key, $matches)) {
                $app_id = $matches[1];
                setcookie('edit', $app_id, time() + 24 * 60 * 60);
            }
            if (preg_match('/^save(\d+)_x$/', $key, $matches)) {
                setcookie('edit', '', time() + 24 * 60 * 60);
                $app_id = $matches[1];
                include('errors.php');
                $stmt = $db->prepare("SELECT name, phone, email, dr, pol, biography FROM FIO WHERE id = ?");
                $stmt->execute([$app_id]);
                $old_dates = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $stmt = $db->prepare("SELECT PL_id FROM ProgLang WHERE idProg = ?");
                $stmt->execute([$app_id]);
                $old_languages = $stmt->fetchAll(PDO::FETCH_COLUMN);
                if (array_diff($dates, $old_dates[0])) {
                    setcookie('updated', $app_id, time() + 24 * 60 * 60);
                    $stmt = $db->prepare("UPDATE FIO SET name = ?, phone = ?, email = ?, dr = ?, pol = ?, biography = ? WHERE id = ?");
                    $stmt->execute([$people_name, $people_phone, $people_mail, $date1, $radio_group_1, $bio, $app_id]);
                }
                if (array_diff($languages, $old_languages) || count($languages) != count($old_languages)) {
                    setcookie('updated', $app_id, time() + 24 * 60 * 60);
                    try {
                        $db->beginTransaction();
                    
                        $stmt = $db->prepare("DELETE FROM ProgLang WHERE idProg = ?");
                        $stmt->execute([$app_id]);
                    
                        $stmt = $db->prepare("INSERT INTO ProgLang (idProg,PL_id) VALUES (?, ?)");
                        foreach ($languages as $language_id) {
                            $stmt->execute([$app_id, $language_id]);
                        }
                        $db->commit();
                    } catch (PDOException $e) {
                        $db->rollBack();
                        echo "Ошибка: " . $e->getMessage();
                    }
                }
            }
        }
    
    } 
 else {
        die('Ошибка CSRF: недопустимый токен');
    }
    header('Location: index.php');
}
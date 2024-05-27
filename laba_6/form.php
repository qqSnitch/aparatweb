<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
    echo '<div class="msgbox">'; 
        if (!empty($_COOKIE['updated'])) {
            echo '<p class="msg">Обновлены данные пользователя с id = ' . $_COOKIE['updated'] . '</p>';
            setcookie('updated', '', time() + 24 * 60 * 60);
        }
        if (!empty($_COOKIE['clear'])) {
            echo '<p class="msg">Удалены данные пользователя с id = ' . $_COOKIE['clear'] . '</p>';
            setcookie('clear', '', time() + 24 * 60 * 60);
        }
        echo '</div>';
    include('statistics.php');
    ?>
    <form action="" method="POST">
        <table>
            <caption>Данные формы</caption>
            <tr> 
                <th>id</th>
                <th>Имя</th>
                <th>Телефон</th>
                <th>email</th>
                <th>Дата</th>
                <th>Пол</th>
                <th>Любимый язык</th>
                <th>Биография</th>
                <th></th>
            </tr>
            <?php
                foreach ($values as $value) {
                    echo    '<tr>';
                    echo    '<td style="font-weight: 700;">'; print($value['id']); echo '</td>';
                    echo    '<td>
                                <input'; if(empty($_COOKIE['edit']) || ($_COOKIE['edit'] != $value['id'])) print(" disabled ");
                                    else print(" "); echo 'class="input" name="name'.$value['id'].'" value="'; print(htmlspecialchars(strip_tags($value['name']))); echo '">
                            </td>';
                    echo    '<td>
                            <input'; if(empty($_COOKIE['edit']) || ($_COOKIE['edit'] != $value['id'])) print(" disabled ");
                                else print(" "); echo 'class="input" name="phone'.$value['id'].'" value="'; print(htmlspecialchars(strip_tags($value['phone']))); echo '">
                            </td>';
                    echo    '<td>
                                <input'; if(empty($_COOKIE['edit']) || ($_COOKIE['edit'] != $value['id'])) print(" disabled ");
                                    else print(" "); echo 'class="input" name="email'.$value['id'].'" value="'; print(htmlspecialchars(strip_tags($value['email']))); echo '">
                            </td>';
                    echo    '<td>';
                    echo        '<input'; if(empty($_COOKIE['edit']) || ($_COOKIE['edit'] != $value['id'])) print(" disabled ");
                                else print(" "); echo 'class="input" name="date1'.$value['id'].'" ';  echo '">
                            </td>';
                    echo    '<td> 
                                <div class="column-item">
                                    <input'; if(empty($_COOKIE['edit']) || ($_COOKIE['edit'] != $value['id'])) print(" disabled ");
                                        else print(" "); echo 'type="radio" id="radio_group_1'.$value['id'].'" name="radio_group_1'.$value['id'].'" value="Мужской" ';
                                             echo '>
                                    <label for="radioMale'.$value['id'].'">Мужчина</label>
                                </div>
                                <div class="column-item">
                                    <input'; if(empty($_COOKIE['edit']) || ($_COOKIE['edit'] != $value['id'])) print(" disabled ");
                                        else print(" "); echo 'type="radio" id="radio_group_1'.$value['id'].'" name="radio_group_1'.$value['id'].'" value="Женский" ';
                                             echo '>
                                    <label for="radioFemale'.$value['id'].'">Женщина</label>
                                </div>
                            </td>';
                    $stmt = $db->prepare("SELECT PL_id FROM ProgLang WHERE idProg = ?");
                    $stmt->execute([$value['id']]);
                    $languages = $stmt->fetchAll(PDO::FETCH_COLUMN);
                    echo    '<td class="languages">
                                <div class="column-item">
                                    <input'; if(empty($_COOKIE['edit']) || ($_COOKIE['edit'] != $value['id'])) print(" disabled ");
                                        else print(" "); echo 'type="checkbox" id="Pascal'.$value['id'].'" name="languages'.$value['id'].'[]" value="1"' . (in_array(1, $languages) ? ' checked' : '') . '>
                                    <label for="Pascal'.$value['id'].'">Pascal</label>
                                </div>
                                <div class="column-item">
                                    <input'; if(empty($_COOKIE['edit']) || ($_COOKIE['edit'] != $value['id'])) print(" disabled ");
                                        else print(" "); echo 'type="checkbox" id="C'.$value['id'].'" name="languages'.$value['id'].'[]" value="2"' . (in_array(2, $languages) ? ' checked' : '') . '>
                                    <label for="C'.$value['id'].'">C</label>
                                </div>
                                <div class="column-item">
                                    <input'; if(empty($_COOKIE['edit']) || ($_COOKIE['edit'] != $value['id'])) print(" disabled ");
                                        else print(" "); echo 'type="checkbox" id="Cpp'.$value['id'].'" name="languages'.$value['id'].'[]" value="3"' . (in_array(3, $languages) ? ' checked' : '') . '>
                                    <label for="Cpp'.$value['id'].'">C++</label>
                                </div>
                                <div class="column-item">
                                    <input'; if(empty($_COOKIE['edit']) || ($_COOKIE['edit'] != $value['id'])) print(" disabled ");
                                        else print(" "); echo 'type="checkbox" id="JavaScript'.$value['id'].'" name="languages'.$value['id'].'[]" value="4"' . (in_array(4, $languages) ? ' checked' : '') . '>
                                    <label for="JavaScript'.$value['id'].'">JavaScript</label>
                                <div class="column-item">
                                    <input'; if(empty($_COOKIE['edit']) || ($_COOKIE['edit'] != $value['id'])) print(" disabled ");
                                        else print(" "); echo 'type="checkbox" id="PHP'.$value['id'].'" name="languages'.$value['id'].'[]" value="5"' . (in_array(5, $languages) ? ' checked' : '') . '>
                                    <label for="PHP'.$value['id'].'">PHP</label>
                                </div>
                                <div class="column-item">
                                    <input'; if(empty($_COOKIE['edit']) || ($_COOKIE['edit'] != $value['id'])) print(" disabled ");
                                        else print(" "); echo 'type="checkbox" id="Python'.$value['id'].'" name="languages'.$value['id'].'[]" value="6"' . (in_array(6, $languages) ? ' checked' : '') . '>
                                    <label for="Python'.$value['id'].'">Python</label>
                                </div>
                                <div class="column-item">
                                    <input'; if(empty($_COOKIE['edit']) || ($_COOKIE['edit'] != $value['id'])) print(" disabled ");
                                        else print(" "); echo 'type="checkbox" id="Java'.$value['id'].'" name="languages'.$value['id'].'[]" value="7"' . (in_array(7, $languages) ? ' checked' : '') . '>
                                    <label for="Java'.$value['id'].'">Java</label>
                                </div>
                                <div class="column-item">
                                    <input'; if(empty($_COOKIE['edit']) || ($_COOKIE['edit'] != $value['id'])) print(" disabled ");
                                        else print(" "); echo 'type="checkbox" id="Haskel'.$value['id'].'" name="languages'.$value['id'].'[]" value="8"' . (in_array(8, $languages) ? ' checked' : '') . '>
                                    <label for="Haskel'.$value['id'].'">Haskel</label>
                                </div>
                                <div class="column-item">
                                    <input'; if(empty($_COOKIE['edit']) || ($_COOKIE['edit'] != $value['id'])) print(" disabled ");
                                        else print(" "); echo 'type="checkbox" id="Clojure'.$value['id'].'" name="languages'.$value['id'].'[]" value="9"' . (in_array(9, $languages) ? ' checked' : '') . '>
                                    <label for="Clojure'.$value['id'].'">Clojure</label>
                                </div>
                                <div class="column-item">
                                    <input'; if(empty($_COOKIE['edit']) || ($_COOKIE['edit'] != $value['id'])) print(" disabled ");
                                        else print(" "); echo 'type="checkbox" id="Prolog'.$value['id'].'" name="languages'.$value['id'].'[]" value="10"' . (in_array(10, $languages) ? ' checked' : '') . '>
                                    <label for="Prolog'.$value['id'].'">Prolog</label>
                                </div>
                                <div class="column-item">
                                    <input'; if(empty($_COOKIE['edit']) || ($_COOKIE['edit'] != $value['id'])) print(" disabled ");
                                        else print(" "); echo 'type="checkbox" id="Scala'.$value['id'].'" name="languages'.$value['id'].'[]" value="11"' . (in_array(11, $languages) ? ' checked' : '') . '>
                                    <label for="Scala'.$value['id'].'">Scala</label>
                                </div>
                            </td>';
                    echo    '<td>
                                <textarea'; if(empty($_COOKIE['edit']) || ($_COOKIE['edit'] != $value['id'])) print(" disabled ");
                                    else print(" "); echo 'name="biography'.$value['id'].'" id="" cols="30" rows="4" maxlength="128">';
                                        print htmlspecialchars(strip_tags($value['biography'])); echo '</textarea>
                            </td>';
                    echo    '<td>';
                if (empty($_COOKIE['edit']) || ($_COOKIE['edit'] != $value['id'])) {
                    echo        '<div class="column-item">
                                    <input name="edit'.$value['id'].'" type="image" src="https://static.thenounproject.com/png/2185844-200.png" width="25" height="25" alt="submit"/>
                                </div>
                                <div class="column-item">
                                    <input name="clear'.$value['id'].'" type="image" src="https://cdn-icons-png.flaticon.com/512/860/860829.png" width="25" height="25" alt="submit"/>
                                </div>';
                } else {
                    echo        '<div class="column-item">
                                    <input name="save'.$value['id'].'" type="image" src="https://cdn-icons-png.flaticon.com/512/84/84138.png" width="25" height="25" alt="submit"/>
                                </div>';
                }
                    echo    '</td>';
                    echo    '</tr>'; 
                }
            ?>
        </table>
        <?php if (!empty($_SESSION['login'])) {echo '<input type="hidden" name="token" value="' . $_SESSION["token"] . '">'; } ?>
    </form>
</body>
</html>
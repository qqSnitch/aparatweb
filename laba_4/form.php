<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Form</title>
        <link href="style.css" rel="stylesheet">
    </head>

    <body>
    <?php
if (!empty($messages)) {
  print('<div id="messages">');
  // Выводим все сообщения.
  foreach ($messages as $message) {
    print($message);
  }
  print('</div>');
}

// Далее выводим форму отмечая элементы с ошибками классом error
// и задавая начальные значения элементов ранее сохраненными.
?>
        <div class="form_wrapper">
            <div class="form_border">
                <div id="myForm">
                    <form id="form" method="POST" action=" ">
                        <input type="text" id="name" name="people_name" <?php if ($errors['people_name']) {print 'class="error"';} ?> value="<?php print $values['people_name']; ?>" >
                        <input type="tel"id="telephon" name="people_phone" <?php if ($errors['people_phone']) {print 'class="error"';} ?> value="<?php print $values['people_phone']; ?>" >
                        <br>
                        <input type="email"id="mail" name="people_mail" <?php if ($errors['people_mail']) {print 'class="error"';} ?> value="<?php print $values['people_mail']; ?>" >
                        <input type="date" id="date" name="date1" <?php if ($errors['date1']) {print 'class="error"';} ?> value="<?php print $values['date1']; ?>">
                        <br>
                        <label>
                            <input type="radio" required name="radio_group_1" id="1" value="Мужской">Мужской
                        </label>
                        <label>
                            <input type="radio" required name="radio_group_1" id="2" value="Женский">Женский
                        </label>
                        <br>
                        <label>Любимые языки программирования:
                            <br>
                            <select name="PL[]" multiple size="11" required>
                              <option value="1">Pascal</option>
                              <option value="2">C</option>
                              <option value="3">C++</option>
                              <option value="4">JavaScript</option>
                              <option value="5">PHP</option>
                              <option value="6">Python</option>
                              <option value="7">Java</option>
                              <option value="8">Haskel</option>
                              <option value="9">Clojure</option>
                              <option value="10">Prolog</option>
                              <option value="11">Scala</option>
                            </select>
                          </label>
                        <br>
                        <textarea name="bio" id="textbox"<?php if ($errors['bio']) {print 'class="error"';} ?> value="<?php print $values['bio']; ?>"></textarea>
                        <br>
                        <input type="checkbox" name="check"<?php if ($errors['check']) {print 'class="error"';} ?> value="<?php print $values['check']; ?>"> C контрактом ознакомлен (а).<br>
                        <button type="submit" class="popup-close">Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
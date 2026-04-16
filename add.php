<?php
// Обработка добавления записи
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $mysqli = mysqli_connect('localhost', 'root', '1234', 'notebook');
    
    if (mysqli_connect_errno()) {
        echo '<div class="error">Ошибка подключения к БД</div>';
    } else {
        mysqli_set_charset($mysqli, 'utf8');
        
        $surname = mysqli_real_escape_string($mysqli, $_POST['surname']);
        $name = mysqli_real_escape_string($mysqli, $_POST['name']);
        $patronymic = mysqli_real_escape_string($mysqli, $_POST['patronymic']);
        $gender = mysqli_real_escape_string($mysqli, $_POST['gender']);
        $birthdate = !empty($_POST['birthdate']) ? $_POST['birthdate'] : null;
        $phone = mysqli_real_escape_string($mysqli, $_POST['phone']);
        $address = mysqli_real_escape_string($mysqli, $_POST['address']);
        $email = mysqli_real_escape_string($mysqli, $_POST['email']);
        $comment = mysqli_real_escape_string($mysqli, $_POST['comment']);
        
        $sql = "INSERT INTO contacts (surname, name, patronymic, gender, birthdate, phone, address, email, comment) 
                VALUES ('{$surname}', '{$name}', '{$patronymic}', '{$gender}', '{$birthdate}', '{$phone}', '{$address}', '{$email}', '{$comment}')";
        
        if (mysqli_query($mysqli, $sql)) {
            echo '<div class="success">Запись добавлена</div>';
        } else {
            echo '<div class="error">Ошибка: запись не добавлена</div>';
        }
        
        mysqli_close($mysqli);
    }
}
?>

<form method="post" class="contact-form">
    <input type="hidden" name="action" value="add">
    
    <div class="form-row">
        <label>Фамилия: <input type="text" name="surname" required></label>
        <label>Имя: <input type="text" name="name" required></label>
        <label>Отчество: <input type="text" name="patronymic"></label>
    </div>
    
    <div class="form-row">
        <label>Пол: 
            <select name="gender">
                <option value="">Не указан</option>
                <option value="m">Мужской</option>
                <option value="f">Женский</option>
            </select>
        </label>
        <label>Дата рождения: <input type="date" name="birthdate"></label>
        <label>Телефон: <input type="text" name="phone"></label>
    </div>
    
    <div class="form-row">
        <label>E-mail: <input type="email" name="email"></label>
        <label>Адрес: <input type="text" name="address"></label>
    </div>
    
    <div class="form-row">
        <label>Комментарий:<br><textarea name="comment" rows="3"></textarea></label>
    </div>
    
    <button type="submit" class="btn">Добавить запись</button>
</form>
<?php
$mysqli = mysqli_connect('localhost', 'root', '1234', 'notebook');

if (mysqli_connect_errno()) {
    echo '<div class="error">Ошибка подключения к БД</div>';
    exit;
}

mysqli_set_charset($mysqli, 'utf8');

// Обработка сохранения изменений
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'edit') {
    $id = (int)$_POST['id'];
    $surname = mysqli_real_escape_string($mysqli, $_POST['surname']);
    $name = mysqli_real_escape_string($mysqli, $_POST['name']);
    $patronymic = mysqli_real_escape_string($mysqli, $_POST['patronymic']);
    $gender = mysqli_real_escape_string($mysqli, $_POST['gender']);
    $birthdate = !empty($_POST['birthdate']) ? $_POST['birthdate'] : null;
    $phone = mysqli_real_escape_string($mysqli, $_POST['phone']);
    $address = mysqli_real_escape_string($mysqli, $_POST['address']);
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $comment = mysqli_real_escape_string($mysqli, $_POST['comment']);
    
    $sql = "UPDATE contacts SET 
            surname='{$surname}', name='{$name}', patronymic='{$patronymic}', 
            gender='{$gender}', birthdate='{$birthdate}', phone='{$phone}', 
            address='{$address}', email='{$email}', comment='{$comment}' 
            WHERE id={$id}";
    
    mysqli_query($mysqli, $sql);
    
    header("Location: /?p=edit&id={$id}");
    exit;
}

// ===== ИНИЦИАЛИЗАЦИЯ ПЕРЕМЕННОЙ =====
$currentContact = null;

// Определяем текущую запись
$currentId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($currentId > 0) {
    $res = mysqli_query($mysqli, "SELECT * FROM contacts WHERE id={$currentId}");
    $currentContact = mysqli_fetch_assoc($res);
}

// ===== ЕСЛИ ЗАПИСЬ НЕ ВЫБРАНА - БЕРЁМ ПЕРВУЮ ПОСЛЕ СОРТИРОВКИ ПО ФАМИЛИИ И ИМЕНИ =====
if (!$currentContact) {
    // ВАЖНО! Сортировка по фамилии, затем по имени (как в списке слева)
    $res = mysqli_query($mysqli, "SELECT * FROM contacts ORDER BY surname, name LIMIT 1");
    $currentContact = mysqli_fetch_assoc($res);
    if ($currentContact) {
        $currentId = $currentContact['id'];
    }
}

// Получаем все контакты для списка (сортировка по фамилии, затем по имени)
$res = mysqli_query($mysqli, "SELECT id, surname, name, patronymic FROM contacts ORDER BY surname, name");
?>

<div class="edit-container">
    <div class="contact-list">
        <h3>Список контактов</h3>
        <?php
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                // Формируем инициалы (только имя, без отчества)
                $firstLetter = '';
                if (!empty($row['name'])) {
                    $firstLetter = iconv_substr($row['name'], 0, 1, 'UTF-8') . '.';
                }
                
                $displayName = $row['surname'] . ' ' . $firstLetter;
                
                if ($row['id'] == $currentId) {
                    echo "<div class='selected-contact'>{$displayName}</div>";
                } else {
                    echo "<a href='/?p=edit&id={$row['id']}' class='contact-link'>{$displayName}</a>";
                }
            }
        } else {
            echo '<div class="info">Нет контактов для редактирования</div>';
        }
        ?>
    </div>
    
    <div class="edit-form">
        <h3>Редактирование контакта</h3>
        <?php if ($currentContact && !empty($currentContact)): ?>
        <form method="post" class="contact-form">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?= $currentContact['id'] ?>">
            
            <div class="form-row">
                <label>Фамилия: <input type="text" name="surname" value="<?= htmlspecialchars($currentContact['surname']) ?>" required></label>
                <label>Имя: <input type="text" name="name" value="<?= htmlspecialchars($currentContact['name']) ?>" required></label>
                <label>Отчество: <input type="text" name="patronymic" value="<?= htmlspecialchars($currentContact['patronymic']) ?>"></label>
            </div>
            
            <div class="form-row">
                <label>Пол: 
                    <select name="gender">
                        <option value="">Не указан</option>
                        <option value="m" <?= $currentContact['gender'] == 'm' ? 'selected' : '' ?>>Мужской</option>
                        <option value="f" <?= $currentContact['gender'] == 'f' ? 'selected' : '' ?>>Женский</option>
                    </select>
                </label>
                <label>Дата рождения: <input type="date" name="birthdate" value="<?= $currentContact['birthdate'] ?>"></label>
                <label>Телефон: <input type="text" name="phone" value="<?= htmlspecialchars($currentContact['phone']) ?>"></label>
            </div>
            
            <div class="form-row">
                <label>E-mail: <input type="email" name="email" value="<?= htmlspecialchars($currentContact['email']) ?>"></label>
                <label>Адрес: <input type="text" name="address" value="<?= htmlspecialchars($currentContact['address']) ?>"></label>
            </div>
            
            <div class="form-row">
                <label>Комментарий:<br><textarea name="comment" rows="3"><?= htmlspecialchars($currentContact['comment']) ?></textarea></label>
            </div>
            
            <button type="submit" class="btn">Сохранить изменения</button>
        </form>
        <?php else: ?>
        <div class="info">Нет контактов для редактирования</div>
        <?php endif; ?>
    </div>
</div>

<?php
mysqli_close($mysqli);
?>
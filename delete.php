<?php
$mysqli = mysqli_connect('localhost', 'root', '1234', 'notebook');

if (mysqli_connect_errno()) {
    echo '<div class="error">Ошибка подключения к БД</div>';
    exit;
}

mysqli_set_charset($mysqli, 'utf8');

// Обработка удаления
if (isset($_GET['delete_id'])) {
    $deleteId = (int)$_GET['delete_id'];
    
    // Получаем фамилию для сообщения
    $res = mysqli_query($mysqli, "SELECT surname FROM contacts WHERE id={$deleteId}");
    $contact = mysqli_fetch_assoc($res);
    $surname = $contact ? $contact['surname'] : '';
    
    // Удаляем запись
    mysqli_query($mysqli, "DELETE FROM contacts WHERE id={$deleteId}");
    
    echo "<div class='success'>Запись с фамилией '{$surname}' удалена</div>";
}

// Получаем список всех контактов
$res = mysqli_query($mysqli, "SELECT id, surname, name, patronymic FROM contacts ORDER BY surname, name");
?>

<div class="delete-container">
    <h3>Удаление контакта</h3>
    
    <?php if (mysqli_num_rows($res) > 0): ?>
    <div class="contact-list">
        <?php
        while ($row = mysqli_fetch_assoc($res)) {
            $initials = mb_substr($row['name'], 0, 1) . '.';
            if (!empty($row['patronymic'])) {
                $initials .= mb_substr($row['patronymic'], 0, 1) . '.';
            }
            $displayName = $row['surname'] . ' ' . $initials;
            
            echo "<a href='/?p=delete&delete_id={$row['id']}' class='delete-link' onclick='return confirm(\"Удалить контакт {$displayName}?\")'>{$displayName}</a>";
        }
        ?>
    </div>
    <?php else: ?>
    <div class="info">Нет контактов для удаления</div>
    <?php endif; ?>
</div>

<?php
mysqli_close($mysqli);
?>
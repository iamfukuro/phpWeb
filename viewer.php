<?php
/**
 * Функция возвращает HTML-код с таблицей контактов
 * @param string $sort Тип сортировки (byid, surname, birthdate)
 * @param int $page Номер страницы (начиная с 0)
 * @return string HTML-код таблицы и пагинации
 */
function getContactsList($sort, $page) {
    // Подключение к БД
    $mysqli = mysqli_connect('localhost', 'root', '1234', 'notebook');
    
    if (mysqli_connect_errno()) {
        return '<div class="error">Ошибка подключения к БД: ' . mysqli_connect_error() . '</div>';
    }
    
    mysqli_set_charset($mysqli, 'utf8');
    
    // Определяем поле сортировки
    switch ($sort) {
        case 'surname':
            $orderBy = 'surname, name';
            break;
        case 'birthdate':
            $orderBy = 'birthdate';
            break;
        default:
            $orderBy = 'id';
    }
    
    // Получаем общее количество записей
    $res = mysqli_query($mysqli, 'SELECT COUNT(*) as total FROM contacts');
    $row = mysqli_fetch_assoc($res);
    $totalRecords = $row['total'];
    
    if ($totalRecords == 0) {
        mysqli_close($mysqli);
        return '<div class="info">В записной книжке пока нет контактов</div>';
    }
    
    $recordsPerPage = 10;
    $totalPages = ceil($totalRecords / $recordsPerPage);
    
    // Корректируем номер страницы
    if ($page >= $totalPages) {
        $page = $totalPages - 1;
    }
    if ($page < 0) {
        $page = 0;
    }
    
    $offset = $page * $recordsPerPage;
    
    // Запрос с сортировкой и пагинацией
    $sql = "SELECT * FROM contacts ORDER BY {$orderBy} LIMIT {$offset}, {$recordsPerPage}";
    $res = mysqli_query($mysqli, $sql);
    
    // Формируем таблицу
    $html = '<table class="contacts-table">';
    $html .= '<thead>
                 <tr>
                     <th>Фамилия</th>
                     <th>Имя</th>
                     <th>Отчество</th>
                     <th>Пол</th>
                     <th>Дата рождения</th>
                     <th>Телефон</th>
                     <th>Адрес</th>
                     <th>E-mail</th>
                     <th>Комментарий</th>
                 </tr>
              </thead>
              <tbody>';
    
    while ($row = mysqli_fetch_assoc($res)) {
        $gender = ($row['gender'] == 'm') ? 'Мужской' : (($row['gender'] == 'f') ? 'Женский' : '');
        $birthdate = $row['birthdate'] ? date('d.m.Y', strtotime($row['birthdate'])) : '';
        
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($row['surname']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['name']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['patronymic']) . '</td>';
        $html .= '<td>' . $gender . '</td>';
        $html .= '<td>' . $birthdate . '</td>';
        $html .= '<td>' . htmlspecialchars($row['phone']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['address']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['email']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['comment']) . '</td>';
        $html .= '</tr>';
    }
    
    $html .= '</tbody></table>';
    
    // Пагинация
    if ($totalPages > 1) {
        $html .= '<div class="pagination">';
        for ($i = 0; $i < $totalPages; $i++) {
            $pageNum = $i + 1;
            if ($i == $page) {
                $html .= "<span class='current-page'>{$pageNum}</span>";
            } else {
                $html .= "<a href='/?p=viewer&sort={$sort}&pg={$i}'>{$pageNum}</a>";
            }
        }
        $html .= '</div>';
    }
    
    mysqli_close($mysqli);
    return $html;
}

// Получаем параметры и выводим результат
$sort = $_GET['sort'] ?? 'byid';
$page = isset($_GET['pg']) ? (int)$_GET['pg'] : 0;

echo getContactsList($sort, $page);
?>
<?php
require_once 'layout.php';

// Подключаем модуль меню
require_once 'menu.php';

// Определяем активный пункт меню
if (!isset($_GET['p'])) {
    $_GET['p'] = 'viewer';
}

// Получаем HTML меню
echo getMenu($_GET['p']);

// Подключаем соответствующий модуль контента
$allowedModules = ['viewer', 'add', 'edit', 'delete'];
if (in_array($_GET['p'], $allowedModules) && file_exists($_GET['p'] . '.php')) {
    include $_GET['p'] . '.php';
} else {
    echo '<div class="error">Ошибка: модуль не найден</div>';
}

require_once 'footer.php';
?>
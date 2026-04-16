<?php
/**
 * Функция возвращает HTML-код главного меню сайта
 * @param string $active Активный пункт меню
 * @return string HTML-код меню
 */
function getMenu($active) {
    $menuItems = [
        'viewer' => 'Просмотр',
        'add' => 'Добавление записи',
        'edit' => 'Редактирование записи',
        'delete' => 'Удаление записи'
    ];
    
    $html = '<div id="main-menu">';
    
    // Основные пункты меню
    foreach ($menuItems as $key => $label) {
        $class = ($active == $key) ? 'class="active"' : '';
        $html .= "<a href='/?p={$key}' {$class}>{$label}</a>";
    }
    
    // Подменю для просмотра (сортировка)
    if ($active == 'viewer') {
        // Определяем активную сортировку
        $sort = $_GET['sort'] ?? 'byid';
        
        $html .= '<div id="sub-menu">';
        $html .= '<span>Сортировка: </span>';
        
        $sortItems = [
            'byid' => 'По умолчанию',
            'surname' => 'По фамилии',
            'birthdate' => 'По дате рождения'
        ];
        
        foreach ($sortItems as $key => $label) {
            $class = ($sort == $key) ? 'class="active-sub"' : '';
            $html .= "<a href='/?p=viewer&sort={$key}' {$class}>{$label}</a>";
        }
        
        $html .= '</div>';
    }
    
    $html .= '</div>';
    
    return $html;
}
?>
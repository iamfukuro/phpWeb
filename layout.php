<?php
date_default_timezone_set('Europe/Moscow');

if (!isset($title)) {
    $title = "Ильенков Иван Владленович, 241-351 | Лабораторная 1 - Простейшая программа на php";
}

if (!isset($current)) {
    $current = "";
}

/* Массив меню */
$menu = [
    "index" => "Главная",
    "race"  => "Гонка",
    "about" => "О сайте"
];
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header class="site-header">
    <div class="container header-inner">
        <h1>Новости Формулы 1</h1>

        <nav class="main-nav">
            <?php foreach ($menu as $key => $value): ?>
                
                <a 
                    href="<?php echo $key; ?>.php"
                    class="nav-link <?php echo ($current == $key) ? 'active' : ''; ?>">
                    
                    <?php echo $value; ?>
                </a>

            <?php endforeach; ?>
        </nav>

    </div>  
</header>

<main class="content container">
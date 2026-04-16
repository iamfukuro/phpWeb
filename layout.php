<?php
session_start();

// Инициализация истории и счётчика обновлений
if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = [];
}
if (!isset($_SESSION['iteration'])) {
    $_SESSION['iteration'] = 0;
}
$_SESSION['iteration']++;

date_default_timezone_set('Europe/Moscow');

if (!isset($title)) {
    $title = "Ильенков Иван Владленович, 241-351 | Арифметический калькулятор";
}

if (!isset($current)) {
    $current = "";
}

/* Массив меню (не используется, но оставлен) */
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
        <h1>Арифметический калькулятор</h1>
        <nav class="main-nav"></nav>
    </div>  
</header>

<main class="content container">
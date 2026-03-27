<?php
$title = "ЛР7 — Результат";
include "layout.php";

function notNumber($v) {
    return !is_numeric($v);
}

if (!isset($_POST['element0'])) {
    echo "<p class='error'>Массив не задан</p>";
    include "footer.php";
    exit();
}

$length = $_POST['arrLength'];
$arr = [];

for ($i = 0; $i < $length; $i++) {
    if ($_POST["element$i"] === "" || notNumber($_POST["element$i"])) {
        echo "<p class='error'>Элемент \"" . $_POST["element$i"] . "\" — не число</p>";
        include "footer.php";
        exit();
    }
    $arr[] = (float)$_POST["element$i"];
}

echo "<h3>Исходный массив:</h3>";
echo implode(", ", $arr);

echo "<br><br><b>Массив проверен, сортировка возможна</b><br><br>";

$type = $_POST['algoritm'];

echo "<h3>Алгоритм: $type</h3>";

$iterations = 0;
$start = microtime(true);

/* ==== СОРТИРОВКИ ==== */

function printStep($arr, &$iter) {
    $iter++;
    echo "Итерация $iter: " . implode(", ", $arr) . "<br>";
}

/* пузырёк */
function bubble(&$arr, &$iter) {
    for ($i = 0; $i < count($arr)-1-$i; $i++) {
        for ($j = 0; $j < count($arr)-1; $j++) {
            if ($arr[$j] > $arr[$j+1]) {
                $tmp = $arr[$j];
                $arr[$j] = $arr[$j+1];
                $arr[$j+1] = $tmp;
            }
            printStep($arr, $iter);
        }
    }
}

/* выбор */
function selection(&$arr, &$iter) {
    for ($i = 0; $i < count($arr); $i++) {
        $min = $i;
        for ($j = $i+1; $j < count($arr); $j++) {
            if ($arr[$j] < $arr[$min]) $min = $j;
        }
        $tmp = $arr[$i];
        $arr[$i] = $arr[$min];
        $arr[$min] = $tmp;

        printStep($arr, $iter);
    }
}

/* гном */
function gnome(&$arr, &$iter) {
    $i = 1;
    while ($i < count($arr)) {
        if ($i == 0 || $arr[$i] >= $arr[$i-1]) {
            $i++;
        } else {
            $tmp = $arr[$i];
            $arr[$i] = $arr[$i-1];
            $arr[$i-1] = $tmp;
            $i--;
        }
        printStep($arr, $iter);
    }
}

/* шелл */
function shellSort(&$arr, &$iter) {
    for ($gap = floor(count($arr)/2); $gap > 0; $gap = floor($gap/2)) {
        for ($i = $gap; $i < count($arr); $i++) {
            $temp = $arr[$i];
            $j = $i;
            while ($j >= $gap && $arr[$j-$gap] > $temp) {
                $arr[$j] = $arr[$j-$gap];
                $j -= $gap;
            }
            $arr[$j] = $temp;
            printStep($arr, $iter);
        }
    }
}

/* быстрая */
function quick(&$arr, $left, $right, &$iter) {
    $i = $left;
    $j = $right;
    $pivot = $arr[floor(($left+$right)/2)];

    while ($i <= $j) {
        while ($arr[$i] < $pivot) $i++;
        while ($arr[$j] > $pivot) $j--;

        if ($i <= $j) {
            $tmp = $arr[$i];
            $arr[$i] = $arr[$j];
            $arr[$j] = $tmp;
            $i++; $j--;
            printStep($arr, $iter);
        }
    }

    if ($left < $j) quick($arr, $left, $j, $iter);
    if ($i < $right) quick($arr, $i, $right, $iter);
}

/* ==== ВЫБОР ==== */

switch ($type) {
    case "bubble": bubble($arr, $iterations); break;
    case "selection": selection($arr, $iterations); break;
    case "gnome": gnome($arr, $iterations); break;
    case "shell": shellSort($arr, $iterations); break;
    case "quick": quick($arr, 0, count($arr)-1, $iterations); break;
    case "native":
        sort($arr);
        echo implode(", ", $arr);
        break;
}

$time = microtime(true) - $start;

echo "<h3>Сортировка завершена</h3>";
echo "Итераций: $iterations<br>";
echo "Время: $time сек";

include "footer.php";
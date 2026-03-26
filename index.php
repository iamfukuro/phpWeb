<?php
include 'layout.php';

/* ================= ОБРАБОТКА ФОРМЫ ================= */

if (isset($_POST['A'])) {

    // числа (поддержка запятой)
    $A = floatval(str_replace(',', '.', $_POST['A']));
    $B = floatval(str_replace(',', '.', $_POST['B']));
    $C = floatval(str_replace(',', '.', $_POST['C']));
    $user = str_replace(',', '.', $_POST['result']);

    // решение задачи
    switch ($_POST['TASK']) {

        case 'mean':
            $result = round(($A + $B + $C) / 3, 2);
            $task = "Среднее арифметическое";
            break;

        case 'perimetr':
            $result = $A + $B + $C;
            $task = "Периметр треугольника";
            break;

        case 'area':
            if ($A + $B > $C && $A + $C > $B && $B + $C > $A) {
                $p = ($A + $B + $C) / 2;
                $result = round(sqrt($p * ($p-$A) * ($p-$B) * ($p-$C)), 2);
            } else {
                $result = 0;
            }
            $task = "Площадь треугольника";
            break;

        case 'volume':
            $result = $A * $B * $C;
            $task = "Объем параллелепипеда";
            break;

        case 'max':
            $result = max($A, $B, $C);
            $task = "Максимум из трех чисел";
            break;

        case 'min':
            $result = min($A, $B, $C);
            $task = "Минимум из трех чисел";
            break;
    }

    // формируем отчет
    $out = "";
    $out .= "<div><b>ФИО:</b> " . $_POST['FIO'] . "</div>";
    $out .= "<div><b>Группа:</b> " . $_POST['GROUP'] . "</div>";

    if (!empty($_POST['ABOUT'])) {
        $out .= "<b>О себе:</b> " . $_POST['ABOUT'] . "<br><br>";
    }

    $out .= "<b>Задача:</b> $task<br>";
    $out .= "A = $A, B = $B, C = $C<br>";

    if ($user === "") {
        $out .= "Задача самостоятельно решена не была<br>";
    } else {
        $out .= "Ваш ответ: $user<br>";
    }

    $out .= "Ответ программы: $result<br>";

    if ($user !== "" && floatval($user) == $result) {
        $out .= "<b class='ok'>Тест пройден</b><br>";
    } else {
        $out .= "<b class='error'>Ошибка: тест не пройден</b><br>";
    }

echo "<div class='container'><div class='result'>$out</div></div>";

    // отправка email
    if (isset($_POST['send_mail'])) {
        mail(
            $_POST['MAIL'],
            "Результат теста",
            str_replace("<br>", "\n", $out),
            "Content-type: text/plain; charset=utf-8"
        );

        echo "<p class='info'>Результаты отправлены на: " . $_POST['MAIL'] . "</p>";
    }

    // кнопка повторить
    if ($_POST['VIEW'] == 'browser') {
        echo "<a class='btn' href='?FIO=" . $_POST['FIO'] . "&GROUP=" . $_POST['GROUP'] . "'>Повторить тест</a>";
    }

} else {

    // случайные числа
    $A = mt_rand(1, 100);
    $B = mt_rand(1, 100);
    $C = mt_rand(1, 100);

    $fio = $_GET['FIO'] ?? "";
    $group = $_GET['GROUP'] ?? "";
?>

<!-- ================= ФОРМА ================= -->

<form method="post" class="form">

<label>ФИО</label>
<input type="text" name="FIO" value="<?= $fio ?>">

<label>Группа</label>
<input type="text" name="GROUP" value="<?= $group ?>">

<label>A</label>
<input type="text" name="A" value="<?= $A ?>">

<label>B</label>
<input type="text" name="B" value="<?= $B ?>">

<label>C</label>
<input type="text" name="C" value="<?= $C ?>">

<label>Ваш ответ</label>
<input type="text" name="result">

<label>Задача</label>
<select name="TASK">
    <option value="mean">Среднее арифметическое</option>
    <option value="perimetr">Периметр треугольника</option>
    <option value="area">Площадь треугольника</option>
    <option value="volume">Объем параллелепипеда</option>
    <option value="max">Максимум из трех чисел</option>
    <option value="min">Минимум из трех чисел</option>
</select>

<label>О себе</label>
<textarea name="ABOUT"></textarea>

<label>
<input type="checkbox" name="send_mail" onclick="toggleEmail(this)">
Отправить результат на email
</label>

<div id="mailBox" style="display:none;">
    <label>Email</label>
    <input type="text" name="MAIL">
</div>

<label>Режим</label>
<select name="VIEW">
    <option value="browser">Для браузера</option>
    <option value="print">Для печати</option>
</select>

<button type="submit">Проверить</button>

</form>

<script>
function toggleEmail(el){
    document.getElementById('mailBox').style.display =
        el.checked ? 'block' : 'none';
}
</script>

<?php
}

include 'footer.php';
?>
<?php require_once 'layout.php'; ?>

<h2>Результат анализа</h2>

<?php

function analyzeText($text) {
// Заменяем переносы на пробелы
    $text = preg_replace('/\s+/', ' ', $text);

    $length = strlen($text);

    $letters = 0;
    $upper = 0;
    $lower = 0;
    $digits = 0;
    $punct = 0;

    $symbols = [];
    $words = [];

    $word = '';

    for ($i = 0; $i < $length; $i++) {

        $char = $text[$i];
        $ord = ord($char);

        // регистр (для подсчёта символов)
        $lowChar = strtolower($char);
        $symbols[$lowChar] = ($symbols[$lowChar] ?? 0) + 1;

        // ЛАТИНИЦА
        if (($ord >= 65 && $ord <= 90) || ($ord >= 97 && $ord <= 122)) {

            $letters++;

            if ($ord >= 65 && $ord <= 90) $upper++;
            else $lower++;

            $word .= $char;
        }
        // КИРИЛЛИЦА (CP1251 + Ё)
        elseif (($ord >= 192 && $ord <= 255) || $ord == 168 || $ord == 184) {

            $letters++;

            if (($ord >= 192 && $ord <= 223) || $ord == 168) $upper++;
            else $lower++;

            $word .= $char;
        }
        else {

            // цифры
            if ($ord >= 48 && $ord <= 57) $digits++;

            // знаки препинания
            if (strpos(".,!?;:()-\"«»", $char) !== false) $punct++;

            // конец слова
            if ($word != '') {
                $w = strtolower($word);
                $words[$w] = ($words[$w] ?? 0) + 1;
                $word = '';
            }
        }
    }

    // последнее слово
    if ($word != '') {
        $w = strtolower($word);
        $words[$w] = ($words[$w] ?? 0) + 1;
    }

    ksort($words);
    ksort($symbols);

    return [
        'length' => $length,
        'letters' => $letters,
        'upper' => $upper,
        'lower' => $lower,
        'digits' => $digits,
        'punct' => $punct,
        'words_count' => count($words),
        'symbols' => $symbols,
        'words' => $words
    ];
}

if (!isset($_POST['data']) || trim($_POST['data']) === '') {

    echo "<div class='error'>Нет текста для анализа</div>";

} else {

    // переводим в CP1251
    $text_cp = iconv("UTF-8", "CP1251", $_POST['data']);

    // вывод оригинала
    echo "<div class='source-text'>" . htmlspecialchars($_POST['data']) . "</div>";

    $res = analyzeText($text_cp);

    echo "<table class='result-table'>
        <tr><th>Параметр</th><th>Значение</th></tr>
        <tr><td>Количество символов</td><td>{$res['length']}</td></tr>
        <tr><td>Количество букв</td><td>{$res['letters']}</td></tr>
        <tr><td>Заглавные буквы</td><td>{$res['upper']}</td></tr>
        <tr><td>Строчные буквы</td><td>{$res['lower']}</td></tr>
        <tr><td>Цифры</td><td>{$res['digits']}</td></tr>
        <tr><td>Знаки препинания</td><td>{$res['punct']}</td></tr>
        <tr><td>Количество слов</td><td>{$res['words_count']}</td></tr>
    </table>";

    echo "<h3>Вхождения символов</h3>";
    echo "<table class='result-table'>";
    foreach ($res['symbols'] as $k => $v) {
        if ($k === ' ') {
            $display = 'Пробел';
        } else {
            $display = htmlspecialchars(iconv("CP1251", "UTF-8", $k));
        }

        echo "<tr><td>{$display}</td><td>$v</td></tr>";
    }
    echo "</table>";

    echo "<h3>Слова (по алфавиту)</h3>";
    echo "<table class='result-table'>";
    foreach ($res['words'] as $k => $v) {
        if ($k === ' ') {
            $display = 'Пробел';
        } else {
            $display = htmlspecialchars(iconv("CP1251", "UTF-8", $k));
        }

        echo "<tr><td>{$display}</td><td>$v</td></tr>";
    }
    echo "</table>";
}
?>


<br>
<a href="index.html" class="btn">Другой анализ</a>

<?php require_once 'footer.php'; ?>
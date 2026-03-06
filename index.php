<?php
$title = "Ильенков Иван Владленович, 241-351, ЛР 2 вар.6";
$current = "index";
include 'layout.php';
?>

<section class="card">
<h2>Вычисление функции (вариант 6)</h2>

<?php
    
$x = -10;           // начальное значение
$encounting = 30;   // количество вычислений
$step = 2;          // шаг
$type = 'E';        // тип верстки A–E

$min_value = -1000;
$max_value = 1000;

/* функция варианта 6 */
function f($x){

    if($x <= 10){
        return 0.33 * $x * $x + 4;
    }

    elseif($x < 20){
        return 18 * $x - 3;
    }

    else{
        $den = $x * 0.1 - 2;

        if(abs($den) < 0.000001){
            return "error";
        }

        return 1 / $den + 3;
    }

}

/* статистика */
$sum = 0;
$count = 0;
$min = null;
$max = null;

/* подготовка вывода */
if($type == 'B') echo "<ul>";
if($type == 'C') echo "<ol>";
if($type == 'D') echo "<table class='result-table'><tr><th>#</th><th>x</th><th>f(x)</th></tr>";
if($type == 'E') echo "<div>";

$currentX = $x;

/* цикл */
for($i=0; $i<$encounting; $i++){

    $value = f($currentX);

    if($value !== "error"){
        $value = round($value,3);

        $sum += $value;
        $count++;

        if($min === null || $value < $min) $min = $value;
        if($max === null || $value > $max) $max = $value;
    }

    $text = "f($currentX) = $value";

    if($type == 'A'){
        echo $text."<br>";
    }

    elseif($type == 'B'){
        echo "<li>$text</li>";
    }

    elseif($type == 'C'){
        echo "<li>$text</li>";
    }

    elseif($type == 'D'){
        echo "<tr><td>".($i+1)."</td><td>$currentX</td><td>$value</td></tr>";
    }

    elseif($type == 'E'){
        echo "<div style='border:2px solid red;padding:6px;margin:4px;display:inline-block'>$text</div>";
    }

    if($value !== "error"){
        if($value >= $max_value || $value < $min_value){
            break;
        }
    }

    $currentX += $step;

}

if($type == 'B') echo "</ul>";
if($type == 'C') echo "</ol>";
if($type == 'D') echo "</table>";
if($type == 'E') echo "</div>";

echo "<hr>";

echo "<h3>Статистика</h3>";

if($count > 0){

    $avg = round($sum/$count,3);

    echo "Количество значений: $count <br>";
    echo "Сумма: ".round($sum,3)."<br>";
    echo "Минимум: $min <br>";
    echo "Максимум: $max <br>";
    echo "Среднее: $avg <br>";

}else{
    echo "Нет корректных значений";
}

?>

</section>

<?php include 'footer.php'; ?>
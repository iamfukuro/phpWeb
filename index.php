<?php
$title = "Ильенков Иван Владленович, 241-351, ЛР 4 вар.6";
$current = "index";
include 'layout.php';
?>

<section class="card">

<?php

/* количество колонок */
$columns = 3;

/* массив структур таблиц (минимум 10) */
$structures = array(
"A*B*C#D*E*F",
"1*2*3#4*5*6",
"PHP*HTML*CSS#JS*SQL*API",
"Cat*Dog*Bird",
"Red*Green*Blue#Black*White*Gray",
"A1*A2*A3#B1*B2*B3",
"X*Y*Z",
"One*Two*Three#Four*Five*Six",
"Apple*Banana*Orange",
"Table*Row*Cell"
);


/* функция формирования строки таблицы */
function getTR($data, $columns)
{
    $cells = explode('*', $data);

    if(count($cells) == 0 || $cells[0] == '')
        return '';

    $html = "<tr>";

    for($i = 0; $i < $columns; $i++)
    {
        if(isset($cells[$i]))
            $html .= "<td>".$cells[$i]."</td>";
        else
            $html .= "<td></td>";
    }

    $html .= "</tr>";

    return $html;
}


/* функция вывода таблицы */
function outTable($structure, $columns)
{
    $rows = explode('#', $structure);

    if(count($rows) == 0)
    {
        echo "В таблице нет строк";
        return;
    }

    $tableRows = "";

    for($i = 0; $i < count($rows); $i++)
    {
        $tr = getTR($rows[$i], $columns);

        if($tr != "")
            $tableRows .= $tr;
    }

    if($tableRows == "")
    {
        echo "В таблице нет строк с ячейками";
        return;
    }

    echo "<table border='1'>";
    echo $tableRows;
    echo "</table>";
}


/* проверка количества колонок */
if($columns == 0)
{
    echo "Неправильное число колонок";
}
else
{
    /* вывод всех таблиц */
    for($i = 0; $i < count($structures); $i++)
    {
        echo "<h2>Таблица №".($i+1)."</h2>";
        outTable($structures[$i], $columns);
    }
}

?>

</section>

<?php 
include 'footer.php'; 
?>
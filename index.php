<?php
$title = "ЛР5 — Таблица умножения";
$current = "index";
include 'layout.php';

$html_type = $_GET['html_type'] ?? null;
$content = $_GET['content'] ?? null;
?>

<div class="lab-container">

<!-- БОКОВОЕ МЕНЮ -->
<aside class="sidebar">
    <a href="?" class="<?php if(!$content) echo 'active'; ?>">Всё</a>

    <?php for($i=2;$i<=9;$i++): ?>
        <a href="?content=<?php echo $i; ?><?php if($html_type) echo '&html_type='.$html_type; ?>"
           class="<?php if($content == $i) echo 'active'; ?>">
            Таблица на <?php echo $i; ?>
        </a>
    <?php endfor; ?>
</aside>

<!-- ОСНОВНОЙ КОНТЕНТ -->
<section class="lab-content">

<?php

function outNumAsLink($x){
    global $html_type;

    $link = '?content='.$x;


    // $link .= '&html_type='.$html_type;

    if($x <= 9)
        return '<a href="'.$link.'">'.$x.'</a>';

    return $x;
}

function outRow($n){
    for($i=2;$i<=9;$i++){
        echo outNumAsLink($n).' × '.outNumAsLink($i).' = '.outNumAsLink($n*$i).'<br>';
    }
}

function outTable($content){
    echo "<table class='table'>";
    
    if(!$content){
        echo "<tr>";
        for($i=2;$i<=9;$i++){
            echo "<td>";
            outRow($i);
            echo "</td>";
        }
        echo "</tr>";
    } else {
        echo "<tr><td>";
        outRow($content);
        echo "</td></tr>";
    }

    echo "</table>";
}

function outDiv($content){
    if(!$content){
        for($i=2;$i<=9;$i++){
            echo "<div class='block'>";
            outRow($i);
            echo "</div>";
        }
    } else {
        echo "<div class='block'>";
        outRow($content);
        echo "</div>";
    }
}

if(!$html_type || $html_type == 'TABLE')
    outTable($content);
else
    outDiv($content);

?>

</section>
</div>

<?php include 'footer.php'; ?>
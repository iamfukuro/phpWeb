<?php
$title = "Ильенков Иван Владленович, 241-351, ЛР 3 вар.6";
$current = "index";
include 'layout.php';
?>

<section class="card">

<?php

/* если предыдущего значения нет — создаем */
if(!isset($_GET['store']))
    $_GET['store'] = '';

/* если нажата кнопка */
else if(isset($_GET['key']))
    $_GET['store'] .= $_GET['key'];

$result = $_GET['store'];


/* ===== СЧЕТЧИК НАЖАТИЙ ===== */

/* если счетчик уже есть */
if(isset($_GET['counter']))
    $clicks = (int)$_GET['counter'];
else
    $clicks = 0;

/* если нажата кнопка — увеличиваем */
if(isset($_GET['key']))
    $clicks++;

?>

<div class="result">
<?php echo $result; ?>
</div>

<div class="keyboard">

<a href="?key=1&store=<?php echo $result; ?>&counter=<?php echo $clicks; ?>">1</a>
<a href="?key=2&store=<?php echo $result; ?>&counter=<?php echo $clicks; ?>">2</a>
<a href="?key=3&store=<?php echo $result; ?>&counter=<?php echo $clicks; ?>">3</a>
<a href="?key=4&store=<?php echo $result; ?>&counter=<?php echo $clicks; ?>">4</a>
<a href="?key=5&store=<?php echo $result; ?>&counter=<?php echo $clicks; ?>">5</a>

<a href="?key=6&store=<?php echo $result; ?>&counter=<?php echo $clicks; ?>">6</a>
<a href="?key=7&store=<?php echo $result; ?>&counter=<?php echo $clicks; ?>">7</a>
<a href="?key=8&store=<?php echo $result; ?>&counter=<?php echo $clicks; ?>">8</a>
<a href="?key=9&store=<?php echo $result; ?>&counter=<?php echo $clicks; ?>">9</a>
<a href="?key=0&store=<?php echo $result; ?>&counter=<?php echo $clicks; ?>">0</a>

<a class="reset" href="index.php?counter=<?php echo $clicks; ?>">СБРОС</a>

</div>

</section>

<?php 
$clicksCount = $clicks;
include 'footer.php'; 
?>
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

/* считаем нажатия */
$clicks = strlen($result);

?>

<div class="result">
<?php echo $result; ?>
</div>

<div class="keyboard">

<a href="?key=1&store=<?php echo $result; ?>">1</a>
<a href="?key=2&store=<?php echo $result; ?>">2</a>
<a href="?key=3&store=<?php echo $result; ?>">3</a>
<a href="?key=4&store=<?php echo $result; ?>">4</a>
<a href="?key=5&store=<?php echo $result; ?>">5</a>

<a href="?key=6&store=<?php echo $result; ?>">6</a>
<a href="?key=7&store=<?php echo $result; ?>">7</a>
<a href="?key=8&store=<?php echo $result; ?>">8</a>
<a href="?key=9&store=<?php echo $result; ?>">9</a>
<a href="?key=0&store=<?php echo $result; ?>">0</a>

<a class="reset" href="index.php">СБРОС</a>

</div>

<p>Количество нажатий: <?php echo $clicks; ?></p>

</section>

<?php include 'footer.php'; ?>
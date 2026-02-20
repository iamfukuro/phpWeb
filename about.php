<?php
$current = "about";
include 'layout.php';
?>

<section class="card">
    <h2>О сайте</h2>

    <p>
        Этот сайт посвящён последним новостям Формулы 1.
        Здесь публикуются результаты гонок, аналитика этапов
        и статистические данные чемпионата.
    </p>
</section>

<aside class="gallery">
    <h3>Галерея</h3>

    <?php
        $sec = date("s");
        $photo1 = ($sec % 2 == 0) ? "images/photo1.jpg" : "images/photo2.jpg";
        $photo2 = ($sec % 2 == 0) ? "images/photo3.jpg" : "images/photo4.jpg";
    ?>

    <figure class="photo">
        <img src="<?php echo $photo1; ?>" alt="Фото 1">
    </figure>

    <figure class="photo">
        <img src="<?php echo $photo2; ?>" alt="Фото 2">
    </figure>
</aside>

<?php include 'footer.php'; ?>
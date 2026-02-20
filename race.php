<?php
$current = "race";
include 'layout.php';
?>

<section class="card">
    <h2>Детальная классификация</h2>

    <table class="result-table">
        <tr>
            <th>Позиция</th>
            <th>Пилот</th>
            <th>Команда</th>
            <th>Fastest lap</th>
            <th>Очки</th>
        </tr>

        <tr>
            <td><?php echo "1"; ?></td>
            <td><?php echo "Max Verstappen"; ?></td>
            <td><?php echo "Red Bull Racing"; ?></td>
            <td><?php echo "-"; ?></td>
            <td><?php echo "25"; ?></td>
        </tr>

        <tr>
            <td><?php echo "2"; ?></td>
            <td><?php echo "Oscar Piastri"; ?></td>
            <td><?php echo "McLaren"; ?></td>
            <td><?php echo "-"; ?></td>
            <td><?php echo "18"; ?></td>
        </tr>

        <tr>
            <td><?php echo "3"; ?></td>
            <td><?php echo "Lando Norris"; ?></td>
            <td><?php echo "McLaren"; ?></td>
            <td><?php echo "1:26.725"; ?></td>
            <td><?php echo "15"; ?></td>
        </tr>
    </table>

    <p>
        Самый быстрый круг показал Lando Norris — 1:26.725.
        Борьба за подиум продолжалась до последних кругов.
    </p>
</section>

<aside class="gallery">
    <h3>Фото гонки</h3>

    <?php
    $sec = date("s");
    $photo1 = ($sec % 2 == 0) ? "images/photo1.jpg" : "images/photo2.jpg";
    $photo2 = ($sec % 2 == 0) ? "images/photo3.jpg" : "images/photo4.jpg";
    ?>

    <figure class="photo">
        <img src="<?php echo $photo1; ?>" alt="Фото гонки 1">
    </figure>

    <figure class="photo">
        <img src="<?php echo $photo2; ?>" alt="Фото гонки 2">
    </figure>
</aside>

<?php include 'footer.php'; ?>
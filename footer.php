</main>

<footer class="site-footer">
    <div class="footer-inner container">
        <?php
        // Вывод истории вычислений (только если есть записи)
        if (!empty($_SESSION['history'])) {
            echo '<div class="history-block">';
            echo '<h4>История вычислений</h4>';
            foreach ($_SESSION['history'] as $historyLine) {
                echo '<div class="history-line">' . htmlspecialchars($historyLine) . '</div>';
            }
            echo '</div>';
        }
        ?>

        <p>
            <?php echo date('d.m.Y H:i:s'); ?>
        </p>
    </div>
</footer>

</body>
</html>
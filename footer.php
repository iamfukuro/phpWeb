</main>

<footer class="site-footer">
    <div class="footer-inner container">
        <?php
        $html_type = $_GET['html_type'] ?? null;
        $content = $_GET['content'] ?? null;

        if(!$html_type || $html_type == 'TABLE')
            $type = "Табличная верстка";
        else
            $type = "Блочная верстка";

        if(!$content)
            $view = "Вся таблица";
        else
            $view = "Таблица на ".$content;
        ?>

        <p>
            <?php echo $type . " | " . $view; ?><br>
            <?php echo date('d.m.Y H:i:s'); ?><br>
        </p>
    </div>
</footer>

</body>
</html>
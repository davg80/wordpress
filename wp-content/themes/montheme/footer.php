</div>
<footer>
    <?php wp_nav_menu([
        'theme_location' => 'footer',
        'container' => false,
        'menu_class' => 'navbar-nav me-auto mb-2 mb-lg-0'
    ]);
    the_widget(YoutubeWidget::class, ['youtube' => 'eUAd5f936Yg' ], ['after_widget' => '', 'before_widget' => '']);

    ?>
</footer>
<div>
    <?=  get_option('agence_horaire') ?>
</div>
<?php wp_footer() ?>
</body>
</html>
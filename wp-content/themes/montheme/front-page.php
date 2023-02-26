<?php get_header(); ?>
<?php  while (have_posts()) : the_post(); ?>
    <h1><?php  the_title() ?></h1>
    <?php  the_content(); ?>
    <a href="<?= get_post_type_archive_link('post') ?>">Voir les dernières actualités</a>
<?php endWhile; ?>
<?php get_footer(); ?>



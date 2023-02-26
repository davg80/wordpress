<?php get_header() ?>

<?php if (have_posts()): while (have_posts()): the_post() ?>
	<h1><?php the_title() ?></h1>
	<p><img src="<?php the_post_thumbnail_url(); ?>" class="img-fluid img-thumbnail" alt="<?php the_title() ?>"></p>
	<p><?php the_content(); ?></p>
<?php endwhile; endif; ?>
<?php get_footer() ?>

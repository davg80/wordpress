<?php get_header() ?>
	<h1>Voir tous nos biens</h1>

<?php if (have_posts()): ?>
	<div class="row mt-4">
		<?php while (have_posts()): the_post() ?>
			<div class="col-sm-4">
				<?php  get_template_part('partials/card', 'post') ?>
			</div>
		<?php endwhile; ?>
		<?php monTheme_pagination(); ?>
	</div>
<?php else: ?>
	<h1>Pas d'articles</h1>
<?php endif; ?>
<?php get_footer() ?>
<div class="card" style="width: 18rem;height: 450px;">
	<img src="<?php the_post_thumbnail_url('post-thumbnail'); ?>" class="card-img-top" alt="<?php the_title(); ?>">
	<div class="card-body position-relative">
		<h5 class="card-title"><?php the_title() ?></h5>
		<h6 class="card-subtitle mb-2 text-muted"><?php the_category(); ?></h6>
		<ul>
			<?php the_terms(get_the_ID(), 'sport', '<li>', '</li><li>', '</li>') ?>
		</ul>
		<p class="card-text"><?php the_excerpt(); ?></p>
		<a href="<?php the_permalink(); ?>" class="btn btn-primary position-absolute bottom-0 start-50 translate-middle">Voir plus</a>
	</div>
</div>
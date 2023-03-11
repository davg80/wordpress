<?php get_header() ?>

<?php if ( have_posts() ): while ( have_posts() ): the_post() ?>
    <h1><?php the_title() ?></h1>
	<?php if ( get_post_meta( get_the_ID(), SponsorMetaBox::META_KEY, true ) ): ?>
        <div class="alert alert-info">
            Cet article est sponsorisé.
        </div>
	<?php endif; ?>
    <p><img src="<?php the_post_thumbnail_url(); ?>" class="img-fluid img-thumbnail" alt="<?php the_title() ?>"></p>
    <p><?php the_content(); ?></p>
    <h2>Articles relatifs</h2>
    <div class="row mt-4">
		<?php
		// Find sport by id
		$sports = array_map( function ( $term ) {
			return $term->term_id;
		}, get_the_terms( get_post(), 'sport' ) );

		$query = new WP_Query( [
			'post__not_in'   => [ get_the_ID() ],
			'post_type'      => 'post',
			'posts_per_page' => 3,
			'orderby '       => 'rand',
			'tax_query'      => [
				[
					'taxonomy' => 'sport',
					'terms'    => $sports,
				],
			],
		] );
		while ( $query->have_posts() ): $query->the_post();
			?>
            <div class="col-sm-4">
				<?php get_template_part( 'partials/card', 'post' ) ?>
            </div>
		<?php endwhile;
		wp_reset_postdata(); ?>
    </div>
<?php endwhile; endif; ?>
<?php get_footer() ?>

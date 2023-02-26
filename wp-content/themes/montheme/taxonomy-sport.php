<?php get_header() ?>

<?php $term = get_queried_object(); ?>
<h1><?= esc_html($term->name) ?></h1>
<p><?= esc_html($term->description) ?></p>

<?php $sports = get_terms(['taxonomy' => 'sport']) ?>
<?php if (is_array($sports)): ?>
    <ul class="nav nav-pills my-4">
        <?php foreach ($sports as $sport): ?>
            <li class="nav-item">
                <a href="<?= get_term_link($sport) ?>"
                   class="nav-link <?= is_tax('sport', $sport->term_id) ? 'active' : '' ?>"><?= $sport->name ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if (have_posts()): ?>
    <div class="row mt-4">
        <?php while (have_posts()): the_post() ?>
            <div class="col-sm-4">
                <div class="card" style="width: 18rem;">
                    <img src="<?php the_post_thumbnail_url('post-thumbnail'); ?>" class="card-img-top"
                         alt="<?php the_title(); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php the_title() ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?php the_category(); ?></h6>
                        <ul>
                            <?php the_terms(get_the_ID(), 'sport', '<li>', '</li><li>', '</li>') ?>
                        </ul>
                        <p class="card-text"><?php the_excerpt(); ?></p>
                        <a href="<?php the_permalink(); ?>" class="btn btn-primary">Voir plus</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
        <?php monTheme_pagination(); ?>
    </div>
<?php else: ?>
    <h1>Pas d'articles</h1>
<?php endif; ?>
<?php get_footer() ?>

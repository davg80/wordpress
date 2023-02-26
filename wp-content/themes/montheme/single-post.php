<?php get_header() ?>

<?php if (have_posts()): while (have_posts()): the_post() ?>
    <h1><?php the_title() ?></h1>
    <?php  if(get_post_meta(get_the_ID(), SponsorMetaBox::META_KEY, true)): ?>
        <div class="alert alert-info">
            Cet article est sponsorisé.
        </div>
    <?php  endif; ?>
    <p><img src="<?php the_post_thumbnail_url(); ?>" class="img-fluid img-thumbnail" alt="<?php the_title() ?>"></p>
    <p><?php the_content(); ?></p>
<?php endwhile; endif; ?>
<?php get_footer() ?>

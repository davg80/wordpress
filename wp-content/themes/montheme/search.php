<?php get_header() ?>
<form class="row gy-2 gx-3 align-items-center">
    <div class="col-auto">
        <input type="search" name="s" class="form-control" id="autoSizingInput" value="<?= get_search_query() ?>" placeholder="Votre recherche">
    </div>
    <div class="col-auto">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" name="sponsor" id="autoSizingCheck" <?= checked('1', get_query_var('sponsor')) ?>">
            <label class="form-check-label" for="autoSizingCheck" >
               Article sponsorisé seulement
            </label>
        </div>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">Rechercher</button>
    </div>
</form>
<h1 class="mb-4">Résultat pour votre recherche "<?= get_search_query() ?>"</h1>
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

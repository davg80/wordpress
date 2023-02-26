<form class="d-flex" role="search" action="<?php  esc_url(home_url('/')); ?>">
    <input class="form-control me-2" name="s" type="search" placeholder="Recherche" aria-label="Search" value="<?=  get_search_query() ?>">
    <button class="btn btn-light" type="submit">Rechercher</button>
</form>
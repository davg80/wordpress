<?php
declare(strict_types=1);

function monTheme_supports(): void
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
    register_nav_menu('header', 'Entête du menu');
    register_nav_menu('footer', 'Pied de page');

    add_image_size('post-thumbnail', 350, 215, true);
}

function monTheme_register_assets(): void
{
    wp_register_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css');
    wp_register_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js', [], false, true);
    wp_enqueue_style('bootstrap');
    wp_enqueue_script('bootstrap');
}

/**
 * functions
 */

function monTheme_title_separator(): string
{
    return '|';
}

function monTheme_menu_class($classes): array
{
    $classes[] = 'nav-item';
    return $classes;
}

function monTheme_menu_link_class($attrs): array
{
    $attrs['class'] = 'nav-link';
    return $attrs;
}

function monTheme_pagination()
{
    $pages = paginate_links(['type' => 'array']);
    if($pages === null) {
        return;
    }
    echo '<nav aria-label="Pagination" class="my-4">';
    echo '<ul class="pagination">';
    foreach ($pages as $page) {
        $active = strpos($page, 'current') !== false;
        $class = 'page-item';
        if ($active) {
            $class .= ' active';
        }
        echo '<li class="' . $class . '">';
        echo str_replace('page-numbers', 'page-link', $page);
        echo '</li>';
    }
    echo '</ul>';
    echo '</nav>';
}

function monTheme_init() {
	register_taxonomy('sport', 'post', [
		'labels' => [
			'name' => 'Sport',
			'singular_name' => 'Sport',
			'plural_name' => 'Sports',
			'search_items'=> 'Rechercher des sports',
			'all_items' => 'Tous les sports',
			'edit_item'=> 'Editer un sport',
			'update_item' => 'Mettre à jour le sport',
			'add_new_item' => 'Ajouter un nouveau sport',
			'new_item_name' => 'Ajouter un nouveau sport',
			'menu_name' => 'Sport'
		],
		'show_in_rest' => true,
		'hierarchical' => true,
		'show_admin_column' => true
	]);
	register_post_type('bien', [
		'label' => 'Bien',
		'public' => true,
		'menu_position' => 3,
		'menu_icon' => 'dashicons-building',
		'supports' => ['title', 'editor', 'thumbnail' ],
		'show_in_rest' => true,
		'has_archive' => true
	]);
}
/**
 * Actions
 */
add_action('after_setup_theme', 'monTheme_supports');
add_action('wp_enqueue_scripts', 'monTheme_register_assets');
add_action('init', 'monTheme_init');

/**
 * Filter
 */
add_filter('document_title_separator', 'monTheme_title_separator');
add_filter('nav_menu_css_class', 'monTheme_menu_class');
add_filter('nav_menu_link_attributes', 'monTheme_menu_link_class');

require_once( 'metaboxes/sponsor.php' );
require_once ('options/agence.php');
SponsorMetaBox::register();
AgenceMenuPage::register();


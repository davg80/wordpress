# Création d'un thème Wordpress

## Dossier obligatoire
- Dans wp-content/themes
  - 1-Création d'un dossier
  - 2-Ajout des fichiers obligatoires : 
  - | index.php
  - | style.css avec le nom du thème 
  - | screenshot.png pour le visuel dans wordpress
- Puis Activer le thème et se rendre dans localhost:8000

## Découpage du header et du footer
- Mettre les fonctions get_header() et get_footer()

_header.php_
```php
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title> //supprimer pour que la fonction add_theme_support fonctionne
    <?php wp_head() ?>
</head>
<body>
```

_footer.php_
```php
    <?php wp_footer() ?>
</body>
</html>
```
Lien des références de la documentation Wordpress [Wordpress-references](https://developer.wordpress.org/reference/).

## Les fonctions utiles
add_theme_support() => Permet de rajouter des fonctionnalités

## Hooks
- Ils permettent de rajouter des actions avec add_action
```php
add_action('nom_du_hook', function () {
     // Action à faire
}, //priorité optionnelle = est un nombre entre 1 et 10: plus c'est petit plus la priorité est importante)
```


_functions.php_
```php
<?php
function monTheme_supports(): void
{
    add_theme_support('title-tag');// Permet de rendre le titre de l'onglet dynamique
}

// Actions
add_action( 'after_setup_theme', 'monTheme_supports');

```

## Enregistrer le style

```php
function monTheme_register_assets(): void
{
    // Enregistre
    wp_register_style('bootstrap', "https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css");
    // Ajoute à l'utilisation
    wp_enqueue_style('bootstrap');
}

add_action('wp_enqueue_scripts', 'monTheme_register_assets');   
```
_example_
```php
function monTheme_register_assets(): void
{
    wp_register_style('bootstrap', "https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css");
  wp_register_script('bootstrap', "https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js", ['popper'], false, true);
    wp_register_script('popper', "https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js", [], false, true); // Permet de mettre dans le footer avec le true
    wp_deregister_script('jquery'); // Pour enlever ou écraser un chargement par défaut
    wp_enqueue_style('bootstrap');
    wp_enqueue_script('bootstrap');
}
// Actions
add_action( 'after_setup_theme', 'monTheme_supports');
add_action('wp_enqueue_scripts', 'monTheme_register_assets');
```

## Les filtres
Permet d'altérer les valeurs par défaut en valeur que l'on a choisi
_ATTENTION_ Un filtre doit toujours retourné quelque chose
```php
//index.php
<?php get_header() ?>
    Bonjour les gens: <?php wp_title() ?>
<?php get_footer() ?>
```
```php
// functions.php
function monTheme_title($title): string
{
    return 'Test';
}

function monTheme_document_title_parts($title)
{
    var_dump($title);die(); // array(2) { ["title"]=> string(18) "reveille-ta-moelle" ["tagline"]=> string(0) "" }
}

// Filters
add_filter('wp_title', 'monTheme_title');
add_filter('document_title_parts', 'monTheme_document_title_parts');
```
## La boucle dans wordpress

- Pour afficher les articles (pages), on a une boucle avec des fonctions déjà déclarés
- Ils sont déjà triés du plus récent au moins récent
- _IMPORTANT_ => Pour éviter la boucle infini, il ne faut pas oublier de mettre the_post() après le while
- Lien des articles [les articles](http://localhost:8000/wp-admin/edit.php).
```php
 <?php if(have_posts()): ?>
      <ul>
      <?php while(have_posts()): the_post();?>
          <li><?php the_title() ?></li>
      <?php endwhile; ?>
      </ul>
 <?php else: ?>
      <h1>Pas d'articles</h1>
 <?php endif; ?>
 /*
    . Mon article de test
    . Bonjour tout le monde !
 */

```
## Exemple de débuggage
```php
 <?php if(have_posts()): ?>
        <ul>
        <?php while(have_posts()): the_post();?>
            <?php
            global $post;
            global $wp_query;
            var_dump($post);
            var_dump($wp_query);
            die;
            ?>
            ?>
            <li>
                <a href="<?php the_permalink(); ?>" ><?php the_title() ?> - <?php the_author() ?></a>
            </li>
        <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <h1>Pas d'articles</h1>
 <?php endif; ?>
```
## Mise en page des articles avec le contenu (the_content())
```php
 <?php if(have_posts()): ?>
        <?php while(have_posts()): the_post();?>
          <div class="card" style="width: 18rem;">
              <div class="card-body">
                  <h5 class="card-title"><?php the_title()?></h5>
                  <h5 class="card-subtitle mb-2 text-muted"><?php the_category()?></h5>
                  <p class="card-text"><?php the_content('En voir plus') ?></p>
                  <a href="<?php the_permalink(); ?>" class="btn btn-primary">Voir plus</a>
              </div>
          </div>
        <?php endwhile; ?>
    <?php else: ?>
        <h1>Pas d'articles</h1>
    <?php endif; ?>
```


## Mise en page des articles avec l'extrait (the_excerpt())
```php
<?php if(have_posts()): ?>
         <?php while(have_posts()): the_post();?>
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title"><?php the_title(); ?></h5>
                    <h5 class="card-subtitle mb-2 text-muted"><?php the_category(); ?></h5>
                    <p class="card-text"><?php the_excerpt(); ?></p>
                    <a href="<?php the_permalink(); ?>" class="btn btn-primary">Voir plus</a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <h1>Pas d'articles</h1>
    <?php endif; ?>
```
## Mise en place d'une image dans la card
```php
//functions.php
function monTheme_supports(): void
{
    //...
    add_theme_support('post-thumbnails');
}

```
- Il existe 3 formats de tailles = miniatures, medium, large  
```php
//index.php
<?php if(have_posts()): ?>
        <div class="row">
         <?php while(have_posts()): the_post();?>
            <div class="col-sm-4">
                <div class="card" style="width: 18rem;">
                <!-- image -->
                <?php the_post_thumbnail('medium', ['class' => 'card-img-top', 'alt' => '', 'style' => 'height: auto;']) ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php the_title(); ?></h5>
                        <h5 class="card-subtitle mb-2 text-muted"><?php the_category(); ?></h5>
                        <p class="card-text"><?php the_excerpt(); ?></p>
                        <a href="<?php the_permalink(); ?>" class="btn btn-primary">Voir plus</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
        </div>
    <?php else: ?>
        <h1>Pas d'articles</h1>
    <?php endif; ?>

```
## La hierarchie des templates
- La hierarchie des templates [les templates](https://developer.wordpress.org/themes/basics/template-hierarchy/).
- Elle permet de savoir quel type de template il faut créer pour une page de post par exemple

_Exemple de single-post.php_
```php
<?php get_header() ?>

    <?php if(have_posts()): while(have_posts()) : the_post(); ?>
               <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
    <?php endwhile;
    endif; ?>
    
<?php get_footer() ?>
```
## Gestion des pages
Création de pages dans Pages => ajouter => donner un titre et publier
- Accueil
- Actualités
Réglages => lecture => la page d'accueil affiche une page statique 
    => sélectionner les pages accueil et actualités
- Et enregistrer les modifications
//front-page.php
```php
<?php get_header(); ?>
<?php if (have_posts()): while (have_posts()) : the_post(); ?>
    <h1><?php the_title(); ?></h1>
    <?php the_content(); ?>
    <a href="<?= get_post_type_archive_link('post'); ?>">Voir les dernières actualités</a>
<?php endwhile; endif; ?>
<?php get_footer(); ?>

```

## Navigation
- Apparence -> Menus:
- Cliquer sur Tout voir => Nom du menu et cocher En tête de menu
- Selectionner les pages et ajouter au menu
- enregistrer les modifications

// functions.php
```php
    add_theme_support('menus');
    register_nav_menu('header', 'En tête du menu');

function monTheme_menu_class(array $classes): array
{
    //var_dump(func_get_args());
    //die();
    $classes[] = 'nav-item';
    return $classes;
}
function monTheme_menu_link_class(array $attrs): array
{
    $attrs['class'] = 'nav-link';
    return $attrs;
}

//Filters
add_filter('nav_menu_css_class', 'monTheme_menu_class');
add_filter('nav_menu_link_attributes', 'monTheme_menu_link_class');
```
```php
// header.php
// Par défaut, il met une div si on veut un ul, on met à false 
// ...
<?php wp_nav_menu([
        'theme_location' => 'header',
        'container' => false,
        'menu_class' => 'navbar-nav me-auto mb-2 mb-lg-0'
]) ?>
```

## Debugger 
Permet de debugger et connaître l'utilisation du framework
```php
function monTheme_menu_class()
{
    var_dump(func_get_args());
    die();
    /**
 * array(1) { [0]=> array(9) { 
 * [1]=> string(9) "menu-item" 
 * [2]=> string(24) "menu-item-type-post_type" 
 * [3]=> string(21) "menu-item-object-page" 
 * [4]=> string(14) "menu-item-home" 
 * [5]=> string(17) "current-menu-item" 
 * [6]=> string(9) "page_item" 
 * [7]=> string(12) "page-item-17" 
 * [8]=> string(17) "current_page_item" 
 * [9]=> string(12) "menu-item-27" } }
 */
}

```

## Formulaire de recherche

_header.php_
```php
<!-- Formulaire de recherche -->
<?= get_search_form() ?>
```
_searchform.php_
```php
<form class="d-flex" role="search" action="<?= esc_url(home_url('/')) ?>">
    <input class="form-control me-2" name="s" type="search" placeholder="Recherche" aria-label="Search" value="<?= get_search_query(); ?>">
    <button class="btn btn-light text-dark me-2 border" type="submit">Rechercher</button>
</form>
```
## Réécriture des URL
- administration -> réglages -> permaliens -> titre de la publication -> enregistrer les modifications
- Permet de faire fonctionner la navigation et donne les url http://localhost:8000/actualites/

# Pagination
Administration -> Réglages -> Lecture

_méthode1_
```php
// Pagination => 1 2 Suivant »
<?php the_posts_pagination(); ?> 
```
_méthode2_
```php
// Pagination => 1 2 Suivant »
<?= paginate_links(); ?> 
```
_méthode3_
```php
// liens => précédent ou suivant de plusieurs articles
 <?= next_posts_link(); ?>
 <?= previous_posts_link(); ?>
```

```php
 // lien pour le single-post vers l'article suivant ou précédent
 previous_post_link();
next_post_link();
```
# Pagination personnalisée

_index.php_
```php
   <?php monTheme_pagination(); ?>
```

_functions.php_
```php
  function monTheme_pagination(): void
{
    $pages = paginate_links(['type' => 'array']);
    if ($pages === null) {
        return;
    }
    echo '<nav aria-label="Pagination" class="my-4">';
    echo '<ul class="pagination">';
    // Tableau de lien
    foreach ($pages as $page) {
        $active = str_contains($page, 'current');
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

```
# Création d'un modèle de page
- administration -> Pages ->  cliquez sur la page -> modèle -> choix de template
_template-banner.php_
```php
<?php
/**
 * Template Name: Page avec bannière
 *  Template Post Type: page, post
 */
?>

```

# Format d'images
- Les formats d'images [les images](C:\Users\Guillin\CodeLab\wordpress\wp-content\uploads\2023\02).
- ***Ajout d'un nouveau format d'images***

_function monTheme_supports()_
```php
add_image_size('card_header', 350, 215,true);
remove_image_size('medium'); // Si le format ne plait pas, puis le redéfinir
add_image_size('medium', 650, 430); 
```
```php
<div class="col">
    <div class="card mx-2 my-2" style="width: 18rem;">
    <?php the_post_thumbnail('card_header', ['class' => 'card-img-top', 'alt' => '', 'style' => 'height: 200px;']) ?>
        <div class="card-body">
            <h5 class="card-title"><?php the_title(); ?></h5>
            <h5 class="card-subtitle mb-2 text-muted"><?php the_category(); ?></h5>
            <p class="card-text"><?php the_excerpt(); ?></p>
            <a href="<?php the_permalink(); ?>" class="btn btn-primary">Voir plus</a>
        </div>
    </div>
</div>
```
***Ajouter une extension***

Administration -> Extensions -> Ajouter -> (Regenerate Thumbnails)
- Recrée les miniatures pour une ou plusieurs de vos images téléversées. 
- Utile si vous changez de tailles d'images ou de thème.
- Dans outils -> ***regenerer les miniatures d'images***

# Les métadonnées

```php
<?php

class SponsorMetaBox
{

    const META_KEY = 'mon_theme_sponsor';
    const NONCE = '_mon_theme_sponsor_nonce';

    public static function register()
    {
        add_action('add_meta_boxes', [self::class, 'add'], 10, 2);
        add_action('save_post', [self::class, 'save']);
    }

    public static function add($postType, $post)
    {
        if ($postType === 'post' && current_user_can('publish_posts', $post)) {
            add_meta_box(self::META_KEY, 'sponsoring', [self::class, 'render'], 'post', 'side');
        }
    }

    public static function render($object_post)
    {
        $value = get_post_meta($object_post->ID, self::META_KEY, true);
        //Clé csrf
        wp_nonce_field(self::NONCE, self::NONCE);
        ?>
        <input type="hidden" value="0" name="<?= self::META_KEY ?>">
        <input type="checkbox" value="1" name="<?= self::META_KEY ?>" <?= $value === '1' ? 'checked' : '' ?>>
        <label for="mon_theme_sponsor">Cet article est sponsorisé ?</label>
        <?php
    }

    public static function save($post)
    {
//        Verification de l'utilisateur et du NONCE (csrf)
        if (
            array_key_exists(self::META_KEY, $_POST) &&
            current_user_can('publish_posts', $post) &&
            wp_verify_nonce($_POST[self::NONCE], self::NONCE)
        ) {
            if ($_POST[self::META_KEY] === '0') {
                delete_post_meta($post, self::META_KEY);
            } else {
                update_post_meta($post, self::META_KEY, 1);
            }
        }
    }
}

```
## Options du thème
- Créer de nouvelles pages dans le menu on a 3 options:
- add_options_page -> nouvelle entrée réglages
- add_menu_page -> nouvelle entrée dans le menu
- add_submenu_page -> ajout d'un sous menu

## Page courante
- permet d'afficher des informations de la page courante
```php
        var_dump($suffix);die();
//C:\wamp64\www\wordpress\wp-content\themes\montheme\options\agence.php:15:string 'settings_page_agence_options' (length=28)
```
ou

```php
 var_dump(get_current_screen());die();
C:\wamp64\www\wordpress\wp-content\themes\montheme\options\agence.php:17:
object(WP_Screen)[8263]
  public 'action' => string '' (length=0)
  public 'base' => string 'settings_page_agence_options' (length=28)
  private 'columns' => int 0
  public 'id' => string 'settings_page_agence_options' (length=28)
  protected 'in_admin' => string 'site' (length=4)
  public 'is_network' => boolean false
  public 'is_user' => boolean false
  public 'parent_base' => null
  public 'parent_file' => null
  public 'post_type' => string '' (length=0)
  public 'taxonomy' => string '' (length=0)
  private '_help_tabs' => 
    array (size=0)
      empty
  private '_help_sidebar' => string '' (length=0)
  private '_screen_reader_content' => 
    array (size=0)
      empty
  private '_options' => 
    array (size=0)
      empty
  private '_show_screen_options' => null
  private '_screen_settings' => null
  public 'is_block_editor' => boolean false
```

## Add column Image 
```php
add_filter( 'manage_bien_posts_columns', function ( $columns ) {
	return [
		'cb' => $columns['cb'],
		'thumbnail' => 'Miniature',
		'title' => $columns['title'],
		'date' => $columns['date']
	];
} );

add_filter('manage_bien_posts_custom_column', function($column, $postId){
	if($column ==='thumbnail'){
		the_post_thumbnail('thumbnail', $postId);
	}
}, 10, 2);
```

##  wp_query

Add 3 articles wp_query qui n'est pas l'article courant
- single-post.php
- !!!! ATTENTION: 
- wp_reset_postdata(); pour réinitialiser les choses et éviter les effets de bords
- lorsque on utilise un boucle dans une autre boucle
```php
	<?php
	$query = new WP_Query( [
		'post__not_in' => [ get_the_ID() ],
		'post_type' => 'post',
		'posts_per_page' => 3
	] );

	?>
```
- Récupération des termes en fonction de l'id tennis = 6 => retourne les articles sport = 6  (taxonomies = catégoies)
```php
         // Find sport by id
        $sports = array_map(function($term) {
            return $term->term_id;
        }, get_the_terms(get_post(), 'sport'));
```
- Récupération des articles qui ont que football en taxonomie
```php
		$query = new WP_Query( [
			'post__not_in'   => [ get_the_ID() ],
			'post_type'      => 'post',
			'posts_per_page' => 3,
			'tax_query' => [
				[
					'taxonomy' => 'sport',
					'terms'    => $sports,
				],
			],
		] );
```
- Récupération des articles qui ont que football et tennis en taxonomie
```php
		$query = new WP_Query( [
			'post__not_in'   => [ get_the_ID() ],
			'post_type'      => 'post',
			'posts_per_page' => 3,
			'tax_query' => [
				[
					'taxonomy' => 'sport',
					'terms'    => $sports,
					'operator' => 'AND'
				],
			],
		] );
```
- Récupération des articles d'un sport donné aléatoirement en taxonomie
```php
			$query = new WP_Query( [
			'post__not_in'   => [ get_the_ID() ],
			'post_type'      => 'post',
			'posts_per_page' => 3,
            'orderby ' => 'rand',
			'tax_query' => [
				[
					'taxonomy' => 'sport',
					'terms'    => $sports,
				],
			],
		] );
```
- Récupération des articles d'un sport donné aléatoirement en taxonomie et sponsorisé
```php
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
			'meta_query'     => [
				[
					'key' => SponsorMetaBox::META_KEY,
                    'compare' => 'EXISTS'
				]
			]
		] );
```

## Altérer l'objet wp_query 
- Se déclenche après la création de l'objet variable de requête, 
- mais avant l'exécution de la requête réelle.

```php
//Intercept objet query
/**
 * @param WP_Query $query
 *
 */
function monTheme_pre_get_posts(WP_Query $query): void {
	if(is_admin() || !is_home() || !$query->is_main_query()){
		return;
	}
	// http://localhost/wordpress/actualites/?sponsor=1
	//	var_dump(get_query_var('sponsor'));die();
	if(get_query_var('sponsor') === '1') {
		$meta_query = $query->get('meta_query', []);
		$meta_query[] = [
			'key' => SponsorMetaBox::META_KEY,
			'compare' => 'EXISTS'
		];
		$query->set('meta_query', $meta_query);
	}
}

function monTheme_query_vars($params){
//	var_dump($params);die();
	$params[] = 'sponsor';
	return $params;
}

add_action('pre_get_posts', 'monTheme_pre_get_posts');
// Gestion des paramètres
add_filter('query_vars', 'monTheme_query_vars');
```

## Filtres avancés
- pre_get_posts pour pouvoir filtrer les choses
- get_search_query() pour supporter de nouvelles requêtes au niveau de l'objet wp_query
```php
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

```
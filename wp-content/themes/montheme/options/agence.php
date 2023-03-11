<?php

class AgenceMenuPage {

	const GROUP = 'agence_options';

	public static function register(): void {
		add_action( 'admin_menu', [ self::class, 'addMenu' ] );
		add_action( 'admin_init', [ self::class, 'registerSettings' ] );
		add_action( 'admin_enqueue_scripts', [ self::class, 'registerScripts' ] );
	}

	public static function registerScripts( $path_page ): void {
		if ( $path_page === 'settings_page_agence_options' ) {
			wp_register_style( 'flatpickr', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css', [], false );
			wp_register_script( 'flatpickr', 'https://cdn.jsdelivr.net/npm/flatpickr', [], false, true );
			wp_enqueue_script( 'monTheme_admin', get_template_directory_uri() . '/assets/admin.js', [ 'flatpickr' ], false, true );
			wp_enqueue_style( 'flatpickr' );
		}
	}

	public static function registerSettings(): void {
		register_setting( self::GROUP, 'agence_horaire', [ 'default' => 'Mettre vos horaires...' ] );
		add_settings_section( 'agence_options_section', 'Paramètres', function () {
			echo "Vous pouvez ici gérer les paramètres liés à l' agence immobilier";
		}, self::GROUP );
		add_settings_field( 'agence_options_horaire', "Horaires d'ouverture", function () {
			?>
            <textarea name="agence_horaire" cols="30" rows="10"
                      style="width: 100%"><?= esc_html( get_option( 'agence_horaire' ) ) ?></textarea>
			<?php
		}, self::GROUP, 'agence_options_section' );
		add_settings_field( 'agence_option_date', "Date d'ouverture", function () {
			?>
            <input type="text" name="agence_date" value="<?= esc_attr(get_option( 'agence_date' )) ?>"
                   class="monTheme_datepicker">
			<?php
		}, self::GROUP, 'agence_options_section' );
	}


	public static function addMenu(): void {
		add_options_page( "Gestion de l'agence", "Agence", "manage_options", self::GROUP, [ self::class, 'render' ] );
	}

	public static function render() {
		?>
        <h1>Gestion de l'agence</h1>

        <form action="options.php" method="post">
			<?php settings_fields( self::GROUP );
			do_settings_sections( self::GROUP );
			submit_button();
			?>
        </form>
		<?php
	}
}

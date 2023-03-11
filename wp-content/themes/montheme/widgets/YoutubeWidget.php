<?php

class YoutubeWidget extends WP_Widget {
	const ID_BASE = 'youtube_widget';
	const NAME = 'Youtube widget';

	public function __construct() {
		parent::__construct( self::ID_BASE, self::NAME );
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if (array_key_exists('title', $instance)) {
			$title = apply_filters( 'widget_title', $instance['title'] );
			echo $args['before_title'] . $title . $args['after_title'];
		}

		echo '<iframe  class="img-fluid" width="560" height="315" src="https://www.youtube.com/embed/'.esc_attr($instance['youtube'] ??  '').'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		?>
        <p>
            <label for="<?=  $this->get_field_id('title') ?>">Titre</label>
            <input
                    class="widefat"
                    type="text"
                    name="<?= $this->get_field_name( 'title' ) ?>"
                    value="<?= esc_attr( $instance['title'] ?? '' ) ?>"
                    id="<?= $this->get_field_name( 'title' ) ?>"
            >
        </p>
        <p>
            <label for="<?=  $this->get_field_id('youtube') ?>">Id YouTube</label>
            <input
                    class="widefat"
                    type="text"
                    name="<?= $this->get_field_name( 'youtube' ) ?>"
                    value="<?= esc_attr(  $instance['youtube'] ?? '' ) ?>"
                    id="<?= $this->get_field_name( 'youtube' ) ?>"
            >
        </p>

		<?php
	}

	public function update( $newInstance, $oldInstance ): array {
		return $newInstance;
	}
}
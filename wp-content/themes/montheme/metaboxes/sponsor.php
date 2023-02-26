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


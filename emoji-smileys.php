<?php
/*
Plugin Name: Emoji Smileys
Plugin URI: 
Description: A brief description of the Plugin.
Version: 0.1
Author: Geremia Taglialatela
Author URI: https://github.com/tagliala
License: MIT
*/

include_once(dirname(__FILE__).'/emoji.php');

/*
 * Load i18n file
 */
add_action('plugins_loaded', 'myplugin_init');

function myplugin_init() {
 $plugin_dir = basename(dirname(__FILE__));
 load_plugin_textdomain( 'emoji-smileys', false, $plugin_dir  . '/languages/' );
}

/**
 * Register with hook 'wp_enqueue_scripts', which can be used for front end CSS and JavaScript
 */
add_action( 'wp_enqueue_scripts', 'emoji_smileys_add_sprite' );
add_action( 'wp_enqueue_scripts', 'emoji_smileys_add_js_click_listener' );

/**
 * Enqueue plugin style-file
 */
function emoji_smileys_add_sprite() {
  // Respects SSL, Style.css is relative to the current file
  wp_register_style( 'emoji-smileys-css', plugins_url('emoji.css', __FILE__) );
  wp_enqueue_style( 'emoji-smileys-css' );
}

function emoji_smileys_add_js_click_listener() {
  // Respects SSL, Style.css is relative to the current file
  wp_register_script( 'emoji-smileys-js', plugins_url('emoji.js', __FILE__) );
  wp_enqueue_script( 'emoji-smileys-js' );
}

/* convert smilies to images */
function convert_custom_smilies($text) {
  return $text;
}

/**
 * Add emoji to form
 */
add_filter( 'comment_form_field_comment', 'emoji_smileys_add_emoji_to_form' );

function emoji_smileys_add_emoji_to_form($field) {
  echo $field;
  ?>
  <div class="control-group">
    <div class="controls" id="emoji-smileys">
      <?php
      foreach ( $GLOBALS['emoji_maps']['available_icons'] as $code => $name ) {
        preg_match('/\[emoji\]([^\[]+)\[\/emoji\]/', $GLOBALS['emoji_maps']['unified_to_tag'][$code], $matches);
        echo '<a href="#" class="emoji-' . $matches[1] . '" data-code="' . $code . '" title="' . $name . '"></a>';
      }
      ?>
      <a href="#" id="emojy-smileys-show-more"><?php _e('show more', 'emoji-smileys') ?></a>
      <div id="emojy-smileys-more" class="hide">
        <?php
        foreach ( $GLOBALS['emoji_maps']['more_icons'] as $code => $name ) {
          preg_match('/\[emoji\]([^\[]+)\[\/emoji\]/', $GLOBALS['emoji_maps']['unified_to_tag'][$code], $matches);
          echo '<a href="#" class="emoji-' . $matches[1] . '" data-code="' . $code . '" title="' . $name . '"></a>';
        }
        ?>
      </div>
    </div>
  </div>
  <?php
}

add_filter('pre_comment_content', 'emoji_smileys_unified_to_tag', 30);
add_filter('comment_text', 'emoji_smileys_tag_to_html', 3);

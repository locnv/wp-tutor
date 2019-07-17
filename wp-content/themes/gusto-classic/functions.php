<?php

/* Scripts & Style */
function gusto_classic_files() {

  wp_enqueue_style( 'lib-bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', false, '1.0', 'all');
  wp_enqueue_style( 'lib-font-awesome', get_template_directory_uri() . '/fonts/font-awesome/css/font-awesome.min.css', false, '1.0', 'all');
  wp_enqueue_style('gusto_classic_main_styles', get_stylesheet_uri());

  //wp_enqueue_script('gusto_classic_jquery', get_theme_file_uri('js/jquery.1.11.1.js', NULL, false, true));
  //wp_enqueue_script('gusto_classic_bootstrap', get_theme_file_uri('js/bootstrap.js', NULL, false, true));
  //wp_enqueue_script('gusto_classic_smoothscroll', get_theme_file_uri('js/SmoothScroll.js', NULL, false, true));
  //wp_enqueue_script('gusto_classic_bootstrap_validation', get_theme_file_uri('js/jqBootstrapValidation.js', NULL, false, true));
  //wp_enqueue_script('gusto_classic_contact_me', get_theme_file_uri('js/contact_me.js', NULL, false, true));
  //wp_enqueue_script('gusto_classic_main', get_theme_file_uri('js/main.js', NULL, false, true));

}

add_action('wp_enqueue_scripts', 'gusto_classic_files');
<?php

/* Scripts & Style */
function minishop_files() {

  //wp_enqueue_script('main-university-js', get_theme_file_uri('/js/scripts-bundled.js'), array(), microtime()/*'1.0'*/, true);

  wp_enqueue_script('minishop-jquery-js', get_theme_file_uri('/js/jquery.min.js'), array(), '1.0', true);
  wp_enqueue_script('minishop-jquery-migrate-js', get_theme_file_uri('/js/jquery-migrate-3.0.1.min.js'), array(), '1.0', true);
  wp_enqueue_script('minishop-poper-js', get_theme_file_uri('/js/popper.min.js'), array(), '1.0', true);
  wp_enqueue_script('minishop-bootstrap-js', get_theme_file_uri('/js/bootstrap.min.js'), array(), '1.0', true);
  wp_enqueue_script('minishop-jquery.easing-js', get_theme_file_uri('/js/jquery.easing.1.3.js'), array(), '1.0', true);
  wp_enqueue_script('minishop-jquery-waypoints-js', get_theme_file_uri('/js/jquery.waypoints.min.js'), array(), '1.0', true);
  wp_enqueue_script('minishop-jquery-stellar-js', get_theme_file_uri('/js/jquery.stellar.min.js'), array(), '1.0', true);
  wp_enqueue_script('minishop-carousel-js', get_theme_file_uri('/js/owl.carousel.min.js'), array(), '1.0', true);
  wp_enqueue_script('minishop-jquery-magnific-popup-js', get_theme_file_uri('/js/jquery.magnific-popup.min.js'), array(), '1.0', true);
  wp_enqueue_script('minishop-aos-js', get_theme_file_uri('/js/aos.js'), array(), '1.0', true);
  wp_enqueue_script('minishop-jquery-ani-js', get_theme_file_uri('/js/jquery.animateNumber.min.js'), array(), '1.0', true);
  wp_enqueue_script('minishop-bootstrap-datepicker-js', get_theme_file_uri('/js/bootstrap-datepicker.js'), array(), '1.0', true);
  wp_enqueue_script('minishop-scrollax-js', get_theme_file_uri('/js/scrollax.min.js'), array(), '1.0', true);
  wp_enqueue_script('minishop-map-api-js', get_theme_file_uri('//maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false'), array(), '1.0', true);
  wp_enqueue_script('minishop-map-app-js', get_theme_file_uri('/js/google-map.js'), array(), '1.0', true);
  wp_enqueue_script('minishop-main-app-js', get_theme_file_uri('/js/main.js'), array(), '1.0', true);

  //wp_enqueue_style('google_font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');	
  //wp_enqueue_style('font_aewsome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

  wp_enqueue_style('font_aewsome', '//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800');
  wp_enqueue_style( 'open-icon-bootstrap',  get_template_directory_uri() .'/css/open-iconic-bootstrap.min.css', array(), null, 'all' );
    
  wp_enqueue_style( 'minishop-animate-css',  get_template_directory_uri() .'/css/animate.css', array(), null, 'all' );
  wp_enqueue_style( 'minishop-carousel-css',  get_template_directory_uri() .'/css/owl.carousel.min.css', array(), null, 'all' );
  wp_enqueue_style( 'minishop-owl-theme-css',  get_template_directory_uri() .'/css/owl.theme.default.min.css', array(), null, 'all' );
  wp_enqueue_style( 'minishop-magnific-popup-css',  get_template_directory_uri() .'/css/magnific-popup.css', array(), null, 'all' );

  wp_enqueue_style( 'minishop-aos-css',  get_template_directory_uri() .'/css/aos.css', array(), null, 'all' );
  wp_enqueue_style( 'minishop-ionicons-css',  get_template_directory_uri() .'/css/ionicons.min.css', array(), null, 'all' );
  wp_enqueue_style( 'minishop-bootstrap-datepicker-css',  get_template_directory_uri() .'/css/bootstrap-datepicker.css', array(), null, 'all' );
  wp_enqueue_style( 'minishop-jquery-timepicker-css',  get_template_directory_uri() .'/css/jquery.timepicker.css', array(), null, 'all' );
  wp_enqueue_style( 'minishop-flaticon-css',  get_template_directory_uri() .'/css/flaticon.css', array(), null, 'all' );
  wp_enqueue_style( 'minishop-icomoon-css',  get_template_directory_uri() .'/css/icomoon.css', array(), null, 'all' );
  wp_enqueue_style( 'minishop-app-style-css',  get_template_directory_uri() .'/css/style.css', array(), null, 'all' );
  wp_enqueue_style('minishop_main_styles', get_stylesheet_uri());


  wp_localize_script('main-minishop-js', 'siteInfo', array(
  	'rootUrl' => get_site_url()
  ));

}

add_action('wp_enqueue_scripts', 'minishop_files');


<?php

function university_adjust_queries($query) {

	if(!is_admin() AND is_post_type_archive('program') AND $query->is_main_query) {
		$query->set('orderby', 'title');
		$query->set('order', 'ASC');
		$query->set('posts_per_page', -1);
	}

	if(!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) {
		
		$today = date('Ymd'); // 20190825

		$query->set('meta_key', 'event_date');
		$query->set('orderby', 'meta_value_num');
		$query->set('order', 'ASC');
		$query->set('meta_query', array(
          array(
            'key' => 'event_date',
            'compare' => '>=',
            'value' => $today,
            'type' => 'numeric'
          )
        ));
	}
}

add_action('pre_get_posts', 'university_adjust_queries');

/* Theme Features */
function university_features() {

	register_nav_menu('headerMenuLocation', 'Header Menu Location');
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_image_size('professorLandscape', 400, 260, true); // True -> cropping
	add_image_size('professorPortrait', 480, 650, true);
	add_image_size('pageBanner', 1500, 350, true);
}

add_action('after_setup_theme', 'university_features');

/* Scripts & Style */
function university_files() {

  //wp_enqueue_script('main-university-js', get_theme_file_uri('/js/scripts-bundled.js', NULL, $ver=false, $in_footer = true));

  wp_enqueue_style('google_font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');	
  wp_enqueue_style('font_aewsome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');	
  wp_enqueue_style('university_main_styles', get_stylesheet_uri());

}

add_action('wp_enqueue_scripts', 'university_files');
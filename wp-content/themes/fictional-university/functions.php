<?php

require get_theme_file_path('/inc/like-route.php');
require get_theme_file_path('/inc/search-route.php');

function university_custom_rest() {
	// p1. Post type to customize
	// p2. Property to be added
	// p3. Handle
	register_rest_field('post', 'autherName', array(
		'get_callback' => function() { return get_the_author(); }
	));

	register_rest_field('note', 'userNoteCount', array(
		'get_callback' => function() { return count_user_posts(get_current_user_id(), 'note'); }
	));

}

add_action('rest_api_init', 'university_custom_rest');

/**
* @param $args array: title | subtitle
*/
function pageBanner($args = array()) { 

	if (!array_key_exists('title', $args)) {
		$args['title'] = get_the_title();
	}

	if(!array_key_exists('subtitle', $args)) {
		$args['subtitle'] = get_field('page_banner_subtitle');
	}

	if (!array_key_exists('photo', $args)) {
		if(get_field('page_banner_background_image')) {
			$args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];	
		} else {
			$args['photo'] = get_theme_file_uri('/images/ocean.jpg');
		}
	}

	?>

	<div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?> );"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
        <div class="page-banner__intro">
          <p><?php echo $args['subtitle']; ?></p>
        </div>
      </div>  
    </div>

<?php
}

function university_adjust_queries($query) {

	if(!is_admin() AND is_post_type_archive('campus') AND $query->is_main_query) {
		$query->set('posts_per_page', -1);
	}

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

  wp_enqueue_script('main-university-js', get_theme_file_uri('/js/scripts-bundled.js'), array('jquery'), microtime()/*'1.0'*/, true);

  //wp_deregister_script('jquery');
  //wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js');

  wp_enqueue_script('google-map', '//maps.googleapis.com/maps/api/js?key=AIzaSyBiX7gwti9keu3ED00w5X4uXRG6llb80zg', NULL, '1.0', true);

  wp_enqueue_style('google_font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');	
  wp_enqueue_style('font_aewsome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');	
  wp_enqueue_style('university_main_styles', get_stylesheet_uri());
  wp_localize_script('main-university-js', 'siteInfo', array(
  	'rootUrl' => get_site_url(),
  	'nonce' => wp_create_nonce('wp_rest')
  ));

}

add_action('wp_enqueue_scripts', 'university_files');


/**
* Google Javascript Map API
* Account: locnv.dev@gmail.com
* Project: My First Project
* API key 1
*/
function university_map_key($api) {
	$api['key'] = 'AIzaSyBiX7gwti9keu3ED00w5X4uXRG6llb80zg';

	return $api;
}

add_filter('acf/fields/google_map/api', 'university_map_key');


// Redirect subscriber accounts out of admin and onto homepage


function universityRedirectSubsToFrontend() {
	$ourCurrentUser = wp_get_current_user();
	if(count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber') {
		wp_redirect(site_url('/'));
		exit;
	}
}

add_action('admin_init', 'universityRedirectSubsToFrontend');


function universityNoSubsAdminBar() {
	$ourCurrentUser = wp_get_current_user();
	if(count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber') {
		show_admin_bar(false);
	}
}

add_action('wp_loaded', 'universityNoSubsAdminBar');


// Customize Login Screen

function universityOurHeaderUrl() {
	return esc_url(site_url('/'));
}

add_filter('login_headerurl', 'universityOurHeaderUrl');


function universityLoginCSS() {
	wp_enqueue_style('university_main_styles', get_stylesheet_uri());
}

add_action('login_enqueue_scripts', 'universityLoginCSS');


function universityOurLoginTitle() {
	return get_bloginfo('name');
}

add_filter('login_headertext', 'universityOurLoginTitle');

// Force note posts to be private

// $data -> post data
// $postarr -> 
function university_make_note_private($data, $postarr) {
	if($data['post_type'] == 'note') {

		if(count_user_posts(get_current_user_id(), 'note') > 500 AND !$postarr['ID']) {
			die("You have reached your note limit.");
		}

		$data['post_content'] = sanitize_textarea_field($data['post_content']);
		$data['post_title'] = sanitize_text_field($data['post_title']);
	}

	if($data['post_type'] == 'note' AND $data['post_status'] != 'trash') {
		$data['post_status'] = 'private';	
	}

	return $data;
}

add_filter('wp_insert_post_data', 'university_make_note_private', 10, 2);


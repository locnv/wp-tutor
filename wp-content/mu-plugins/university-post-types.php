<?php

/* New Post Types */
function university_post_type() {

	// Event post type
	register_post_type('event', array(
		'show_in_rest' => true,
		'capability_type' => 'event',
		'map_meta_cap' => 'true',
		'supports' => array('title', 'editor', 'excerpt'),
		'rewrite' => array('slug' => 'events'),
		'has_archive' => true,
		'public' => true,
		'labels' => array(
			'name' => 'Events',
			'add_new_item' => 'Add New Event',
			'edit_item' => 'Edit Event',
			'all_items' => 'All Events',
			'singular_name' => 'Event'
		),
		// g Wordpress Dashicon
		'menu_icon' => 'dashicons-calendar'
	));

	// Program Post Type
	register_post_type('program', array(
		'show_in_rest' => true,
		'supports' => array('title'),
		'rewrite' => array('slug' => 'programs'),
		'has_archive' => true,
		'public' => true,
		'labels' => array(
			'name' => 'Programs',
			'add_new_item' => 'Add New Program',
			'edit_item' => 'Edit Program',
			'all_items' => 'All Programs',
			'singular_name' => 'Program'
		),
		// g Wordpress Dashicon
		'menu_icon' => 'dashicons-awards'
	));

	// Professor Post Type
	register_post_type('professor', array(
		'show_in_rest' => true,
		'supports' => array('title', 'editor', 'thumbnail'),
		'public' => true,
		'labels' => array(
			'name' => 'Professors',
			'add_new_item' => 'Add New Professor',
			'edit_item' => 'Edit Professor',
			'all_items' => 'All Professors',
			'singular_name' => 'Professor'
		),
		// g Wordpress Dashicon
		'menu_icon' => 'dashicons-welcome-learn-more'
	));

	// Campus post type
	register_post_type('campus', array(
		'capability_type' => 'campus',
		'map_meta_cap' => 'true',
		'supports' => array('title', 'editor', 'excerpt'),
		'rewrite' => array('slug' => 'campuses'),
		'has_archive' => true,
		'public' => true,
		'labels' => array(
			'name' => 'Campuses',
			'add_new_item' => 'Add New Campus',
			'edit_item' => 'Edit Campus',
			'all_items' => 'All Campuses',
			'singular_name' => 'Campus'
		),
		// g Wordpress Dashicon
		'menu_icon' => 'dashicons-location-alt'
	));

	// Note Post Type
	register_post_type('note', array(
		'capability_type' => 'note',
		'map_meta_cap' => true,
		'show_in_rest' => true,
		'supports' => array('title', 'editor'),
		'public' => false,
		'show_ui' => true,
		'labels' => array(
			'name' => 'Notes',
			'add_new_item' => 'Add New Note',
			'edit_item' => 'Edit Note',
			'all_items' => 'All Notes',
			'singular_name' => 'Note'
		),
		// g Wordpress Dashicon
		'menu_icon' => 'dashicons-welcome-write-blog'
	));

	// Note Post Type
	register_post_type('like', array(
		//'show_in_rest' => true, // Not to use default rest api, but rather than make completely custom rest api
		'supports' => array('title'),
		'public' => false,
		'show_ui' => true,
		'labels' => array(
			'name' => 'Likes',
			'add_new_item' => 'Add New Like',
			'edit_item' => 'Edit Like',
			'all_items' => 'All Likes',
			'singular_name' => 'Like'
		),
		// g Wordpress Dashicon
		'menu_icon' => 'dashicons-heart'
	));

	// Word Post Type
	register_post_type('word', array(
		'show_in_rest' => true, // Not to use default rest api, but rather than make completely custom rest api
		'supports' => array('title', 'editor'),
		'public' => false,
		'show_ui' => true,
		'labels' => array(
			'name' => 'Words',
			'add_new_item' => 'Add New Word',
			'edit_item' => 'Edit Word',
			'all_items' => 'All Words',
			'singular_name' => 'Word'
		),
		// g Wordpress Dashicon
		'menu_icon' => 'dashicons-editor-paste-word'
	));

	// Word Post Type
	register_post_type('topic', array(
		//'show_in_rest' => true, // Not to use default rest api, but rather than make completely custom rest api
		'supports' => array('title'),
		'public' => false,
		'show_ui' => true,
		'labels' => array(
			'name' => 'Topics',
			'add_new_item' => 'Add New Topic',
			'edit_item' => 'Edit Topic',
			'all_items' => 'All Topics',
			'singular_name' => 'Topic'
		),
		// g Wordpress Dashicon
		'menu_icon' => 'dashicons-admin-site-alt'
	));

	// Word Post Type
	register_post_type('topic_word', array(
		//'show_in_rest' => true, // Not to use default rest api, but rather than make completely custom rest api
		'supports' => array('title'),
		'public' => false,
		'show_ui' => true,
		'labels' => array(
			'name' => 'TopicWords',
			'add_new_item' => 'Add New TopicWord',
			'edit_item' => 'Edit TopicWord',
			'all_items' => 'All TopicWords',
			'singular_name' => 'TopicWord'
		),
		// g Wordpress Dashicon
		'menu_icon' => 'dashicons-translation'
	));
}

add_action('init', 'university_post_type');

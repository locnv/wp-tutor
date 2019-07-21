<?php

function load_stylesheets() {
	wp_register_style('stylesheet', get_template_directory_uri() . '/style.css', '', 1, 'all');
	wp_enqueue_style('stylesheet');

	wp_register_style('custom', get_template_directory_uri() . '/app.css', '', 1, 'all');
	wp_enqueue_style('custom');
}

add_action('wp_enqueue_scripts', 'load_stylesheets');

function load_javascripts() {
	wp_register_script('custom', get_template_directory_uri() . '/app.js', 'jquery', 1, true);
	wp_enqueue_script('custom');
}

// Add Menus
add_action('wp_enqueue_scripts', 'load_javascripts');

// Add support
add_theme_support('menus');
add_theme_support('post-thumbnails');

// Register some menus
register_nav_menus(
	array(
		'top-menu' => 'Top Menu',
	)
);

// Add image sizes
add_image_size('post_image', 1100, 750, true);


// Add a widget
register_sidebar(array(
	'name' => 'Page Sidebar',
	'id' => 'page-sidebar',
	'class' => '',
	'before_title' => '<h4>',
	'after_title' => '</h4>',
));

register_sidebar(array(
	'name' => 'Blog Sidebar',
	'id' => 'blog-sidebar',
	'class' => '',
	'before_title' => '<h4>',
	'after_title' => '</h4>',
));

// Add Support Woocommerce


function wc_add_woocommerce_support() {
	add_theme_support('woocommerce');
}

add_action('after_setup_theme', 'wc_add_woocommerce_support');


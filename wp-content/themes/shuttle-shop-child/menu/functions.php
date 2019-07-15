<?php

// https://gist.github.com/AliMD/3865955
// Create A Somple Product Catalog width Wordpress. ali.md/pcwp
// Step One: Create the custom post type

//add_theme_support('post-thumbnails');

add_action('init', 'menu_init'); // add init event

function menu_init (){

	$labels = array(
		'name' => _x('Menu', 'post type general name'),
		'singular_name' => _x('Menu', 'post type singular name'),
		'add_new' => _x('Add New', 'menu'),
		'add_new_item' => __('Add New Menu'),
		'edit_item' => __('Edit Menu'),
		'new_item' => __('New Menu'),
		'view_item' => __('View Menu'),
		'search_items' => __('Search Menu'),
		'not_found' =>  __('No menu found'),
		'not_found_in_trash' => __('No menu found in Trash'),
		'parent_item_colon' => '',
		'menu_name' => 'Menu'
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => 25,
		'menu_icon' => get_bloginfo('template_url') . '/images/producticon.png',
		'supports' => array('title','editor','thumbnail','excerpt')
	);

	register_post_type ('menu', $args);
	// http://codex.wordpress.org/Function_Reference/register_post_type

	register_taxonomy_for_object_type('category', 'menu');
	// http://codex.wordpress.org/Taxonomies
	// http://codex.wordpress.org/Function_Reference/register_taxonomy_for_object_type
}

// Step 2: Create meta boxes for product information.

add_action('add_meta_boxes', 'menu_add_custom_box');

function menu_add_custom_box(){
	add_meta_box('menu_priceid', 'Price', 'menu_price_box', 'menu', 'side');
	// http://codex.wordpress.org/Function_Reference/add_meta_box
}

function menu_price_box(){
	$price = 0;
	if ( isset($_REQUEST['post']) ) { // after first post save
		$price = get_post_meta((int)$_REQUEST['post'],'menu_price',true);
	}
	echo "<label for='menu_price_text'>Price</label>";
	echo "<input id='menu_price_text' class='widefat' name='menu_price_text' size='20' type='text' value='$price' />";
}

// Step 3: Save the product info

add_action('save_post','menu_save_meta');

function menu_save_meta($post_id){
	if ( is_admin() ) {
		if ( isset($_POST['menu_price_text']) ) {
			update_post_meta($post_id,'menu_price',$_POST['menu_price_text']);
			// http://codex.wordpress.org/Function_Reference/update_post_meta
		}
	}
}

// Step 4: Add shortcode for product

add_shortcode('all_menu', 'menu_list');
// ali.md/shortcode


function menu_list($args) {
	
	$allMenu = get_terms('category');
	$html = '<h3>Menu List</h3>';
	
	foreach ( $allMenu as $menu ) {

		$menuItems = new WP_Query(array(
			'post_type' => 'menu',
			'category_name' => $menu->name
		));

		$html .= '<br /><b>' .$menu->name.'</b><br/>';
		$html .= '<ul>';
    	while($menuItems->have_posts()) {
			$menuItems->the_post();

			$title = get_the_title();
			$price = get_post_meta(get_the_ID(), 'menu_price', true);
			//$url = get_permalink();

			$html .= "<li><span>$title</span> - <i>$price</i> vnd</li>";
		}
		$html .= '</ul>';
	}

	return $html;

}

function menu_list1($args){

	if(!@$args['cat']) $args['cat']='';
	
	$products = new WP_Query(array(
		'post_type' => 'menu',
		'category_name' => $args['cat']
	));

	$html = '<h3>Menu List</h3>';

	$html .= '<ul>';

	while($products->have_posts()){
		$products->the_post();

		$title = get_the_title();
		$url = get_permalink();

		$html .= "<li><a href='$url'>$title</a></li>";
	}

	$html .= '</ul>';

	return $html;
}

<?php

// Create A Somple Product Catalog width Wordpress. ali.md/pcwp
// Step One: Create the custom post type

add_theme_support('post-thumbnails');

add_action('init', 'product_init'); // add init event

function product_init (){

	$labels = array(
		'name' => _x('Products', 'post type general name'),
		'singular_name' => _x('Product', 'post type singular name'),
		'add_new' => _x('Add New', 'product'),
		'add_new_item' => __('Add New Product'),
		'edit_item' => __('Edit Product'),
		'new_item' => __('New Product'),
		'view_item' => __('View Product'),
		'search_items' => __('Search Products'),
		'not_found' =>  __('No products found'),
		'not_found_in_trash' => __('No products found in Trash'),
		'parent_item_colon' => '',
		'menu_name' => 'Products'
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

	register_post_type ('product',$args);
	// http://codex.wordpress.org/Function_Reference/register_post_type

	register_taxonomy_for_object_type('category', 'product');
	// http://codex.wordpress.org/Taxonomies
	// http://codex.wordpress.org/Function_Reference/register_taxonomy_for_object_type
}

// Step 2: Create meta boxes for product information.

add_action('add_meta_boxes', 'product_add_custom_box');

function product_add_custom_box(){
	add_meta_box('product_priceid', 'Product Price', 'product_price_box', 'product', 'side');
	// http://codex.wordpress.org/Function_Reference/add_meta_box
}

function product_price_box(){
	$price = 0;
	if ( isset($_REQUEST['post']) ) { // after first post save
		$price = get_post_meta((int)$_REQUEST['post'],'product_price',true);
	}
	echo "<label for='product_price_text'>Product Price</label>";
	echo "<input id='product_price_text' class='widefat' name='product_price_text' size='20' type='text' value='$price' />";
}

// Step 3: Save the product info

add_action('save_post','product_save_meta');

function product_save_meta($post_id){
	if ( is_admin() ) {
		if ( isset($_POST['product_price_text']) ) {
			update_post_meta($post_id,'product_price',$_POST['product_price_text']);
			// http://codex.wordpress.org/Function_Reference/update_post_meta
		}
	}
}

// Step 4: Add shortcode for product

add_shortcode('products', 'product_list');
// ali.md/shortcode

function product_list($args){

	if(!@$args['cat']) $args['cat']='';
	
	$products = new WP_Query(array(
		'post_type' => 'product',
		'category_name' => $args['cat']
	));

	$html = '<h3>Product List</h3>';

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
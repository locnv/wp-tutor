<?php

function universityRegisterSearch() {

	// localhost ... /wp-json/wp/v2/professor
	// wp/v2 -> namespace
	// professor -> route

	// p1. Namespace to use
	// p2. The route
	register_rest_route('university/v1', 'search', array(
		'methods' => WP_REST_SERVER::READABLE,
		'callback' => 'universitySearchResult'
	));
}

function universitySearchResult($data) {

	$mainQuery = new WP_Query(array(
		'post_type' => array('post', 'page', 'program', 'event', 'campus', 'professor'),
		's' => sanitize_text_field($data['term'])
	));

	$results = array(
		'generalInfo' => array(), // post & page
		'professors' => array(),
		'programs' => array(),
		'events' => array(),
		'campuses' => array()
	);

	while($mainQuery->have_posts()) {
		$mainQuery->the_post();

		$postType = get_post_type();

		if($postType == 'post' OR $postType == 'page') {
			array_push($results['generalInfo'], array(
				'title' => get_the_title(),
				'permalink' => get_the_permalink(),
				'postType' => $postType,
				'authorName' => get_the_author()
			));
		}

		if($postType == 'professor') {
			array_push($results['professors'], array(
				'title' => get_the_title(),
				'permalink' => get_the_permalink()
			));
		}

		if($postType == 'event') {
			array_push($results['events'], array(
				'title' => get_the_title(),
				'permalink' => get_the_permalink()
			));
		}

		if($postType == 'program') {
			array_push($results['programs'], array(
				'title' => get_the_title(),
				'permalink' => get_the_permalink()
			));
		}

		if($postType == 'campus') {
			array_push($results['campuses'], array(
				'title' => get_the_title(),
				'permalink' => get_the_permalink()
			));
		}
	}


	return $results;
}

add_action('rest_api_init', 'universityRegisterSearch');

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
				'permalink' => get_the_permalink(),
				'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
			));
		}

		if($postType == 'event') {

			$eventDateField = get_field('event_date');
			$eventDate = DateTime::createFromFormat('d/m/Y', $eventDateField);

			$description = null;

			if(has_excerpt()) {
		      $description = get_the_excerpt();
		    } else {
		      $description = wp_trim_words(get_the_content(), 18);
		    }

			array_push($results['events'], array(
				'title' => get_the_title(),
				'permalink' => get_the_permalink(),
				'month' => $eventDate->format('M'),
				'day' => $eventDate->format('d'),
				'description' => $description
			));
		}

		if($postType == 'program') {
			array_push($results['programs'], array(
				'title' => get_the_title(),
				'permalink' => get_the_permalink(),
				'id' => get_the_id()
			));
		}

		if($postType == 'campus') {
			array_push($results['campuses'], array(
				'title' => get_the_title(),
				'permalink' => get_the_permalink()
			));
		}
	}

	if($results['programs']) {

		$programsMetaQuery = array('relation' => 'OR');
		foreach($results['programs'] as $item) {
			array_push($programsMetaQuery, array(
				'key' => 'related_programs',
				'compare' => 'LIKE',
				'value' => '"'. $item['id'] .'"'
			));
		}

		$programRelationshipQuery = new WP_Query(array(
			'post_type' => 'professor',
			'meta_query' => $programsMetaQuery
		));

		while($programRelationshipQuery->have_posts()) {
			$programRelationshipQuery->the_post();

			array_push($results['professors'], array(
				'title' => get_the_title(),
				'permalink' => get_the_permalink(),
				'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
			));
		}

		$results['professors'] = array_values(array_unique($results['professors'], SORT_REGULAR));
	}

	return $results;
}

add_action('rest_api_init', 'universityRegisterSearch');

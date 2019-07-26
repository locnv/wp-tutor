<?php 
get_header();
pageBanner(); 

$args = array(  
      'post_type' => 'post',
      'post_status' => 'publish',
      'posts_per_page' => -1,  
      'category_name' => 'english',
  );

  $loop = new WP_Query( $args ); 

?>
<div class="container container--narrow page-section">
  <?php
  while($loop->have_posts()) {
    $loop->the_post(); ?>

    <div class="post-item">
      <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h2>

      <div class="metabox">
        <p>Posted by <?php the_author_posts_link(); ?> on <?php the_time('j/n/y'); ?> in <?php echo get_the_category_list(', '); ?></p>
      </div>

      <div class="generic-content">
        <?php the_excerpt(); ?>
        <p><a class="btn btn--blue" href=<?php the_permalink(); ?>>Continue reading &raquo;</a></p>
      </div>
    </div>

  <?php } ?>
  
</div>

<?php get_footer(); ?>
<?php get_header(); ?>


<section id="home-section" class="hero">
  <div style="width: 25%; float: left;">
    <?php wp_list_pages(); ?>
  </div>
  <div style="width: 74%; float: left;">
    <?php 
      while(have_posts()) {
        the_post(); ?>
        <h2><?php the_title() ?></div>
        <p><?php the_content() ?></p>
      <?php }
    ?>
  </div>
    
</section>

<?php get_footer(); ?>
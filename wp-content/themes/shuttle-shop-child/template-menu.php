<?php
    query_posts(array(
        'post_type' => 'ccmenu',
        'showposts' => 10
    ) );
?>
<?php while (have_posts()) : the_post(); ?>
        <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
        <p><?php echo get_the_excerpt(); ?></p>
<?php endwhile;?>
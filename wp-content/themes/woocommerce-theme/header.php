<!DOCTYPE html>
<html>
<head>
	<title>Wordpress Woocommerce Tutorial</title>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header>
	<div class="container">
		<div class="row">
			<div class="col d-flex align-items-center justify-content-between">
				<a href="<?php bloginfo('url'); ?>"><img src="<?php bloginfo('template_directory') ?>/images/logo.png" class="img-fluid logo"></a>
				
				<?php
				wp_nav_menu(array(
					'them-location' => 'top-menu',
					'menu_class' => 'top-menu'
				));
				?>
			</div>
		</div>
		
	</div>
</header>
	
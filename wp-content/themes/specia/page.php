<?php
get_header();
get_template_part('sections/specia','breadcrumb'); ?>

<section class="page-wrapper">

	<!-- 2018/09/17 -- START -- Banner or slider in HOME page -->
	<?php
	$show_banner = false;
	$url_exp = explode('/', $_SERVER['REQUEST_URI']);
	if(empty($url_exp[2])) {
		$show_banner = true;
	} else {
		if(strstr('en_us', $url_exp[2])) {
			if(empty($url_exp[3])) $show_banner = true;
		}
	}
	
        if($show_banner) {
	?>
		<div style="width: 100%; height: 400px; display: inline-block; text-align: center; background-color: #fc0d1b;">
			<p style="text-align: center; margin-top: 100px; color: white;">HEADER / SLIDER</p>
			<p style="text-align: center; margin-top: 50px; color: white;">Here will be the copy campaign.</p>
		</div>
	<?php } ?>
	<!-- 2018/09/17 -- END -- Banner or slider in HOME page -->

	<div class="container">
					
		<div class="row padding-top-60 padding-bottom-60">		
			<?php 
				if ( class_exists( 'WooCommerce' ) ) 
				{
					
					if( is_account_page() || is_cart() || is_checkout() ) {
							echo '<div class="col-md-'.( !is_active_sidebar( "woocommerce-1" ) ?"12" :"8" ).'">'; 
					}
					else{ 
				
					echo '<div class="col-md-'.( !is_active_sidebar( "sidebar-primary" ) ?"12" :"8" ).'">'; 
					
					}
					
				}
				else
				{ 
				
					echo '<div class="col-md-'.( !is_active_sidebar( "sidebar-primary" ) ?"12" :"8" ).'">';
					
					
				} 
			?>
			<div class="site-content">
			
			<?php 
				
				if( have_posts()) :  the_post();
				
				the_content(); 
				endif;
				
				comments_template( '', true ); // show comments 
			?>
				

			</div><!-- /.posts -->
							
			</div><!-- /.col -->
			

			<?php 
				if ( class_exists( 'WooCommerce' ) ) 
					{
						
						if( is_account_page() || is_cart() || is_checkout() ) {
								get_sidebar('woocommerce'); 
						}
						else{ 
					
						get_sidebar(); 
						
						}
						
					}
				else
					{ 
					
						get_sidebar(); 
						
					} 
			?>
			
						
		</div><!-- /.row -->
	</div><!-- /.container -->
</section>

<?php get_footer(); ?>


<?php defined( 'ABSPATH' ) or die;

/*
 * Admin settings
 */

class Specia_admin {

    // Loads scripts and styles for admin settings page
    public static function scripts_and_styles ( $page ) {
        if ( 'appearance_page_' . 'specia-store' === $page ) {
			wp_enqueue_style( 'specia-theme-admin-css', get_template_directory_uri() . '/css/specia-theme-admin.css' );
        }
    }

    // Admin settings page
    public static function settings_page () { ?>
        <div class="wrap">

            <div id="<?php echo 'specia-theme-info-form'; ?>">
               

                <div id="tabs">
					
					<div id="specia" class="tab-item">
						
						
						<!-- Section One -->
						<section class="section-one">
							<div id="container" class="cf">
								
								<div class="span12">
									<h1>
									<?php _e('Our Premium Themes Collection','specia'); ?>
									</h1><br><br><br>
								</div>
								
								<div class="span4">
									<img class="theme_screen" src="<?php echo get_template_directory_uri(); ?>/images/specia.png">
									
									<div class="promo-buttons">
										<a href="<?php echo "https://demo.speciatheme.com/pro/?theme=specia"; ?>" class="promo-btn btn-black" target="_blank"><i class="dashicons dashicons-desktop info-icon"></i> <?php _e('PRO Demo','specia'); ?></a>
										
										<a href="<?php echo "https://speciatheme.com/specia-premium/"; ?>" class="promo-btn btn-green" target="_blank"><i class="dashicons dashicons-cart info-icon"></i> <?php _e('View Details','specia'); ?></a>
										
										<a href="<?php echo "https://speciatheme.com/specia-premium/"; ?>" class="promo-btn btn-red" target="_blank"><i class="dashicons dashicons-cart info-icon"></i> <?php _e('Buy Now','specia'); ?></a>
									</div>
								</div>
								
								<div class="span4">
									<img class="theme_screen" src="<?php echo get_template_directory_uri(); ?>/images/proficient.png">
									
									<div class="promo-buttons">
										<a href="<?php echo "https://demo.speciatheme.com/pro/?theme=proficient"; ?>" class="promo-btn btn-black" target="_blank"><i class="dashicons dashicons-desktop info-icon"></i> <?php _e('PRO Demo','specia'); ?></a>
										
										<a href="<?php echo "https://speciatheme.com/proficient-premium-wordpress-theme/"; ?>" class="promo-btn btn-green" target="_blank"><i class="dashicons dashicons-cart info-icon"></i> <?php _e('View Details','specia'); ?></a>
										
										<a href="<?php echo "https://speciatheme.com/proficient-premium-wordpress-theme/"; ?>" class="promo-btn btn-red" target="_blank"><i class="dashicons dashicons-cart info-icon"></i> <?php _e('Buy Now','specia'); ?></a>
									</div>
								</div>
								
								<div class="span4">
									<img class="theme_screen" src="<?php echo get_template_directory_uri(); ?>/images/avira.png">
									
									<div class="promo-buttons">
										<a href="<?php echo "https://demo.speciatheme.com/pro/?theme=avira"; ?>" class="promo-btn btn-black" target="_blank"><i class="dashicons dashicons-desktop info-icon"></i> <?php _e('PRO Demo','specia'); ?></a>
										
										<a href="<?php echo "https://speciatheme.com/avira-premium-wordpress-theme/"; ?>" class="promo-btn btn-green" target="_blank"><i class="dashicons dashicons-cart info-icon"></i> <?php _e('View Details','specia'); ?></a>
										
										<a href="<?php echo "https://speciatheme.com/avira-premium-wordpress-theme/"; ?>" class="promo-btn btn-red" target="_blank"><i class="dashicons dashicons-cart info-icon"></i> <?php _e('Buy Now','specia'); ?></a>
									</div>
								</div>
								
								<div class="span4">
									<img class="theme_screen" src="<?php echo get_template_directory_uri(); ?>/images/heropress.png">
									
									<div class="promo-buttons">
										<a href="<?php echo "https://demo.speciatheme.com/pro/?theme=heropress"; ?>" class="promo-btn btn-black" target="_blank"><i class="dashicons dashicons-desktop info-icon"></i> <?php _e('PRO Demo','specia'); ?></a>
										
										<a href="<?php echo "https://speciatheme.com/heropress-premium/"; ?>" class="promo-btn btn-green" target="_blank"><i class="dashicons dashicons-cart info-icon"></i> <?php _e('View Details','specia'); ?></a>
										
										<a href="<?php echo "https://speciatheme.com/heropress-premium/"; ?>" class="promo-btn btn-red" target="_blank"><i class="dashicons dashicons-cart info-icon"></i> <?php _e('Buy Now','specia'); ?></a>
									</div>
								</div>
								
								<div class="span4">
									<img class="theme_screen" src="<?php echo get_template_directory_uri(); ?>/images/fabify.png">
									
									<div class="promo-buttons">
										<a href="<?php echo "https://demo.speciatheme.com/pro/?theme=fabify"; ?>" class="promo-btn btn-black" target="_blank"><i class="dashicons dashicons-desktop info-icon"></i> <?php _e('PRO Demo','specia'); ?></a>
										
										<a href="<?php echo "https://speciatheme.com/fabify-premium/"; ?>" class="promo-btn btn-green" target="_blank"><i class="dashicons dashicons-cart info-icon"></i> <?php _e('View Details','specia'); ?></a>
										
										<a href="<?php echo "https://speciatheme.com/fabify-premium/"; ?>" class="promo-btn btn-red" target="_blank"><i class="dashicons dashicons-cart info-icon"></i> <?php _e('Buy Now','specia'); ?></a>
									</div>
								</div>
								
								<div class="span4">
									<img class="theme_screen" src="<?php echo get_template_directory_uri(); ?>/images/magzee.png">
									
									<div class="promo-buttons">
										<a href="<?php echo "https://demo.speciatheme.com/pro/?theme=magzee"; ?>" class="promo-btn btn-black" target="_blank"><i class="dashicons dashicons-desktop info-icon"></i> <?php _e('PRO Demo','specia'); ?></a>
										
										<a href="<?php echo "https://speciatheme.com/magzee-premium/"; ?>" class="promo-btn btn-green" target="_blank"><i class="dashicons dashicons-cart info-icon"></i> <?php _e('View Details','specia'); ?></a>
										
										<a href="<?php echo "https://speciatheme.com/magzee-premium/"; ?>" class="promo-btn btn-red" target="_blank"><i class="dashicons dashicons-cart info-icon"></i> <?php _e('Buy Now','specia'); ?></a>
									</div>
								</div>
								
								<div class="span4">
									<img class="theme_screen" src="<?php echo get_template_directory_uri(); ?>/images/benzer.png">
									
									<div class="promo-buttons">
										<a href="<?php echo "https://demo.speciatheme.com/pro/?theme=benzer"; ?>" class="promo-btn btn-black" target="_blank"><i class="dashicons dashicons-desktop info-icon"></i> <?php _e('PRO Demo','specia'); ?></a>
										
										<a href="<?php echo "https://speciatheme.com/benzer-premium/"; ?>" class="promo-btn btn-green" target="_blank"><i class="dashicons dashicons-cart info-icon"></i> <?php _e('View Details','specia'); ?></a>
										
										<a href="<?php echo "https://speciatheme.com/benzer-premium/"; ?>" class="promo-btn btn-red" target="_blank"><i class="dashicons dashicons-cart info-icon"></i> <?php _e('Buy Now','specia'); ?></a>
									</div>
								</div>
								
							</div>
						</section>
						<!-- /Section One -->
						
					</div>

                </div>

            </div>
        </div><!-- wrap -->
    <?php
    }
}

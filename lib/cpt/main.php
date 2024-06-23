<?php
/**
 * Include custom post types here
 */
require_once( plugin_dir_path( __FILE__ ) . 'cpt-treatments.php' );
require_once( plugin_dir_path( __FILE__ ) . 'cpt-team_members.php' );
require_once( plugin_dir_path( __FILE__ ) . 'cpt-specials.php' );

$main_site = is_main_site();
if( $main_site ) :
  require_once( plugin_dir_path( __FILE__ ) . 'cpt-testimonials.php' );
endif;

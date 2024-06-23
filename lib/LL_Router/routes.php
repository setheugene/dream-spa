<?php


add_action('init', function() {
  $router = new LL_Router('lifted_logic');
  $routes = array(
    'component_preview' => LL_Route::default( 'component-preview', '', get_stylesheet_directory() . '/templates/component-preview.php' )
  );

  LL_RouteProcessor::init( $router, $routes );
}, 0 );

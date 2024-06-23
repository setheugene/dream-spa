<?php
/**
* Left Right Hero
* -----------------------------------------------------------------------------
*
* Left Right Hero component
*/

/**
 * Any additional classes to apply to the main component container.
 *
 * @var array
 * @see args['classes']
 */
$classes = ( isset( $component_args['classes'] ) ? $component_args['classes'] : array() );

/**
 * ID to apply to the main component container.
 *
 * @var array
 * @see args['id']
 */
$component_id   = ( isset( $component_args['id'] ) ? $component_args['id'] : false );
?>

<?php
$defaults = [
  'content' => '',
  'image' => null,
];

$component_data = ll_parse_args( $component_data, $defaults );

$image = $component_data['image'];
?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="left-right-hero py-12 lg:py-16 bg-brand-dark-teal relative <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="left-right-hero">
  <div class="absolute bottom-0 right-0 w-full pointer-events-none">
    <img class="w-screen lg:ml-auto lg:w-full" src="<?php echo get_template_directory_uri(); ?>/assets/img/left-right-hero-wave.svg" alt="background wave graphic">
  </div>
  <div class="container">
    <div class="items-center justify-center row">
      <div class="w-full mb-6 col lg:w-1/2 lg:mb-0">
        <div class="wysiwyg">
          <?php echo $component_data['content']; ?>
        </div>
      </div>
      <div class="w-full col lg:w-1/2">
        <div class="relative aspect-square">
          <?php
            ll_include_component(
              'fit-image',
              array(
                'image_id' => $image['image_id'],
                'thumbnail_size' => 'full',
                'position' => $image['image_focus_point'],
                'fit' =>  $image['image_fit'],
                'loading' => $image['image_loading']
              )
            );
          ?>
        </div>
      </div>
    </div>
  </div>
</section>

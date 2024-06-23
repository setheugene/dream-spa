<?php
/**
* Dual Image Content
* -----------------------------------------------------------------------------
*
* Dual Image Content component
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
  'left_image' => null,
  'right_image' => null,
  'content' => '',
];

$component_data = ll_parse_args( $component_data, $defaults );

$left_image = $component_data['left_image'];
$right_image = $component_data['right_image'];
?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="dual-image-content py-16 lg:py-20 bg-brand-off-white <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="dual-image-content">
  <div class="container">
    <div class="items-center row">
      <div class="w-full mb-8 col lg:w-4/12 lg:mb-0">
        <div class="relative aspect-3/4">
          <?php
            ll_include_component(
              'fit-image',
              array(
                'image_id' => $left_image['image_id'],
                'thumbnail_size' => 'full',
                'position' => $left_image['image_focus_point'],
                'fit' =>  $left_image['image_fit'],
                'loading' => $left_image['image_loading']
              )
            );
          ?>
        </div>
      </div>
      <div class="w-full mb-8 col lg:w-5/12 lg:mb-0">
        <div class="wysiwyg js-fade-group">
          <?php echo $component_data['content']; ?>
        </div>
      </div>
      <div class="w-full col lg:w-3/12">
        <div class="relative aspect-square">
          <?php
            ll_include_component(
              'fit-image',
              array(
                'image_id' => $right_image['image_id'],
                'thumbnail_size' => 'full',
                'position' => $right_image['image_focus_point'],
                'fit' =>  $right_image['image_fit'],
                'loading' => $right_image['image_loading']
              )
            );
          ?>
        </div>
      </div>
    </div>
  </div>
</section>

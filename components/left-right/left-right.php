<?php
/**
* Left Right
* -----------------------------------------------------------------------------
*
* Left Right component
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
  'content'           => '',
  'image_id'          => null,
  'image_focus_point' => null,
  'image_fit'         => null,
  'image_loading'     => null,
  'layout'            => 'content-image',
  'background_color'  => 'bg-brand-off-white',
];

$component_data = ll_parse_args( $component_data, $defaults );

/**
 * Content Column Classes
*/
$content_col_order = 'lg:order-1';
if ( $component_data['layout'] == 'image-content' ) {
  $content_col_order = 'lg:order-2';
}

/**
 * Image Column Classes
*/
$image_col_order = 'lg:order-1';
if ( $component_data['layout'] == 'content-image' ) {
  $image_col_order = 'lg:order-2';
}
?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="left-right relative py-12 lg:py-16 <?php echo $component_data['background_color']; ?> <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ) ?> data-component="left-right">

  <div class="container relative z-10">
    <div class="items-center row">
      <div class="col w-full order-2 lg:w-1/2 <?php echo $content_col_order; ?>">
        <div class="wysiwyg">
          <?php echo $component_data['content']; ?>
        </div>
      </div>

      <div class="col w-full order-1 mb-10 lg:mb-0 lg:w-1/2 <?php echo $image_col_order; ?>">
        <?php if ( $component_data['image_id'] != '' ) : ?>
          <div class="relative aspect-square">
            <?php
              ll_include_component(
                'fit-image',
                [
                  'image_id'            => $component_data['image_id'],
                  'thumbnail_size'      => 'large',
                  'position'            => $component_data['image_focus_point'],
                  'fit'                 => $component_data['image_fit'],
                  'loading'             => $component_data['image_loading'],
                ]
              );
            ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

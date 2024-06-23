<?php
/**
* Left Right Dual Image
* -----------------------------------------------------------------------------
*
* Left Right Dual Image component
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
  'background_color' => 'bg-brand-off-white',
  'content' => '',
  'large_image' => null,
  'small_image' => null,
  'layout' => 'image-content',
];

$component_data = ll_parse_args( $component_data, $defaults );

$large_image = $component_data['large_image'];
$small_image = $component_data['small_image'];
$layout = $component_data['layout'];

$content_layout_class = 'lg:order-2';
$media_layout_class = 'lg:order-1';
$small_image_position_class = "-right-[100px]";
$image_column_justify = "justify-start";
if( $layout === 'content-image' ) {
  $content_layout_class = 'lg:order-1';
  $media_layout_class = 'lg:order-2';
  $small_image_position_class = "-left-[100px]";
  $image_column_justify = "justify-end";
}
?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="left-right-dual-image py-12 lg:py-16 <?php echo $component_data['background_color']; ?> <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="left-right-dual-image">
  <div class="container">
    <div class="items-center row">
      <div class="w-full mb-8 col lg:w-1/2 lg:mb-0 order-1 <?php echo $media_layout_class; ?>">
        <div class="row <?php echo $image_column_justify; ?>">
          <div class="w-5/6 col">
            <?php if( $large_image ) : ?>
              <div class="relative aspect-3/4">
                <?php
                  ll_include_component(
                    'fit-image',
                    array(
                      'image_id' => $large_image['image_id'],
                      'thumbnail_size' => 'full',
                      'position' => $large_image['image_focus_point'],
                      'fit' =>  $large_image['image_fit'],
                      'loading' => $large_image['image_loading']
                    )
                  );
                ?>
                <?php if( $small_image ) : ?>
                  <div class="absolute md:h-[267px] bottom-10 h-[167px] w-[167px] md:w-[267px] aspect-square <?php echo $small_image_position_class; ?>">
                    <?php
                      ll_include_component(
                        'fit-image',
                        array(
                          'image_id' => $small_image['image_id'],
                          'thumbnail_size' => 'full',
                          'position' => $small_image['image_focus_point'],
                          'fit' =>  $small_image['image_fit'],
                          'loading' => $small_image['image_loading']
                        )
                      );
                    ?>
                  </div>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="w-full col lg:w-1/2 order-2 <?php echo $content_layout_class; ?>">
        <div class="wysiwyg js-fade-group">
          <?php echo $component_data['content']; ?>
        </div>
      </div>
    </div>
  </div>
</section>

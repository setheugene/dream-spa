<?php
/**
* Left Right with Call Out
* -----------------------------------------------------------------------------
*
* Left Right with Call Out component
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
  'image' => null,
  'content' => '',
  'call_out' => '',
];

$component_data = ll_parse_args( $component_data, $defaults );

$image = $component_data['image'];
?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="left-right-with-call-out py-16 lg:py-20 bg-brand-off-white <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="left-right-with-call-out">
  <div class="container">
    <div class="items-center justify-between row">
      <div class="order-2 w-full col lg:w-5/12 lg:order-1">
        <div class="wysiwyg">
          <?php echo $component_data['content']; ?>
        </div>
      </div>
      <div class="order-1 w-full mb-10 col lg:w-1/2 lg:order-2 lg:mb-0">
        <?php if( $image ) : ?>
          <div class="relative aspect-4/3">
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
        <?php endif; ?>
        <div class="relative z-10 -mt-8 lg:-ml-[100px] mx-auto w-10/12 lg:w-[369px] p-8 bg-white left-right-with-call-out__call-out">
          <p class="font-semibold text-center text-brand-teal paragraph-default lg:text-left">
            <?php echo $component_data['call_out']; ?>
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

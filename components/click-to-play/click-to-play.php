<?php
/**
* Click to Play
* -----------------------------------------------------------------------------
*
* Click to Play component
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
  'video_url' => '',
];

$image = $component_data['image'];
$video_url = $component_data['video_url'];

$component_data = ll_parse_args( $component_data, $defaults );
?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="click-to-play bg-brand-off-white py-16 lg:py-20 <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="click-to-play">
  <div class="container">
    <div class="items-center justify-between row">
      <div class="w-full mb-8 col lg:w-5/12 lg:mb-0 js-fade-group">
        <div class="wysiwyg">
          <?php echo $component_data['content']; ?>
        </div>
      </div>
      <div class="w-full col lg:w-1/2 js-fade">
        <?php if( $image['image_id'] ) : ?>
          <div class="relative aspect-16/9">
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
            <?php if ( isset( $video_url ) ) : ?>
              <button type="button" class="absolute inset-0 flex items-center justify-center w-full h-full group js-init-video bg-brand-teal-70" data-mfp-src="<?php echo $video_url; ?>">
                <div class="flex items-center justify-center w-16 h-16 duration-200 ease-in-out border rounded-full bg-brand-off-white bg-opacity-20 group-hover:bg-opacity-100 bg-blur border-brand-off-white">
                  <svg class="w-5 h-5 ml-1 duration-200 ease-in-out text-brand-off-white group-hover:text-brand-teal icon icon-play-loop"><use xlink:href="#icon-play-loop"></use></svg>
                </div>
                <span class="sr-only">Play video in popup</span>
              </button>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

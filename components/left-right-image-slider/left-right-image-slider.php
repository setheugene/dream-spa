<?php
/**
* Left Right Image Slider
* -----------------------------------------------------------------------------
*
* Left Right Image Slider component
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
  'images' => null,
];

$component_data = ll_parse_args( $component_data, $defaults );

$image_fields = $component_data['images'];
$images = [];

if( !empty($image_fields) ) :
  foreach ($image_fields as $key => $image) :
    $images[] = [
      'image_id' => $image['image']['image_id'] ?? '',
      'image_focus_point' => $image['image']['image_focus_point'] ?? '',
      'image_fit' => $image['image']['image_fit'] ?? '',
      'image_loading' => $image['image']['image_loading'] ?? '',
    ];
  endforeach;
endif;

?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="left-right-image-slider py-12 lg:py-16 <?php echo $component_data['background_color']; ?> <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="left-right-image-slider">
  <div class="container">
    <div class="justify-center row">
      <div class="w-full col xl:w-10/12">
        <div class="items-center row">
          <div class="w-full mb-10 col lg:w-1/2 lg:mb-0">
            <div class="wysiwyg">
              <?php echo $component_data['content']; ?>
            </div>
          </div>
          <div class="w-full col lg:w-1/2">
            <div class="left-right-image-slider__primary-slider">
              <?php if( !empty($images) ) : ?>
                <?php foreach( $images as $image ) : ?>
                  <div class="relative aspect-square left-right-image-slider__slide">
                    <?php
                      ll_include_component(
                        'fit-image',
                        array(
                          'image_id' => $image['image_id'],
                          'thumbnail_size' => 'large',
                          'position' => $image['image_focus_point'],
                          'fit' =>  $image['image_fit'],
                          'loading' => $image['image_loading']
                        )
                      );
                    ?>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
            <?php if( !empty($images) && count($images) > 1 ) : ?>
            <div class="relative w-full mt-5">
              <button aria-label="button to go to previous slide" role="button" class="absolute left-0 flex items-center justify-center w-10 h-10 mr-3 duration-200 ease-in-out -translate-y-1/2 border rounded-full top-1/2 aria-disabled:opacity-50 aria-disabled:pointer-events-none hover:bg-brand-teal group left-right-image-slider__prev border-brand-teal">
                <svg class='w-4 h-4 duration-200 ease-in-out icon group-hover:text-brand-off-white text-brand-teal icon-arrow-left'><use xlink:href='#icon-arrow-left'></use></svg>
              </button>
              <div class="w-7/12 mx-auto left-right-image-slider__nav-slider">
                <?php foreach( $images as $image ) : ?>
                  <div class="relative mx-[10px] aspect-square left-right-image-slider__nav-slide h-16 w-16">
                    <?php
                      ll_include_component(
                        'fit-image',
                        array(
                          'image_id' => $image['image_id'],
                          'thumbnail_size' => 'thumbnail',
                          'position' => $image['image_focus_point'],
                          'fit' => 'cover',
                          'loading' => $image['image_loading']
                        )
                      );
                    ?>
                  </div>
                <?php endforeach; ?>
              </div>
              <button aria-label="button to go to next slide" role="button" class="absolute right-0 flex items-center justify-center w-10 h-10 duration-200 ease-in-out -translate-y-1/2 border rounded-full top-1/2 aria-disabled:opacity-50 aria-disabled:pointer-events-none hover:bg-brand-teal group left-right-image-slider__next border-brand-teal">
                <svg class='w-4 h-4 duration-200 ease-in-out icon group-hover:text-brand-off-white text-brand-teal icon-arrow-right'><use xlink:href='#icon-arrow-right'></use></svg>
              </button>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

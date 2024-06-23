<?php
/**
* Video Slider
* -----------------------------------------------------------------------------
*
* Video Slider component
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
  'heading_content' => '',
  'videos' => null,
];

$component_data = ll_parse_args( $component_data, $defaults );

$videos_field = $component_data['videos'];
$videos = [];
if($videos_field) {
  foreach($videos_field as $video) {
    $videos[] = [
      'video_url' => $video['video_url'],
      'image' => $video['image'],
    ];
  }
}
$slider_active = false;
if(!empty( $videos ) && count( $videos ) > 2):
  $slider_active = true;
endif;
?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="video-slider bg-brand-off-white py-16 lg:py-20 <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="video-slider">
  <div class="container">
    <div class="flex flex-wrap mb-8">
      <div class="w-full mb-4 wysiwyg lg:mb-0 lg:w-8/12 js-fade">
        <?php echo $component_data['heading_content']; ?>
      </div>
      <div class="flex items-center justify-end w-full lg:w-4/12">
        <div class="video-slider__slider-nav relative flex w-full lg:justify-end lg:mb-0 <?php echo $slider_active ? 'flex' : 'hidden'; ?>">
          <button aria-label="button to go to previous slide" role="button" class="flex items-center justify-center w-10 h-10 mr-3 duration-200 ease-in-out border rounded-full aria-disabled:opacity-50 aria-disabled:pointer-events-none hover:bg-brand-teal group video-slider__prev border-brand-teal">
            <svg class='w-4 h-4 duration-200 ease-in-out icon group-hover:text-brand-off-white text-brand-teal icon-arrow-left'><use xlink:href='#icon-arrow-left'></use></svg>
          </button>
          <button aria-label="button to go to next slide" role="button" class="flex items-center justify-center w-10 h-10 duration-200 ease-in-out border rounded-full aria-disabled:opacity-50 aria-disabled:pointer-events-none hover:bg-brand-teal group video-slider__next border-brand-teal">
            <svg class='w-4 h-4 duration-200 ease-in-out icon group-hover:text-brand-off-white text-brand-teal icon-arrow-right'><use xlink:href='#icon-arrow-right'></use></svg>
          </button>
        </div>
      </div>
    </div>
    <?php if( !empty($videos) ) : ?>
      <div class="video-slider__slider <?php echo $slider_active ? '-mx-4' : 'row'; ?>">
        <?php foreach( $videos as $video ) : ?>
          <?php if( $video['image']['image_id'] ) : ?>
            <div class="<?php echo $slider_active ? 'mx-4' : 'col w-full lg:w-1/2'; ?>">
              <div class="relative aspect-16/9 video-slider__slide">
                <?php
                  ll_include_component(
                    'fit-image',
                    array(
                      'image_id' => $video['image']['image_id'],
                      'thumbnail_size' => 'full',
                      'position' => $video['image']['image_focus_point'],
                      'fit' =>  $video['image']['image_fit'],
                      'loading' => $video['image']['image_loading']
                    )
                  );
                ?>
                <?php if ( isset( $video['video_url'] ) ) : ?>
                  <button type="button" class="absolute inset-0 flex items-center justify-center w-full h-full group js-init-video bg-brand-teal-70" data-mfp-src="<?php echo $video['video_url']; ?>">
                    <div class="flex items-center justify-center w-16 h-16 duration-200 ease-in-out border rounded-full group-hover:bg-brand-off-white bg-brand-off-white-20 bg-blur border-brand-off-white">
                      <svg class="w-5 h-5 ml-1 duration-200 ease-in-out text-brand-off-white group-hover:text-brand-teal icon icon-play-loop"><use xlink:href="#icon-play-loop"></use></svg>
                    </div>
                    <span class="sr-only">Play video in popup</span>
                  </button>
                <?php endif; ?>
              </div>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php
/**
* Before and After Slider
* -----------------------------------------------------------------------------
*
* Before and After Slider component
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
];

$component_data = ll_parse_args( $component_data, $defaults );
$before_after_posts = $component_data['bag_ids'] ?? '';
?>

<?php if ( empty( $before_after_posts ) ) return; ?>
<section class="before-and-after-slider py-12 bg-brand-off-white lg:py-16 <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ) ?> data-component="before-and-after-slider">
  <div class='container relative z-30'>
    <div class='items-center justify-center row'>
      <div class='w-full col md:w-5/12 js-fade'>
        <?php if ( isset( $component_data['content'] ) ) : ?>
          <div class="relative">
            <div class="wysiwyg">
              <?php echo $component_data['content']; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>
      <div class="w-full mt-12 col md:w-7/12 md:mt-0 js-fade">
        <?php if ( !empty( $before_after_posts ) ) : ?>
          <div class="pb-6 before-after-slider-outer">
            <?php foreach( $before_after_posts as $ba_post ) : ?>
              <?php $image_count = 0; ?>
              <?php switch_to_blog( get_main_site_id() ); ?>
              <!-- GRABS NECCESSARY POST DATA FOR THE FIRST IMAGE IN EACH POST -->
              <?php foreach( get_field('bag_single_photos_and_videos', $ba_post) as $item ) : ?>
                <?php
                  $image_count++;
                  $content_type       = $item['bag_single_content_type'];
                  $single_image       = $item['bag_single_single_image'];
                  $two_images_first   = $item['bag_single_two_images_first'];
                  $two_images_second  = $item['bag_single_two_images_second'];
                  $show_tags          = $item['bag_before_and_after_tags'];
                  $image_orientation  = $item['bag_single_image_orientation'];
                  $display_style      = $item['bag_single_display_style'];
                  $image_title        = $item['bag_image_title'];
                  $image_description  = $item['bag_image_description'];
                  $video_still        = $item['bag_single_video_still_image'];
                  $video_url          = $item['bag_single_video_url'];
                ?>

                <!-- IF FIRST IMAGE IN POSTS HAS ONE IMAGE -->
                <?php if ( $content_type === "one" && $image_count === 1 ) : ?>
                  <div class="slide-wrapper">
                    <div class="relative w-full rounded-b-lg bag_single-image-slide">
                      <img src="<?php echo esc_url($single_image['url']); ?>" alt="<?php echo esc_attr($single_image['alt']); ?>" />

                      <div class="bg-white rounded-b-lg bag_slide-details text-brand-navy">
                        <?php if ( $image_title ) : ?>
                          <div class="px-4 pt-3 font-semibold paragraph-default">
                            <?php echo $image_title; ?>
                          </div>
                        <?php endif; ?>

                        <?php if ( $image_description ) : ?>
                          <div class="paragraph-small text-brand-gray pb-3 px-4 <?php if ( !$image_title ) : echo 'pt-3'; endif; ?>">
                            <?php echo $image_description; ?>
                          </div>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                <!-- IF FIRST IMAGE IN POST HAS TWO IMAGES -->
                <?php elseif ( $content_type === "two" && $image_count === 1) : ?>
                  <div class="overflow-hidden rounded-lg slide-wrapper">
                    <div class="bg-white rounded-lg bag_double-image-slide">
                      <div class="flex relative <?php echo $image_orientation === 'horizontal' ? 'flex-col bag_horizontal-tags': 'bag_vertical-tags' ;  ?> <?php echo $show_tags === true ? 'bag_tags-active': '' ;  ?>">
                        <img class="<?php echo $image_orientation === 'horizontal' ? 'w-full h-1/2 mb-1' : 'w-1/2 h-full mr-1' ; ?>" src="<?php echo esc_url($two_images_first['url']); ?>" alt="<?php echo esc_attr($two_images_first['alt']); ?>" />

                        <img class="<?php echo $image_orientation === 'horizontal' ? 'w-full h-1/2' : 'w-1/2 h-full' ; ?>" src="<?php echo esc_url($two_images_second['url']); ?>" alt="<?php echo esc_attr($two_images_second['alt']); ?>" />
                      </div>

                      <div class="rounded-b-lg bag_slide-details">
                        <?php if( $image_title ) : ?>
                          <div class="px-4 pt-3 font-bold bag_slide-details_title text-brand-midnight">
                            <?php  echo $image_title; ?>
                          </div>
                        <?php endif; ?>

                        <?php if( $image_description ) : ?>
                          <div class="bag_slide-details_description text-sm pb-3 px-4 text-brand-dark-gray <?php if ( !$image_title ) : echo 'pt-3'; endif; ?>">
                            <?php echo $image_description; ?>
                          </div>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                <?php endif; ?>
              <?php endforeach; ?>
              <?php restore_current_blog(); ?>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <div class="relative flex justify-between before-after-nav-wrapper"></div>
      </div>
    </div>
  </div>
</section>

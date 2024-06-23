<?php
/**
* Testimonial Slider
* -----------------------------------------------------------------------------
*
* Testimonial Slider component
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
  'testimonial_ids' => null,
];

$component_data = ll_parse_args( $component_data, $defaults );

$featured_testimonials = $component_data['testimonial_ids'];
switch_to_blog( get_main_site_id() );
if( !empty($featured_testimonials) ) {
  $args = array(
    'post_type'       => 'll_testimonials',
    'post_status'     => 'publish',
    'orderby'         => 'date',
    'order'           => 'DESC',
    'field'           => 'ids',
    'orderby'         => 'post__in',
    'post__in'        => $featured_testimonials,
  );
}else{
  $args = array(
    'post_type'       => 'll_testimonials',
    'post_status'     => 'publish',
    'orderby'         => 'date',
    'order'           => 'DESC',
    'posts_per_page'  => 6,
    'field'           => 'ids'
  );
}

$testimonial_posts_data = get_posts( $args );

$testimonial_posts = [];

if(!empty($testimonial_posts_data)) :
  foreach($testimonial_posts_data as $testimonial_post ) :
    $testimonial_post_id = $testimonial_post->ID;
    $testimonial_posts[] = [
      'title' => get_field('testimonial_title', $testimonial_post_id) ?? '',
      'quote_excerpt' => get_field('testimonial_quote_excerpt', $testimonial_post_id) ?? '',
      'full_quote' => get_field('testimonial_full_quote', $testimonial_post_id) ?? '',
      'author' => get_field('testimonial_author', $testimonial_post_id) ?? '',
    ];
  endforeach;
endif;
restore_current_blog();
$slider_active = false;
if(!empty( $testimonial_posts ) && count( $testimonial_posts ) > 3):
  $slider_active = true;
endif;
?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="testimonial-slider bg-brand-off-white py-16 lg:py-20 <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="testimonial-slider">
  <div class="container">
    <div class="flex flex-wrap mb-8">
      <div class="w-full mb-4 wysiwyg lg:mb-0 lg:w-8/12 js-fade">
        <?php echo $component_data['content']; ?>
      </div>
      <div class="flex items-center justify-end w-full lg:w-4/12">
        <div class="testimonial-slider__slider-nav relative flex w-full lg:justify-end lg:mb-0 <?php echo $slider_active ? 'flex' : 'hidden'; ?>">
          <button aria-label="button to go to previous slide" role="button" class="flex items-center justify-center w-10 h-10 mr-3 duration-200 ease-in-out border rounded-full aria-disabled:opacity-50 aria-disabled:pointer-events-none hover:bg-brand-teal group testimonial-slider__prev border-brand-teal">
            <svg class='w-4 h-4 duration-200 ease-in-out icon group-hover:text-brand-off-white text-brand-teal icon-arrow-left'><use xlink:href='#icon-arrow-left'></use></svg>
          </button>
          <button aria-label="button to go to next slide" role="button" class="flex items-center justify-center w-10 h-10 duration-200 ease-in-out border rounded-full aria-disabled:opacity-50 aria-disabled:pointer-events-none hover:bg-brand-teal group testimonial-slider__next border-brand-teal">
            <svg class='w-4 h-4 duration-200 ease-in-out icon group-hover:text-brand-off-white text-brand-teal icon-arrow-right'><use xlink:href='#icon-arrow-right'></use></svg>
          </button>
        </div>
      </div>
    </div>
    <div class="testimonial-slider__slider <?php echo $slider_active ? '-mx-4' : 'grid grid-cols-1 lg:grid-cols-3 gap-8'; ?>">
      <?php foreach( $testimonial_posts as $key => $testimonial_post ) : ?>
        <?php
          $full_quote_active = false;
          if($testimonial_post['full_quote'] != '') :
            $full_quote_active = true;
          endif;
        ?>
        <div class="<?php echo $slider_active ? 'testimonial-slider__slide mx-4' : ''; ?>">
          <div class="flex flex-col justify-between h-full">
            <div>
              <p class="mb-5 font-medium paragraph-default text-brand-teal">
                <?php echo $testimonial_post['title']; ?>
              </p>
              <p class="text-brand-gray paragraph-default">
                <?php echo $testimonial_post['quote_excerpt']; ?>
                <?php if( $full_quote_active ) : ?>
                  <span class="inline-block mr-1 -ml-1">...</span>
                  <button class="inline-block underline text-brand-teal js-init-popup" data-modal="#testimonial-popup-<?php echo $key; ?>" data-component="modal">Read More <span class="sr-only">of this testimonial from <?php echo $testimonial_post['author']; ?></span></button>
                <?php endif; ?>
              </p>
            </div>
            <div>
              <hr class="my-8 border-brand-storm">
              <p class="text-brand-gray paragraph-small">
                -<?php echo $testimonial_post['author']; ?>
              </p>
            </div>
          </div>
          <?php if( $full_quote_active ) : ?>
            <div id="testimonial-popup-<?php echo $key; ?>" class="mfp-hide dream-spa__modal">
              <div class="flex flex-col justify-between h-full">
                <div>
                  <p class="mb-5 font-medium paragraph-default text-brand-teal">
                    <?php echo $testimonial_post['title']; ?>
                  </p>
                  <p class="text-brand-gray paragraph-default">
                    <?php echo $testimonial_post['full_quote']; ?>
                  </p>
                </div>
                <div>
                  <hr class="my-8 border-brand-storm">
                  <p class="text-brand-gray paragraph-small">
                    -<?php echo $testimonial_post['author']; ?>
                  </p>
                </div>
              </div>
            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

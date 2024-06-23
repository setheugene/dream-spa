<?php
/**
* Specials Grid
* -----------------------------------------------------------------------------
*
* Specials Grid component
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

$current_date = date('Y-m-d');
// $posts_per_page = get_option('posts_per_page');
// $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

$args = [
  'post_type'       => 'll_specials',
  'post_status'     => 'publish',
  // 'numberposts'    => $posts_per_page,
  // 'offset'         => ( $paged - 1 ) * $posts_per_page,
  // 'posts_per_page'  => get_option('posts_per_page'),
  'posts_per_page'  => -1,
  'meta_key'       => 'special_start_date',
  'orderby'        => 'meta_value',
  'order'          => 'ASC',
  'meta_type'      => 'DATE',
  'meta_query'     => array(
      array(
          'key'     => 'special_end_date',
          'value'   => $current_date,
          'compare' => '>',
          'type'    => 'DATE',
      ),
  ),
];
$specials = get_posts($args);
?>

<section class="specials-grid bg-brand-off-white <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="specials-grid">
  <div class="container">
    <?php if ( !ll_empty( $specials ) ) : ?>
      <div class="grid grid-cols-1 gap-8 pb-8 md:grid-cols-2 lg:grid-cols-3">
        <?php if( !empty($specials) ) : ?>
          <?php foreach( $specials as $special ) : ?>
            <article class="">
              <?php
                $special_id = $special->ID;

                $special_locations = get_field( 'special_locations_site_ids', $special_id ) ?? '';
                $special_start_date = get_field('special_start_date', $special_id) ?? '';
                $special_start_time = get_field('special_start_time', $special_id) ?? '';
                $special_end_date = get_field('special_end_date', $special_id) ?? '';
                $special_end_time = get_field('special_end_time', $special_id) ?? '';
                $excerpt = get_the_excerpt( $special_id ) ?? '';

                $start_date = date_create($special_start_date);
                $start_date_timestamp = date_timestamp_get($start_date);
                $start_day_of_week = date('l', $start_date_timestamp);

                $end_date = date_create($special_end_date);
                $end_date_timestamp = date_timestamp_get($end_date);
                $end_day_of_week = date('l', $end_date_timestamp);

                $full_event_date = $special_start_date;
                if( $special_end_date != '' ) {
                  $full_event_date = '<div class="flex"><span class="block">' . $special_start_date . ' - ' . $special_end_date .'</span></div>';
                }

                $full_event_time = $special_start_time . ' - ' . $special_end_time;
              ?>
              <a class="post__card" href="<?php echo get_permalink($special_id) ?>" title="Read more about <?php echo get_the_title($special_id); ?>">
                <div class="relative overflow-hidden post__image-wrapper aspect-16/9">
                  <?php
                    ll_include_component(
                      'fit-image',
                      array(
                        'image_id' => get_post_thumbnail_id($special_id),
                        'position' => 'object-center'
                      ),
                      array(
                        'classes' => ['post__image']
                      )
                    );
                  ?>
                </div>

                <div class="flex flex-col pb-5 bg-white post__content">
                  <div class="flex mb-5 post__meta paragraph-small px-5 text-brand-teal py-[6px] bg-brand-teal bg-opacity-10">
                    <?php echo $full_event_date; ?>
                    <?php //if( $full_event_time != ' - ') : ?>
                      <!-- <div class="mx-2">|</div> -->
                      <?php //echo $full_event_time; ?>
                    <?php //endif; ?>
                  </div>
                  <div class="px-5">
                    <h2 class="mb-2 hdg-5 text-brand-navy post__title"><?php echo get_the_title( $special_id ); ?></h2>
                    <p class="mb-5 text-brand-gray paragraph-small">
                      <?php echo $excerpt; ?>
                    </p>
                    <?php
                      if (!empty($special_locations)) { ?>
                        <div class="flex flex-wrap gap-2">
                        <?php
                        foreach ($special_locations as $key => $location) {
                          $current_blog_details = get_blog_details( array( 'blog_id' => $location ) );
                          $blog_name = $current_blog_details->blogname ?? '';
                          ?>
                            <div class="special-grid__card-location-pill w-fit py-1 pr-3 pl-[10px] paragraph-small rounded-full text-brand-teal items-center flex bg-brand-off-white">
                              <svg class='icon h-4 w-4 mr-[9px] text-brand-teal icon-Location'><use xlink:href='#icon-Location'></use></svg>
                              <?php echo $blog_name; ?>
                            </div>
                          <?php
                        }
                        ?>
                        </div>
                        <?php
                      }
                    ?>
                  </div>
                </div>

                <div class="flex items-center justify-between px-5 py-3 duration-300 ease-in-out text-brand-off-white post__read-more-wrapper bg-brand-teal">
                  <span class="post__read-more">Learn More</span>
                  <svg class='flex-shrink-0 w-5 h-5 icon text-brand-off-white icon-arrow-right-long'><use xlink:href='#icon-arrow-right-long'></use></svg>
                </div>
              </a>
            </article>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    <?php else: ?>
      <div class="text-center paragraph-default text-brand-medium-gray h-[50vh]">
        There are no upcoming events at this time. Please check again soon!
      </div>
    <?php endif; ?>
  </div>
</section>

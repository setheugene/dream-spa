<?php
/**
* Featured Posts
* -----------------------------------------------------------------------------
*
* Featured Posts component
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
  'posts' => null,
  'options' => 'all',
];

$component_data = ll_parse_args( $component_data, $defaults );

$options = $component_data['options'];

$featured_posts = $component_data['post_ids'];
$category = $component_data['category_ids'];

if( $featured_posts && $options === 'manual' ) {
  $args = array(
    'post_type'       => 'post',
    'post_status'     => 'publish',
    'orderby'         => 'date',
    'order'           => 'DESC',
    'field'           => 'ids',
    'orderby'         => 'post__in',
    'post__in'        => $featured_posts,
  );
} elseif($options === 'category') {
  $args = array(
    'post_type'       => 'post',
    'post_status'     => 'publish',
    'orderby'         => 'date',
    'order'           => 'DESC',
    'category'        => $category,
    'posts_per_page'  => 6,
    'field'           => 'ids'
  );
}else{
  $args = array(
    'post_type'       => 'post',
    'post_status'     => 'publish',
    'orderby'         => 'date',
    'order'           => 'DESC',
    'posts_per_page'  => 6,
    'field'           => 'ids'
  );
}


$main_site = is_main_site();
$main_site_id = get_main_site_id();

$blog_post_data = [];
if( !$main_site ) :
  switch_to_blog($main_site_id);
endif;
$blog_posts = get_posts( $args );
foreach ($blog_posts as $key => $blog_post) {
  $blog_id = $blog_post->ID;
  $blog_post_data[] = [
    'blog_id' => $blog_post->ID ?? '',
    'cats' => get_the_terms( $blog_id, 'category' ) ?? '',
    'permalink' => get_the_permalink( $blog_id ) ?? '',
    'title' => get_the_title( $blog_id ) ?? '',
    'date' => get_the_date( '', $blog_id ) ?? '',
    'featured_image' => wp_get_attachment_image( get_post_thumbnail_id($blog_id), 'large', "", array( "class" => "" ) ),
  ];
}
if( !$main_site ) :
  restore_current_blog();
endif;
// var_dump($blog_post_data);
$slider_active = false;
if(!empty( $blog_posts ) && count( $blog_posts ) > 3):
  $slider_active = true;
endif;
?>

<?php if ( ll_empty( $component_data ) ) return; ?>
<section class="featured-posts bg-brand-off-white py-16 lg:py-20 <?php echo implode( " ", $classes ); ?>" <?php echo ( $component_id ? 'id="'.$component_id.'"' : '' ); ?> data-component="featured-posts">
  <div class="container">
    <div class="flex flex-wrap mb-8">
      <div class="w-full mb-4 wysiwyg lg:mb-0 lg:w-8/12 js-fade">
        <?php echo $component_data['content']; ?>
      </div>
      <div class="flex items-center justify-end w-full lg:w-4/12">
        <div class="featured-posts__slider-nav relative flex w-full lg:justify-end lg:mb-0 <?php echo $slider_active ? 'flex' : 'hidden'; ?>">
          <button aria-label="button to go to previous slide" role="button" class="flex items-center justify-center w-10 h-10 mr-3 duration-200 ease-in-out border rounded-full aria-disabled:opacity-50 aria-disabled:pointer-events-none hover:bg-brand-teal group featured-posts__prev border-brand-teal">
            <svg class='w-4 h-4 duration-200 ease-in-out icon group-hover:text-brand-off-white text-brand-teal icon-arrow-left'><use xlink:href='#icon-arrow-left'></use></svg>
          </button>
          <button aria-label="button to go to next slide" role="button" class="flex items-center justify-center w-10 h-10 duration-200 ease-in-out border rounded-full aria-disabled:opacity-50 aria-disabled:pointer-events-none hover:bg-brand-teal group featured-posts__next border-brand-teal">
            <svg class='w-4 h-4 duration-200 ease-in-out icon group-hover:text-brand-off-white text-brand-teal icon-arrow-right'><use xlink:href='#icon-arrow-right'></use></svg>
          </button>
        </div>
      </div>
    </div>
    <div class="featured-posts__slider <?php echo $slider_active ? '-mx-4' : 'grid grid-cols-1 lg:grid-cols-3 gap-8'; ?>">
      <?php foreach( $blog_post_data as $blog_post ) : ?>
        <article class="<?php echo $slider_active ? 'featured-posts__slide mx-4' : ''; ?>">
          <?php
            $cats = $blog_post['cats'];
          ?>
          <a class="post__card" href="<?php echo $blog_post['permalink']; ?>" title="Read more about <?php  echo $blog_post['title']; ?>">
            <div class="relative overflow-hidden post__image-wrapper aspect-3/2">
              <div class="fit-image">
                <?php echo $blog_post['featured_image']; ?>
              </div>
            </div>

            <div class="flex flex-col p-5 bg-white post__content">
              <p class="flex items-center justify-between mb-5 post__meta">
                <?php if ( !empty($cats[0]) ) : ?>
                  <span class="font-semibold text-brand-teal paragraph-small post-category"><?php echo $cats[0]->name; ?></span>
                <?php endif; ?>
                <span class="text-right paragraph-small text-brand-gray">
                  <?php echo $blog_post['date']; ?>
                </span>
              </p>

              <h2 class="paragraph-large text-brand-navy post__title"><?php echo $blog_post['title']; ?></h2>
            </div>

            <div class="flex items-center justify-between px-5 py-3 duration-300 ease-in-out text-brand-off-white post__read-more-wrapper bg-brand-teal">
              <span class="post__read-more">Learn More</span>
              <svg class='flex-shrink-0 w-5 h-5 icon text-brand-off-white icon-arrow-right-long'><use xlink:href='#icon-arrow-right-long'></use></svg>
            </div>
          </a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php
$back_link = '<a href="'.get_permalink(get_option('page_for_posts')).'">Back to Blog</a>';

$post_categories = get_the_terms( get_the_ID(), 'category' );
$post_tags = get_the_terms( get_the_ID(), 'post_tag' );

$args = array(
  'post_type'       => 'post',
  'post_status'     => 'publish',
  'orderby'         => 'menu_order',
  'order'           => 'ASC',
  'posts_per_page'  => 2,
  'post__not_in' => [ get_the_ID() ],
  'tax_query'       => [
    [
      'taxonomy'      => 'category',
      'field'         => 'term_id',
      'terms'         => get_queried_object_id(),
      'operator'       => '='
    ]
  ]
);

$related_posts = new WP_Query( $args );
?>

<div class="py-12 lg:py-5 blog-page bg-brand-off-white blog-page--single" data-component="blog">
  <div class="container">

    <?php if ( function_exists('yoast_breadcrumb') ) : ?>
      <div class="relative z-10 flex items-center w-full mb-5 text-brand-gray paragraph-small">
        <?php yoast_breadcrumb(); ?>
      </div>
    <?php endif; ?>

    <div class="blog__columns">

      <div class="blog__sidebar">
        <?php get_template_part('templates/partials/blog-sidebar'); ?>
      </div>

      <div class="blog__post lg:col-span-2">

        <article <?php post_class(); ?>>
          <div class="single-post__headings">
            <?php
              $small_heading = get_field( 'post_small_heading' );
              $heading_tag = (empty($small_heading['tag']) || $small_heading['tag'] !== 'h1') ? 'h1' : 'h2';
            ?>

            <?php if ( ! empty($small_heading['text']) ) : ?>
              <<?php echo $small_heading['tag']; ?> class="mb-5 hdg-6"><?php echo $small_heading['text']; ?></<?php echo $small_heading['tag']; ?>>
            <?php endif; ?>


            <<?php echo $heading_tag; ?> class="hdg-2 text-brand-navy">
            <?php echo get_the_title(); ?>
            </<?php echo $heading_tag; ?>>
          </div>

          <div class="flex justify-center mt-3 mb-5">
            <p><?php echo get_the_date(); ?></p>
          </div>

          <div class="post">
            <?php if ( get_post_thumbnail_id() ) : ?>
              <div class="relative mb-12 aspect-3/2">
                <?php
                  ll_include_component(
                    'fit-image',
                    array(
                      'image_id' => get_post_thumbnail_id(),
                      'position' => 'object-center'
                    ),
                    array(

                    )
                  );
                ?>
              </div>
            <?php endif; ?>

            <div class="wysiwyg">
              <?php the_content(); ?>
            </div>
          </div>
        </article>
      </div>
    </div>


  </div>
</div>


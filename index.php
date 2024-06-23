<?php
$blog_headings = get_field( 'blog_headings', get_option('page_for_posts') );
$featured_post = get_field( 'blog_featured_post', get_option('page_for_posts') );
?>
<div class="py-12 lg:py-5 blog-page bg-brand-off-white">
  <div class="container">
    <?php if ( isset($blog_headings['small_heading']['text']) || isset($blog_headings['large_heading']['text']) ) : ?>
      <div class="blog__headings js-fade-group">
        <?php if ( isset($blog_headings['small_heading']['text']) ) : ?>
          <<?php echo $blog_headings['small_heading']['tag']; ?> class="text-center hdg-6"><?php echo $blog_headings['small_heading']['text']; ?></<?php echo $blog_headings['small_heading']['tag']; ?>>
        <?php endif; ?>

        <?php if ( isset($blog_headings['large_heading']['text']) ) : ?>
          <<?php echo $blog_headings['large_heading']['tag']; ?> class="mb-8 text-center hdg-1"><?php echo $blog_headings['large_heading']['text']; ?></<?php echo $blog_headings['large_heading']['tag']; ?>>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <div class="blog__columns">

      <div class="blog__sidebar">
        <?php get_template_part('templates/partials/blog-sidebar'); ?>
      </div>


      <div class="blog__posts lg:col-span-2">
        <?php if (!have_posts()) : ?>
          <div class="alert alert-warning">
            <?php _e('Sorry, no results were found.', 'roots'); ?>
          </div>
          <?php get_search_form(); ?>
        <?php endif; ?>

        <?php if ( $featured_post && (!is_category() && !is_tag()) ) : ?>
          <div class="mb-10 blog__featured-post">
            <?php
              ll_include_component(
                'content',
                array(
                  'post' => $featured_post
                ),
                array(
                  'classes' => ['featured-post']
                )
              );
            ?>
          </div>
        <?php endif; ?>

        <div class="grid gap-y-12 lg:grid-cols-2 gap-x-gutter-full blog__posts-grid">
          <?php while (have_posts()) : the_post(); ?>
            <?php get_template_part('templates/contents/content'); ?>
          <?php endwhile; ?>
        </div>

        <?php if ($wp_query->max_num_pages > 1) : ?>
          <nav class="blog__pagination">
            <?php
            add_filter( 'number_format_i18n', 'give_numbers_leading_zero' );
              echo paginate_links( array(
                'format'  => 'page/%#%',
                'current' => max( 1, get_query_var('paged') ),
                'total'   => $wp_query->max_num_pages,
                'mid_size'        => 5,
                'prev_text'       => __('<svg class="w-4 h-4 text-brand-teal icon icon-chevron-left mr-[68px]"><use xlink:href="#icon-chevron-left"></use></svg>'),
                'next_text'       => __('<svg class="w-4 h-4 text-brand-teal icon icon-chevron-right ml-[68px]"><use xlink:href="#icon-chevron-right"></use></svg>')
              ) );
            ?>
          </nav>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
